<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class messages extends CI_Controller {

	
	public function index()
	{
		$id = $this->session->userdata('id');

		$SendData['messages'] = $this->message_model->getAllMessages($id);
		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;


		//$SendData['AllUsers'] = $this->admin_model->getAllUsers();

		$this->load->view('messages',$SendData);
	}

	public function SentMessages()
	{
		$id = $this->session->userdata('id');

		$SendData['messages'] = $this->message_model->getSendMessages($id);
		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		//$SendData['AllUsers'] = $this->admin_model->getAllUsers();

		$this->load->view('sentMessages',$SendData);
	}
	
	public function SentTextMessages()
	{
		$body = "Visiopath Verification Code:
345378";
$to = "+923462300676";
		$SendData['messages'] = $this->message_model->sendTextMessage($to,$body);

		
		
	}
	
	

	public function AddMessage()
	{

		$id = $this->session->userdata('id');
		
		//$SendData['Users'] = $this->admin_model->getOtherUsers($id);

		
	
		$this->load->view('addnewmessage',$SendData);
	}


	public function SendMessage()
	{
		

		$data['receiver_id'] = $_POST['receiver'];
        $data['company_id'] = $this->session->userdata('company_id');
		$data['sender_id'] = $_POST['sender'];
		$data['title'] = $_POST['title'];
		$data['message'] = $_POST['message'];
		$data['message_status'] = "0";

		if(!empty($_POST['message_parent_id'])){
			$data['message_parent_id'] = $_POST['message_parent_id'];
		}

		$check = $this->message_model->AddNewMessage($data);

		$Sender = $this->admin_model->Selectuser($_POST['sender'])[0]->first_name;
		$receiver = $this->admin_model->Selectuser($_POST['sender'])[0]->first_name;
				
		$Notify['userId '] = $_POST['sender'];
		$Notify['user_action '] = $Sender." Contacted to : ".$receiver." on Messages ";

		$notification = $this->admin_model->AddNotification($Notify);

		if($check != 'Fail'){
			redirect('messages?sent');
		}

	
	}

	public function ShowMessage($id)
	{

		$this->message_model->UpdateToRead($id);

		$SendData['messageDetail'] = $this->message_model->GetMessage($id);

		$SendData['messageReply'] = $this->message_model->GetMessageReply($id);


		//$SendData['Users'] = $this->admin_model->getAllUsers();


		
		$this->load->view('messagedetails',$SendData);

	}

	public function GetusersByid()
	{

		$id = $this->input->get('Typeid');
		
		$role = $this->session->userdata('roleId');
		
		if($role == 3){
			$hospital = $this->hospital_model->getHospitalByIdUser($this->session->userdata('id'));
			$user_detail_id = $hospital[0]->UserDetail_Id;
		}elseif($role == 2){
			$hospital = $this->doctor_model->getDoctorByIdUser($this->session->userdata('id'));
			$user_detail_id = $hospital[0]->UserDetail_Id;
		}
		$Users = $this->admin_model->getUsersByfTypeId($id,$role,$user_detail_id);

		$User = array();
		foreach($Users as $u){ 
			
			$userid = $u->id;
   			$username = $u->first_name;

			$User[] = array("id" => $userid, "username" => $username);
			  
		}

		$data = $User;
		echo json_encode($data);

	}

		
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */