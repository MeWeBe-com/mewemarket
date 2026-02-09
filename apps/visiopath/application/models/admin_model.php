<?php

/**
 * Created by Haseeb IDEA.
 * Date: 19/05/2017
 * Time: 21:49
 */


class admin_model extends CI_Model
{

	
	
	
	
	
	 public function getAllErpUser()
    {

        $this->db->from('erp_users');
        $this->db->select('*');   
         $query = $this->db->get();

        return $query->result();    
     
    }
	
	
	
	public function getAllJobsDetails()
    {
       

        $query = $this->db->query("SELECT *,td.test_id as test_primary_id,td.patient_id as patient_primary_id FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id 
								   LEFT join `test_report` as tr
        						   on td.test_id = tr.test_id
								   where td.admin_archive = 0 And td.urgent = 0 And td.company_id = ".$this->session->userdata('company_id'));

        
        return $query->result();
     
    }

    public function getAllJobsForAdmin()
    {
       

        $query = $this->db->query("SELECT *,td.test_id as test_primary_id,td.patient_id as patient_primary_id FROM `test_details` as td
                                   Inner join `patient_details` as pd
                                   on pd.patient_id = td.patient_id 
                                   LEFT join `test_report` as tr
                                   on td.test_id = tr.test_id");

        
        return $query->result();
     
    }

    public function Upload_multiple_attach_By_Admin($data)
    {
        $this->db->reconnect();

        $this->db->insert("admin_uploads",$data);

        if($this->db->affected_rows()>0 )
            {
                return"Done";
            }
            else
            {
                return "Fail";
            }
    }

    public function DeleteAdminFileById($id)
    {

        $query = $this->db->query("DELETE FROM `admin_uploads` WHERE id = $id");

        
      if($this->db->affected_rows()>0 )
            {
                return "Done";
            }
            else
            {
                return "Fail";
            }
    }

    public function GetAttachUploads($id)
    {

        $this->db->reconnect();
      
        $this->db->from('admin_uploads');
        $this->db->select('*');   
        $this->db->where('test_id',$id);

        //SELECT count(*) FROM `test_details` where doctor_id = 1 and doctor_approval is null 

         $query = $this->db->get();

        return $query->result();    
     
    }
	
	
	
	public function GetOverduesMoreThenTwoweek()
	{
		$date = new DateTime(date("Y-m-d"));
		$date->modify('-14 day');
		$startDate = $date->format('Y-m-d');

		$Ndate = new DateTime(date("Y-m-d"));
		$Ndate->modify('-21 day');
		$EndDate = $Ndate->format('Y-m-d');

		 $query = $this->db->query("SELECT  td.*,pd.*,td.test_id as test_primary_id,td.patient_id as patient_primary_id FROM `test_details` as td
		 
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id 

                                    left join test_doctor_report as tdr 
                                    on tdr.test_id = td.test_id

									left join test_report as tr 
									on td.test_id = tr.test_id


									where tdr.status = 1 AND  tr.authorised is NULL AND td.admin_archive = 0 AND td.company_id = ".$this->session->userdata('company_id')." AND td.test_date < '$EndDate' GROUP BY td.test_id");

		return $query->result();
	}
	
    public function getAllUrgentJobsDetails()
    {

        $query = $this->db->query("SELECT *,td.test_id as test_primary_id,td.patient_id as patient_primary_id FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id 
								    left join test_report as tr 
									 on td.test_id = tr.test_id 
								   where td.admin_archive = 0 And td.urgent = 1 And td.company_id = ".$this->session->userdata('company_id'));

        return $query->result();
    }

    public function getAllArchiveJobs()
    {

        $query = $this->db->query("SELECT td.test_id,pd.patient_id,td.visiopath_number,td.hospital_id,td.Client_case_number,td.test_date,td.admin_archive,td.box_received,pd.patient_name,pd.last_name,tr.authorised FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id

                                   left join `test_report` as tr
                                   on tr.test_id = td.test_id

                                   where td.admin_archive = 1 and td.company_id =".$this->session->userdata('company_id'));
        
        return $query->result();
    }

    public function GetPatientDetailsById($id)
    {
        $query = $this->db->query("SELECT * FROM `patient_details` 
        						   where patient_id = $id");
        return $query->result();
    }

    public function GetPatientDetails($id)
    {
        $query = $this->db->query("SELECT * FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id 
        						   where td.patient_id = $id");

        return $query->result();
    }

    public function reported()
    {
       

        $query = $this->db->get('test_report');

        return $query->result();
     
    }

    public function reportById($id)
    {
       

        $query = $this->db->query("SELECT * FROM `test_report` where test_id = $id");

        
        return $query->result();
     
    }

    public function invoicealreadySend($id)
    {
        $query = $this->db->query("SELECT * FROM `invoice_details` where test_id = $id");

        return $query->result();
     
    }

    public function getAllPatient()
    {
		$this->db->from('patient_details');
		$this->db->select('*');
        $this->db->where("company_id", $this->session->userdata('company_id'));
		$this->db->order_by("patient_name", "asc");
		$query = $this->db->get(); 
	//echo 	$this->db->last_query();
		return $query->result();
		
		
        
        return $query->result();
     
    }

    public function getAllDoctor()
    {
        $this->db->select('doctors.*');
        $this->db->from('user');
        $this->db->join('doctors','doctors.doctor_id = user.UserDetail_Id');
        $this->db->where('user.company_id',$this->session->userdata('company_id'));

        $this->db->group_by('doctors.doctor_id');

        $query = $this->db->get();
        return $query->result();
    }

    public function getAllUsers()
    {

        $query = $this->db->get('user');
        return $query->result();
     
    }
	public function getAllAdminUsers()
    {
       
		$this->db->select('*');
        $this->db->from('user');
        $this->db->where('roleId', "1");
        $query = $this->db->get();
        return $query->result();
     
    }

    public function UnacceptedCases()
    {
       
		$this->db->select('count(*) as UnacceptedCases');
        $this->db->from('test_details as td');
        $this->db->join('test_doctor_report as tdr','tdr.test_id = td.test_id','left');
        $this->db->where('tdr.doctor_id IS NOT NULL', NULL, FALSE);
        $this->db->where('(tdr.status = 0 )');
        $this->db->where('td.admin_archive ', '0');
        $this->db->where('td.test_id NOT IN (select test_id from test_doctor_report where status = 1)',NULL,FALSE);
        $this->db->where('td.company_id',$this->session->userdata('company_id'));

        $this->db->group_by('tdr.test_id');

        $query = $this->db->get();

        return $query->num_rows();
     
    }

    public function ViewableReports()
    {
       
		$this->db->select('count(*) as ViewableReports');
        $this->db->from('test_report');
        $this->db->join('test_details', 'test_report.test_id = test_details.test_id');	
        $this->db->where('test_report.authorised', '1');
        $this->db->where('test_details.admin_archive', '0');
        $this->db->where('test_details.company_id',$this->session->userdata('company_id'));


        
        $query = $this->db->get();

       // echo $this->db->last_query();exit;

        return $query->result();
     
    }

    public function TotalArchived()
    {
       
		$this->db->select('count(*) as TotalArchived');
        $this->db->from('test_details');
        $this->db->where('admin_archive', '1');
        $this->db->where('company_id', $this->session->userdata('company_id'));

        
        $query = $this->db->get();

        return $query->result();
     
    }

     public function getTestDetailsById($id)
    {
       

       // $query = $this->db->get('test_details');
        
		$this->db->where('test_id', $id);
		$this->db->select('*');  
		$this->db->from('test_details'); 
		$this->db->join('patient_details', 'patient_details.patient_id = test_details.patient_id');	
        $query = $this->db->get(); 
		return $query->result();
     
    }

    public function getTestById($id)
    {
       

       // $query = $this->db->get('test_details');
        
		$this->db->where('test_id', $id);
		$this->db->select('*');  
		$this->db->from('test_details'); 
		$query = $this->db->get(); 
		return $query->result();
     
    }
	
	public function getTestDetailsByPatientId($id = NULL,$test_id = NULL,$unapprove = NULL,$role = NULL,$connectionId = NULL)
    {

		 if($role == 3){
	   		$this->db->where('test_details.hospital_id', $connectionId);
	  	 }
		 if($role == 2){
	   		$this->db->where('tdr.doctor_id', $connectionId);
	  	 }
		 
		 if(!empty($id)){
			$this->db->where('test_details.patient_id', $id);
		}
		/* if(empty($unapprove)){
			 $this->db->where('test_details.doctor_approval is not NULL');
		 }*/
		if(!empty($test_id)){
			$this->db->where('test_details.test_id', $test_id);
		}
		
	    $this->db->from('test_details');
		$this->db->select('test_details.*,doctors.doctor_name,type_of_test.TestTypeName,test_report.test_reportId,test_report.authorised,hospitals.hospital_name,hospitals.hospital_id');    
      	$this->db->limit(50);  
		$this->db->order_by("test_id", "desc");
        $this->db->join('test_doctor_report as tdr', 'tdr.test_id = test_details.test_id', 'left');

		$this->db->join('doctors', 'doctors.doctor_id = tdr.doctor_id', 'left');
		$this->db->join('hospitals', 'hospitals.hospital_id = test_details.hospital_id');
		$this->db->join('type_of_test', 'type_of_test.TestTypeId = test_details.specimen', 'left');
		$this->db->join('test_report', 'test_report.test_id = test_details.test_id', 'left');

		$query = $this->db->get(); 
	 	$this->db->last_query();
		return $query->result();
     
    }

    public function getPatientDetailsTestById($id)
    {

     	$this->db->where('test_details.test_id =', $id);
		$this->db->from('test_details');
		$this->db->select('*,patient_details.gender as patientGender');    
      	$this->db->join('patient_details', 'patient_details.patient_id = test_details.patient_id');
        $this->db->join('test_doctor_report as tdr', 'tdr.test_id = test_details.test_id');	
      	$this->db->join('doctors', 'doctors.doctor_id = tdr.doctor_id');	
      	$this->db->join('type_of_test', 'type_of_test.TestTypeId = test_details.specimen','left');


		$query = $this->db->get(); 
		return $query->result();

    }
	
	public function array_to_csv_download($array = NULL, $filename = "export.csv", $delimiter=";") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w'); 
    // loop over the input array
    foreach ($array as $line) { 
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter); 
    }
    // reset the file pointer to the start of the file
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}


    public function getPatientById($id)
    {
       // $query = $this->db->get('test_details');
        $query = $this->db->query("SELECT * FROM `patient_details` where patient_id = $id");
        return $query->result();
     
    }

    public function GetAllAdminDetails()
    {
       
       // $query = $this->db->get('test_details');
        $query = $this->db->query("SELECT * FROM `user` where roleId = 1 And company_id = ".$this->session->userdata('company_id'));
        return $query->result();
     
    }

	 public function GetAllAdminDetailsCsv($fields)
		{
		    $this->db->from('user');
			$this->db->select(implode(",",$fields));   
			$this->db->order_by("first_name", "asc");
			$this->db->where('roleId',1);
            $this->db->where('company_id',$this->session->userdata('company_id'));
			$query = $this->db->get(); 
			return $query->result();    
		}
		
		 public function getSnomedData($data)
		{
			$this->db->from('snomed');
			$this->db->select("*");   
			$this->db->where("Concat(`code`,' - ',description) like '%".$data."%'");
			$this->db->order_by('code', 'asc');
			//$this->db->or_where("code like '%".$data."%'");
			$this->db->limit(25); 
			$query = $this->db->get(); 
			return $query->result();    
		}
		
	public function getAllJobsDetailsCSV($fields)
    {
       		$this->db->from('test_details as td');
			$this->db->join('patient_details as pd', 'pd.patient_id = td.patient_id');
			$this->db->join('doctors as doc', 'doc.doctor_id = td.doctor_id');
			$this->db->join('hospitals as hos', 'hos.hospital_id = td.hospital_id');
			
			$this->db->select(implode(",",$fields));   
			$this->db->order_by("td.test_id", "desc");
			$this->db->where('td.admin_archive',0);
			$query = $this->db->get(); 
			return $query->result(); 
     
    }

    public function GetAllDoctorsDetails()
    {

       // $query = $this->db->get('test_details');
        $query = $this->db->query("SELECT * FROM `doctors` as d inner join user as u on d.doctor_id =u.UserDetail_Id and u.roleId = 2 and u.company_id = ".$this->session->userdata('company_id'));

        return $query->result();
    }
	
	 public function GetAllDoctorsUploads($doctor_id)
    {
       // $query = $this->db->get('test_details');
        $query = $this->db->query("SELECT * FROM `doctor_uploads` where doctor_id =".$doctor_id);

        return $query->result();
    }
	
	
	public function GetAllDoctorsDetailsCSV($fields)
    {
       
			$this->db->from('doctors');
			$this->db->select(implode(",",$fields));   
			$this->db->order_by("doctors.doctor_name", "asc");
			$this->db->where('user.roleId',2);
			$this->db->join('user', 'user.UserDetail_Id = doctors.doctor_id');
			$query = $this->db->get();
			 
			return $query->result();
     
    }

    public function GetAllHospitalsDetailsCSV($fields)
    {
       


        	$this->db->from('hospitals');
			$this->db->select(implode(",",$fields));   
			$this->db->order_by("hospitals.hospital_name", "asc");
			$this->db->where('user.roleId',3);
			$this->db->join('user', 'user.UserDetail_Id = hospitals.hospital_id');
			$query = $this->db->get();
			 
			return $query->result();
     
    }
	 public function GetAllHospitalsDetails()
    {
       

       // $query = $this->db->get('test_details');
        $query = $this->db->query("SELECT * FROM `hospitals` as h inner join user as u on h.hospital_id =u.UserDetail_Id and u.roleId = 3 and u.company_id = ".$this->session->userdata('company_id'));

        return $query->result();
     
    }
	
	public function GetAllHospitalsNames()
    {
	    $this->db->from('hospitals');
		$this->db->select('hospital_name,hospital_id');   
		$this->db->order_by("hospital_name", "asc");
		$query = $this->db->get(); 
		return $query->result();     
    }


     public function getOtherUsers($id)
    {
       
       

        $query = $this->db->query("SELECT * FROM `user` where id != $id");

      
        return $query->result();
     
    }

     public function getUsersByfTypeId($id = NULL,$role = NULL,$userid = NULL)
    {
      
       if($role == 3){
			if($id == 2){
				$this->db->where('td.hospital_id', $userid);
				$this->db->where('us.roleId', "2");
				$this->db->select('doc.doctor_name as first_name,us.id');
				$this->db->join('patient_details as pd', ' pd.patient_id = td.patient_id');	
				$this->db->join('doctors  as doc', 'doc.doctor_id = td.doctor_id','left');	
				$this->db->join('user  as us', 'us.UserDetail_Id = doc.doctor_id','left');	
			    $this->db->from('test_details as td');
			    $this->db->group_by('id');
			   
			   $query = $this->db->get();
			   
				return $query->result();	 
			
			}elseif($id == 1){
				$query = $this->db->query("SELECT * FROM `user` where roleId = $id");
				return $query->result();
			}
	}elseif($role == 2){
		if($id == 3){
			$this->db->where('td.doctor_id', $userid);
			$this->db->where('us.roleId', "3");
			$this->db->from('test_details as td');
			$this->db->select('hos.hospital_name as first_name,us.id');
			$this->db->join('patient_details as pd', ' pd.patient_id = td.patient_id');	
			$this->db->join('hospitals  as hos', 'hos.hospital_id = td.hospital_id');	
			$this->db->join('user  as us', 'us.UserDetail_Id = hos.hospital_id');	
			
			$this->db->group_by('us.id');
		   $query = $this->db->get();
			return $query->result();	 
		
		}elseif($id == 1){
			$query = $this->db->query("SELECT * FROM `user` where roleId = $id");
			return $query->result();
		}
	}elseif($role == 1){
		if($id == 2){
			$this->db->where('us.roleId', $id);
			$this->db->select('us.id,doc.doctor_name as first_name');
			$this->db->join('user  as us', 'us.UserDetail_Id = doc.doctor_id','left');	
			$this->db->from('doctors as doc');
		   $query = $this->db->get();
			return $query->result();
		}elseif($id == 3){
			$this->db->where('us.roleId', $id);
			$this->db->select('us.id,hos.hospital_name as first_name');
			$this->db->join('user  as us', 'us.UserDetail_Id = hos.hospital_id','left');	
			$this->db->from('hospitals as hos');
		   $query = $this->db->get();
			return $query->result();
		}
			 
	}
        
      
        
     
    }

    public function getAllHospitals()
    {

        $this->db->select('hospitals.*');
        $this->db->from('user');
        $this->db->join('hospitals', 'user.UserDetail_Id = hospitals.hospital_id');
        $this->db->where('user.company_id', $this->session->userdata('company_id'));
        $this->db->group_by('hospitals.hospital_id');

        $query = $this->db->get();

        return $query->result();
     
    }

    public function getHospitalById($id)
    {

        $query = $this->db->query("SELECT hospital_name FROM `hospitals` where hospital_id = $id");

        return $query->result();
     
    }
	
	public function updateTestTypeById($data = NULL,$id = NULL)
    {
      
        $this->db->set($data);
		$this->db->where('TestTypeId', $id);
		$this->db->update('type_of_test');
	   
		return true;	 
     
    }
	

     public function getAllTypeOfTest()
    {
        $this->db->select('*');
        $this->db->from('type_of_test');
        $this->db->where('company_id',$this->session->userdata('company_id'));

        $query = $this->db->get();
        return $query->result();
    }
	
	 public function getTypeTestbyId($id)
    {
		$this->db->from('type_of_test');
		$this->db->where('TestTypeId',$id);
		$query = $this->db->get(); 
        return $query->result();
    }



 public function insert_report($id)
	{
		$this->db->reconnect();

		$this->db->insert("test_report",$id);

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}
    public function AddNewPatientDetails($data)
	{
		$this->db->reconnect();

		$this->db->insert("patient_details",$data);

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}

	public function UpdatePatientDetails($data = NULL,$id = NULL)
	{
		$this->db->reconnect();

		$this->db->set($data);
		$this->db->where('patient_id',$id);
		$this->db->update("patient_details");

		if($this->db->affected_rows()>0 )
			{
				return "Done";
			}
			else
			{
				return "Fail";
			}
	}


	public function AddNewJobDetails($data)
	{
		$this->db->reconnect();

		$this->db->insert("test_details",$data);

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}


	public function AddNotification($data)
	{
		$this->db->reconnect();
		$data['date'] = date("Y-m-d H:i:s");
        $data['company_id'] = $this->session->userdata('company_id');
		$this->db->insert("notifications",$data);

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}


	public function addPatientReport($data)
	{
		$this->db->reconnect();
	
		$this->db->insert("test_report",$data);

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}

	public function AssignDoctorToTest($doctor_id = NULL,$test_id = NULL)
	{
		$this->db->reconnect();

		$query = $this->db->query("UPDATE `test_details` SET `doctor_id`=$doctor_id WHERE test_id = $test_id");

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}

    public function AssignMultipleDoctorToTest($data)
    {
        $this->db->reconnect();
    
        $this->db->insert("test_doctor_report",$data);

        if($this->db->affected_rows()>0 )
            {
                return $this->db->insert_id();
            }
            else
            {
                return "Fail";
            }
    }
	
	public function assignGC($test_id = NULL,$gc)
	{
		$this->db->reconnect();

		$query = $this->db->query("UPDATE `test_details` SET `Client_case_number`='$gc' WHERE test_id = $test_id");

	}

	public function AddtoArchive($post_id)
	{
		$this->db->reconnect();

		$query = $this->db->query("UPDATE `test_details` SET `admin_archive`= 1 WHERE test_id = $post_id");

		if($this->db->affected_rows()>0 )
			{
				return "Done";
			}
			else
			{
				return "Fail";
			}
	}

	public function RemoveFromArchive($post_id)
	{
		$this->db->reconnect();

		$query = $this->db->query("UPDATE `test_details` SET `admin_archive`= 0 WHERE test_id = $post_id");

		if($this->db->affected_rows()>0 )
			{
				return "Done";
			}
			else
			{
				return "Fail";
			}
	}

	public function AddtoDoctorArchive($post_id = NULL,$doctor_id = NULL)
	{
		$this->db->reconnect();

		$query = $this->db->query("UPDATE `test_details` SET `doctor_archive`= $doctor_id WHERE test_id = $post_id");

		if($this->db->affected_rows()>0 )
			{
				return "Done";
			}
			else
			{
				return "Fail";
			}
	}

	public function RemoveFromDoctorArchive($post_id)
	{
		$this->db->reconnect();

		$query = $this->db->query("UPDATE `test_details` SET `doctor_archive`= 0 WHERE test_id = $post_id");

		if($this->db->affected_rows()>0 )
			{
				return "Done";
			}
			else
			{
				return "Fail";
			}
	}

	public function GetFormByid($id)
    {
       

        $query = $this->db->query("
			SELECT ff.*,tot.terms,tot.TestTypeName FROM `form_fields` as ff 
			inner join type_of_test as tot 
			on ff.test_type_id = tot.TestTypeId 
			where ff.test_type_id = $id
			order by ff.sorting_order
			");

        
        return $query->result();
     
    }

    public function GetFormPostByid($id)
    {
       

        $query = $this->db->query("SELECT * FROM `form_fields`  where test_type_id = $id And is_heading != 1");

        
        return $query->result();
     
    }
	
	 public function GetFormValuesByid($id = NULL,$report_id = NULL)
    {
       

        $query = $this->db->query("SELECT * FROM `form_values`  where test_id = $id And report_id = $report_id");

        
        return $query->result();
     
    }


    public function last_visio_num()
    {
       

        $query = $this->db->query("SELECT visiopath_number FROM `test_details` where company_id = ".$this->session->userdata('company_id')." order by test_id DESC limit 1 ");

        
        return $query->result();
     
    }

    public function VPexist($number)
    {
       

        $query = $this->db->query("SELECT * FROM `test_details` where visiopath_number = '$number' and company_id = ".$this->session->userdata('company_id')."");

        
        return $query->result();
     
    }

    public function EditVisiopathnumber($number = NULL ,$id = NULL)
    {
       

        $query = $this->db->query("SELECT * FROM `test_details` where visiopath_number = '$number' and test_id != $id and company_id = ".$this->session->userdata('company_id')."");

        
        return $query->result();
     
    }

    public function last_Snomed()
    {
       

        $query = $this->db->query("SELECT snomed_code FROM `test_details` order by patient_id DESC limit 1 ");

        
        return $query->result();
     
    }


    public function addNewDoctor($data)
	{
		$this->db->reconnect();

		$this->db->insert("doctors",$data);

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}

	public function addNewDoctorDetails($data)
	{
		$this->db->reconnect();

		$this->db->insert("user",$data);

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}
	
	
	
	public function deleteTestType($id)
	{
		$this->db->delete('type_of_test', array('TestTypeId' => $id)); 
		return true;
	}
	public function DeleteAdminUserById($UserDetail_Id)
	{
		$this->db->where('id', $UserDetail_Id);
		$this->db->delete('user');
	}
	public function addNewTestType($data)
	{
		$this->db->reconnect();

		$this->db->insert("type_of_test",$data);

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}


	 public function addNewHospital($data)
	{
		$this->db->reconnect();

		$this->db->insert("hospitals",$data);

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}

	public function addNewHospitalDetails($data)
	{
		$this->db->reconnect();

		 $this->db->insert("user",$data);

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}

	 public function GetAllReports()
    {

        $this->db->where('td.company_id',$this->session->userdata('company_id'));
		$this->db->where('tr.authorised', 1);
		$this->db->select('td.*,tot.TestTypeName,pd.patient_name,pd.DateOfBirth,pd.last_name,hos.hospital_name,pd.hospital_number,doc.doctor_name,tr.authorised');    
		$this->db->join('test_details as td', 'tr.test_id = td.test_id');
		$this->db->join('patient_details as pd', 'td.patient_id = pd.patient_id');
		$this->db->join('hospitals as hos', 'td.hospital_id = hos.hospital_id');
		$this->db->join('doctors as doc', 'td.doctor_id = doc.doctor_id');
		$this->db->join('type_of_test as tot', 'td.test_type_id = tot.TestTypeId');
		$this->db->from('test_report tr');


		$query = $this->db->get();

		return $query->result();

    }

    public function SearchUser($id)
    {
       

      //   $query = $this->db->query("SELECT * FROM `user`  where id != $id");
		
		 $this->db->where('user.id !=', $id);
		 $this->db->join('hospitals', 'user.UserDetail_Id = hospitals.hospital_id and user.roleId = 3',"left");	
		 $this->db->join('doctors', 'user.UserDetail_Id = doctors.doctor_id and user.roleId = 2',"left");	
		 $this->db->from('user');
	     $query = $this->db->get();
	   
		return $query->result();	
     
    }

    public function changethisuserpassword($data)
	{
		$this->db->reconnect();

		$query = $this->db->query("UPDATE `user` SET `original_password`= '".$data['password']."',`password`= '".md5($data['password'])."' WHERE id = ".$data['userid']."");

		if($this->db->affected_rows()>0 )
			{
				return "Done";
			}
			else
			{
				return "Fail";
			}
	}

	public function getAllLogs($limit,$start)
    {
	
		$this->db->select('notifications.*,user.email');    
       	$this->db->limit($limit, $start);  
		$this->db->order_by("id", "desc");
		$this->db->join('user', 'user.id = notifications.userId');
		$this->db->from('notifications');
        $this->db->where('notifications.company_id',$this->session->userdata('company_id'));

		$query = $this->db->get(); 
		return $query->result();

       // $query = $this->db->get('notifications');

        //return $query->result();
     
    }

    public function DoctorloggedInToday()
	{
		$this->db->reconnect();

		$Date = date("Y-m-d");

		$query = $this->db->query("SELECT count(*) as totalDoctor FROM `user` where cast(last_login as date) = '$Date' and roleId = 2 and company_id=".$this->session->userdata('company_id'));

		if($this->db->affected_rows()>0 )
			{
				return $query->result();
			}
			else
			{
				return "Fail";
			}
	}

	public function casesAuthorised()
	{
		$this->db->reconnect();

		$query = $this->db->query("SELECT count(*) as total  FROM `test_report` where authorised = 1 ");

		if($this->db->affected_rows()>0 )
			{
				return $query->result();
			}
			else
			{
				return "Fail";
			}
	}
	
		public function AcceptedCase()
	{
		$this->db->reconnect();

		$query = $this->db->query("SELECT count(*) as total  FROM `test_details` as td inner join `test_doctor_report` as tdr on tdr.test_id = td.test_id  left join `test_report` as tr on tr.test_id = td.test_id  where tdr.status = 1 And admin_archive=0 And tr.authorised is Null and td.company_id = '".$this->session->userdata('company_id')."' GROUP BY td.test_id ");

           return $query->num_rows();
			
			
	}

	public function urgent()
	{
		$this->db->reconnect();

		$query = $this->db->query("SELECT count(*) as total  FROM `test_details` where urgent = 1 and admin_archive=0 and company_id=".$this->session->userdata('company_id'));

		if($this->db->affected_rows()>0 )
			{
				return $query->result();
			}
			else
			{
				return "Fail";
			}
	}

	public function routineCases()
	{
		$this->db->reconnect();

		$query = $this->db->query("SELECT count(*) as total  FROM `test_details` where urgent = 0 and admin_archive=0 and company_id=".$this->session->userdata('company_id'));

		if($this->db->affected_rows()>0 )
			{
				return $query->result();
			}
			else
			{
				return "Fail";
			}
	}

	public function notallocated()
	{
		$this->db->reconnect();

		$query = $this->db->query("SELECT count(*) as total  FROM `test_details` where test_id NOT IN (select test_id from `test_doctor_report`)  and admin_archive=0 and company_id=".$this->session->userdata('company_id'));

		if($this->db->affected_rows()>0 )
			{
				return $query->result();
			}
			else
			{
				return "Fail";
			}
	}

	 public function GetReportDetails($id)
	{
		$this->db->reconnect();

		

		$query = $this->db->query("SELECT * FROM `test_details` as td
								 inner join test_report as tr 
								 on tr.test_id = td.test_id
								 where tr.test_id = $id");

		if($this->db->affected_rows()>0 )
			{
				return $query->result();
			}
			else
			{
				return "Fail";
			}
	}

	public function EditPatientReport($data)
	{
		$this->db->reconnect();

		$this->db->set($data);
		$this->db->where('test_id', $data['test_id']);
		$this->db->update('test_report');
		if($this->db->affected_rows()>0 )
			{
				return "Done";
			}
			else
			{
				return "Fail";
			}

	}

	public function GetErrorByTestId($id)
	{
		
        $this->db->from('error_log');
        $this->db->select('error_log.*,user.first_name,user.last_name');   
        $this->db->where('test_id',$id);
        $this->db->order_by("error_id", "desc");
        $this->db->join('user', 'user.id = error_log.userId');
            $query = $this->db->get(); 
            return $query->result(); 

	}

	public function GetDoctorDetailId($id)
	{
		$this->db->reconnect();

		$query = $this->db->query("SELECT id FROM `user`
								where UserDetail_Id = $id and roleId = 2");

		if($this->db->affected_rows()>0 )
			{
				return $query->result();
			}
			else
			{
				return "Fail";
			}

	}


	public function Selectuser($id)
	{
		$this->db->reconnect();

		$query = $this->db->query("SELECT * FROM `user`
								where id = $id ");

		if($this->db->affected_rows()>0 )
			{
				return $query->result();
			}
			else
			{
				return "Fail";
			}

	}

	public function AddAdditionalReport($data)
	{
		$this->db->reconnect();
		$data['date'] = date("Y-m-d H:i:s");
		 $this->db->insert("error_log",$data);

		if($this->db->affected_rows()>0 )
			{
				return 'Done';
			}
			else
			{
				return "Fail";
			}


	}

	 public function GetAdditionalreports($id)
		{
		   
		$this->db->from('error_log');
		$this->db->select('error_log.*,user.first_name,user.last_name');   
		$this->db->where('test_id',$id);
        $this->db->order_by("error_id", "desc");
		$this->db->join('user', 'user.id = error_log.userId');
			$query = $this->db->get(); 
			return $query->result();    
		
		 
		}

	public function getFormValuesByTestId($id)
		{
		   
		$this->db->from('form_values');
		$this->db->select('*');   
		$this->db->where('test_id',$id);
		$query = $this->db->get(); 
		return $query->result();    
		
		 
		}

    public function GetReportById($id)
        {
           
        $this->db->from('test_report');
        $this->db->select('*');   
        $this->db->where('test_id',$id);
        $query = $this->db->get(); 
        return $query->result();    
        
         
        }

	public function GetTestNameByTestId($id)
		{
		   
		$this->db->from('type_of_test');
		$this->db->select('TestTypeName');   
		$this->db->where('TestTypeId',$id);
		$query = $this->db->get(); 
		return $query->result();    
		
		 
		}

	public function UpdateJobByTestId($data = NULL,$id = NULL)
    {
      
        $this->db->set($data);
		$this->db->where('test_id', $id);
		$this->db->update('test_details');
	   
		if($this->db->affected_rows()>0 )
			{
				return 'Done';
			}
			else
			{
				return "Fail";
			}	 
     
    }

    public function UpdateSpecimenGenerateForm($data = NULL,$id = NULL)
    {
      
        $this->db->set($data);
		$this->db->where('test_id', $id);
		$this->db->update('test_details');
	   
		if($this->db->affected_rows()>0 )
			{
				return 'Done';
			}
			else
			{
				return "Fail";
			}	 
     
    }

    public function GetReportNameById($id)
        {
           
        $this->db->from('reports');
        $this->db->select('*');   
        $this->db->where('id',$id);
        $query = $this->db->get(); 
        return $query->result();    
        
         
        }

     public function GetReportNameByTestId($id)
        {
           
        $this->db->from('reports');
        $this->db->select('*,id as testnameId');   
        $this->db->where('test_id',$id);
        $query = $this->db->get(); 
        return $query->result();    
        
         
        }


    public function GetConfigOption($user_id = NULL,$role_id = NULL,$name = NULL)
    {
       if(!empty($user_id)){
        $this->db->where('parent_id', $user_id);
       }
       if(!empty($role_id)){
        $this->db->where('role', $role_id);
       }

       $this->db->where('name', $name);
       $this->db->from('config_options');
       $this->db->select('value');

       $query = $this->db->get();

      
       
    return $query->result();       
        
     
    }

    public function GetAllConfigOption()
    {
       $this->db->from('config_options');
       $this->db->select('*');

       $query = $this->db->get();

      
    return $query->result();       
        
     
    }

    public function UpdateConfiguration($data = NULL,$id = NULL)
    {


        $this->db->set($data);
        $this->db->where('name', $id);
        $this->db->update('config_options');
       
        if($this->db->affected_rows()>0 )
            {
                return 'Done';
            }
            else
            {
                return "Fail";
            }    
    }

    public function GetTotalValueOfHospitalInvocies($paid = Null,$unpaid = Null,$startDate = Null,$endDate = Null)
    {

        $this->db->reconnect();
      
        $this->db->from('test_details as td');
        $this->db->join('invoice_details as inv', 'inv.test_id = td.test_id');
        $this->db->where('td.admin_archive ', "!= 1");
        $this->db->where('td.company_id ', $this->session->userdata('company_id'));


        $this->db->select('sum(specimen_fee) as total,cast(inv.invoice_date as date)');   
        
        if(!empty($paid)){
            $this->db->where('inv.hospital_paid', '1');
        }

        if(!empty($unpaid)){
            $this->db->where('inv.hospital_paid', '0');
        }

        if(!empty($startDate) && !empty($endDate)){
            $this->db->where('inv.invoice_date between "'.$startDate.'" And "'.$endDate.'"');
        }
       
        //SELECT sum(*) FROM `test_details` where doctor_id = 1 and doctor_approval is null 

         $query = $this->db->get();

        return $query->result();    
     
    }

    public function GetTotalValueOfDoctorInvocies($paid = Null,$unpaid = Null,$startDate = Null,$endDate = Null)
    {

        $this->db->reconnect();
      
        $this->db->from('test_details as td');
        $this->db->join('invoice_details as inv', 'inv.test_id = td.test_id');
        $this->db->where('td.admin_archive ', "!= 1");
        $this->db->where('td.company_id ', $this->session->userdata('company_id'));


        $this->db->select('sum(pathologists_fee) as total,cast(inv.invoice_date as date)');

        $this->db->where('inv.doctor_sent', '1');   
        
        if(!empty($paid)){
            $this->db->where('inv.doctor_paid', '1');
        }

        if(!empty($unpaid)){
            $this->db->where('inv.doctor_paid', '0');
        }

        if(!empty($startDate) && !empty($endDate)){
            $this->db->where('inv.invoice_date between "'.$startDate.'" And "'.$endDate.'"');
        }
       
        //SELECT sum(*) FROM `test_details` where doctor_id = 1 and doctor_approval is null 

         $query = $this->db->get();
		 //echo $this->db->last_query();

        return $query->result();    
     
    }

    public function getInvoiceForHospitalCSV($fields = NULL,$startDate = Null,$endDate = Null)
    {
       
        
            $this->db->from('test_details as td');
            $this->db->join('patient_details as pd', 'pd.patient_id = td.patient_id');
            $this->db->join('doctors as doc', 'doc.doctor_id = td.doctor_id');
            $this->db->join('hospitals as hos', 'hos.hospital_id = td.hospital_id');
            $this->db->join('invoice_details as inv', 'inv.test_id = td.test_id');
            $this->db->join('test_report as tr', 'tr.test_id = td.test_id');
             $this->db->where('td.company_id ', $this->session->userdata('company_id'));
            
            $this->db->select(implode(",",$fields),'cast(inv.invoice_date as date)');   
            $this->db->order_by("td.test_id", "desc");
           
            $this->db->where('tr.authorised', 1);
            
             if(!empty($startDate) && !empty($endDate)){
                $this->db->where('inv.invoice_date between "'.$startDate.'" And "'.$endDate.'"');
            }

            $query = $this->db->get(); 
            return $query->result(); 
     
    }


      public function getAllInvoiceDetailsForDoctorCSV($fields = NULL,$startDate = Null,$endDate = Null)
    {
       
        
            $this->db->from('test_details as td');
            $this->db->join('patient_details as pd', 'pd.patient_id = td.patient_id');
            $this->db->join('doctors as doc', 'doc.doctor_id = td.doctor_id');
            $this->db->join('hospitals as hos', 'hos.hospital_id = td.hospital_id');
            $this->db->join('invoice_details as inv', 'inv.test_id = td.test_id');
            $this->db->join('test_report as tr', 'tr.test_id = td.test_id');
            
            $this->db->select(implode(",",$fields),'cast(inv.invoice_date as date)');   
            $this->db->order_by("td.test_id", "desc");
           
            $this->db->where('tr.authorised', 1);
            $this->db->where('inv.doctor_sent', 1);
        $this->db->where('td.company_id ', $this->session->userdata('company_id'));
            
             if(!empty($startDate) && !empty($endDate)){
                $this->db->where('inv.invoice_date between "'.$startDate.'" And "'.$endDate.'"');
            }

            $query = $this->db->get(); 
            return $query->result(); 
     
    }

     public function CountAllLogs()
    {

        $this->db->reconnect();
      
        $this->db->from('notifications');
        $this->db->select('count(*) as Total'); 
        $this->db->where('userid !=','0');
        $this->db->where('company_id',$this->session->userdata('company_id'));

        //SELECT count(*) FROM `test_details` where doctor_id = 1 and doctor_approval is null 

         $query = $this->db->get();

        return $query->result();    
     
    }

      public function GetDoctorsByTestId($test_id)
    {

        $this->db->reconnect();
      
        $this->db->from('test_doctor_report');
        $this->db->select('test_doctor_report.doctor_id,test_doctor_report.status,doctors.doctor_name');
        $this->db->join('doctors','doctors.doctor_id = test_doctor_report.doctor_id');

        $this->db->where('test_id',$test_id);   
        
        $query = $this->db->get();

        return $query->result_array();    
     
    }

    public function GetCountAllLogs() {
        return $this->db->count_all("notifications");
    }

    public function AssignJobToMultipleDoctor($data)
    {
        $this->db->reconnect();

        $this->db->insert("test_doctor_report",$data);

        if($this->db->affected_rows()>0 )
            {
                return"Done";
            }
            else
            {
                return "Fail";
            }
    }

    public function UnassignTheJob($id,$doctor_id)
    {
        $this->db->where('test_id', $id);
        $this->db->delete('test_doctor_report');

         if($this->db->affected_rows()>0 )
            {
                return"Done";
            }
            else
            {
                return "Fail";
            }
    
    }

    public function UnassignTheJobWithDoctor($id,$doctor_id)
    {
         $this->db->where('test_id', $id);
        $this->db->where('doctor_id', $doctor_id);
        $this->db->delete('test_doctor_report');
       
        

         if($this->db->affected_rows()>0 )
            {
                return"Done";
            }
            else
            {
                return "Fail";
            }
    
    }

    public function UpdateTestDetailDoctor($id = NULL,$test_id = NULL)
    {

      

        $this->db->set('doctor_id',$id);
         $this->db->set('doctor_approval','1');
        $this->db->where('test_id', $test_id);
        $this->db->update('test_details');
       
        if($this->db->affected_rows()>0 )
            {
                return 'Done';
            }
            else
            {
                return "Fail";
            }    
    }

    public function insertCompany($data)
    {
        $this->db->reconnect();

        $this->db->insert("company",$data);

        if($this->db->affected_rows()>0 )
        {
            return $this->db->insert_id();
        }
        else
        {
            return "Fail";
        }
    }

    public function insertCompanyAdmin($data)
    {
        $this->db->reconnect();

        $this->db->insert("user",$data);

        if($this->db->affected_rows()>0 )
        {
            return 'Done';
        }
        else
        {
            return "Fail";
        }
    }

    public function GetCompanyDetails($id)
    {

        $this->db->select('*');
        $this->db->from('company');
        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->result();

    }

    public function UpdateDetails($column_name = NULL,$id = NULL,$posteddata = NULL,$table_name = NULL)
    {

        $this->db->set($posteddata);
        $this->db->where($column_name, $id);
        $this->db->update($table_name);

        if($this->db->affected_rows()>0 )
        {
            return 'Done';
        }
        else
        {
            return "Fail";
        }
    }






}