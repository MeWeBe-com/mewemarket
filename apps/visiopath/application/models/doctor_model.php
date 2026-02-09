<?php

/**
 * Created by Haseeb IDEA.
 * Date: 19/05/2017
 * Time: 21:49
 */


class doctor_model extends CI_Model
{

	public function GetDoctorDetails($id)
    {

		$this->db->where('doctor_id', $id);
	   $this->db->from('doctors');
	   
	    $this->db->where('user.roleId', "2");
		
		$this->db->join('user', 'user.UserDetail_Id = doctors.doctor_id');	
	   $query = $this->db->get();
	   
		return $query->result();	
		
     
    }


	public function GetAllReports($id)
    {
       
        
		$this->db->where('tr.authorised', 1);
		$this->db->where('td.doctor_id', $id);
		$this->db->select('td.*,tot.TestTypeName,pd.patient_name,pd.last_name,pd.DateOfBirth,hos.hospital_name,pd.hospital_number,doc.doctor_name,tr.authorised');    
		$this->db->join('test_details as td', 'tr.test_id = td.test_id');
		$this->db->join('patient_details as pd', 'td.patient_id = pd.patient_id');
		$this->db->join('hospitals as hos', 'td.hospital_id = hos.hospital_id');
		$this->db->join('doctors as doc', 'td.doctor_id = doc.doctor_id');
		$this->db->join('type_of_test as tot', 'td.test_type_id = tot.TestTypeId');
		$this->db->from('test_report tr');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
    }
	
	public function DeleteDoctorById($UserDetail_Id)
    {
		$this->db->where('doctor_id', $UserDetail_Id);
		$this->db->delete('doctors');
	}

	public function DeleteDoctorUserById($UserDetail_Id)
    {
		$this->db->where('id', $UserDetail_Id);
		$this->db->delete('user');
	}


		public function getDoctorUserById($UserDetail_Id)
    {
      
        $this->db->where('roleId', 2);
		$this->db->where('UserDetail_Id', $UserDetail_Id);
	   $this->db->from('user');
	   $query = $this->db->get();
	   
		return $query->result();	 
     
    }

    public function getDoctorDetailsById($UserDetail_Id)
    {
      
        $this->db->where('roleId', '2');
       $this->db->where('doctor_id', $UserDetail_Id);
       $this->db->from('doctors');
       $this->db->join('user','doctors.doctor_id = user.UserDetail_Id');

       $query = $this->db->get();
       
        return $query->result();     
     
    }



	public function getDoctorByIdUser($id)
    {
      
        $this->db->where('id', $id);
		 $this->db->where('roleId', "2");
	   $this->db->from('user');
	   $query = $this->db->get();
	   
		return $query->result();	 
     
    }
   
	
	public function getDoctorJobsByDoctorId($UserDetail_Id = NULL,$role = NULL,$connectionId = NULL,$unapprove = NULL)
    {
      
       if($role == 3){
	   		$this->db->where('td.hospital_id', $connectionId);
	   }
	   if($role == 2){
	   		$this->db->having('primary_doctor', $connectionId);
	   }
	   if(empty($unapprove)){
			 $this->db->having('primary_status != ','0');
		}
		
	   $this->db->where('tdr.doctor_id', $UserDetail_Id);
	   $this->db->from('test_details  as td');
       $this->db->select('td.*,td.test_id as primary_id,pd.patient_id as patient_primary_id,pd.*,tr.authorised,tt.TestTypeName,hos.hospital_name,doc.doctor_name,tdr.doctor_id as primary_doctor,tdr.status as primary_status');
       $this->db->join('test_doctor_report as tdr','tdr.test_id = td.test_id','left');
       $this->db->join('test_report as tr','td.test_id = tr.test_id','left');
       $this->db->join('patient_details as pd','pd.patient_id = td.patient_id','left');
       $this->db->join('type_of_test as tt','td.specimen = tt.TestTypeId','left');
	   $this->db->join('hospitals as hos','hos.hospital_id = td.hospital_id');
	   $this->db->join('doctors as doc','doc.doctor_id= tdr.doctor_id');
		$this->db->order_by("td.test_id", "desc");
		
		
       $query = $this->db->get();
		//echo $this->db->last_query();
       
       
        return $query->result();     
     
    }
	
	public function updateDoctorById($data = NULL,$id = NULL)
    {
      
        $this->db->set($data);
		$this->db->where('doctor_id', $id);
		$this->db->update('doctors');
	   
		return true;	 
     
    }

    public function SetBoxReceived($data = NULL,$id = NULL)
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

 

	
	
    public function GetDoctorFiles($id)
    {

        $query = $this->db->query("SELECT * FROM `doctor_uploads` where doctor_id = $id");

        
        return $query->result();
     
    }

	public function getAllDoctorJobsWithoutUrgent($id)
    {

        $query = $this->db->query("SELECT *,tdr.status as primary_status,tdr.doctor_id as primary_doctor_id FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id

                        inner join `test_doctor_report` as tdr
                        on tdr.test_id = td.test_id

        						    where tdr.doctor_id = $id 
                        And td.doctor_archive != 1 And td.urgent = 0
								        order by td.doctor_approval
								   ");

        
        return $query->result();
     
    }


    public function getAllDoctorJobsForSearch($UserDetail_Id = NULL,$roleId = NULL)
    {


       
  	   if($roleId == 3){
	   		$this->db->where('td.hospital_id', $UserDetail_Id);
	   }
	   if($roleId == 2){
	   		$this->db->where('td.doctor_id', $UserDetail_Id);
	   }
	   $this->db->from('`test_details` as td');
       $this->db->select('td.*,pd.*,hos.hospital_name,doc.doctor_name');
       $this->db->join('patient_details as pd','pd.patient_id = td.patient_id','left');
	   $this->db->join('hospitals as hos','hos.hospital_id = td.hospital_id');
	   $this->db->join('doctors as doc','doc.doctor_id= td.doctor_id','left');
		$this->db->order_by("td.test_id", "desc");
		
		
       $query = $this->db->get();
		//echo $this->db->last_query();
       
       
        return $query->result();     
		
     
    }

	
	public function getAllDoctorJobs($id)
    {

        $query = $this->db->query("SELECT * FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id 
        						   where td.doctor_id = $id 
                                   And td.doctor_archive != 1 And td.urgent = 0 ");

        
        return $query->result();
     
    }

    public function getDoctorJobs($id)
    {

        $query = $this->db->query("SELECT * FROM `test_details` as td
                                   Inner join `patient_details` as pd
                                   on pd.patient_id = td.patient_id 
                                   where td.doctor_id = $id ");

        
        return $query->result();
     
    }

    public function getAllUrgentDoctorJobs($id)
    {

        $query = $this->db->query("SELECT *,tdr.status as primary_status,tdr.doctor_id as primary_doctor_id FROM `test_details` as td
                                   Inner join `patient_details` as pd
                                   on pd.patient_id = td.patient_id 

                                    inner join `test_doctor_report` as tdr
                                   on tdr.test_id = td.test_id

                                   where tdr.doctor_id = $id 
                                   And td.doctor_archive != 1 And td.urgent = 1
								   order by td.doctor_approval
								   ");

        
        return $query->result();
     
    }

    public function getAllRemainingDoctorJobs($id)
    {
       
        $query = $this->db->query("SELECT * FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id 
        						   INNER join `test_report` as tr
        						   on tr.test_id != td.test_id
        						   where td.doctor_id = $id And td.doctor_archive != 1");

        
        return $query->result();
     
    }

    public function getCompletedJob($id)
    {
       
        $query = $this->db->query("SELECT count(*) as completed FROM `test_report` as tr inner join test_details as td on td.test_id = tr.test_id where doctor_id = $id AND tr.authorised = 1 AND tr.update_time >= DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)");

        
        return $query->result();
     
    }

     public function getCompletedJobsDetails($id)
    {
       
        $query = $this->db->query("SELECT * FROM `test_report` as tr inner join test_details as td on td.test_id = tr.test_id inner join patient_details as pd on td.patient_id = pd.patient_id where doctor_id = $id AND tr.authorised = 1 AND tr.update_time >= DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)");


        

        
        return $query->result();
     
    }

    public function getAllReportedDoctorJobs($id)
    {
       
        $query = $this->db->query("SELECT * FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id 
        						   INNER join `test_report` as tr
        						   on tr.test_id = td.test_id
        						   where td.doctor_id = $id And td.doctor_archive != 1");

        
        return $query->result();
     
    }

     public function getAlReadyReported($id)
    {
       
        $query = $this->db->query("SELECT * FROM `test_report` as td
        						   where td.test_id = $id ");

        
        return $query->result();
     
    }

    public function AwaitingApprovalJobs($id)
    {
       
        $query = $this->db->query("SELECT * FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id



                                   where td.doctor_id = $id
        						   And td.doctor_approval IS NULL");

        
        return $query->result();
     
    }


    public function AwaitingReport($id)
    {

    	$startDate = date("Y-m-d");
		$date = new DateTime(date("Y-m-d"));
		$date->modify('-7 day');
		$tomorrowDATE = $date->format('Y-m-d');
       
        $query = $this->db->query("SELECT * FROM `test_details` as td inner join test_report as tr on td.test_id = tr.test_id where td.doctor_id = $id and td.doctor_approval = 1
        	and td.test_date between $tomorrowDATE and $startDate");

        
        return $query->result();
     
    }
	
	 public function AwaitingReportCount($id)
    {

    	$startDate = date("Y-m-d");
		$date = new DateTime(date("Y-m-d"));
		$date->modify('-7 day');
		$tomorrowDATE = $date->format('Y-m-d');
       
        $query = $this->db->query("SELECT count(*) as counts FROM `test_details` as td 
            inner join test_report as tr on td.test_id = tr.test_id

            left join test_doctor_report as tdr on tdr.test_id = td.test_id 

            where tdr.doctor_id = $id and tdr.status = 1 AND tr.authorised is NULL ");

        
        return $query->result();
     
    }

     public function GetReportById($test_id)
    {
       
        $query = $this->db->query("SELECT * FROM `test_report` where test_id = $test_id");
        
        return $query->result();
     
    }

     public function GetOverdues($id = NULL,$test_id = NULL)
    {
       
        
		$date = new DateTime(date("Y-m-d"));
		$date->modify('-7 day');
		$startDate = $date->format('Y-m-d');

		$Ndate = new DateTime(date("Y-m-d"));
		$Ndate->modify('-14 day');
		$EndDate = $Ndate->format('Y-m-d');



         $query = $this->db->query("SELECT * FROM `test_details` as td inner join test_report as tr on td.test_id = tr.test_id where td.doctor_id = $id and td.doctor_approval = 1 and tr.test_id = $test_id AND td.test_date Between $EndDate and $startDate");

        return $query->result();
     
    }
	
	 public function GetOverduesCount($id = NULL,$test_id = NULL)
    {
       
        
		$date = new DateTime(date("Y-m-d"));
		$date->modify('-7 day');
		$startDate = $date->format('Y-m-d');

		$Ndate = new DateTime(date("Y-m-d"));
		$Ndate->modify('-14 day');
		$EndDate = $Ndate->format('Y-m-d');



         $query = $this->db->query("SELECT count(*) as counts FROM `test_details` as td inner join test_report as tr on td.test_id = tr.test_id where td.doctor_id = $id and td.doctor_approval = 1 AND  tr.authorised is NULL AND  td.test_date Between $EndDate and $startDate");

        return $query->result();
     
    }

     public function GetOverduesMoreThenweek($id = NULL,$test_id = NULL)
    {

    	$date = new DateTime(date("Y-m-d"));
		$date->modify('-14 day');
		$startDate = $date->format('Y-m-d');

		$Ndate = new DateTime(date("Y-m-d"));
		$Ndate->modify('-21 day');
		$EndDate = $Ndate->format('Y-m-d');
       
         $query = $this->db->query("SELECT * FROM `test_details` as td inner join test_report as tr on td.test_id = tr.test_id where td.doctor_id = $id and td.doctor_approval = 1 and tr.test_id = $test_id AND td.test_date Between $EndDate and $startDate");


        return $query->result();
     
    }
	public function GetOverduesMoreThenweekCount($id)
    {

    	$date = new DateTime(date("Y-m-d"));
		$date->modify('-14 day');
		$startDate = $date->format('Y-m-d');

		$Ndate = new DateTime(date("Y-m-d"));
		$Ndate->modify('-21 day');
		$EndDate = $Ndate->format('Y-m-d');
       
	   
	   
	   
         $query = $this->db->query("SELECT count(*) as counts FROM `test_details` as td inner join test_report as tr on td.test_id = tr.test_id where td.doctor_id = $id and td.doctor_approval = 1 AND  tr.authorised is NULL AND td.test_date Between $EndDate and $startDate");


        return $query->result();
     
    }

     public function GetOverduesMoreThenTwoweek($id = NULL,$test_id = NULL)
    {
       

    	$date = new DateTime(date("Y-m-d"));
		$date->modify('-14 day');
		$startDate = $date->format('Y-m-d');

		$Ndate = new DateTime(date("Y-m-d"));
		$Ndate->modify('-21 day');
		$EndDate = $Ndate->format('Y-m-d');

         $query = $this->db->query("SELECT * FROM `test_details` as td inner join test_report as tr on td.test_id = tr.test_id where td.doctor_id = $id and td.doctor_approval = 1 and tr.test_id = $test_id AND td.test_date < '$EndDate'");

        
        return $query->result();
     
    }

     public function DoctorOverDues($id)
    {
       

        $date = new DateTime(date("Y-m-d"));
        $date->modify('-14 day');
        $startDate = $date->format('Y-m-d');

        $Ndate = new DateTime(date("Y-m-d"));
        $Ndate->modify('-21 day');
        $EndDate = $Ndate->format('Y-m-d');

         $query = $this->db->query("SELECT *,tdr.status as primary_status,tdr.doctor_id as primary_doctor_id FROM `test_details` as td 
            inner join test_report as tr on td.test_id = tr.test_id 
            inner join patient_details as pd on pd.patient_id = td.patient_id 

             inner join `test_doctor_report` as tdr
             on tdr.test_id = td.test_id


            where tdr.doctor_id = $id and tr.authorised IS NULL AND td.test_date < '$EndDate'");

        // echo $this->db->last_query();exit;

        return $query->result();
     
    }

	public function GetOverduesMoreThenTwoweekCount($id)
    {
       

    	$date = new DateTime(date("Y-m-d"));
		$date->modify('-14 day');
		$startDate = $date->format('Y-m-d');

		$Ndate = new DateTime(date("Y-m-d"));
		$Ndate->modify('-21 day');
		$EndDate = $Ndate->format('Y-m-d');




         $query = $this->db->query("SELECT count(*) as counts FROM `test_details` as td inner join test_report as tr on td.test_id = tr.test_id where td.doctor_id = $id and td.doctor_approval = 1 AND  tr.authorised is NULL AND td.test_date < '$EndDate'");

        
        return $query->result();
     
    }

    public function TotalCompletedJob($id)
    {
       
        $query = $this->db->query("SELECT count(*) as counts FROM `test_details` as td left join test_report as tr on td.test_id = tr.test_id where td.doctor_id = $id and td.doctor_approval = 1 AND  tr.authorised = 1");

        
        return $query->result();
     
    }

     public function TotalInCompletedJob($id)
    {
       
        $query = $this->db->query("SELECT count(*) as counts FROM `test_details` as td 
		left join test_report as tr 
		on td.test_id = tr.test_id

        left join test_doctor_report as tdr 
        on tdr.test_id = td.test_id

		 where tdr.doctor_id = $id and tdr.status = 1 AND  tr.authorised is NULL");

        
        return $query->result();
     
    }

    public function TotalUrgentJob($id)
    {
       
        $query = $this->db->query("SELECT count(*) as counts FROM `test_details`  where doctor_id = $id AND  urgent = 1");

        
        return $query->result();
     
    }


public function getAllPatientReports($id)
    {
       
        $query = $this->db->query("SELECT *,td.test_id as primary_id FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id 
        						   Inner join `test_report` as tr
        						   on td.test_id = tr.test_id 
								   
								   left join `type_of_test` as tot
        						   on tot.TestTypeId = td.test_type_id 
								   
								   left join `hospitals` as hos
        						   on hos.hospital_id = td.hospital_id 
								   
								   left join `doctors` as doc
        						   on doc.doctor_id = td.doctor_id 
								   
        						   where td.doctor_id = $id");

        
        return $query->result();
     
    }
    public function ApproveJobByDoctor($id)
    {
       
        $query = $this->db->query("UPDATE `test_details` SET `doctor_approval`= 1 WHERE test_id = $id");

        
        if($this->db->affected_rows()>0 )
			{
				return 'Done';
			}
			else
			{
				return "Fail";
			}
     
    }

    public function ApproveJobByMultipleDoctor($id,$doctor_id)
    {
       
        $query = $this->db->query("UPDATE `test_doctor_report` SET `status`= 1 WHERE test_id = $id AND doctor_id = $doctor_id");

        
        if($this->db->affected_rows()>0 )
            {
                return 'Done';
            }
            else
            {
                return "Fail";
            }
     
    }

    public function DeclineJobByDoctor($id)
    {
        $query = $this->db->query("UPDATE `test_details` SET `doctor_id`= NULL, `doctor_approval` = NULL  WHERE test_id = $id");

        
        if($this->db->affected_rows()>0 )
			{
				return 'Done';
			}
			else
			{
				return "Fail";
			}
     
    }

    public function getAllArchiveJobs($id)
    {
      
        $query = $this->db->query("SELECT td.test_id,pd.patient_id,td.hospital_id,td.Client_case_number,td.test_date,td.admin_archive,td.box_received,pd.patient_name,pd.last_name,tr.authorised FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id

                                   left join `test_report` as tr
                                   on tr.test_id = td.test_id
                                   where td.doctor_id = $id And
                                    td.doctor_archive = 1 And
                                    td.company_id = ".$this->session->userdata('company_id'));


        return $query->result();
     
    }

     public function getInvoiceById($id)
    {
      
        $query = $this->db->query("SELECT * FROM `test_details` as td
                                   left join `test_report` as tr
                                   on td.test_id = tr.test_id

                                   Inner join `patient_details` as pd
                                   on pd.patient_id = td.patient_id

                                   left join `invoice_details` as id
                                   on td.test_id = id.test_id 

                                   where td.test_id = $id");

        
        return $query->result();
     
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
	
	

	public function AddtoArchive($post_id)
	{
		$this->db->reconnect();

		$query = $this->db->query("UPDATE `test_details` SET `archive`= 1 WHERE test_id = $post_id");

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

		$query = $this->db->query("UPDATE `test_details` SET `archive`= 0 WHERE test_id = $post_id");

		if($this->db->affected_rows()>0 )
			{
				return "Done";
			}
			else
			{
				return "Fail";
			}
	}

    public function AddtoUrgent($post_id)
    {
        $this->db->reconnect();

        $query = $this->db->query("UPDATE `test_details` SET `urgent`= 1 WHERE test_id = $post_id");

        if($this->db->affected_rows()>0 )
            {
                return "Done";
            }
            else
            {
                return "Fail";
            }
    }

    public function RemovetoUrgent($post_id)
    {
        $this->db->reconnect();

        $query = $this->db->query("UPDATE `test_details` SET `urgent`= 0 WHERE test_id = $post_id");

        if($this->db->affected_rows()>0 )
            {
                return "Done";
            }
            else
            {
                return "Fail";
            }
    }


    public function Upload_Doctor_documents($data)
	{
		$this->db->reconnect();

		$this->db->insert("doctor_uploads",$data);

		if($this->db->affected_rows()>0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return "Fail";
			}
	}

    public function Upload_multiple_attach($data)
    {
        $this->db->reconnect();

        $this->db->insert("reports_upload",$data);

        if($this->db->affected_rows()>0 )
            {
                return $this->db->insert_id();
            }
            else
            {
                return "Fail";
            }
    }

    public function DeleteFileById($id)
    {

        $query = $this->db->query("DELETE FROM `doctor_uploads` WHERE doctor_upload_id = $id");

        
      if($this->db->affected_rows()>0 )
            {
                return "Done";
            }
            else
            {
                return "Fail";
            }
    }


    public function AddErrorLog($data)
    {
        $this->db->reconnect();
		$data['date'] = date("Y-m-d H:i:s");
        $this->db->insert("error_log",$data);

        if($this->db->affected_rows()>0 )
            {
                return $this->db->insert_id();
            }
            else
            {
                return "Fail";
            }
    }

    public function AwaitingApprovalCount($doctor_id)
    {

        $this->db->reconnect();
      
        $this->db->from('test_details');
        $this->db->select('count(*) as value');

        $this->db->join('test_doctor_report as tdr','tdr.test_id = test_details.test_id');


        $this->db->where('tdr.doctor_id',$doctor_id);
        $this->db->where('tdr.status', 0);

        //SELECT count(*) FROM `test_details` where doctor_id = 1 and doctor_approval is null 

         $query = $this->db->get();

        return $query->result();    
     
    }

    public function getInvoiceByTestId($id)
    {

        $this->db->reconnect();
      
        $this->db->from('invoice_details');
        $this->db->select('*');   
        $this->db->where('test_id',$id);
        

        //SELECT count(*) FROM `test_details` where doctor_id = 1 and doctor_approval is null 

         $query = $this->db->get();

        return $query->result();    
     
    }

    public function getAllAttachFiles($id)
    {

        $this->db->reconnect();
      
        $this->db->from('reports_upload');
        $this->db->select('*');   
        $this->db->where('test_id',$id);
        

        //SELECT count(*) FROM `test_details` where doctor_id = 1 and doctor_approval is null 

         $query = $this->db->get();

        return $query->result();    
     
    }

    public function DeleteThisAttachment($id)
    {
        $this->db->where('report_upload_id', $id);
        $this->db->delete('reports_upload');
    }

    public function getAllInvoiceDetailsCSV($fields = NULL,$id = NULL,$startDate = Null,$endDate = Null)
    {
       
        
            $this->db->from('test_details as td');
            $this->db->join('patient_details as pd', 'pd.patient_id = td.patient_id');
            $this->db->join('doctors as doc', 'doc.doctor_id = td.doctor_id');
            $this->db->join('hospitals as hos', 'hos.hospital_id = td.hospital_id');
            $this->db->join('invoice_details as inv', 'inv.test_id = td.test_id');
            $this->db->where('td.doctor_archive ', "!= 1");
            
            $this->db->select(implode(",",$fields),'cast(inv.invoice_date as date)');   
            $this->db->order_by("td.test_id", "desc");
           
            $this->db->where('td.doctor_id',$id);

            if(!empty($startDate) && !empty($endDate)){
                $this->db->where('inv.invoice_date between "'.$startDate.'" And "'.$endDate.'"');
            }

            $query = $this->db->get(); 
            return $query->result(); 
     
    }

    public function GetTotalValueOfInvocies($id = Null,$paid = Null,$unpaid = Null,$startDate = Null,$endDate = Null)
    {

        $this->db->reconnect();
      
        $this->db->from('test_details as td');
         $this->db->join('invoice_details as inv', 'inv.test_id = td.test_id');

        $this->db->select('sum(pathologists_fee) as total,cast(inv.invoice_date as date)');   
        $this->db->where('td.doctor_id',$id);
        $this->db->where('td.doctor_approval', '1');
        $this->db->where('td.doctor_archive ', "!= 1");

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

        return $query->result();    
     
    }

    public function GetRequestForm($id)
    {

       $this->db->from('admin_uploads');
       $this->db->where('test_id', $id);
        
       $query = $this->db->get();
       
        return $query->result();    
        
     
    }

    public function DeleteSynopsisByReportId($id)
    {
        $this->db->where('report_id', $id);
        $this->db->delete('form_values');

        if($this->db->affected_rows()>0 )
            {
                return "Done";
            }
            else
            {
                return "Fail";
            }
    }

    public function DeleteReportNameByReportId($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('reports');

        if($this->db->affected_rows()>0 )
            {
                return "Done";
            }
            else
            {
                return "Fail";
            }
    }

    public function UpdateSnomed($data = NULL,$id = NULL)
    {
        $this->db->set($data);
        $this->db->where('test_id', $id);
        $this->db->update('test_report');
       
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