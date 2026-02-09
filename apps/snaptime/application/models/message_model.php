<?php

/**
 * Created by IntelliJ IDEA.
 * User: Urfan
 * Date: 19/05/2017
 * Time: 21:49
 */

class message_model extends CI_Model
{

	
	public function AddNewMessage($data)
    {
        
        $this->db->reconnect();
		$data['message_time'] = date("Y-m-d H:i:s");
    $this->db->insert("messages",$data);

    if($this->db->affected_rows()>0 )
      {
        return $this->db->insert_id();
      }
      else
      {
        return "Fail";
      } 

    }


	public function AddNewMessageOutside($s = NULL,$r = NULL,$t = NULL,$m = NULL)
    {
        
        $data['receiver_id'] = $r;
       	$data['sender_id'] = $s;
       	$data['title'] = $t;
    		$data['message'] = $m;
    		$data['message_status'] = "0";
			  $data['message_time'] = date("Y-m-d H:i:s");
    	  $this->db->insert("messages",$data);

    }


      public function getAllMessages($id,$receiverrole)
    {
        
        $this->db->reconnect();

        $this->db->select('*');
        $this->db->from('messages');
        $this->db->where('receiver_id', $id );
        $this->db->where('receiver_role', $receiverrole );

		    $this->db->order_by("messages.message_id", "desc");
        $query = $this->db->get();
        
        return $query->result();

    }

     public function getSendMessages($id,$senderrole)
    {
        
        $this->db->reconnect();

        $this->db->select('*');
        $this->db->from('messages');
        $this->db->where('sender_id', $id );
   	    //$this->db->join('users', 'users.user_id = messages.sender_id');
        $this->db->where('sender_role', $senderrole );	

        $query = $this->db->get();

        return $query->result();

    }

    public function GetMessage($id)
    {
        
          $this->db->reconnect();

          $this->db->select('*');
          $this->db->from('messages');
          $this->db->where('message_id', $id );
		  
		  	
		  
          $query = $this->db->get();

          return $query->result();

    }

    public function GetMessageReply($id)
    {
        
          $this->db->reconnect();

          $this->db->select('*');
          $this->db->from('messages');
          $this->db->where('message_parent_id', $id );
		 
          $query = $this->db->get();

          return $query->result();

    }

     public function UpdateToRead($id)
    {
        
          $this->db->reconnect();

          $this->db->set('message_status', '1');
          $this->db->where('message_id', $id);
          $this->db->update('messages');

          return true;

    }

    public function GetUnreadMessages($id)
    {
        
          $this->db->reconnect();

          $this->db->select('count(*) as unread');
          $this->db->from('messages');
          $this->db->where('receiver_id ', $id );
          $this->db->where('message_status  ', '0' );

          $query = $this->db->get();

          return $query->result();

    }




   

}