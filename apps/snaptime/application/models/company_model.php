<?php

/**
 * Created by IntelliJ IDEA.
 * User: Urfan
 * Date: 19/05/2017
 * Time: 21:49
 */

class company_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_id($id)
    {
        $query = $this->db->get_where('companies', array('id' => $id));
        return $query->row();
    }
    public function get_by_name($name)
    {
        $query = $this->db->get_where('companies', array('name' => $name));
        return $query->row();
    }

}