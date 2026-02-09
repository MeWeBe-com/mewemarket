<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class timesheet extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('project_model');
        $this->load->model('supplier_model');
        $this->load->model('sub_project_model');
        $this->load->model('task_model');
        $this->load->model('log_model');
        $this->load->model('time_check_model');
        $this->load->model('supplier_relation_model');
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

        $this->load->view('timesheet/index',$data);
    }
    public function show($supplier_id=null, $startdate = null, $enddate = null,$project_get_id = NULL,$tablename = NULL)
    {
     /*   
        $date_range = $this->input->post('date_range');
		  
		  
		  $date_range = $this->input->post('date_range');
*/
        if(!empty($supplier_id)){
           $data['supplier_get_id'] = $supplier_id;
        }

//        $last = date('Y-m-t', strtotime($date));
//        $first = date('Y-m-01', strtotime($date));
//        $data['previous'] = date('01-m-Y', strtotime('last month', strtotime($date)));
//        $data['next'] = date('01-m-Y', strtotime('next month', strtotime($date)));
//        $data['first'] = $first;
//        $data['last'] = $last;
        $types = array('projects', 'sub_projects', 'tasks', 'sub_tasks');
        foreach ($types as $type) {
            $data['assigned_projects'][] = $this->supplier_relation_model->get_relation_data_by_supplier_id($supplier_id, $type);
        }
//        echo json_encode($data['assigned_projects']);
//        die();
      //  $data['suppliers'] = $this->supplier_model->GetAllSupplierByCompanyID($this->session->userdata('company_id));

		$date_range_post = $this->input->post('date_range');
		
        if(!empty($date_range_post))
        {
            $date_range = $this->input->post('date_range');
        }elseif(!empty($enddate)){
			$date_range = $startdate." - ".$enddate; 
		}else{
			$date_last =  mktime(0, 0, 0, date("m")-1,   date("d"),   date("Y"));
			$date_range = date('Y-m-d',($date_last))." - ".date("Y-m-d"); 
		}
		$first_last_date =  explode(' - ',$date_range);
		$data['first'] = $first = trim($first_last_date[0]);
		$data['last'] = $last = trim($first_last_date[1]);
		$data['dates'] = $this->getDatesFromRange($first, $last);

		/*elseif(!empty($date))
        {
            $dates = date('Y-m-d');
            $data['last'] = $last = date('Y-12-31', strtotime($dates));
            $data['first'] = $first = date($date, strtotime($dates));
            $data['dates'] = $this->getDatesFromRange($first, $last);
        }else
        {
            $date = date('Y-m-d');
            $data['last'] = $last = date('Y-12-01', strtotime($date));
            $data['first'] = $first = date('Y-01-01', strtotime($date));
            $data['dates'] = $this->getDatesFromRange($first, $last);
        }
*/

        if($this->session->userdata('role') == 'Supplier')
        {
            $supplier_id = $this->session->userdata('id');
        }
        else
        {
            $supplier_id = $supplier_id;

        }
		
		$project_id = $this->input->post('project_id');
        if(!empty($project_id))
        {
            $data['by_project'] = 'true';
            $data['project_id'] = $project_id;
			$tablename = null;

        }elseif(!empty($project_get_id)){
            $project_id = $project_get_id ;
			$data['by_project'] = 'true';
			$data['project_id'] = $project_id;
        }

		if(isset($supplier_id))
        {
            $data['by_supplier'] = 'true';
        }

        if($project_id != null || $date_range != null) {


            $project = array();
            $data['time_checks'] = $time_checks = $this->time_check_model->get_time_check($first, $last, $supplier_id != null ? $supplier_id : null, $project_id,$tablename);

            if (!empty($time_checks)) {
                foreach ($time_checks as $time_check) {
                    $project[] = $this->supplier_relation_model->get_supplier_relation_by_relation_id_supplier_id_table_name_with_relation_data($time_check->relation_id, $time_check->supplier_id, $time_check->table_name);
                    $supplier_names[] = $time_check->name;
                }
                $data['supplier_name'] = array_unique($supplier_names);

            } else {
                $supplier = $this->supplier_model->get_supplier_by_id($supplier_id);
                $data['supplier_name'] = $supplier->name;
            }
            $data['project'] = $project;
        }/*else
        {
            $project = array();
            $data['time_checks'] = $time_checks = $this->time_check_model->get_time_check($first, $last, $supplier_id != null ? $supplier_id : null, $project_id, $project_id != null ? 'projects' : null);

            if (!empty($time_checks)) {
                foreach ($time_checks as $time_check) {
                    $project[] = $this->supplier_relation_model->get_supplier_relation_by_relation_id_supplier_id_table_name_with_relation_data($time_check->relation_id, $time_check->supplier_id, $time_check->table_name);
                    $supplier_names[] = $time_check->name;
                }
                $data['supplier_name'] = array_unique($supplier_names);

            } else {
                $supplier = $this->supplier_model->get_supplier_by_id($supplier_id);
                $data['supplier_name'] = $supplier->name;
            }
            $data['project'] = $project;
        }
*/

        if ($this->session->userdata('role') == 'Supplier') {
			$supplier_id = $this->session->userdata('id');
		}
            //if (!isset($data['assigned_projects'])) {
                $types = array('projects', 'sub_projects', 'tasks', 'sub_tasks');
                foreach ($types as $type) {
                    $data['assigned_projects'][] = $this->supplier_relation_model->get_relation_data_by_supplier_id($supplier_id, $type);
                }
          //  }
       /* } else {
            $types = array('projects', 'sub_projects', 'tasks', 'sub_tasks');
            foreach ($types as $type) {
                $data['assigned_projects'][] = $this->supplier_relation_model->get_relation_data_by_supplier_id($supplier_id, $type);
            }

        }*/

        if($this->session->userdata('role') == '0') {
            $this->log_model->add_log('visit timesheet page', 'users');
        }else if($this->session->userdata('role') == 'Supplier')
        {
            $this->log_model->add_log('visit timesheet page', 'supplier');
        }

        $this->load->view('timesheet/show', $data);
    }

    function get_relational_data($project_id)
    {
        $all_projects = array();
        $sub_projects = $this->sub_project_model->get_all_sub_projects_by_project_id($project_id);
        // $tasks = array();
        $i = 0;

        if(isset($sub_projects))
        {

            foreach ($sub_projects as $sub_project) {
                $all_projects[$i]['type'] = 'sub_projects';
                $all_projects[$i]['id'] = $sub_project->id;
                $tasks  = $this->task_model->get_all_sub_tasks_by_sub_project_id($sub_project->id);
                $i++;

                if (isset($tasks))
                {

                    foreach ($tasks as $task) {

                        $all_projects[$i]['type'] = 'tasks';
                        $all_projects[$i]['id'] = $task->id;
                        $sub_tasks = $this->sub_task_model->get_all_sub_tasks_by_task_id($task->id);
                        $i++;

                        if(isset($sub_tasks))
                        {

                            foreach ($sub_tasks as $sub_task)
                            {
                                $all_projects[$i]['type'] = 'sub_tasks';
                                $all_projects[$i]['id'] = $sub_task->id;
                                $i++;
                            }
                        }

                    }
                }
            }
        }
//        if (isset($tasks[0]))
//        {
//
//            foreach ($tasks[0] as $task) {
//
//                $all_projects[$i]['type'] = 'tasks';
//                $all_projects[$i]['id'] = $task->id;
//                $sub_tasks = $this->sub_task_model->get_all_sub_tasks_by_task_id($task->id);
//
//            }
//        }
//        if(isset($sub_tasks[0]))
//        {
//
//            foreach ($sub_tasks[0] as $sub_task)
//            {
//                $all_projects[$i]['type'] = 'sub_tasks';
//                $all_projects[$i]['id'] = $sub_task->id;
//            }
//        }
        return $all_projects;
    }

    function get_projects($first_date, $last_date, $project_id = null, $supplier_id)
    {
        $projects = array();
        if ($project_id != null) {
            $projects[0] = $this->supplier_relation_model->get_all_relation_data_by_supplier_id($first_date, $last_date, $supplier_id, 'projects', $project_id);
            $all_project_ids = $this->get_relational_data($project_id);
            foreach ($all_project_ids as $all_project_id)
            {
                $projects[] = $this->supplier_relation_model->get_all_relation_data_by_supplier_id($first_date, $last_date, $supplier_id, $all_project_id['type'], $all_project_id['id']);
            }

        } else {
            $types = array('projects', 'sub_projects', 'tasks', 'sub_tasks');
            foreach ($types as $type) {
                $project = $this->supplier_relation_model->get_all_relation_data_by_supplier_id($first_date, $last_date, $supplier_id, $type, $project_id);

                if (isset($project)) {
                    array_push($projects, $project);
                }
            }
        }
        return $projects;
    }

    public function get_screenshots($first_date, $last_date,$projects, $supplier_id)
    {
        $screenshots = array();

        foreach ($projects as $key => $project) {
            if ($project != null) {

//                foreach ($project as $key2 => $item) {

                $screenshots[$project->name] = $this->supplier_screenshots_model->get_all_screenshots_by_supplier_id_and_relation_id($first_date, $last_date,$supplier_id, $project->relation_table_id);
				
                $time_check = $this->time_check_model->get_time_check_by_relation_id($first_date, $last_date,$project->relation_table_id);

                $screenshots['total'][] = round($time_check->total / 60, 2);
                $screenshots['date'][] = $time_check->date;
//                }
            }
        }
        $data = ($screenshots);
        return $data;
    }

    function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        // Declare an empty array
        $array = array();

        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        // Use loop to store date into array
        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        // Return the array elements
        return $array;
    }

}
