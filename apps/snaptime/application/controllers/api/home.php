<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS'); 
 header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
 
 
 header('Access-Control-Allow-Credentials: true');

class home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier_screenshots_model');
        $this->load->model('project_model');
        $this->load->model('sub_project_model');
        $this->load->library('rest_controller');
        $this->load->library('upload');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
            echo $this->rest_controller->response('', $this->rest_controller::HTTP_OK);
        }
    }

    public function supplier_projects($supplier_id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'GET') {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $latest_project = $this->supplier_relation_model->GetLatestProjectsBySupplierID($supplier_id);

            echo $this->rest_controller->response(json_encode($latest_project), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        }
    }

    public function latest_tasks($supplier_id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'GET') {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $latest_tasks = $this->supplier_relation_model->GetLatestTasksBySupplierID($supplier_id);
            echo $this->rest_controller->response(json_encode($latest_tasks), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        }
    }

    public function latest_screenshots($supplier_id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'GET') {
            $latest_screenshots = $this->supplier_relation_model->GetLatestScreenshotsWithLatestWork($supplier_id);
            echo $this->rest_controller->response(json_encode($latest_screenshots), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);

        }
    }

    public function upload_image()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $supplier_id = $input_data['supplier_id'];
        $relation_id = $input_data['relation_id'];
        $UPLOAD_DIR = "./assets/supplier/" . $supplier_id . "/" . $relation_id;
        $base_64_data = $input_data['image'];

        if (!is_dir($UPLOAD_DIR)) {
            if (!mkdir($UPLOAD_DIR, 0777, TRUE) && !is_dir($UPLOAD_DIR)) {
                echo new \RuntimeException(sprintf('Directory "%s" was not created', $UPLOAD_DIR));
            }
        }
        if (isset($supplier_id) && isset($relation_id)) {

            $image_name = $supplier_id . "-" . $relation_id . "-" . date('Y-m-dHis');
            if (!file_put_contents($UPLOAD_DIR . "/" . $image_name . '.jpg', base64_decode($base_64_data))) {
                $error = array('error' => $base_64_data);
                echo json_encode($error);
            } else {
                $store_data = array(
                    'file' => $image_name . '.jpg',
                    'status' => '1',
                    'relation_id' => $relation_id,
                    'supplier_id' => $supplier_id
                );
                $this->db->insert('supplier_screenshots', $store_data);

                $responseArray = array('file' => $image_name . '.jpg', 'relation_id' => $relation_id,
                    'supplier_id' => $this->input->post('supplier_id'), 'created_at' => date("H:i d/m/Y"));

                return $responseArray;
            }
        }

    }

    public function upload_ss($id)
    {
        if ($this->session->userdata('role') == 'Supplier') {
            $supplier_id = $this->session->userdata('id');
            $Is_relation = $this->supplier_relation_model->get_supplier_relation_by_relation_id_table_name_and_supplierid($id, $supplier_id, 'projects');
            $UPLOAD_DIR = "assets/supplier/" . $Is_relation[0]->supplier_id . "/" . $Is_relation[0]->id . '/';

            $last = array_key_last($_FILES['screenshots']['name']);

            // Configure upload directory and allowed file types
            $allowed_types = array('jpg', 'png', 'jpeg', 'gif');

            // Define maxsize for files i.e 2MB
            $maxsize = 2 * 1024 * 1024;

            // Checks if user sent an empty form
            if (!empty(array_filter($_FILES['screenshots']['name']))) {

                // Loop through each file in files[] array
                foreach ($_FILES['screenshots']['tmp_name'] as $key => $value) {

                    $file_tmpname = $_FILES['screenshots']['tmp_name'][$key];
                    $file_name = $_FILES['screenshots']['name'][$key];
                    $file_size = $_FILES['screenshots']['size'][$key];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                    // Set upload file path
                    $filepath = $UPLOAD_DIR . $file_name;

                    // Check file type is allowed or not
                    if (in_array(strtolower($file_ext), $allowed_types)) {

                        // Verify file size - 2MB max
                        if ($file_size > $maxsize)
                            redirect('projects/view/' . $id);

                        // If file with name already exist then append time in
                        // front of name of the file to avoid overwriting of file
                        if (file_exists($filepath)) {
                            $filepath = $filepath . time() . $file_name;
                            if (!is_dir($UPLOAD_DIR)) {
                                if (!mkdir($UPLOAD_DIR, 0777, true) && !is_dir($UPLOAD_DIR)) {
                                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $UPLOAD_DIR));
                                }
                            }
                            if (move_uploaded_file($file_tmpname, $filepath)) {
                                $store_data = array(
                                    'file' => $file_name,
                                    'status' => '1',
                                    'description' => $this->input->post('description'),
                                    'relation_id' => $Is_relation[0]->id,
                                    'supplier_id' => $Is_relation[0]->supplier_id
                                );
                                $this->db->insert('supplier_screenshots', $store_data);
                                if ($last == $key) {
                                    redirect('projects/view/' . $id);
                                }
                            } else {
                                redirect('projects/view/' . $id);
                            }
                        } else {
                            if (!is_dir($UPLOAD_DIR)) {
                                if (!mkdir($UPLOAD_DIR, 0777, true) && !is_dir($UPLOAD_DIR)) {
                                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $UPLOAD_DIR));
                                }
                            }
                            if (move_uploaded_file($file_tmpname, $filepath)) {
                                $store_data = array(
                                    'file' => $file_name,
                                    'status' => '1',
                                    'description' => $this->input->post('description'),
                                    'relation_id' => $Is_relation[0]->id,
                                    'supplier_id' => $Is_relation[0]->supplier_id
                                );
                                $this->db->insert('supplier_screenshots', $store_data);
                                if ($last == $key) {
                                    redirect('projects/view/' . $id);
                                }
                            } else {
                                redirect('projects/view/' . $id);
                            }
                        }
                    } else {

                        redirect('projects/view/' . $id);
                    }
                }
            } else {
                redirect('projects/view/' . $id);
            }

            if (empty($Is_relation)) {
                redirect('/home?AlertMessage=You+are+not+assign+to+this+project');
            }

        }

    }

    public function sub_projects($id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'GET') {
            $data['project'] = $project = $this->project_model->get_project_by_id($id);

            $data['sub_projects'] = $sub_project = $this->sub_project_model->get_all_sub_projects_by_project_id($project->id);
            echo $this->rest_controller->response(json_encode($data), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
        }
    }

    public function tasks($id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'GET') {
            $data['project'] = $project = $this->project_model->get_project_by_id($id);
            $data['sub_projects'] = $sub_project = $this->sub_project_model->get_all_sub_projects_by_project_id($project->id);
            $data['tasks'] = $tasks = $this->task_model->get_all_sub_tasks_by_sub_project_id($id);

            echo $this->rest_controller->response(json_encode($data), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
        }
    }

    public function sub_tasks($id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'GET') {
            $data['tasks'] = $tasks = $this->task_model->get_task_by_id($id);
            $data['sub_tasks'] = $sub_tasks = $this->sub_task_model->get_all_sub_tasks_by_task_id($tasks->id);

            echo $this->rest_controller->response(json_encode($data), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
        }
    }

    public function frequency()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'GET') {
            $data['frequency'] = $this->user_model->get_frequency();
            echo $this->rest_controller->response(json_encode($data), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
        }
    }

    public function requests()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method == 'POST') {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $data[0]['url'] =  base_url('api/authentication/application_login');
            $data[0]['parameters'] = array('email'=>$input_data['email']);
            $data[0]['method'] = 'POST';

            $data[1]['url'] = base_url('api/home/sub_projects/');
            $data[1]['parameters'] = array('project_id'=>$input_data['project_id']);
            $data[1]['method'] = 'GET';

            $data[2]['url'] =  base_url('api/home/tasks/');
            $data[2]['parameters'] = array('project_id'=>$input_data['project_id']);
            $data[2]['method'] = 'GET';

            $data[3]['url'] =  base_url('api/home/sub_tasks/');
            $data[3]['parameters'] = array('task_id'=>$input_data['task_id']);
            $data[3]['method'] = 'GET';

            $data[4]['url'] =  base_url('api/home/frequency');
            $data[4]['method'] = 'GET';

            echo $this->rest_controller->response(json_encode($data), $this->rest_controller::HTTP_OK);
        } else {
            $response = [
                'status' => False,
                'message' => 'Invalid Method',
            ];
            echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);
        }
    }
}