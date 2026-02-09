<?php

class admin_model extends CI_Model
{

	public function TotalUsers()
	{
		$this->db->select('count(*) as Total');
		$this->db->from('users');
		$this->db->where('user_role','0');

		$query = $this->db->get();
		return $query->row();
	}

	public function ProductIdNext($table_name = NULL)
	{
		$this->db->select('MAX(product_id) as id');
		$this->db->from($table_name);

		$query = $this->db->get();
		return $query->result();
	}

	public function ActivatedTools()
	{
		$this->db->select('count(*) as Total');
		$this->db->from('billing');

		$query = $this->db->get();
		return $query->row();
	}

	public function TotalPackages()
	{
		$this->db->select('count(*) as Total');
		$this->db->from('packages');

		$query = $this->db->get();
		return $query->row();
	}

	public function GetAllUsersDetails()
	{
		$this->db->select('users.user_id,users.user_name,users.user_email,users.created_at');
		$this->db->from('users');

		$query = $this->db->get();
		return $query->result();
	}

	public function GetAllUsersSubscription()
	{
		$this->db->select('users.user_id,users.user_name,products.product_name,billing.package_amount,billing.billing_date,billing.billing_due_date,billing.status,billing.subscription_id,billing.app_url,products.product_id');
		$this->db->from('users');
		$this->db->join('billing','billing.user_id = users.user_id');
		$this->db->join('products','products.product_id = billing.product_id');

		$query = $this->db->get();
		return $query->result();
	}

	public function GetAllTimeEarning()
	{
		$this->db->select('sum(package_amount) as total');
		$this->db->from('billing');

		$query = $this->db->get();
		return $query->result();
	}

	public function GetThisYearEarning()
	{
		$this->db->select('sum(package_amount) as total');
		$this->db->from('billing');
		$this->db->where('YEAR( billing_date ) = YEAR( CURDATE())');

		$query = $this->db->get();
		return $query->result();
	}

	public function GetThisMonthEarning()
	{
		$this->db->select('sum(package_amount) as total');
		$this->db->from('billing');
		$this->db->where('MONTH( billing_date ) = MONTH( CURDATE())');

		$query = $this->db->get();
		return $query->result();
	}


}
