<?php 
require_once "config.php";
// function selectFrom($tableName) {
// 	GLOBAL $mysqli;

// 	$resultsArr = array(); 

// 	$query = "SELECT * FROM ". $tableName;
// 	$result =  mysqli_query($mysqli, $query );
// 	if (!empty($result)) {
// 		$resultsArr = mysqli_fetch_all($result, MYSQLI_ASSOC);
// 	}

// 	return $resultsArr;
// }


function selectFrom($tableName) {
	GLOBAL $mysqli;

	$resultsArr = array(); 

	$query = "SELECT * FROM ". $tableName;
	$result =  mysqli_query($mysqli, $query );
	if (!empty($result)) {
		$resultsArr = mysqli_fetch_all($result, MYSQLI_ASSOC);
	}

	return $resultsArr;
}




?>
