<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class builder extends CI_Controller {

	
	public function index()
	{

		$forms = array
  (
  
	array(
        'label'       => 'First Name',
        'type'        => 'text',
        'name'        => 'Fname',
        'id'          => 'First Name',
        'placeholder' => 'First Name',
        'class'   	  => 'form-control ',
        
	),
  array(
  	    'label'      => 'Last Name',
        'name'       => 'Lname',
        'type'       => 'text',
        'id'         => 'Last Name',
        'placeholder'=> 'Last Name',
        'class'      => 'form-control ',
 
	),

  array(
  		'label'      => 'specimen',
        'name'       => 'specimen',
        'id'         => 'specimen',
        'type'       => 'text',
        'placeholder'=> 'specimen',
        'class'   	 => 'form-control ',

 			
	),

  array(
  		'label'      => 'Select Month',
        'name'       => 'month',
        'id'         => 'month',
        'type'       => 'select',
        'class'      => 'form-control ',
        "months"     => array(
	  		'jan'   => 'january',
	        'feb'   => 'february',
	        'mar'   => 'march',
	        'apr'   => 'april',
	        'may'   => 'may',
	        'jun'   => 'june',
	        'jul'   => 'july',
	        'aug'   => 'august',
	        'sep'   => 'september',
	        'oct'   => 'october',
	        'nov'   => 'november',
	        'dec'   => 'december',
	    ),
	    

	),

	  array(
	  		'type'          => 'checkbox',
	  		'label'         => 'Agree terms and Conditions',
	        'name'          => 'newsletter',
	        'value'         => 'accept',
	        'checked'       => False,
	        'style'         => 'margin:10px;width: 4%;display:  inline-block;vertical-align:  middle;',
	        'class'     => 'form-control ',
	        'text'     => 'I accept the new terms & conditions',
	),

	array(
	  		'type'    => 'hidden',
	        'name'    => 'patient_id',
	        'value'	  => '1',
	        'class'   => 'form-control ',
	     
	),

	array(
	  		'type'    => 'radio',
	        'name'    => 'gender',
	       	'label'   => 'gender',
	       	'class'   => 'form-control',
	       	'value'   => 'M',

	       	'Innerlabel'   => 'Male ',


	       	'seccondvalue' => array(
	       		'value'    => 'F',
	       		'Innerlabel' => 'Female ',
	       	),

	),

	array(
	  		'type'    => 'textarea',
	        'name'    => 'details',
	       	'label'   => 'Details',
	       	'class'   => 'form-control',
	     
	),

	array(
	  		'type'    => 'date',
	        'name'    => 'dateofbirth',
	       	'label'   => 'Date Of Birth',
	       	'class'   => 'form-control',
	     
	),

	array(
	  		'type'    => 'file',
	        'name'    => 'profile',
	       	'label'   => 'Profile Picture',
	       	'class'   => 'form-control',
	     
	),

	array(
	  		'type'    => 'email',
	        'name'    => 'emailaddress',
	       	'label'   => 'Email Address',
	       	'class'   => 'form-control',
	       	'placeholder'   => 'demo@demo.com',
	     
	),

	array(
	  		'type'    => 'password',
	        'name'    => 'password',
	       	'label'   => 'Password',
	       	'class'   => 'form-control',
	),

	 

  );

  	$SendData['forms'] = $forms ;

		$this->load->view("formBuilder",$SendData);
	}

	public function submitbuilder()
	{

		print_r($this->input->post());
		
		exit;
	}

		
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */