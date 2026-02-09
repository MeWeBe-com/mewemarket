<?php

class login_model extends CI_Model
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
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if ($row->is_email_verified == 'yes') {
                    $store_password = $row->password;
                    if (md5($password) == $store_password) {
                        $name = $row->name;
                        $email = $row->email;
                        $role = $row->role;
                        $id = $row->user_id;
                        $company = $this->company_model->get_by_id($company_id);
                        $sesdata = array(
                            'username' => $name,
                            'email' => $email,
                            'role' => $role,
                            'id' => $id,
                            'logged_in' => TRUE,
                            'company_name' => $company->name,
                            'company_id' => $company->id,
                        );
                        $this->session->set_userdata($sesdata);


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
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if ($row->is_email_verified == 'yes') {
                    $store_password = $row->password;
                    if (md5($password) == $store_password) {
                        $name = $row->name;
                        $email = $row->email;
                        $role = $row->role;
                        $id = $row->user_id;

                        $response = json_encode([
                            'status' => TRUE,
                            'message' => 'Admin Login Successfully',
                            'data' => $row,
                        ]);
                        return $response;
                    } else {
                        $response = json_encode([
                            'status' => TRUE,
                            'message' => 'Email address or Password is wrong',
                            'data' => null,
                        ]);
                        return $response;
                    }
                } else {
                    $response = json_encode([
                        'status' => TRUE,
                        'message' => 'First verified your email address',
                        'data' => null,
                    ]);
                    return $response;
                }
            }
        } else {
            $response = json_encode([
                'status' => TRUE,
                'message' => 'Email address or Password is wrong',
                'data' => null,
            ]);
            return $response;
        }
    }

}

?>