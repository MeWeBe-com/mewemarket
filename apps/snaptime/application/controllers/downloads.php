<?php
defined('BASEPATH') or exit('No direct script access allowed');

class downloads extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('username')) {
            redirect('login');
        }
    }

    public function server_time()
    {
        echo date("h:i:s");
    }

    public function index()
    {

        $this->load->view('download');
    }



}

?>