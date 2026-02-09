<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class private_area extends CI_Controller {
 public function __construct()
 {
  parent::__construct();

  if(!$this->session->userdata('username'))
  {
     redirect('login');
  }
 }

 public function home()
 {
    $Senddata['suppliers'] = $this->supplier_model->GetLatestSupplier();
    $Senddata['projects'] = $this->supplier_model->GetLatestProjects();
    $this->load->view('home',$Senddata);
 }

 function logout()
 {
  $data = $this->session->all_userdata();
     if($this->session->userdata('role') == 'Supplier') {
         $this->log_model->add_log('logout','supplier');
     }elseif($this->session->userdata('role') == '0')
     {
         $this->log_model->add_log('logout','users');
     }
  foreach($data as $row => $rows_value)
  {
   $this->session->unset_userdata($row);
  }
  redirect('login');
 }

}

?>