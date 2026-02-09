<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


include('lib/barcode/vendor/picqer/php-barcode-generator/src/BarcodeGenerator.php');
include('lib/barcode/vendor/picqer/php-barcode-generator/src/BarcodeGeneratorPNG.php');

require(dirname(__FILE__).'/../../lib/fpdf181/fpdf.php');
class PDF extends FPDF
{


function BasicTable($header = NULL, $data = NULL)
{
    // Header
    foreach($header as $col)
        $this->Cell(100,7,$col,0);
    $this->Ln();
    // Data
   
}


	// Page header
	function Header()
	{
		// Logo
		$this->Image('https://www.reviewschef.com/lims_system/assets/img/logo.png',10,16,60);
		// Arial bold 15
		$this->SetFont('Arial','B',10);
		// Move to the right
		$this->Cell(130);
		// Title
		$this->Cell(10,00,'PATHOGNOMICS',0,0,'C');
		$this->Ln(4);
		$this->Cell(127);
		$this->Cell(10,00,'HUNTINGDON',0,0,'C');
		$this->Ln(4);
		$this->Cell(131);
		$this->Cell(10,00,'CAMBRIDGESHIRE',0,0,'C');
		
		
		$this->Ln(10);
		$this->Cell(139);
		$this->Cell(10,00,'Email: info@videopath.co.uk',0,0,'C');
		$this->Ln(4);
		$this->Cell(133);
		$this->Cell(10,00,'Phone: 01480 453 437',0,0,'C');
		
		// Line break
		$this->Ln(5);
		$this->Cell(0,1,"",0,1,'L',true);
	}
	
	// Page footer
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}


class uploadreport extends CI_Controller {

	
	public function index()
	{
		$role = $this->session->userdata('roleId');
		if($role == 3){
			redirect(base_url());
		}
		$doctor_id = $this->session->userdata('UserDetail_Id');

		$jobDetails = $this->doctor_model->getDoctorJobs($doctor_id);

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		foreach($jobDetails as $job){ //print_r($job);
			$test_id = $job->test_id;

			$data = $this->doctor_model->getAlReadyReported($test_id);

			if(empty($data)){
				$newJob[] = $job;
			}

		}

		$SendData['jobDetails'] = $newJob;
		
		$this->load->view('doctor/uploadreport',$SendData);
	}


	public function AddPatientReport($id)
	{

		$role = $this->session->userdata('roleId');
		if($role == 3){
			redirect(base_url());
		}
		$patient_details = $this->admin_model->getPatientDetailsTestById($id);

		$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
		$patient_details[0]->Client_case_number_barcode =  base64_encode($generator->getBarcode($patient_details[0]->Client_case_number, $generator::TYPE_CODE_128));

		$patient_details[0]->visiopath_case_number_barcode =  base64_encode($generator->getBarcode($patient_details[0]->visiopath_number, $generator::TYPE_CODE_128));

		$SendData['testName'] = $this->admin_model->GetTestNameByTestId($patient_details[0]->specimen);

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['patient_details'] = $patient_details;


		$this->load->view('doctor/addReport',$SendData);
		
	}

	public function AddDetailReport()
	{
		$role = $this->session->userdata('roleId');
		if($role == 3){
			redirect(base_url());
		}

		$test_id = $this->input->post('test_id');

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
			$upload_file[] = "";
		}
		
		$data['test_id'] = $this->input->post('test_id'); 

		if(!empty($attach_file)){

			 		foreach($attach_file as $file){

			 			$Sdata['test_id '] = $this->input->post('test_id');
						$Sdata['upload_file'] = $file;
				
						
						$Upload_multiple_attach = $this->doctor_model->Upload_multiple_attach($Sdata);

			 		}
		}
		
		//$data['patient_id'] = $this->input->post('patient_id'); 
		$data['microscopy'] = $this->input->post('microscopy');
		
		$data['snomed'] = implode("|",$this->input->post('snomed'));

		if(!empty($this->input->post('publish'))){
			$data['authorised'] =  '1';
		}
		$data['update_time'] = date("Y-m-d");

		$data_test = $this->admin_model->getTestDetailsById($this->input->post('test_id'));
		
		$patient_details = $this->admin_model->getPatientById($data_test[0]->patient_id);
		$patient_name = $patient_details[0]->patient_name;



		$testreport_id = $this->admin_model->addPatientReport($data);

		
		$Uid = $this->session->userdata('id');
		
		$Notify['userId '] = $Uid;
		$Notify['user_action '] = "Doctor Upload report for Client case number: ".$data_test[0]->Client_case_number;;

		$notification = $this->admin_model->AddNotification($Notify);

		//$test_details = $this->admin_model->getTestDetailsById($data['test_id']);
		$test_reports = $this->admin_model->getTestDetailsByPatientId($patient_details[0]->patient_id,$data['test_id']);
		$doctor_details = $this->doctor_model->GetDoctorDetails($test_reports[0]->doctor_id)[0];
		$hospital_details = $this->hospital_model->getHospitalById($test_reports[0]->hospital_id)[0];
		if($test_reports[0]->authorised == 1){
			$Content = array();
			$this->load->library('event');
			
			$Content['heading'] = "Dear ".$hospital_details->hospital_name; ; 
			$Content['secondHeading'] = "Doctor has published a report for Visiopath case number: ".$test_reports[0]->Client_case_number."."; 
			$Content['thirdHeading'] = "<strong>Institute Name</strong> - ".$hospital_details->hospital_name; 
			$Content['TextLineOne'] = "<strong>Doctor Name:</strong> ".$doctor_details->doctor_name;
			
			$Content['TextLineTwo'] = "<strong>Visiopath Number:</strong> ".$test_reports[0]->Client_case_number;
			
			$Content['TextLineForth'] = "<a href='".base_url()."hospital/ViewReport/".$test_id."' >Click here to view case</a>"; 

			$hospital_details = $this->hospital_model->getHospitalById($patient_details[0]->hospital_id)[0];
			
			$data = array();
             $data['to'] = $hospital_details->email;
            $data['to'] = 'fahad.m.aslam@gmail.com';
           	$data['subject'] = 'Doctor has published a report - Visiopath';
			//$this->load->view('emails/generalEmail',$Content);
          
		   $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
            $this->event->email($data);
			
			$Uid = $this->session->userdata('id');
			$this->message_model->AddNewMessageOutside($Uid,$hospital_details->id,$data['subject'],$data['body']);
			
			$Content['heading'] = "Dear Admin,"; 
			$admins = $this->admin_model->getAllAdminUsers();
			foreach($admins as $admin){
				$adminEmails[] = $admin->email;
				$Uid = $this->session->userdata('id');
				$this->message_model->AddNewMessageOutside($Uid,$admin->id,$data['subject'],$data['body']);
			}
			$data['to'] = implode(",",$adminEmails);
			
			
			if($this->event->email($data)){		
				sleep(2);
			}
			$Content['heading'] = "Dear Insti,"; 
			
			
			
		}
		



		if(!empty($testreport_id)){
	 		redirect('doctor'); 
	 	}
  
	}

	public function Thankyou()
	{

		$this->load->view('doctor/thankyou');
	}


	public function AlreadySysponis()
	{
		$role = $this->session->userdata('roleId');
		if($role == 2){
			redirect(base_url());
		}
		$doctor_id = $this->session->userdata('UserDetail_Id');

		$jobDetails = $this->doctor_model->getAllReportedDoctorJobs($doctor_id);

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$SendData['jobDetails'] = $jobDetails;
		
		$this->load->view('doctor/alreadysysponis',$SendData);
	}


	public function GetForm($id)
	{
		$role = $this->session->userdata('roleId');
		if($role == 3){
			redirect(base_url());
		}

		

		$ReportDetails = $this->admin_model->GetReportNameById($id);


		$TestDetails = $this->admin_model->getTestDetailsById($ReportDetails[0]->test_id);
		

		$SendData['FieldDetails'] = $this->admin_model->GetFormByid($ReportDetails[0]->test_type_id);
		$SendData['FieldDetailsValues'] = $this->admin_model->GetFormValuesByid($ReportDetails[0]->test_id,$ReportDetails[0]->id);

		$SendData['ReportDetails'] = $ReportDetails;
		
		foreach($SendData['FieldDetailsValues'] as $FieldDetailsValue){
		$i = 0;
			foreach($SendData['FieldDetails'] as $FieldDetail){
				if($FieldDetail->field_id == $FieldDetailsValue->field_id){
					$SendData['FieldDetails'][$i]->values = $FieldDetailsValue->values;
					$SendData['FieldDetails'][$i]->other_text = $FieldDetailsValue->other_text;	
				}
				$i++;
			}
				
		}
		
		$this->load->view('doctor/trs',$SendData);
				
	}
	
	public function GetFormDownload($id)
	{
		$file = "https://www.reviewschef.com/lims_system/lib/html2pdf/example03.php";
		echo file_get_contents($file);
		//$this->load->view($file);
		

	}
	public function GetFormDownloads($id)
	{


		$TestDetails = $this->admin_model->getTestDetailsById($id);

		$SendData['FieldDetails'] = $this->admin_model->GetFormByid($ReportDetails[0]->test_type_id);
		$SendData['FieldDetailsValues'] = $this->admin_model->GetFormValuesByid($id);
		
		
		foreach($SendData['FieldDetailsValues'] as $FieldDetailsValue){
		$i = 0;
			foreach($SendData['FieldDetails'] as $FieldDetail){
				if($FieldDetail->field_id == $FieldDetailsValue->field_id){
					$SendData['FieldDetails'][$i]->values = $FieldDetailsValue->values;
					$SendData['FieldDetails'][$i]->other_text = $FieldDetailsValue->other_text;	
				}
				$i++;
			}
				
		}

		$FieldDetails = $SendData['FieldDetails'];
		
		
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',11);
		
		
				$jobDetails = $this->hospital_model->getPatientReportById($id);

				$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
				$Client_case_number_barcode =  base64_encode($generator->getBarcode($jobDetails[0]->Client_case_number, $generator::TYPE_CODE_128));

				$visiopath_case_number_barcode =  base64_encode($generator->getBarcode($jobDetails[0]->visiopath_number, $generator::TYPE_CODE_128));

				$DateOfBirth =date_create($jobDetails[0]->DateOfBirth);
				$DateOfBirth= date_format($DateOfBirth,"d-m-Y");

				$test_date =date_create($jobDetails[0]->test_date);
				$test_date= date_format($test_date,"d-m-Y");

				$update_time =date_create($jobDetails[0]->update_time);
				$update_time= date_format($update_time,"d-m-Y");

				
				$header = array("Patient Name: ".ucfirst($jobDetails[0]->patient_name),
				"Date Of Birth: ".$DateOfBirth);

				$pdf->BasicTable($header);

				$header = array("Address: ".$jobDetails[0]->address,
				"Gender: ".ucfirst($jobDetails[0]->gender));

				$pdf->BasicTable($header);

				$header = array("Snomed code: ".$jobDetails[0]->snomed_code,
				"Visiopath Number: ".$jobDetails[0]->visiopath_number);

				$pdf->BasicTable($header);

				$header = array("Date Assigned: ".$test_date,
				"Date Reported: ".$update_time);

				$pdf->BasicTable($header);

		
				$pdf->Cell(0,1,"",0,1,'L',true);

		        $header = array("Doctor Name: ".$jobDetails[0]->doctor_name,
				"Doctor Number: ".$jobDetails[0]->work_number);

				$pdf->BasicTable($header);

			$pdf->Cell(0,1,"",0,1,'L',true);
			
			$pdf->SetFont('Times','',12);
			foreach($FieldDetails as $field){
				if($field->is_heading == 1){
					$pdf->SetFont('Times','B',12);
					$pdf->Cell(00,10,$field->field_text,0,1);
				}else{
					$pdf->SetFont('Times','',11);
					$values = explode("$",$field->values);
					$fieldtext = str_replace("(check all that apply)","",$field->field_text);
					$pdf->Cell(0,10,$fieldtext.": ".implode(", ",$values),0,1);
				}
			}
		
		/*for($i=1;$i<=40;$i++)
			$pdf->Cell(0,10,'Printing line number '.$i,0,1);*/
		$pdf->Output();
				
	}

	public function GetFormValues($id)
	{	
		$role = $this->session->userdata('roleId');
		if($role == 3){
			redirect(base_url());
		}

		$ReportDetails = $this->admin_model->GetReportNameById($id);

		$report_id = $id;		

		$id = $ReportDetails[0]->test_id;

		$TestDetails = $this->admin_model->getTestDetailsById($ReportDetails[0]->test_id);
		
		$reportbyId = $this->admin_model->reportById($ReportDetails[0]->test_id);
		if(empty($reportbyId)){
			$data_test['test_id'] = $TestDetails[0]->test_id;
			//$data_test['patient_id'] = $TestDetails[0]->patient_id;
			$data_test['update_time'] = date("Y-m-d");
			$this->admin_model->insert_report($data_test);
		}

		$test_id =  $TestDetails[0]->test_id;

		$FieldDetails = $this->admin_model->GetFormPostByid($ReportDetails[0]->test_type_id);

		$values = $this->input->post();

		if($values['submit']){
			$values['type'] = "";
		}


		//print_r($FieldDetails);
		$i = 0;
		
		$this->db->where('report_id', $report_id);
		$this->db->where('test_id', $id);
		$this->db->delete('form_values');
		
		

 	foreach($FieldDetails as $data){

	 		$Posted_value = "";
	 		$insert[$i]['field_id'] = $data->field_id;
	 		//$insert[$i]['field_name'] = $data->field_name;
	 		$Posted_item = $this->input->post($data->field_name);
	 		if(is_array($Posted_item)){

	 			foreach($Posted_item as $item){
	 				$Posted_value .= $item."$";
	 			}

	 		}else{
	 			if($Posted_item == 'Select'){
	 				$Posted_value = '';
	 			}else{
	 				$Posted_value = $Posted_item;
	 			}

	 		}

     		$insert[$i]['values'] = $Posted_value;
	 		$insert[$i]['other_text'] = $this->input->post($data->field_name."_other");
	 		$insert[$i]['test_id'] = $id;
	 		$insert[$i]['report_id'] = $report_id;
	 		
	 		$i++;

 	}


 		$datas['report_name'] = $this->input->post('report_name');
	 	
	 	$this->db->set($datas);
		$this->db->where('id', $report_id);
		$this->db->update('reports');
 	
	 	foreach($insert as $dataValue){
		  $this->db->insert('form_values', $dataValue);
	 	}

	 	



	 	$id = $this->session->userdata('id');

	 	$patient_details = $this->admin_model->GetPatientDetailsById($test_id);
		$patient_name =  $patient_details[0]->patient_name;

		$data_test = $this->admin_model->getTestDetailsById($id);


			

		

		
		$Notify['userId '] = $id;
		$Notify['user_action '] = "Doctor upload sysponis for the Client case number ".$data_test[0]->Client_case_number;

		$notification = $this->admin_model->AddNotification($Notify);

		if($values['type'] == 'json'){

			$Notify['userId '] = $id;
		    $Notify['user_action '] = "Doctor upload sysponis for the Client case number ".$data_test[0]->Client_case_number;

			echo json_encode($data_test); 
			exit;
		}

	 	
	 	if($this->db->affected_rows()>0 )
		{
			redirect('uploadreport/EditReport/'.$test_id);
		}
			
 	}


 	public function EditReport($id)
	{
		$role = $this->session->userdata('roleId');
		if($role == 3){
			redirect(base_url());
		}

		$checkExisting = $this->admin_model->GetReportById($id);

		if(empty($checkExisting)){
			$datas['test_id'] = $id;
			$datas['update_time'] = date("Y-m-d");
			$this->db->insert('test_report',$datas);
		}





		$patient_details = $this->admin_model->getPatientDetailsTestById($id);

		$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
		$patient_details[0]->Client_case_number_barcode =  base64_encode($generator->getBarcode($patient_details[0]->Client_case_number, $generator::TYPE_CODE_128));

		$patient_details[0]->visiopath_case_number_barcode =  base64_encode($generator->getBarcode($patient_details[0]->visiopath_number, $generator::TYPE_CODE_128));

		$SendData['testName'] = $this->admin_model->GetTestNameByTestId($patient_details[0]->test_type_id);

		$SendData['getErrorReport'] = $this->admin_model->GetErrorByTestId($id);

		$SendData['patient_details'] = $patient_details;

		$SendData['ReportDetails'] = $this->admin_model->GetReportDetails($id);

		$SendData['getFormValues'] = $this->admin_model->getFormValuesByTestId($id);
		
		$SendData['Additionalreports'] = $this->admin_model->GetAdditionalreports($id);

		
		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['multipleUploads'] = $this->doctor_model->getAllAttachFiles($id);

		$SendData['doctor_details'] = $this->doctor_model->GetDoctorDetails($SendData['ReportDetails'][0]->doctor_id)[0];

		$SendData['RequestForm'] = $this->doctor_model->GetRequestForm($id);
		
		$SendData['AllReports'] = $this->admin_model->GetReportNameByTestId($id);

		$SendData['AssociateDoctors'] = $this->admin_model->GetDoctorsByTestId($id);

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		
		$this->load->view('doctor/EditReport',$SendData);
		
	}

	public function DeleteThisAttachment($id)
	{
		$role = $this->session->userdata('roleId');
		if($role != 2){
			redirect(base_url());
		}

		$responce = $this->doctor_model->DeleteThisAttachment($id);

		return true;

	}

	public function Autosave($id)
	{
		$data['test_id'] = $id;
		//$data['microscopy'] = trim($this->input->post('microscopy'));
		$data['microscopy'] = preg_replace('/<!--\[if gte mso 9\]>.*<!\[endif\]-->/s', '',  trim($this->input->post('microscopy')));

		//$pattern = "/p[^>]*><\\/p[^>]*>/"; 
		//$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";  

		//$data['microscopy'] = preg_replace($pattern, '', $data['microscopy']);

		//$data['microscopy'] = str_replace("<p","<span",$data['microscopy']);
		//$data['microscopy'] = str_replace("</p>","<br></span>",$data['microscopy']);
		$data['microscopy'] = str_replace("<o:p></o:p>","",$data['microscopy']);
		$data['microscopy'] = str_replace("</span>","",$data['microscopy']);
		$data['microscopy'] = str_replace("<span>","",$data['microscopy']);

		$data['conclusion'] = preg_replace('/<!--\[if gte mso 9\]>.*<!\[endif\]-->/s', '',  trim($this->input->post('conclusion')));

		//$pattern = "/p[^>]*><\\/p[^>]*>/"; 
		//$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";  

	//	$data['conclusion'] = preg_replace($pattern, '', $data['conclusion']);

		//$data['conclusion'] = str_replace("<p","<span",$data['conclusion']);
		//$data['conclusion'] = str_replace("</p>","<br></span>",$data['conclusion']);
		$data['conclusion'] = str_replace("<o:p></o:p>","",$data['conclusion']);

		$data['snomed'] = implode("|",$this->input->post('snomed'));

		$testreport_id = $this->admin_model->EditPatientReport($data);

		echo json_encode($testreport_id);

	}


	public function EditDetailReport($id)
	{
	
		$role = $this->session->userdata('roleId');
		if($role == 3){
			redirect(base_url());
		}

		
		
		
		if(!empty($_FILES['upload_file'])){ 

			 		$files = $_FILES['upload_file'];
			 		$i = 0;
			 		foreach($files as $file){ ;

			 			if(!empty($files['name'][$i])){ ;
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

			$data['test_id'] = $this->input->post('test_id');
		
			if(!empty($attach_file)){

				 		foreach($attach_file as $file){

				 			$Sdata['test_id '] = $data['test_id'];
							$Sdata['upload_file'] = $file;
							
							if(!empty($file)){
								$Upload_multiple_attach = $this->doctor_model->Upload_multiple_attach($Sdata);
							}

				 		}
			}



		$checkMicroscopy = strip_tags($this->input->post('microscopy'));



		$checkSnomed = $this->input->post('snomed');

		

		
		//$data['patient_id'] = $this->input->post('patient_id'); 
		//$data['conclusion'] = $this->input->post('conclusion');
		//$data['conclusion'] = preg_replace('/<!--\[if gte mso 9\]>.*<!\[endif\]-->/s', '',  trim($this->input->post('conclusion')));

		//$pattern = "/p[^>]*><\\/p[^>]*>/"; 
		//$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";  

	//	$data['conclusion'] = preg_replace($pattern, '', $data['conclusion']);

		//$data['conclusion'] = str_replace("<p","<br><span",$data['conclusion']);
		//$data['conclusion'] = str_replace("</p>","</span>",$data['conclusion']);
		//$data['conclusion'] = str_replace("<o:p></o:p>","",$data['conclusion']);
		//$data['conclusion'] = str_replace("<o:p>","",$data['conclusion']);
		//$data['conclusion'] = str_replace("</o:p>","",$data['conclusion']);

		//print_r($data['conclusion']);

		//$data['microscopy'] = preg_replace('/<!--\[if gte mso 9\]>.*<!\[endif\]-->/s', '',  trim($this->input->post('microscopy')));

		//$pattern = "/p[^>]*><\\/p[^>]*>/"; 
		//$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";  

		//$data['microscopy'] = preg_replace($pattern, '', $data['microscopy']);

		//$data['microscopy'] = str_replace("<p","<span",$data['microscopy']);
		//$data['microscopy'] = str_replace("</p>","<br></span>",$data['microscopy']);
		//$data['microscopy'] = str_replace("<o:p></o:p>","",$data['microscopy']);
		//$data['microscopy'] = str_replace("</span>","",$data['microscopy']);
		//$data['microscopy'] = str_replace("<span>","",$data['microscopy']);
		
		
		$data['snomed'] = implode("|",$this->input->post('snomed'));
		$data['update_time'] = date("Y-m-d h:i:s");

		$data['microscopy'] = trim($this->input->post('microscopy'));
		$data['conclusion'] = trim($this->input->post('conclusion'));

		
		/*echo $this->input->post('microscopy');
		echo "||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||";
		$data['microscopy'] = preg_replace('/<!--\[if gte mso 9\]>.*<!\[endif\]-->/s', '',  trim($this->input->post('microscopy')));

		//$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";
		//$data['microscopy'] = preg_replace($pattern, '', $data['microscopy']); 


		$data['microscopy'] = str_replace("<o:p></o:p>","",$data['microscopy']);
		$data['microscopy'] = str_replace("<o:p>","",$data['microscopy']);
		$data['microscopy'] = str_replace("</o:p>","",$data['microscopy']);
		$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";  

		 
		$data['microscopy'] = str_replace("<p","<span",$data['microscopy']);
		$data['microscopy'] = str_replace("</p>","<br></span>",$data['microscopy']);
		$data['microscopy'] = str_replace("<o:p></o:p>","",$data['microscopy']);
		$data['microscopy'] = str_replace("</span>","",$data['microscopy']);
		 $data['microscopy'] = str_replace("<span>","",$data['microscopy']);
		echo $data['microscopy'] = preg_replace($pattern, '', $data['microscopy']);
		

		$data['conclusion'] = preg_replace('/<!--\[if gte mso 9\]>.*<!\[endif\]-->/s', '',  trim($this->input->post('conclusion')));
		$data['conclusion'] = str_replace("<o:p></o:p>","",$data['conclusion']);
		$data['conclusion'] = str_replace("<o:p>","",$data['conclusion']);
		$data['conclusion'] = str_replace("</o:p>","",$data['conclusion']);*/

		//$data['conclusion'] = trim($this->input->post('conclusion'));

		//print_r($data['conclusion']);

		

		if(empty($checkMicroscopy)){
				redirect(base_url().'uploadreport/EditReport/'.$id."?microscopy");
		}
			
		if(empty($checkSnomed)){
				$this->session->set_flashdata('microscopy',$data['microscopy']); 
				redirect(base_url().'uploadreport/EditReport/'.$id."?snomed");
		}


		if(!empty($this->input->post('publish'))){
			$data['authorised'] = '1';

			$this->admin_model->UpdateTestDetailDoctor($this->session->userdata('UserDetail_Id'),$id);

			$Pdata['test_id'] = $id;
			$Pdata['invoice_date'] = date("Y-m-d H:i:s");
			$data_get = $this->invoice_model->checkIfInvoiceAlreadyGenerated($id);
			
			if(empty($data_get)){
				$this->invoice_model->GenerateInvoice($Pdata);
			}
		}
		

		$testreport_id = $this->admin_model->EditPatientReport($data);

		$id = $data['test_id'];

		$sid = $this->session->userdata('id');
		
		
		$test_details = $this->admin_model->GetPatientDetailsById($id);

		$patient_name = $test_details[0]->patient_name;
		
		
		
		
		
		$data_test = $this->admin_model->getTestDetailsById($id);
		$Notify['userId '] = $sid;
		$Notify['user_action '] = "Doctor Edit Synopsis for the Client case number: ".$data_test[0]->Client_case_number;;

		$notification = $this->admin_model->AddNotification($Notify);



		$test_reports = $this->admin_model->getTestDetailsByPatientId($test_details[0]->patient_id,$data['test_id']);
		$doctor_details = $this->doctor_model->GetDoctorDetails($test_reports[0]->doctor_id)[0];
		$hospital_details = $this->hospital_model->getHospitalById($test_reports[0]->hospital_id)[0];
		
		if($test_reports[0]->authorised == 1){
			$Content = array();
			$this->load->library('event');
			
			$Content['heading'] = "Dear Admin,"; 
			$Content['secondHeading'] = "Doctor has published a report for Visiopath case number: ".$test_reports[0]->Client_case_number; 
			$Content['thirdHeading'] = "<strong>Institute Name</strong> - ".$hospital_details->hospital_name; 
			$Content['TextLineOne'] = "<strong>Doctor Name:</strong> ".$doctor_details->doctor_name;
			
			$Content['TextLineTwo'] = "<strong>Visiopath Number:</strong> ".$test_reports[0]->Client_case_number;
			
			$Content['TextLineForth'] = "<a href='".base_url()."hospital/ViewReport/".$data['test_id']."' >Click here to view case</a>"; 

			
			$data = array();
             $data['to'] = $hospital_details->email;
            $data['to'] = 'fahad.m.aslam@gmail.com';
           	$data['subject'] = 'Doctor has published a report - Visiopath';
			//$this->load->view('emails/generalEmail',$Content);
          
		   $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
            $this->event->email($data);
			$Uid = $this->session->userdata('id');
			$this->message_model->AddNewMessageOutside($Uid,$hospital_details->id,$data['subject'],$data['body']);
			
			
			$admins = $this->admin_model->getAllAdminUsers();
			foreach($admins as $admin){
				$adminEmails[] = $admin->email;
				$Uid = $this->session->userdata('id');
				$this->message_model->AddNewMessageOutside($Uid,$admin->id,$data['subject'],$data['body']);

			}

			$this->message_model->AddNewMessageOutside($Uid,$Uid,$data['subject'],$data['body']);
			$data['to'] = implode(",",$adminEmails);

			//$data['to'] = $data['to'].",".$doctor_details->email;
			
			
			if($this->event->email($data)){		
				sleep(2);
			}


	}

		if(!empty($testreport_id)){

	 		redirect(base_url().'uploadreport/EditReport/'.$id); 
	 	}
		
	}

	public function AddAdditionalReport($id)
	{
		
		$role = $this->session->userdata('roleId');
		if($role == 3){
			redirect(base_url());
		}

		$data['test_id'] = $id;  
		$data['UserId'] = $this->session->userdata('id'); 
		$data['title'] = $this->input->post('title');

		$checkSnomed = $this->input->post('snomed');
		$sdata['snomed'] = implode("|",$this->input->post('snomed')); 

		if(empty($checkSnomed)){
				redirect(base_url().'uploadreport/EditReport/'.$id."?snomedempty");
		}

		$this->doctor_model->UpdateSnomed($sdata,$id);

		$data['comments'] = trim($this->input->post('comments'));

		/*$data['comments'] = preg_replace('/<!--\[if gte mso 9\]>.*<!\[endif\]-->/s', '',  trim($this->input->post('comments')));

		//$pattern = "/p[^>]*><\\/p[^>]*>/"; 
		$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";  

		$data['comments'] = preg_replace($pattern, '', $data['comments']);

		//$data['comments'] = str_replace("<p","<span",$data['comments']);
		//$data['comments'] = str_replace("</p>","<br></span>",$data['comments']);
		$data['comments'] = str_replace("<o:p></o:p>","",$data['comments']);
		$data['comments'] = str_replace("</span>","",$data['comments']);
		$data['comments'] = str_replace("<span>","",$data['comments']);*/

		if(!empty($this->input->post('publish'))){
			$data['comment_authorised'] = 1;
		}
		
		$responce = $this->admin_model->AddAdditionalReport($data);

		$sid = $this->session->userdata('id');

		$data_test = $this->admin_model->getTestDetailsById($id);
		$Notify['userId '] = $sid;
		$Notify['user_action '] = "Doctor Add Additional Report for Client case number: ".$data_test[0]->Client_case_number;;

		$notification = $this->admin_model->AddNotification($Notify);

		if($responce != 'Fail'){
			redirect(base_url().'uploadreport/EditReport/'.$id.'?Done');
		}

	}

	public function UpdateSpecimenGenerateForm($id)
	{
		
		$role = $this->session->userdata('roleId');
		if($role == 3){
			redirect(base_url());
		}

		$data['specimen'] = $this->input->post('specimen');
		$data['test_type_id'] = $this->input->post('specimen'); 
		
		$responce = $this->admin_model->UpdateSpecimenGenerateForm($data,$id);

		
		$dataValue['report_name'] = $this->input->post('report_name');
		$dataValue['test_type_id'] = $this->input->post('specimen');
		$dataValue['test_id'] = $id;

		 $this->db->insert('reports', $dataValue);
		 $id = $this->db->insert_id();

		redirect(base_url().'uploadreport/GetForm/'.$id);

	}

	public function DeleteSynopsisByReportId()
	{
		
		$role = $this->session->userdata('roleId');
		if($role != 2){
			redirect(base_url());
		}

		$GetData =  $this->input->get('ids');
		$GetDataArr = explode("|",$GetData);

		$report_id =  $GetDataArr[0];
		$testnameId = $GetDataArr[1];

		
		$responce = $this->doctor_model->DeleteSynopsisByReportId($report_id);
		$responce = $this->doctor_model->DeleteReportNameByReportId($testnameId);

		
		if($responce == 'Done' )
            {
                return "Done";
            }
            else
            {
                return "Fail";
            }

	}
	

}


/* End of file uploadreport.php */
/* Location: ./application/controllers/uploadreport.php */