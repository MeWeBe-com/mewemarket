<?php

class supplier_relation_model extends CI_Model
{

    public function get_supplier_relation_by_relation_id_table_name($relation_id, $table_name)
    {
        $this->db->select('*');
        $this->db->from('supplier_relations');
        $this->db->where('relation_id', $relation_id);
        $this->db->where('table_name', $table_name);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_supplier_relation_by_relation_id($relation_id)
    {
        $this->db->select('*');
        $this->db->from('supplier_relations');
        $this->db->where('relation_id', $relation_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_supplier_relation_by_relation_id_table_name_and_supplierid($relation_id, $supplier_id, $table_name)
    {
        $this->db->select('*');
        $this->db->from('supplier_relations');
        $this->db->where('relation_id', $relation_id);
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('table_name', $table_name);
        $query = $this->db->get();
        return $query->result();
    }


    public function get_relation_data_by_supplier_id($supplier_id, $table_name)
    {
        $this->db->select($table_name . '.*');
        if ($table_name == 'projects') {
            $this->db->select('project_type.project_type as project_type,users.name as manager_name');
        }

        $this->db->from('supplier_relations');
        $this->db->join($table_name, 'supplier_relations.relation_id = ' . $table_name . '.id', 'left');
        if ($table_name == 'projects') {
            $this->db->join('project_type', '' . $table_name . '.type_id = project_type.id');
            $this->db->join('users', '' . $table_name . '.user_id = users.user_id');
            $this->db->where('projects.supplier_archive', 1);

        }
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('table_name', $table_name);


        $query = $this->db->get();

        return $query->result();
    }
    public function get_archive_relation_data_by_supplier_id($role, $table_name)
    {
        $this->db->select($table_name . '.*');
        if ($table_name == 'projects') {
            $this->db->select('project_type.project_type as project_type,users.name as manager_name');
        }
        $this->db->from(''.$table_name.'');
        if ($table_name === 'projects') {
            $this->db->join('project_type', '' . $table_name . '.type_id = project_type.id');
            $this->db->join('users', '' . $table_name . '.user_id = users.user_id');
        }
        if($table_name ==='projects' && $role === 'Supplier')
        {
            $this->db->where('projects.supplier_archive', 0);

        }elseif ($table_name === 'projects' && $role=='0'){
            $this->db->where('projects.manager_archive', 0);

        }elseif($table_name === 'projects' && $role=='1')
        {
            $this->db->where('projects.admin_archive', 0);
        }


        $query = $this->db->get();

        return $query->result();
    }

    public function get_relation_data_by_supplier_id_sub_id($relation_id = NULL, $supplier_id, $table_name)
    {
        $this->db->select($table_name . '.*');
        $this->db->select('supplier_relations.id as relation_table_id,supplier_relations.supplier_id,supplier_relations.relation_id,supplier_relations.table_name');
        $this->db->from('supplier_relations');
        $this->db->join($table_name, 'supplier_relations.relation_id = ' . $table_name . '.id', 'left');

        $this->db->where('supplier_relations.supplier_id', $supplier_id);
        $this->db->where('supplier_relations.table_name', $table_name);

        if (!empty($relation_id)) {
            $this->db->where($table_name . '.id', $relation_id);
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function get_all_relation_data_by_supplier_id_supplier_id_table_name($relation_id, $supplier_id, $table_name)
    {
        $this->db->select('*');
        $this->db->from('supplier_relations');
        $this->db->where('relation_id', $relation_id);
        $this->db->where('table_name', $table_name);
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_all_relation_data_by_supplier_id($start_date, $last_date, $supplier_id, $table_name, $project_id = null)
    {
        $this->db->select($table_name . '.*');
        $this->db->select('supplier_relations.id as relation_table_id,supplier_relations.supplier_id,supplier_relations.relation_id,supplier_relations.table_name');
        $this->db->from('supplier_relations');
        $this->db->join($table_name, 'supplier_relations.relation_id = ' . $table_name . '.id', 'left');
        $this->db->where('supplier_id', $supplier_id);
        $this->db->where('table_name', $table_name);
        //   $this->db->where("Date(supplier_relations.created_at) BETWEEN '". $start_date . "' AND '" . $last_date . "'");

        if ($project_id != null) {
            $this->db->where($table_name . '.id', $project_id);
        }

        $this->db->group_by($table_name . '.id');

        $query = $this->db->get();
        return $result = $query->result();

    }

    public function get_all_relation_data_by_manager_id($manager_id, $table_name)
    {
        $this->db->select($table_name . '.*');
        $this->db->select('supplier_relations.id as relation_table_id,supplier_relations.supplier_id,supplier_relations.relation_id,supplier_relations.table_name');
        $this->db->from('supplier_relations');
        $this->db->join($table_name, 'supplier_relations.relation_id = ' . $table_name . '.id', 'right');
        if ($table_name == 'projects') {
            $this->db->where('projects.user_id', $manager_id);
        }
        $this->db->where('table_name', $table_name);
        $this->db->group_by($table_name . '.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_supplier_relation_by_relation_id_supplier_id_table_name_with_relation_data($relation_id, $supplier_id, $table_name)
    {
        $this->db->select($table_name . '.name');
        $this->db->from('supplier_relations');
        $this->db->join($table_name, 'supplier_relations.relation_id = ' . $table_name . '.id');
        $this->db->where('relation_id', $relation_id);
        $this->db->where('table_name', $table_name);
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_supplier_relation_by_relation_id_supplier_id_table_name($relation_id, $supplier_id, $table_name)
    {
        $this->db->select($table_name . '.*,supplier_relations.id as sr_id');
        $this->db->from('supplier_relations');
        $this->db->join($table_name, 'supplier_relations.relation_id = ' . $table_name . '.id');
        $this->db->where('relation_id', $relation_id);
        $this->db->where('table_name', $table_name);
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get();
        return $query->row();
    }


    public function delete($id, $table_name)
    {
        $previous_url = $this->session->userdata('previous_url');
        $this->db->where('id', $id);
        $this->db->where('table_name', $table_name);
        $this->db->delete('supplier_relations');
        return true;
    }

    public function delete_excpet_id($supplier_id, $table_name)
    {
        $previous_url = $this->session->userdata('previous_url');
        $sql = "Delete FROM supplier_relations WHERE NOT supplier_id=? AND table_name=?";
        $this->db->query($sql, [$supplier_id, $table_name]);
        return true;
    }

    public function get_all_suppliers($id, $table_name)
    {
        $this->db->distinct();
        $this->db->select('supplier_relations.id as supplier_relation_id,supplier.id as supplier_id,supplier.name as supplier_name, supplier.email,supplier.skills,supplier.quality,supplier.teamwork,supplier.speed,supplier.unit_payment_rate,' . $table_name . '.*');
        $this->db->from('supplier_relations');
        $this->db->join($table_name, 'supplier_relations.relation_id = ' . $table_name . '.id', 'right');
        $this->db->join('supplier', 'supplier_relations.supplier_id = supplier.id', 'right');
        $this->db->where('supplier_relations.relation_id', $id);
        $this->db->where('supplier_relations.table_name', $table_name);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_relation_data($relation_id, $supplier_id, $table_name)
    {
        $this->db->select('' . $table_name . '.*');
        $this->db->from('supplier_relations');
        $this->db->join($table_name, 'supplier_relations.relation_id = ' . $table_name . '.id', 'right');
        $this->db->join('supplier', 'supplier_relations.supplier_id = supplier.id', 'right');
        $this->db->where('supplier_relations.relation_id', $relation_id);
        $this->db->where('supplier_relations.supplier_id', $supplier_id);
        $query = $this->db->get();
        return $query->row();
    }


    public function get_supplier_assigned_data($supplier_id, $table_name)
    {
        $this->db->select('' . $table_name . '.*');
        $this->db->from('supplier_relations');
        $this->db->join($table_name, 'supplier_relations.relation_id = ' . $table_name . '.id', 'left');
        $this->db->where('supplier_relations.supplier_id', $supplier_id);
        $this->db->where('supplier_relations.table_name', $table_name);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_data_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('supplier_relations');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_all_projects_screenshot_by_ID($relation, $supplier_id)
    {
        $this->db->select('*');
        $this->db->from('supplier_relations');
        $this->db->join('supplier_screenshots', 'supplier_relations.id = supplier_screenshots.relation_id', 'left');
        $this->db->where('supplier_relations.supplier_id', $supplier_id);
        $this->db->where('supplier_screenshots.relation_id', $relation);

        $query = $this->db->get();

        return $query->result();
    }

    public function GetLatestProjectsWithLatestWork($supplier_id = Null,$company_id)
    {
        $this->db->select('*,projects.id as project_id,projects.name as project_name,users.name as manager_name');
        $this->db->from('supplier_relations');
        $this->db->join('supplier_screenshots', 'supplier_relations.id = supplier_screenshots.relation_id', 'right');
        $this->db->join('projects', 'projects.id = supplier_relations.relation_id');
        $this->db->join('users', 'users.user_id = projects.user_id');
        $this->db->where('supplier_relations.table_name', 'projects');
        if ($this->session->userdata('role') == 'Supplier') {
            $this->db->where('projects.supplier_archive = 1');

        } elseif ($this->session->userdata('role') == '0') {
            $this->db->where('projects.manager_archive = 1');
        } else {
            $this->db->where('projects.admin_archive = 1');
        }
        if (!empty($supplier_id)) {
            $this->db->where('supplier_screenshots.supplier_id', $supplier_id);
        }
        $this->db->where('users.company_id ='.$company_id.'');
        $this->db->group_by('projects.id');
        $this->db->order_by('supplier_screenshots.created_at', 'desc');
        $this->db->limit(3);

        $query = $this->db->get();
        return $query->result();
    }

    public function GetLatestsuppliersWithLatestWork($company_id)
    {
        $this->db->select('supplier_relations.id,supplier.email,supplier.phone_number,supplier.website,supplier_relations.supplier_id,projects.id as project_id,projects.name as project_name,projects.description as project_description,supplier.name as supplier_name,supplier.id as supplier_id,supplier_screenshots.created_at,supplier.skills');
        $this->db->from('supplier_relations');

        $this->db->join('supplier_screenshots', 'supplier_relations.id = supplier_screenshots.relation_id', 'right');
        $this->db->join('supplier', 'supplier.id = supplier_relations.supplier_id', 'right');
        $this->db->join('projects', 'projects.id = supplier_relations.relation_id', 'right');

        $this->db->where('supplier_relations.table_name', 'projects');
        $this->db->where('supplier.company_id', $company_id);
        if ($this->session->userdata('role') == 'Supplier') {
            $this->db->where('projects.supplier_archive = 1');

        } elseif ($this->session->userdata('role') == '0') {
            $this->db->where('projects.manager_archive = 1');
        } else {
            $this->db->where('projects.admin_archive = 1');
        }
        $this->db->group_by('supplier_relations.id');
        $this->db->order_by('supplier_screenshots.created_at', 'desc');
        $this->db->limit(3);
        $query = $this->db->get();


        return $query->result();
    }

    public function GetLatestScreenshotsWithLatestWork($supplier_id = Null,$company_id)
    {
        $this->db->select('supplier_relations.id,supplier_relations.supplier_id,projects.id as project_id,projects.name as project_name,supplier.name as supplier_name,supplier.id as supplier_id,supplier_screenshots.file,supplier_screenshots.created_at,supplier_screenshots.relation_id as relation_id');
        $this->db->from('supplier_relations');
        $this->db->join('supplier_screenshots', 'supplier_relations.id = supplier_screenshots.relation_id', 'right');
        $this->db->join('projects', 'projects.id = supplier_relations.relation_id', 'right');
        $this->db->join('supplier', 'supplier.id = supplier_relations.supplier_id', 'right');
        $this->db->where('supplier_relations.table_name', 'projects');
        $this->db->where('supplier.company_id', $company_id);

        if (!empty($supplier_id)) {
            $this->db->where('supplier_screenshots.supplier_id', $supplier_id);
        }

        $this->db->order_by('supplier_screenshots.id', 'desc');
        $this->db->limit(6);
        $query = $this->db->get();

        return $query->result();
    }

    public function GetLatestProjectScreenshots($supplier_id = Null, $project_id = Null)
    {
        $this->db->select('supplier_relations.id,supplier_relations.supplier_id,projects.id as project_id,projects.name as project_name,supplier.name as supplier_name,supplier.id as supplier_id,supplier_screenshots.file,supplier_screenshots.created_at,supplier_screenshots.relation_id as relation_id');
        $this->db->from('supplier_relations');

        $this->db->join('supplier_screenshots', 'supplier_relations.id = supplier_screenshots.relation_id', 'right');
        $this->db->join('projects', 'projects.id = supplier_relations.relation_id', 'right');
        $this->db->join('supplier', 'supplier.id = supplier_relations.supplier_id', 'right');

        $this->db->where('supplier_relations.table_name', 'projects');

        if (!empty($supplier_id)) {
            $this->db->where('supplier_screenshots.supplier_id', $supplier_id);
        }

        if (!empty($project_id)) {
            $this->db->where('supplier_relations.relation_id', $project_id);
        }

        $this->db->order_by('supplier_screenshots.id', 'desc');
        $this->db->limit(6);
        $query = $this->db->get();

        return $query->result();
    }

    public function GetLatestProjectsBySupplierID($supplier_id,$company_id)
    {
        $this->db->select('*,projects.id as project_id,projects.name as project_name,projects.created_at as created_date,users.name as manager_name');
        $this->db->from('projects');
        $this->db->join('supplier_relations', 'supplier_relations.relation_id = projects.id');
        $this->db->join('users', 'users.user_id = projects.user_id');

        $this->db->where('supplier_relations.table_name', 'projects');
        $this->db->where('users.company_id', $company_id);
        $this->db->where('supplier_relations.supplier_id', $supplier_id);

        $this->db->limit('3');
        $this->db->order_by('supplier_relations.id', 'desc');

        $query = $this->db->get();

        return $query->result();
    }

    public function GetLatestTasksBySupplierID($supplier_id,$company_id)
    {
        $this->db->select('*,tasks.id as task_id,projects.name as project_name,users.name as manager_name,tasks.name as task_name,tasks.created_at as created_date,tasks.due_date');
        $this->db->from('tasks');
        $this->db->join('supplier_relations', 'supplier_relations.relation_id = tasks.id');
        $this->db->join('sub_projects', 'tasks.sub_project_id = sub_projects.id');
        $this->db->join('projects', 'sub_projects.project_id = projects.id');
        $this->db->join('users', 'users.user_id = projects.user_id');
        $this->db->where('supplier_relations.table_name', 'tasks');
        $this->db->where('supplier_relations.supplier_id', $supplier_id);
        $this->db->where('users.company_id', $company_id);
        $this->db->limit('3');
        $this->db->order_by('supplier_relations.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function GetAllProjectsScreenshot($supplier_id = NULL)
    {
        $this->db->select('*,supplier_screenshots.relation_id as screenshot_relation_id');

        $this->db->from('supplier_screenshots');
        $this->db->join('supplier_relations', 'supplier_relations.id = supplier_screenshots.relation_id');
        $this->db->join('projects', 'projects.id = supplier_relations.relation_id');
        $this->db->where('supplier_relations.table_name', 'projects');

        if (!empty($supplier_id)) {
            $this->db->where('supplier_relations.supplier_id', $supplier_id);
        }

        $this->db->group_by('supplier_relations.relation_id');

        $this->db->order_by('supplier_screenshots.id', 'desc');

        $query = $this->db->get();

        return $query->result();
    }


    public function CheckRelationOfSupplierAndProject($project_id, $supplier_id, $table_name)
    {
        $this->db->select('*');
        $this->db->from('supplier_relations');
        $this->db->where('supplier_relations.relation_id', $project_id);
        $this->db->where('supplier_relations.supplier_id', $supplier_id);
        $this->db->where('supplier_relations.table_name', $table_name);


        $query = $this->db->get();
        return $query->result();
    }

    public function GetHoursFromRelationId($relation_id, $start_date = NULL, $end_date = NULL)
    {

        //SELECT sum(total) FROM `time_check` where relation_id = 11 
        $this->db->select('sum(total) as total_hours');
        $this->db->from('time_check');
        $this->db->where('relation_id', $relation_id);

        if (!empty($start_date)) {
            $this->db->where("Date(time_check.date) BETWEEN '" . $start_date . "' AND '" . $end_date . "'");
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function get_relation_id_by_project_id($project_id)
    {
        $this->db->select('id');

        $this->db->from('supplier_relations');

        $this->db->where('relation_id', $project_id);
        $this->db->where('table_name', 'projects');


        $query = $this->db->get();

        return $query->result();
    }


}

?>