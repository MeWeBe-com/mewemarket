<?php require('../includes/connection.php');

header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

$input_data = json_decode(trim(file_get_contents('php://input')));

    $company_name = $input_data->company_name;

    $query = "INSERT INTO company (COMPANY_ID, COMPANY_NAME ) VALUES (Null,'{$company_name}')";
    mysqli_query($db,$query)or die ('Error in updating product in Database '.$query);
    $company_id = mysqli_insert_id($db);

        $first_name = $input_data->first_name;
        $lastname = $input_data->last_name;
        $email = $input_data->email;
        $phonenumber  = $input_data->phone;
        $password  = sha1($input_data->password);
        $gender  = "Male";
        $job_id  = "1";
        $date  = date('Y-m-d');

        $query = "INSERT INTO `employee`(`EMPLOYEE_ID`, `COMPANY_ID`, `FIRST_NAME`, `LAST_NAME`, `GENDER`, `EMAIL`, `PHONE_NUMBER`, `JOB_ID`, `HIRED_DATE`)
                  VALUES (Null,'{$company_id}','{$first_name}','{$lastname}','{$gender}','{$email}','{$phonenumber}','{$job_id}','{$date}')";
        mysqli_query($db,$query)or die ('Error in updating product in Database '.$query);
        $employee_id = mysqli_insert_id($db);

        $query = "INSERT INTO `users`(`ID`, `COMPANY_ID`, `EMPLOYEE_ID`, `USERNAME`, `PASSWORD`, `TYPE_ID`) 
                          VALUES (Null,'{$company_id}','{$employee_id}','{$first_name}','{$password}','1')";
        mysqli_query($db,$query)or die ('Error in updating product in Database '.$query);
        $admin_id = mysqli_insert_id($db);


if(isset($admin_id)){
	$data = [
		'status' => True,
		'message' => 'Company Added Successfully',
		'url' => 'https://www.mewemarket.com/apps/SAIS/'.$company_name.'/pages/login.php',
	];
	echo json_encode($data);
}else {
	$data = [
		'status' => False,
		'message' => 'Something Wrong',
	];
	echo json_encode($data);
}

