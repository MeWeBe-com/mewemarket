<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Patient Report - LIMS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


     <!-- Bootstrap core CSS     -->
   <?php $this->load->view('partial/head') ?>
</head>

<body>
	<?php if(!isset($_GET['appview'])){?>	
	<div class="wrapper">
		 <?php $this->load->view('partial/sidebar')?>

	    <div class="main-panel">
			
            <?php $this->load->view('partial/nav')?>

	        <div class="content">	 
	<?php }?>
	            <div class="container-fluid">
	                <div class="row">
	                    
	                    <div class="col-lg-12 col-md-7">
	                        <div class="card">
	                            <div class="card-header">

	                               <span class="text-theme  bootstrap-table  mb-3 d-block pl-0">View Report</span>

 <?php if(!empty($jobDetails[0]->authorised)){?>
	                               <a class="btn btn-outline-danger btn-theme " target="_blank" href="<?php echo base_url();?>report/view/<?php echo $jobDetails[0]->test_id?>">Export as PDF </a>
						                <a class="btn btn-outline-danger btn-theme " target="_blank" href="<?php echo base_url();?>hospital/ViewReportPDF/<?php echo $jobDetails[0]->test_id?>/text">Export as TEXT</a>
						
						
								   
								   <a class="btn btn-outline-danger btn-theme " href="javascript:;" onClick="openWin()">Export as WORD </a>
		<script> 
        var myGeeksforGeeksWindow; 
  
        function openWin() { 
            myGeeksforGeeksWindow = window.open("<?php echo base_url();?>hospital/ViewReportWord/<?php echo $jobDetails[0]->test_id?>/doc", "_blank", "width=786, height=786"); 
			 myGeeksforGeeksWindow.focus();
			 myGeeksforGeeksWindow.onblur = function() {
			 	 setTimeout(
				 	function(){
						myGeeksforGeeksWindow.close()
					}, 5000);
				 }
				 
			
        } 
		
		
		

    </script> 
 <?php }else{?>
 									 <a class="btn btn-outline-danger btn-theme " target="_blank" href="<?php echo base_url();?>report/view/<?php echo $jobDetails[0]->test_id?>">View Sample PDF </a>
 <?php }?>
	                               <?php if($this->session->userdata('roleId') == 2){ 

	                               	//print_r($AssociateDoctors);echo $this->session->userdata('UserDetail_Id')?>

	                               	<?php $doctor_id = $this->session->userdata('UserDetail_Id');
	                               	 	if(in_array($doctor_id, array_column($AssociateDoctors, 'doctor_id'))){

	                               	?>
	                              
	                               	 <?php if($jobDetails[0]->authorised != 1 ){

	                               	 	?>
	                                     <a class="btn btn-outline-danger btn-theme mt-3 mb-3 ml"  href="<?php echo base_url()?>uploadreport/EditReport/<?php echo $jobDetails[0]->test_id?>" ><span>Edit Report</span></a>
	                                 <?php }else{?>
	                                 	 <a class="btn btn-outline-danger btn-theme mt-3 mb-3 ml"  href="<?php echo base_url()?>uploadreport/EditReport/<?php echo $jobDetails[0]->test_id?>" ><span>Add Supplementary Report</span></a>
	                                 <?php  }?>
	                                 <?php }?>
	                             <?php }?>
	                               
	                            </div>
	                            <div class="card-content">

	                            	<div class="main-patient-box">
	                            		<div class="Box-header">
	                            			<h4>Patient Details</h4> 
	                            		</div>

	                            		<div class="Box-body">
	                            			<div class="row">
	                                    	<?php //print_r($jobDetails);?>
	                                    	
	                                        
	                                        <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Name: </span>
 													<?php 
 													$name =  $jobDetails[0]->patient_name;
 													?>

	                                                <label class="patient_name"><?php echo $jobDetails[0]->last_name; ?>, <?php echo ($name) ?> </label>
	                                            </div>
	                                        </div>
	                                        
	                                         <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Age: </span>
	                                                <label>
													
													 <?php 
		                                             $date=$jobDetails[0]->DateOfBirth;
													 $date = new DateTime($date);
														 $now = new DateTime();
														 $interval = $now->diff($date);
														 echo  $interval->y; 

														 $date = $jobDetails[0]->DateOfBirth;
														 $date = date_create($date);
														 $date = date_format($date,$dateFormat); 
 														 echo " (dob: ".$date.")"
 
												?>
												
												</label>
	                                            </div>
	                                        </div>
											<div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>NHS number: </span>
	                                                <label><?php echo $jobDetails[0]->nhs_number ?> </label>
	                                            </div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                    	<div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Referral clinic: </span>
 													<label><a class="theme-color" href="<?php echo base_url();?>hospital/HospitalDetails/<?php  echo $jobDetails[0]->hospital_id ?>">
 													<?php echo $jobDetails[0]->hospital_name  ?> </a> </label>
	                                            </div>
	                                        </div>

	                                        <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Date assigned: </span>
 													<label><?php $date=date_create($jobDetails[0]->test_date); echo date_format($date,$dateFormat); ?> </label>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Date reported: </span>
	                                                 <label><?php $date=date_create($jobDetails[0]->update_time); echo date_format($date,$dateFormat); ?></label>
	                                            </div>
	                                        </div>
	                                   </div>

	                                    <div class="row">
	                                    	<div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Hospital number: </span>
	                                                <label><?php echo $jobDetails[0]->hospital_number ?> </label>
	                                            </div>
	                                        </div>
											
											
											
											  <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span >Date created: </span>
	                                                <label><?php  $date = $jobDetails[0]->test_date;
														 $date = date_create($date);
														 $date = date_format($date,$dateFormat); 
 														 echo $date; ?></label>
	                                            </div>
	                                        </div>
	                                        <?php if(!empty($jobDetails[0]->address)){?>
	                                        <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Patient address: </span>
	                                                <label><?php echo $jobDetails[0]->address ?> </label>
	                                            </div>
	                                        </div>
	                                    <?php }?>

	                                      </div>
									
										<div class="row">	

	                                   <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span class="width-100">Case reference number: </span>
	                                                 <label> <img src="data:image/png;base64,<?php echo $jobDetails[0]->Client_case_number_barcode?>"> 
	                                                 		 </label><br>
	                                                 		 <label><?php echo  $jobDetails[0]->Client_case_number  ?></label>
	                                            </div>
	                                        </div>

	                                        <div class="col-md-4"></div>


	                                    <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span class="width-100">Visiopath number: </span><br>
	                                                 <label> <img src="data:image/png;base64,<?php echo $jobDetails[0]->visiopath_case_number_barcode?>"> 
	                                                 		 </label><br>
	                                                 		 <label><?php echo  $jobDetails[0]->visiopath_number  ?></label>
	                                            </div>
	                                        </div>

	                                   



	                            		</div>
	                                        
	                                   </div>

	                                  
	                            	</div>
									
									<div class="main-patient-box mt-3">
	                            		<div class="Box-header">
	                            			<h4>Specimen</h4> 
	                            		</div>

	                            		<div class="Box-body">
	                            			<div class="row">
	                                    	<div class="col-md-12">
	                                            <div class="form-group">
	                                                
 													<label><?php echo  nl2br($jobDetails[0]->specimen_text) ?> </label>
	                                            </div>
	                                        </div>

	                                        

	                                       
	                                   </div>
	                                   	</div>

	                                   
	                                  
	                            	</div>
									
									<div class="main-patient-box mt-3">
	                            		<div class="Box-header">
	                            			<h4>Clinical Details</h4> 
	                            		</div>

	                            		<div class="Box-body">
	                            			<div class="row">
	                                    	<div class="col-md-12">
	                                            <div class="form-group">
	                                                
 													<label><?php echo  nl2br($jobDetails[0]->clinical_details) ?> </label>
	                                            </div>
	                                        </div>

	                                        

	                                       
	                                   </div>
	                                   	</div>

	                                   
	                                  
	                            	</div>
									
									<div class="main-patient-box mt-3">
	                            		<div class="Box-header">
	                            			<h4>Macroscopic Details</h4> 
	                            		</div>

	                            		<div class="Box-body">
	                            			<div class="row">
	                                    	<div class="col-md-12">
	                                            <div class="form-group">
	                                                
 													<label><?php echo  nl2br($jobDetails[0]->macroscopic_details) ?> </label>
	                                            </div>
	                                        </div>

	                                        

	                                       
	                                   </div>
	                                   	</div>

	                                   
	                                  
	                            	</div>


	                            	<div class="main-patient-box mt-3">
	                            		<div class="Box-header">
	                            			<h4>Microscopic Details</h4> 
	                            		</div>

	                            		<div class="Box-body">
	                            			<div class="row">
	                                    	<div class="col-md-12">
	                                            <div class="form-group">
	                                               <!-- <span style="vertical-align:top">Microscopy: </span>-->
 													<span class="RteText"><?php echo ($jobDetails[0]->microscopy) ?> </span>
	                                            </div>

	                                             <?php foreach($ReportDetails as $reportDetail){
	                            		 $report_id = $reportDetail->id ;?>

	                            	
	                            		<div class="col-lg-12 pl-0">
	                            			<h4 class="SynopsisTitle mt-3"><?php echo ucfirst($reportDetail->report_name) ; ?></h4> </div>
	                            		
	                            			<div class="row">

	                            			  <?php

	                            			 
	                            			  if(!empty($GetReportValues[$report_id])){ ?>

	                                   <?php 
									   $array = json_decode(json_encode($GetReportValues[$report_id]), true);

									   foreach($GetReportFields[$report_id] as $field){ 
									   
									   $key = array_search($field->field_id, array_column($array, 'field_id'));

									   if(!empty($GetReportValues[$report_id][$key]->values) || $field->is_heading == 1)
									   {
									   ?> 
									   
									   

	                                   	 <div <?php if($field->is_heading == 1 ){ ?>  class="col-md-12"  <?php }else{ ?> class="col-md-6" <?php } ?>>
	                                            <div class="form-group">

	                                            	 <span>
	                                            	 		<?php if($field->is_heading == 1 ){ ?> 
	                                            	 			<strong>
	                                            	 		<?php } ?> 
	                                            	 		<?php echo $field->field_text;?><?php if($field->is_heading == 1 ){ ?> 
	                                            	 			</strong>
	                                            	 		<?php } ?>: 
	                                            	</span>
	                                   	
	                                   	<?php 
										// $key = array_search($field->field_id, array_column($GetReportValues, 'field_id'));;
										 if($field->is_heading != 1 ){ 
											$values = str_replace("$",",",$GetReportValues[$report_id][$key]->values);
										}else{
											$values = "";
										}

										
										//foreach($GetReportValues as $value){ 

	                                   		//	if($field->field_id == $value->field_id && !empty($value->values)){

	                                   				//$values = str_replace("$",",",$value->values)

	                                   				?>
	                                   				  <label><?php echo $values  ?></label>
	                                   			<?php 	//}

	                                   		//} ?>

	                                   		</div>
	                                   	</div>

	                                  <?php 
									  }
									  }
	                              }?>
	                            		</div>
	                            		
	                            	

	                         <?php }?>

	                                        </div>

	                                       

	                                        

	                                        <?php if(!empty($multipleUploads)){?>

	                                          <div class="col-md-12">
	                                            <div class="form-group">
	                                                <span style="vertical-align:top">Attached Files: </span>
													<label> <?php $i = 1; foreach($multipleUploads as $file){
		                                                	$file_name = explode('/', $file->upload_file);?>
		 													<a class="theme-color" href="<?php echo base_url();?><?php echo  $file->upload_file  ?>"><?php echo $file_name[2]?></a>  
		 													<br />
		                                            	<?php $i++ ; }?></a>  </label>
	                                            </div>
	                                        </div> 

	                                    	<?php }?>

	                                   </div>
	                                   	</div>

	                                   
	                                  
	                            	</div>
	                            	<?php if(!empty($jobDetails[0]->conclusion)){?>
	                            	<div class="main-patient-box mt-3">
	                            		<div class="Box-header">
	                            			<h4>Conclusion</h4> 
	                            		</div>

	                            		<div class="Box-body">
	                            			<div class="row">
	                                    	<div class="col-md-12">
	                                            <div class="form-group">
	                                                
 													<div class="RteText"><?php echo  $jobDetails[0]->conclusion ; ?> </div>
	                                            </div>
	                                        </div>

	                                        

	                                       
	                                   </div>
	                                   	</div>

	                                   
	                                  
	                            	</div>
	                            	<?php }?>
	                            		


	                                   <div class="main-patient-box mt-3">
	                            		<div class="Box-header">
	                            			<h4>Reported By</h4> 
	                            		</div>

	                            		<div class="Box-body">
	                            			
	                            			 <div class="row">

	                                     	<div class="col-md-4">
	                                            <div class="form-group">
	                                            	<span>Doctor name: </span>
 													<label><a class="theme-color" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo  $jobDetails[0]->doctor_id  ?>">
 														<?php echo  "Dr. ".$jobDetails[0]->doctor_name  ?></a>  </label>
	                                            </div>
	                                        </div>

	                                        	<div class="col-md-4">
	                                            <div class="form-group">
	                                            	<span>Gmc number: </span>
 													<label><?php echo  $jobDetails[0]->gmc_number  ?>  </label>
	                                            </div>
	                                        </div>


	                                     	<?php if($jobDetails[0]->show_number == 1){?>
	                                    	<div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Doctor number: </span>
 													<label><?php echo  $jobDetails[0]->work_number  ?> </label>

	                                            </div>
	                                        </div>
	                                    <?php }
										if($jobDetails[0]->show_email == 1){?>
	                                        <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Doctor Email: </span>
	                                                 <label><?php echo  $jobDetails[0]->secondary_email  ?></label>
	                                            </div>
	                                        </div>
	                                    <?php }?>
										
										
										<div class="col-md-12">
	                                            <div class="form-group">
	                                                <span class="vertical-align-top">Snomed: </span>
 													<label><?php echo str_replace("|", ", <br />", $jobDetails[0]->snomed) ?> </label>
	                                            </div>
	                                        </div>
	                                   </div>
	                                    
	                            		</div>
	                            	</div>

	                            	<?php /*?><div class="main-patient-box mt-3">
	                            		<div class="Box-header">
	                            			<h4>Hospital Details</h4> 
	                            		</div>

	                            		<?php //print_r($HospitalDetails);?>

	                            		<div class="Box-body">
	                            			
	                            			 <div class="row">

	                                     	<div class="col-md-4">
	                                            <div class="form-group">
	                                            	<span>Name of Hospital :</span>
 													<label><a class="profile_link" href="<?php echo base_url();?>hospital/HospitalDetails/<?php echo  $jobDetails[0]->hospital_id  ?>"><?php echo  $HospitalDetails[0]->hospital_name  ?></a>  </label>
	                                            </div>
	                                        </div>


	                                     	
	                                    	<div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Email :</span>
 													<label><?php echo  $HospitalDetails[0]->email  ?> </label>

	                                            </div>
	                                        </div>
	                                   
	                                        <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Address :</span>
	                                                 <label><?php echo  $HospitalDetails[0]->address  ?></label>
	                                            </div>
	                                        </div>

	                                       </div>

	                                       <div class="row">
	                                   
	                                     <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Phone number :</span>
	                                                 <label><?php echo $HospitalDetails[0]->phone ?></label>
	                                            </div>
	                                        </div>
	                                   

	                                   
	                                   </div></div>
	                                    
	                            		</div><?php */?>
	                            	

	                               <?php //print_r($jobDetails);?>



	                                <?php if(!empty($getErrorReport)){?>

	                                	 <div class="main-patient-box mt-3">
	                            		<div class="Box-header">
	                            			<h4>Supplementary Report</h4> 
	                            		</div>

	                            		<div class="Box-body">

	                            			<?php foreach($getErrorReport as $error){?>
	                            			
	                            			 <div class="row">

		                                     	<div class="col-md-12">
		                                            <div class="form-group">
		                                            	<span>Doctor name: </span>
	 													<label><a class="theme-color" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo  $error->doctor_id  ?>">
	 														<?php echo  "Dr. ".$error->first_name." ".$error->last_name  ?></a>  </label>
		                                            </div>
		                                        </div>

	                                        	<div class="col-md-12">
		                                            <div class="form-group">
		                                            	<span>Subject: </span>
	 													<label><?php echo  $error->title  ?>  </label>
		                                            </div>
	                                        	</div>


	                                     	
		                                    	<div class="col-md-12">
		                                            <div class="form-group">
		                                                <span>Date: </span>
	 													<label><?php $date=date_create($error->date); echo date_format($date,$dateFormat).' '.date_format($date,'H:i a');?> </label>

		                                            </div>
		                                        </div>
	                                  
		                                        <div class="col-md-12">
		                                            <div class="form-group">
		                                                <span>Report Details: </span><br />
		                                                <div class="RteText"> <?php echo  $error->Comments  ?></div>
		                                            </div>
		                                        </div>
	                                   		
	                                   		</div>

	                                   		<legend></legend>

	                               		<?php }?>

	                               	</div>
	                                    
	                            </div>
	                            	</div>

									<?php }/*?>	<div class="main-patient-box mt-3">
	                            		<div class="Box-header">
	                            			<h4></h4> 
	                            		</div>

	                            		<div class="Box-body">
	                            			<div id="table" >
				                                <table class="table table-striped">
				                                    <thead>
				                                        <tr>
				                                        
				                                    	<!--<th>User</th>-->
				                                    	<th>Title</th>
				                                    	<th>Report Details</th>
				                                    	<th>Date</th>
				                                    	
				                                    </tr></thead>
				                                    <tbody>
				                                      <?php foreach($getErrorReport as $error){ //print_r($error);?>
				                                        <tr>
				                                        	
				                                        	<!--<td><?php echo  $jobDetails[0]->doctor_name  ?></td>-->
				                                        	<td><?php echo $error->title ?></td>
				                                        	<td><?php echo $error->Comments ?></td>
				                                        	<td><?php $date=date_create($error->date); echo date_format($date,$dateFormat);?></td>
				                                        </tr>
				                                       <?php }?>
				                                    </tbody>
				                                </table>
				                            </div>
	                                    
	                            		</div>
	                            	</div>

									

									<?php */ ?>
									</div>   
	                               <div class="clearfix"></div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        <?php if(!isset($_GET['appview'])){?>  
	   		
	      <?php $this->load->view('partial/footer')?>
	    </div>
	</div><?php }?><?php if(isset($_GET['Done'])){?> 

    	<script>
    		
    		$('html,body').animate({scrollTop: 650}, 0);

    	</script>

	  <?php }?>
</body>
 <?php if(!isset($_GET['appview'])){?>  
	<!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
	<?php $this->load->view('partial/footerscript') ?>

	

</html>

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
												  <div class="modal-dialog" role="document">
												    <div class="modal-content">
												      <div class="modal-header">
												        <h5 class="modal-title" id="exampleModalLongTitle" >Add Additional Details</h5>
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
												          <span aria-hidden="true">&times;</span>
												        </button>
												      </div>
												       <form method="post" action="<?php echo base_url()?>doctor/AddErrorLog" >
	<?php 
															$id = end($this->uri->segment_array());
														?>
												       	 <input type="hidden" class="form-control" name="test_id" value="<?php echo $id?>">
												       	 <input type="hidden" class="form-control" name="userId" value="<?php echo $this->session->userdata('id')?>">
												      <div class="modal-body row">
												      

												       	
												        	 <div class="col-md-12">
						                                        <div class="form-group">
						                                            <label>Title </label> 
						                                            <input type="text" class="form-control" placeholder="Title" name="title">
						                                        </div>
						                                    </div>

						                                
						                                    <div class="col-md-12">
						                                        <div class="form-group">
						                                            <label>Comments</label> 
						                                            <textarea name="Comments" required="" class="form-control"> </textarea>
						                                        </div>
						                                    </div>
												      </div>
												      <div class="modal-footer">
												        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												        <button type="submit"  name="submit" class="btn btn-primary">Submit</button>
												      </div>
												       </form>
												    </div>
												  </div>
												</div>
<?php }?>