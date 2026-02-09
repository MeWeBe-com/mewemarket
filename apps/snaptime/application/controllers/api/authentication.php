<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');

header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

header('Access-Control-Allow-Credentials: true');

header('Content-Type: application/json');



class authentication extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        // Load the user model

        $this->load->model('user_model');

        $this->load->model('login_model');

        $this->load->model('company_model');

        $this->load->model('supplier_login_model');

        $this->load->library('rest_controller');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {

            echo $this->rest_controller->response('', $this->rest_controller::HTTP_OK);

        }

    }


    public function admin_login()

    {

        // Get the post data

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $email = $input_data['email'];

        $password = $input_data['password'];



        // Validate the post data

        if (!empty($email) && !empty($password)) {



            // Check if any user exists with the given credentials

            $user = $this->login_model->api_login($email, $password);



            if (isset($user)) {

                // Set the response and exit

                echo $this->rest_controller->response(($user), $this->rest_controller::HTTP_OK);

            } else {

                // Set the response and exit

                //BAD_REQUEST (400) being the HTTP response code

                echo $this->rest_controller->response("Wrong email or password.", $this->rest_controller::HTTP_BAD_REQUEST);

            }

        } else {

            // Set the response and exit

            echo $this->rest_controller->response("Provide email and password.", $this->rest_controller::HTTP_BAD_REQUEST);

        }

    }



    public function supplier_login()

    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $email = $input_data['email'];

        $password = $input_data['password'];



        if (!empty($email) && !empty($password)) {

            // Check if any user exists with the given credentials

            $user = $this->supplier_login_model->api_login($email, $password);



            if (isset($user)) {

                // Set the response and exit



                echo $this->rest_controller->response(($user), $this->rest_controller::HTTP_OK);

            } else {

                // Set the response and exit

                //BAD_REQUEST (400) being the HTTP response code

                echo $this->rest_controller->response("Wrong email or password.", $this->rest_controller::HTTP_BAD_REQUEST);

            }

        } else {

            // Set the response and exit

            echo $this->rest_controller->response("Provide email and password.", $this->rest_controller::HTTP_BAD_REQUEST);

        }

    }



    public function application_login()

    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $email = $input_data['email'];



        if (!empty($email)) {

            // Check if any user exists with the given credentials

            $user = $this->supplier_login_model->application_login($input_data['email'], $email);

            $data['user'] = $user;

            if (isset($user)) {



                echo $this->rest_controller->response(json_encode($data), $this->rest_controller::HTTP_OK);

            } else {

                // Set the response and exit

                //BAD_REQUEST (400) being the HTTP response code

                echo $this->rest_controller->response("Wrong email or password.", $this->rest_controller::HTTP_BAD_REQUEST);

            }

        } else {

            // Set the response and exit

            echo $this->rest_controller->response("Provide email and password.", $this->rest_controller::HTTP_BAD_REQUEST);

        }

    }



    public function supplier_projects($user_id)

    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $latest_project = $this->supplier_screenshots_model->get_latest_record($user_id);

       echo $this->rest_controller->response($latest_project, self::HTTP_OK);

    }



    public function registration_post()

    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        // Get the post data

        $first_name = strip_tags($input_data['first_name']);

        $last_name = strip_tags($input_data['last_name']);

        $email = strip_tags($input_data['email']);

        $password = $input_data['password'];

        $phone = strip_tags($input_data['phone']);

        $company = strip_tags($input_data['company']);



        // Validate the post data

        if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password)) {



            // Check if the given email already exists

            $userCount = $this->user_model->getRows($email);



            if ($userCount[0]->Total > 0) {

                // Set the response and exit

               echo $this->rest_controller->response("The given email already exists.",$this->rest_controller::HTTP_BAD_REQUEST);

            } else {

                // Insert user data

                $userData = array(

                    'first_name' => $first_name,

                    'last_name' => $last_name,

                    'email' => $email,

                    'company' => $company,

                    'password' => md5($password),

                    'phone' => $phone

                );

                $insert = $this->user_model->AddNewUser($userData);



                // Check if the user data is inserted

                if ($insert) {

                    // Set the response and exit

                   echo $this->rest_controller->response([

                        'status' => TRUE,

                        'message' => 'The user has been added successfully.',

                        'url' => base_url('login/'.$company),

                        'data' => $insert

                    ],$this->rest_controller::HTTP_OK);

                } else {

                    // Set the response and exit

                   echo $this->rest_controller->response("Some problems occurred, please try again.",$this->rest_controller::HTTP_BAD_REQUEST);

                }

            }

        } else {

            // Set the response and exit

           echo $this->rest_controller->response("Provide complete user info to add.",$this->rest_controller::HTTP_BAD_REQUEST);

        }

    }



    public function user_get($id = 0)

    {

        // Returns all the users data if the id not specified,

        // Otherwise, a single user will be returned.

        $con = $id ? array('id' => $id) : '';

        $users = $this->user->getRows($con);



        // Check if the user data exists

        if (!empty($users)) {

            // Set the response and exit

            //OK (200) being the HTTP response code

           echo $this->rest_controller->response($users,$this->rest_controller::HTTP_OK);

        } else {

            // Set the response and exit

            //NOT_FOUND (404) being the HTTP response code

           echo $this->rest_controller->response([

                'status' => FALSE,

                'message' => 'No user was found.'

            ],$this->rest_controller::HTTP_NOT_FOUND);

        }

    }



    public function getToken()

    {

        $length = 80;

        $token = "";

        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";

        $codeAlphabet .= "0123456789";

        $max = strlen($codeAlphabet);



        for ($i = 0; $i < $length; $i++) {

            $token .= $codeAlphabet[random_int(0, $max - 1)];

        }

        $response = [

            'status' => False,

            'message' => 'Invalid Method',

            'data'=>$token

        ];

        echo $this->rest_controller->response(json_encode($response), $this->rest_controller::HTTP_OK);



    }

    public function register_from_sass(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
		echo "hello";
        print_r($input_data);
        exit;

        $data = array('name'=>$input_data['company_name']);

        $this->db->insert('companies', $data);

        $id = $this->db->insert_id();

        // Get the post data

        $first_name = strip_tags($input_data['first_name']);

        $last_name = strip_tags($input_data['last_name']);

        $email = strip_tags($input_data['email']);

        $role = strip_tags($input_data['role']);

        $password = md5($input_data['password']);

        $company = strip_tags($id);

        // Validate the post data

        if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password)) {

            $userCount = $this->user_model->checkEmail($email);

            if ($userCount->Total > 0) {

                // Set the response and exit
                echo $this->rest_controller->response("The given email already exists.",$this->rest_controller::HTTP_BAD_REQUEST);

            } else {
                // Insert user data

                $userData = array(

                    'name' => $first_name.' '.$last_name,

                    'email' => $email,

                    'role' => $role,

                    'status' => 0,

                    'company_id' => $company,

                    'password' => $password,

                );

                $insert = $this->db->insert('users',$userData);

                // Check if the user data is inserted

                if ($insert) {

                    // Set the response and exit

                    $data = [

                        'status' => TRUE,

                        'message' => 'The user has been added successfully.',

                        'url' => base_url('login/'.$input_data['company_name']),

                    ];

                    echo json_encode($data);

                } else {

                    // Set the response and exit

                    echo $this->rest_controller->response("Some problems occurred, please try again.", $this->rest_controller::HTTP_BAD_REQUEST);

                }

            }

        } else {

            // Set the response and exit

            echo $this->rest_controller->response("Provide complete user info to add.",$this->rest_controller::HTTP_BAD_REQUEST);

        }

    }



}
