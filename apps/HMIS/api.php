<?php

include 'connection/config.php';

header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

$input_data = json_decode(trim(file_get_contents('php://input')));

$ret="INSERT INTO his_company(`company_name`)VALUES('".$input_data->company_name."')";
$company_id = mysqlInsert($ret);


echo $rett="INSERT INTO his_admin (`company_id`, `ad_fname`,`ad_lname`,`ad_email`, `ad_pwd`) VALUES ('".$company_id."','".$input_data->first_name."','".$input_data->last_name."','".$input_data->email."','".md5($input_data->password)."')";
$lastInsertId = mysqlInsert($rett);

if(isset($lastInsertId)){
	$data = [
		'status' => True,
		'message' => 'Company Added Successfully',
		'url' => 'https://www.mewemarket.com/apps/HMIS/'.$input_data->company_name,
	];
	echo json_encode($data);
}else {
	$data = [
		'status' => False,
		'message' => 'Something Wrong',
	];
	echo json_encode($data);
}

