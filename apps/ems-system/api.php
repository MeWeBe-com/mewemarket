<?php
	include 'admin/admin_class.php';
	$action = new Action();


	header('Content-Type: application/json');
	//header('Access-Control-Allow-Origin: *');

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
	header('Access-Control-Allow-Headers: token, Content-Type');

	$input_data = json_decode(trim(file_get_contents('php://input')));

	if(!empty($input_data)){
		$lastInsertId = $action->register_user($input_data);
	}

	if($lastInsertId == "Done"){
		$data = [
			'status' => True,
			'message' => 'Company Added Successfully',
			'url' => 'https://www.mewemarket.com/apps/ems-system?company='.$input_data->company_name,
		];
		echo json_encode($data);
	}else {
		$data = [
			'status' => False,
			'message' => 'Something Wrong',
		];
		echo json_encode($data);
	}
