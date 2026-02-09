<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class setting extends CI_Controller {

	
	
	
	
	public function EditProfile($id)
	{ 


		if($this->session->userdata('id') != $id){
			if($this->session->userdata('roleId') == 1){
				redirect(base_url().'admin');
			}elseif($this->session->userdata('roleId') == 2){
				redirect(base_url().'doctor');
			}else{
				redirect(base_url().'hospital');
			}
		}

		$user_detail_id = $this->session->userdata('UserDetail_Id');

		$UpdateoptionDetails = $this->user_model->UpdateUserFirstLogin($id,'__First__Login__');

		$this->session->set_userdata('First_Login', '1');


		if($this->session->userdata('roleId') == 2){
				$SendData['Doctordetails'] = $this->doctor_model->GetDoctorDetails($user_detail_id);

				$SendData['DoctorFiles'] = $this->doctor_model->GetDoctorFiles($user_detail_id);
		}elseif($this->session->userdata('roleId') == 3){
				$SendData['Hospitaldetails'] = $this->hospital_model->getHospitalById($user_detail_id);
		
		}else{
			$SendData['Doctordetails'] = "";
			$SendData['DoctorFiles'] = "";
			$SendData['Hospitaldetails'] = "";
		}


		$SendData['Userdetails'] = $this->user_model->GetUserData($id);



		$this->load->view('setting', $SendData);
	}

	public function UpdateProfile($id)
	{
		$doc_id = $id;
		
		$userdata = $this->input->post();
		$oldpassword = $this->input->post("oldpassword");
		$password = $this->input->post("password");
		$cpassword = $this->input->post("cpassword");
		unset($userdata['oldpassword']);
		unset($userdata['password']);
		unset($userdata['cpassword']);

		$oldhospital_pincode = $this->input->post("oldhospital_pincode");
		$hospital_pincode = $this->input->post("hospital_pincode");
		$chospital_pincode = $this->input->post("chospital_pincode");
		unset($userdata['oldhospital_pincode']);
		unset($userdata['hospital_pincode']);
		unset($userdata['chospital_pincode']);
		
		$passwordToConfirm = $this->user_model->GetUserData($id);
		
		
		if(!empty($oldpassword) && !empty($password)){
			if(md5($oldpassword) != $passwordToConfirm[0]->password){
				redirect(base_url().'setting/EditProfile/'.$id."?passwordNotMatch");
			}elseif(($cpassword) != $password){
				redirect(base_url().'setting/EditProfile/'.$id."?newPasswordNotMatch");
			}else{
				$userdata['password'] = md5($password);
				$userdata['original_password'] = $password;
				
			}
		}

		$roleId = $this->session->userdata('roleId');

		 if($roleId == 2 ){
			
		 	if(!empty($_FILES['Doctor_upload'])){ 

		 		$files = $_FILES['Doctor_upload'];
		 		$i = 0;
		 		foreach($files as $file){ ;

		 			if(!empty($files['name'][$i])){
		 				$attach_file[] = "assets/uploads/".$files['name'][$i];
		 			
		 				$file_name = $files['name'][$i];
				        $file_tmp =  $files['tmp_name'][$i];

				        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
						$allowed = array('jpg','png','gif','jpeg','bmp','svg','tif','psd','ai','JPEG','pdf');
						

						if( ! in_array( $ext, $allowed ) ) {
							$data['error'] = "yes";

							redirect(base_url().'setting/EditProfile/'.$id);
							
						}else{
							if(!empty($file_name)){
				        	 move_uploaded_file($file_tmp,"assets/uploads/".$file_name);
				        	}
						} 
				
		 		}
		 	$i++;
		 }
			}else{
				$attach_file[] = "";
			}

		 		$doctor_detail_id = $this->session->userdata('UserDetail_Id');

		 		if(!empty($attach_file)){

			 		foreach($attach_file as $file){

			 			$Sdata['doctor_id '] = $doc_id;
						$Sdata['filename'] = $file;
				
						$Upload_Doctor_documents = $this->doctor_model->Upload_Doctor_documents($Sdata);

						$id = $this->session->userdata('id');

						$user = $this->admin_model->Selectuser($id)[0]->first_name;
		
						$Notify['userId '] = $id;
						$Notify['user_action '] = "Doctor". $user ."Upload Document";

						$notification = $this->admin_model->AddNotification($Notify);

			 		}
			 	}

		 	$this->user_model->UpdateDoctor($userdata);

		 	$id = $this->session->userdata('id');$user = $this->admin_model->Selectuser($id)[0]->first_name;
		
			$Notify['userId '] = $id;
			$Notify['user_action '] = "Doctor". $user ."Update Profile";

			$notification = $this->admin_model->AddNotification($Notify);
		 }
	  if($roleId == 3 ){

	  		$pinToConfirm = $this->hospital_model->getHospitalByIdUser($id);
	  		
			if(!empty($oldhospital_pincode) && !empty($hospital_pincode)){
				if($oldhospital_pincode != $pinToConfirm[0]->hospital_pincode){
					redirect(base_url().'setting/EditProfile/'.$id."?pincodeNotMatch");
				}elseif(($chospital_pincode) != $hospital_pincode){
					redirect(base_url().'setting/EditProfile/'.$id."?newPincodeNotMatch");
				}else{
					$Sdata['hospital_pincode'] = $hospital_pincode;
					$this->session->set_userdata('hospital_pincode', $hospital_pincode);
				}
			}

		 	$hospital_detail_id = $this->session->userdata('UserDetail_Id');
			$Sdata['hospital_name'] = $this->input->post("institute_name");
			
			$Sdata['address'] = $this->input->post("address");
			$Sdata['phone'] = $this->input->post("mobile_number");

			$id = $this->session->userdata('id');
			$user = $this->admin_model->Selectuser($id)[0]->first_name;
		
			$Notify['userId '] = $id;
			$Notify['user_action '] = "Hospital". $user ."Update Profile";

			$notification = $this->admin_model->AddNotification($Notify);

			$this->hospital_model->updateHospitalById($Sdata,$hospital_detail_id);
		}
	
		unset($userdata['gmc_number']);
		unset($userdata['work_number']);
		unset($userdata['show_number']);
		unset($userdata['show_email']);
		
		unset($userdata['secondary_email']);
		unset($userdata['department']);
		unset($userdata['doctor_specialties']);
		unset($userdata['gender']);
		
		unset($userdata['institute_name']);



		$Originalmobile_number = $this->admin_model->Selectuser($id)[0]->mobile_number;

		if($Originalmobile_number != $userdata['mobile_number']){
			$userdata['mobile_verified'] = '0';
		}

		$CountryCode = substr($userdata['mobile_number'], 0, 3);

	    if($CountryCode != '+44'){

			if(substr($userdata['mobile_number'], 0, 2) == 44){
				$userdata['mobile_number'] = '+'.$userdata['mobile_number'];
			}else{
				$userdata['mobile_number'] = '+44'.$userdata['mobile_number'];
			}
	    }


		

		if(empty($userdata['codeviaEmail'])){
			$userdata['codeviaEmail'] = '0';
		}else{
			$userdata['codeviaEmail'] = '1';
		}

		if(empty($userdata['codeviaSms'])){
			$userdata['codeviaSms'] = '0';
		}else{
			$userdata['codeviaSms'] = '1';
		}

		if($userdata['codeviaEmail'] == 0 && $userdata['codeviaSms'] == 0){
			$userdata['codeviaEmail'] = '1';
		}
	
		$data =  $this->user_model->UpdateUserData($userdata);

		$id = $this->session->userdata('id');
		
		$Data['userId'] = $id;
		$Data['user_action'] = "User Update his profile";

		$data = $this->admin_model->AddNotification($Data);

		if($data == "Done"){
			redirect(base_url().'setting/EditProfile/'.$id."?updated");
		}else{
			redirect(base_url().'setting/EditProfile/'.$id."?updated");
		}

	}

	public function DeleteThisFile()
	{
		
		$id = $_GET['id'];

		$data =  $this->doctor_model->DeleteFileById($id);

		$id = $this->session->userdata('id');$id = $this->session->userdata('id');$user = $this->admin_model->Selectuser($id)[0]->first_name;
		
		
		$Notify['userId '] = $id;
		$Notify['user_action '] = "Doctor ".$user." delete his Document file";

		$notification = $this->admin_model->AddNotification($Notify);

		if($data != 'Fail'){
			echo "--Done--";
		}
		
	}

	public function SendValidationCode()
	{ 
		if(empty($this->session->userdata('roleId'))){
			redirect(base_url());
		}

		$id = $this->input->get('id');
		//$phoneNumber = $this->input->get('phoneNumber');

		$mobile_number = $this->admin_model->Selectuser($id)[0]->mobile_number;

		if(substr($mobile_number, 0, 1) != '+'){
			$data['mobile_number'] = '+'.$mobile_number;
		}else{
			$data['mobile_number'] = $mobile_number;
		}

		$pattern = "/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/";
					
		$match = preg_match($pattern,$data['mobile_number']);
		
		if ($match != false) {
			$ValidationCode = mt_rand(100000,999999);

		$body = "Visiopath Verification Code:
".$ValidationCode."";
		//$to = "+923462300676";
		$to = $data['mobile_number'];

		$this->message_model->sendTextMessage($to,$body);

		$this->session->set_userdata('ValidationCode',$ValidationCode);

			echo '--Done--';
		} else {
			echo '--Fail--';
		}

	    //$this->user_model->UpdateMobileNumberOfUser($id,$data);
	 	

	}

	public function UpdateVerifiedStatus()
	{ 
		if(empty($this->session->userdata('roleId'))){
			redirect(base_url());
		}

		$id = $this->input->get('id');

		$data =  $this->user_model->UpdateVerifiedStatus($id);
		
		return true;

	}

	public function checkCode()
	{ 

		if(empty($this->session->userdata('roleId'))){
			redirect(base_url());
		}

		$code = $this->input->get('code');

		if($code == $this->session->userdata('ValidationCode')){
			echo  "--done--";
		}else{
			echo "--fail--";
		}
		
	}

	
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */