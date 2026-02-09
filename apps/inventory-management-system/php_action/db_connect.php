<?php 	

$localhost = "localhost";
$username = "saasthemes_inventory_store";
$password = "1000Dollar";
$dbname = "saasthemes_inventory_store";
$store_url = "https://www.mewemarket.com/apps/inventory-management-system/";
// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}

?>