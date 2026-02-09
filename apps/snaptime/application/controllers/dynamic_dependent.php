<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dynamic_dependent extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sub_project_model');
        $this->load->model('task_model');
        $this->load->model('log_model');
        $this->load->model('supplier_screenshots_model');
        $this->load->model('sub_task_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    function fetch_sub_project()
    {
        if($this->input->post('project_id'))
        {
            echo $this->sub_project_model->fetch_sub_project($this->input->post('project_id'));
        }
    }

    function fetch_task()
    {
        if($this->input->post('sub_project_id'))
        {
            echo $this->task_model->fetch_task($this->input->post('sub_project_id'));
        }
    }
    function fetch_sub_task()
    {
        if($this->input->post('task_id'))
        {
            echo $this->sub_task_model->fetch_sub_task($this->input->post('task_id'));
        }
    }
}
