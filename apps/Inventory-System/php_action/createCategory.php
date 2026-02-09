<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());
$company_id = $_SESSION['company_id'];
if($_POST) {	

	$categoryName = $_POST['categoryName'];

	$sql = "INSERT INTO category (company_id,category_name, category_active, category_status) VALUES ('$company_id','$categoryName', 1, 1)";

	if($connect->query($sql) === TRUE) {
	 	

			header('location: https://www.mewemarket.com/apps/Inventory-System/category.php');



	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the category.";
	}
	 

	$connect->close();

	echo json_encode($valid);
 
}
