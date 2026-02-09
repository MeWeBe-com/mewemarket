<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class invoice extends CI_Controller {

	
	public function index()
	{

		$doctor_id = $this->session->userdata('UserDetail_Id');

		$SendData['doctors'] = $this->admin_model->getAllDoctor();
		$SendData['hospitals'] = $this->admin_model->getAllHospitals();
		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();
		

		$SendData['jobDetails'] = $this->invoice_model->getAllPatientForInvoice();

		$this->load->view('invoice',$SendData);

	}

	public function generateInvoice($id)
	{

		$Testdetails = $this->invoice_model->GetTestDetails($id);

		$data['test_id'] = $Testdetails[0]->test_id;
		$data['invoice_date'] = date("Y/m/d");
		$data['doctor_id'] = $Testdetails[0]->doctor_id;
		$data['hospital_id'] = $Testdetails[0]->hospital_id;

		$invoice_id = $this->invoice_model->GenerateInvoice($data);

		$data_test = $this->admin_model->getTestDetailsById($data['test_id']);
		$Uid = $this->session->userdata('id');
				
		$Notify['userId '] = $Uid;
		$Notify['user_action '] = "Admin generated invoice for Client case number: ".$data_test[0]->Client_case_number;
				

		$notification = $this->admin_model->AddNotification($Notify);

		redirect('admin');

	}

	

		
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */