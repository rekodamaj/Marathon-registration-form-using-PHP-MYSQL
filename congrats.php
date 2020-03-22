<?php 
require_once "header.php"; 

// make sure there is an id in the GET
if (!isset($_GET['id'])) {
	die();
} else {
	// get the id
	$id = mysqli_real_escape_string($mysqli, base64_decode( $_GET['id'] ) );
	$raceNumber = 0;
	$sql = "SELECT * FROM users WHERE bib = '$id'";
	$res = mysqli_query($mysqli, $sql);
	
	// make sure that the id is exisrs in our db
	if (mysqli_num_rows($res) > 0) {
		$res = mysqli_fetch_assoc($res);
		$raceNumber = $res['race_number'];
	} else {
		die();
	}

}

?>

<div class="row justify-content-center align-content-center h-100">
	<div class="col-6 text-center">
		<h2>
			Congratulations:
		</h2>
		<h4>
			Your race number is <?= $raceNumber; ?>
		</h4>
		<br>
		<button class="btn btn-primary" onclick="window.location.href = './index.php' ">
			<i class="far fa-hand-point-left"></i>
			Back to the form
		</button>
	</div>
</div>




<?php require_once "footer.php"; ?>