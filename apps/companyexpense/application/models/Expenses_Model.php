<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses_Model extends CI_Model{

// For adding expenses
public function add($uid,$company_id,$edate,$item,$icost){
$data=array(
'UserId'=>$uid,
'company_id'=>$company_id,
'ExpenseDate'=>$edate,
'ExpenseItem'=>$item,
'ExpenseCost'=>$icost
);
$query=$this->db->insert('tblexpense',$data);
if($query){
$this->session->set_flashdata('success','Expense added successfully.');	
redirect('Expenses/add');
} else {
$this->session->set_flashdata('error','Something went wrong. Please try again.');	
redirect('Expenses/add');	
}
}
//For Manage Expenses
public function manage($uid)
{
	$query=$this->db->select('ExpenseDate,ExpenseItem,ExpenseCost,NoteDate,ID')
	     ->where('UserId',$uid)
         ->where('company_id',$this->session->userdata('company_id'))
	     ->get('tblexpense');
	     return $query->result();
}

// For expense Deletion
public function delete($uid){
$query=$this->db->where('ID',$uid)
                ->delete('tblexpense');
}
}