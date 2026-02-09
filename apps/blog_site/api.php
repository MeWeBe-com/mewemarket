<?php

include 'connection/config.php';

header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

$input_data = json_decode(trim(file_get_contents('php://input')));

$ret="INSERT INTO company(`company_name`)VALUES('".$input_data->company_name."')";
$company_id = mysqlInsert($ret);

$rettt="INSERT INTO general (`company_id`, `home_summary`,`logo`,`color`) VALUES ('".$company_id."','".$input_data->company_name."','logo.png','#18479e')";
$lastInsertId = mysqlInsert($rettt);

$rett="INSERT INTO admin (`company_id`, `name`,`email`, `password`) VALUES ('".$company_id."','".$input_data->first_name."','".$input_data->email."','".$input_data->password."')";
$lastInsertId = mysqlInsert($rett);

if(isset($lastInsertId)){
	$data = [
		'status' => True,
		'message' => 'Company Added Successfully',
		'url' => 'https://www.mewemarket.com/apps/blog_site/'.$input_data->company_name.'/p1',
	];
	echo json_encode($data);
}else {
	$data = [
		'status' => False,
		'message' => 'Something Wrong',
	];
	echo json_encode($data);
}

