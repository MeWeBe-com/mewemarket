<?php
defined('BASEPATH') or exit('No direct script access allowed');

class login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('id')) {
            redirect('dashboard');
        }
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('company_model');
        $this->load->model('log_model');
    }

    public function index($company_name = '')
    {
        $this->session->set_userdata('previous_url', current_url());
        $data['company'] = $this->company_model->get_by_name($company_name);
        $this->load->view('login',$data);
    }

   public function validation()
    {
        $previous_url = $this->session->userdata('previous_url');
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run()) {

            $result = $this->login_model->can_login($this->input->post('email'), $this->input->post('password'), $this->input->post('company_id'));

            if ($result == 'true') {
                if ($this->session->userdata('role') == '0') {
                    $this->log_model->add_log('successfully login', 'users');
                }
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('message', $result);
                redirect($previous_url);
            }
        } else {
            $this->index();
        }
    }

    public function ForgetPassword()
    {
        $this->load->view('forget');
    }

    function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }

    public function ForgetValidation()
    {
        $data = $this->input->post('email');
        $token = $this->getToken(16);

        $result = $this->user_model->checkEmail($data);

        if (!empty($result)) {

            $this->load->library('event');

            $Content = array();

            $Content['token'] = $token;

            $datas['to'] = $this->input->post('email');

            $datas['subject'] = 'Account Password Reset - Scruffy';

            $datas['body'] = $this->load->view('emails/resetpassword', $Content, true);

            $this->event->email($datas);


            $this->user_model->updateEmailWithToken($data, $token);

            //redirect to the page
            redirect('login/ForgetPassword?CheckEmail');

        } else {
            //redirect to the page if not found
            //redirect to the page
            redirect('login/ForgetPassword?EmailError');
        }

    }

    public function VerifyUserEmailForPassword($token)
    {
        $Senddata['userdata'] = $this->user_model->GetUserDetailsByToken($token);

        if (empty($Senddata['userdata'])) {
            redirect('login/ForgetPassword?EmailError');
        }

        $this->load->view('changepassword', $Senddata);
    }

    public function ChangePassword($user_id)
    {
        $password = md5($this->input->post('password'));

        $posteddata['password'] = $password;
        $posteddata['verification_key'] = '';

        $this->user_model->ChangePasswordById($posteddata, $user_id);

        redirect('login?success');
    }

    public function dummyLogin()
    {

        $this->load->view('dummyLogin');
    }


}

?>