<?php

$localhost = "localhost";
$username = "saasthemes_inventory";
$password = "1000Dollar";
$dbname = "saasthemes_inventory";

$connect = new mysqli($localhost, $username, $password, $dbname);

if($connect->connect_error) {
	die("Connection Failed : " . $connect->connect_error);
} else {
}

?>
