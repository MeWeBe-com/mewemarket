<?php include 'admin/includes/conn.php';

header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

$input_data = json_decode(trim(file_get_contents('php://input')));

$sql = "INSERT INTO company (company_name) VALUES ('$input_data->company_name')";
$query = $conn->query($sql);
$company_id =  mysqli_insert_id($conn);

$password = password_hash($input_data->password,PASSWORD_DEFAULT);
$date = date('Y-m-d');
$sql = "INSERT INTO admin (company_id, username, password, firstname, lastname,created_on) VALUES ('$company_id','$input_data->first_name','$password','$input_data->first_name','$input_data->last_name', '$date')";

if($conn->query($sql)){
	$data = [
		'status' => True,
		'message' => 'Company Added Successfully',
		'url' => 'https://www.mewemarket.com/apps/payrollsystem/'.$input_data->company_name,
	];
	echo json_encode($data);
}else {
	$data = [
		'status' => False,
		'message' => 'Something Wrong',
	];
	echo json_encode($data);
}

