<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include('lib/barcode/vendor/picqer/php-barcode-generator/src/BarcodeGenerator.php');
include('lib/barcode/vendor/picqer/php-barcode-generator/src/BarcodeGeneratorPNG.php');

class hospital extends CI_Controller {

	public function index()
	{

        if ($this->session->userdata('verify_by_code') != 'yes') {
            redirect(base_url());
        }
	

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 3){ redirect(base_url());	}
		
		
		$hospital_id = $this->session->userdata('UserDetail_Id');
		$hospital = $this->hospital_model->getHospitalByIdUser($hospital_id);
		$user_detail_id = $hospital[0]->UserDetail_Id;
		
		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();
		$SendData['TotalCases'] = $this->hospital_model->getAllhospitalsJobsCount($hospital_id)[0]->county;
		$SendData['CasesUnassigned'] = $this->hospital_model->getAllhospitalsJobsCount($hospital_id,"unassigned")[0]->county;
		$SendData['ReportsAvailable'] = $this->hospital_model->getAllhospitalsJobsCount($hospital_id,"reportsIn")[0]->county;
		
		/*$Urgents = $this->hospital_model->getAllUrgenthospitalsJobs($hospital_id);

		foreach($Urgents as $urgent){ 
				$report_id = $urgent->primary_id;
				$reportbyId = $this->admin_model->reportById($report_id);
				
				
				if(!empty($reportbyId)){
					$urgent->sentinvoice = "Enable";
				}else{
					$urgent->sentinvoice = "";
				}
			}
		$SendData['Urgent'] = $Urgents; */
		
		$jobDetails = $this->hospital_model->getAllhospitalsJobs($hospital_id);

		foreach($jobDetails as $detail){
				$detail->AssociateDoctors = $this->admin_model->GetDoctorsByTestId($detail->primary_id);
			}

		foreach($details as $detail){
				$report_id = $detail->test_id;
				$reportbyId = $this->admin_model->reportById($report_id);
				if(!empty($reportbyId)){
					$detail->sentinvoice = "Enable";
				}else{
					$detail->sentinvoice = "";
				}

				$detail->AssociateDoctors = $this->admin_model->GetDoctorsByTestId($detail->primary_id);
			}


		$SendData['jobDetails'] = $jobDetails; 
		
		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		
		$this->load->view('hospital/dashboard',$SendData);
	}

	public function PinVerification()
	{
		$this->load->view('hospital/pinverify');
	}

	public function PinVerificationLogin()
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 3){ redirect(base_url());	}

		if(empty($this->session->userdata('id'))){
			redirect(base_url());
		}


		$hospital_pin = $this->session->userdata('hospital_pincode');

		$first_number = $this->input->post('first_number');

		if($first_number['data'] != md5($first_number['value'])){
				redirect('hospital/PinVerification'."?pinNotMatch");
		}

		$second_number = $this->input->post('second_number');

		if($second_number['data'] != md5($second_number['value'])){
				redirect('hospital/PinVerification'."?pinNotMatch");
		}
		
		$third_number = $this->input->post('third_number');

		if($third_number['data'] != md5($third_number['value'])){
			redirect('hospital/PinVerification'."?pinNotMatch");
		}

        $this->session->set_userdata('verify_by_code','yes');

		redirect('hospital');
		
	
	}
	
	public function HospitalInvoice()
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 3){ redirect(base_url());	}
		if(empty($this->session->userdata('id'))){
			redirect(base_url());
		}

		$StartDate = $this->input->get('startdate');
		$EndDate = $this->input->get('enddate');

		if(empty($StartDate)){
			$StartDate = '';
		}

		if(empty($EndDate)){
			$EndDate = '';
		}
		
		
		$hospital_id = $this->session->userdata('UserDetail_Id');

		$jobDetails = $this->invoice_model->getAllHospitalInvoice($hospital_id,$StartDate,$EndDate);

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['TotalValue'] = $this->hospital_model->GetTotalValueOfInvocies($hospital_id,'','',$StartDate,$EndDate)[0]->total;

		$SendData['PaidValue'] = $this->hospital_model->GetTotalValueOfInvocies($hospital_id,'1','',$StartDate,$EndDate)[0]->total;

		$SendData['UnPaidValue'] = $this->hospital_model->GetTotalValueOfInvocies($hospital_id,'','1',$StartDate,$EndDate)[0]->total;

		//$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$SendData['jobDetails'] = $jobDetails;

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;
		
		$this->load->view('hospital/invoice',$SendData);

	}

	public function ViewAll()
	{

        if ($this->session->userdata('verify_by_code') != 'yes') {
            redirect(base_url());
        }

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 3){ redirect(base_url());	}

		$hospital_id = $this->session->userdata('UserDetail_Id');

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$jobDetails = $this->hospital_model->getAllhospitalsJobs($hospital_id);

		foreach($details as $detail){
				$report_id = $detail->test_id;
				$reportbyId = $this->admin_model->reportById($report_id);
				if(!empty($reportbyId)){
					$detail->sentinvoice = "Enable";
				}else{
					$detail->sentinvoice = "";
				}
			}

		$SendData['jobDetails'] = $jobDetails; 

		$Urgents = $this->hospital_model->getAllUrgenthospitalsJobs($hospital_id);

		foreach($Urgents as $urgent){
				$report_id = $urgent->primary_id;
				$reportbyId = $this->admin_model->reportById($report_id);
				if(!empty($reportbyId)){
					$urgent->sentinvoice = "Enable";
				}else{
					$urgent->sentinvoice = "";
				}
			}

		$SendData['Urgent'] = $Urgents; 

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		
		$this->load->view('hospital/ViewAllHospital',$SendData);
	}

	public function ViewMyReport()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 3){ redirect(base_url());	}
		if(empty($this->session->userdata('id'))){
			redirect(base_url());
		}

		$hospital_id = $this->session->userdata('UserDetail_Id');

		//$SendData['jobDetails'] = $this->hospital_model->getAllPatientReports($doctor_id);
		$SendData['jobDetails'] = $this->hospital_model->GetAllReports($hospital_id);

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		//$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$this->load->view('hospital/viewreport',$SendData);

	}

	public function ViewReport($id)
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		//if($this->session->userdata('roleId') != 3){ redirect(base_url());	}

		$hospital_id = $this->session->userdata('UserDetail_Id');

		//$SendData['hospitals'] = $this->admin_model->getAllHospitals();
		
		$jobDetails = $this->hospital_model->getPatientReportById($id);
		if(empty($jobDetails)){redirect(base_url());}
		
		$patient_details = $this->admin_model->getPatientById($jobDetails[0]->patient_id);
		
		$SendData['HospitalDetails'] = $this->hospital_model->getHospitalById($jobDetails[0]->hospital_id);
		
		$patient_name = $patient_details[0]->patient_name;

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['ReportDetails'] = $this->admin_model->GetReportNameByTestId($jobDetails[0]->test_primary_id);

		foreach($SendData['ReportDetails'] as $reportdetail){
			$SendData['GetReportFields'][$reportdetail->id] = $this->hospital_model->GetReportFields($reportdetail->test_type_id);
		}

		foreach($SendData['ReportDetails'] as $reportdetail){
			$SendData['GetReportValues'][$reportdetail->id] = $this->hospital_model->GetReportValues($reportdetail->test_id,$reportdetail->id);
		}

		//$SendData['GetReportFields'] = $this->hospital_model->GetReportFields($jobDetails[0]->test_type_id);
		//$SendData['GetReportValues'] = $this->hospital_model->GetReportValues($jobDetails[0]->test_primary_id);

		$SendData['getErrorReport'] = $this->admin_model->GetErrorByTestId($id);

		$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
		$jobDetails[0]->Client_case_number_barcode =  base64_encode($generator->getBarcode($jobDetails[0]->Client_case_number, $generator::TYPE_CODE_128));

		$jobDetails[0]->visiopath_case_number_barcode =  base64_encode($generator->getBarcode($jobDetails[0]->visiopath_number, $generator::TYPE_CODE_128));

		$SendData['jobDetails'] = $jobDetails;

		$SendData['multipleUploads'] = $this->doctor_model->getAllAttachFiles($id);

		$SendData['AssociateDoctors'] = $this->admin_model->GetDoctorsByTestId($id);

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		$id = $this->session->userdata('id');
		
		$Notify['userId '] = $id;
		$Notify['user_action '] = "User view ".$jobDetails[0]->Client_case_number." report";

		$notification = $this->admin_model->AddNotification($Notify);


		

		$this->load->view('hospital/reportdetails',$SendData);

		
	}
	
	public function ViewReportText($id)
	{
		$data = file_get_contents(base_url()."hospital/ViewReportPDF/$id/text");
		echo $data;
		
	}
	
	public function ViewReportWord($id)
	{
		$SendData['id'] = $id;
		$this->load->view('hospital/download_as_word',$SendData);
	}
	public function ViewReportPDF($id = NULL,$docview = NULL)
	{

		
	
		//if(empty($this->session->userdata('id'))){  redirect(base_url()); }
		
		$hospital_id = $this->session->userdata('UserDetail_Id');

		//$SendData['hospitals'] = $this->admin_model->getAllHospitals();
		
		$jobDetails = $this->hospital_model->getPatientReportById($id);
		$SendData['HospitalDetails'] = $this->hospital_model->getHospitalById($jobDetails[0]->hospital_id);
		$patient_details = $this->admin_model->getPatientById($jobDetails[0]->patient_id);
		$patient_name = $patient_details[0]->patient_name;
		
		$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
		$jobDetails[0]->Client_case_number_barcode =  base64_encode($generator->getBarcode($jobDetails[0]->Client_case_number, $generator::TYPE_CODE_128));

		$jobDetails[0]->visiopath_case_number_barcode =  base64_encode($generator->getBarcode($jobDetails[0]->visiopath_number, $generator::TYPE_CODE_128));
		

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['ReportDetails'] = $this->admin_model->GetReportNameByTestId($jobDetails[0]->test_primary_id);

		foreach($SendData['ReportDetails'] as $reportdetail){
			$SendData['GetReportFields'][$reportdetail->id] = $this->hospital_model->GetReportFields($reportdetail->test_type_id);
		}

		foreach($SendData['ReportDetails'] as $reportdetail){
			$SendData['GetReportValues'][$reportdetail->id] = $this->hospital_model->GetReportValues($reportdetail->test_id,$reportdetail->id);
		}

		$SendData['getErrorReport'] = $this->admin_model->GetErrorByTestId($id);

		$SendData['jobDetails'] = $jobDetails;

		$SendData['multipleUploads'] = $this->doctor_model->getAllAttachFiles($id);

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		$id = $this->session->userdata('id');
		
		$Notify['userId '] = $id;
		$Notify['user_action '] = "User view ".$jobDetails[0]->Client_case_number." report In PDF Format";

		$notification = $this->admin_model->AddNotification($Notify);
		
		if(isset($docview)){
			$SendData['DocView'] = true;
		}
		
		if(($docview == "text")){
			$str = $this->load->view('hospital/reportdetailstext',$SendData,true);
			$brRemover = array("<br>","<br />");
			$str = str_replace($brRemover,"\r\n",$str);
			header('Content-type: text/plain');
			$this->load->helper('download');
			$data = file_get_contents($name);
			header('Content-Disposition: attachment; filename="TextReport.txt"');
			echo $str;
		}else{
			$this->load->view('hospital/reportdetailspdf',$SendData);
		}
		
	}
	public function viewInvoice(){
		return ;
	}
	public function viewInvoicePDF($id){
        
        $test_details = $this->admin_model->getTestDetailsById($id);
		$SendData['patientDetails'] = $this->admin_model->getPatientById($test_details[0]->patient_id);
		$SendData['hospitalDetails'] = $this->hospital_model->getHospitalById($test_details[0]->hospital_id);
		$SendData['test_details'] = $test_details;

		$SendData['test_details'][0]->testname = $this->admin_model->getTypeTestbyId($test_details[0]->specimen)[0]->TestTypeName;

		$SendData['invoiceDetails'] = $this->doctor_model->getInvoiceByTestId($id);

		$SendData['DoctorDetails'] = $this->doctor_model->getDoctorDetailsById($test_details[0]->doctor_id);

		//$SendData['invoiceTo'] = $SendData['patientDetails'][0]->hospital_name;

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

        $this->load->view('hospital/invoiceShow',$SendData);
    }

	public function archive()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 3){ redirect(base_url());	}
		
		if(empty($this->session->userdata('id'))){
			redirect(base_url());
		}

		$SendData['jobDetails'] = $this->hospital_model->getAllArchiveJobs();

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		$this->load->view('hospital/archive',$SendData);
	}


	
	public function AddtoArchive()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 3){ redirect(base_url());	}
		
		if(empty($this->session->userdata('id'))){
			redirect(base_url());
		}

		$Post_id =  $this->input->get('Post_id');
		
		$test_id = $this->hospital_model->AddtoArchive($Post_id);



		if($test_id != 'Fail'){
			echo "--Done--";
		}
			
	}

	public function RemoveFromArchive()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 3){ redirect(base_url());	}
		$Post_id =  $this->input->get('Post_id');
		
		$test_id = $this->hospital_model->RemoveFromArchive($Post_id);

		if($test_id != 'Fail'){
			echo "--Done--";
		}
			
	}

	public function DeleteHospital($id)
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		$hospital_details = $this->hospital_model->getHospitalById($id)[0];
		$data['hospital'] = $this->hospital_model->getHospitalById($id)[0];
		$data['hospital_user'] = $this->hospital_model->getHospitalUserById($data['hospital']->hospital_id)[0];

		$DeleteHospital =  $this->hospital_model->DeleteHospitalById($id);

		if($DeleteHospital == 'Done'){
			$DeleteHospitalUser =  $this->hospital_model->DeleteHospitalUserById($data['hospital_user']->id);
			
			
			$id = $this->session->userdata('id');
		
			$Notify['userId '] = $id;
			$Notify['user_action '] = "Admin removed hospital name ".$hospital_details->hospital_name;

			$notification = $this->admin_model->AddNotification($Notify);
			if($DeleteHospitalUser != 'Fail'){
				redirect('admin/ShowAllHospitals?dataupdated');
			}
		}

			
	}

	public function HospitalDetails($id)
	{
	
		
		
		if(empty($this->session->userdata('id'))){
			redirect(base_url());
		}
		$role = $this->session->userdata('roleId');
		$Hospital_id = $id;

		$SendData['HospitalDetails'] = $this->hospital_model->getHospitalDetailsByHospitalId($Hospital_id);

		if($role == 3){
			$hospital = $this->hospital_model->getHospitalByIdUser($this->session->userdata('id'));
			$user_detail_id = $hospital[0]->UserDetail_Id;
		}elseif($role == 2){
			$hospital = $this->doctor_model->getDoctorByIdUser($this->session->userdata('id'));
			$user_detail_id = $hospital[0]->UserDetail_Id;
		}else{
			$user_detail_id = $Hospital_id;
		}
		
		
		
		
		
		$SendData['patientsDetails'] = $this->hospital_model->getHospitalPatientByHospitalId($Hospital_id,$role,$user_detail_id);

		$SendData['JobsDetails'] = $this->hospital_model->getHospitalJobsByHospitalId($Hospital_id,$role,$user_detail_id);

		
		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
			
			if($this->session->userdata('roleId') != 1){ 
					if(empty($SendData['patientsDetails'])) { redirect(base_url()); }
	
			}
	
		$this->load->view('hospital/hospitaldetails',$SendData);
	}

	public function AllHospitalInvoiceexport()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 3){ redirect(base_url());	}

		$StartDate = $this->input->get('startdate');
		$EndDate = $this->input->get('enddate');

		if(empty($StartDate)){
			$StartDate = '';
		}

		if(empty($EndDate)){
			$EndDate = '';
		}

		$hospital_id = $this->session->userdata('UserDetail_Id');
		
		$fields = array('inv.hospital_paid','td.Client_case_number','pd.patient_name','td.visiopath_number','hos.hospital_name','doc.doctor_name','td.specimen_fee','inv.invoice_date');
		$admins = $this->hospital_model->getAllInvoiceDetailsCSV($fields,$hospital_id,$StartDate,$EndDate);
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

		
		$this->admin_model->array_to_csv_download($datas,"AllInvocie.csv",",");
	}
		
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */