<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_Model extends CI_Model{

//function for todays Expenses
public function todaysexpenses($uid){
$tdate=date('Y-m-d');
$data=array(
'ExpenseDate'=>$tdate,
'UserId'=>$uid,
'company_id'=>$this->session->userdata('company_id')
);
$this->db->select_sum('ExpenseCost');
$this->db->where($data);
$result=$this->db->get('tblexpense')->row();
return $result->ExpenseCost;
}

//Function for yesterday expenses
public function yesterdayxpenses($uid){
$tdate=date('Y-m-d',strtotime("-1 days"));
$data=array(
'ExpenseDate'=>$tdate,
'UserId'=>$uid,
    'company_id'=>$this->session->userdata('company_id')
);
$this->db->select_sum('ExpenseCost');
$this->db->where($data);
$result=$this->db->get('tblexpense')->row();
return $result->ExpenseCost;
}

//Function for last 7 days expenses
public function last7daysexpenses($uid){
$pasttdate=date('Y-m-d',strtotime("-1 week"));
$cdate=date('Y-m-d');

$data=array(
'ExpenseDate>='=>$pasttdate,
'ExpenseDate<='=>$cdate,
'UserId'=>$uid,
    'company_id'=>$this->session->userdata('company_id')
);
$result=$this->db->select_sum('ExpenseCost')
         ->where($data)
         ->get('tblexpense')->row();  
return $result->ExpenseCost;
}

//Function for last 30 days expenses
public function last30daysexpenses($uid){
$pasttdate=date('Y-m-d',strtotime("-1 month"));
$cdate=date('Y-m-d');

$data=array(
'ExpenseDate>='=>$pasttdate,
'ExpenseDate<='=>$cdate,
'UserId'=>$uid,
    'company_id'=>$this->session->userdata('company_id')
);
$this->db->select_sum('ExpenseCost');
$this->db->where($data);
$result=$this->db->get('tblexpense')->row();
return $result->ExpenseCost;
}

//Function for current year expenses
public function currentyearsexpenses($uid){
$tdate=date("Y");
$data=array(
'year(ExpenseDate)'=>$tdate,
'UserId'=>$uid,
    'company_id'=>$this->session->userdata('company_id')
);
$this->db->select_sum('ExpenseCost');
$this->db->where($data);
$result=$this->db->get('tblexpense')->row();
return $result->ExpenseCost;
}

//Function for total expenses
public function totalsexpenses($uid){
$data=array(
'UserId'=>$uid,
    'company_id'=>$this->session->userdata('company_id')
);
$this->db->select_sum('ExpenseCost');
$this->db->where($data);
$result=$this->db->get('tblexpense')->row();
return $result->ExpenseCost;
}

    public function company_add($company_name){
        $data=array(
            'company_name'=>$company_name,

        );
        $query=$this->db->insert('tblcompany',$data);
        if($query){
            return $this->db->insert_id();
        }
    }

    public function user_add($company_id,$data){
        $data=array(
            'company_id' =>$company_id,
            'FullName'    => $data->first_name.''.$data->last_name,
            'Email'      => $data->email,
            'MobileNumber' => $data->phone,
            'password'     => md5($data->password)
        );

        $query=$this->db->insert('tbluser',$data);
        if($query){
            return 'Done';
        }
    }


}
