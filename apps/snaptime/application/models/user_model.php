<?php


class user_model extends CI_Model
{

    public function AddNewUser($PostedData)
    {

      	$this->db->insert("users",$PostedData);

    		if($this->db->affected_rows()>0 )
    		{
    			return $this->db->insert_id();
    		}
    		else
    		{
    			return "Fail";
    		}
    }

    public function getRows($email = NULL)
    {
      $this->db->select('count(*) as Total');
      $this->db->from('users');
      $this->db->where('email',$email);
      
      $query = $this->db->get();

      return $query->result();     
    }

    public function userLogin($email = NULL,$pass = NULL)
    {
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('email',$email);
      $this->db->where('password',$pass);
      
      $query = $this->db->get();

      return $query->result();     
    }


    public function get_frequency()
    {
        $this->db->select('frequency');
        $this->db->from('users');
        $this->db->where('role','1');
        $query = $this->db->get();
        return $query->row();
    }
    public function GetProjectManagersByCompanyID($company_id)
    {
      $this->db->select('user_id,name');
      $this->db->from('users');
      $this->db->where('role','0');
      $this->db->where('company_id',$company_id);

      $query = $this->db->get();
      return $query->result();     
    }

     public function GetAllAdmin()
    {
      $this->db->select('user_id,name');
      $this->db->from('users');
      $this->db->where('role','1');
    
      $query = $this->db->get();
      return $query->result();     
    }

     public function GetAllUserByCompanyID($company_id)
    {
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('company_id',$company_id);

      $query = $this->db->get();
      return $query->result();     
    }

     public function GetUserDetailsById($id)
    {
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('user_id',$id);

    
      $query = $this->db->get();
      return $query->result();     
    }

      public function UpdateUserById($PostedData,$id)
    {
      
        $this->db->set($PostedData);
        $this->db->where('user_id', $id);
        $this->db->update('users');
       
        if($this->db->affected_rows()>0 )
        {
            return 'Done';
        }
        else
        {
            return "Fail";
        }      
    }

  

  public function checkEmail($email)
    {
      $this->db->select('count(*) as Total');
      $this->db->from('users');
      $this->db->where('email',$email);

      $query = $this->db->get();
     
        return $query->row();
    }

      public function updateEmailWithToken($data,$token)
    {
        $this->db->set('verification_key',$token);
        $this->db->where('email', $data);
        $this->db->update('users');
       
        if($this->db->affected_rows()>0 )
        {
            return 'Done';
        }
        else
        {
            return "Fail";
        }      
    }

  public function GetUserDetailsByToken($token)
    {
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('verification_key',$token);

      $query = $this->db->get();
      return $query->result();     
    }

      public function ChangePasswordById($posteddata,$id)
    {
        $this->db->set($posteddata);
        $this->db->where('user_id', $id);
        $this->db->update('users');
       
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