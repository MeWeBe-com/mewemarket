<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class page extends CI_Controller {

	public function index()
	{

		$SendData['categories'] =  $this->general->SelectQueryWithClause('categories','visibility','1');

		$this->load->view('about',$SendData);
	}

	public function terms()
	{
		$this->load->view('terms');
	}

	
}
