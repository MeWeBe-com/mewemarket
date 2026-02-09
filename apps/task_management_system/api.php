<?php

include 'db_connect.php';
    

header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

$input_data = json_decode(trim(file_get_contents('php://input')));
$pass = md5($input_data->password);

$save = $conn->query("INSERT INTO companies(`company_name`)VALUES('".$input_data->company_name."')");
$company_id = $conn->insert_id;

$saved = $conn->query("INSERT INTO users (`company_id`, `firstname`, `lastname`, `email`, `password`, `type`) VALUES ('".$company_id."','".$input_data->first_name."','".$input_data->last_name."','".$input_data->email."','".$pass."','1')");
$lastInsertId = $conn->insert_id;
if(isset($lastInsertId)){
	$data = [
		'status' => True,
		'message' => 'Company Added Sucncessfully',
		'url' => 'https://www.mewemarket.com/apps/task_management_system/'.$input_data->company_name,
	];
	echo json_encode($data);
}else {
	$data = [
		'status' => False,
		'message' => 'Something Wrong',
	];
	echo json_encode($data);
}

