<?php


class time_check_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function get_by_relation_id_date($relation_id, $date, $clockout = null)
    {
        $query = $this->db->get_where('time_check', array('relation_id' => $relation_id, 'date' => $date, 'clockout' => $clockout));
        return $query->row();
    }

    public function get_by_relation_id($id)
    {
        $query = $this->db->get_where('time_check', array('id' => $id));
        return $query->row();
    }

    public function get_by_null_clockout()
    {
        $query = $this->db->get_where('time_check', array('clockout' => null));
        return $query->row();
    }

    public function start()
    {
        $table = $this->input->post('table');
        $supplier_relation_id = $this->supplier_relation_model->get_supplier_relation_by_relation_id_supplier_id_table_name($this->input->post('project_id'), $this->session->userdata('id'), $table);
        //print_r($supplier_relation_id);

        $data = array(
            'clockin' => date('h:i'),
            'relation_id' => $supplier_relation_id->sr_id,
            'date' => date("Y-m-d"),
            'company_id' => $this->session->userdata('company_id'),
            'total' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );

        $time_check = $this->get_by_relation_id_date($supplier_relation_id->sr_id, date("Y-m-d"));
        // $null_time_check = $this->get_by_null_clockout($supplier_relation_id->sr_id,date("Y-m-d"));

        if (!empty($time_check)) {
            return array('status' => 'true', 'message' => 'You are already time in another process', 'url' => base_url('' . $table . '/view/' . $this->input->post('project_id')));
        } else {
            if (!empty($time_check)) {
                return array('status' => 'true', 'message' => 'Please time out from ', 'url' => base_url('' . $table . '/view/' . $this->input->post('project_id')));
            } else {
                $rel_data = $this->supplier_relation_model->get_relation_data($this->input->post('project_id'), $this->session->userdata('id'), $table);
                if ($rel_data) {
                    if ($this->db->insert('time_check', $data)) {
                        $inserted_id = $this->db->insert_id();
                        $sesdata = array(
                            'table' => $table,
                            'project_name' => $rel_data->name,
                            'clockin' => $this->input->post('time'),
                            'project_id' => $this->input->post('project_id'),
                            'relation_id' => $supplier_relation_id->sr_id,
                            'send_image' => true,
                            'time_check_id' => $inserted_id,
                        );
                        $this->session->set_userdata($sesdata);
                        return array('id' => $inserted_id, 'status' => 'true', 'message' => 'Time in Successfully', 'url' => base_url('' . $table . '/view/' . $this->input->post('project_id')));
                    }
                } else {
                    return array('status' => 'false', 'message' => 'Assign any supplier first', 'url' => base_url('' . $table . '/view/' . $this->input->post('project_id')));
                }

            }
        }
    }

    public function stop()
    {
        $table = $this->input->post('table');
        $supplier_relation_id = $this->supplier_relation_model->get_supplier_relation_by_relation_id_supplier_id_table_name($this->input->post('project_id'), $this->session->userdata('id'), $table);

        if ($this->session->userdata('time_check_id') != '') {
            $time_check = $this->get_by_relation_id($this->session->userdata('time_check_id'));
        } else {
            $time_check = $this->get_by_relation_id_date($supplier_relation_id->id, date("Y-m-d"));
        }

        if (!empty($time_check)) {
            $to_time = strtotime($time_check->date . ' ' . $time_check->clockin);
            $from_time = strtotime($time_check->date . ' ' . $this->input->post('time'));
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
            $this->session->unset_userdata($sesdata);
            return array('status' => 'true', 'message' => 'Time out successfully', 'url' => base_url('' . $table . '/view/' . $this->input->post('project_id')));
        } else {
            return array('status' => 'false', 'message' => 'Please time in to ' . $table . ' before time out.', 'url' => base_url('' . $table . '/view/' . $this->input->post('project_id')));
        }


    }

    public function get_time_check($start_date, $last_date, $supplier_id = null, $relation_id = null, $table = null)
    {
        $this->db->select('time_check.notes as time_notes,supplier.name,time_check.id,time_check.clockin,time_check.clockout,time_check.date,supplier_relations.supplier_id,supplier_relations.relation_id,time_check.total,supplier_relations.table_name');
        $this->db->from('time_check');
        $this->db->join('supplier_relations', 'supplier_relations.id = time_check.relation_id', 'right');
        $this->db->join('supplier', 'supplier_relations.supplier_id = supplier.id', 'right');
        $this->db->where('time_check.date BETWEEN "' . $start_date . '" AND "' . $last_date . '"');
        if ($supplier_id != null) {
            $this->db->where('supplier_relations.supplier_id', $supplier_id);
        }
        if ($table != null && $relation_id != null) {
            $this->db->where('supplier_relations.table_name', $table);

        }
        $this->db->where('supplier_relations.relation_id', $relation_id);
        $query = $this->db->get();
//      echo $this->db->last_query();
//      die();
        return $query->result();
    }

    public function get_time_table($start_date, $last_date, $company_id, $supplier_id = null, $relation_id = null, $table = null)
    {
        $this->db->select('SUM(total)AS Total_Time ,date as date');
        $this->db->from('time_check');
        $this->db->join('supplier_relations as rel', 'rel.id = time_check.relation_id', 'left');

        if ($this->session->userdata('role') == '0') {
            $this->db->join('projects as pro', 'pro.id = rel.relation_id');
            $this->db->where('pro.user_id', $this->session->userdata('id'));
        }

        $this->db->where('time_check.date BETWEEN "' . $start_date . '" AND "' . $last_date . '"');

        if ($supplier_id != null) {
            $this->db->where('rel.supplier_id', $supplier_id);
        }
        if ($table != null) {
            $this->db->where('rel.table_name', $table);
        }

        if ($relation_id != null) {
            $this->db->where('time_check.relation_id', $relation_id);
        }
        $this->db->where('time_check.company_id', $company_id);

        $this->db->group_by('time_check.date');

        $query = $this->db->get();
        return $query->result();
    }


    public function get_time_check_by_relation_id($start_date, $last_date, $relation_id)
    {
        $this->db->select_sum('total');
        $this->db->select('date');
        $this->db->from('time_check');
        $this->db->where('relation_id', $relation_id);
        $this->db->where("Date(created_at) BETWEEN '" . $start_date . "' AND '" . $last_date . "'");
        $query = $this->db->get();
        return $query->row();

    }

    public
    function check_relation_data($supplier_id)
    {
        $this->db->select('time_check.*');
        $this->db->select('supplier_relations.supplier_id,supplier_relations.relation_id,supplier_relations.table_name');
        $this->db->from('supplier_relations');
        $this->db->join('time_check', 'time_check.relation_id = supplier_relations.id', 'right');
        $this->db->where('supplier_relations.supplier_id', $supplier_id);
        $this->db->where('time_check.clockout', null);
        $query = $this->db->get();
        return $query->row();

    }

    public
    function delete($id)
    {
        $previous_url = $this->session->userdata('previous_url');
        $this->db->where('id', $id);
        $this->db->delete('time_check');
        return redirect($previous_url);
    }

    public function UpdateNotesById($PostedData, $id)
    {
        $this->db->set($PostedData);
        $this->db->where('id', $id);
        $this->db->update('time_check');

        if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return "Fail";
        }
    }

}