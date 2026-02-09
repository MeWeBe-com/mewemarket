<?php
session_start();
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');


include('lib/barcode/vendor/picqer/php-barcode-generator/src/BarcodeGenerator.php');
include('lib/barcode/vendor/picqer/php-barcode-generator/src/BarcodeGeneratorPNG.php');

class user extends CI_Controller {

	
	public function index($slug = NULL)
	{
		if (REQUEST == "external") {
			return;
		}

		if(empty($slug)){
            $slug = 'demo';
            $Companydata = $this->user_model->GetCompanyNameAndID($slug);
        }else{
            $Companydata = $this->user_model->GetCompanyNameAndID($slug);
        }

		if(empty($Companydata)){
            $Data['company_id'] = '1';
            $Data['company_name'] = 'Demo';
            $Data['company_name'] = 'demo';
            redirect(base_url().'login/demo');
        }else{
            $Data['company_id'] = $Companydata[0]->id;
            $Data['company_name'] = $Companydata[0]->company_name;
        }

		$this->load->view('index',$Data);
	}
	
	public function forgetpassword()
	{

		$this->load->view('forgetpassword');
	}

	public function Login()
	{
		$this->load->helper('cookie');

		$email = $this->input->post('email', true);
		$pass =  $this->input->post('password', true);

        $company_id =  $this->input->post('company_id', true);

		$password = md5($pass);

		//$data = $this->user_model->userLogin($email,$password);
        $data = $this->user_model->userLogin($email,$password,$company_id);

		if(!empty($data)){

	        $UserDetails = array();
			$UserDetails["id"] = $data[0]->id;
			$UserDetails["username"] = $data[0]->first_name." ".$data[0]->last_name;
			$UserDetails["roleId"] = $data[0]->roleId;
			$UserDetails["UserDetail_Id"] = $data[0]->UserDetail_Id;
			$UserDetails["email"] = $data[0]->email;
			$UserDetails["user_type"] = $data[0]->user_type;
			$UserDetails["mobile_number"] = $data[0]->mobile_number;
			$UserDetails["DateOfBirth"] = $data[0]->DateOfBirth;
			$UserDetails["last_login"] = $data[0]->last_login;
            $UserDetails["company_id"] = $company_id;
            $UserDetails["company_name"] = $data[0]->company_name;
            $UserDetails["company_slug"] = $data[0]->company_slug;

            if(empty($data[0]->company_logo)){
                $UserDetails["company_logo"] = 'logo.jpg';
            }else{
                $UserDetails["company_logo"] = $data[0]->company_logo;
            }


            if($data[0]->roleId == 3){
				 $UserDetails["username"] = $this->hospital_model->getHospitalById($data[0]->UserDetail_Id)[0]->hospital_name;
				 $UserDetails["hospital_pincode"] = $this->hospital_model->getHospitalById($data[0]->UserDetail_Id)[0]->hospital_pincode;
			}
			$Verification_code = mt_rand(100000,999999); 
 
			 $UserDetails["Verification_code"] = $Verification_code;
			 $nextminute  = mktime(date('h'), date('i')+2, date('s'), date("m"),   date("d"),   date("Y"));

			$UserDetails["Login_time"] = $nextminute;
		
			//$UserDetails['IsFirstLogin']=$UserObject->IsFirstLogin;

				$optionDetails = $this->user_model->GetUserFirstLogin($data[0]->id,'__First__Login__');
				if(empty($optionDetails)){

					$Details["parent_id"] = $data[0]->id;
					$Details["role"] = $data[0]->roleId;
					$Details["name"] = '__First__Login__';
					$Details["value"] = '0';
					
					$AddoptionDetails = $this->user_model->AddUserFirstLogin($Details);

					$UserDetails["First_Login"] = $AddoptionDetails[0]->value;

				}else{
					$UserDetails["First_Login"] = $optionDetails[0]->value;
				}
			

			$this->session->set_userdata($UserDetails);

			if($data[0]->roleId == 1){
				$user = 'Admin';
			}elseif($data[0]->roleId == 2){
				$user = 'Doctor';
			}elseif($data[0]->roleId == 3 ){
				$user = 'Hospital';
			}

	
			$Data['userId '] = $data[0]->id;
			$Data['user_action '] = $user." has login";

			$Addnotify = $this->admin_model->AddNotification($Data);

			$updatelogin = $this->user_model->updateLastlogin();

			//

			if($data[0]->roleId != 3){

				$rememberCookie =  $this->input->cookie("remember_me");
				if(!empty($rememberCookie)){
					if($this->session->userdata('id') == $rememberCookie){
						if($this->session->userdata('roleId') ==1){
							redirect('admin');
						}
						elseif($this->session->userdata('roleId') == 2){
								redirect('doctor');
								
						}
					}
				}

				if($data[0]->codeviaEmail == 1){
					$this->load->library('event');

					$Content = array();
		                    
					$Content['Verification_code'] = $Verification_code;
		             
		            //$data['to'] = $data[0]->email;
		            //$data['to'] = 'fahad.m.aslam@gmail.com';
                    $data['to'] = 'haseeb.idevation@gmail.com';
		            $data['subject'] = 'Two Factor Authentication';
					
		            $data['body'] = $this->load->view('emails/loginemail',$Content, true);

		            $this->event->email($data);
	        	}
	        	//Send Code Via SMS
	        	if($data[0]->mobile_verified == 1){

					if($data[0]->codeviaSms == 1){

				$body = "Visiopath Verification Code:
".$Verification_code."";
		//$to = "+923462300676";
					$to = $data[0]->mobile_number;


					$pattern = "/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/";
					
					$match = preg_match($pattern,$to);
					
					if ($match != false) {
						//$this->message_model->sendTextMessage($to,$body);
					} else {
							redirect('user/TwoFactorAuthentication?invalidNumber');
					}

					}
				}

				//End send Code Via SMS

				redirect('user/TwoFactorAuthentication');
			}else{
				redirect('hospital/PinVerification');
			}

        }else{
        	$SendData['Error'] = 'User does not exist';

            $Companydata = $this->user_model->GetCompanyNameAndIDByID($company_id);
                redirect(base_url().'login/'.$Companydata[0]->company_slug.'?error');
        }
		
	}
	
	public function sendpassword()
	{
		//print_r($this->input->post());

		$email = $this->input->post('email', true);

		$data = $this->user_model->userLoginforget($email);

		if(!empty($data)){

	        $UserDetails = array();
			$id = $data[0]->id;
			$username = $data[0]->username;

			$Verification_code = mt_rand(100000,999999); 
 
			$UserDetails["Verification_code"] = $Verification_code;
			 $nextminute  = mktime(date('h'), date('i')+2, date('s'), date("m"),   date("d"),   date("Y"));
			

			$UserDetails["Login_time"] = $nextminute;
		
			//$UserDetails['IsFirstLogin']=$UserObject->IsFirstLogin;
			$this->session->set_userdata($UserDetails);

			$Data['userId'] = $data[0]->id;
			$user = $this->admin_model->Selectuser($Data['userId'])[0]->first_name;
			$Data['user_action '] = "Generate new password for ".$user;

			$Addnotify = $this->admin_model->AddNotification($Data);

			//$updatelogin = $this->user_model->updateLastlogin();


			$this->load->library('event');

			$Content = array();
                    
			$Content['userId'] = $data[0]->id;

            $data['to'] = $data[0]->email;
           // $data['to'] = 'fahad.m.aslam@gmail.com';
            $data['subject'] = 'Forgot password - Visiopath';
			
             $data['body'] = $this->load->view('emails/forgotemail',$Content, true);

            $this->event->email($data);

			redirect('user/forgetpassword?emialsent');

        }else{
        	$SendData['Error'] = 'User does not exist';
					
			redirect('user/forgetpassword'."?error");

        }
		
	}
	
	public function verifyForgotPassword($id)
	{
		//print_r($this->input->post());

		$password = $this->input->post('password', true);
		$cpassword = $this->input->post('cpassword', true);
		if(!empty($password)){
			if($password != $cpassword){
				redirect('user/verifyForgotPassword/'.$id."/?error");
			}else{
				$this->user_model->updatepassword($password,$id);
				redirect('user'."?passwordchanged");
			}
		
		}
		
		

		$data = $this->user_model->userLoginforgetmd5($id);
		
		if(!empty($data)){
			$Code_time = $this->session->userdata('Login_time');
			$current_time = mktime(date('h'), date('i'), date('s'), date("m"),   date("d"),   date("Y"));
			if($current_time > $Code_time){
			//if(1==2){
				redirect('user/forgetpassword'."?expire");
			}else{
				$this->load->view('resetpassword');
			}

        }else{
        	$SendData['Error'] = 'User does not exist';
			redirect('user/forgetpassword'."?error");

        }
		
	
	}
	
	
	

	public function TwoFactorAuthentication()
	{
		$this->load->view('verify');
	}

	public function VerificationLogin()
	{

		$posted_code = $this->input->post('Verification_code');
		$verification = $this->session->userdata('Verification_code');

	  	$Code_time = $this->session->userdata('Login_time');
		$current_time = mktime(date('h'), date('i'), date('s'), date("m"),   date("d"),   date("Y"));
 		if($current_time > $Code_time){
			redirect(base_url().'login/'.$this->session->userdata('company_slug')."?expire");
		}else{
			if($posted_code == $verification){

			    $this->session->set_userdata('verify_by_code','yes');

				$RememberMe =  $this->input->post('remember_me', true);

				if(!empty($RememberMe)){
						$this->load->helper('cookie'); 
						$cookie= array(

					       'name'   => 'remember_me',
					       'value' =>  $this->session->userdata('id'), 
					       'expire' => '7889400',                                                                                   
					       'secure' => false,
					     

			   			);

						$this->input->set_cookie($cookie);
					}


				if($this->session->userdata('roleId') ==1){
					redirect('admin');
				}
				elseif($this->session->userdata('roleId') == 2){
						redirect('doctor');
						
				}elseif($this->session->userdata('roleId') == 3){
						redirect('hospital');
				}
			}else{
				redirect('user/TwoFactorAuthentication'."?expire");
			}
			
		}

	}



	public function logout()
	{

		$id = $this->session->userdata('id');

		if($this->session->userdata('roleId') == 1){
				$user = 'Admin';
			}elseif($this->session->userdata('roleId') == 2){
				$user = 'Doctor';
			}elseif($this->session->userdata('roleId') == 3 ){
				$user = 'Hospital';
			}
		
		$Data['userId '] = $id;
		$Data['user_action '] = $user." has logout";

		$data = $this->admin_model->AddNotification($Data);

		$this->session->sess_destroy();
		unset($_SESSION['UserDetails']);
		redirect(base_url().'user');
	}

	public function PatientDetails($id)
	{


		$SendData['patientDetails'] = $this->admin_model->getPatientById($id);
		
		//$SendData['patientDetails'][0]->hospital_name = $this->hospital_model->getHospitalById($SendData['patientDetails'][0]->hospital_id)[0]->hospital_name;
		$user_detail_id = $this->session->userdata('UserDetail_Id');
		 $role = $this->session->userdata('roleId');
		
		 $details = $this->admin_model->getTestDetailsByPatientId($id,"","",$role,$user_detail_id);

		 foreach($details as $detail){
		 	$detail->test_doctor_report = $this->admin_model->GetDoctorsByTestId($detail->test_id);
		 }

		 $SendData['patientDetails'][0]->test_details = $details;

		if($role == 2){
		 $SendData['userDataID'] = $user_detail_id;
		}
		
		/*if(!empty($SendData['patientDetails'][0]->test_details)){
			$SendData['patientDetails'][0]->doctor_name = $this->doctor_model->GetDoctorDetails($SendData['patientDetails'][0]->test_details[0]->doctor_id)[0]->doctor_name;
		}else{
			$SendData['patientDetails'][0]->doctor_name = "Doctor not assigned";

		}*/
		
		/*$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
		$SendData['patientDetails'][0]->Client_case_number_barcode =  base64_encode($generator->getBarcode($SendData['patientDetails'][0]->Client_case_number, $generator::TYPE_CODE_128));

		$SendData['patientDetails'][0]->visiopath_case_number_barcode =  base64_encode($generator->getBarcode($SendData['patientDetails'][0]->visiopath_number, $generator::TYPE_CODE_128));*/
		
		
		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

			
			
		//$SendData['Barcode']  = 

		

		$this->load->view('patientdetails',$SendData);
	}

	
		
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */