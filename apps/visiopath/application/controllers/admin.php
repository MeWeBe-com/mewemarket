<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
            if ($this->session->userdata('verify_by_code') != 'yes') {
                redirect(base_url());
            }
    }


	public function index()
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

		$SendData['doctors'] = $this->admin_model->getAllDoctor();

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$details = $this->admin_model->getAllJobsDetails();

		$UrgentsJobs = $this->admin_model->getAllUrgentJobsDetails();


		foreach($UrgentsJobs as $detail){

				$report_id = $detail->test_id;

				if(!empty($report_id)){
					$reportbyId = $this->admin_model->reportById($report_id);
					if(!empty($reportbyId)){ 
						$detail->report = "Available";
					}else{
						$detail->report = "";
					}
				}else{
					$detail->report = "";
				}

				$detail->test_doctor_report = $this->admin_model->GetDoctorsByTestId($detail->test_primary_id);

			}
		
		$OverduesMoreThenTwoweek = $this->admin_model->GetOverduesMoreThenTwoweek();

		foreach($OverduesMoreThenTwoweek as $detail){ 
				$report_id = $detail->test_id;
				if(!empty($report_id)){
					$reportbyId = $this->admin_model->reportById($report_id);
					if(!empty($reportbyId)){ 
						$detail->report = "Available";
					}else{
						$detail->report = "";
					}
				}else{
					$detail->report = "";
				}

				$detail->test_doctor_report = $this->admin_model->GetDoctorsByTestId($detail->test_primary_id);
			}


		
		$reports = $this->admin_model->reported();

		$SendData['UnacceptedCases'] = $this->admin_model->UnacceptedCases();

		$SendData['ViewableReports'] = $this->admin_model->ViewableReports()[0]->ViewableReports;

		$SendData['TotalArchived'] = $this->admin_model->TotalArchived()[0]->TotalArchived;
		
		$SendData['jobDetails'] = $details;

		$SendData['OverduesMoreThenTwoweek'] = $OverduesMoreThenTwoweek;
		
		$SendData['UrgentsJobs'] = $UrgentsJobs;

		$SendData['urgent'] = $this->admin_model->urgent();

		$SendData['routineCases'] = $this->admin_model->routineCases();

		$SendData['doctorOnline'] = $this->admin_model->DoctorloggedInToday();

	//	$SendData['casesAuthorised'] = $this->admin_model->casesAuthorised();
		$SendData['acceptedCase'] = $this->admin_model->AcceptedCase();
		//$SendData['acceptedCase'] = "55";



		$SendData['notallocated'] = $this->admin_model->notallocated();

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		$SendData['autoAccept'] = $this->admin_model->GetConfigOption('','1','__auto__accept__jobs__')[0]->value;

	
		$this->load->view('dashboard',$SendData);
	}


	public function ViewAll()
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

		$SendData['doctors'] = $this->admin_model->getAllDoctor();

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$details = $this->admin_model->getAllJobsDetails();

		$UrgentsJobs = $this->admin_model->getAllUrgentJobsDetails(); 

		$reports = $this->admin_model->reported();

		
			foreach($details as $detail){
				$report_id = $detail->test_id;
				if(!empty($report_id)){
					$reportbyId = $this->admin_model->reportById($report_id);
					if(!empty($reportbyId)){
						$detail->report = "Available";
					}else{
						$detail->report = "";
					}
				}else{
					$detail->report = "";
				}

				$detail->test_doctor_report = $this->admin_model->GetDoctorsByTestId($detail->test_primary_id);
			}

			
			/*foreach($details as $detail){
				$test_id = $detail->test_id;
				$invoicebyId = $this->admin_model->invoicealreadySend($test_id);
				if(!empty($invoicebyId)){ 
					$detail->invoicealreadySend = "already send";

				}else{
					$detail->invoicealreadySend = "";
				}
			}*/


			foreach($UrgentsJobs as $detail){ 
				$report_id = $detail->test_id;
				if(!empty($report_id)){
					$reportbyId = $this->admin_model->reportById($report_id);
					if(!empty($reportbyId)){ 
						$detail->report = "Available";
					}else{
						$detail->report = "";
					}
				}else{
					$detail->report = "";
				}

				$detail->test_doctor_report = $this->admin_model->GetDoctorsByTestId($detail->test_primary_id);
			}

			/*foreach($UrgentsJobs as $detail){
				$test_id = $detail->test_id;
				$invoicebyId = $this->admin_model->invoicealreadySend($test_id);
				if(!empty($invoicebyId)){
					$detail->invoicealreadySend = "already send";
				}else{
					$detail->invoicealreadySend = "";
				}
			}
			*/

		$SendData['jobDetails'] = $details;

		$SendData['UrgentsJobs'] = $UrgentsJobs;
/*
		$SendData['urgent'] = $this->admin_model->urgent();

		$SendData['routineCases'] = $this->admin_model->routineCases();

		$SendData['doctorOnline'] = $this->admin_model->DoctorloggedInToday();

		//$SendData['casesAuthorised'] = $this->admin_model->casesAuthorised();

		$SendData['notallocated'] = $this->admin_model->notallocated();
*/
		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;
	
		$this->load->view('ViewAll',$SendData);
	}

	/*public function Profile()
	{
		if(empty($this->session->userdata('id'))){
			redirect(base_url());
		}

		$this->load->view('setting');
	}*/


	public function ChooseExistingPatient()
	{
	
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

		$details = $this->admin_model->getAllPatient();

		$SendData['patients'] = $details;

		$this->load->view('chooseexistingpatient',$SendData);
	}


	public function Filter()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

		$SendData['query'] = $this->input->get('query');


		$SendData['testDetails'] = $this->admin_model->getAllJobsForAdmin();
		$SendData['doctors'] = $this->admin_model->getAllDoctor();

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		$this->load->view('filter',$SendData);
	}

	public function addJob()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

		$last_visio_num = $this->admin_model->last_visio_num();

		$visiopath = $last_visio_num[0]->visiopath_number;

		$value = explode("VP", $visiopath);

		$NewValue =  $value[1] + 1;

		$year =  date("y") ;

		if($year != $value[0]){
			$NewValue = '1';
		}

		$SendData['visiopath_number'] = $year."VP".$NewValue;

		
		$SendData['doctors'] = $this->admin_model->getAllDoctor();

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$SendData['typeOfTest'] = $this->admin_model->getAllTypeOfTest();


		$this->load->view('addjob',$SendData);
	}



	public function AddExistingjob($id)
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

		$SendData['patient_id'] = $id;

		$last_visio_num = $this->admin_model->last_visio_num();

		$visiopath = $last_visio_num[0]->visiopath_number;

		$value = explode("VP", $visiopath);

		$NewValue =  $value[1] + 1;

		$year =  date("y") ;

		if($year != $value[0]){
			$NewValue = '1';
		}

		$SendData['visiopath_number'] = $year."VP".$NewValue;

		$SendData['patientDetails'] = $this->admin_model->getPatientById($id) ;

		$SendData['typeOfTest'] = $this->admin_model->getAllTypeOfTest();
		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$this->load->view('addexistingjob',$SendData);
	}

	public function addNewJob()
	{


		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

		/*$last_visio_num = $this->admin_model->last_visio_num();

		 $visiopath = $last_visio_num[0]->visiopath_number;

		 $value = explode("VP", $visiopath);

		 $NewValue =  $value[1] + 1;

		 $year =  date("y") ;

		 $visiopath_number = $year."VP".$NewValue;*/



		 
		$username = $_POST['Fname']." ".$_POST['Lname']; 
		$data['patient_name'] = $_POST['Fname'];
		$data['last_name'] = $_POST['Lname'];

		$Ndob = $_POST['DOB'];
		
		$date = date_create($Ndob);
		$dob =  date_format($date,"Y/m/d");

			if ($dob != "") {
				if (strpos($dob, '-') !== false) {
					$dob = explode("-", $dob);
					$dob = $dob[0] . "-" . $dob[1] . "-" . $dob[2];
				} elseif (strpos($dob, '/') !== false) {
					$dob = explode("/", $dob);
					$dob = $dob[0] . "/" . $dob[1] . "/" . $dob[2];
				} else {
					$dob = $dob;
				}
			}
		
		
		$data['DateOfBirth'] = $dob;
		$data['address'] = $_POST['address'];


        $data['nhs_number'] = $_POST['nhs_number'];
		
		
		$data['address_two'] = $_POST['address_two']; 
		$data['gender'] = $_POST['gender'];
		$data['email'] = $_POST['email_address'];
		$data['mobile_number'] = $_POST['mob_number'];
		$data['hospital_number'] = $_POST['Hnumber'];
        $data['company_id'] = $_POST['company_id'];
		
		/*$data['Client_case_number'] = $_POST['Case_refrence_number'];
		$data['hospital_id'] = $_POST['Rinstitute'];

		$data['visiopath_number'] = $_POST['visiopath_case_number'];*/

		$patient_id = $this->admin_model->AddNewPatientDetails($data);

		$Sdata['patient_id'] = $patient_id;
		$Sdata['Client_case_number'] = $_POST['Case_refrence_number'];
		$Sdata['hospital_id'] = $_POST['Rinstitute'];
		
		$Sdata['specimen_text'] = $_POST['specimen_text'];
		$Sdata['clinical_details'] = $_POST['clinical_details'];
		$Sdata['macroscopic_details'] = $_POST['macroscopic_details'];
		
		
		
		$Sdata['visiopath_number'] = $_POST['visiopath_case_number'];

		$VPexist = $this->admin_model->VPexist($_POST['visiopath_case_number']);

		if(!empty($VPexist)){
			redirect(base_url().'admin/addJob?VPexist');
		}


		$Sdata['specimen'] = '5';
		$Sdata['no_of_specimen'] = $_POST['no_of_specimen']; 

		$last_Snomed = $this->admin_model->last_Snomed();

		$snomed_code = $last_Snomed[0]->snomed_code;

		$value = explode("M", $snomed_code);

		$NewValue =  $value[1] + 1;

		$snomed_code = "M".$NewValue;


		$test_date = $_POST['test_date'];

		$date = date_create($test_date);
		$test_date =  date_format($date,"Y/m/d");


			if ($test_date != "") {
				if (strpos($test_date, '-') !== false) {
					$test_date = explode("-", $test_date);
					$test_date = $test_date[0] . "-" . $test_date[1] . "-" . $test_date[2];
				} elseif (strpos($test_date, '/') !== false) {
					$test_date = explode("/", $test_date);
					$test_date = $test_date[0] . "/" . $test_date[1] . "/" . $test_date[2];
				} else {
					$test_date = $test_date;
				}
			}

			
		$Sdata['test_date'] = $test_date;
        $Sdata['company_id'] = $_POST['company_id'];
		$Sdata['admin_archive'] = "0";
		$Sdata['doctor_archive'] = "0";
		$Sdata['status'] = "Unassigned";
		$Sdata['test_type_id'] = '5';
		$Sdata['notes'] = $_POST['notes'];
		$Sdata['urgent'] = $_POST['case_type'];
		$Sdata['snomed_code'] = $snomed_code;

		$Sdata['pathologists_fee'] = $_POST['pathologists_fee'];


		$Sdata['specimen_fee'] = $_POST['specimen_fee'];

		
		$id = $this->session->userdata('id');
		
		$Notify['userId '] = $id;
		$Notify['user_action '] = "Admin Add New Job Client case number: ".$Sdata['Client_case_number'];
		

		$notification = $this->admin_model->AddNotification($Notify);

		$test_id = $this->admin_model->AddNewJobDetails($Sdata);

		if(!empty($_FILES['upload_file'])){ 

		 		$files = $_FILES['upload_file'];
		 		$i = 0;
		 		foreach($files as $file){ ;

		 			if(!empty($files['name'][$i])){
		 				$attach_file[] = "assets/uploads/".$files['name'][$i];
		 			
		 				$file_name = $files['name'][$i];
				        $file_tmp =  $files['tmp_name'][$i];

				        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
						//$allowed = array('jpg','png','gif','jpeg','bmp','svg','tif','psd','ai','JPEG','pdf');
						

						if(!empty($file_name)){
				        	move_uploaded_file($file_tmp,"assets/uploads/".$file_name);
				        }
						
				
		 			 }
		 		  $i++;
		 		}
		}else{
			$attach_file[] = "";
		}
		
		if(!empty($attach_file)){

			 		foreach($attach_file as $file){

			 			$Pdata['test_id '] = $test_id;
						$Pdata['upload_file'] = $file;
				
						if(!empty($file)){
							$Upload_multiple_attach = $this->admin_model->Upload_multiple_attach_By_Admin($Pdata);
						}
			 		}
		}
		
		/*$hospital_details = $this->hospital_model->getHospitalById($Sdata['hospital_id'])[0];
			
		
			$Content = array();
			$this->load->library('event');
			$Content['heading'] = "Dear ".$hospital_details->first_name.","; 
			$Content['secondHeading'] = "Admin just created new Job in your institution"; 
			$Content['thirdHeading'] = "Please login and review"; 
			
			            
            $data['to'] = $hospital_details->email;
            
			if($Sdata['urgent'] == 1){
           	 	$data['subject'] = 'Admin added new [URGENT] Job - Visiopath';
			}else{
				$data['subject'] = 'Admin added new Job - Visiopath';
			}
            $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$this->message_model->AddNewMessageOutside($id,$hospital_details->id,$data['subject'],$data['body']);
            $this->event->email($data);*/
		
		
		if($this->db->affected_rows()>0 )
			{
				redirect('admin/ViewAll');
			}

	}

	
	public function doctorInvoice()
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		if($this->session->userdata('user_type') == 1){ redirect(base_url());	}

		$StartDate = $this->input->get('startdate');
		$EndDate = $this->input->get('enddate');

		if(empty($StartDate)){
			$StartDate = '';
		}

		if(empty($EndDate)){
			$EndDate = '';
		}


		$doctor_id = $this->session->userdata('UserDetail_Id');

		$jobDetails = $this->invoice_model->getAllDoctorInvoiceByAdmin('doctor','',$StartDate,$EndDate);

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['TotalValue'] = $this->admin_model->GetTotalValueOfDoctorInvocies('','',$StartDate,$EndDate)[0]->total;

		

		$SendData['PaidValue'] = $this->admin_model->GetTotalValueOfDoctorInvocies('1','',$StartDate,$EndDate)[0]->total; 
		
		$SendData['UnPaidValue'] = $this->admin_model->GetTotalValueOfDoctorInvocies('','1',$StartDate,$EndDate)[0]->total; 

		//$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$SendData['jobDetails'] = $jobDetails;

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		
		$this->load->view('admin/doctor_invoice',$SendData);
	}
	public function hospitalInvoice()
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		if($this->session->userdata('user_type') == 1){ redirect(base_url());	}

		$StartDate = $this->input->get('startdate');
		$EndDate = $this->input->get('enddate');

		if(empty($StartDate)){
			$StartDate = '';
		}

		if(empty($EndDate)){
			$EndDate = '';
		}

		$doctor_id = $this->session->userdata('UserDetail_Id');

		$jobDetails = $this->invoice_model->getAllDoctorInvoiceByAdmin('',$StartDate,$EndDate);

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['TotalValue'] = $this->admin_model->GetTotalValueOfHospitalInvocies('','',$StartDate,$EndDate)[0]->total;

		$SendData['PaidValue'] = $this->admin_model->GetTotalValueOfHospitalInvocies('1','',$StartDate,$EndDate)[0]->total; 
		
		$SendData['UnPaidValue'] = $this->admin_model->GetTotalValueOfHospitalInvocies('','1',$StartDate,$EndDate)[0]->total; 
		
		//$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$SendData['jobDetails'] = $jobDetails;

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		
		$this->load->view('admin/hospital_invoice',$SendData);
	}
	public function payInvoice($id){
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
	
	
	
		$this->invoice_model->AdminPayToDoctor($id);
		$data_test = $this->admin_model->getTestDetailsById($id);
	
		
		$test_id = $id;
		$id = $this->session->userdata('id');
		$Notify['userId '] = $id;
		$Notify['user_action '] = "Admin paid Doctor on Client Case Number: ".$data_test[0]->Client_case_number;

		$notification = $this->admin_model->AddNotification($Notify);
			$doctor_details = $this->doctor_model->GetDoctorDetails($data_test[0]->doctor_id)[0];
			
			$Content = array();
			$this->load->library('event');
			$Content['heading'] = "Dear Doctor,"; 
			$Content['secondHeading'] = "Admin paid Doctor on Client Case Number: ".$data_test[0]->Client_case_number;
			$Content['thirdHeading'] = "Below are the details: "; 
			//$Content['TextLineOne'] = "<strong>Patient Name: </strong> ".$data_test[0]->patient_name;
			//$Content['TextLineOne'] = "<strong>Snomed Code: </strong> ".$data_test[0]->snomed_code;
			$Content['TextLineOne'] = "<strong>Visiopath Number: </strong> ".$data_test[0]->visiopath_number;
			
			$Content['TextLineThree'] = "<a href='".base_url()."doctor/viewInvoice/".$test_id."' >Click here to view Invoice</a>"; 
			
			$data = array();
             $data['to'] = $doctor_details->email;
            
           	$data['subject'] = 'Admin Paid Invoice - Visiopath';
            $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$this->message_model->AddNewMessageOutside($id,$doctor_details->id,$data['subject'],$data['body']);
            if($this->event->email($data)){		
				redirect('admin/doctorInvoice?Paid');
			}
			
			
		
	}

	public function UnpayInvoice($id){
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		$responce =  $this->invoice_model->UnpayInvoiceToDoctor($id);

		$data_test = $this->admin_model->getTestDetailsById($id);
		$Uid = $this->session->userdata('id');
		
		$Notify['userId '] = $Uid;
		$Notify['user_action '] = "Admin Unpay Invoice for Doctor Client case number: ".$data_test[0]->Client_case_number;
		

		$notification = $this->admin_model->AddNotification($Notify);
		
		if(!$responce ){
			return true;
		}else{
			return false;
		}
		
		
	}
	
	public function payInvoiceHospital($id){
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		
		$this->invoice_model->AdminPayToHospital($id);
		$data_test = $this->admin_model->getTestDetailsById($id);
		$test_id = $id;
		$id = $this->session->userdata('id');
		$Notify['userId '] = $id;
		$Notify['user_action '] = "Invoice paid by hospital on Case number: ".$data_test[0]->Client_case_number;

		$notification = $this->admin_model->AddNotification($Notify);
		$hospital_details = $this->hospital_model->getHospitalById($data_test[0]->hospital_id)[0];
		$Content = array();
			$this->load->library('event');
			$Content['heading'] = "Dear ".$hospital_details->hospital_name.","; 
			$Content['secondHeading'] = "Admin paid by hospital on Client case number:".$data_test[0]->Client_case_number;
			$Content['thirdHeading'] = "Below are the details: "; 
			//$Content['TextLineOne'] = "<strong>Patient Name:</strong> ".$data_test[0]->patient_name;
			$Content['TextLineOne'] = "<strong>Snomed Code:</strong> ".$data_test[0]->snomed_code;
			$Content['TextLineTwo'] = "<strong>Visiopath Number:</strong> ".$data_test[0]->visiopath_number;
			
			$Content['TextLineThree'] = "<a href='".base_url()."hospital/viewInvoice/".$test_id."' >Click here to view Invoice</a>"; 
			
			$data = array();
             $data['to'] = $hospital_details->email;
            
           	$data['subject'] = 'Admin Paid By Hospital- Visiopath';
            $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$this->message_model->AddNewMessageOutside($id,$hospital_details->id,$data['subject'],$data['body']);
            if($this->event->email($data)){		
				redirect('admin/hospitalInvoice?Paid');
			}
			
			
		
	}

	public function UnpayInvoiceHospital($id){
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$responce =  $this->invoice_model->AdminUnPayToHospital($id);

		$data_test = $this->admin_model->getTestDetailsById($id);
		$Uid = $this->session->userdata('id');
		
		$Notify['userId '] = $Uid;
		$Notify['user_action '] = "Admin Unpay Invoice for hospital Client case number: ".$data_test[0]->Client_case_number;
		

		$notification = $this->admin_model->AddNotification($Notify);
		
		if(!$responce ){
			return true;
		}else{
			return false;
		}
		
		
	}
	
	public function sendInvoiceHospital($id){
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		
		$this->invoice_model->AdminSendToHospital($id);
		$data_test = $this->admin_model->getTestDetailsById($id);
		
		$test_id = $id;
		$id = $this->session->userdata('id');
		$Notify['userId '] = $id;
		$hospital_details = $this->hospital_model->getHospitalById($data_test[0]->hospital_id)[0];
		$Notify['user_action '] = "Invoice Sent to ".$hospital_details->hospital_name." on Case number: ".$data_test[0]->Client_case_number;

		$notification = $this->admin_model->AddNotification($Notify);
			
			
			$Content = array();
			$this->load->library('event');
			$Content['heading'] = "Dear ".$hospital_details->hospital_name; 
			$Content['secondHeading'] = "A Invoice has been generated for Visiopath Case Number: ".$data_test[0]->Client_case_number; 
			$Content['thirdHeading'] = "Please check the details and revert."; 
			//$Content['TextLineOne'] = "<strong>Patient Name :</strong> ".$data_test[0]->patient_name;
			$Content['TextLineOne'] = "<strong>Snomed Code :</strong> ".$data_test[0]->snomed_code;
			$Content['TextLineTwo'] = "<strong>Visiopath Number :</strong> ".$data_test[0]->visiopath_number;
			
			$Content['TextLineThree'] = "<a href='".base_url()."hospital/viewInvoice/".$test_id."' >Click here to view Invoice</a>"; 
			
			$data = array();
             $data['to'] = $hospital_details->email;
            
           	$data['subject'] = 'Visiopath Invoice Requested - Visiopath';
            $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$this->message_model->AddNewMessageOutside($id,$hospital_details->id,$data['subject'],$data['body']);
            if($this->event->email($data)){		
				redirect('admin/hospitalInvoice?Sent');
			}
			
			
		
	}
	
	
	
	
	public function addExistingJobDetails()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		if(empty($this->session->userdata('id'))){
				redirect(base_url());
		}

		$patient_id = $_POST['patient_id'];

		$data['patient_name'] = $_POST['Fname'];
		$data['last_name'] = $_POST['Lname'];
		$data['email'] = $_POST['email_address'];
		$data['nhs_number'] = $_POST['nhs_number'];
        $data['company_id'] = $_POST['company_id'];

		$dob = $_POST['DOB'];

		$date = date_create($dob);
		$dob =  date_format($date,"Y/m/d");

			if ($dob != "") {
				if (strpos($dob, '-') !== false) {
					$dob = explode("-", $dob);
					$dob = $dob[0] . "-" . $dob[1] . "-" . $dob[2];
				} elseif (strpos($dob, '/') !== false) {
					$dob = explode("/", $dob);
					$dob = $dob[0] . "/" . $dob[1] . "/" . $dob[2];
				} else {
					$dob = $dob;
				}
			}
		
		$data['DateOfBirth'] = $dob;
		$data['address'] = $_POST['address']; 
		$data['address_two'] = $_POST['address_two']; 
		$data['gender'] = $_POST['gender'];
		$data['mobile_number'] = $_POST['mob_number'];
		$data['hospital_number'] = $_POST['Hnumber'];
		
		if($this->session->userdata('roleId') == 1){
		 	$this->admin_model->UpdatePatientDetails($data,$patient_id);
		}
		
		$Sdata['patient_id'] = $patient_id;
		$Sdata['specimen'] = '5';
		$Sdata['Client_case_number'] = $_POST['Case_refrence_number'];
		$Sdata['hospital_id'] = $_POST['Rinstitute'];
		$Sdata['visiopath_number'] = $_POST['visiopath_case_number'];
        $Sdata['company_id'] = $_POST['company_id'];

		$VPexist = $this->admin_model->VPexist($_POST['visiopath_case_number']);

		if(!empty($VPexist)){
			redirect(base_url().'admin/AddExistingjob/'.$patient_id.'?VPexist');
		}

		$Sdata['notes'] = $_POST['notes'];
		$Sdata['no_of_specimen'] = $_POST['no_of_specimen']; 

		$Sdata['specimen_text'] = $_POST['specimen_text'];
		$Sdata['clinical_details'] = $_POST['clinical_details'];
		$Sdata['macroscopic_details'] = $_POST['macroscopic_details'];

		$test_date = $_POST['test_date'];

		$date = date_create($test_date);
		$test_date =  date_format($date,"Y/m/d");

		

			if ($test_date != "") {
				if (strpos($test_date, '-') !== false) {
					$test_date = explode("-", $test_date);
					$test_date = $test_date[0] . "-" . $test_date[1] . "-" . $test_date[2];
				} elseif (strpos($test_date, '/') !== false) {
					$test_date = explode("/", $test_date);
					$test_date = $test_date[0] . "/" . $test_date[1] . "/" . $test_date[2];
				} else {
					$test_date = $test_date;
				}
			}

		

		$Sdata['test_date'] = $test_date;
		$Sdata['status'] = "Unassigned";
		$Sdata['test_type_id'] = '5';

		$Sdata['urgent'] = $_POST['case_type'];

		$last_Snomed = $this->admin_model->last_Snomed();

		$snomed_code = $last_Snomed[0]->snomed_code;

		$value = explode("M", $snomed_code);

		$NewValue =  $value[1] + 1;

		$snomed_code = "M".$NewValue;

		$Sdata['snomed_code'] = $snomed_code;

		$Sdata['pathologists_fee'] = $_POST['pathologists_fee'];

		

		$Sdata['specimen_fee'] = $_POST['specimen_fee'];

		



		$id = $this->session->userdata('id');
		
		$Notify['userId '] = $id;
		$Notify['user_action '] = "Admin Add Existing Job for Client_case_number: ".$Sdata['Client_case_number'];

		$notification = $this->admin_model->AddNotification($Notify);

			$hospital_details = $this->hospital_model->getHospitalById($Sdata['hospital_id'])[0];
		$test_id = $this->admin_model->AddNewJobDetails($Sdata);


		if(!empty($_FILES['upload_file'])){ 

		 		$files = $_FILES['upload_file'];
		 		$i = 0;
		 		foreach($files as $file){ ;

		 			if(!empty($files['name'][$i])){
		 				$attach_file[] = "assets/uploads/".$files['name'][$i];
		 			
		 				$file_name = $files['name'][$i];
				        $file_tmp =  $files['tmp_name'][$i];

				        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
						//$allowed = array('jpg','png','gif','jpeg','bmp','svg','tif','psd','ai','JPEG','pdf');
						

						if(!empty($file_name)){
				        	move_uploaded_file($file_tmp,"assets/uploads/".$file_name);
				        }
						
				
		 			 }
		 		  $i++;
		 		}
		}else{
			$attach_file[] = "";
		}
		
		if(!empty($attach_file)){

			 		foreach($attach_file as $file){

			 			$Pdata['test_id '] = $test_id;
						$Pdata['upload_file'] = $file;
				
						if(!empty($file)){
							$Upload_multiple_attach = $this->admin_model->Upload_multiple_attach_By_Admin($Pdata);
						}
			 		}
		}
		
			$Content = array();
			$this->load->library('event');
			$Content['heading'] = "Dear ".$hospital_details->hospital_name.","; 
			$Content['secondHeading'] = "Admin just created new Job in your institution."; 
			$Content['thirdHeading'] = "Please login and review."; 
            $data['to'] = $hospital_details->email;
            
			if($Sdata['urgent'] == 1){
           	 	$data['subject'] = 'Admin added new [URGENT] Job - Visiopath';
			}else{
				$data['subject'] = 'Admin added new Job - Visiopath';
			}
            $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$this->message_model->AddNewMessageOutside($id,$hospital_details->id,$data['subject'],$data['body']);
            $this->event->email($data);
		
		
		if($this->db->affected_rows()>0 )
			{
				redirect('admin/ViewAll');
			}

	}

	public function assignDoctortopatient()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$GetData =  $this->input->get('doctor_id');
		$GetDataArr = explode("|",$GetData);

		$doctor_id =  $GetDataArr[0];
		$test_id = $GetDataArr[1];

		$test_details = $this->admin_model->GetPatientDetailsById($test_id);

		$patient_name = $test_details[0]->patient_name;

		$NewData['test_id'] = $test_id;
		$NewData['doctor_id'] = $doctor_id;
		$NewData['status'] = '0';

		$test_ids = $this->admin_model->AssignMultipleDoctorToTest($NewData);

		//$test_ids = $this->admin_model->AssignDoctorToTest($doctor_id,$test_id);

		$data_test = $this->admin_model->getTestDetailsById($test_id);
		$id = $this->session->userdata('id');
		
		$Notify['userId '] = $id;
		$Notify['user_action '] = "Admin Assign doctor to Client case number:".$data_test[0]->Client_case_number;

		$notification = $this->admin_model->AddNotification($Notify);
			
			
			$data_test = $this->admin_model->getTestDetailsById($test_id);
			$doctor_details = $this->doctor_model->GetDoctorDetails($doctor_id)[0];
			$hospital_details = $this->hospital_model->getHospitalById($data_test[0]->hospital_id)[0];
		
			$Content = array();
			$this->load->library('event');
			$Content['heading'] = "Dear Dr ".$doctor_details->doctor_name.","; 
			$Content['secondHeading'] = "A new case has been assigned to you."; 
			$Content['thirdHeading'] = "Please login and review case below: "; 
			$Content['TextLineOne'] = "<strong>Institute Name: </strong>".$hospital_details->hospital_name; 
			$Content['TextLineTwo'] = "<strong>Client case number: </strong>".$data_test[0]->Client_case_number; 
			$Content['TextLineThree'] = "<strong>Visiopath Number: </strong>".$data_test[0]->visiopath_number; 
			$Content['TextLineForth'] = "<a href='".base_url()."doctor/viewTestDetails/".$test_id."' >Click here to view case</a>"; 

            $data['to'] = $doctor_details->email;
            
           	$data['subject'] = 'New Visiopath Case assigned';
            $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$this->message_model->AddNewMessageOutside($id,$doctor_details->id,$data['subject'],$data['body']);
            $this->event->email($data);
		
		
		if($test_id != 'Fail'){
			echo "--Done--";
		}
			
	}

	public function AddtoArchive()
	{
		$Post_id =  $this->input->get('Post_id');
		
		$test_id = $this->admin_model->AddtoArchive($Post_id);

		if($test_id != 'Fail'){
			echo "--Done--";
		}
			
	}

	public function AddAdmin()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		$this->load->view('addadmin');
			
	}
	
	public function AddTestType()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		$this->load->view('addspecimen');
			
	}
	


	public function AddDoctor()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		$this->load->view('adddoctor');
			
	}
	
	/*public function EditDoctor()
	{
		$this->load->view('editdoctor');
			
	}
*/

	public function AddHospital()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		$this->load->view('hospital/addhospital');
			
	}

	public function EditHospital($id)
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$data['hospital'] = $this->hospital_model->getHospitalById($id)[0];
		
		if(!empty($data['hospital'])){		
			$data['hospital_user'] = $this->hospital_model->getHospitalUserById($data['hospital']->hospital_id)[0];
			$this->load->view('hospital/edithospital',$data);
		}else{
			redirect(base_url());
		}	
	}
	
	public function editTestType($id)
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		if(empty($this->session->userdata('id'))){
				redirect(base_url());
		}
		
		$datas['TestType'] = $this->admin_model->getTypeTestbyId($id)[0];
		
		$this->load->view('edittesttype',$datas);
		
			
	}
	
	
	
	
	public function EditDoctor($id)
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		if(empty($this->session->userdata('id'))){
				redirect(base_url());
		}
	
		$data['Doctordetails'] = $this->doctor_model->GetDoctorDetails($id);
		if(!empty($data['Doctordetails'])){		
			$data['Userdetails'] = $this->doctor_model->getDoctorUserById($data['Doctordetails'][0]->doctor_id);
			$data['DoctorFiles'] = $this->doctor_model->GetDoctorFiles($data['Doctordetails'][0]->doctor_id);
			$this->load->view('doctor/editdoctor',$data);
		}else{
			redirect(base_url());
		}
			
	}
	
		
	public function deleteHospital($id)
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$data['hospital'] = $this->hospital_model->getHospitalById($id)[0];
		$data['hospital_user'] = $this->hospital_model->getHospitalUserById($data['hospital']->hospital_id)[0];
		
		
		$this->load->view('hospital/edithospital',$data);
			
	}
	
	public function deleteAdmin($id)
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		
		$this->admin_model->DeleteAdminUserById($id);
		
		
		redirect('admin/ShowAllAdminUser?dataupdated');
			
	}
	
	public function deleteTestType($id)
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$this->admin_model->deleteTestType($id);
		redirect('admin/ShowTestType'."?datadeleted");
			
	}
	
	
	
	public function updateTestType($id)
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$userdata= $this->input->post();
	
		$this->admin_model->updateTestTypeById($userdata,$id);
		$sid = $this->session->userdata('id');
		
		$Notify['userId '] = $sid;
		$Notify['user_action '] = "Admin edit Test Type: ".$this->input->post("TestTypeName");

		$notification = $this->admin_model->AddNotification($Notify);
	
		redirect('admin/editTestType/'.$id."?dataupdated");
	
	}
	public function updateHospital($id)
	{
	
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		$userdata['hospital_name'] = $this->input->post("institute_name");
		//$userdata['hospital_number'] = $this->input->post("hospital_number");
		$userdata['address'] = $this->input->post("address");
		$userdata['phone'] = $this->input->post("mobile_number");
		$userdata['hospital_pincode'] = $this->input->post("hospital_pincode");
	
	
	
	
	$this->hospital_model->updateHospitalById($userdata,$id);
	
	
	$userdata = array();

	
	$userdata['first_name'] = $this->input->post("first_name");
	$userdata['last_name'] = $this->input->post("last_name");
	$userdata['notes'] = $this->input->post("notes");
	$password = $this->input->post("password");
	if($password !="password"){
		$userdata['password'] = md5($this->input->post("password"));
		$userdata['original_password'] = ($this->input->post("password"));
	}
	$userdata['address'] = $this->input->post("address");
	$userdata['mobile_number'] = $this->input->post("mobile_number");
	$user_id = $this->input->post("user_id");
	
	
	$this->user_model->UpdateUserByAdmin($userdata,$user_id);
	
	
			$id = $this->session->userdata('id');
		
			$Notify['userId '] = $id;
			$Notify['user_action '] = "Admin edit Hospital: ".$userdata['hospital_name'];

			$notification = $this->admin_model->AddNotification($Notify);
	
		redirect('admin/ShowAllHospitals'."?dataupdated");
			
	}
	
	
	public function updateDoctor($id)
	{
	
	if(empty($this->session->userdata('id'))){ redirect(base_url()); }
	if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
	
	$doc_id = $id;
	$userdata['doctor_name'] = $this->input->post("first_name")." ".$this->input->post("last_name");
	$userdata['department'] = $this->input->post("department");
	$userdata['work_number'] = $this->input->post("mobile_number");
	$userdata['secondary_email'] = $this->input->post("secondary_email");
	$userdata['doctor_specialties'] = $this->input->post("doctor_specialties");
	$userdata['gender'] = $this->input->post("gender");
	$userdata['gmc_number'] = $this->input->post("gmc_number");
	$userdata['work_number'] = $this->input->post("work_number");
	$userdata['show_email'] = $this->input->post("show_email");
	$userdata['show_number'] = $this->input->post("show_number");
	
	 
	

		 	if(!empty($_FILES['Doctor_upload'])){ 

		 		$files = $_FILES['Doctor_upload'];
		 		$i = 0;
		 		foreach($files as $file){ ;

		 			if(!empty($files['name'][$i])){
		 				 $attach_file[] = "assets/uploads/".$files['name'][$i];
		 				$file_name = $files['name'][$i];
				        $file_tmp =  $files['tmp_name'][$i];

				        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
						$allowed = array('jpg','png','gif','jpeg','bmp','svg','tif','psd','ai','JPEG','pdf');
						

						if( ! in_array( $ext, $allowed ) ) {
							$data['error'] = "yes";

							//redirect(base_url().'setting/EditProfile/'.$id);
							
						}else{
							if(!empty($file_name)){
				        	 move_uploaded_file($file_tmp,"assets/uploads/".$file_name);
				        	}
						} 
				
		 		}
		 	$i++;
		 }
			}else{
				$attach_file[] = "";
			}

		 		

		 		if(!empty($attach_file)){

			 		foreach($attach_file as $file){

			 			$Sdata['doctor_id'] = $doc_id;
						$Sdata['filename'] = $file;
						$Upload_Doctor_documents = $this->doctor_model->Upload_Doctor_documents($Sdata);

			 		}
			 	}
		 	//$this->user_model->UpdateDoctor($userdata);

		 	$id = $this->session->userdata('id');
		
			$Notify['userId '] = $id;
			$Notify['user_action '] = "Admin Upload Document in Doctor ".$userdata['doctor_name']." Profile";

			$notification = $this->admin_model->AddNotification($Notify);
		
	
	$this->doctor_model->updateDoctorById($userdata,$doc_id);
	
	
	$userdata = array();

	
	$userdata['first_name'] = $this->input->post("first_name");
	$userdata['username'] = $this->input->post("first_name")." ".$this->input->post("last_name");
	$userdata['last_name'] = $this->input->post("last_name");
	$userdata['notes'] = $this->input->post("notes");
	$password = $this->input->post("password");
	if($password !="password"){
		$userdata['password'] = md5($this->input->post("password"));
		$userdata['original_password'] = ($this->input->post("password"));
	}
	$userdata['address'] = $this->input->post("address");
	$userdata['mobile_number'] = $this->input->post("mobile_number");
	$user_id = $this->input->post("user_id");
	
	
	$this->user_model->UpdateUserByAdmin($userdata,$user_id);
	
	
			$id = $this->session->userdata('id');
		
			$Notify['userId '] = $id;
			$Notify['user_action '] = "Admin edit Doctor: ".$userdata['username'];

			$notification = $this->admin_model->AddNotification($Notify);
	
		redirect('admin/ShowAllDoctor'."?dataupdated");
			
	}
	

	
	
	
	public function exportAdminUsers()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$fields = array('id','email','first_name','last_name','mobile_number','address','DateOfBirth','notes');
		$admins = $this->admin_model->GetAllAdminDetailsCsv($fields);
		foreach($fields as $field){ $changedField[] = ucwords(str_replace("_"," ",$field)); }
		$data_field[0] = $changedField;
   		$array_data = json_decode(json_encode($admins), true);
		$datas = array_merge($data_field,$array_data);
		$this->admin_model->array_to_csv_download($datas,"AdminUsers.csv",",");
	}
	
	public function allJobsexport()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$fields = array('td.test_id','pd.patient_name','td.Client_case_number','td.test_date','hos.hospital_name','doc.doctor_name','td.visiopath_number');
		$admins = $this->admin_model->getAllJobsDetailsCSV($fields);
		foreach($fields as $field){ $fieldarr = explode(".",$field); $changedField[] = ucwords(str_replace("_"," ",$fieldarr[1])); }
		$data_field[0] = $changedField;
   		$array_data = json_decode(json_encode($admins), true);
		$datas = array_merge($data_field,$array_data);
		$this->admin_model->array_to_csv_download($datas,"AllJobs.csv",",");
	}
	
	
	public function exportDoctorUsers()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$fields = array('id','doctor_name','email','secondary_email','doctor_specialties','department','gender','gmc_number','work_number','address','DateOfBirth','notes');
		$doctors = $this->admin_model->GetAllDoctorsDetailsCSV($fields);
		foreach($fields as $field){ $changedField[] = ucwords(str_replace("_"," ",$field)); }
		$data_field[0] = $changedField;
   		$array_data = json_decode(json_encode($doctors), true);
		$datas = array_merge($data_field,$array_data);
		$this->admin_model->array_to_csv_download($datas,"DoctorUsers.csv",",");
	}
	public function exportHospitalUsers()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$fields = array('id','hospital_name','email','hospitals.address','phone','hospital_number','notes');
		$hospitals = $this->admin_model->GetAllHospitalsDetailsCSV($fields);
		foreach($fields as $field){ $changedField[] = ucwords(str_replace("_"," ",$field)); }
		$data_field[0] = $changedField;
   		$array_data = json_decode(json_encode($hospitals), true);
		$datas = array_merge($data_field,$array_data);
		$this->admin_model->array_to_csv_download($datas,"HospitalUsers.csv",",");
	}
	
	
	
	
	public function ShowAllAdminUser()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		if($this->session->userdata('user_type') == 1){ redirect(base_url());	}
	
		$data['admins'] = $this->admin_model->GetAllAdminDetails();

		$this->load->view('manageAdmin',$data);
			
	}
	
	public function ShowTestType()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		$data['admins'] = $this->admin_model->getAllTypeOfTest();
		$this->load->view('managespecimen',$data);
			
	}

	public function ShowAllDoctor()
	{
			
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		if($this->session->userdata('user_type') == 1){ redirect(base_url());	}

		$data['doctors'] = $this->admin_model->GetAllDoctorsDetails();
		foreach($data['doctors'] as $key=>$value){
			$data['doctors'][$key]->uploads = $this->admin_model->GetAllDoctorsUploads($value->doctor_id);
		}
		
		

		$this->load->view('showalldoctors',$data);
		
		
			
	}

	public function ShowAllHospitals()
	{
			
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		if($this->session->userdata('user_type') == 1){ redirect(base_url());	}

		$data['hospitals'] = $this->admin_model->GetAllHospitalsDetails();

		$this->load->view('showallhospitals',$data);
			
	}

	public function AddNewHospital($type = Null)
	{
			
			if(empty($this->session->userdata('id'))){ redirect(base_url()); }
			if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

			//$hospital_pincode = mt_rand(100000,999999); 
		
			$data['hospital_name'] = $this->input->post('hospital_name');
			$data['address'] = $this->input->post('address');
			$data['phone'] = $this->input->post('mobile_number');
			$data['hospital_pincode'] = $this->input->post('hospital_pincode');
			
		//	$data['hospital_number'] = $this->input->post('hospital_number');

			$hospital_id = $this->admin_model->addNewHospital($data);

			if($hospital_id != 'Fail'){
			  
				$datas['username'] = $this->input->post('first_name')." ".$this->input->post('last_name');
				$datas['roleId'] = '3';
				$datas['UserDetail_Id '] = $hospital_id;
				$datas['email'] = $this->input->post('email');
				$datas['first_name'] = $this->input->post('first_name');
				$datas['last_name'] = $this->input->post('last_name');
                $datas['company_id'] = $this->input->post('company_id');
				$datas['mobile_number'] = $this->input->post('mobile_number');
				$datas['address'] = $this->input->post('address');
				$datas['notes'] = $this->input->post('notes');

				$datas['password'] = md5($this->input->post('password')) ;
				$datas['original_password'] = $this->input->post('password');
				//$datas['hospital_number'] = $this->input->post('hospital_number');

				$hospital_details_id = $this->admin_model->addNewHospitalDetails($datas);

			}

			$id = $this->session->userdata('id');
		
			$Notify['userId '] = $id;
			$Notify['user_action '] = "Admin Add new Hospital name: ".$this->input->post('first_name'). " ".$this->input->post('last_name');;

			$notification = $this->admin_model->AddNotification($Notify);


			$Content = array();
			$this->load->library('event');
			$Content['heading'] = "Dear ".$data['hospital_name'].","; 
			$Content['secondHeading'] = "You have been added to the Visiopath LIMS, and can view Case status via this system."; 
			$Content['thirdHeading'] = "Please find details below: "; 
			$Content['TextLineOne'] = "<strong>Link</strong>: ".base_url(); 
			$Content['TextLineTwo'] = "<strong>Email</strong>: ".$datas['email']; 
			$Content['TextLineThree'] = "<strong>Password</strong>: ".$datas['original_password'];
			$Content['TextLineFourth'] = "<strong>Pincode</strong>: ".$data['hospital_pincode']; 
			            
            $data['to'] = $datas['email'];
             //$data['to'] = 'fahad.m.aslam@gmail.com';
            $data['subject'] = 'Institute added to Visiopath';
            $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
            $this->event->email($data);
			$id = $this->session->userdata('id');
			$this->message_model->AddNewMessageOutside($id,$hospital_details_id,$data['subject'],$data['body']);

			if($this->event->email($data)){		
				if(isset($type)){
					$hospital = $this->admin_model->GetAllHospitalsNames();
					echo json_encode($hospital);
				
				}else{
					if($hospital_details_id != 'Fail'){
						redirect('admin/ShowAllHospitals'.'/?status=done');
					}else{
						redirect('admin/ShowAllHospitals'.'/?status=error');
					}
				}
			}

	}

	public function AddNewDoctor()
	{
			
			if(empty($this->session->userdata('id'))){ redirect(base_url()); }
			if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
			
			
			$data['doctor_name'] = $this->input->post("first_name")." ".$this->input->post("last_name");
			$data['department'] = $this->input->post("department");
			$data['work_number'] = $this->input->post("mobile_number");
			$data['secondary_email'] = $this->input->post("secondary_email");
			$data['doctor_specialties'] = $this->input->post("doctor_specialties");
			$data['gender'] = $this->input->post("gender");
			$data['gmc_number'] = $this->input->post("gmc_number");
			$data['work_number'] = $this->input->post("work_number");
			$data['show_email'] = $this->input->post("show_email");
			$data['show_number'] = $this->input->post("show_number");
	
	

			$doctor_id = $this->admin_model->addNewDoctor($data);
			
			if(!empty($_FILES['Doctor_upload'])){ 

		 		$files = $_FILES['Doctor_upload'];
		 		$i = 0;
		 		foreach($files as $file){ ;

		 			if(!empty($files['name'][$i])){
		 				 $attach_file[] = "assets/uploads/".$files['name'][$i];
		 				$file_name = $files['name'][$i];
				        $file_tmp =  $files['tmp_name'][$i];

				        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
						$allowed = array('jpg','png','gif','jpeg','bmp','svg','tif','psd','ai','JPEG','pdf');
						

						if( ! in_array( $ext, $allowed ) ) {
							$data['error'] = "yes";

							//redirect(base_url().'setting/EditProfile/'.$id);
							
						}else{
							if(!empty($file_name)){
				        	 move_uploaded_file($file_tmp,"assets/uploads/".$file_name);
				        	}
						} 
				
		 		}
		 	$i++;
		 }
			}else{
				$attach_file[] = "";
			}

		 		

		 		if(!empty($attach_file)){

			 		foreach($attach_file as $file){

			 			$Sdata['doctor_id'] = $doctor_id;
						$Sdata['filename'] = $file;
						$Upload_Doctor_documents = $this->doctor_model->Upload_Doctor_documents($Sdata);

			 		}
			 	}
				
				

			if($doctor_id != 'Fail'){
			  
				$datas['username'] = $this->input->post('first_name')." ".$this->input->post('last_name');
				$datas['roleId'] = '2';
				$datas['UserDetail_Id '] = $doctor_id;
				$datas['email'] = $this->input->post('email');
				$datas['first_name'] = $this->input->post('first_name');
				$datas['last_name'] = $this->input->post('last_name');

                $datas['company_id'] = $this->input->post('company_id');

				$datas['mobile_number'] = $this->input->post('mobile_number');
				$datas['address'] = $this->input->post('address');

				$datas['password'] = md5($this->input->post('password')) ;
				$datas['original_password'] = $this->input->post('password');
				//$datas['DateOfBirth'] = $this->input->post('DateOfBirth');
				$datas['notes'] = $this->input->post('notes');

				$doctor_details_id = $this->admin_model->addNewDoctorDetails($datas);
			}

			$id = $this->session->userdata('id');
		
			$Notify['userId '] = $id;
			$Notify['user_action '] = "Admin Add new doctor name: ".$this->input->post('first_name')." ".$this->input->post('last_name');

			$notification = $this->admin_model->AddNotification($Notify);
			
			$Content = array();
			$this->load->library('event');
			$Content['heading'] = "Dear Dr ".$datas['username'].","; 
			$Content['secondHeading'] = "You have been added to the Visiopath LIMS, and can now receive and manage Cases via this system."; 
			$Content['thirdHeading'] = "Please find details below: "; 
			$Content['TextLineOne'] = "<strong>Link</strong>: ".base_url(); 
			$Content['TextLineTwo'] = "<strong>Email</strong>: ".$datas['email']; 
			$Content['TextLineThree'] = "<strong>Password</strong>: ".$datas['original_password']; 
			            
            $data['to'] = $datas['email'];
            $id = $this->session->userdata('id');
            $data['subject'] = 'Doctor added to Visiopath';
            $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
            $this->event->email($data);
			$this->message_model->AddNewMessageOutside($id,$doctor_details_id,$data['subject'],$data['body']);


			if($this->input->post('appview') == 'yes'){
				print json_encode($this->input->post());
				exit;
			}
			

			if($doctor_details_id != 'Fail'){
				redirect('admin/ShowAllDoctor'.'/?status=done');
			}else{
				redirect('admin/ShowAllDoctor'.'/?status=error');
			}

	}
	
	public function getSnomed()
	{
		header('content-type: text/json');
		$datas = $this->admin_model->getSnomedData($_GET['search']);
		$i = 0;
		foreach($datas as $data){
			$ars[$i]['text'] =  $data->type.$data->code." - ".$data->description;
			$ars[$i]['value'] =  $data->type.$data->code." - ".$data->description;
			$i++;
		}
		echo json_encode($ars);
		
	}

	public function AddNewTestType()
	{


			if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
			$datas = $this->input->post();
            $datas['company_id'] = $this->session->userdata('company_id');
			$form_Id = $this->admin_model->addNewTestType($datas);
			

			$id = $this->session->userdata('id');
		
			$Notify['userId '] = $id;
			$Notify['user_action '] = "Admin Add new Form: ".$this->input->post('TestTypeName');

			$notification = $this->admin_model->AddNotification($Notify);

			redirect('formbuild/EditForm/'.$form_Id);
			

	}
	
	public function AddNewAdmin()
	{

				
				if(empty($this->session->userdata('id'))){ redirect(base_url()); }
				if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
				 
				 $datas['username'] = $this->input->post('first_name').$this->input->post('last_name');
				$datas['roleId'] = '1';
				$datas['UserDetail_Id '] = '0';
				$datas['email'] = $this->input->post('email');
				$datas['first_name'] = $this->input->post('first_name');
				$datas['last_name'] = $this->input->post('last_name');

				$datas['company_id'] = $this->input->post('company_id');

				$datas['mobile_number'] = $this->input->post('mobile_number');
				$datas['address'] = $this->input->post('address');

				$datas['password'] = md5($this->input->post('password')) ;

				$datas['user_type'] = $this->input->post('user_type') ;
				
				$doctor_details_id = $this->admin_model->addNewDoctorDetails($datas);
			

			$id = $this->session->userdata('id');
		
			$Notify['userId '] = $id;
			$Notify['user_action '] = "Admin Add new Admin / DE name: ".$this->input->post('first_name')." ".$this->input->post('last_name');

			$notification = $this->admin_model->AddNotification($Notify);


			
			if($doctor_details_id != 'Fail'){
				redirect('admin/ShowAllAdminUser'.'/?status=done');
			}else{
				redirect('admin/ShowAllAdminUser'.'/?status=error');
			}

	}

	public function ViewAllReports()
	{
	
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$AllReports = $this->admin_model->GetAllReports();

		$SendData['jobDetails'] = $AllReports;

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;


		//$SendData['doctors'] = $this->admin_model->getAllDoctor();

	///	$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		//$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();
		$this->load->view('viewallreports',$SendData);
		

	}

	public function SearchUser()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$user_id = $this->session->userdata('id');
		
		$SendData['AllUser'] = $this->admin_model->SearchUser($user_id);

		$this->load->view('searchuser',$SendData);
	}

	public function ChangeUserPassword($id)
	{
		
		
		$SendData['user_id'] = $id;

		
		//$this->load->view('changePassword',$SendData);
		

	}

	public function changethisuserpassword($id)
	{
		
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$data['userid'] = $id;
		$data['password'] = $_POST['newpassword'];


		$patient_details = $this->admin_model->Selectuser($id);
		$patient_name    = $patient_details[0]->username;

		$changePassword = $this->admin_model->changethisuserpassword($data);

		$user_id = $this->session->userdata('id');
		
		$Notify['userId '] = $user_id;
		$Notify['user_action '] = "Admin change password for ".$patient_name;

		$notification = $this->admin_model->AddNotification($Notify);

		if($changePassword == "Done"){
			redirect('admin/SearchUser'.'/?status=done');
		}

	}

	public function Logs()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		if($this->session->userdata('user_type') == 1){ redirect(base_url());	}
		//$SendData['AllUser'] = $this->admin_model->getAllUsers();
		
		$CountLogs = $this->admin_model->CountAllLogs();

		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/Logs/';
		$config['total_rows'] = $CountLogs[0]->Total;
		$config['per_page'] = 100;
		$config['uri_segment'] = 3;

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$SendData['links'] = $this->pagination->create_links();

		$SendData['AllLogs'] = $this->admin_model->getAllLogs($config['per_page'],$page);

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		$this->load->view('logs',$SendData);

	}

	public function DeleteAdminFileById($id)
	{
		$role = $this->session->userdata('roleId');
		if($role != 1){
			redirect(base_url());
		}

		$responce = $this->admin_model->DeleteAdminFileById($id);

		return true;

	}

	public function EditJob($id)
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') == 3){ redirect(base_url());	}
		$SendData['TestDetails'] = $this->admin_model->getTestById($id);
		$SendData['doctors'] = $this->admin_model->getAllDoctor();
		$SendData['Assigndoctors'] = $this->admin_model->GetDoctorsByTestId($id);

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();
		$SendData['patient'] = $this->admin_model->GetPatientDetailsById($SendData['TestDetails'][0]->patient_id);
		$SendData['patient']->userDetails = $this->admin_model->GetPatientDetailsById($SendData['TestDetails'][0]->patient_id);
		$SendData['typeOfTest'] = $this->admin_model->getAllTypeOfTest();
		$SendData['multipleUploads'] = $this->admin_model->GetAttachUploads($id);

		$SendData['roleId'] = $this->session->userdata('roleId');
		
		$this->load->view('Editjob',$SendData);
		

	}

	public function EditJobDetailsByAdmin($id)
	{


		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') == 3){ redirect(base_url());	}
		
		$TestDetails = $this->admin_model->getTestById($id);
		
		$username = $_POST['Fname']." ".$_POST['Lname']; 
		$data['patient_name'] = $_POST['Fname'];
		$data['last_name'] = $_POST['Lname'];
		$data['nhs_number'] = $_POST['nhs_number'];

		$Ndob = $_POST['DOB'];

		$date = date_create($Ndob);
		$dob =  date_format($date,"Y/m/d");

			if ($dob != "") {
				if (strpos($dob, '-') !== false) {
					$dob = explode("-", $dob);
					$dob = $dob[0] . "-" . $dob[1] . "-" . $dob[2];
				} elseif (strpos($dob, '/') !== false) {
					$dob = explode("/", $dob);
					$dob = $dob[0] . "/" . $dob[1] . "/" . $dob[2];
				} else {
					$dob = $dob;
				}
			}
		
		$data['DateOfBirth'] = $dob;
		$data['address'] = $_POST['address']; 
		$data['address_two'] = $_POST['address_two']; 
		$data['gender'] = $_POST['gender'];
		$data['mobile_number'] = $_POST['mob_number'];
		$data['hospital_number'] = $_POST['Hnumber'];
		
		$pat_id = $_POST['patient_id']; 

		if($this->session->userdata('roleId') == 1){
		 	$this->admin_model->UpdatePatientDetails($data,$pat_id);
		}
		$data = array( );
		if($this->session->userdata('roleId') == 1){
		 	$data['hospital_id'] = $this->input->post('Rinstitute');
		 	$test_date = $this->input->post('test_date');

		 	$date = date_create($test_date);
			$test_date =  date_format($date,"Y/m/d");

			if ($test_date != "") {
				if (strpos($test_date, '-') !== false) {
					$test_date = explode("-", $test_date);
					$test_date = $test_date[0] . "-" . $test_date[1] . "-" . $test_date[2];
				} elseif (strpos($test_date, '/') !== false) {
					$test_date = explode("/", $test_date);
					$test_date = $test_date[0] . "/" . $test_date[1] . "/" . $test_date[2];
				} else {
					$test_date = $test_date;
				}
			}

			$data['test_date'] = $test_date;
			$data['Client_case_number'] = $this->input->post('Case_refrence_number');
			$data['urgent'] = $this->input->post('case_type');
			$data['visiopath_number'] = $this->input->post('visiopath_case_number');

			$VPexist = $this->admin_model->EditVisiopathnumber($this->input->post('visiopath_case_number'),$id);

			if(!empty($VPexist)){
				redirect(base_url().'admin/EditJob/'.$id.'?VPexist');
			}

			$doctor_id = $this->input->post('doctor_id');
			
			$data_test = $this->admin_model->getTestDetailsById($id);

			$Assigndoctors = $this->admin_model->GetDoctorsByTestId($id);

			if(empty($doctor_id)){

				$this->admin_model->UnassignTheJob($id);
			
			}else{
				foreach($doctor_id as $doctor){

				if(!in_array($doctor, array_column($Assigndoctors, 'doctor_id'))) { //search value in the array
                    $SendData['test_id'] = $id;
					$SendData['doctor_id'] = $doctor;
					$SendData['status'] = 0;

					$this->admin_model->AssignJobToMultipleDoctor($SendData);

					$user_id = $this->session->userdata('id');
		
					$Notify['userId '] = $user_id;
					$Notify['user_action '] = "Admin Assign doctor to Client case number: ".$data_test[0]->Client_case_number;

					$notification = $this->admin_model->AddNotification($Notify);
					
					$doctor_details = $this->doctor_model->GetDoctorDetails($doctor)[0];
					$hospital_details = $this->hospital_model->getHospitalById($data_test[0]->hospital_id)[0];
				
					$Content = array();
					$this->load->library('event');
					$Content['heading'] = "Dear Dr ".$doctor_details->doctor_name.","; 
					$Content['secondHeading'] = "A new case has been assigned to you."; 
					$Content['thirdHeading'] = "Please login and review case below: "; 
					$Content['TextLineOne'] = "<strong>Institute Name: </strong>".$hospital_details->hospital_name; 
					$Content['TextLineTwo'] = "<strong>Client case number: </strong>".$data_test[0]->Client_case_number; 
					$Content['TextLineThree'] = "<strong>Visiopath Number: </strong>".$data_test[0]->visiopath_number; 
					$Content['TextLineForth'] = "<a href='".base_url()."doctor/viewTestDetails/".$test_id."' >Click here to view case</a>"; 

		            $datas['to'] = $doctor_details->email;
		            
		           	$datas['subject'] = 'New Visiopath Case assigned';
		            $datas['body'] = $this->load->view('emails/generalEmail',$Content, true);
					$this->message_model->AddNewMessageOutside($user_id,$doctor_details->id,$datas['subject'],$datas['body']);
		            $this->event->email($datas);
                }else{
                	
					}
                }


                foreach($Assigndoctors as $key => $doc){ 
	                	$doc_id = $doc['doctor_id'];
	                	$test_id = $id;

	                	if(!in_array($doc_id, $doctor_id)) { 
	                		$this->admin_model->UnassignTheJobWithDoctor($test_id,$doc_id);

	                			
	                	}
	            }
                
			}

			$data['notes'] = $this->input->post('notes');


				if(!empty($_FILES['upload_file'])){ 

			 		$files = $_FILES['upload_file'];
			 		$i = 0;
			 		foreach($files as $file){ ;

			 			if(!empty($files['name'][$i])){
			 				$attach_file[] = "assets/uploads/".$files['name'][$i];
			 			
			 				$file_name = $files['name'][$i];
					        $file_tmp =  $files['tmp_name'][$i];

					        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
							//$allowed = array('jpg','png','gif','jpeg','bmp','svg','tif','psd','ai','JPEG','pdf');
							

							if(!empty($file_name)){
					        	move_uploaded_file($file_tmp,"assets/uploads/".$file_name);
					        }
							
					
			 			 }
			 		  $i++;
			 		}
			}else{
				$attach_file[] = "";
			}
		
			if(!empty($attach_file)){

				 		foreach($attach_file as $file){

				 			$Pdata['test_id '] = $id;
							$Pdata['upload_file'] = $file;
					
							if(!empty($file)){		
								$Upload_multiple_attach = $this->admin_model->Upload_multiple_attach_By_Admin($Pdata);
							}
				 		}
			}

			$data['pathologists_fee'] = $_POST['pathologists_fee'];

			$data['specimen_fee'] = $_POST['specimen_fee'];

		}
		$data['no_of_specimen'] = $this->input->post('no_of_specimen');
		$data['specimen_text'] = $this->input->post('specimen_text');
		$data['clinical_details'] = $this->input->post('clinical_details');
		$data['macroscopic_details'] = $this->input->post('macroscopic_details');
		$data['specimen'] = '5';
		$data['test_type_id'] = '5';

		$Responce = $this->admin_model->UpdateJobByTestId($data,$id);

		$Uid = $this->session->userdata('id');
				
		$Notify['userId '] = $Uid;
		$Notify['user_action '] = "Edit Job details for Client case number: ".$data['Client_case_number'];
				
		$notification = $this->admin_model->AddNotification($Notify);

		if($this->session->userdata('roleId') == 1){
			redirect('admin/EditJob/'.$id.'?Done');
		}else{
			redirect('uploadreport/EditReport/'.$id);
		}

	}

	public function ShowAllForms()  {

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		if($this->session->userdata('user_type') == 1){ redirect(base_url());	}

		$data['admins'] = $this->admin_model->getAllTypeOfTest();


		$this->load->view('admin/manageforms',$data);
	}

	public function Configuration() {

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		if($this->session->userdata('user_type') == 1){ redirect(base_url());	}
		
		$data['ConfigOptions'] = $this->admin_model->GetAllConfigOption();


		$this->load->view('admin/configuration',$data);
	}

	public function UpdateConfiguration() {

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$name = $this->input->get('name');
		$value =  $this->input->get('value');

		$updateConfiguration = $this->admin_model->UpdateConfiguration($name,$value);
		
	}

	public function UpdateConfigurationForm() {

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
			$data = $this->input->post();

			if(empty($data['name']['__auto__accept__jobs__'])){
				$data['name']['__auto__accept__jobs__'] = 0;
			}

			foreach($data['name'] as $key => $value){

				$id = $key;
				$datas['value'] = $value;

				$updateConfiguration = $this->admin_model->UpdateConfiguration($datas,$id);
			}


			redirect('admin/configuration?Done');
			
		
	}

	public function AllHospitalInvoiceexport()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

		$StartDate = $this->input->get('startdate');
		$EndDate = $this->input->get('enddate');

		if(empty($StartDate)){
			$StartDate = '';
		}

		if(empty($EndDate)){
			$EndDate = '';
		}

		$fields = array('inv.hospital_paid','td.Client_case_number','pd.patient_name','td.visiopath_number','hos.hospital_name','doc.doctor_name','td.specimen_fee','inv.invoice_date');
		$admins = $this->admin_model->getInvoiceForHospitalCSV($fields,$StartDate,$EndDate);
		foreach($fields as $field){ $fieldarr = explode(".",$field); $changedField[] = ucwords(str_replace("_"," ",$fieldarr[1])); }
		$data_field[0] = $changedField;
   		$array_data = json_decode(json_encode($admins), true);

   		foreach($array_data as $key => $data){
   			if($data['hospital_paid'] == 1){
   				$array_data[$key]['hospital_paid'] = 'Paid';


   			}else{
   				$array_data[$key]['hospital_paid'] = 'Pending';
   			}

   			$Idate = date_create($data['invoice_date']);
   			$Indate = date_format($Idate,'d-m-Y'); 

   			$array_data[$key]['invoice_date'] = $Indate;
   		}
		
		$datas = array_merge($data_field,$array_data);

		
		$this->admin_model->array_to_csv_download($datas,"AllHospitalInvoice.csv",",");
	}

	public function AllDoctorInvoiceexport()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

		$StartDate = $this->input->get('startdate');
		$EndDate = $this->input->get('enddate');

		if(empty($StartDate)){
			$StartDate = '';
		}

		if(empty($EndDate)){
			$EndDate = '';
		}

		$fields = array('inv.doctor_paid','td.Client_case_number','pd.patient_name','td.visiopath_number','hos.hospital_name','doc.doctor_name','td.pathologists_fee','inv.invoice_date');
		$admins = $this->admin_model->getAllInvoiceDetailsForDoctorCSV($fields,$StartDate,$EndDate);
		foreach($fields as $field){ $fieldarr = explode(".",$field); $changedField[] = ucwords(str_replace("_"," ",$fieldarr[1])); }
		$data_field[0] = $changedField;
   		$array_data = json_decode(json_encode($admins), true);

   		foreach($array_data as $key => $data){
   			if($data['doctor_paid'] == 1){
   				$array_data[$key]['doctor_paid'] = 'Paid';


   			}else{
   				$array_data[$key]['doctor_paid'] = 'Pending';
   			}

   			$Idate = date_create($data['invoice_date']);
   			$Indate = date_format($Idate,'d-m-Y'); 

   			$array_data[$key]['invoice_date'] = $Indate;
   		}
		
		$datas = array_merge($data_field,$array_data);

		
		$this->admin_model->array_to_csv_download($datas,"AllDoctorInvoice.csv",",");
	}

	public function EditAdmin($id)
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

		$SendData['userDetails'] = $this->admin_model->Selectuser($id);

		$this->load->view('Editadmin',$SendData);

	}

	public function EditAdminDetails($id)
	{
		//$data = $this->input->post();

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}

		$userDetails = $this->admin_model->Selectuser($id);

		$PostedData['username'] = $this->input->post('first_name').' '.$this->input->post('last_name');
		$PostedData['first_name'] = $this->input->post('first_name');
		$PostedData['last_name'] = $this->input->post('last_name');
		$PostedData['email'] = $this->input->post('email');
		$PostedData['mobile_number'] = $this->input->post('mobile_number');

		if($userDetails[0]->mobile_number !=  $this->input->post('mobile_number')){ //if mobile number change user need to verify again
			$PostedData['mobile_verified'] = '0';
			$PostedData['codeviaSms'] = '0';
		}
		

		if(!empty($this->input->post('password'))){ //if password empty db password will not changed
			$PostedData['password'] = md5($this->input->post('password'));
		}

		$PostedData['address'] = $this->input->post('address');
		$PostedData['user_type'] = $this->input->post('user_type');


		$UpdateUser =  $this->user_model->UpdateUserByAdmin($PostedData,$id);

		$Uid = $this->session->userdata('id');
				
		$Notify['userId '] = $Uid; 
		$Notify['user_action '] = "Admin edit Admin/DE: ".$userDetails[0]->first_name.' '.$userDetails[0]->last_name."";
				
		$notification = $this->admin_model->AddNotification($Notify);

		
		redirect('admin/EditAdmin/'.$id.'?Done');



		
	}

    public function companysetting()
    {
        $id = $this->session->userdata('company_id');
        $Senddata['CompanyDetails'] = $this->admin_model->GetCompanyDetails($id);

        $this->load->view('admin/editcompany',$Senddata);

    }

    public function EditCompanyDetails()
    {

        $PostedData = $this->input->post();

        if(!empty($_FILES['company_logo']['name'])){

            $file_name = $_FILES['company_logo']['name'];
            $file_tmp =  $_FILES['company_logo']['tmp_name'];

            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed = array('jpg','png','gif','jpeg','bmp','svg','tif','JPEG','pdf');

            if( ! in_array( $ext, $allowed ) ) {
                $data['error'] = "yes";
                redirect(base_url().'admin/companysetting?FormatError');
            }else{
                if(!empty($file_name)){
                    $this->session->set_userdata('company_logo',$file_name);
                    $SaveData['company_logo'] = $file_name;

                    move_uploaded_file($file_tmp,"assets/uploads/".$file_name);
                }
            }
        }

        $company_id = $this->session->userdata('company_id');
        $table_name = 'company';
        $column_name = 'id';

        $SaveData['company_name'] = $PostedData['company_name'];
        $SaveData['company_slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $PostedData['company_name'])));
        $SaveData['company_email'] = $PostedData['company_email'];




       $response =  $this->admin_model->UpdateDetails($column_name,$company_id,$SaveData,$table_name);

       if($response == 'Done') {
            redirect(base_url('admin/companysetting?Success'));
       }else{
           redirect(base_url('admin/companysetting?fail'));
       }

    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */