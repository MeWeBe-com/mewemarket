<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');

header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

header('Access-Control-Allow-Credentials: true');

header('Content-Type: application/json');


class api_register extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('user_model');

		$this->load->model('login_model');

		$this->load->model('company_model');

		$this->load->model('supplier_login_model');

	}


	public function register_from_sass(){

		$input_data = json_decode(trim(file_get_contents('php://input')));
		echo "hello";

		print_r($input_data);
		exit;


		$data = array('name'=>$input_data['company_name']);

		$this->db->insert('companies', $data);

		$id = $this->db->insert_id();

		// Get the post data

		$first_name = strip_tags($input_data['first_name']);

		$last_name = strip_tags($input_data['last_name']);

		$email = strip_tags($input_data['email']);

		$role = strip_tags($input_data['role']);

		$password = md5($input_data['password']);

		$company = strip_tags($id);

		// Validate the post data

		if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password)) {

				$userData = array(

					'name' => $first_name.' '.$last_name,

					'email' => $email,

					'role' => $role,

					'status' => 0,

					'company_id' => $company,

					'password' => $password,

				);

				$insert = $this->db->insert('users',$userData);

				// Check if the user data is inserted

				if ($insert) {

					// Set the response and exit

					$data = [

						'status' => TRUE,

						'message' => 'The user has been added successfully.',

						'url' => base_url('login/'.$input_data['company_name']),

					];

					echo json_encode($data);

				} else {

					$data = [

						'status' => False,

						'message' => 'Something Wrong.',

					];

					echo json_encode($data);

				}

		} else {

			$data = [

				'status' => False,

				'message' => 'Provide complete user info to add.',

			];

			echo json_encode($data);
		}

	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
