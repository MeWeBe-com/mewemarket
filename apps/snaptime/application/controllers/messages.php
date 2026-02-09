<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class messages extends CI_Controller {

	
	public function index()
	{
	    if(empty($this->session->userdata('id'))){
            redirect(base_url());
        }

		$id = $this->session->userdata('id');

		if($this->session->userdata('role') == 'Supplier'){
			$receiverrole = 'Supplier';
		}elseif($this->session->userdata('role') == 1){
			$receiverrole = 'Admin';
		}elseif($this->session->userdata('role') == 0){
			$receiverrole = 'Project Manager';
		}

		$messages = $this->message_model->getAllMessages($id,$receiverrole);

		foreach($messages as $message){
			
			if($message->sender_role == 'Admin' || $message->sender_role == 'Project Manager'){
				$Sender = $this->user_model->GetUserDetailsById($message->sender_id);
				$message->sendername = $Sender[0]->name;
			}else{
				$Sender = $this->supplier_model->get_supplier_by_id($message->sender_id);
				$message->sendername = $Sender->name;
			}
		}

		$SendData['messages'] = $messages;

		//$SendData['AllUsers'] = $this->admin_model->getAllUsers();

		$this->load->view('messages/messages',$SendData);
	}

	public function SentMessages()
	{
        if(empty($this->session->userdata('id'))){
            redirect(base_url());
        }

		$id = $this->session->userdata('id');

		if($this->session->userdata('role') == 'Supplier'){
			$senderrole = 'Supplier';
		}elseif($this->session->userdata('role') == 1){
			$senderrole = 'Admin';
		}elseif($this->session->userdata('role') == 0){
			$senderrole = 'Project Manager';
		}

		$messages = $this->message_model->getSendMessages($id,$senderrole);

		foreach($messages as $message){
			if($message->receiver_role == 'Admin' || $message->receiver_role == 'Project Manager'){
				$Sender = $this->user_model->GetUserDetailsById($message->receiver_id);
				$message->receivername = $Sender[0]->name;
			}else{
				$Sender = $this->supplier_model->get_supplier_by_id($message->receiver_id);
				$message->receivername = $Sender->name;
			}
		}

		$SendData['messages'] = $messages;


		//$SendData['AllUsers'] = $this->admin_model->getAllUsers();

		$this->load->view('messages/sentMessages',$SendData);
	}
	
	public function AddMessage()
	{

        if(empty($this->session->userdata('id'))){
            redirect(base_url());
        }

		$id = $this->session->userdata('id');
		
		//$SendData['Users'] = $this->admin_model->getOtherUsers($id);
	
		$this->load->view('messages/addnewmessage');
	}


	public function SendMessage()
	{

        if(empty($this->session->userdata('id'))){
            redirect(base_url());
        }


		if($this->session->userdata('role') == 'Supplier'){
			$senderrole = 'Supplier';
		}elseif($this->session->userdata('role') == 1){
			$senderrole = 'Admin';
		}elseif($this->session->userdata('role') == 0){
			$senderrole = 'Project Manager';
		}

		if($_POST['receiver_role'] == '3'){
			$receiverrole = 'Supplier';
		}elseif($_POST['receiver_role'] == '1'){
			$receiverrole = 'Admin';
		}elseif($_POST['receiver_role'] == '0'){
			$receiverrole = 'Project Manager';
		}

		$data['receiver_id'] = $_POST['receiver'];
		$data['receiver_role'] = $receiverrole;
		$data['sender_id']   = $_POST['sender'];
		$data['sender_role']   = $senderrole;
		$data['title'] 		 = $_POST['title'];
		$data['message'] 	 = $_POST['message'];
		$data['message_status'] = "0";

		if(!empty($_POST['message_parent_id'])){
			$data['message_parent_id'] = $_POST['message_parent_id'];
		}

		$check = $this->message_model->AddNewMessage($data);

		/*$Sender = $this->admin_model->Selectuser($_POST['sender'])[0]->first_name;
		$receiver = $this->admin_model->Selectuser($_POST['sender'])[0]->first_name;*/
				
		/*$Notify['userId '] = $_POST['sender'];
		$Notify['user_action '] = $Sender." Contacted to : ".$receiver." on Messages ";
		$notification = $this->admin_model->AddNotification($Notify);
		*/
		
		if($check != 'Fail'){
			redirect('messages?sent');
		}

	
	}

	public function ShowMessage($id)
	{

        if(empty($this->session->userdata('id'))){
            redirect(base_url());
        }

		$this->message_model->UpdateToRead($id);

		$SendData['messageDetail'] = $this->message_model->GetMessage($id);

		
		if($SendData['messageDetail'][0]->sender_role == 'Admin' || $SendData['messageDetail'][0]->sender_role == 'Project Manager'){
				$Sender = $this->user_model->GetUserDetailsById($SendData['messageDetail'][0]->sender_id);
				$SendData['messageDetail'][0]->name = $Sender[0]->name;
		}else{
				$Sender = $this->supplier_model->get_supplier_by_id($SendData['messageDetail'][0]->sender_id);
				$SendData['messageDetail'][0]->name  = $Sender->name;
		}

		$SendData['messageReply'] = $this->message_model->GetMessageReply($id);

		if(!empty($SendData['messageReply'])){

			if($SendData['messageReply'][0]->sender_role == 'Admin' || $SendData['messageReply'][0]->sender_role == 'Project Manager'){
					$Sender = $this->user_model->GetUserDetailsById($SendData['messageReply'][0]->sender_id);
					$SendData['messageReply'][0]->name = $Sender[0]->name;
			}else{
					$Sender = $this->supplier_model->get_supplier_by_id($SendData['messageReply'][0]->sender_id);
					$SendData['messageReply'][0]->name  = $Sender->name;
			}
		}



		//$SendData['Users'] = $this->admin_model->getAllUsers();

		$this->load->view('messages/messagedetails',$SendData);

	}

	public function GetusersByid()
	{

		$id = $this->input->get('Typeid');
		
		$role = $this->session->userdata('roleId');
		
		if($id == 3){
			//GET Supplier
			$Supplier = $this->supplier_model->GetAllSupplierByCompanyID($this->session->userdata('company_id'));
			$Users = $Supplier;

			$User = array();
		foreach($Users as $u){ 
			
			$userid = $u->id;
   			$username = $u->name;

			$User[] = array("id" => $userid, "username" => $username);
			  
		}
		}elseif($id == 0 ){
			$manager = $this->user_model->GetProjectManagersByCompanyID($this->session->userdata('company_id'));
			$Users = $manager;

			$User = array();
		foreach($Users as $u){ 
			
			$userid = $u->user_id;
   			$username = $u->name;

			$User[] = array("id" => $userid, "username" => $username);
			  
		}
		}elseif($id == 1){

			$admin = $this->user_model->GetAllAdmin();
			$Users = $admin;

			$User = array();
		foreach($Users as $u){ 
			
			$userid = $u->user_id;
   			$username = $u->name;

			$User[] = array("id" => $userid, "username" => $username);
			  
		}
		}
		//$Users = $this->admin_model->getUsersByfTypeId($id,$role,$user_detail_id);

		

		$data = $User;
		echo json_encode($data);

	}

		
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */