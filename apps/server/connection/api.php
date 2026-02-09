<?php include 'config.php';

header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

$input_data = json_decode(trim(file_get_contents('php://input')));

 $pas  = password_hash($input_data->password, PASSWORD_DEFAULT);
 $sql = "INSERT INTO `monitor_users`( `company_name`,`user_name`,`password`,`password_reset_hash`,`password_reset_timestamp`,`rememberme_token`,`level`,`name`,`mobile`,`pushover_key`,`pushover_device`,`email`) VALUES 
                     ('".$input_data->company_name."','".$input_data->first_name."','".$pas."',NULL,NULL,NULL,'10','".$input_data->first_name."','".$input_data->phone."','','','".$input_data->email."')";

 $insertedID = mysqlInsert($sql);


if(isset($insertedID)){
	$data = [
		'status' => True,
		'message' => 'Company Added Successfully',
		'url' => 'https://www.mewemarket.com/apps/server/',
	];
	echo json_encode($data);
}else {
	$data = [
		'status' => False,
		'message' => 'Something Wrong',
	];
	echo json_encode($data);
}



?>
