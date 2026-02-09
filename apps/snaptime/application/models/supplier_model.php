<?php

class supplier_model extends CI_Model
{

    public function createOrUpdate()
    {
        $data = array(
            'supplier_type_id' => $this->input->post('supplier_type_id'),
            'accounts_code' => $this->input->post('accounts_code'),
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'start_date' => $this->input->post('start_date'),
            'phone_number' => $this->input->post('phone_number'),
            'website' => $this->input->post('website'),
            'resume' => $_FILES['resume']['name'],
            'trade_id' => $this->input->post('trade_id'),
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'zipcode' => $this->input->post('zipcode'),
            'unit_payment_rate' => $this->input->post('unit_payment_rate'),
            'notes' => $this->input->post('notes'),
            'skills' => $this->input->post('skills'),
            'quality' => $this->input->post('quality'),
            'teamwork' => $this->input->post('teamwork'),
            'speed' => $this->input->post('speed'),
            'nda_status' => $this->input->post('nda_status'),
            'starter_form_status' => $this->input->post('starter_form_status'),
            'company_id' => $this->session->userdata('company_id'),
            'department_id' => $this->input->post('department_type_id'),
            'created_at' => date('Y-m-d H:i:s', strtotime('now')),
        );
        $id = $this->input->post('id');

        if (empty($id)) {

            $this->load->library('event');

            $Content = array();

            $Content['name'] = $this->input->post('name');
            $Content['email'] = $this->input->post('email');
            $Content['password'] = $this->input->post('password');

            $datas['to'] = $this->input->post('email');
            //$data['to'] = 'haseeb.idevation@gmail.com';
            $datas['subject'] = 'Supplier Added - Scruffy Dog';

            $datas['body'] = $this->load->view('emails/supplieradded', $Content, true);

            $this->event->email($datas);
            if (!empty($_FILES['starter_form']['name'])) {
                $data1 = array('nda' => $_FILES['nda']['name'],
                    'starter_form' => $_FILES['starter_form']['name']);
                $data_all = array_merge($data, $data1);
                $location = 'assets/supplier/' . $insert_id . '/';
                if (!is_dir($location)) {
                    if (!mkdir($location, 0755, true) && !is_dir($location)) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $location));
                    }
                }
                $file = $location . basename($_FILES['starter_form']['name']);
                if (move_uploaded_file($_FILES['starter_form']['tmp_name'], $file)) {
                    echo "success";
                } else {
                    echo "error";
                }
            } else {
                $data_all = $data;
            }
            if (!empty($_FILES['nda']['name'])) {
                $data1 = array('nda' => $_FILES['nda']['name']);
                $data_all = array_merge($data, $data1);

                $location = 'assets/supplier/' . $insert_id . '/';
                if (!is_dir($location)) {
                    if (!mkdir($location, 0755, true) && !is_dir($location)) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $location));
                    }
                }
                $file = $location . basename($_FILES['nda']['name']);
                if (move_uploaded_file($_FILES['nda']['tmp_name'], $file)) {
                    echo "success";
                } else {
                    echo "error";
                }
            } else {
                $data_all = $data;
            }

            $this->db->insert('supplier', $data_all);
            $insert_id = $this->db->insert_id();

        } else {

            if (!empty($_FILES['starter_form']['name'])) {
                $data1 = array('starter_form' => $_FILES['starter_form']['name']);
                $location = 'assets/supplier/' . $id . '/';
                if (!is_dir($location)) {
                    if (!mkdir($location, 0755, true) && !is_dir($location)) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $location));
                    }
                }
                $file = $location . basename($_FILES['starter_form']['name']);
                if (move_uploaded_file($_FILES['starter_form']['tmp_name'], $file)) {
                    $this->db->where('id', $id);
                    $this->db->update('supplier', $data1);
                }
            }
            if (!empty($_FILES['nda']['name'])) {
                $data1 = array('nda' => $_FILES['nda']['name']);
                $location = 'assets/supplier/' . $id . '/';
                if (!is_dir($location)) {
                    if (!mkdir($location, 0755, true) && !is_dir($location)) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $location));
                    }
                }
                $file = $location . basename($_FILES['nda']['name']);
                if (move_uploaded_file($_FILES['nda']['tmp_name'], $file)) {
                    $this->db->where('id', $id);
                    $this->db->update('supplier', $data1);
                }
            }

            $this->db->where('id', $id);
            $this->db->update('supplier', $data);

            $supplier = $this->get_supplier_by_id($id);
            if(!empty($supplier->nda) && !empty($supplier->starter_form))
            {
                $status = array('status'=>1);
                $this->db->where('id', $id);
                $this->db->update('supplier', $status);
            }
            return true;
        }
    }

    public function GetAllSupplierByCompanyID($company_id)
    {

        $query = $this->db->get('supplier');
        $this->db->select('supplier.*,supplier_department.name as department_name,supplier_trade.trade_name');
        $this->db->select('supplier_type.name as supplier_name');
        $this->db->from('supplier');
        $this->db->join('supplier_department', 'supplier_department.id = supplier.department_id', 'left');
        $this->db->join('supplier_type', 'supplier_type.id = supplier.supplier_type_id', 'left');
        $this->db->join('supplier_trade', 'supplier_trade.trade_id = supplier.trade_id', 'left');
        $this->db->where('supplier.company_id', $company_id);

        $query = $this->db->get();
        return $query->result();
    }

    public function GetAllSupplierTrade()
    {

        $this->db->select('*');
        $this->db->from('supplier_trade');
        $query = $this->db->get();
        return $query->result();
    }

    public function GetLatestSupplier()
    {
        $this->db->select('*');
        $this->db->from('supplier');
        $this->db->limit('5');
        $this->db->order_by('id', 'desc');

        $query = $this->db->get();
        return $query->result();
    }

    public function GetLatestProjects()
    {
        $this->db->select('projects.*,u.name as manager_name');
        $this->db->from('projects');
        $this->db->join('users  as u', 'u.user_id = projects.user_id');
        $this->db->limit('8');
        $this->db->order_by('id', 'desc');

        $query = $this->db->get();

        return $query->result();
    }


    public function get_supplier_by_id($id)
    {
        $query = $this->db->get_where('supplier', array('id' => $id));
        return $query->row();
    }

    public function GetSupplierType()
    {

        $this->db->select('*');
        $this->db->from('supplier_type');

        $query = $this->db->get();
        return $query->result();
    }

    public function GetSupplierTypeByID($id)
    {
        $query = $this->db->get_where('supplier_type', array('id' => $id));
        return $query->row();

    }

    public function GetSupplierDepartment($company_id)
    {
        $this->db->select('*');
        $this->db->from('supplier_department');
        $this->db->where('company_id',$company_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function store_department()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'company_id' => $this->session->userdata('company_id'),
        );
        $this->db->insert('supplier_department', $data);
        return true;
    }
    public function update_department($id)
    {
        $data = array(
            'name' => $this->input->post('name'),
        );
        $this->db->where('id', $id);
        $this->db->update('supplier_department', $data);
        return true;
    }
    public function delete_department($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('supplier_department');
        return true;
    }
    public function GetSupplierDepartmentByID($id)
    {
        $query = $this->db->get_where('supplier_department', array('id' => $id));
        return $query->row();
    }


    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('supplier');
    }

    public function checkEmail($email)
    {
        $this->db->select('*');
        $this->db->from('supplier');
        $this->db->where('email', $email);

        $query = $this->db->get();
        return $query->result();
    }

    public function updateEmailWithToken($data, $token)
    {
        $this->db->set('verification_key', $token);
        $this->db->where('email', $data);
        $this->db->update('supplier');

        if ($this->db->affected_rows() > 0) {
            return 'Done';
        } else {
            return "Fail";
        }
    }

    public function GetUserDetailsByToken($token)
    {
        $this->db->select('*');
        $this->db->from('supplier');
        $this->db->where('verification_key', $token);

        $query = $this->db->get();
        return $query->result();
    }

    public function ChangePasswordById($posteddata, $id)
    {
        $this->db->set($posteddata);
        $this->db->where('id', $id);
        $this->db->update('supplier');

        if ($this->db->affected_rows() > 0) {
            return 'Done';
        } else {
            return "Fail";
        }
    }


}