<?php 	

require_once 'core.php';

$sql = "SELECT product_id, product_name FROM product WHERE status = 1 AND active = 1 and company_id = {$_SESSION['company_id']}";
$result = $connect->query($sql);

$data = $result->fetch_all();

$connect->close();

echo json_encode($data);