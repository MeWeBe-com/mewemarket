<?php

include 'dbconnection.php';

header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

$input_data = json_decode(trim(file_get_contents('php://input')));

$ret=mysqli_query($con,"INSERT INTO company(`company_name`)VALUES('".$input_data->company_name."')");
$company_id = mysqli_insert_id($con);

$rett=mysqli_query($con,"INSERT INTO admin (`company_id`, `name`, `password`) VALUES ('".$company_id."','".$input_data->first_name."','".$input_data->password."')");
$lastInsertId = (mysqli_insert_id($con));

if(isset($lastInsertId)){
	$data = [
		'status' => True,
		'message' => 'Company Added Successfully',
		'url' => 'https://www.mewemarket.com/apps/crmsystem/admin/index.php',
	];
	echo json_encode($data);
}else {
	$data = [
		'status' => False,
		'message' => 'Something Wrong',
	];
	echo json_encode($data);
}

