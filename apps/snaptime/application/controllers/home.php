<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier_screenshots_model');
        $this->load->model('time_check_model');
        $this->load->model('project_model');
    }

    public function index()
    {
        if (!$this->session->userdata('username')) {
            redirect('login');
        }
        $data['latest_project'] = $latest_project = $this->supplier_screenshots_model->get_latest_record($this->session->userdata('id'), $this->session->userdata('company_id'));
        $data['dates'] = $dates = $this->getLastWeekDates();
        $data['last'] = $last = end($dates['dates']);
        $data['first'] = $first = reset($dates['dates']);
        if ($this->session->userdata('role') === 'Supplier') {
            $date_last = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"));
            $data['firstMonth'] = $firstMonth = date('Y-m-d', ($date_last));
            $data['lastMonth'] = $lastMonth = date('Y-m-d');

            $supplier_id = $this->session->userdata('id');

            if (!empty($this->input->post('project_id'))) {
                $relation_id = $this->supplier_relation_model->get_relation_id_by_project_id($this->input->post('project_id'))[0]->id;
                $data['project_id'] = $this->input->post('project_id');
            } else {
                $relation_id = '';
            }

            $table_name = 'projects';

            $data['assigned_projects'] = $this->supplier_relation_model->get_relation_data_by_supplier_id($supplier_id, $table_name);
            $data['time_table'] = $this->time_check_model->get_time_table($firstMonth, $lastMonth, $this->session->userdata('company_id'), $supplier_id, $relation_id, $table_name);

        } elseif ($this->session->userdata('role') === '0') {

            $date_last = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"));
            $data['firstMonth'] = $firstMonth = date('Y-m-d', ($date_last));
            $data['lastMonth'] = $lastMonth = date('Y-m-d');

            $supplier_id = '';
            $manager_id = $this->session->userdata('id');

            if (!empty($this->input->post('project_id'))) {
                $relation = $this->supplier_relation_model->get_relation_id_by_project_id($this->input->post('project_id'));
                if (!empty($relation)) {
                    $relation_id = $relation[0]->id;
                } else {
                    $relation_id = '';
                }
                $data['project_id'] = $this->input->post('project_id');
            } else {
                $relation_id = '';
            }

            $table_name = 'projects';
            $data['assigned_projects'] = $this->project_model->get_all_projects_by_manager_id($manager_id);
            $data['time_table'] = $this->time_check_model->get_time_table($firstMonth, $lastMonth, $this->session->userdata('company_id'), $supplier_id, $relation_id, $table_name);
        } else if ($this->session->userdata('role') === '1') {

            $date_last = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"));
            $data['firstMonth'] = $firstMonth = date('Y-m-d', ($date_last));
            $data['lastMonth'] = $lastMonth = date('Y-m-d');
            $supplier_id = '';
            if (!empty($this->input->post('project_id'))) {
                $relation = $this->supplier_relation_model->get_relation_id_by_project_id($this->input->post('project_id'));
                if (!empty($relation)) {
                    $relation_id = $relation[0]->id;
                } else {
                    $relation_id = '';
                }

                $data['project_id'] = $this->input->post('project_id');
            } else {
                $relation_id = '';
            }

            $table_name = 'projects';

            $data['assigned_projects'] = $this->project_model->get_all_projects_by_company_id($this->session->userdata('company_id'));

            $data['time_table'] = $this->time_check_model->get_time_table($firstMonth, $lastMonth, $this->session->userdata('company_id'), $supplier_id, $relation_id, $table_name);
        }
        $data['suppliers'] = $this->supplier_model->GetLatestSupplier();
        $data['projects'] = $this->supplier_model->GetLatestProjects();

        if ($this->session->userdata('role') != 'Supplier') {
            $supplier_id = '';
        } else {
            $supplier_id = $this->session->userdata('id');
        }

        if ($this->session->userdata('role') != 'Supplier') {
            $data['LatestProject'] = $this->supplier_relation_model->GetLatestProjectsWithLatestWork($supplier_id, $this->session->userdata('company_id'));
        } else {
            $data['LatestProject'] = $this->supplier_relation_model->GetLatestProjectsBySupplierID($supplier_id, $this->session->userdata('company_id'));
        }
        $data['Latestsuppliers'] = $this->supplier_relation_model->GetLatestsuppliersWithLatestWork($this->session->userdata('company_id'));
        $data['LatestScreenshots'] = $this->supplier_relation_model->GetLatestScreenshotsWithLatestWork($supplier_id, $this->session->userdata('company_id'));
        $data['screenshots'] = $this->supplier_screenshots_model->get_all_screenshots_by_supplier_id($this->session->userdata('id'), $this->session->userdata('company_id'));
        $data['dates'] = $this->getLastMonthDates();
        $this->load->view('home', $data);
    }

    function getLastMonthDates()
    {
        $lastWeek = array();

        $prevMon = abs(strtotime("previous month"));
        $currentDate = abs(strtotime("today"));
        $seconds = 86400; //86400 seconds in a day

        $dayDiff = ceil(($currentDate - $prevMon) / $seconds);

        if ($dayDiff < 7) {
            $dayDiff += 1; //if it's monday the difference will be 0, thus add 1 to it
            $prevMon = strtotime("previous monday", strtotime("-$dayDiff day"));
        }

        $prevMon = date("Y-m-d", $prevMon);

        // create the dates from Monday to Sunday
        for ($i = 0; $i < 30; $i++) {
            $d = date("Y-m-d", strtotime($prevMon . " + $i day"));
            $lastWeek['dates'][] = $d;
            $lastWeek['days'][] = date('D', strtotime($prevMon . " + $i day"));
        }

        return $lastWeek['dates'];
    }

    function getLastWeekDates()
    {

        if (!$this->session->userdata('username')) {
            redirect('login');
        }
        $lastWeek = array();

        $prevMon = abs(strtotime("previous monday"));
        $currentDate = abs(strtotime("today"));
        $seconds = 86400; //86400 seconds in a day

        $dayDiff = ceil(($currentDate - $prevMon) / $seconds);

        if ($dayDiff < 7) {
            $dayDiff += 1; //if it's monday the difference will be 0, thus add 1 to it
            $prevMon = strtotime("previous monday", strtotime("-$dayDiff day"));
        }

        $prevMon = date("Y-m-d", $prevMon);

        // create the dates from Monday to Sunday
        for ($i = 0; $i < 7; $i++) {
            $d = date("Y-m-d", strtotime($prevMon . " + $i day"));
            $lastWeek['dates'][] = $d;
            $lastWeek['days'][] = date('D', strtotime($prevMon . " + $i day"));
        }

        return $lastWeek;
    }

    public function create_image($text)
    {
        header("Content-Type: image/png");
        $im = @imagecreate(800, 450)
        or die("Cannot Initialize new GD image stream");
        $background_color = imagecolorallocate($im, 0, 0, 0);
        $text_color = imagecolorallocate($im, 233, 14, 91);
        imagestring($im, 25, 5, 5, $text, $text_color);
        imagepng($im);
        imagedestroy($im);
    }

}
