<?php
defined('BASEPATH') or exit('No direct script access allowed');

class departments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier_model');
        if (!$this->session->userdata('username')) {
            redirect('login');
        }
    }
    public function index()
    {
        $data['departments'] = $this->supplier_model->GetSupplierDepartment($this->session->userdata('company_id'));
        $this->load->view('settings/departments/index', $data);
    }

    public function create()
    {
        $this->load->view('settings/departments/create');
    }

    public function store()
    {
       $this->supplier_model->store_department();
       redirect( base_url('departments'));
    }
    public function edit($id)
    {
        $data['department'] = $this->supplier_model->GetSupplierDepartmentByID($id);
        $this->load->view('settings/departments/edit',$data);
    }
    public function update($id)
    {
        $this->supplier_model->update_department($id);
        redirect( base_url('departments'));
    }

    public function delete($id)
    {
        $this->supplier_model->delete_department($id);
        redirect( base_url('departments'));
    }

}

?>