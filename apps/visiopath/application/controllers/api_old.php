<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');


class api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('rest_controller');

    }

   public function index()
	{
        $method = $this->input->server('REQUEST_METHOD');

        if ($method == 'POST') {

            $input_data = json_decode(trim(file_get_contents('php://input')));

            $data['company_name'] =  $input_data->company_name;
            $data['company_slug'] =  strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $input_data->company_name)));
            $data['company_email'] =  $input_data->email;

           $company_id = $this->admin_model->insertCompany($data);

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
                echo $this->rest_controller->response(json_encode($data), $this->rest_controller::HTTP_OK);
            }else {
                $data = [
                    'status' => False,
                    'message' => 'Something Wrong',
                ];
               echo $this->rest_controller->response(json_encode($data), $this->rest_controller::HTTP_BAD_REQUEST);
            }
        }else {
            $data = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($data), $this->rest_controller::HTTP_BAD_REQUEST);
        }
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
