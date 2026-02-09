<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller {


    public function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('id'))) {
            redirect(base_url());
        }

        if($this->session->userdata('role') == 'Supplier'){
            redirect(base_url());
        }
    }



	public function index()
	{

		$Senddata['users'] = $this->user_model->GetAllUserByCompanyID($this->session->userdata('company_id'));

		$this->load->view('users/user_list',$Senddata);
	}

	public function CreateNewUser($id = Null)
	{

	    if($this->session->userdata('role') == '0'){
	        if($id != $this->session->userdata('id')){
	            redirect(base_url());
            }
        }

       if(!empty($id)){
			$Senddata['users'] = $this->user_model->GetUserDetailsById($id);
		}else{
			$Senddata['users'] = '';
		}

		$this->load->view('users/createuser',$Senddata);
	}

	public function AddNewUser()
	{

		$data =  $this->input->post();

		if(!empty($data['id'])){

			$PostedData['name'] = $data['name'];
			$PostedData['email'] = $data['email'];

			if(!empty($data['password'])){
				$PostedData['password'] = md5($data['password']);
			}

			$PostedData['role'] = $data['role'];
			$PostedData['phone'] = $data['phone'];
			$PostedData['status'] = $data['status'];
				
			$this->user_model->UpdateUserById($PostedData,$data['id']);

		}else{
			$PostedData['name'] = $data['name'];
			$PostedData['email'] = $data['email'];
			$PostedData['password'] = md5($data['password']);
			$PostedData['role'] = $data['role'];
			$PostedData['phone'] = $data['phone'];
			$PostedData['status'] = $data['status'];
			$PostedData['company_id'] = $this->session->userdata('company_id');

			$id =  $this->user_model->AddNewUser($PostedData);
		}

		redirect('user');

	}

	public function delete($id)
    {
        $this->db->where('user_id', $id);
        $this->db->delete('users');

        redirect('user');
    }

}
