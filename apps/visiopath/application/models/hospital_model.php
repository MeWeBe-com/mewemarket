<?php

/**
 * Created by Haseeb IDEA.
 * Date: 19/05/2017
 * Time: 21:49
 */


class hospital_model extends CI_Model
{

	
	public function getAllhospitalsJobs($id)
    {
       
        $query = $this->db->query("SELECT *,td.test_id as primary_id,pd.patient_id as patient_primary FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id 
								   LEFT join `doctors` as doc
                                   on td.doctor_id = doc.doctor_id 
								   
								   LEFT join `test_report` as tr
        						   on td.test_id = tr.test_id
								   
        						   where td.hospital_id = $id 
                                   -- And td.urgent != 1
                                   And td.hospital_archive != 1");

        
        return $query->result();
     
    }
	
	public function getAllhospitalsJobsCount($id = NULL,$type = NULL)
    {
		
		if($type == "unassigned"){
			 $this->db->where('test_id NOT IN (select test_id from `test_doctor_report`)');
		}
		if($type == "reportsIn"){
			  $this->db->join('test_report as tr','td.test_id = tr.test_id');
        $this->db->where('tr.authorised', '1');
		}
		 $this->db->where('td.hospital_id', $id);
       	 $this->db->where('td.hospital_archive != 1');
      	 $this->db->from('test_details  as td');
      	 $this->db->select('count(*) as county');
	  	 $this->db->order_by("td.test_id", "desc");
         $query = $this->db->get();
         return $query->result();    
     
    }
	
	public function getAllhospitalsJobsReportsCount($id = NULL,$type = NULL)
    {
		
		if($type == "unassigned"){
			 $this->db->where('td.doctor_id is NULL');
		}
		 $this->db->where('td.hospital_id', $id);
       	 $this->db->where('td.hospital_archive != 1');
      	 $this->db->from('test_details  as td');
      	 $this->db->select('count(*) as county');
	  	 $this->db->order_by("td.test_id", "desc");
         $query = $this->db->get();
         return $query->result();    
     
    }


    public function getAllUrgenthospitalsJobs($id)
    {
	
       
        $query = $this->db->query("SELECT *,td.test_id,td.test_id as primary_id,pd.patient_id as patient_primary FROM `test_details` as td
                                   Inner join `patient_details` as pd
                                   on pd.patient_id = td.patient_id 
								   LEFT join `doctors` as doc
                                   on td.doctor_id = doc.doctor_id 
								   LEFT join `test_report` as tr
        						   on td.test_id = tr.test_id
                                   where td.hospital_id = $id 
                                   And td.urgent = 1
                                   And td.hospital_archive != 1");

        
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
								   
        						   where td.hospital_id = $id");

        
        return $query->result();
     
    }
	
	public function GetAllReports($id)
    {
       
        
		$this->db->where('tr.authorised', 1);
		$this->db->where('td.hospital_id', $id);
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

    public function getPatientReportById($id)
    {
      
						
								   
        $query = $this->db->query("SELECT tr.*,td.*,pd.*,dr.*,td.test_id as test_primary_id,hos.hospital_name FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id 
        						   left join `test_report` as tr
        						   on td.test_id = tr.test_id 
									inner join `hospitals` as hos
                                   on td.hospital_id = hos.hospital_id
                                   left join `doctors` as dr
                                   on td.doctor_id = dr.doctor_id

        						   where td.test_id = $id");

        
        return $query->result();
     
    }


    public function getAllArchiveJobs()
    {
      
        $query = $this->db->query("SELECT  td.test_id,pd.patient_id,td.visiopath_number,td.hospital_id,td.Client_case_number,td.test_date,td.admin_archive,td.box_received,pd.patient_name,pd.last_name,tr.authorised  FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id

                                   left join `test_report` as tr
                                   on tr.test_id = td.test_id

                                   where td.hospital_archive = 1");

        
        return $query->result();
     
    }


	public function AddtoArchive($post_id)
	{
		$this->db->reconnect();

		$query = $this->db->query("UPDATE `test_details` SET `hospital_archive`= 1 WHERE test_id = $post_id");

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

		$query = $this->db->query("UPDATE `test_details` SET `hospital_archive`= 0 WHERE test_id = $post_id");

		if($this->db->affected_rows()>0 )
			{
				return "Done";
			}
			else
			{
				return "Fail";
			}
	}

    public function GetReportFields($id)
    {
      
        $query = $this->db->query("SELECT * FROM `form_fields` 
                                   where test_type_id = $id order by sorting_order");

        
        return $query->result();
     
    }
	
	 public function getHospitalById($id)
    {
      
        $this->db->where('hospitals.hospital_id', $id);
		$this->db->where('user.roleId', "3");
		
		$this->db->join('user', 'user.UserDetail_Id = hospitals.hospital_id');	
	   $this->db->from('hospitals');
	   $query = $this->db->get();
	   
		return $query->result();	 
     
    }
	 public function getHospitalByIdUser($id)
    {
      
        $this->db->where('user.id', $id);
		 $this->db->where('roleId', "3");
		 $this->db->join('hospitals', 'user.UserDetail_Id = hospitals.hospital_id');	
	   $this->db->from('user');
	   $query = $this->db->get();
	   
		return $query->result();	 
     
    }
	
	 public function updateHospitalById($data = NULL,$id = NULL)
    {
      
        $this->db->set($data);
		$this->db->where('hospital_id', $id);
		$this->db->update('hospitals');
	   
		return true;	 
     
    }
	
	

	
	public function getHospitalUserById($UserDetail_Id)
    {
      
        $this->db->where('roleId', 3);
		$this->db->where('UserDetail_Id', $UserDetail_Id);
	   $this->db->from('user');
	   $query = $this->db->get();
	   
		return $query->result();	 
     
    }

    public function GetReportValues($id = NULL,$report_id = NULL)
    {
      
        $query = $this->db->query("SELECT * FROM `form_values` 
                                   where test_id = $id And report_id = $report_id");

        
        return $query->result();
     
    }

    public function DeleteHospitalById($id)
    {
      
       $this->db->where('hospital_id', $id);
       $this->db->delete('hospitals');
       if($this->db->affected_rows()>0 )
            {
                return 'Done';
            }
            else
            {
                return "Fail";
            }      
     
    }

    public function DeleteHospitalUserById($id)
    {
      
        $this->db->where('id', $id);
        $this->db->delete('user');
      
       
       if ($this->db->affected_rows() > 0)  {
                return 'Done';
            }
            else
            {
                return "Fail";
            } 
     
    }

    public function getHospitalDetailsByHospitalId($UserDetail_Id)
    {
      
        $this->db->where('roleId', '3');
       $this->db->where('hospital_id', $UserDetail_Id);
       $this->db->from('hospitals');
       $this->db->join('user','hospitals.hospital_id = user.UserDetail_Id');

       $query = $this->db->get();
       
        return $query->result();     
     
    }

    public function getHospitalPatientByHospitalId($UserDetail_Id = NULL,$role = NULL,$connectionId = NULL)
    {
      
	  
	  
	   if($role == 3){
	   		$this->db->where('td.hospital_id', $connectionId);
	   }
	   if($role == 2){
	   		$this->db->where('td.doctor_id', $connectionId);
	   }
	   $this->db->where('td.hospital_id', $UserDetail_Id);
       $this->db->from('test_details  as td');
       $this->db->select('pd.*');
       $this->db->join('patient_details as pd','pd.patient_id = td.patient_id');
	   
	   $this->db->join('hospitals as hos','hos.hospital_id = td.hospital_id');
	   $this->db->join('doctors as doc','doc.doctor_id= td.doctor_id');
	   $this->db->order_by("pd.patient_name", "asc");
	   $this->db->group_by('pd.patient_id');
		
       $query = $this->db->get();
	  // echo  $this->db->last_query();
        return $query->result();   
		
		

    }

    public function getAllInvoiceDetailsCSV($fields = NULL,$id = NULL,$startDate = Null,$endDate = Null)
    {
       
        
            $this->db->from('test_details as td');
            $this->db->join('patient_details as pd', 'pd.patient_id = td.patient_id');
            $this->db->join('doctors as doc', 'doc.doctor_id = td.doctor_id');
            $this->db->join('hospitals as hos', 'hos.hospital_id = td.hospital_id');
            $this->db->join('invoice_details as inv', 'inv.test_id = td.test_id');
            $this->db->join('test_report as tr', 'tr.test_id = td.test_id');
            
            $this->db->select(implode(",",$fields),'cast(inv.invoice_date as date)');   
            $this->db->order_by("td.test_id", "desc");
           
           $this->db->where('td.hospital_archive ', "!= 1");
            $this->db->where('tr.authorised', 1);
            $this->db->where('inv.hospital_sent', 1);
            $this->db->where('td.hospital_id',$id);

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


        $this->db->select('sum(specimen_fee) as total,cast(inv.invoice_date as date)');   
        $this->db->where('td.hospital_archive ', "!= 1");
        $this->db->where('td.hospital_id',$id);
        $this->db->where('inv.hospital_sent',$id);

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

    public function getHospitalJobsByHospitalId($UserDetail_Id = NULL,$role = NULL,$connectionId = NULL,$unapprove = NULL)
    {
      
       //if($role == 3){
        $this->db->where('td.hospital_id', $UserDetail_Id);
     //}
	 
	 if($role == 2){
	 	 $this->db->where('td.doctor_id', $connectionId);
	 }
     /*if(empty($unapprove)){
       $this->db->where('td.doctor_approval is not NULL');
    }*/
    
     $this->db->from('test_details  as td');
       $this->db->select('td.*,td.test_id as primary_id,pd.patient_id as patient_primary_id,pd.*,tr.authorised,tt.TestTypeName,hos.hospital_name,doc.doctor_name');
       $this->db->join('test_report as tr','td.test_id = tr.test_id','left');
       $this->db->join('patient_details as pd','pd.patient_id = td.patient_id','left');
       $this->db->join('type_of_test as tt','td.specimen = tt.TestTypeId','left');
     $this->db->join('hospitals as hos','hos.hospital_id = td.hospital_id');
     $this->db->join('doctors as doc','doc.doctor_id= td.doctor_id','left');
    $this->db->order_by("td.test_id", "desc");
    
    
       $query = $this->db->get();
    //echo $this->db->last_query();
       
       
        return $query->result();     
     
    }


}