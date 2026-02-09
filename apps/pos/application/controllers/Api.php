<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');

header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

header('Access-Control-Allow-Credentials: true');

header('Content-Type: application/json');


class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
		/*$this->load->library('session');
        $this->load->library('rest_controller');*/
		$this->load->model('model_api');

    }

   public function index()
	{
        $method = $this->input->server('REQUEST_METHOD');

        if ($method == 'POST') {

            $input_data = json_decode(trim(file_get_contents('php://input')));

            $data['company_name'] =  $input_data->company_name;

           $company_id = $this->model_api->InsertCompany($data);

            $Userdata['company_id']     = $company_id;
            $Userdata['first_name']     = $input_data->first_name;
            $Userdata['last_name']      = $input_data->last_name;
            $Userdata['email']          = $input_data->email;
            $Userdata['roleId']         = $input_data->role;
            $Userdata['username']       = $input_data->first_name.' '.$input_data->last_name;
            $Userdata['UserDetail_Id']  = '0';
            $Userdata['password']       = md5($input_data->password);

            $return = $this->admin_model->insertCompanyAdmin($Userdata);

            if($return == 'Done'){
                $data = [
                    'status' => True,
                    'message' => 'Company Added Successfully',
					'url' => base_url('login/'.$data['company_slug']),
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

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
