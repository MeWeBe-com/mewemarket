<?php
ob_start();
require_once('includes/load.php');

header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

$input_data = json_decode(trim(file_get_contents('php://input')));

$sql  = "INSERT INTO company (";
$sql .= " company_name";
$sql .= ") VALUES (";
$sql .= "'{$input_data->company_name}'";
$sql .= ")";

if ($db->query($sql) === TRUE) {
    $last_id = $db->insert_id();
}

$password = sha1($input_data->password);

$sql = "INSERT INTO `users`(`company_id`, `name`, `username`, `password`, `user_level`, `status`) VALUES 
                          ('".$last_id."','".$input_data->first_name.' '.$input_data->last_name."','".$input_data->first_name."'
                          ,'".$password."','1','1')";

if($db->query($sql) === TRUE){
	$data = [
		'status' => True,
		'message' => 'Company Added Successfully',
		'url' => 'https://www.mewemarket.com/apps/wis/'.$input_data->company_name,
	];
	echo json_encode($data);
}else {
	$data = [
		'status' => False,
		'message' => 'Something Wrong',
	];
	echo json_encode($data);
}

