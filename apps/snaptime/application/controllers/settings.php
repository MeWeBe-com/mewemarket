<?php
defined('BASEPATH') or exit('No direct script access allowed');

class settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('username')) {
            redirect('login');
        }
    }
    public function index()
    {
        $this->load->view('settings');
    }
}

?>