<?php


class task_model extends CI_Model
{
    /**
     * project_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }
    public function get_all_sub_tasks_by_sub_project_id($id)
    {
        $this->session->set_userdata('previous_url', current_url());
        $query = $this->db->get_where('tasks', array('sub_project_id' => $id));
        return $query->result();
    }
    public function fetch_task($id)
    {
        $this->db->where('sub_project_id', $id);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('tasks');
        $output = '<option value="">Select Task</option>';
        foreach($query->result() as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        return $output;
    }
    public function get_task_by_id($id)
    {
        $query = $this->db->get_where('tasks', array('id' => $id));
        return $query->row();
    }
    public function createOrUpdate($project_id)
    {
        $this->session->set_userdata('previous_url', current_url());
        $data=array(
            'name'=> $this->input->post('task_name'),
            'priority'=> $this->input->post('priority'),
            'status'=> $this->input->post('status'),
            'due_date'=> $this->input->post('due_date'),
            'description'=> $this->input->post('description'),
            'sub_project_id'=> $project_id,
            'updated_at'=> date('Y-m-d H:i:s',strtotime('now'))
        );
        $id = $this->input->post('id');

        if (empty($id)) {

            $suppliers = $this->input->post('suppliers');
            $this->db->insert('tasks',$data);
            $insert_id = $this->db->insert_id();
            
           foreach($suppliers as $supplier)
           {
             $relation_data = array(
               'supplier_id'=>$supplier,
               'relation_id'=>$insert_id,
               'table_name'=>'tasks',
              );
           
             $this->db->insert('supplier_relations',$relation_data);
           }
           return true;
        }else {
            $this->db->where('id', $id);
            $this->db->update('tasks', $data);

            $suppliers = $this->input->post('suppliers');
            $remove_suppliers = explode(',', $this->input->post('remove_suppliers'));

            foreach ($suppliers as $key => $supplier) {

                $supplier_relations_total = $this->supplier_relation_model->get_supplier_relation_by_relation_id_supplier_id_table_name($id, $supplier, 'tasks');

                $suppliers_total = count($suppliers);

                if (empty($supplier_relations_total)) {
                    $relation_data = array(
                        'supplier_id' => $supplier,
                        'relation_id' => $id,
                        'table_name' => 'tasks',
                        'created_at' => date('Y-m-d H:i:s', strtotime('now'))
                    );
                    $this->db->insert('supplier_relations', $relation_data);
                }

                if (!empty($remove_suppliers)) {
                    foreach ($remove_suppliers as $remove_supplier) {

                        $supplier_relations = $this->supplier_relation_model->get_supplier_relation_by_relation_id_supplier_id_table_name($id, $remove_supplier, 'tasks');

                        $supplier_relations_count = count($supplier_relations);

                        if ($supplier_relations_count > 0) {
                            $this->supplier_relation_model->delete($supplier_relations->id, 'tasks');
                        }
                    }
                }
            }
        }
        return true;
    }
    public function delete($id)
    {
        $previous_url = $this->session->userdata('previous_url');
        $this->db->where('id', $id);
        $this->db->delete('tasks');
        return redirect($previous_url);
    }

}