<?php

class supplier_login_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('time_check_model');
        $this->load->model('company_model');
        $this->load->model('supplier_relation_model');
        $this->load->library('session');
    }

    function can_login($email, $password, $company_id)
    {
        $this->db->where('email', $email);
        $this->db->where('company_id', $company_id);
        $query = $this->db->get('supplier');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if ($row->is_email_verified == 'yes') {
                    $store_password = $row->password;
                    if ($password == $store_password) {
                        $name = $row->name;
                        $email = $row->email;
                        $id = $row->id;
                        $company = $this->company_model->get_by_id($company_id);
                        $sesdata = array(
                            'username' => $name,
                            'email' => $email,
                            'id' => $id,
                            'role' => "Supplier",
                            'logged_in' => TRUE,
                            'company_name' => $company->name,
                            'company_id' => $company->id,
                        );
                        $this->session->set_userdata($sesdata);

                        $rel_data = $this->time_check_model->check_relation_data($id);

                        if (!empty($rel_data)) {
                            $project = $this->supplier_relation_model->get_relation_data($rel_data->relation_id, $rel_data->supplier_id, $rel_data->table_name);
                            if ($rel_data) {
                                $sesiondata = array(
                                    'table' => $rel_data->table_name,
                                    'project_name' => $project->name,
                                    'clockin' => $rel_data->clockin,
                                    'project_id' => $project->id,
                                    'time_check_id' => $rel_data->id,
                                );
                                $this->session->set_userdata($sesiondata);
                            }
                        }
                        return 'true';
                    } else {
                        return 'Email address or Password is wrong';
                    }
                } else {
                    return 'First verified your email address';
                }
            }
        } else {
            return 'Email address or Password is wrong';
        }
    }

    function api_login($email, $password)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('supplier');


        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                if ($row->is_email_verified == 'yes') {
                    $store_password = $row->password;
                    if ($password == $store_password) {


                        $name = $row->name;
                        $email = $row->email;
                        $id = $row->id;

//                        $rel_data = $this->time_check_model->check_relation_data($row->id);



//                        if (!empty($rel_data)) {
//                            $project = $this->supplier_relation_model->get_relation_data($rel_data->relation_id, $rel_data->supplier_id, $rel_data->table_name);
//
//                            if ($rel_data) {
//                                $sesiondata = array(
//                                    'table' => $rel_data->table_name,
//                                    'project_name' => $project->name,
//                                    'clockin' => $rel_data->clockin,
//                                    'project_id' => $project->id,
//                                    'time_check_id' => $rel_data->id,
//                                );
//
//                            }
//                        }
                        $response = json_encode([
                            'status' => TRUE,
                            'message' => 'Supplier Login Successfully',
                            'data' => $row,
                        ]);
                        return $response;
                    } else {
                        $response = json_encode([
                            'status' => FALSE,
                            'message' => 'Email address or Password is wrong',
                            'data' => null,
                        ]);
                        return $response;
                    }
                } else {
                    $response = json_encode([
                        'status' => FALSE,
                        'message' => 'First verified your email address',
                        'data' => null,
                    ]);
                    return $response;
                }
            }
        } else {
            $response = json_encode([
                'status' => FALSE,
                'message' => 'Email address or Password is wrong',
                'data' => null,
            ]);
            return $response;
        }
    }

    function application_login($email)
    {

            $sql="Select * from supplier where md5(email) = '".$email."' ";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {

                foreach ($query->result() as $row) {
                    if ($row->is_email_verified == 'yes') {
                            $name = $row->name;
                            $email = $row->email;
                            $id = $row->id;

//                        $rel_data = $this->time_check_model->check_relation_data($row->id);


//                        if (!empty($rel_data)) {
//                            $project = $this->supplier_relation_model->get_relation_data($rel_data->relation_id, $rel_data->supplier_id, $rel_data->table_name);
//
//                            if ($rel_data) {
//                                $sesiondata = array(
//                                    'table' => $rel_data->table_name,
//                                    'project_name' => $project->name,
//                                    'clockin' => $rel_data->clockin,
//                                    'project_id' => $project->id,
//                                    'time_check_id' => $rel_data->id,
//                                );
//
//                            }
//                        }
                            $response = ([
                                'status' => TRUE,
                                'message' => 'Supplier Login Successfully',
                                'data' => $row,
                            ]);
                            return $response;

                    } else {
                        $response = ([
                            'status' => FALSE,
                            'message' => 'First verified your email address',
                            'data' => null,
                        ]);
                        return $response;
                    }
                }
            } else {
                $response = ([
                    'status' => FALSE,
                    'message' => 'Email address or Password is wrong',
                    'data' => null,
                ]);
                return $response;
            }
    }
}

