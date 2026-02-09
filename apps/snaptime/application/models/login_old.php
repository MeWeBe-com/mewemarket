<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {

	public function index()
	{

		$this->load->view('login.php');
	}

	public function register()
	{
		$this->load->view('signup');
	}

	public function registeruser()
	{
		$data = $this->input->post();

		$PostedData['user_name'] = $data['user_name'];
		$PostedData['user_email'] = $data['user_email'];
		$PostedData['user_password'] = md5($data['user_password']); 

		$token = $this->getToken(14);

		$PostedData['user_token'] = $token; 

		$user = $this->user_model->AddNewUser($PostedData);

		$config = Array(
			        'protocol' => 'smtp',
			        'smtp_host' => 'mail.yaze.live',
			        'smtp_port' => 587,
			        'smtp_user' => 'info@yaze.live',    //email id
			        'smtp_pass' => '1000@Dollar',       // password
			        'mailtype'  => 'html', 
			        'charset'   => 'iso-8859-1'
			    );
			    $this->load->library('email', $config);
			    $this->email->set_newline("\r\n");

			    $this->email->from('info@yaze.live','Biz Directory');
			    $this->email->to("haseeb.idevation@gmail.com");
			    //$this->email->to($data['user_email']);
			    
			    $this->email->subject('Please confirm your email address');   

			      $Html  = "<div>Thanks for creating a Bizdirectory.live account!</div> <br /> ";
			      $Html .= "<div>You can now login in with the email address: ".$data['user_email'].".";
			      $Html .= "<div>To finish the registration process, you just need to verify your email address.</div> ";

			      $Html .= "<a href='".base_url()."/login/VerifyUserEmail/".$token."'>Verify Email Address</a>";

			    $this->email->message($Html);

			    echo $result = $this->email->send();

		if($user != 'Fail'){
			redirect('user/login?Success');
		}
	}

	function getToken($length){
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet);

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[random_int(0, $max-1)];
    }

    return $token;
}

	public function Verify()
	{
		$data = $this->input->post();

		$PostedData['user_email'] = $data['user_email'];
		$PostedData['user_password'] = md5($data['user_password']);

		$user = $this->user_model->userLogin($PostedData);

		if(!empty($user)){

	        $UserDetails = array();
			$UserDetails["id"] = $user[0]->id;
			$UserDetails["user_detail_id"] = $user[0]->user_detail_id;
			$UserDetails["admin_id"] = $data[0]->admin_id;
			$UserDetails["username"] = $data[0]->first_name." ".ucfirst(substr($data[0]->middle_name, 0,1)).". ".$data[0]->last_name;
			$UserDetails["first_name"] = $data[0]->first_name;
			$UserDetails["middle_name"] = $data[0]->middle_name;
			$UserDetails["last_name"] = $data[0]->last_name;
			$UserDetails["email"] = $data[0]->email;
			$UserDetails["phone"] = $data[0]->phone;
			$UserDetails["type"] = $data[0]->type;


			$this->session->set_userdata($UserDetails);

			redirect('users/home');

        }else{
        	
					
			redirect('user/login'."?error");

        }
		
	}



}
