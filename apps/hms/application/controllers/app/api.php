<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php';

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');

header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

header('Access-Control-Allow-Credentials: true');

header('Content-Type: application/json');


class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('general_model');

    }

   public function index()
	{
        $method = $this->input->server('REQUEST_METHOD');

        if ($method == 'POST') {

            $input_data = json_decode(trim(file_get_contents('php://input')));

            $company_name =  $input_data->company_name;

           $company_id = $this->general_model->insertCompany($company_name);


           $last_user_id = $this->general_model->GetLastUser_id();

            $Userdata['company_id']     = $company_id;
            $Userdata['user_id']        = $last_user_id->user_id + 1;

            $Userdata['department']        = '2';
            $Userdata['designation']        = '1';
            $Userdata['user_role']        = '1';
            $Userdata['user_role']        = '7';
            $Userdata['lastname']      = $input_data->last_name;
            $Userdata['firstname']     = $input_data->first_name;
            $Userdata['age']     = '0';
            $Userdata['gender']     = '0';
            $Userdata['civil_status']     = '3';
            $Userdata['birthday']     = '1974-05-30';
            $Userdata['email_address']          = $input_data->email;
            $Userdata['username']       = $input_data->first_name;
            $Userdata['password']       = md5($input_data->password);
            $Userdata['InActive']  = '0';

            $return = $this->general_model->insertCompanyAdmin($Userdata);
            

            if($return == 'Done'){
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

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
