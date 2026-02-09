<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

	public function index()
	{
		$this->load->view('users/login');
	}

	public function Verify()
	{
		//print_r($this->input->post());

		//$this->load->helper('cookie'); 

		$email = $this->input->post('email', true);
		$password =  $this->input->post('password', true);

		$pass = md5($password);

		//$data = $this->user_model->userLogin($email);
		$data = $this->user_model->userLogin($email,$pass);

		if(!empty($data)){

	        $UserDetails = array();
			$UserDetails["id"] = $data[0]->id;
			$UserDetails["user_detail_id"] = $data[0]->user_detail_id;
			$UserDetails["admin_id"] = $data[0]->admin_id;
			$UserDetails["username"] = $data[0]->first_name." ".ucfirst(substr($data[0]->middle_name, 0,1)).". ".$data[0]->last_name;
			$UserDetails["first_name"] = $data[0]->first_name;
			$UserDetails["middle_name"] = $data[0]->middle_name;
			$UserDetails["last_name"] = $data[0]->last_name;
			$UserDetails["email"] = $data[0]->email;
			$UserDetails["phone"] = $data[0]->phone;
			$UserDetails["type"] = $data[0]->type;

			if($data[0]->type == 'Super Admin'){
				$UserDetails["passcode"] = '000000';
			}

			if($data[0]->type == 'Admin'){
				$UserDetails["passcode"] = $data[0]->passcode;
			}

			if($data[0]->type == 'User'){
				$passcode = $this->user_model->GetPasscodeByAdminId($data[0]->admin_id);
				$UserDetails["passcode"] = $passcode[0]->passcode;
			}


			if($data[0]->type == 'Super Admin'){
				$UserDetails["check_module"] = 1;
				$UserDetails["sales_module"] = 1;
				$UserDetails["payroll_module"] = 1;
				$UserDetails["deposit_module"] = 1;

			}elseif($data[0]->type == 'Admin'){

				$SendData['permissions']  = $this->user_model->AdminPermissionsById($data[0]->id);

				if(empty($SendData['permissions'])){
					redirect('login'."?permission");
				}

				$UserDetails["check_module"] = $SendData['permissions'][0]->check_module;
				$UserDetails["deposit_module"] = $SendData['permissions'][0]->deposit_module;

			}elseif($data[0]->type == 'User'){

				if(empty($data[0]->admin_id)){
					redirect('login'."?permission");
				}

				$SendData['permissions']  = $this->user_model->AdminPermissionsById($data[0]->admin_id);

				if(empty($SendData['permissions'])){
					redirect('login'."?permission");
				}

				$UserDetails["check_module"] = $SendData['permissions'][0]->check_module;
				$UserDetails["deposit_module"] = $SendData['permissions'][0]->deposit_module;

			}else{
				
				$new = $this->user_model->GetUserDetailsById('',$data[0]->user_detail_id);

				if(empty($new)){
					redirect('login'."?permission");
				}
				
				$SendData['permissions']  = $this->user_model->AdminPermissionsById($new[0]->admin_id);

				if(empty($SendData['permissions'])){
					redirect('login'."?permission");
				}

				$UserDetails["check_module"] = $SendData['permissions'][0]->check_module;
				$UserDetails["deposit_module"] = $SendData['permissions'][0]->deposit_module;
			}
			
			$this->session->set_userdata($UserDetails);

			redirect('users/Options');

        }else{
        	$SendData['Error'] = 'User does not exist';
					
			redirect('login'."?error");

        }
		
	}



	public function logout()
	{

		$this->session->sess_destroy();

		redirect('login');
	}

	public function forgetPassword()
	{
		
		$this->load->view('users/forgetpassword');
	}
	
	
}
