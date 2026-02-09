<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class workgallery extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('project_model');
        $this->load->model('supplier_model');
        $this->load->model('sub_project_model');
        $this->load->model('task_model');
        $this->load->model('time_check_model');
        $this->load->model('supplier_relation_model');
        $this->load->model('supplier_screenshots_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->model('log_model');
        $this->load->library('form_validation');

        if (empty($this->session->userdata('id'))) {
            redirect(base_url());
        }
    }

    public function index()
    {
        if ($this->session->userdata('role') == 'Supplier') {
           $supplier_id = $this->session->userdata('id');
       } else {
           $supplier_id = '';
       }

    	$data['projects'] = $this->supplier_relation_model->GetAllProjectsScreenshot($supplier_id);

		$this->load->view('workgallery/index', $data);
    }


}
