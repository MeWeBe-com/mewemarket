<?php

/**
 * Created by IntelliJ IDEA.
 * User: Urfan
 * Date: 19/05/2017
 * Time: 21:49
 */


class invoice_model extends CI_Model
{

    public function getAllPatientForInvoice()
    {
       
        $query = $this->db->query("SELECT * FROM `test_details` as td
        						   Inner join `patient_details` as pd
        						   on pd.patient_id = td.patient_id 
        						   Inner join `test_report` as tr
        						   on td.test_id = tr.test_id
                       Inner join `invoice_details` as id
                       on td.test_id = id.test_id ");

        
        return $query->result();
     
    }
	

    public function getAllDoctorInvoice($id = Null,$startDate = Null,$endDate = Null)
    {
       
      
		$this->db->where('td.doctor_id', $id);
		$this->db->where('td.doctor_archive ', "!= 1");
		$this->db->where('tr.authorised', 1);
	    $this->db->from('test_details as td');
		$this->db->select('td.*,pd.patient_id,pd.patient_name,pd.last_name,pd.DateOfBirth,id.doctor_sent,id.doctor_paid,hos.hospital_name,td.Client_case_number,td.visiopath_number,id.invoice_date,cast(id.invoice_date as date)');    
      	$this->db->limit(50);  
		$this->db->order_by("test_id", "desc");
		$this->db->join('patient_details as pd', 'pd.patient_id = td.patient_id ');
		$this->db->join('hospitals as hos', 'hos.hospital_id = td.hospital_id ');
		$this->db->join('test_report as tr', 'tr.test_id = td.test_id', 'left');
		$this->db->join('invoice_details as id', 'td.test_id = id.test_id', 'left');

		if(!empty($startDate) && !empty($endDate)){
            $this->db->where('id.invoice_date between "'.$startDate.'" And "'.$endDate.'"');
        }
		
		$query = $this->db->get(); 
		return $query->result();
     
    }
	 public function checkIfInvoiceAlreadyGenerated($id)
    {
       
      
		
		$this->db->where('test_id', $id);
	    $this->db->from('invoice_details');
		$this->db->select('*');    
      	$this->db->limit(50);  
		
		
		$query = $this->db->get(); 
		return $query->result();
     
    }
	
	
	public function AdminPayToDoctor($id)
    {
      
        
		$this->db->set('doctor_paid','1');
		$this->db->where('test_id', $id);
		$this->db->update('invoice_details');
	   
		return true;	 
     
    }

    public function updateInvoice($id)
    {
      
        
		$this->db->set('doctor_sent','1');
		$this->db->where('test_id', $id);
		$this->db->update('invoice_details');
	   
		return true;	 
     
    }


    

	public function AdminPayToHospital($id)
    {
      
        
		$this->db->set('hospital_paid','1');
		$this->db->where('test_id', $id);
		$this->db->update('invoice_details');
	   
		return true;	 
     
    }

    public function AdminUnPayToHospital($id)
    {
      
        
		$this->db->set('hospital_paid','0');
		$this->db->where('test_id', $id);
		$this->db->update('invoice_details');
	   
		return true;	 
     
    }

    public function UnpayInvoiceToDoctor($id)
    {
      
        
		$this->db->set('doctor_paid','0');
		$this->db->where('test_id', $id);
		$this->db->update('invoice_details');
	   
		return true;	 
     
    }


    
	
	public function AdminSendToHospital($id)
    {
      
        
		$this->db->set('hospital_sent','1');
		$this->db->where('test_id', $id);
		$this->db->update('invoice_details');
	   
		return true;	 
     
    }
	
	
	
	
	public function getAllDoctorInvoiceByAdmin($role = NULL, $id = Null,$startDate = Null,$endDate = Null)
    {

    	if($role == 'doctor'){
    		$this->db->where('id.doctor_sent ', 1);
    	}

        $this->db->where('td.company_id ', $this->session->userdata('company_id'));
       
        $this->db->where('td.admin_archive ', "!= 1");
		$this->db->where('tr.authorised', 1);
	    $this->db->from('invoice_details as id');
		$this->db->select('td.*,pd.patient_name,pd.last_name,pd.DateOfBirth,id.doctor_sent,id.doctor_paid,id.hospital_sent,id.hospital_paid,doc.doctor_name,hos.hospital_name,td.Client_case_number,td.visiopath_number,tr.*,id.invoice_date,cast(id.invoice_date as date)');    
      	$this->db->limit(50);  
		$this->db->order_by("td.test_id", "desc");
		$this->db->join('test_details as td', 'td.test_id = id.test_id');
		$this->db->join('patient_details as pd', 'pd.patient_id = td.patient_id ');
		$this->db->join('hospitals as hos', 'hos.hospital_id = td.hospital_id ');
		$this->db->join('doctors as doc', 'doc.doctor_id = td.doctor_id ','left');
		$this->db->join('test_report as tr', 'tr.test_id = td.test_id', 'left');

		if(!empty($startDate) && !empty($endDate)){
            $this->db->where('id.invoice_date between "'.$startDate.'" And "'.$endDate.'"');
        }

        

		
		//$this->db->group_by('td.test_id');


		
		$query = $this->db->get(); 

		
		
		return $query->result();
     
    }
	
	
	
	
	public function getAllHospitalInvoice($id = Null,$startDate = Null,$endDate = Null)
    {
     
					   
		$this->db->where('td.hospital_id', $id);   
 		$this->db->where('td.hospital_archive ', "!= 1");
		$this->db->where('tr.authorised', 1);
		$this->db->where('id.hospital_sent', 1);

		if(!empty($startDate) && !empty($endDate)){
            $this->db->where('id.invoice_date between "'.$startDate.'" And "'.$endDate.'"');
        }

	    $this->db->from('test_details as td');
		$this->db->select('td.*,pd.patient_id,pd.patient_name,pd.last_name,id.hospital_sent,id.hospital_paid,doc.doctor_name,td.Client_case_number,td.visiopath_number,id.invoice_date,cast(id.invoice_date as date)');    
      	$this->db->limit(50);  
		$this->db->order_by("test_id", "desc");
		$this->db->join('patient_details as pd', 'pd.patient_id = td.patient_id ');
		$this->db->join('doctors as doc', 'doc.doctor_id = td.doctor_id ');
		$this->db->join('test_report as tr', 'tr.test_id = td.test_id');
		$this->db->join('invoice_details as id', 'td.test_id = id.test_id');
		$query = $this->db->get(); 
		return $query->result();
     
        
        
		
		
     
    }

    public function GetTestDetails($id)
    {
       
        $query = $this->db->query("SELECT * FROM `test_details` as td
                                   Inner join `patient_details` as pd
                                   on pd.patient_id = td.patient_id 
                                   Inner join `test_report` as tr
                                   on td.test_id = tr.test_id 
                                   where td.test_id = $id");

        
        return $query->result();
     
    }

    public function GenerateInvoice($data)
    {
       
         $this->db->reconnect();

            $this->db->insert("invoice_details",$data);

            if($this->db->affected_rows()>0 )
            {
                return $this->db->insert_id();
            }
            else
            {
                return "Fail";
            }
    }

    public function getAllPatientForInvoiceByDoctor($id)
    {
       
        $query = $this->db->query("SELECT * FROM `test_details` as td
                                   Inner join `patient_details` as pd
                                   on pd.patient_id = td.patient_id 
                                   Inner join `test_report` as tr
                                   on td.test_id = tr.test_id 
                                   where td.doctor_id = $id");

        
        return $query->result();
     
    }
  

}