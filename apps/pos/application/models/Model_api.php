<?php 

class Model_api extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function InsertCompany($data)
	{
		$this->db->insert('companies', $data);
		return $this->db->insert_id();
	}

	public function InsertCompanyData($data)
	{
		$this->db->insert('company', $data);
		return $this->db->insert_id();
	}

	public function InsertCompanyAdmin($data)
	{
		$this->db->insert('users', $data);
		return $this->db->insert_id();
	}

	public function InsertAdminGroup($data)
	{
		$this->db->insert('user_group', $data);
		return $this->db->insert_id();
	}

}
