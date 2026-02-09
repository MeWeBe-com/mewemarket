<?php


class general_model extends CI_Model
{

    public function InsertQuery($table_name, $PostedData)
    {

      	$this->db->insert($table_name,$PostedData);

    		if($this->db->affected_rows()>0 ){
    			return $this->db->insert_id();
    		}else{
    			return "Fail";
    		}
    }

	public function SelectQuery($table_name = NULL)
	{
		$this->db->select('*');
		$this->db->from($table_name);

		$query = $this->db->get();
		return $query->result();
	}

	public function ProdcutIdNext($table_name = NULL)
	{
		$this->db->select('MAX(id) as id');
		$this->db->from($table_name);

		$query = $this->db->get();
		return $query->result();
	}

    public function SelectQueryWithClause($table_name = NULL,$column_name = NULL,$clause = NULL)
    {
      $this->db->select('*');
      $this->db->from($table_name);
      $this->db->where($column_name,$clause);
      
      $query = $this->db->get();
      return $query->result();
    }



      public function UpdateQuery($table_name = NULL,$column_name = NULL,$clause = NULL,$PostedData = NULL)
    {

        $this->db->set($PostedData);
        $this->db->where($column_name, $clause);
        $this->db->update($table_name);

        if($this->db->affected_rows() > 0 )
        {
            return true;
        }
        else
        {
            return "Fail";
        }
    }

    public function DeleteQuery($table_name = NULL,$column_name = NULL,$clause = NULL)
    {

        $this->db->where($column_name, $clause);
        $this->db->delete($table_name);
        //DELETE FROM table_name WHERE column_name = clause;

        if($this->db->affected_rows()>0 )
        {
            return true;
        }
        else
        {
            return "Fail";
        }
    }

	public function RemoveFavourite($product_id)
	{
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->where('product_id', $product_id);
		$this->db->delete('user_favourite');
		//DELETE FROM user_favourite WHERE product_id = $product_id;

		if($this->db->affected_rows()>0 )
		{
			return true;
		}
		else
		{
			return "Fail";
		}
	}

	public function CheckUserEmail($email)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_email',$email);

		$query = $this->db->get();
		return $query->result();

	}

	public function GetCountrows($table_name = NULL,$column_name = NULL,$clause = NULL)
	{
		$this->db->select('count(*) as total');
		$this->db->from($table_name);
		$this->db->where($column_name,$clause);

		$query = $this->db->get();
		return $query->result();
	}


}
