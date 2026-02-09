<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddDoctor extends CI_Controller {

	
	public function index()
	{
	
	}

	public function AddNewDoctor()
	{
			$data['doctor_name'] = $this->input->post('username');
			$data['department'] = $this->input->post('department');
			$data['gender'] = $this->input->post('gender');

			$doctor_id = $this->admin_model->addNewDoctor($data);

			if($doctor_id != 'Fail'){
			  
				$datas['username'] = $this->input->post('username');
				$datas['roleId'] = '2';
				$datas['UserDetail_Id '] = $doctor_id;
				$datas['email'] = $this->input->post('email');
				$datas['first_name'] = $this->input->post('first_name');
				$datas['last_name'] = $this->input->post('last_name');

				$datas['mobile_number'] = $this->input->post('mobile_number');
				$datas['address'] = $this->input->post('address');

				$datas['password'] = md5($this->input->post('password')) ;
				$datas['original_password'] = $this->input->post('password');
				$datas['DateOfBirth'] = $this->input->post('DateOfBirth');

				$doctor_details_id = $this->admin_model->addNewDoctorDetails($datas);
			}

				$Uid = $this->session->userdata('id');
						
				$Notify['userId '] = $Uid;
				$Notify['user_action '] = "Admin add new Doctor Name : ".$this->input->post('first_name')." ".$this->input->post('last_name');
						

				$notification = $this->admin_model->AddNotification($Notify);

			if($this->input->post('appview') == 'yes'){
				$data = $datas;
				print json_encode($data);
				
			}
	}

	
		
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */