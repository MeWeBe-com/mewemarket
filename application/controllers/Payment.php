<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class payment extends CI_Controller
{

	var $data;

	function __construct()
	{
		parent::__construct(); // needed when adding a constructor to a controller

		$this->load->library('paypal_lib');

		//$this->data can be accessed from anywhere in the controller for adding sidebar on the view page.
	}

	public function index()
	{

	}

	function BuyProduct($product_id, $id ,$package_id)
	{

		$product = $this->general->SelectQueryWithClause('products', 'product_id', $product_id);
		$user = $this->general->SelectQueryWithClause('users', 'user_id', $id);
		$package = $this->general->SelectQueryWithClause('packages', 'package_id', $package_id);

		$returnURL = base_url() . 'payment/success/'; //payment success url

		$failURL = base_url() . 'payment/fail'; //payment fail url

		$notifyURL = base_url() . 'payment/ipn/' . $product_id . '/' . $id. '/' . $package_id; //ipn url

		$userID = $user[0]->user_id; //current user id

		//$logo = base_url() . 'https://www.mewemarket.com/assets/img/illustrations/logo.png';

		$this->paypal_lib->add_field('cmd', '_xclick-subscriptions');

		$this->paypal_lib->add_field('return', $returnURL);

		$this->paypal_lib->add_field('fail_return', $failURL);

		$this->paypal_lib->add_field('notify_url', $notifyURL);

		$this->paypal_lib->add_field('item_name', $product[0]->product_name);

		$this->paypal_lib->add_field('listing_id', $product[0]->product_id);

		$this->paypal_lib->add_field('item_number', $product[0]->product_id);

		$this->paypal_lib->add_field('amount', $package[0]->package_amount);

		// Monthly Payment to charge
		$this->paypal_lib->add_field('quantity_1', 1);
		
		$this->paypal_lib->add_field('a3', $package[0]->package_amount);
		// Charge amount on which date ?
		$this->paypal_lib->add_field('p3', 1);
		// Charge on monthly or weekly or daily
		$this->paypal_lib->add_field('t3', "M");

		$this->paypal_lib->add_field('subscr_id', $product[0]->product_id);
		$this->paypal_lib->add_field('subscr_u_id', $this->session->userdata('user_id'));

		// Extra
		$this->paypal_lib->add_field('src', 1);
		$this->paypal_lib->add_field('sra', 1);
		$this->paypal_lib->add_field('first_name', $this->session->userdata('user_name'));
		$this->paypal_lib->add_field('email', $this->session->userdata('user_email'));

		//$this->paypal_lib->image($logo);

		$this->paypal_lib->paypal_auto_form();

	}

	function UpdateProduct($product_id, $id ,$package_id)
	{
		$product = $this->general->SelectQueryWithClause('products', 'product_id', $product_id);
		$user = $this->general->SelectQueryWithClause('users', 'user_id', $id);
		$package = $this->general->SelectQueryWithClause('packages', 'package_id', $package_id);

		$returnURL = base_url() . 'payment/success/'; //payment success url

		$failURL = base_url() . 'payment/fail'; //payment fail url

		$notifyURL = base_url() . 'payment/ipn/' . $product_id . '/' . $id. '/' . $package_id; //ipn url

		$userID = $user[0]->user_id; //current user id

		//$logo = base_url() . 'https://www.mewemarket.com/assets/img/illustrations/logo.png';

		$this->paypal_lib->add_field('cmd', '_xclick-subscriptions');

		$this->paypal_lib->add_field('return', $returnURL);

		$this->paypal_lib->add_field('fail_return', $failURL);

		$this->paypal_lib->add_field('notify_url', $notifyURL);

		$this->paypal_lib->add_field('item_name', $product[0]->product_name);

		$this->paypal_lib->add_field('listing_id', $product[0]->product_id);

		$this->paypal_lib->add_field('item_number', $product[0]->product_id);

		$this->paypal_lib->add_field('amount', $package[0]->package_amount);

		// Monthly Payment to charge
		$this->paypal_lib->add_field('quantity_1', 1);

		$this->paypal_lib->add_field('a3', $package[0]->package_amount);
		// Charge amount on which date ?
		$this->paypal_lib->add_field('p3', 1);
		// Charge on monthly or weekly or daily
		$this->paypal_lib->add_field('t3', "M");

		$this->paypal_lib->add_field('subscr_id', $product[0]->product_id);
		$this->paypal_lib->add_field('subscr_u_id', $this->session->userdata('user_id'));

		// Extra
		$this->paypal_lib->add_field('src', 1);
		$this->paypal_lib->add_field('sra', 1);
		$this->paypal_lib->add_field('first_name', $this->session->userdata('user_name'));
		$this->paypal_lib->add_field('email', $this->session->userdata('user_email'));

		//$this->paypal_lib->image($logo);

		$this->paypal_lib->paypal_auto_form();

	}

	function success()
	{
		$this->load->view('user/paymentcompleted');
	}

	public function ipn($product_id, $user_id,$package_id)
	{

		//$this->product->UpdateSales($product_id);

		$User = $this->user->GetUserDetails($user_id);
		$Product = $this->product->GetProductsByProductId($product_id);
		$Apidata = new stdClass();
		$data = array(
			'company_name'  => $User->company_name,
			'first_name' 	=> $User->first_name,
			'last_name' 	=> $User->last_name,
			'email' 		=> $User->user_email,
			'password' 		=> $User->original_password,
			'role' 			=> '1',
			'phone' 		=> $User->contact_number,
		);

		$Exist = $this->product->CheckProductOfUserExist($product_id,$user_id,$package_id);

		if(empty($Exist)){

			if($Product[0]->api_type == 'saas_app') {

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => $Product[0]->api_url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => "" . json_encode($data) . "",
					CURLOPT_HTTPHEADER => array(
						"Content-Type: application/json",
					),
				));

				$response = curl_exec($curl);
				curl_close($curl);

				$Apidata = json_decode($response);
			}elseif($Product[0]->api_type == 'normal_app'){
				$Apidata->url = $Product[0]->api_url.$User->company_name;
			}else{
				$Apidata->url = "hello";
			}
		}else{
			$Apidata->url = $Exist[0]->app_url;
		}
	
		$currenttime = date_create()->format('Y-m-d H:i:s');

		//$due_dates = mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"));
		$due_dates = mktime(0, 0, 0, date("m") + 1, date("d") , date("Y"));
		$due_date = date('Y-m-d H:i:s', ($due_dates));

		if(!empty($_REQUEST)){

			$PostedData['user_id'] = $user_id;
			$PostedData['product_id'] = $_REQUEST['item_number'];
			$PostedData['package_amount'] = $_REQUEST['mc_amount3'];
			$PostedData['subscription_id'] = $_REQUEST['subscr_id'];
			$PostedData['status'] = 'activate';
			$PostedData['billing_log'] = json_encode($_REQUEST);
			$PostedData['billing_date'] = $currenttime;
			$PostedData['billing_due_date'] = $due_date;
			$PostedData['app_url'] = $Apidata->url;
			$PostedData['package_id'] = $package_id;
			$this->general->InsertQuery('billing', $PostedData);

		}

		if (!empty($_REQUEST['mc_amount3'])) {

			$Content = array();
			$Content['heading'] = "Dear Sir /Madam,";
			$Content['secondHeading'] = "You have successfully paid for '".$_REQUEST['item_name']."' tool.";
			$Content['thirdHeading'] = "Your next billing date is: '" . date('d-m-Y', $due_dates) . "'.";

			$Content['TextLineOne'] = "Please log in to : " . base_url();
			$Content['TextLineTwo'] = "App Url : " .$Apidata->url;
			$Content['TextLineThree'] = "Username : " .$User->first_name;
			$Content['TextLineFourth'] = "Email : " .$User->user_email;
			$Content['TextLineFifth'] = "Password : " .$User->original_password;

			$data['to'] = $User->user_email;
			$data['subject'] = 'Payment Notification - Received Payment Success';
			$data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$this->event->email($data);

			/*$Html = "<div>Dear Sir /Madam,</div> <br /> ";
			$Html .= "<div>You have successfully paid for '" . $_REQUEST['item_name'] . "' tool.</div> <br /> ";
			$Html .= "<div>Now you can use this tool.</div> <br />";
			$Html .= "<div>Your next billing date is: '" . date('d-m-Y', $due_dates) . "'.</div> <br />";
			$Html .= "<div>Please log in to : " . base_url() . '</div> <br />';
			$Html .= "<div>App Url : " .$Apidata->url. '</div> <br />';
			$Html .= "<div>Username : " .$User->first_name. '</div> <br />';
			$Html .= "<div>Email : " . $User->user_email . '</div> <br />';
			$Html .= "<div>Password : " . $User->original_password . '</div> <br />';
			$Html .= "<div>If you have any queries please don't hesitate to contact us. </div> <br />";
			$Html .= "<div>Regards,</div> ";
			$Html .= "<div>Mewemarket</div> <br />";

			$this->load->library('email');
			$this->email->from('yaze.live@gmail.com', 'Mewemarket.com NoReply');
			$this->email->set_mailtype("html");
		    $this->email->to($this->session->userdata('user_email'));
			//	$this->email->to('haseeb.idevation@gmail.com');
			$this->email->subject('Payment Notification - Received Payment Success');
			$this->email->message($Html);
			$sent = $this->email->send();*/
		}

	}

	public function PaymentCompleted(){
		$this->load->view('user/paymentcompleted');
	}

	public function CancelSubscription(){
		
		$token = $this->GetToken();
		$id = 'I-DF1YFRWB3NKC';

		$data = array('reason' => 'Admin Suspend');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.sandbox.paypal.com/v1/billing/subscriptions/".$id."/suspend");
		curl_setopt($ch, CURLOPT_HEADER, array(
			"Content-Type: application/json",
			"Authorization: Bearer " . $token->access_token,
		));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		$result = curl_exec($ch);
		curl_close($ch);

		echo json_decode($result);
	}

	function GetToken(){
		$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api-m.sandbox.paypal.com/v1/oauth2/token",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "grant_type=client_credentials",
			CURLOPT_HTTPHEADER => array(
			"Accept: application/json",
			"Accept-Language: en_US",
			"Authorization: Basic QWUxNDQ0ZDFrRE41X0NxZ1FfM2kxMjJULXdlazE0a29LZUxQTmJoYk40TE83U00xT3dydl9lclNseUVEd2k3R2wwTi1maG05V181b0QxM1M6RUZvYlpTbHhNUkRUNzlmYmlqenNlYzk5QmVXQ3JpVVliemxoYV9OR3A4UmJTaU8wajN0UG53NDR5aUhYNjZJOXJLdFRyME1oMXRGN0VjYUM=",
			"Content-Type: application/x-www-form-urlencoded",
			),
		));

		$response = curl_exec($curl);


		curl_close($curl);
		return json_decode($response);
	}

	public function SuspendMySubscription($status){

		$token = $this->GetToken();
		$id = 'I-DF1YFRWB3NKC';

		$data = array('reason' => 'Admin Suspend');

			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://www.sandbox.paypal.com/v1/billing/subscriptions/".$id."/".$status,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "" . json_encode($data) . "",
			CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json",
			"Authorization: Bearer " . $token->access_token,
			),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			echo ($response);
	}

	public function MySubscription($subs_id,$status,$product_id){

		$token = $this->GetToken();

			if($status == "cancel"){
				$data = array('reason' => 'Admin Cancel');
			}else{
				$data = array('reason' => 'Admin Suspend');
			}

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://www.sandbox.paypal.com/v1/billing/subscriptions/".$subs_id."/".$status,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "" . json_encode($data) . "",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Authorization: Bearer " . $token->access_token,
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		//echo ($response);

		$PostedData['status'] = $status;
		$this->general->UpdateQuery('billing','subscription_id',$subs_id,$PostedData);

		if($this->session->userdata('role')  == 1){
			redirect(base_url('admin'));
		}else{
			redirect(base_url('users/dashboard'));
		}

	}

	public function Vpn($product_id, $user_id)
	{
		$User = $this->user->GetUserDetails($user_id);
		$Product = $this->product->GetProductsByProductId($product_id);

		$data = array(
			'company_name'  => $User->company_name,
			'first_name' 	=> $User->first_name,
			'last_name' 	=> $User->last_name,
			'email' 		=> $User->user_email,
			'password' 		=> $User->user_password,
			'role' 			=> '1',
			'phone' 		=> $User->contact_number,
		);

		$Exist = $this->product->CheckProductOfUserExist($product_id,$user_id);

		if(empty($Exist)){

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $Product[0]->api_url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "" . json_encode($data) . "",
				CURLOPT_HTTPHEADER => array(
					"Content-Type: application/json",
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);

			$Apidata = json_decode($response);
		}
	
		$currenttime = date_create()->format('Y-m-d H:i:s');

		$due_dates = mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"));
		$due_date = date('Y-m-d H:i:s', ($due_dates));
		
			$PostedData['user_id'] = $user_id;
			$PostedData['product_id'] = "11";
			$PostedData['package_amount'] = "1.00";
			$PostedData['subscription_id'] = "asdf123";
			$PostedData['status'] = 'activate';
			$PostedData['billing_log'] = json_encode($PostedData);
			$PostedData['billing_date'] = $currenttime;
			$PostedData['billing_due_date'] = $due_date;
			$PostedData['app_url'] = $Apidata->url;

			$this->general->InsertQuery('billing', $PostedData);
	}


}
