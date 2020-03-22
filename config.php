<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "registeration_form";
$mysqli = mysqli_connect($hostname, $username, $password, $database);

mysqli_set_charset($mysqli, "utf8");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} 
 ?>
