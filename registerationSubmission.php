<?php 
require_once "config.php";
require_once "functions.php";
require_once "Validation.php";

// check if there is a data in the post
if (isset($_POST)) {
	$raceNumber = 0;
	$obj = new stdClass();

	$fullName = mysqli_real_escape_string($mysqli, $_POST['fullName']);
	$dob = mysqli_real_escape_string($mysqli, $_POST['dob']);
	// Converting the date into MYSQL format
	$dob = date('Y-m-d', strtotime(str_replace('-', '/', $dob)));


	$category_id = mysqli_real_escape_string($mysqli, $_POST['category_id']);

	// Backend data validation
	$val = new Validation();
	$val->name('fullName')->value($fullName)->pattern('text')->required();
	$val->name('category_id')->value($category_id)->customPattern('[1-3]{1}')->required();
	$val->name('dob')->value($dob)->pattern('date_ymd')->required();
	if(!$val->isSuccess()){
		$obj->data = "Unexpected error. ";
		$obj->status = -100;
		$obj->value = 0;
		echo json_encode($obj);
		die();
		break;
	}




	

	// isUserExists
	$isUserExists = false;
	$sql = "SELECT * FROM users WHERE full_name = '$fullName'";
	$res = mysqli_query($mysqli, $sql);
	$num_rows = mysqli_num_rows($res);
	if ($num_rows > 0) {
		$isUserExists = true;

		$obj->data = "User already exists!";
		$obj->status = -100;
		$obj->value = 0;

		
	} else {
		// generate the race number by getting the last number in the cateogry + 1 and make sure that its in the range
		$str = "SELECT MAX(race_number)  AS lastRaceNumber FROM users WHERE category_id = '$category_id'";
		$res = mysqli_query($mysqli, $str);
		// print_r(mysqli_fetch_assoc($res));die();
		$lastRaceNumber = mysqli_fetch_assoc($res)['lastRaceNumber'];
		if ( is_null($lastRaceNumber) ) {
			 // If this is the first one in the cateogry

			switch ($category_id) {
				case '1':
					// for 10K
				$raceNumber = 0;
				break;
				case '2':
					// for 10K
				$raceNumber = 101;
				break;
				case '3':
					// for 10K
				$raceNumber = 201;
				break;
				
				default:
				$obj->data = "Unexpected error";
				$obj->status = -100;
				$obj->value = 0;
				echo json_encode($obj);
				die();
				break;
			}

		} else {
			// echo 1;die();
			$raceNumber = $lastRaceNumber + 1;
			
			if ( ($category_id == 1 && $raceNumber > 100) || ($category_id == 2 && $raceNumber > 200) || ($category_id == 3 && $raceNumber > 300)  ) {
				$obj->data = "Your desired category is full";
				$obj->status = -100;
				$obj->value = 0;
				echo json_encode($obj);
				die();
			}
		}

		// If exists, insert the user
		$sql = "INSERT INTO users (full_name, dob, category_id, race_number  ) VALUES ('".$fullName."', '".$dob."', '".$category_id."', '".$raceNumber."') ";
		if (mysqli_query($mysqli, $sql)) {
			$obj->data = "Success, registeration completed successfully!";
			$obj->status = 100;
			$obj->value = base64_encode(mysqli_insert_id($mysqli));;
		} else {
			$obj->data = "Unexpected error";
			$obj->status = -100;
			$obj->value = 0;
		}


	}

	// return for ajax request
	echo json_encode($obj);
	die();
}

?>