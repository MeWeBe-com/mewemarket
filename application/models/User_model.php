<?php


class user_model extends CI_Model
{

	public function CheckUserExist($email = NULL,$password = NULL)
	{
		$this->db->select('user_id, company_name,first_name, last_name, user_name, user_role, date_of_birth, user_email, street, state, zip_code, country_id,status, created_at, updated_at');
		$this->db->from('users');
		$this->db->where('user_email',$email);
		$this->db->where('user_password',$password);

		$query = $this->db->get();
		return $query->row();
	}

	public function GetUserDetails($id = NULL)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_id',$id);

		$query = $this->db->get();
		return $query->row();
	}

	public function Userpayment($user_id )
	{
		$this->db->select('*');
		$this->db->from('billing as bill');
		$this->db->join('packages as pack','pack.package_id = bill.package_id');
		$this->db->where('bill.user_id',$user_id);
		$this->db->order_by('bill.id','desc');

		$query = $this->db->get();
		return $query->row();
	}

	public function CountUserTools($user_id,$status)
	{
		$this->db->select('count(*) as Total');
		$this->db->from('billing');
		$this->db->where('billing.user_id',$user_id);
		$this->db->where('billing.status',$status);

		$query = $this->db->get();
		return $query->row();
	}

	public function DeleteUserTool($user_id = NULL,$product_id = NULL)
	{

		$this->db->where('user_id', $user_id);
		$this->db->where('product_id', $product_id);
		$this->db->delete('user_products');
		//DELETE FROM table_name WHERE column_name = clause;

		if($this->db->affected_rows()>0 )
		{
			return "Done";
		}
		else
		{
			return "Fail";
		}
	}

}
