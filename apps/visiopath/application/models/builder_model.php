<?php

/**
 * Created by IntelliJ IDEA.
 * User: Urfan
 * Date: 19/05/2017
 * Time: 21:49
 */


class builder_model extends CI_Model
{

	  public function InsertFormFields($data)
    {
    $this->db->reconnect();
    $data['company_id'] = $this->session->userdata('company_id');
    $this->db->insert("form_fields",$data);

    if($this->db->affected_rows()>0 )
      {
        return $this->db->insert_id();
      }
      else
      {
        return "Fail";
      }
  }

  public function UpdateFormFields($id = NULL,$field_id = NULL,$data = NULL) {
    $this->db->reconnect();

      $this->db->set($data);
      $this->db->where('field_id',$field_id);
	  $this->db->where('test_type_id',$id);
      $this->db->update("form_fields");

      if($this->db->affected_rows()>0 )
        {
          return "Done";
        }
        else
        {
          return "Fail";
        }
  }

  public function DeleteFieldById($id)
  {
    $this->db->delete('form_fields', array('field_id' => $id)); 
    
    return true;
  }

}