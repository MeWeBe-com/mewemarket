<?php
session_start();
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');


include('lib/barcode/vendor/picqer/php-barcode-generator/src/BarcodeGenerator.php');
include('lib/barcode/vendor/picqer/php-barcode-generator/src/BarcodeGeneratorPNG.php');

class logout extends CI_Controller {

	public function index($slug)
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


		redirect(base_url().'login/'.$slug);
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */