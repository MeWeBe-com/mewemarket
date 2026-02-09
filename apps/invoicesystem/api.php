<?php

include 'Invoice.php';
$invoice = new Invoice();

header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

$input_data = json_decode(trim(file_get_contents('php://input')));

$lastInsertId = $invoice->register_user($input_data);

if(isset($lastInsertId)){
	$data = [
		'status' => True,
		'message' => 'Company Added Successfully',
		'url' => 'https://www.mewemarket.com/apps/invoicesystem/',
	];
	echo json_encode($data);
}else {
	$data = [
		'status' => False,
		'message' => 'Something Wrong',
	];
	echo json_encode($data);
}

