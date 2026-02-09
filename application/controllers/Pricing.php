<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pricing extends CI_Controller {

	public function index()
	{
		$GetData['packages'] = $this->general->SelectQuery('packages');
		$this->load->view('pricing',$GetData);
	}

	public function Buynow($token)
	{
		//c81e728d9d4c2f636f067f89cc14862c - basic
		//eccbc87e4b5ce2fe28308fd9f2a7baf3 - plus
		//a87ff679a2f3e71d9181a67b7542122c - pro

		print_r($token);


	}

}
