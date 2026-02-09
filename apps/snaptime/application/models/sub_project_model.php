<?php


class sub_project_model extends CI_Model
{
    /**
     * project_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }

    public function fetch_sub_project($id)
    {
        $this->db->where('project_id', $id);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('sub_projects');
        $output = '<option value="">Select Sub Project</option>';
        foreach($query->result() as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        return $output;
    }
    public function get_all_sub_projects_by_project_id($id)
    {
        $this->session->set_userdata('previous_url', current_url());
        $query = $this->db->get_where('sub_projects', array('project_id' => $id));
        return $query->result();
    }

    public function get_project_by_id($id)
    {
        $query = $this->db->get_where('sub_projects', array('id' => $id));
        return $query->row();
    }

    public function createOrUpdate($project_id)
    {
        $this->session->set_userdata('previous_url', current_url());
        $data = array(
            'name' => $this->input->post('sub_project_name'),
            'priority' => $this->input->post('priority'),
            'status' => $this->input->post('status'),
            'description' => $this->input->post('description'),
            'due_date' => $this->input->post('due_date'),
            'project_id' => $project_id,
            'created_at' => date('Y-m-d H:i:s', strtotime('now'))
        );
        $id = $this->input->post('id');

        if (empty($id)) {


            $suppliers = $this->input->post('suppliers');
            $this->db->insert('sub_projects', $data);
            $insert_id = $this->db->insert_id();

            foreach ($suppliers as $supplier) {
                $relation_data = array(
                    'supplier_id' => $supplier,
                    'relation_id' => $insert_id,
                    'table_name' => 'sub_projects',
                    'created_at' => date('Y-m-d H:i:s', strtotime('now'))
                );

                $this->db->insert('supplier_relations', $relation_data);
            }
            return $this->db->insert_id();
        } else {
            $this->db->where('id', $id);
            $this->db->update('sub_projects', $data);

            $suppliers = $this->input->post('suppliers');
            $remove_suppliers = explode(',', $this->input->post('remove_suppliers'));

            foreach ($suppliers as $key => $supplier) {

                $supplier_relations_total = $this->supplier_relation_model->get_supplier_relation_by_relation_id_supplier_id_table_name($id, $supplier, 'sub_projects');

                $suppliers_total = count($suppliers);

                if (empty($supplier_relations_total)) {
                    $relation_data = array(
                        'supplier_id' => $supplier,
                        'relation_id' => $id,
                        'table_name' => 'sub_projects',
                        'created_at' => date('Y-m-d H:i:s', strtotime('now'))
                    );
                    $this->db->insert('supplier_relations', $relation_data);
                }

                if (!empty($remove_suppliers)) {
                            foreach ($remove_suppliers as $remove_supplier) {

                                $supplier_relations = $this->supplier_relation_model->get_supplier_relation_by_relation_id_supplier_id_table_name($id, $remove_supplier, 'sub_projects');

                                $supplier_relations_count = count($supplier_relations);
                                if ($supplier_relations_count > 0) {
                                    $this->supplier_relation_model->delete($supplier_relations->id, 'sub_projects');
                                }
                            }
                }
            }
        }

        return $this->db->insert_id();
    }


    public function delete($id)
    {
        $previous_url = $this->session->userdata('previous_url');
        $this->db->where('id', $id);
        $this->db->delete('sub_projects');
        return redirect($previous_url);
    }

}