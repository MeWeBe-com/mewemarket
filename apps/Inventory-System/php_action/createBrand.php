<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());
$company_id = $_SESSION['company_id'];
if($_POST) {	

	$brandName = $_POST['brandName'];

	$sql = "INSERT INTO brands (company_id,brand_name, brand_active, brand_status) VALUES ('$company_id','$brandName', 1, 1)";

	if($connect->query($sql) === TRUE) {
        header('location: https://www.mewemarket.com/apps/Inventory-System/brand.php');
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the brand.";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
}
