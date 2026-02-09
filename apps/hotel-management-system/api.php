<?php
include('connect.php');

header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

$input_data = json_decode(trim(file_get_contents('php://input')));

$sql = "INSERT INTO `company`(`company_name`) VALUES ('$input_data->company_name')";

if ($conn->query($sql) === TRUE) {
    $company_id = $conn->insert_id;
}

$passw = hash('sha256', $input_data->password);
//$passw = hash('sha256',$p);
//echo $passw;exit;
function createSalt()
{
    return '2123293dsj2hu2nikhiljdsd';
}
$salt = createSalt();
$pass = hash('sha256', $salt . $passw);

$sqls = "INSERT INTO `admin`(`company_id`, `username`, `email`, `password`, `fname`, `lname`,`gender`,`dob`,`contact`,`address`,`image`,`created_on`,`group_id`) VALUES 
                          ('".$company_id."','".$input_data->first_name."','".$input_data->email."','".$pass."'
                          ,'".$input_data->first_name."','".$input_data->last_name."','Male','1994-01-01','".$input_data->phone."','UK','pos.jpg','2021-03-01','1')";

if($conn->query($sqls) === TRUE){
	$data = [
		'status' => True,
		'message' => 'Company Added Successfully',
		'url' => 'https://www.mewemarket.com/apps/hotel-management-system/'.$input_data->company_name,
	];
	echo json_encode($data);
}else {
	$data = [
		'status' => False,
		'message' => 'Something Wrong',
	];
	echo json_encode($data);
}

