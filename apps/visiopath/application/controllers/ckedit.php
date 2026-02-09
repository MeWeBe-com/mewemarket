<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ckedit extends CI_Controller {

	
	public function index()
	{
	
		$this->load->view('editor');
	}

	public function Data()
	{
	
		$data = $this->input->post();

		print_r($data);
	}

	
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */