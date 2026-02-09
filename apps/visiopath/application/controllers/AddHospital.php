<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddHospital extends CI_Controller {

	
	public function index()
	{
	
	}

	public function AddNewHospital()
	{
			$data['hospital_name'] = $this->input->post('username');
			$data['address'] = $this->input->post('address');
			$data['phone'] = $this->input->post('mobile_number');
			$data['notes'] = $this->input->post('notes');
			//$data['hospital_number'] = $this->input->post('hospital_number');
			$datas['notes'] = $this->input->post('notes');

			$hospital_id = $this->admin_model->addNewHospital($data);

			if($hospital_id != 'Fail'){
			  
				$datas['username'] = $this->input->post('username');
				$datas['roleId'] = '3';
				$datas['UserDetail_Id '] = $hospital_id;
				$datas['email'] = $this->input->post('email');
				$datas['first_name'] = $this->input->post('first_name');
				$datas['last_name'] = $this->input->post('last_name');

				$datas['mobile_number'] = $this->input->post('mobile_number');
				$datas['address'] = $this->input->post('address');

				$datas['password'] = md5($this->input->post('password')) ;
				$datas['original_password'] = $this->input->post('password');
				

				$hospital_details_id = $this->admin_model->addNewHospitalDetails($datas);

			}

			$Uid = $this->session->userdata('id');
						
			$Notify['userId '] = $Uid;
			$Notify['user_action '] = "Admin add new Hospital Name: ".$data['hospital_name'];
						

				$notification = $this->admin_model->AddNotification($Notify);

			if($this->input->post('appview') == 'yes'){
				$data = $datas;
				print json_encode($data);
				
			}
	}

	
		
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */