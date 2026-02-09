<?php
session_start();
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');


include('lib/barcode/vendor/picqer/php-barcode-generator/src/BarcodeGenerator.php');
include('lib/barcode/vendor/picqer/php-barcode-generator/src/BarcodeGeneratorPNG.php');

class login extends CI_Controller {

	
	public function index($slug = NULL)
	{

		if(empty($slug)){
            $slug = 'demo';
            $Companydata = $this->user_model->GetCompanyNameAndID($slug);
        }else{
            $Companydata = $this->user_model->GetCompanyNameAndID($slug);
        }

		if(empty($Companydata)){
            $Data['company_id'] = '1';
            $Data['company_name'] = 'Demo';
            $Data['company_slug'] = 'demo';
            $this->session->set_userdata('company_logo','logo.png');

            redirect(base_url().'login/demo?companyerror');
        }else{
            $Data['company_id'] = $Companydata[0]->id;
            $Data['company_name'] = $Companydata[0]->company_name;
            $Data['company_name'] = $Companydata[0]->company_name;

            if(!empty($Companydata[0]->company_logo)){
                $this->session->set_userdata('company_logo',$Companydata[0]->company_logo);
            }else{
                $this->session->set_userdata('company_logo','logo.jpg');
            }
        }

		$this->load->view('index',$Data);
	}

	public function logout($slug)
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


		redirect(base_url().'login/index/'.$slug);
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */