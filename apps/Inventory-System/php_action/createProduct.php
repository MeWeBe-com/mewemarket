<?php require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());
$company_id = $_SESSION['company_id'];
if($_POST) {	

	$productName = $_POST['productName'];
	$quantity = $_POST['quantity'];
	$rate = $_POST['rate'];
	$brand_id = $_POST['brandName'];
	$category_id = $_POST['categoryName'];

	$sql = "INSERT INTO product (company_id,product_name, quantity, rate, brand_id, category_id, active, status) VALUES ('$company_id','$productName', '$quantity', '$rate', '$brand_id', '$category_id', 1, 1)";

	if($connect->query($sql) === TRUE) {
		header('location: https://www.mewemarket.com/apps/Inventory-System/product.php');
	} else {
	 	echo "Failed!";
	}

	$connect->close();
	echo json_encode($valid);
}
