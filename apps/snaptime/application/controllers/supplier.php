<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class supplier extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier_model');
        $this->load->model('log_model');
        $this->load->model('supplier_screenshots_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');

        if (empty($this->session->userdata('id'))) {
            redirect(base_url());
        }
	}
	
	public function index()
	{

		$data['suppliers'] = $this->supplier_model->GetAllSupplierByCompanyID($this->session->userdata('company_id'));
		$data['supplier_type'] = $this->supplier_model->GetSupplierType();
        $data['supplier_department'] = $this->supplier_model->GetSupplierDepartment($this->session->userdata('company_id'));

        if($this->session->userdata('role') == '0') {
            $this->log_model->add_log('visit supplier list', 'users');
        }
		$this->load->view('supplier/index',$data);
	}

	public function create()
	{

        $data['supplier_type'] = $this->supplier_model->GetSupplierType();
		$data['supplier_department'] = $this->supplier_model->GetSupplierDepartment($this->session->userdata('company_id'));

        $data['supplier_trade'] = $this->supplier_model->GetAllSupplierTrade();

        if($this->session->userdata('role') == 'Supplier') {
            $this->log_model->add_log('visit create supplier','supplier');
        }else if($this->session->userdata('role') == '0') {
            $this->log_model->add_log('visit create supplier', 'users');
        }
		$this->load->view('supplier/create',$data);

	}

	public function edit($id)
    {

        if($this->session->userdata('role') == 'Supplier' ){
            if($this->session->userdata('id') != $id){
                redirect(base_url());
            }
        }

        $data = array();
        if (empty($id))
        {
            if($this->session->userdata('role') == 'Supplier') {
                $this->log_model->add_log('404 error on edit supplier','supplier');
            }else if($this->session->userdata('role') == '0') {
                $this->log_model->add_log('404 error on edit supplier', 'users');
            }
            show_404();
        }else{
			$data['supplier_type'] = $this->supplier_model->GetSupplierType();
			$data['supplier_department'] = $this->supplier_model->GetSupplierDepartment($this->session->userdata('company_id'));
            $data['supplier'] = $supplier=$this->supplier_model->get_supplier_by_id($id);
            $data['supplier_trade'] = $this->supplier_model->GetAllSupplierTrade();
            if($this->session->userdata('role') == 'Supplier') {
                $this->log_model->add_log('visit edit '.$supplier->name.' supplier','supplier');
            }else if($this->session->userdata('role') == '0') {
                $this->log_model->add_log('visit edit '.$supplier->name.' supplier', 'users');
            }
            $this->load->view('supplier/edit',$data);

        }
	}
	
    public function store()
    {
        $id = $this->input->post('id');

        if(empty($id)){ 
            $this->form_validation->set_rules('supplier_type_id', 'Type', 'required');
        }else{
            $this->form_validation->set_rules('name', 'Name', 'required');
        }
        

        if ($this->form_validation->run() === FALSE)
        {
            if(empty($id)){
                redirect( base_url('supplier/create') );
            }else{
                redirect( base_url('supplier/edit/'.$id) );
            }
        }
        else
        { 
            $data['supplier'] = $this->supplier_model->createOrUpdate();
            if($this->session->userdata('role') == 'Supplier') {
                $this->log_model->add_log('create/update supplier','supplier');
            }else if($this->session->userdata('role') == '0') {
                $this->log_model->add_log('create/update supplier', 'users');
            }

            if(empty($id)){
                redirect( base_url('supplier') );
            }else{
                redirect( base_url('supplier/edit/'.$id) );
            }

        }

	}

	public function delete($id)
    {
        if (empty($id))
        {
            if($this->session->userdata('role') == 'Supplier') {
                $this->log_model->add_log('404 error on delete supplier','supplier');
            }else if($this->session->userdata('role') == '0') {
                $this->log_model->add_log('404 error on delete supplier', 'users');
            }
            show_404();
        }
        $this->supplier_model->delete($id);
        if($this->session->userdata('role') == 'Supplier') {
            $this->log_model->add_log('delete supplier','supplier');
        }else if($this->session->userdata('role') == '0') {
            $this->log_model->add_log('delete supplier', 'users');
        }
        redirect( base_url('supplier') );
    }

    public function view($id)
    {

        $data['supplier_department'] = $this->supplier_model->GetSupplierDepartment($this->session->userdata('company_id'));
        $data['supplier'] = $supplier=$this->supplier_model->get_supplier_by_id($id);
        $data['projects'] = $this->supplier_relation_model->get_relation_data_by_supplier_id($id, 'projects');
        $data['supplier_type'] = $this->supplier_model->GetSupplierTypeByID($supplier->supplier_type_id);
        if(!empty($this->input->post())){
            $date_range = $this->input->post('date_range');
            $date_exp = explode('-',$date_range);

            $start_date = str_replace('/','-',$date_exp[0]) ;
            $end_date = str_replace('/','-',$date_exp[1]) ;

        }else{
            $start_date = date('Y-01-01');
            $end_date = date('Y-12-31');
        }

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

         foreach($data['projects'] as $key => $projects){ 
            $relation_id = $this->supplier_relation_model->CheckRelationOfSupplierAndProject($projects->id,$id,'projects')[0]->id;

            $Hours = $this->supplier_relation_model->GetHoursFromRelationId($relation_id,$start_date,$end_date)[0]->total_hours;

            $TotalWorkingHours = $Hours / 60 ;

            $data['projects'][$key]->WorkingHours = $TotalWorkingHours ;
            
        } 

        $data['projectsscreenshot'] = $this->supplier_screenshots_model->get_all_screenshots_by_supplier_id_with_Projects($id);

        $this->load->view('supplier/profile',$data);
    }

}
