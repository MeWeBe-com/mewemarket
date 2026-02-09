<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sub_tasks extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sub_task_model');
        $this->load->model('task_model');
        $this->load->model('log_model');
        $this->load->model('supplier_screenshots_model');
        $this->load->model('sub_project_model');
        $this->load->model('project_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');

        if (empty($this->session->userdata('id'))) {
            redirect(base_url());
        }
    }

    public function index($id)
    {
        /*if($this->session->userdata('role') == 'Supplier')
        {
            $data['sub_tasks'] = $this->supplier_relation_model->get_relation_data_by_supplier_id($this->session->userdata('id'),'sub_tasks');
            $data['task'] = $this->task_model->get_task_by_id($id);
            $this->log_model->add_log('visit sub-tasks list','supplier');
        }else*/
        {
        $data['sub_tasks'] = $this->sub_task_model->get_all_sub_tasks_by_task_id($id);
        $data['task'] = $this->task_model->get_task_by_id($id);
            if($this->session->userdata('role') == '0') {
                $this->log_model->add_log('visit sub-tasks list', 'users');
            }
        }

       $data['sub_project'] = $sub_project =  $this->sub_project_model->get_project_by_id($data['task']->sub_project_id);
       
       $data['project_bread'] = $project =  $this->project_model->get_project_by_id($sub_project->project_id);  


      

        $this->load->view('sub_tasks/index',$data);
    }

    public function upload_ss($id)
    {
        if ($this->session->userdata('role') == 'Supplier') {
            $supplier_id = $this->session->userdata('id');
            $Is_relation = $this->supplier_relation_model->get_supplier_relation_by_relation_id_table_name_and_supplierid($id,$supplier_id,'sub_tasks');
            $UPLOAD_DIR = "assets/supplier/".$Is_relation[0]->supplier_id."/".$Is_relation[0]->id.'/';

            $last = array_key_last($_FILES['screenshots']['name']);

            // Configure upload directory and allowed file types
            $allowed_types = array('jpg', 'png', 'jpeg', 'gif');

            // Define maxsize for files i.e 2MB
            $maxsize = 2 * 1024 * 1024;

            // Checks if user sent an empty form
            if(!empty(array_filter($_FILES['screenshots']['name']))) {
                ;
                // Loop through each file in files[] array
                foreach ($_FILES['screenshots']['tmp_name'] as $key => $value) {

                    $file_tmpname = $_FILES['screenshots']['tmp_name'][$key];
                    $file_name = $_FILES['screenshots']['name'][$key];
                    $file_size = $_FILES['screenshots']['size'][$key];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                    // Set upload file path
                    $filepath = $UPLOAD_DIR.$file_name;

                    // Check file type is allowed or not
                    if(in_array(strtolower($file_ext), $allowed_types)) {

                        // Verify file size - 2MB max
                        if ($file_size > $maxsize)
                            redirect('sub_tasks/view/'.$id);

                            // If file with name already exist then append time in
                            // front of name of the file to avoid overwriting of file
                            if(file_exists($filepath)) {
                                $filepath = $UPLOAD_DIR.time().$file_name;
                                if (!is_dir($filepath)) {
                                    if (!mkdir($UPLOAD_DIR, 0777, true) && !is_dir($UPLOAD_DIR)) {
                                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $UPLOAD_DIR));
                                    }
                                }
                                if( move_uploaded_file($file_tmpname, $filepath)) {
                                    $store_data = array(
                                        'file' => $file_name,
                                        'status' => '1',
                                        'description' => $this->input->post('description'),
                                        'relation_id' => $Is_relation[0]->id,
                                        'supplier_id' => $Is_relation[0]->supplier_id
                                    );
                                    $this->db->insert('supplier_screenshots', $store_data);
                                    if($last == $key)
                                    {
                                        redirect('sub_tasks/view/'.$id);
                                    }
                                }
                                else {
                                    redirect('sub_tasks/view/'.$id);
                                }
                            }
                            else {
                                if (!is_dir($UPLOAD_DIR)) {
                                    if (!mkdir($UPLOAD_DIR, 0777, true) && !is_dir($UPLOAD_DIR)) {
                                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $UPLOAD_DIR));
                                    }
                                }
                                if( move_uploaded_file($file_tmpname, $filepath)) {
                                    $store_data = array(
                                        'file' => $file_name,
                                        'status' => '1',
                                        'description' => $this->input->post('description'),
                                        'relation_id' => $Is_relation[0]->id,
                                        'supplier_id' => $Is_relation[0]->supplier_id
                                    );
                                    $this->db->insert('supplier_screenshots', $store_data);
                                    if($last == $key)
                                    {
                                        redirect('sub_tasks/view/'.$id);
                                    }
                                }
                                else {
                                    redirect('sub_tasks/view/'.$id);
                                }
                            }
                    }
                    else {

                        redirect('sub_tasks/view/'.$id);
                    }
                }
            }
            else {
                redirect('sub_tasks/view/'.$id);
            }

            if(empty($Is_relation)){
                redirect('/home?AlertMessage=You+are+not+assign+to+this+project');
            }

        }

    }

    public function edit($id)
    {
        $data = array();
        if (empty($id))
        {
            if($this->session->userdata('role') == 'Supplier') {
                $this->log_model->add_log('404 error on edit sub-task','supplier');
            }else if($this->session->userdata('role') == '0') {
                $this->log_model->add_log('404 error on edit sub-task', 'users');
            }
            show_404();
        }else{
            $data['task'] = $task= $this->sub_task_model->get_sub_task_by_id($id);
            $data['suppliers'] = $this->supplier_model->GetAllSupplierByCompanyID($this->session->userdata('company_id'));
            $data['supplier_relations'] = $this->supplier_relation_model->get_supplier_relation_by_relation_id_table_name($id,'sub_tasks');
            if($this->session->userdata('role') == 'Supplier') {
                $this->log_model->add_log('visit edit '.$task->name.' sub-task','supplier');
            }else if($this->session->userdata('role') == '0') {
                $this->log_model->add_log('visit edit '.$task->name.' sub-task', 'users');
            }

            $data['maintask'] = $task= $this->task_model->get_task_by_id($data['task']->task_id);
            $data['sub_project'] = $this->sub_project_model->get_project_by_id($data['maintask']->sub_project_id);
            $data['mainproject'] = $this->project_model->get_project_by_id($data['sub_project']->project_id);

            $this->load->view('sub_tasks/edit',$data);

        }
    }
    public function store($project_id)
    {
        $this->form_validation->set_rules('sub_task_name', 'Sub Task Name', 'required');

        $id = $this->input->post('id');

        if ($this->form_validation->run() === FALSE)
        {
            if(empty($id)){
                redirect( base_url('sub_tasks/create/'.$project_id) );
            }else{
                redirect( base_url('sub_tasks/edit/'.$id) );
            }
        }
        else
        {
            $data['sub_project'] = $this->sub_task_model->createOrUpdate($project_id);
            if($this->session->userdata('role') == 'Supplier') {
                $this->log_model->add_log('create/update sub-task','supplier');
            }else if($this->session->userdata('role') == '0') {
                $this->log_model->add_log('create/update sub-task', 'users');
            }
            redirect( base_url('sub_tasks/index/'.$project_id));
        }

    }
	public function create($id)
	{
        $data['task'] = $this->task_model->get_task_by_id($id);
        $data['suppliers'] = $this->supplier_model->GetAllSupplierByCompanyID($this->session->userdata('company_id'));

        
        $data['sub_project'] = $this->sub_project_model->get_project_by_id($data['task']->sub_project_id);
        $data['mainproject'] = $this->project_model->get_project_by_id($data['sub_project']->project_id);

        if($this->session->userdata('role') == 'Supplier') {
            $this->log_model->add_log('visit create sub-task','supplier');
        }else if($this->session->userdata('role') == '0') {
            $this->log_model->add_log('visit create sub-task', 'users');
        }
		$this->load->view('sub_tasks/create',$data);
	}
    public function delete($id)
    {
        if (empty($id))
        {
            if($this->session->userdata('role') == 'Supplier') {
                $this->log_model->add_log('404 error on delete sub-task','supplier');
            }else if($this->session->userdata('role') == '0') {
                $this->log_model->add_log('404 error on delete sub-task', 'users');
            }
            show_404();
        }
        if($this->session->userdata('role') == 'Supplier') {
            $this->log_model->add_log('delete sub-task','supplier');
        }else if($this->session->userdata('role') == '0') {
            $this->log_model->add_log('delete sub-tasks', 'users');
        }
        $this->sub_task_model->delete($id);
        redirect( base_url('sub_tasks/index/'.$id) );
    }

    public function view($id)
    {

        if ($this->session->userdata('role') == 'Supplier') {
             $supplier_id = $this->session->userdata('id');

           $Is_relation = $this->supplier_relation_model->get_supplier_relation_by_relation_id_table_name_and_supplierid($id,$supplier_id,'sub_tasks');

           if(empty($Is_relation)){
            redirect('/home?AlertMessage=You+are+not+assign+to+this+sub+task');
           }

        }

        $data['sub_task'] = $sub_task =  $this->sub_task_model->get_sub_task_by_id($id);

        $data['tasks'] = $tasks =  $this->task_model->get_task_by_id($sub_task->task_id);
        $data['sub_project'] = $sub_project =  $this->sub_project_model->get_project_by_id($tasks->sub_project_id);
        $data['project'] = $project =  $this->project_model->get_project_by_id($sub_project->project_id);


        if($this->session->userdata('role') == 'Supplier'){
            $supplier_id = $this->session->userdata('id');
        }else{
            $supplier_id = '';
        }

        $data['work_gallery'] =  $this->supplier_screenshots_model->get_work_gallery($supplier_id,'sub_tasks',$id);

        $data['assigned_suppliers'] = $this->supplier_relation_model->get_all_suppliers($id,'sub_tasks');

        if(!empty($this->input->post())){
            $date_range = $this->input->post('date_range');
            $date_exp = explode('-',$date_range);

            $start_date = str_replace('/','-',$date_exp[0]) ;
            $end_date = str_replace('/','-',$date_exp[1]) ;


        }else{
            $date_start =  mktime(0, 0, 0, date("m"),   date("d") + 1,   date("Y")-1);
            $start_date = date('Y-m-d',($date_start));
            $date_end =  mktime(0, 0, 0, date("m"),   date("d") + 1,   date("Y"));
            $end_date =  date('Y-m-d',($date_end));
        }

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        foreach($data['assigned_suppliers'] as $key => $supplier){
            $relation_id = $this->supplier_relation_model->CheckRelationOfSupplierAndProject($id,$supplier->supplier_id,'sub_tasks');

            if(!empty($relation_id)){
                $Hours = $this->supplier_relation_model->GetHoursFromRelationId($relation_id[0]->id,$start_date,$end_date)[0]->total_hours;

                $TotalWorkingHours = $Hours / 60 ;
            }else{
                $TotalWorkingHours = 0;
            }

            $data['assigned_suppliers'][$key]->WorkingHours = $TotalWorkingHours ;
            
        } 


        if($this->session->userdata('role') == 'Supplier') {
            if($sub_task->name != null) {
                $this->log_model->add_log('view ' . $sub_task->name . ' sub-task', 'supplier');
            }
        }else if($this->session->userdata('role') == '0') {
            if($sub_task->name != null) {
                $this->log_model->add_log('view ' . $sub_task->name . ' sub-task', 'users');
            }
        }
        $this->load->view('sub_tasks/view',$data);
    }

    public function Gallery($id)
    {

        if(!empty($this->input->post('supplier_id'))){
            $Supplierid = $this->input->post('supplier_id');
        }elseif ($this->session->userdata('role') != 'Supplier') {
            $Supplierid = '';
        } else {
            $Supplierid = $this->session->userdata('id');
        }

        $data['suppliers'] = $this->supplier_model->GetLatestSupplier();

        if(!empty($this->input->post('supplier_id'))){
            $data['SelectedSupplier'] = $this->input->post('supplier_id');
        }else{
            $data['SelectedSupplier'] = '';
        }


        $data['sub_task'] = $sub_task = $this->sub_task_model->get_sub_task_by_id($id);
        $data['task'] = $task = $this->task_model->get_task_by_id($sub_task->task_id);


        $data['sub_project'] = $sub_project = $this->sub_project_model->get_project_by_id($data['task']->sub_project_id);
        $data['project'] = $project = $this->project_model->get_project_by_id($sub_project->project_id);

        if(!empty($this->input->post())){
            $date_range = $this->input->post('date_range');
            $date_exp = explode('-',$date_range);

            $start_date = str_replace('/','-',$date_exp[0]) ;
            $end_date = str_replace('/','-',$date_exp[1]) ;
        }else{
            $date_start =  mktime(0, 0, 0, date("m"),   date("d") + 1,   date("Y")-1);
            $start_date = date('Y-m-d',($date_start));
            $date_end =  mktime(0, 0, 0, date("m"),   date("d") + 1,   date("Y"));
            $end_date =  date('Y-m-d',($date_end));
        }

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $config['base_url'] = base_url('sub_tasks/Gallery/'.$id);

        $counts = $this->supplier_screenshots_model->get_count_work_gallery_For_All($id,$Supplierid,'sub_tasks',$start_date,$end_date);
        
        $config['total_rows'] = $counts[0]->totals;
        $config['per_page'] = 30;
        $config['uri_segment'] = 4;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="paginate_button active"><a href="javascript:;">';
        $config['cur_tag_close'] = '</a></li>';


        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $data['pagination'] = $this->pagination->create_links();


        $data['work_gallery'] =  $this->supplier_screenshots_model->get_work_gallery_For_All($id,$Supplierid,'sub_tasks',$start_date,$end_date,$config['per_page'],$page);


        $this->load->view('sub_tasks/gallery', $data);

    }

}
