<?php


class project_model extends CI_Model
{
    /**
     * project_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('supplier_relation_model');
        $this->load->model('notification_model');
    }

    /* public function get_project_by_id($id)
     {
         $query = $this->db->get_where('projects', array('id' => $id));
         return $query->row();
     }*/

    public function get_project_by_id($id)
    {
        $this->db->select('projects.*,user.name as manager_name');
        $this->db->from('projects');
        $this->db->join('users as user', 'user.user_id = projects.user_id');
        $this->db->where('projects.id',$id);

        if ($this->session->userdata('role') == 'Supplier') {
            $this->db->where('projects.supplier_archive = 1');

        }elseif($this->session->userdata('role') == '0')
        {
            $this->db->where('projects.manager_archive = 1');
        }else
        {
            $this->db->where('projects.admin_archive = 1');
        }
        $query = $this->db->get();

        return $query->row();
    }


    public function get_all_projects_by_manager_id($id)
    {

        $this->db->select('*');
        $this->db->from('projects');
        $this->db->where('user_id',  $id);

        if ($this->session->userdata('role') == 'Supplier') {
            $this->db->where('projects.supplier_archive = 1');

        }elseif($this->session->userdata('role') == '0')
        {
            $this->db->where('projects.manager_archive = 1');
        }else
        {
            $this->db->where('projects.admin_archive = 1');
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function GetProjectType()
    {
        $this->db->select('*');
        $this->db->from('project_type');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_projects_by_company_id($company_id)
    {
        $this->db->select('projects.*,type.project_type,user.name as manager_name');
        $this->db->from('projects');
        $this->db->join('project_type as type', 'type.id = projects.type_id');
        $this->db->join('users as user', 'user.user_id = projects.user_id');
        if ($this->session->userdata('role') == 'Supplier') {
            $this->db->where('projects.supplier_archive = 1');

        }elseif($this->session->userdata('role') == '0')
        {
            $this->db->where('projects.manager_archive = 1');
        }else
        {
            $this->db->where('projects.admin_archive = 1');
        }
        $this->db->where('user.company_id',$company_id);
        $query = $this->db->get();
        return $query->result();
    }


    public function createOrUpdate()
    {
        $data = array(
            'type_id' => $this->input->post('type_id'),
            'name' => $this->input->post('name'),
            'accounts_code' => $this->input->post('accounts_code'),
            'client_name' => $this->input->post('client_name'),
            'accounts_number' => $this->input->post('accounts_number'),
            'user_id' => $this->input->post('user_id'),
            'due_date' => $this->input->post('due_date'),
            'status' => $this->input->post('status'),
            'description' => $this->input->post('description'),
            'created_at' => date('Y-m-d H:i:s', strtotime('now')),
        );
        $id = $this->input->post('id');

        if (empty($id)) {

            $suppliers = $this->input->post('suppliers');
            $this->db->insert('projects', $data);
            $insert_id = $this->db->insert_id();

            foreach ($suppliers as $supplier) {
                $relation_data = array(
                    'supplier_id' => $supplier,
                    'relation_id' => $insert_id,
                    'table_name' => 'projects',
                    'created_at' => date('Y-m-d H:i:s', strtotime('now'))
                );

                $this->db->insert('supplier_relations', $relation_data);

            }
            return $this->db->insert_id();
        } else {
            $this->db->where('id', $id);
            $this->db->update('projects', $data);

            $suppliers = $this->input->post('suppliers');
            $remove_suppliers = explode(',', $this->input->post('remove_suppliers'));

            foreach ($suppliers as $key => $supplier) {

                $supplier_relations_total = $this->supplier_relation_model->get_supplier_relation_by_relation_id_supplier_id_table_name($id, $supplier, 'projects');

                $suppliers_total = count($suppliers);

                if (empty($supplier_relations_total)) {
                    $relation_data = array(
                        'supplier_id' => $supplier,
                        'relation_id' => $id,
                        'table_name' => 'projects',
                        'created_at' => date('Y-m-d H:i:s', strtotime('now'))
                    );
                    $this->db->insert('supplier_relations', $relation_data);
                }

                if (!empty($remove_suppliers)) {
                    foreach ($remove_suppliers as $remove_supplier) {

                        $supplier_relations = $this->supplier_relation_model->get_supplier_relation_by_relation_id_supplier_id_table_name($id, $remove_supplier, 'projects');
                        $supplier_relations_count = count($supplier_relations);

                        if ($supplier_relations_count > 0) {
                            $this->supplier_relation_model->delete($supplier_relations->id, 'projects');
                        }
                    }
                }
            }
        }
        return $this->db->insert_id();
    }


    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('projects');
    }

    public function archive($id)
    {
        $this->db->where('id', $id);
        if ($this->session->userdata('role') == 'Supplier') {
            $data = [
                'supplier_archive' => 0
            ];
        }elseif($this->session->userdata('role') == '0')
        {
            $data = [
                'manager_archive' => 0
            ];
        }else
        {
            $data = [
                'admin_archive' => 0
            ];
        }
        return $this->db->update('projects', $data);
    }

    public function restore($id)
    {
        $this->db->where('id', $id);
        if ($this->session->userdata('role') == 'Supplier') {
            $data = [
                'supplier_archive' => 1
            ];
        }elseif($this->session->userdata('role') == '0')
        {
            $data = [
                'manager_archive' =>1
            ];
        }else
        {
            $data = [
                'admin_archive' =>1
            ];
        }
        return $this->db->update('projects', $data);
    }

}