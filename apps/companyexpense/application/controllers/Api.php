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
		$this->load->model('Dashboard_Model');

    }

   public function index()
	{
        $method = $this->input->server('REQUEST_METHOD');

        if ($method == 'POST') {

            $input_data = json_decode(trim(file_get_contents('php://input')));

            $company_name =  $input_data->company_name;

           $company_id = $this->Dashboard_Model->company_add($company_name);


            $return = $this->Dashboard_Model->user_add($company_id,$input_data);

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
