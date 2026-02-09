<?php

/**
 * Created by Haseeb IDEA.
 * Date: 19/05/2017
 * Time: 21:49
 */


class user_model extends CI_Model
{

	
	public function userLogin($email = NULL,$password = NULL,$company_id = NULL)
    {

        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('company','company.id = user.company_id');
        $this->db->where('user.email', $email);
        $this->db->where('user.password', $password);
        $this->db->where('user.company_id', $company_id);


        $query = $this->db->get();
        return $query->result();
     
    }
	
	
	public function userLoginforget($email)
    {
       $this->db->where('email', $email);
	   $this->db->from('user');
	   $query = $this->db->get();
	   
	return $query->result();
    }

    public function GetCompanyNameAndID($slug)
    {
        $this->db->where('company_slug', $slug);
        $this->db->from('company');
        $query = $this->db->get();

        return $query->result();
    }

    public function GetCompanyNameAndIDByID($id)
    {
        $this->db->where('id', $id);
        $this->db->from('company');
        $query = $this->db->get();

        return $query->result();
    }

    public function GetUserFirstLogin($id = NULL,$name = NULL)
    {
       $this->db->where('parent_id', $id);
       $this->db->where('name', $name);
       $this->db->from('config_options');
       $query = $this->db->get();
       
    return $query->result();       
        
     
    }

    public function AddUserFirstLogin($Details)
    {
        $this->db->reconnect();

        $this->db->insert("config_options",$Details);

        $id = $this->db->insert_id();

        $query = $this->db->get_where('config_options', array('id' => $id));
        
        return $query->result();
    }


    public function UpdateUserFirstLogin($id = NULL,$name = NULL)
    {
       
      $this->db->set('value', '1');
      $this->db->where('parent_id', $id);
      $this->db->where('name', $name);
      $this->db->update('config_options');

        
        return true;
     
    }
	
	
	
	public function userLoginforgetmd5($id)
    {
       $this->db->where('md5(id)', ($id));
	   $this->db->from('user');
	   $query = $this->db->get();
	   return $query->result();	        
    }	
	

    public function updateLastlogin()
    {
       
      
	$id = $this->session->userdata('id');

       $query = $this->db->query("UPDATE `user` SET `last_login`= NOW() WHERE id = '$id'");

        
        return true;
     
    }
	
	public function updatepassword($password = NULL,$id = NULL)
    {
       
      $this->db->set('password', md5($password));
	  $this->db->where('md5(id)', $id);
	  $this->db->update('user');

        
        return true;
     
    }

    public function GetUserData($id)
    {
       
        $query = $this->db->query("SELECT * FROM `user`
                                   where id = '$id'");

        
        return $query->result();
     
    }

    public function UpdateUserData($data)
    {
       
    $id = $this->session->userdata('id');

		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update('user');

    /*   $query = $this->db->query("UPDATE `user` SET `username`= '".$data['first_name'].$data['last_name']."',`original_password`='".$data['password']."',`password`='".md5($data['password'])."',`first_name`='".$data['first_name']."',`last_name`='".$data['last_name']."',`mobile_number`='".$data['mobile_number']."',`address`='".$data['address']."' WHERE id = '".$id."'");

       if($this->db->affected_rows()>0 )
            {
                return "Done";
            }
            else
            {
                return "Fail";
            }
		*/
		return "Done";
    }
	
	
	public function UpdateUserByAdmin($data = NULL,$id = NULL){
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update('user');
	   
		return true;	 
	}

     public function UpdateDoctor($data)
    {
       
    $id = $this->session->userdata('UserDetail_Id');

       $query = $this->db->query("UPDATE `doctors` SET `doctor_specialties`= '".$data['doctor_specialties']."',`gender`= '".$data['gender']."',`gmc_number`= '".$data['gmc_number']."',`work_number`= '".$data['work_number']."',`show_number`= '".$data['show_number']."',`show_email`= '".$data['show_email']."',`secondary_email`= '".$data['secondary_email']."' WHERE  doctor_id = '".$id."'");

       if($this->db->affected_rows()>0 )
            {
                return "Done";
            }
            else
            {
                return "Fail";
            }
    }


  public function UpdateVerifiedStatus($id)
    {
       
      $this->db->set('mobile_verified', '1');
      $this->db->where('id', $id);
      $this->db->update('user');

        
      return true;
     
    }


  public function UpdateMobileNumberOfUser($id = NULL,$data = NULL)
    {
       
      $this->db->set($data);
      $this->db->where('id', $id);
      $this->db->update('user');

        
        return true;
     
    }

}