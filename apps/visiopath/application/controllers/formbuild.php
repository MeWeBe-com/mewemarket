<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class formbuild extends CI_Controller {


	public function Index() {

		
	}

	public function EditForm($id)
	{
		
		$Senddata['test_type_id'] = $id;

		$Senddata['formfields'] = $this->admin_model->GetFormByid($id);

		$Senddata['TestTypeName'] = $this->admin_model->getTypeTestbyId($id)[0];

		$this->load->view('admin/editformbuild',$Senddata);

	}
	
	public function eEditForm($id)
	{
		
		
		$this->load->view('admin/eeditformbuild',$Senddata);

	}
	
	
	
	
	public function AddNewFormsssssssssss($id)
	{
		
		$Senddata['test_type_id'] = $id;

		$this->load->view('admin/formbuilder',$Senddata);

	}

	public function AddNewFormFields($id)
	{
		
		$test_type_id = $id; 
		$datas =  $this->input->post();
		$i=1;
		foreach($datas['field_type'] as  $value){
			$value['sorting_order'] = $i;
			if($value['field_type'] == "heading" || $value['field_type'] == "" || $value['field_type'] == "Heading"){
				$value['is_heading'] = 1;
			}
		
			if(isset($value['field_id'])){
				$field_id = $value['field_id'];
				$replacer = array(" ","(","}",")","{","%");
				$value['field_options'] = str_replace("\n","$",$value['field_options']);
				$value['field_name'] = strtolower(str_replace($replacer,"_",$value['field_text']));
				unset($value['field_id']);
				$InsertFields = $this->builder_model->UpdateFormFields($test_type_id,$field_id,$value);
			}else{
				$value['test_type_id'] = $test_type_id;
				$replacer = array(" ","(","}",")","{","%");
				$value['field_name'] = strtolower(str_replace($replacer,"_",$value['field_text']));
				$value['field_options'] = str_replace("\n","$",$value['field_options']);
				$InsertFields = $this->builder_model->InsertFormFields($value);
			}
				
			$i++;
		
		 }

			$data_test = $this->admin_model->GetTestNameByTestId($test_type_id);
			$Uid = $this->session->userdata('id');
					
			$Notify['userId '] = $Uid;
			$Notify['user_action '] = "Admin Add/Edit Form Fields For Specimen: ".$data_test[0]->TestTypeName;
			

			$notification = $this->admin_model->AddNotification($Notify);
		 

		redirect('admin/ShowAllForms/?dataupdated');
		

	}

	public function DeleteFormFieldById($id)
	{
		
		$responce = $this->builder_model->DeleteFieldById($id);

		if(!$responce){
			return true;
		}else{
			return false;
		}

	}

	
}

/* End of file formbuilder.php */
/* Location: ./application/controllers/formbuilder.php */