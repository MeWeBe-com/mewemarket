<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');

header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

header('Access-Control-Allow-Credentials: true');

header('Content-Type: application/json');


class Register extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_api');
	}

	/* 
	* redirect to the index page 
	*/
	public function index()
	{
		$method = $this->input->server('REQUEST_METHOD');

		if ($method == 'POST') {

			$input_data = json_decode(trim(file_get_contents('php://input')));

			$data['company_name'] =  $input_data->company_name;
			$company_id = $this->model_api->InsertCompany($data);

			$datas['company_id'] =  $company_id;
			$datas['company_name'] =  $input_data->company_name;
			$datas['service_charge_value'] =  "13";
			$datas['vat_charge_value'] =  "10";
			$datas['address'] =  "Madrid";
			$datas['phone'] =  $input_data->phone;
			$datas['country'] =  "Spain";
			$datas['message'] =  "hello";
			$datas['currency'] =  "USD";

			$this->model_api->InsertCompanyData($datas);

			$password = password_hash($input_data->password,PASSWORD_DEFAULT);

			$Userdata['company_id']     = $company_id;
			$Userdata['firstname']      = $input_data->first_name;
			$Userdata['lastname']       = $input_data->last_name;
			$Userdata['email']          = $input_data->email;
			$Userdata['username']       = $input_data->first_name.''.$input_data->last_name;
			$Userdata['gender']  		= '1';
			$Userdata['password']       = $password;
			$Userdata['phone']       	= $input_data->phone;

			$return = $this->model_api->InsertCompanyAdmin($Userdata);

			$group['user_id']       = $return;
			$group['group_id']      = "1";

			$return = $this->model_api->InsertAdminGroup($group);

			if(!empty($return)){
				$data = [
					'status' => True,
					'message' => 'Company Added Successfully',
					'url' => base_url(),
				];
				echo json_encode($data);
			}else {
				$data = [
					'status' => False,
					'message' => 'Something Wrong',
				];
				echo json_encode($data);
			}
		}else {
			$data = [
				'status' => False,
				'message' => 'Invalid Method',
			];
			echo json_encode($data);
		}
	}

}
