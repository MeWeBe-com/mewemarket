<?php


class api_model extends CI_Model
{
   
   public function insertCompany($data)
    {
        $this->db->reconnect();

        $this->db->insert("companies",$data);

        if($this->db->affected_rows()>0 )
        {
            return $this->db->insert_id();
        }
        else
        {
            return "Fail";
        }
    }

    public function insertCompanyAdmin($data)
    {
        $this->db->reconnect();

        $this->db->insert("users",$data);

        if($this->db->affected_rows()>0 )
        {
            return 'Done';
        }
        else
        {
            return "Fail";
        }
    }



}