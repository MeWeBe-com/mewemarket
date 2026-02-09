<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS'); 
 header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
 
 
 header('Access-Control-Allow-Credentials: true');


header('Content-Type: application/json');

class projects extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier_screenshots_model');
        $this->load->model('sub_project_model');
        $this->load->model('time_check_model');
        $this->load->model('task_model');
        $this->load->library('rest_controller');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
            echo $this->rest_controller->response('', $this->rest_controller::HTTP_OK);
        }
    }

    public function supplier_projects($supplier_id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'GET') {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $projects = $this->supplier_relation_model->get_relation_data_by_supplier_id($supplier_id, $input_data['table']);
            echo $this->rest_controller->response(json_encode($projects), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        }
    }

    public function admin_projects()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'GET') {

            $projects = $this->project_model->get_all_projects();
            echo $this->rest_controller->response(json_encode($projects), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        }
    }

    public function view_project($id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'POST') {

            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            if ($input_data['role'] == 'Supplier') {
                $supplier_id = $input_data['supplier_id'];

                $Is_relation = $this->supplier_relation_model->get_supplier_relation_by_relation_id_table_name_and_supplierid($id, $supplier_id, $input_data['table']);

                if (empty($Is_relation)) {
                    redirect('/home?AlertMessage=You+are+not+assign+to+this+project');
                }

            }
            $data['project'] = $project = $this->project_model->get_project_by_id($id);
            $data['sub_projects'] = $sub_project = $this->sub_project_model->get_all_sub_projects_by_project_id($project->id);
            $data['assigned_suppliers'] = $this->supplier_relation_model->get_all_suppliers($id, $input_data['table']);
            if (!empty($input_data['date_range'])) {
                $date_range = $input_data['date_range'];
                $date_exp = explode('-', $date_range);

                $start_date = str_replace('/', '-', $date_exp[0]);
                $end_date = str_replace('/', '-', $date_exp[1]);

            } else {
                $date_start = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y") - 1);
                $start_date = date('Y-m-d', ($date_start));
                $date_end = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
                $end_date = date('Y-m-d', ($date_end));
            }
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;

            foreach ($data['assigned_suppliers'] as $key => $supplier) {
                $relation_id = $this->supplier_relation_model->CheckRelationOfSupplierAndProject($id, $supplier->supplier_id, $input_data['table']);

                if (!empty($relation_id)) {
                    $Hours = $this->supplier_relation_model->GetHoursFromRelationId($relation_id[0]->id, $start_date, $end_date)[0]->total_hours;

                    $TotalWorkingHours = $Hours / 60;
                } else {
                    $TotalWorkingHours = 0;
                }
                $data['assigned_suppliers'][$key]->WorkingHours = $TotalWorkingHours;
            }
            $data['screenshots'] = $this->supplier_screenshots_model->get_work_gallery($supplier_id, $input_data['table'], $id);
            $response = [
                'status' => True,
                'message' => 'Data Found',
                'data' => $data
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        }
    }

    public function view_sub_project($id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'POST') {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            if ($input_data['role'] == 'Supplier') {
                $supplier_id = $input_data['supplier_id'];

                $Is_relation = $this->supplier_relation_model->get_supplier_relation_by_relation_id_table_name_and_supplierid($id, $supplier_id, $input_data['table']);

                if (empty($Is_relation)) {
                    $response = [
                        'status' => False,
                        'message' => 'You are not assign to this task',
                    ];
                    echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
                }

            }

            $data['sub_project'] = $sub_project = $this->sub_project_model->get_project_by_id($id);
            $data['project'] = $project = $this->project_model->get_project_by_id($sub_project->project_id);

            if ($input_data['role'] == 'Supplier') {
                $supplier_id = $input_data['supplier_id'];
            } else {
                $supplier_id = '';
            }

            $data['work_gallery'] = $this->supplier_screenshots_model->get_work_gallery($supplier_id, $input_data['table'], $id);

            // $data['tasks'] = $tasks =  $this->supplier_relation_model->get_relation_data_by_supplier_id_sub_id($id,$this->session->userdata('id'),'tasks');

            $data['tasks'] = $tasks = $this->task_model->get_all_sub_tasks_by_sub_project_id($id);

            $data['assigned_suppliers'] = $this->supplier_relation_model->get_all_suppliers($id, $input_data['table']);

            if (!empty($input_data['date_range'])) {
                $date_range = $input_data['date_range'];
                $date_exp = explode('-', $date_range);

                $start_date = str_replace('/', '-', $date_exp[0]);
                $end_date = str_replace('/', '-', $date_exp[1]);

            } else {
                $date_start = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y") - 1);
                $start_date = date('Y-m-d', ($date_start));
                $date_end = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
                $end_date = date('Y-m-d', ($date_end));
            }

            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;

            foreach ($data['assigned_suppliers'] as $key => $supplier) {
                $relation_id = $this->supplier_relation_model->CheckRelationOfSupplierAndProject($id, $supplier->supplier_id, $input_data['table']);

                if (!empty($relation_id)) {
                    $Hours = $this->supplier_relation_model->GetHoursFromRelationId($relation_id[0]->id, $start_date, $end_date)[0]->total_hours;

                    $TotalWorkingHours = $Hours / 60;
                } else {
                    $TotalWorkingHours = 0;
                }

                $data['assigned_suppliers'][$key]->WorkingHours = $TotalWorkingHours;

            }

            $response = [
                'status' => True,
                'message' => 'Data Found',
                'data' => $data
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
        }
    }

    public function view_task($id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'POST') {

            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            if ($input_data['role'] == 'Supplier') {
                $supplier_id = $this->session->userdata('id');

                $Is_relation = $this->supplier_relation_model->get_supplier_relation_by_relation_id_table_name_and_supplierid($id, $supplier_id, $input_data['table']);

                if (empty($Is_relation)) {
                    $response = [
                        'status' => False,
                        'message' => 'You are not assign to this task',
                    ];
                    echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
                }

            }

            $data['tasks'] = $tasks = $this->task_model->get_task_by_id($id);
            $data['sub_tasks'] = $sub_tasks = $this->sub_task_model->get_all_sub_tasks_by_task_id($tasks->id);

            if ($input_data['role'] == 'Supplier') {
                $supplier_id = $input_data['supplier_id'];
            } else {
                $supplier_id = '';
            }

            $data['work_gallery'] = $this->supplier_screenshots_model->get_work_gallery($supplier_id, $input_data['table'], $id);

            $data['sub_project'] = $sub_project = $this->sub_project_model->get_project_by_id($tasks->sub_project_id);
            $data['project'] = $this->supplier_relation_model->get_relation_data_by_supplier_id_sub_id($id, $input_data['supplier_id'], 'sub_tasks');


            $data['project_bread'] = $project = $this->project_model->get_project_by_id($sub_project->project_id);

            $data['assigned_suppliers'] = $this->supplier_relation_model->get_all_suppliers($id, $input_data['table']);

            if (!empty($input_data['date_range'])) {
                $date_range = $input_data['date_range'];
                $date_exp = explode('-', $date_range);

                $start_date = str_replace('/', '-', $date_exp[0]);
                $end_date = str_replace('/', '-', $date_exp[1]);

            } else {
                $date_start = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y") - 1);
                $start_date = date('Y-m-d', ($date_start));
                $date_end = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
                $end_date = date('Y-m-d', ($date_end));
            }

            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;

            foreach ($data['assigned_suppliers'] as $key => $supplier) {
                $relation_id = $this->supplier_relation_model->CheckRelationOfSupplierAndProject($id, $supplier->supplier_id, $input_data['table']);

                if (!empty($relation_id)) {
                    $Hours = $this->supplier_relation_model->GetHoursFromRelationId($relation_id[0]->id, $start_date, $end_date)[0]->total_hours;

                    $TotalWorkingHours = $Hours / 60;
                } else {
                    $TotalWorkingHours = 0;
                }

                $data['assigned_suppliers'][$key]->WorkingHours = $TotalWorkingHours;
                $response = [
                    'status' => True,
                    'message' => 'Data Found',
                    'data' => $data
                ];
                echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
            }
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        }
    }

    public function view_sub_task($id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'POST') {

            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            if ($input_data['role'] == 'Supplier') {
                $supplier_id = $this->session->userdata('id');

                $Is_relation = $this->supplier_relation_model->get_supplier_relation_by_relation_id_table_name_and_supplierid($id, $supplier_id, $input_data['table']);

                if (empty($Is_relation)) {
                    $response = [
                        'status' => False,
                        'message' => 'You are not assign to this task',
                    ];
                    echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
                }

            }

            $data['tasks'] = $tasks = $this->task_model->get_task_by_id($id);
            $data['sub_tasks'] = $sub_tasks = $this->sub_task_model->get_all_sub_tasks_by_task_id($tasks->id);

            if ($input_data['role'] == 'Supplier') {
                $supplier_id = $input_data['supplier_id'];
            } else {
                $supplier_id = '';
            }

            $data['work_gallery'] = $this->supplier_screenshots_model->get_work_gallery($supplier_id, $input_data['table'], $id);

            $data['sub_project'] = $sub_project = $this->sub_project_model->get_project_by_id($tasks->sub_project_id);
            $data['project'] = $this->supplier_relation_model->get_relation_data_by_supplier_id_sub_id($id, $input_data['supplier_id'], $input_data['table']);


            $data['project_bread'] = $project = $this->project_model->get_project_by_id($sub_project->project_id);

            $data['assigned_suppliers'] = $this->supplier_relation_model->get_all_suppliers($id, $input_data['table']);

            if (!empty($input_data['date_range'])) {
                $date_range = $input_data['date_range'];
                $date_exp = explode('-', $date_range);

                $start_date = str_replace('/', '-', $date_exp[0]);
                $end_date = str_replace('/', '-', $date_exp[1]);

            } else {
                $date_start = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y") - 1);
                $start_date = date('Y-m-d', ($date_start));
                $date_end = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
                $end_date = date('Y-m-d', ($date_end));
            }

            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;

            foreach ($data['assigned_suppliers'] as $key => $supplier) {
                $relation_id = $this->supplier_relation_model->CheckRelationOfSupplierAndProject($id, $supplier->supplier_id, $input_data['table']);

                if (!empty($relation_id)) {
                    $Hours = $this->supplier_relation_model->GetHoursFromRelationId($relation_id[0]->id, $start_date, $end_date)[0]->total_hours;

                    $TotalWorkingHours = $Hours / 60;
                } else {
                    $TotalWorkingHours = 0;
                }

                $data['assigned_suppliers'][$key]->WorkingHours = $TotalWorkingHours;
                $response = [
                    'status' => True,
                    'message' => 'Data Found',
                    'data' => $data
                ];
                echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
            }
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        }
    }

    public function gallery($id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'POST') {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $data['suppliers'] = $this->supplier_model->GetLatestSupplier();
            $supplier_id = $input_data['supplier_id'];
            if (!empty($input_data['supplier_id'])) {
                $data['SelectedSupplier'] = $input_data['supplier_id'];
            } else {
                $data['SelectedSupplier'] = '';
            }
            if (!empty($input_data['date_range'])) {
                $date_range = $input_data['date_range'];
                $date_exp = explode('-', $date_range);
                $start_date = str_replace('/', '-', $date_exp[0]);
                $end_date = str_replace('/', '-', $date_exp[1]);
            } else {
                $date_start = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y") - 1);
                $start_date = date('Y-m-d', ($date_start));
                $date_end = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
                $end_date = date('Y-m-d', ($date_end));
            }
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['project'] = $project = $this->project_model->get_project_by_id($id);
            $data['counts'] = $count = $this->supplier_screenshots_model->get_count_work_gallery_For_All($id, $supplier_id, $input_data['table'], $start_date, $end_date);
            $data['work_gallery'] = $this->supplier_screenshots_model->get_work_gallery_For_All($id, $supplier_id, $input_data['table'], $start_date, $end_date, $count[0]->totals);

            echo $this->rest_controller->response(json_encode($data), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        }
    }

    public function clockin()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'POST') {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $table = $input_data['table'];
            $supplier_relation_id = $this->supplier_relation_model->get_data_by_id($input_data['relation_id']);

            $data = array(
                'clockin' => date('h:i'),
                'date' => date("Y-m-d"),
                'total' => 0,
                'relation_id' => $supplier_relation_id->relation_id,
                'created_at' => date('Y-m-d H:i:s')
            );

            $time_check = $this->time_check_model->get_by_relation_id_date($supplier_relation_id->id, date("Y-m-d"));
            if (!empty($time_check)) {
                $response = array('status' => false, 'code' => $this->rest_controller::HTTP_CONFLICT, 'message' => 'You are already time in another process', 'url' => base_url('' . $table . '/view/' . $supplier_relation_id->relation_id));
                echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
            } else {
                if (!empty($time_check)) {
                    $response = array('status' => false, 'code' => $this->rest_controller::HTTP_CONFLICT, 'message' => 'Please time out from ', 'url' => base_url('' . $table . '/view/' . $supplier_relation_id->relation_id));
                    echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
                } else {
                    $rel_data = $this->supplier_relation_model->get_relation_data($supplier_relation_id->relation_id, $input_data['supplier_id'], $supplier_relation_id->table_name);
                    if ($rel_data) {
                        if ($this->db->insert('time_check', $data)) {
                            $inserted_id = $this->db->insert_id();
                            $response = [
                                'table' => $table,
                                'project_name' => $rel_data->name,
                                'clockin' => $input_data['time'],
                                'project_id' => $supplier_relation_id->relation_id,
                                'relation_id' => $supplier_relation_id->id,
                                'send_image' => true,
                                'time_check_id' => $inserted_id,
                                'url' => base_url('api/home/upload_image'),
                                'parameters' => array('supplier_id' => '', 'relation_id' => '', 'image' => ''),
                                'message' => 'Time in Successfully',
                                'status' => 'true',
                            ];

                            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
                        }
                    } else {
                        $response = array('status' => false, 'code' => $this->rest_controller::HTTP_NO_CONTENT, 'message' => 'Assign any supplier first', 'url' => base_url('' . $supplier_relation_id->table_name . '/view/' . $supplier_relation_id->relation_id));
                        echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
                    }

                }
            }
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        }
    }

    public function clockout()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'POST') {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $table = $input_data['table'];
            $supplier_relation_id = $this->supplier_relation_model->get_supplier_relation_by_relation_id_supplier_id_table_name($input_data['project_id'], $input_data['id'], $table);

            if ($input_data['time_check_id'] != '') {
                $time_check = $this->time_check_model->get_by_relation_id($input_data['time_check_id']);
            } else {
                $time_check = $this->time_check_model->get_by_relation_id_date($supplier_relation_id->id, date("Y-m-d"));
            }

            if (!empty($time_check)) {
                $to_time = strtotime($time_check->date . ' ' . $time_check->clockin);
                $from_time = strtotime($time_check->date . ' ' . $input_data['time']);
                $time_diff = round(abs($to_time - $from_time) / 60, 2);

                $data = array(
                    'clockout' => date('h:i'),
                    'total' => $time_diff,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $this->db->where('id', $time_check->id);
                $this->db->update('time_check', $data);
                $sesdata = array(
                    'table' => null,
                    'clockin' => null,
                    'project_id' => null,
                    'relation_id' => null,
                    'send_image' => false,
                    'notes' => null,
                    'time_id' => null,
                );
                $response = array('status' => 'true', 'code' => $this->rest_controller::HTTP_NO_CONTENT, 'message' => 'Time out successfully', 'url' => base_url('' . $table . '/view/' . $input_data['project_id']));
                echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
            } else {
                $response = array('status' => 'false', 'code' => $this->rest_controller::HTTP_NO_CONTENT, 'message' => 'Please time in to ' . $table . ' before time out.', 'url' => base_url('' . $table . '/view/' . $input_data['project_id']));
                echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
            }
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
        }
    }

    public function check()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'POST') {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $rel_data = $this->time_check_model->check_relation_data($input_data['supplier_id']);
            $data['relation_data'] = $rel_data;


            if (!empty($rel_data)) {
                $project = $this->supplier_relation_model->get_relation_data($rel_data->relation_id, $rel_data->supplier_id, $rel_data->table_name);
                $data[$rel_data->table_name] = $project;
                $response = [
                    'data' => $data,
                    'status' => true,
                    'message' => "You have already time in ".$rel_data->table_name
                ];
            }else
            {
                $response = [
                    'data' => $data,
                    'status' => false,
                    'message' => "You are not time in any task"
                ];
            }


            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
        }
    }
}