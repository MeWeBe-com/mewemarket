<?php
defined('_PATH') or die('Restricted!');

class ControllerApiSaas extends Controller {
    private $error = array();

    public function index() {
		$input_data = json_decode(trim(file_get_contents('php://input')));

		$this->load->model('api/api');

		$company_id = $this->model_api_api->AddCompany($input_data->company_name);

		$admin_data = array(
			'company_id' 	 => $company_id,
			'user_group_id'  => $input_data->role,
			'key' 	 => $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 64)),
			'secret'  => $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 64)),
			'name'    		 => $input_data->first_name.' '.$input_data->last_name,
			'email'    		 => $input_data->email,
			'username'    	 =>  $input_data->first_name,
			'salt'  		 => $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)),
			'password'    	 =>  SHA1($input_data->password),
			'ip'             => '',
			'code'           => '',
			'status'         => $input_data->role,
		);

		$admin_id = $this->model_api_api->AddAdmin($admin_data);

		if(isset($admin_id)){
			$data = [
				'status' => True,
				'message' => 'Company Added Successfully',
				'url' => 'https://www.mewemarket.com/apps/logic-invoice/',
			];
		}else {
			$data = [
				'status' => False,
				'message' => 'Something Wrong',
			];
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
    }

}
