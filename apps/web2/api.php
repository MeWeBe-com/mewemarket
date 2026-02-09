<?php

include 'common.php';

header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

include PACKAGE_PATH . 'PasswordHash.php';
$phpass = new PasswordHash(8, false);

$input_data = json_decode(trim(file_get_contents('php://input')));

$query = "INSERT INTO " . $DBPrefix . "company
						(company_name,company_slug)
						VALUES
						(:company_name,:company_slug)";
$params = array(
	array(':company_name',$input_data->company_name, 'int'),
	array(':company_slug', $input_data->company_name, 'str'),
);

$db->query($query, $params);
$company_id = $db->lastInsertId();

// prepare to hash the password

$query = "INSERT INTO " . $DBPrefix . "adminusers
						(company_id,username,password,hash,created,lastlogin,status)
						VALUES
						('".$company_id."','".$input_data->email."', '".$phpass->HashPassword($input_data->password)."', 'xv74m', '".date('Ymd')."', '1612170952','1')";

/*
$query = "INSERT INTO " . $DBPrefix . "adminusers
						(company_id,username,password,hash,created,lastlogin,status)
						VALUES
						(:company_id,:username, :password, :hash, :created, :lastlogin,:status)";
$params = array(
	array(':company_id',$company_id, 'int'),
	array(':username', $input_data->first_name.' '.$input_data->last_name, 'str'),
	array(':password', $phpass->HashPassword($input_data->password), 'str'),
	array(':hash', 'xv74m', 'str'),
	array(':created', date('Ymd'), 'str'),
	array(':lastlogin', "1612170952", 'str'),
	array(':status', "1", 'int')
);*/

$db->query($query);
$user_id = $db->lastInsertId();

if(isset($user_id)){
	$data = [
		'status' => True,
		'message' => 'Company Added Successfully',
		'url' => 'https://mewemarket.com/apps/web2/user_login.php/?company='.$input_data->company_name,
	];
	echo json_encode($data);
}else {
	$data = [
		'status' => False,
		'message' => 'Something Wrong',
	];
	echo json_encode($data);
}

