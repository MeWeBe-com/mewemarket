<?php
class User {
    private $user_id;
    private $username;
    private $email;
    private $key;
    private $secret;
    private $company_id;
    private $company_name;
    private $permission = array();

    public function __construct($registry) {
        $this->db = $registry->get('db');
        $this->request = $registry->get('request');
        $this->session = $registry->get('session');

        if (isset($this->session->data['user_id'])) {
            $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user as user inner join " . DB_PREFIX . "company as company on company.company_id = user.company_id WHERE user.user_id = '" . (int)$this->session->data['user_id'] . "' AND user.status = '1'");

            if ($user_query->num_rows) {

                $this->user_id = $user_query->row['user_id'];
                $this->username = $user_query->row['username'];
                $this->email = $user_query->row['email'];
                $this->key = $user_query->row['key'];
                $this->secret = $user_query->row['secret'];

                $this->company_id = $user_query->row['company_id'];
                $this->company_name = $user_query->row['company_name'];

                $this->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

                $user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

                $permissions = json_decode($user_group_query->row['permission'], true);

                if (is_array($permissions)) {
                    foreach ($permissions as $key => $value) {
                        $this->permission[$key] = $value;
                    }
                }
            } else {
                $this->logout();
            }
        }
    }

    public function login($username, $password) {

        $pass = sha1($password);
        $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user as user inner join " . DB_PREFIX . "company as company on company.company_id = user.company_id WHERE user.username = '" . $this->db->escape($username) . "' AND user.password = '".$pass."' AND user.status = '1'");

        if ($user_query->num_rows) {
            $this->session->data['user_id'] = $user_query->row['user_id'];

            $this->user_id  = $user_query->row['user_id'];
            $this->username = $user_query->row['username'];
            $this->email    = $user_query->row['email'];
            $this->key      = $user_query->row['key'];
            $this->secret   = $user_query->row['secret'];

            $this->session->data['company_id']   = $user_query->row['company_id'];
            $this->session->data['company_name']   = $user_query->row['company_name'];

            $user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

            $permissions = json_decode($user_group_query->row['permission'], true);

            if (is_array($permissions)) {
                foreach ($permissions as $key => $value) {
                    $this->permission[$key] = $value;
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        unset($this->session->data['user_id']);

        $this->user_id = '';
        $this->username = '';
        $this->email = '';
        $this->key = '';
        $this->secret = '';
    }

    public function hasPermission($key, $value) {
        if (isset($this->permission[$key])) {
            return in_array($value, $this->permission[$key]);
        } else {
            return false;
        }
    }

    public function isLogged() {
        return $this->user_id;
    }

    public function getId() {
        return $this->user_id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }
}