<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');define('POUND',chr(163));

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

function MyTable($header = NULL, $data = NULL)
{
    // Header
    foreach($header as $col)
        $this->Cell(47.5,7,$col,1,'T');
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(45,7,$col,0,'T');
        $this->Ln();
    }
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

class doctor extends CI_Controller {

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
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}

		$doctor_id = $this->session->userdata('UserDetail_Id');

		//$SendData['doctors'] = $this->admin_model->getAllDoctor();

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		//$jobDetail = $this->doctor_model->getAllDoctorJobs($doctor_id);

		$jobDetails = $this->doctor_model->getAllDoctorJobsWithoutUrgent($doctor_id);

		$DoctorOverDues = $this->doctor_model->DoctorOverDues($doctor_id);

		//$OverduesMoreThenTwoweek = $this->doctor_model->GetDoctorOverduesMoreThenTwoweek($id);

		foreach($DoctorOverDues as $detail){
				$report_id = $detail->test_id;
				if(!empty($report_id)){
					$reportbyId = $this->admin_model->reportById($report_id);
				}

				
				if(!empty($reportbyId)){
					$detail->viewReport = "Enable";

					$id = $reportbyId[0]->authorised;

					if($id == 0){
						$detail->authorised = "not authorised";
					}else{
						$detail->authorised = "authorised";
					}
				}else{
					$detail->viewReport = "";
				}

				$detail->multipleUploads = $this->admin_model->GetAttachUploads($detail->test_id);
		
			}
		

		foreach($jobDetails as $detail){
				$report_id = $detail->test_id;

				if(!empty($report_id)){
					$reportbyId = $this->admin_model->reportById($report_id);
				}

			
				if(!empty($reportbyId)){
					$detail->viewReport = "Enable";

					$id = $reportbyId[0]->authorised;

					if($id == 0){
						$detail->authorised = "not authorised";
					}else{
							$detail->authorised = "authorised";
					}
				}else{
					$detail->viewReport = "";
				}

				$detail->multipleUploads = $this->admin_model->GetAttachUploads($detail->test_id);
		
			}

		$urgentDetails = $this->doctor_model->getAllUrgentDoctorJobs($doctor_id);

		foreach($urgentDetails as $detail){
				$report_id = $detail->test_id;
				if(!empty($report_id)){
					$reportbyId = $this->admin_model->reportById($report_id);
				}
				if(!empty($reportbyId)){

					$detail->viewReport = "Enable";

					$id = $reportbyId[0]->authorised;
					
					if($id == 0){
						$detail->authorised = "not authorised";
					}else{
						$detail->authorised = "authorised";
					}
				}else{
					$detail->viewReport = "";
				}



				$detail->multipleUploads = $this->admin_model->GetAttachUploads($detail->test_id);
			}
		
		$i = 0;
		/*foreach($jobDetails as $jobdetail){
			$awaitingReport = $this->doctor_model->AwaitingReport($doctor_id);

			$responce = $this->doctor_model->GetReportById($jobdetail->test_id);

			if(!empty($awaitingReport)){ 
				 $i++;
			}
		}

		$awaiting = $i;*/
		$awaiting = $this->doctor_model->AwaitingReportCount($doctor_id)[0]->counts;

		$j = 0;
		/*foreach($jobDetails as $jobdetail){ 
			$Overdue = $this->doctor_model->GetOverdues($doctor_id,$jobdetail->test_id);

			if(!empty($Overdue)){
				 $j++;
			}
		}

		$Overdues = $j;*/
		$Overdues = $this->doctor_model->GetOverduesCount($doctor_id)[0]->counts;

		$k = 0;
		/*foreach($jobDetails as $jobdetail){ 
			$Abovetheweek = $this->doctor_model->GetOverduesMoreThenweek($doctor_id,$jobdetail->test_id);

			if(!empty($Abovetheweek)){
				 $k++;
			}
		}*/
		$Abovetheweek = $this->doctor_model->GetOverduesMoreThenweekCount($doctor_id)[0]->counts;
		//$Abovetheweek = $k;

		$l = 0;
		/*foreach($jobDetails as $jobdetail){
			$Abovethetwoweek = $this->doctor_model->GetOverduesMoreThenTwoweek($doctor_id,$jobdetail->test_id);

			if(!empty($Abovethetwoweek)){
				 $l++;
			}
		}*/
		$TotalCompletedJob = $this->doctor_model->TotalCompletedJob($doctor_id);
		$TotalInCompletedJob = $this->doctor_model->TotalInCompletedJob($doctor_id);
		$TotalUrgentJob = $this->doctor_model->TotalUrgentJob($doctor_id);

		$Abovethetwoweek = $this->doctor_model->GetOverduesMoreThenTwoweekCount($doctor_id)[0]->counts;
		
		
		
		$AwaitingApprovalCount = $this->doctor_model->AwaitingApprovalCount($doctor_id)[0]->value;

		if(empty($awaiting)){ $awaiting = '0' ;}
 		if(empty($Overdues)){ $Overdues = '0' ;}
		if(empty($Abovetheweek)){ $Abovetheweek = '0' ;}
		if(empty($Abovethetwoweek)){ $Abovethetwoweek = '0' ;}

		

		$SendData['DoctorOverDues'] = $DoctorOverDues;
		$SendData['AwaitingApprovalCount'] = $AwaitingApprovalCount;

		$SendData['Overdues'] = $Overdues;
		$SendData['Abovetheweek'] = $Abovetheweek;
		$SendData['Abovethetwoweek'] = $Abovethetwoweek;

		$SendData['awaitingReport'] = $awaiting;

		$SendData['jobDetails'] = $jobDetails;
		$SendData['urgentDetails'] = $urgentDetails;

		$SendData['TotalCompletedJob'] = $TotalCompletedJob;
		$SendData['TotalInCompletedJob'] = $TotalInCompletedJob;
		$SendData['TotalUrgentJob'] = $TotalUrgentJob;

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['CompletedJob'] = $this->doctor_model->getCompletedJob($doctor_id);

		$SendData['autoAccept'] = $this->admin_model->GetConfigOption('','1','__auto__accept__jobs__')[0]->value;

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		$this->load->view('doctor/dashboard',$SendData);
	}


	public function viewInvoice(){
		return;
	}
	public function viewInvoicePDF($id){
        
     //  if(empty($this->session->userdata('id'))){ redirect(base_url()); }
	   $test_details = $this->admin_model->getTestDetailsById($id);
		
		/*if($this->session->userdata('roleId') != 1){ 
			if($this->session->userdata('UserDetail_Id') != $test_details[0]->doctor_id){ 
				redirect(base_url());	
			}

		}*/
	    //$test_details = $this->admin_model->getTestDetailsById($id);
		$SendData['patientDetails'] = $this->admin_model->getPatientById($test_details[0]->patient_id);
		$SendData['patientDetails'][0]->hospital_name = $this->hospital_model->getHospitalById($SendData['patientDetails'][0]->hospital_id)[0]->hospital_name;
		$SendData['test_details'] = $test_details;

		$SendData['test_details'][0]->testname = $this->admin_model->getTypeTestbyId($test_details[0]->specimen)[0]->TestTypeName;

		$SendData['DoctorDetails'] = $this->doctor_model->getDoctorDetailsById($test_details[0]->doctor_id);
		$SendData['hospitalDetails'] = $this->hospital_model->getHospitalById($test_details[0]->hospital_id);
		$SendData['invoiceTo'] = "Visiopath Ltd";
        $this->load->view('invoiceShow',$SendData);
    }

    public function AllDoctorInvoiceexport()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}

		$StartDate = $this->input->get('startdate');
		$EndDate = $this->input->get('enddate');

		if(empty($StartDate)){
			$StartDate = '';
		}

		if(empty($EndDate)){
			$EndDate = '';
		}

		$doctor_id = $this->session->userdata('UserDetail_Id');
		
		$fields = array('inv.doctor_paid','td.Client_case_number','pd.patient_name','td.visiopath_number','hos.hospital_name','doc.doctor_name','td.pathologists_fee','inv.invoice_date');
		$admins = $this->doctor_model->getAllInvoiceDetailsCSV($fields,$doctor_id,$StartDate,$EndDate);
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

		
		$this->admin_model->array_to_csv_download($datas,"AllInvocie.csv",",");
	}

	public function ViewAll()
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}


		
		
		$doctor_id = $this->session->userdata('UserDetail_Id');

		//$SendData['doctors'] = $this->admin_model->getAllDoctor();

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		//$jobDetail = $this->doctor_model->getAllDoctorJobs($doctor_id);

		$jobDetails = $this->doctor_model->getAllDoctorJobsWithoutUrgent($doctor_id);

		

		foreach($jobDetails as $detail){
				$report_id = $detail->test_id;
				if(!empty($report_id)){
					$reportbyId = $this->admin_model->reportById($report_id);
				}
				if(!empty($reportbyId)){
					$detail->viewReport = "Enable";

					$id = $reportbyId[0]->authorised;

					if($id == 0){
						$detail->authorised = "not authorised";
					}else{
							$detail->authorised = "authorised";
					}
				}else{
					$detail->viewReport = "";
				}


				$detail->multipleUploads = $this->admin_model->GetAttachUploads($detail->test_id);

				
			}

		$urgentDetails = $this->doctor_model->getAllUrgentDoctorJobs($doctor_id);

		foreach($urgentDetails as $detail){
				$report_id = $detail->test_id;
				if(!empty($report_id)){
					$reportbyId = $this->admin_model->reportById($report_id);
				}
				if(!empty($reportbyId)){

					$detail->viewReport = "Enable";

					$id = $reportbyId[0]->authorised;
					
					if($id == 0){
						$detail->authorised = "not authorised";
					}else{
						$detail->authorised = "authorised";
					}
				}else{
					$detail->viewReport = "";
				}

				
				$detail->multipleUploads = $this->admin_model->GetAttachUploads($detail->test_id);
				
			}
		
		$i = 0;
		
		$SendData['jobDetails'] = $jobDetails;
		$SendData['urgentDetails'] = $urgentDetails;
		
		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['CompletedJob'] = $this->doctor_model->getCompletedJob($doctor_id);

		$SendData['autoAccept'] = $this->admin_model->GetConfigOption('','1','__auto__accept__jobs__')[0]->value;

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;
		
		$this->load->view('doctor/ViewAllDoctor',$SendData);
	}

	public function SearchUser($id = NULL)
	{
		
		$roleID = $this->session->userdata('roleId');
		$UserDetail_Id = $this->session->userdata('UserDetail_Id');
		$Jobs = $this->doctor_model->getAllDoctorJobsForSearch($UserDetail_Id,$roleID);

		//echo $this->db->last_query();exit;

		foreach($Jobs as $detail){
				$report_id = $detail->test_id;
				if(!empty($report_id)){
					$reportbyId = $this->admin_model->reportById($report_id);
				}
				if(!empty($reportbyId)){

					$detail->viewReport = "Enable";

					$id = $reportbyId[0]->authorised;
					
					if($id == 0){
						$detail->authorised = "not authorised";
					}else{
						$detail->authorised = "authorised";
					}
				}else{
					$detail->viewReport = "";
				}
				
			}

			$SendData['Jobs'] = $Jobs;

			$this->load->view('doctor/searchUser',$SendData);


	}
	
	public function DoctorDetails($id)
	{
		


	   
		$doc_id = $id;
		$institute_id = $this->session->userdata('id');
		$role = $this->session->userdata('roleId');
		if(empty($institute_id)){
			redirect(base_url());
		}

		$doctor_id = $id;

		$SendData['DoctorDetails'] = $this->doctor_model->getDoctorDetailsById($doctor_id);
		
		if(empty($SendData['DoctorDetails'])) { redirect(base_url()); }
		
		/*if($role == 3){
			$hospital = $this->hospital_model->getHospitalByIdUser($this->session->userdata('id'));
			$user_detail_id = $hospital[0]->UserDetail_Id;
		}elseif($role == 2){
			$hospital = $this->doctor_model->getDoctorByIdUser($this->session->userdata('id'));
			$user_detail_id = $hospital[0]->UserDetail_Id;
		}
		
		*/
		
		$user_detail_id = $this->session->userdata('UserDetail_Id');
		
		$SendData['JobsDetails'] = $this->doctor_model->getDoctorJobsByDoctorId($id,$role,$user_detail_id);


		foreach($SendData['JobsDetails'] as $jobs){
			$hospitalsArr[] = $jobs->hospital_id;
		}
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		
		if($this->session->userdata('roleId') != 1){ 
			if($role == 2){
				if($this->session->userdata('id') != $SendData['DoctorDetails'][0]->id){redirect(base_url()); }
			}
			if($role == 3){
				if(empty($SendData['JobsDetails'])) { redirect(base_url()); }
				if(!in_array($this->session->userdata('UserDetail_Id'),$hospitalsArr)){ 
					redirect(base_url());	
				}
			}

		}

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		$this->load->view('doctor/doctordetails',$SendData);
	}

	
	

	public function GetInvoiceDownload($id)
	{


		
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',11);
		
		
				$jobDetails = $this->doctor_model->getInvoiceById($id);

				$doctors = $this->admin_model->getAllDoctor();
		
				$hospitals = $this->admin_model->getAllHospitals();

				$testTypes = $this->admin_model->getAllTypeOfTest();

				 

                   foreach($doctors as $doctor){ 
		                if($doctor->doctor_id == $jobDetails[0]->doctor_id){
		                    $doctor_name = $doctor->doctor_name;
		                }
		            }

		            foreach($testTypes as $test){ 
                        if($test->TestTypeId == $jobDetails[0]->specimen){
                            $test_name = $test->TestTypeName;
                        }
                    }

                    foreach($hospitals as $hospital){ 
                      if($hospital->hospital_id == $jobDetails[0]->hospital_id){
                           $hospital_name = $hospital->hospital_name;
                      }
                  }

           	
				$invoicedate = date_create($jobDetails[0]->invoice_date);
				$invoicedate = date_format($invoicedate,"d-m-Y");

				$testdate = date_create($jobDetails[0]->test_date);
				$testdate = date_format($testdate,"d-m-Y");
				//print_r($jobDetails);

				$header = array();

				$pdf->BasicTable($header);


				$header = array("Job no: ".$jobDetails[0]->Client_case_number,
				"Invoice Total: ".POUND.$jobDetails[0]->amount);

				$pdf->BasicTable($header);

				$header = array("Name of Doctor: ".$doctor_name,
				"Invoice date: ".$invoicedate);

				$pdf->BasicTable($header);

				$header = array("Address: ".$jobDetails[0]->address,
				"Gender: ".$jobDetails[0]->gender);

				$pdf->BasicTable($header);

				$header = array("Name of Patient: ".$jobDetails[0]->patient_name,
				"Invoice to: ".$hospital_name);

				$pdf->BasicTable($header);

				$header = array("Type of Test: ".$test_name,
				"Test Date: ".$testdate);

				$pdf->BasicTable($header);


				$header = array();

				$pdf->BasicTable($header);

		
				$pdf->Cell(0,1,"",0,1,'L',true);
				
				$pdf->SetFont('Times','',12);

				$header = array();

				$pdf->MyTable($header);

				$pdf->Cell(15,7,'QTY',1,'T');
				$pdf->Cell(97,7,'DESCRIPTION',1,'T');
				$pdf->Cell(32.5,7,'UNIT PRICE',1,'T');
				$pdf->Cell(45.5,7,'AMOUNT',1,'T');
				$pdf->ln();

		        //$header = array('QTY', 'DESCRIPTION', 'UNIT PRICE', 'AMOUNT');

				//$pdf->MyTable($header);

				$pdf->Cell(15,7,'1',1,'T');
				$pdf->Cell(97,7,$test_name,1,'T');
				$pdf->Cell(32.5,7,POUND.$jobDetails[0]->amount,1,'T');
				$pdf->Cell(45.5,7,POUND.$jobDetails[0]->amount,1,'T');
				$pdf->ln();

				$pdf->Cell(15,7,'',0,'T');
				$pdf->Cell(97,7,'',0,'T');
				$pdf->Cell(32.5,7,"Total",1,'T');
				$pdf->Cell(45.5,7,POUND.$jobDetails[0]->amount,1,'T');
				$pdf->ln();

				//$data = array('1', $test_name, " £ ".$jobDetails[0]->amount, " £ ".$jobDetails[0]->amount);

				//$pdf->MyTable($data);

				
		
		/*for($i=1;$i<=40;$i++)
			$pdf->Cell(0,10,'Printing line number '.$i,0,1);*/
		$pdf->Output();
		
				
	}

	public function archive()
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}

		
		

		$doctor_id = $this->session->userdata('UserDetail_Id');

		$SendData['jobDetails'] = $this->doctor_model->getAllArchiveJobs($doctor_id);

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;


		$this->load->view('doctor/archive',$SendData);
	}
	
	public function viewTestDetails($test_id)
	{
	
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }

		if($this->session->userdata('roleId') == 2){
			$role = 2;
			$connectionId = $this->session->userdata('UserDetail_Id');
		}else{
			$role = '';
		}
		
		$test_details = $this->admin_model->getTestDetailsById($test_id);
		$SendData['patientDetails'] = $this->admin_model->getPatientById($test_details[0]->patient_id);
		$SendData['patientDetails'][0]->hospital_name = $this->hospital_model->getHospitalById($SendData['patientDetails'][0]->hospital_id)[0]->hospital_name;
		$SendData['patientDetails'][0]->test_details = $this->admin_model->getTestDetailsByPatientId($test_details[0]->patient_id,$test_id,"unapprove",$role,$connectionId);
		$SendData['multipleUploads'] = $this->admin_model->GetAttachUploads($test_id);
		$SendData['autoAccept'] = $this->admin_model->GetConfigOption('','1','__auto__accept__jobs__')[0]->value;

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		if($this->session->userdata('roleId') == 2){ 

			if($test_details[0]->doctor_id != $this->session->userdata('UserDetail_Id')){
				//redirect(base_url());
			}
		}
		
		/*if(!empty($SendData['patientDetails'][0]->test_details)){
			$SendData['patientDetails'][0]->doctor_name = $this->doctor_model->GetDoctorDetails($SendData['patientDetails'][0]->test_details[0]->doctor_id)[0]->doctor_name;
		}else{
			$SendData['patientDetails'][0]->doctor_name = "Doctor not assigned";

		}*/
		
		$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
		$SendData['patientDetails'][0]->Client_case_number_barcode =  base64_encode($generator->getBarcode($SendData['patientDetails'][0]->test_details[0]->Client_case_number, $generator::TYPE_CODE_128));

		$SendData['patientDetails'][0]->visiopath_case_number_barcode =  base64_encode($generator->getBarcode($SendData['patientDetails'][0]->test_details[0]->visiopath_number, $generator::TYPE_CODE_128));
		
		$this->load->view('viewjob',$SendData);
	}

	public function AwaitingApproval()
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') == 1){ redirect(base_url());	}

		
		$doctor_id = $this->session->userdata('UserDetail_Id');


		$SendData['jobDetails'] = $this->doctor_model->AwaitingApprovalJobs($doctor_id);

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		
		$this->load->view('doctor/awaitingapproval',$SendData);
	
	}

	public function SetBoxReceived()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}

		$test_id = $this->input->get('test_id');
		$data_test = $this->admin_model->getTestDetailsById($test_id);
		$data['box_received'] = '1';
		
		$responce = $this->doctor_model->SetBoxReceived($data,$test_id);

		$data_test = $this->admin_model->getTestDetailsById($test_id);
		$Uid = $this->session->userdata('id');
				
		$Notify['userId '] = $Uid;
		$Notify['user_action '] = "Doctor received the slides for Client case number: ".$data_test[0]->Client_case_number;
				

		$notification = $this->admin_model->AddNotification($Notify);


			$Content = array();
			$this->load->library('event');
			
			$Content['heading'] = "Dear Admin,"; 
			$Content['secondHeading'] = "Doctor received the slides for case number: ".$data_test[0]->Client_case_number;
			$Content['thirdHeading'] = "Below are the details: "; 
			//$Content['TextLineOne'] = "<strong>Patient Name:</strong> ".$data_test[0]->patient_name;
			$Content['TextLineOne'] = "<strong>Client case number:</strong> ".$data_test[0]->Client_case_number;
			$Content['TextLineTwo'] = "<strong>Visiopath Number:</strong> ".$data_test[0]->visiopath_number;

			$data = array();
             $data['to'] = $hospital_details->email;
           
           	$data['subject'] = 'Doctor received the slides - Visiopath';
			//$this->load->view('emails/generalEmail',$Content);
          
		   $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
						
			$admins = $this->admin_model->getAllAdminUsers();
			$id = $this->session->userdata('id');
			foreach($admins as $admin){
				$adminEmails[] = $admin->email;
				$this->message_model->AddNewMessageOutside($id,$admin->id,$data['subject'],$data['body']);
			}
			$data['to'] = implode(",",$adminEmails);

			if($this->event->email($data)){		
				return true;
			}else{
				return false;
			}




		
	
	}
	
	public function ViewMyReport()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}
		
		$doctor_id = $this->session->userdata('UserDetail_Id');

		$SendData['jobDetails'] = $this->doctor_model->GetAllReports($doctor_id);

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;


		//$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$this->load->view('doctor/viewreport',$SendData);

	}
	

	public function ApproveJobByDoctor($id)
	{
		
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}

		$response = $this->doctor_model->ApproveJobByDoctor($id);
		$test_id = $id;
		$id = $this->session->userdata('id');
		$test_reports = $this->admin_model->getTestDetailsByPatientId('',$test_id);
		
		$patient_details = $this->admin_model->GetPatientDetailsById($test_reports[0]->patient_id);
		$patient_name =  $patient_details[0]->patient_name;

		$data_test = $this->admin_model->getTestDetailsById($test_id);
		$Data['userId '] = $id;
		$Data['user_action '] = "Doctor Approve the Job for Client case number".$data_test[0]->Client_case_number;

		$data = $this->admin_model->AddNotification($Data);
		
			
			$doctor_details = $this->doctor_model->GetDoctorDetails($test_reports[0]->doctor_id)[0];
			$hospital_details = $this->hospital_model->getHospitalById($test_reports[0]->hospital_id)[0];
		
		
		
			$Content = array();
			$this->load->library('event');
			$Content['heading'] = "Dear Admin,"; 
			$Content['secondHeading'] = "Doctor has accepted the job for Client case number: ".$test_reports[0]->Client_case_number; 
			$Content['thirdHeading'] = "Below are the details: "; 
			$Content['TextLineOne'] = "<strong>Institute Name:</strong> ".$hospital_details->hospital_name;
			$Content['TextLineTwo'] = "<strong>Doctor Name:</strong> ".$doctor_details->doctor_name;
			$Content['TextLineThree'] = "<strong>Visiopath Number:</strong> ".$test_reports[0]->visiopath_number;
			$data = array();
             $data['to'] = $hospital_details->email;
            $data['to'] = 'fahad.m.aslam@gmail.com';
            //$data['to'] = 'haseeb.idevation@gmail.com';
           	$data['subject'] = 'Doctor accepted the job - Visiopath';
            $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$admins = $this->admin_model->getAllAdminUsers();
			$id = $this->session->userdata('id');
			foreach($admins as $admin){
				$adminEmails[] = $admin->email;
				$this->message_model->AddNewMessageOutside($id,$admin->id,$data['subject'],$data['body']);
			}
			$data['to'] = implode(",",$adminEmails);
			
            if($this->event->email($data)){		
				redirect('uploadreport/EditReport/'.$test_id);
			}

			
		

	}

	public function ApproveJobByMultipleDoctor($id,$doctor_id)
	{
		
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}

		$response = $this->doctor_model->ApproveJobByMultipleDoctor($id,$doctor_id);
		$test_id = $id;
		$id = $this->session->userdata('id');
		$test_reports = $this->admin_model->getTestDetailsByPatientId('',$test_id);
		
		$patient_details = $this->admin_model->GetPatientDetailsById($test_reports[0]->patient_id);
		$patient_name =  $patient_details[0]->patient_name;

		$data_test = $this->admin_model->getTestDetailsById($test_id);
		$Data['userId '] = $id;
		$Data['user_action '] = "Doctor Approve the Job for Client case number: ".$data_test[0]->Client_case_number;

		$data = $this->admin_model->AddNotification($Data);
		
			
			$doctor_details = $this->doctor_model->GetDoctorDetails($test_reports[0]->doctor_id)[0];
			$hospital_details = $this->hospital_model->getHospitalById($test_reports[0]->hospital_id)[0];
		
		
		
			$Content = array();
			$this->load->library('event');
			$Content['heading'] = "Dear Admin,"; 
			$Content['secondHeading'] = "Doctor has accepted the job for Client case number: ".$test_reports[0]->Client_case_number; 
			$Content['thirdHeading'] = "Below are the details: "; 
			$Content['TextLineOne'] = "<strong>Institute Name:</strong> ".$hospital_details->hospital_name;
			$Content['TextLineTwo'] = "<strong>Doctor Name:</strong> ".$doctor_details->doctor_name;
			$Content['TextLineThree'] = "<strong>Visiopath Number:</strong> ".$test_reports[0]->visiopath_number;
			$data = array();
             $data['to'] = $hospital_details->email;
            $data['to'] = 'fahad.m.aslam@gmail.com';
            $data['to'] = 'haseeb.idevation@gmail.com';
           	$data['subject'] = 'Doctor accepted the job - Visiopath';
            $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$admins = $this->admin_model->getAllAdminUsers();
			$id = $this->session->userdata('id');
			foreach($admins as $admin){
				$adminEmails[] = $admin->email;
				$this->message_model->AddNewMessageOutside($id,$admin->id,$data['subject'],$data['body']);
			}
			$data['to'] = implode(",",$adminEmails);
			
            if($this->event->email($data)){		
				redirect('uploadreport/EditReport/'.$test_id);
			}

			
		

	}

	public function DeclineJobByDoctor($id)
	{
	
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}
		
		$test_id = $id;
		$id = $this->session->userdata('id');
		$data_test = $this->admin_model->getTestDetailsById($test_id);
		$response = $this->doctor_model->DeclineJobByDoctor($test_id);
		$patient_details = $this->admin_model->GetPatientDetailsById($data_test[0]->patient_id);
		$patient_name =  $patient_details[0]->patient_name;
		$Data['userId '] = $id;
		$Data['user_action '] = "Doctor Decline the job for <strong>Client case number:</strong> ".$data_test[0]->Client_case_number;

		$data = $this->admin_model->AddNotification($Data);
			
			
			
			$hospital_details = $this->hospital_model->getHospitalById($data_test[0]->hospital_id)[0];
			$doctor_details = $this->doctor_model->GetDoctorDetails($data_test[0]->doctor_id)[0];

			$Content = array();
			$this->load->library('event');
			
			$Content['heading'] = "Dear Admin,"; 
			$Content['secondHeading'] = "Doctor declined the below job, please contact the Doctor or assign a new Doctor."; 
			$Content['thirdHeading'] = "Below are the details: "; 
			$Content['TextLineOne'] = "<strong>Intitute Name:</strong> ".$hospital_details->hospital_name;
			$Content['TextLineTwo'] = "<strong>Doctor Name:</strong> ".$doctor_details->doctor_name;
			
			$Content['TextLineThree'] = "<strong>Client case number:</strong> ".$data_test[0]->Client_case_number."<br><strong>Visiopath Number:</strong> ".$data_test[0]->visiopath_number;

			$data = array();
             $data['to'] = $hospital_details->email;
            $data['to'] = 'fahad.m.aslam@gmail.com';
           	$data['subject'] = 'Doctor declined the job - Visiopath';
			//$this->load->view('emails/generalEmail',$Content);
          
		   $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
						
			$admins = $this->admin_model->getAllAdminUsers();
			$id = $this->session->userdata('id');
			foreach($admins as $admin){
				$adminEmails[] = $admin->email;
				$this->message_model->AddNewMessageOutside($id,$admin->id,$data['subject'],$data['body']);
			}
			$data['to'] = implode(",",$adminEmails);

			if($this->event->email($data)){		
				redirect('doctor/ViewAll');
			}
		
	}

	

	public function DeleteDoctorById($id)
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$doctorDetails = $this->doctor_model->GetDoctorDetails($id)[0];
		$doctorUser = $this->doctor_model->getDoctorUserById($doctorDetails->doctor_id)[0];

		$DeleteDoctor =  $this->doctor_model->DeleteDoctorById($id);
		$DeleteDoctorUser =  $this->doctor_model->DeleteDoctorUserById($doctorUser->id);

				$id = $this->session->userdata('id');
		
				$Notify['userId '] = $id;
				$Notify['user_action '] = "Admin removed doctor name ".$doctorDetails->doctor_name;
				$notification = $this->admin_model->AddNotification($Notify);
				redirect('admin/ShowAllDoctor?dataupdated');
		
	}

	public function Profile()
	{
		$this->load->view('setting');
	}

	public function Invoice()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}
		
		$doctor_id = $this->session->userdata('UserDetail_Id');

		$SendData['doctors'] = $this->admin_model->getAllDoctor();
		
		$SendData['hospitals'] = $this->admin_model->getAllHospitals();
		
		$SendData['jobDetails'] = $this->invoice_model->getAllPatientForInvoiceByDoctor($doctor_id);

		$this->load->view('doctor/invoice',$SendData);
	}

	public function AddtoArchive()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}
		
		$Post_id =  $this->input->get('Post_id');

		$doctor_id = $this->session->userdata('UserDetail_Id');

		$id = $this->session->userdata('id');
		
		$Data['userId '] = $id;
		$Data['user_action '] = "Doctor Archive the Job";

		$data = $this->admin_model->AddNotification($Data);
		
		$test_id = $this->admin_model->AddtoDoctorArchive($Post_id,'1');

		if($test_id != 'Fail'){
			echo "--Done--";
		}
			
	}

	public function AddtoUrgent()
	{
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$Post_id =  $this->input->get('Post_id');

		$id = $this->session->userdata('id');
		
		$Data['userId '] = $id;
		$Data['user_action '] = "Doctor Add Job to Urgent";

		$data = $this->admin_model->AddNotification($Data);

		$test_id = $this->doctor_model->AddtoUrgent($Post_id);

		if($test_id != 'Fail'){
			echo "--Done--";
		}	
	}

	public function RemovetoUrgent()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 1){ redirect(base_url());	}
		
		$Post_id =  $this->input->get('Post_id');

		$id = $this->session->userdata('id');
		
		$Data['userId '] = $id;
		$Data['user_action '] = "Doctor Remove Job from Urgent";

		$data = $this->admin_model->AddNotification($Data);
		
		$test_id = $this->doctor_model->RemovetoUrgent($Post_id);

		if($test_id != 'Fail'){
			echo "--Done--";
		}
			
	}

	public function RemoveFromArchive()
	{
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}
		
		$Post_id =  $this->input->get('Post_id');

		$id = $this->session->userdata('id');
		
		$Data['userId '] = $id;
		$Data['user_action '] = "Doctor Remove Job from Archive";

		$data = $this->admin_model->AddNotification($Data);
		
		$test_id = $this->admin_model->RemoveFromDoctorArchive($Post_id);

		if($test_id != 'Fail'){
			echo "--Done--";
		}
			
	}

	public function DoctorInvoice()
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}


		$StartDate = $this->input->get('startdate');
		$EndDate = $this->input->get('enddate');

		if(empty($StartDate)){
			$StartDate = '';
		}

		if(empty($EndDate)){
			$EndDate = '';
		}

		$doctor_id = $this->session->userdata('UserDetail_Id');

		$jobDetails = $this->invoice_model->getAllDoctorInvoice($doctor_id,$StartDate,$EndDate);

		

		$SendData['testTypes'] = $this->admin_model->getAllTypeOfTest();

		$SendData['TotalValue'] = $this->doctor_model->GetTotalValueOfInvocies($doctor_id,'','',$StartDate,$EndDate)[0]->total;
		
		$SendData['PaidValue'] = $this->doctor_model->GetTotalValueOfInvocies($doctor_id,'1','',$StartDate,$EndDate)[0]->total;
	
		$SendData['UnPaidValue'] = $this->doctor_model->GetTotalValueOfInvocies($doctor_id,'','1',$StartDate,$EndDate)[0]->total;

		//$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$SendData['jobDetails'] = $jobDetails;

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;


		
		$this->load->view('doctor/invoice',$SendData);
		

	}


	
	public function SendInvoice($id){
		
		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}
		$data['test_id'] = $id;
		$test_id = $id;
		$data['invoice_date'] = date("Y-m-d H:i:s");
		$data_get = $this->invoice_model->checkIfInvoiceAlreadyGenerated($id);
		
		if(!empty($data_get)){
			//$this->invoice_model->GenerateInvoice($data);

			$this->invoice_model->updateInvoice($id);
			$data_test = $this->admin_model->getTestDetailsById($id);
			

			$doctor_details = $this->doctor_model->GetDoctorDetails($data_test[0]->doctor_id)[0];
			$hospital_details = $this->hospital_model->getHospitalById($data_test[0]->hospital_id)[0];
			
			
			$id = $this->session->userdata('id');
			$Notify['userId '] = $id;
			$Notify['user_action '] = "Doctor has generated an Invoice for Client case number: ".$data_test[0]->Client_case_number;
	
			$notification = $this->admin_model->AddNotification($Notify);
			
			
			$Content = array();
			$this->load->library('event');
			$Content['heading'] = "Dear Admin,"; 
			$Content['secondHeading'] = $Notify['user_action ']; 
			$Content['thirdHeading'] = "Below are the details: "; 
			$Content['TextLineTwo'] = "<strong>Doctor Name:</strong> ".$doctor_details->doctor_name;
			$Content['TextLineOne'] = "<strong>Institute Name:</strong> ".$hospital_details->hospital_name;
			$Content['TextLineThree'] = "<strong>Visiopath Number:</strong> ".$data_test[0]->visiopath_number;
			
			$Content['TextLineForth'] = "<a href='".base_url()."doctor/viewInvoice/".$test_id."' >Click here to view Invoice</a>"; 
			
			$data = array();
            
           	$data['subject'] = 'Doctor sent invoice - Visiopath';
            $data['body'] = $this->load->view('emails/generalEmail',$Content, true);
			$admins = $this->admin_model->getAllAdminUsers();
			$id = $this->session->userdata('id');
			foreach($admins as $admin){
				$adminEmails[] = $admin->email;
				$this->message_model->AddNewMessageOutside($id,$admin->id,$data['subject'],$data['body']);
			}
			$data['to'] = implode(",",$adminEmails);
            
            if($this->event->email($data)){		
				redirect('doctor/DoctorInvoice/?invoicesent');
			}
			
		
		}else{
			redirect('doctor/DoctorInvoice/?invoicesent');
		}
		
		
	}

	public function AddErrorLog()
	{

		if(empty($this->session->userdata('id'))){ redirect(base_url()); }
		if($this->session->userdata('roleId') != 2){ redirect(base_url());	}
		
		$doctor_id = $this->session->userdata('UserDetail_Id');

		$SendData['test_id'] = $this->input->post('test_id');
		$SendData['userId'] = $this->input->post('userId');
		$SendData['title'] = $this->input->post('title');
		$SendData['Comments'] = $this->input->post('Comments');
		

		$data = $this->doctor_model->AddErrorLog($SendData);

		$data_test = $this->admin_model->getTestDetailsById($SendData['test_id']);
		$Uid = $this->session->userdata('id');
				
		$Notify['userId '] = $Uid;
		$Notify['user_action '] = "Doctor add Additional details for Client case number : ".$data_test[0]->Client_case_number;
	
		$notification = $this->admin_model->AddNotification($Notify);

			if(!empty($data)){ 
				$id = $SendData['test_id'];
				redirect('hospital/ViewReport/'.$id.'?Done');
			

		}


		
		
	}

	public function CompletedThisMonth()
	{
		$role = $this->session->userdata('roleId');
		if($role != 2){
			redirect(base_url());
		}
		$doctor_id = $this->session->userdata('UserDetail_Id');

		$jobDetails = $this->doctor_model->getCompletedJobsDetails($doctor_id);

		

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$SendData['jobDetails'] = $jobDetails;

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;
		
		$this->load->view('doctor/completedJob',$SendData);
	}


		
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */