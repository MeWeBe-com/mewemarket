<?php
defined('_PATH') or die('Restricted!');

class ModelApiApi extends Model {
    public function login($key, $secret) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE `key` = '" . $this->db->escape($key) . "' AND secret = '" . $this->db->escape($secret) . "' AND status = '1'");

        if ($query->num_rows) {
            return $query->row;
        } else {
            return false;
        }
    }

	public function AddCompany($company_name) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "company SET company_name = '" . $company_name . "'");

		return $this->db->getLastId();
	}

	public function AddAdmin($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "user SET company_id = '" . $data['company_id'] . "', user_group_id = '" . $data['user_group_id'] . "' , `key` = 'FYHHJehcQFzyt8X92sniyJprUDsVD59ChqXktisssiW4RivSwS336sPThcgO84pm', secret = 'n6azZH7gUenz1oUTDjjjdAFJDLnLomwPRbOXQZ4sdDElhMf2Iswty4Kfm9AlKyxc',   
		name = '" . $data['name'] . "', email = '" . $data['email'] . "', username = '" . $data['username'] . "',salt = '" . $data['salt'] . "',password = '" . $data['password'] . "',ip = '" . $data['ip'] . "',code = '" . $data['code'] . "',
		status = '" . $data['status'] . "' ");

		return $this->db->getLastId();
	}
}
