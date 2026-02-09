<?php
/* Local Database*/

$servername = "localhost";
$username = "saasthemes_hotel";
$password = "1000Dollar";
$dbname = "saasthemes_hotel";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}  ?>
