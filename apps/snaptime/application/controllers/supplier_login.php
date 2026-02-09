<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class supplier_login extends CI_Controller {

 public function __construct()
 {
  parent::__construct();
  if($this->session->userdata('id'))
  {
   redirect('dashboard');
  }
  $this->load->library('form_validation');
  $this->load->model('supplier_login_model');
  $this->load->model('log_model');
 }

 function index()
 {
        $this->load->view('supplier_login');
 }

 function validation()
 {
  $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email');
  $this->form_validation->set_rules('password', 'Password', 'required');
  if($this->form_validation->run())
  {
   $result = $this->supplier_login_model->can_login($this->input->post('email'), $this->input->post('password'),$this->input->post('company_id'));

   if($result == 'true')
   {
       $this->log_model->add_log('successfully login','supplier');
    redirect('dashboard/');
   }
   else
   {
    $this->session->set_flashdata('message',$result);
    redirect('login');
   }
  }
  else
  {
   $this->index();
  }
 }

  public function ForgetPassword()
 {
    $this->load->view('supplier/forget');
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

 public function ForgetValidation()
 {
    $data = $this->input->post('email');
    $token = $this->getToken(16);

    $result = $this->supplier_model->checkEmail($data);

    if(!empty($result)){

        $this->load->library('event');

        $Content = array();

        $Content['token'] = $token ;

        $datas['to'] = $this->input->post('email');

        $datas['subject'] = 'Account Password Reset - Scruffy';

        $datas['body'] = $this->load->view('emails/supplierresetpassword',$Content, true);

        $this->event->email($datas);

      //update token to the email 

      $this->supplier_model->updateEmailWithToken($data,$token);

      //redirect to the page
      redirect('supplier_login/ForgetPassword?CheckEmail');

    }else{
      //redirect to the page if not found
      //redirect to the page
      redirect('supplier_login/ForgetPassword?EmailError');
    }

 }

  public function VerifyUserEmailForPassword($token)
  {
    $Senddata['userdata'] = $this->supplier_model->GetUserDetailsByToken($token);

    if(empty($Senddata['userdata'])){
      redirect('supplier_login/ForgetPassword?EmailError');
    }

    $this->load->view('supplier/changepassword',$Senddata);
  }

  public function ChangePassword($user_id)
  {
    $password = $this->input->post('password');

    $posteddata['password'] = $password;
    $posteddata['verification_key'] = '';

    $this->supplier_model->ChangePasswordById($posteddata,$user_id);

     redirect('supplier_login?success');
  }

}

?>