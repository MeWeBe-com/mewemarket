<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class users extends CI_Controller {

	public function index()
	{
		$this->load->view('index');
	}

	public function Verify()
	{
		$email =  $this->input->post('user_email');
		$password =  md5($this->input->post('user_password'));

		$Userdata = $this->user->CheckUserExist($email,$password);

		if(!empty($Userdata)){

			if($Userdata->status == 0){
				redirect(base_url('home?notactive'));
			}

			$UserDetails = array();
			$UserDetails["user_id"] 	= $Userdata->user_id;
			$UserDetails["company_name"] 	= $Userdata->company_name;
			$UserDetails["user_name"] 	= $Userdata->user_name;
			$UserDetails["first_name"] 	= $Userdata->first_name;
			$UserDetails["last_name"] 	= $Userdata->last_name;
			$UserDetails["user_email"] 	= $Userdata->user_email;
			$UserDetails["role"] 		= $Userdata->user_role;

			$this->session->set_userdata($UserDetails);
			redirect('home');

		}else{
			redirect(base_url('home?loginerror'));
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('home');
	}

	public function register()
	{
		$GetData['countries'] =  $this->general->SelectQuery('countries');
		$this->load->view('user/register',$GetData);
	}

	public function CreateUser()
	{
		$PostedData = $this->input->post();

		$DBData['company_name']  = $PostedData['company_name'];
		$DBData['first_name'] 	 = $PostedData['first_name'];
		$DBData['last_name'] 	 = $PostedData['last_name'];
		$DBData['user_email'] 	 = $PostedData['user_email'];
		$DBData['date_of_birth'] = $PostedData['date_of_birth'];
		$DBData['contact_number']= $PostedData['contact_number'];
		$DBData['country_id'] 	 = $PostedData['country'];
		$DBData['street'] 	 	 = $PostedData['street'];
		$DBData['state'] 		 = $PostedData['state'];
		$DBData['zip_code'] 	 = $PostedData['zip_code'];
		$DBData['user_role'] 	 = '0';
		$DBData['user_name'] 	 = $PostedData['user_name'];
		$DBData['user_password'] = md5($PostedData['user_password']);
		$DBData['original_password'] = $PostedData['user_password'];
		$DBData['status'] 		 = "1";

		$Response =  $this->general->InsertQuery('users',$DBData);

		if($Response != 'Fail'){

			$Content = array();

			$Content['heading'] = "Dear ".$PostedData['user_name'].',';
			$Content['secondHeading'] = "We’re glad you’re here! Following are your account details:";


			$Content['TextLineOne'] = "Email: ".$PostedData['user_email'];
			$Content['TextLineTwo'] = "Password: ".$PostedData['user_password'];

			$data['to'] = $PostedData['user_email'];
			$data['subject'] = 'Account Registration - MeweMarket';
			$data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$this->event->email($data);

		/*	$Html  = "<div>Dear ,</div> <br /> ";
			$Html  .= "<div>We’re glad you’re here! Following are your account details: </div> <br /> ";

			$Html .= "<div><strong>Email:</strong> '".$PostedData['user_email']."' </div> <br />";
			$Html .= "<div><strong>Password:</strong> '".$PostedData['user_password']."' </div> <br />";

			$Html .= "<div>Thank you for using our application! </div> <br />";

			$Html .= "<div>Regards,</div> ";
			$Html .= "<div>MeweMarket</div> <br />";

			$this->load->library('email');
			$this->email->from('yaze.live@gmail.com', 'MeweMarket.com NoReply');
			$this->email->set_mailtype("html");
			$this->email->to($PostedData['user_email']);
			//$this->email->to('haseeb.idevation@gmail.com');
			$this->email->subject('Account Registration - MeweMarket');
			$this->email->message($Html);
			$this->email->send();*/

			redirect(base_url('?RegisterSuccess'));
		}else{
			redirect(base_url('?Error'));
		}
	}

	public function ActivateTools()
	{

		$product_id = $this->input->get('product_id');

		$CheckUserTools = $this->user->CountUserTools($this->session->userdata('user_id'));

		if($CheckUserTools->Total < $this->session->userdata('tools_limit')){

			$DBData['product_id'] = $product_id;
			$DBData['user_id'] = $this->session->userdata('user_id');

			$Response =  $this->general->InsertQuery('user_products',$DBData);

			echo "Done";
		}else{
			echo "Limit Exceed";
		}
	}

	public function DeleteTools()
	{
		$product_id = $this->input->get('product_id');
		$response = $this->user->DeleteUserTool($this->session->userdata('user_id'),$product_id);
		if($response == 'Done'){
			echo "Done";
		}else{
			echo "Fail";
		}
	}

	public function ForgetPassword()
	{
		$this->load->view('user/forgetpassword');
	}

	public function VerifyEmailPassword()
	{
		$data = $this->input->post();

		$userdetails = $this->general->SelectQueryWithClause('users','user_email',$data['user_email']);

		if(empty($userdetails)){
			//error
			redirect(base_url('users/ForgetPassword?emailnotfound'));
		}else{
			$token = $this->getToken(16);

			$Content = array();

			$Content['heading'] = "Dear Sir / Madam,";
			$Content['secondHeading'] = "Click the link below  or simply copy this link and paste into your browser to change the password.";

			$Content['TextLineOne'] = "<a class='text' target='_blank' href='".base_url()."users/ChangPassword/".$token."' style='color:rgb(4,67,162); font-family:Poppins, Helvetica, Arial, sans-serif; font-size:13px; font-weight:600; font-style:normal;letter-spacing:1px; line-height:20px; text-transform:uppercase; text-decoration:underline; display:block'>
										Reset Your Password</a>";
			$Content['TextLineTwo'] = "If you did not request this password change, please ignore this email - your password will remain unaffected.";

			$data['to'] = $data['user_email'];
			$data['subject'] = 'Reset Password - MeweMarket';
			$data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$this->event->email($data);

			/*$Html  = "<div>Dear Sir / Madam,</div> <br /> ";
			$Html  .= "<div>Click the button below to reset your password. </div> <br /> ";

			$Html .= "<div><a href='".base_url()."users/ChangPassword/".$token."'>Click Here</a></div> <br />";
			$Html .= "<div>If you did not request this password change, please ignore this email - your password will remain unaffected.</div> <br />";

			$Html .= "<div>Regards,</div> ";
			$Html .= "<div>MeweMarket</div> <br />";

			$this->load->library('email');
			$this->email->from('yaze.live@gmail.com', 'MeweMarket.com NoReply');
			$this->email->set_mailtype("html");
			$this->email->to($data['user_email']);
			//$this->email->to('haseeb.idevation@gmail.com');
			$this->email->subject('Reset Password - MeweMarket');
			$this->email->message($Html);

			$sent = $this->email->send();*/

			$updateData['verification_key'] = $token;

			$this->general->UpdateQuery('users','user_email',$userdetails[0]->user_email,$updateData);

			redirect('users/ForgetPassword?Done');
		}
	}

	public function ChangPassword($token)
	{

		$userdetails = $this->general->SelectQueryWithClause('users','verification_key',$token);

		if(empty($userdetails)){
			//error
			redirect(base_url('users/ForgetPassword?notfound'));
		}else{
			$Senddata['userdetails'] = $userdetails;
			$Senddata['token'] = $token;
			$this->load->view('user/changepassword',$Senddata);
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

	function VerifyConfirmPassword(){

		$verification_key = $this->input->post('token');
		$updateData['original_password'] = $this->input->post('user_password');
		$updateData['user_password'] = md5($this->input->post('user_password'));
		$updateData['verification_key'] = "";

		$this->general->UpdateQuery('users','verification_key',$verification_key,$updateData);

		redirect(base_url().'?passwordChanged');
	}

	function Dashboard(){

		if(empty($this->session->userdata('user_id'))){
			redirect(base_url());
		}

		$SendData['billing_details'] = $this->product->GetBillingDetails($this->session->userdata('user_id'));
		$SendData['products'] = $this->product->GetProductsForUsersDetails($this->session->userdata('user_id'));
		$SendData['ActivateTools'] = $this->user->CountUserTools($this->session->userdata('user_id'),'activate');
		$SendData['SuspendTools'] = $this->user->CountUserTools($this->session->userdata('user_id'),'suspend');
		$SendData['CancelTools'] = $this->user->CountUserTools($this->session->userdata('user_id'),'cancel');

		if(!empty($this->session->userdata('user_id'))){
			$SendData['userproducts'] =  $this->product->UserProducts($this->session->userdata('user_id'));
		}else{
			$SendData['userproducts'] =  array();
		}

		$this->load->view('user/dashboard',$SendData);
	}

	public function Purchases()
	{
		if(empty($this->session->userdata('user_id'))){
			redirect(base_url());
		}

		$config['base_url'] = base_url('users/purchases');
		$counts = $this->product->GetCountrows('billing','user_id',$this->session->userdata('user_id'));
		$config['total_rows'] = $counts[0]->total;
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;

		$config['full_tag_open'] = '<div>';
		$config['full_tag_close'] = '</div>';

		$config['first_tag_open'] = '<button class="btn btn-falcon-default btn-sm mr-1 mr-sm-2 px-0 py-0">';
		$config['first_tag_close'] = '</button>';

		$config['prev_tag_open'] = '<li class="btn btn-sm btn-falcon-default text-primary mr-2 px-0 py-0">';
		$config['prev_tag_close'] = '</li>';

		$config['num_tag_open'] = '<li class="btn btn-sm btn-falcon-default text-primary mr-2 px-0 py-0">';
		$config['num_tag_close'] = '</li>';

		$config['next_tag_open'] = '<li class="btn btn-sm btn-falcon-default text-primary mr-2 px-0 py-0">';
		$config['next_tag_close'] = '</li>';

		$config['last_tag_open'] = '<button class="btn btn-falcon-default btn-sm mr-1 mr-sm-2 px-0 py-0">';
		$config['last_tag_close'] = '</button>';

		$config['cur_tag_open'] = '<li class="btn btn-falcon-default btn-sm mr-1 mr-sm-2 active "><a href="javascript:;">';
		$config['cur_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$SendData['pagination'] = $this->pagination->create_links();

		$SendData['products'] = $this->product->UserPurchasedProducts($this->session->userdata('user_id'),$config['per_page'],$page);


		$this->load->view('user/purchases',$SendData);
	}

	function Setting($id){

		if(empty($this->session->userdata('user_id'))){
			redirect(base_url());
		}

		if($this->session->userdata('role') == 1){

		}else if($id != $this->session->userdata('user_id')){
			redirect(base_url());
		}

		$SendData['countries'] =  $this->general->SelectQuery('countries');
		$SendData['user_details'] = $this->general->SelectQueryWithClause('users','user_id',$id);

		$this->load->view('user/setting',$SendData);
	}

	public function AddtoFavourite()
	{

		if(empty($this->session->userdata('user_id'))){
			echo "Please Login";
		}else{
				$product_id = $this->input->get('product_id');

				$DBData['product_id'] = $product_id;
				$DBData['user_id'] = $this->session->userdata('user_id');

				$Response =  $this->general->InsertQuery('user_favourite',$DBData);

				echo "Done";
		}
	}

	public function RemoveFromFavourite()
	{

			$product_id = $this->input->get('product_id');

			$DBData['product_id'] = $product_id;

			$Response =  $this->general->RemoveFavourite($product_id);

			echo "Done";

	}

	public function Favourites()
	{
		if(empty($this->session->userdata('user_id'))){
			redirect(base_url());
		}

		if(!empty($this->session->userdata('user_id'))){
			$SendData['userproducts'] =  $this->product->UserProducts($this->session->userdata('user_id'));
		}else{
			$SendData['userproducts'] =  array();
		}

		if(!empty($this->session->userdata('user_id'))){
			$SendData['userfavourite'] =  $this->product->UserFavourites($this->session->userdata('user_id'));
		}else{
			$SendData['userfavourite'] =  array();
		}

		$config['base_url'] = base_url('users/favourites');
		$counts = $this->product->GetCountrows('user_favourite','user_id',$this->session->userdata('user_id'));
		$config['total_rows'] = $counts[0]->total;
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;

		$config['full_tag_open'] = '<div>';
		$config['full_tag_close'] = '</div>';

		$config['first_tag_open'] = '<button class="btn btn-falcon-default btn-sm mr-1 mr-sm-2 px-0 py-0">';
		$config['first_tag_close'] = '</button>';

		$config['prev_tag_open'] = '<li class="btn btn-sm btn-falcon-default text-primary mr-2 px-0 py-0">';
		$config['prev_tag_close'] = '</li>';

		$config['num_tag_open'] = '<li class="btn btn-sm btn-falcon-default text-primary mr-2 px-0 py-0">';
		$config['num_tag_close'] = '</li>';

		$config['next_tag_open'] = '<li class="btn btn-sm btn-falcon-default text-primary mr-2 px-0 py-0">';
		$config['next_tag_close'] = '</li>';

		$config['last_tag_open'] = '<button class="btn btn-falcon-default btn-sm mr-1 mr-sm-2 px-0 py-0">';
		$config['last_tag_close'] = '</button>';

		$config['cur_tag_open'] = '<li class="btn btn-falcon-default btn-sm mr-1 mr-sm-2 active "><a href="javascript:;">';
		$config['cur_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$SendData['pagination'] = $this->pagination->create_links();

		$user_id = $this->session->userdata('user_id');
		$SendData['products'] = $this->product->GetFavouritesForUsersDetails($this->session->userdata('user_id'),$config['per_page'],$page);

		$this->load->view('user/favourites',$SendData);

	}

	public function AddNewUser()
	{

		$Userdata = $this->input->post();

		$PostedData['first_name'] =  $Userdata['first_name'];
		$PostedData['last_name'] =  $Userdata['last_name'];
		$PostedData['user_email'] =  $Userdata['user_email'];
		$PostedData['contact_number'] =  $Userdata['contact_number'];
		$PostedData['street'] =  $Userdata['street'];

		$PostedData['state'] =  $Userdata['state'];
		$PostedData['zip_code'] =  $Userdata['zip_code'];
		$PostedData['country_id'] =  $Userdata['country_id'];

		$PostedData['user_name'] =  $Userdata['user_name'];

		if(!empty($Userdata['user_password'])){
			$PostedData['user_password'] =  $Userdata['user_password'];
		}

		if(!empty($Userdata['user_id'])){
			$this->general->UpdateQuery('users','user_id',$Userdata['user_id'],$PostedData);
			redirect(base_url('users/setting/'.$Userdata['user_id'].'?update'));
		}else{
			$this->general->InsertQuery('users',$PostedData);
			redirect(base_url('users/setting/'.$Userdata['user_id'].'?inserted'));
		}



	}

	public function ThemeMode($mode)
	{
		$this->input->set_cookie('theme_mode',$mode,time()+60*60*24*30 );

		if($mode == 2){
			echo "Dark Mode Start";
		}else{
			echo "Light Mode Start";
		}
	}

	public function Mail()
	{
		$Content = array();

		$Content['heading'] = "Dear Haseeb,";
		$Content['secondHeading'] = "Admin just created new Job in your institution";
		$Content['thirdHeading'] = "Please login and review";

		$Content['TextLineOne'] = "Please login and review";

		$data['to'] = "haseeb.idevation@gmail.com";
		$data['subject'] = 'Checking Email MeweMarket';
		$data['body'] = $this->load->view('emails/generalEmail - Copy',$Content, true);
		$this->event->email($data);

	}

	public function Mails(){
		$Html  = "<div>Dear haseeb,</div> <br /> ";
		$Html  .= "<div>We’re glad you’re here! Following are your account details: </div> <br /> ";

		$Html .= "<div><strong>Email:</strong> 'haseeb.idevation@gmail.com' </div> <br />";
		$Html .= "<div><strong>Password:</strong> Winixsun/1 </div> <br />";

		$Html .= "<div>Thank you for using our application! </div> <br />";

		$Html .= "<div>Regards,</div> ";
		$Html .= "<div>MeweMarket</div> <br />";

		$this->load->library('email');
		$this->email->from('yaze.live@gmail.com', 'MeweMarket.com NoReply');
		$this->email->set_mailtype("html");
		//$this->email->to($PostedData['user_email']);
		$this->email->to('haseeb.idevation@gmail.com');
		$this->email->subject('Account Registration - Mewemarket');
		$this->email->message($Html);
		$this->email->send();
	}

	public function CheckUserMail($email){

		$user =  $this->general->CheckUserEmail($email);

		if(!empty($user)){
			echo "Exist";
		}else{
			echo "Not Exist";
		}
	}

	public function profile($id = NULL){

		if(empty($id)){
			$userid = $this->session->userdata('user_id');
		}else{
			$userid = $id;
		}

		$Content['userDetails'] =  $userDetails =  $this->user->GetUserDetails($userid);
		$Content['billing_details'] = $this->product->GetProductsForUsersDetails($userid);
		$Content['favourites'] = $this->product->UserFavourites($userid);

		$this->load->view('user/profile',$Content);
	}

	public function Support()
	{
		$this->load->view('user/support');
	}

	public function verifySupport()
	{

		$data = $this->input->post();

		$Content = array();

		$Content['heading'] = "Dear Admin,";
		$Content['secondHeading'] = "User need support on mewemarket ";
		$Content['thirdHeading'] = "Check details below: ";

		$Content['TextLineOne'] = "Fullname: ".$data['full_name'];
		$Content['TextLineTwo'] = "Email: ".$data['email'];
		$Content['TextLineThree'] = "Subject: ".$data['subject'];
		$Content['TextLineFourth'] = "Message: ".$data['message'];

		$data['to'] = "yaze.live@gmail.com";
		$data['subject'] = 'User Support - Mewemarket';
		$data['body'] = $this->load->view('emails/generalEmail - Copy',$Content, true);
		$this->event->email($data);

		redirect('users/Support?Done');
	}



}
