<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../../assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Patient Report - LIMS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


     <!-- Bootstrap core CSS     -->
   <?php $this->load->view('partial/head') ?>
</head>

<body>
	<div class="wrapper">
		<?php $this->load->view('partial/sidebar') ?>

	    <div class="main-panel">
			<?php $this->load->view('partial/nav') ?>

	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    
	                    <div class="col-lg-12 col-md-7">
	                        <div class="card">
	                            <div class="card-header">
	                               <!-- <h4 class="card-title">REPORT</h4>-->

	                               <a class="btn btn-outline-danger btn-theme " href="<?php echo base_url();?>uploadreport/GetFormDownload/<?php echo $jobDetails[0]->test_id?>">Export as PDF </a>

	                                

	                               
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
	                                                <span>Name :</span>
 													<?php 
 													$name =  explode(" ", $jobDetails[0]->patient_name);
 													?>

	                                                <label><?php print_r($name[0]) ?> </label>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Surname :</span>
	                                                 <label><?php print_r($name[1]) ?></label>
	                                            </div>
	                                        </div>
	                                         <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Date Of birth :</span>
	                                                <label><?php echo $jobDetails[0]->DateOfBirth ?> </label>
	                                            </div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                    	<div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Referral clinic :</span>
 													<label>
 													<?php  

                                                    foreach($hospitals as $hospital){ 
                                                                if($hospital->hospital_id == $jobDetails[0]->hospital_id ){
                                                                    echo $hospital->hospital_name;
                                                                }
                                                            }

                                                     ?>  </label>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span class="width-100">Case reference number :</span>
	                                                 <label> <img src="data:image/png;base64,<?php echo $jobDetails[0]->Client_case_number_barcode?>"> 
	                                                 		 </label><br>
	                                                 		 <label><?php echo  $jobDetails[0]->Client_case_number  ?></label>
	                                            </div>
	                                        </div>

	                                           <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span class="width-100">Visiopath number :</span><br>
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


	                            			  <?php if(!empty($GetReportValues)){ ?>

	                                   <?php 
									   $array = json_decode(json_encode($GetReportValues), true);
									   foreach($GetReportFields as $field){ 
									   
									   $key = array_search($field->field_id, array_column($array, 'field_id'));
									   if(!empty($GetReportValues[$key]->values) || $field->is_heading == 1)
									   {
									   ?> 
									   
									   

	                                   	 <div <?php if($field->is_heading == 1 ){ ?>  class="col-md-12"  <?php }else{ ?> class="col-md-6" <?php } ?>>
	                                            <div class="form-group">

	                                            	 <span><?php if($field->is_heading == 1 ){ ?> <strong>  <?php } ?> <?php echo $field->field_text;?> <?php if($field->is_heading == 1 ){ ?> </strong>  <?php } ?> :</span>
	                                   	
	                                   	<?php 
										// $key = array_search($field->field_id, array_column($GetReportValues, 'field_id'));;
										 if($field->is_heading != 1 ){ 
											$values = str_replace("$",",",$GetReportValues[$key]->values);
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
	                            		</div>	
	                            	</div>

	                            	<div class="main-patient-box mt-3">
	                            		<div class="Box-header">
	                            			<h4>Microscopy Details</h4> 
	                            		</div>

	                            		<div class="Box-body">
	                            			<div class="row">
	                                    	<div class="col-md-12">
	                                            <div class="form-group">
	                                                <span>Microscopy :</span>
 													<label><?php echo  $jobDetails[0]->microscopy  ?> </label>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-4">
	                                            <div class="form-group">
	                                                <span>Supplementary Report :</span>
	                                                 <label><?php echo  $jobDetails[0]->additional_comment  ?></label>
	                                            </div>
	                                        </div>
	                                   </div>
	                                   	</div>

	                                  
	                            	</div>
	                            		


	                                   <div class="main-patient-box mt-3">
	                            		<div class="Box-header">
	                            			<h4>Doctor Details</h4> 
	                            		</div>

	                            		<div class="Box-body">
	                            			
	                            			 <div class="row">

	                                     	<div class="col-md-6">
	                                            <div class="form-group">
	                                            	<span>Doctor name :</span>
 													<label><?php echo  $jobDetails[0]->doctor_name  ?> </label>
	                                            </div>
	                                        </div>


	                                     	<?php if($jobDetails[0]->show_number == 1){?>
	                                    	<div class="col-md-6">
	                                            <div class="form-group">
	                                                <span>Doctor number :</span>
 													<label><?php echo  $jobDetails[0]->work_number  ?> </label>

	                                            </div>
	                                        </div>
	                                    <?php }else{?>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <span>Doctor Email :</span>
	                                                 <label><?php echo  $jobDetails[0]->secondary_email  ?></label>
	                                            </div>
	                                        </div>
	                                    <?php }?>
	                                   </div>
	                                    
	                            		</div>
	                            	</div>

	                                   <?php //print_r($jobDetails);?>

	                                   <?php if($this->session->userdata('roleId') == 2){?>

	                                     <a class="btn btn-outline-danger btn-theme mt-3 mb-3 ml" href="<?php echo base_url()?>uploadreport/EditReport/<?php echo $jobDetails[0]->test_id?>" ><span>Edit report</span></a>

	                                 <?php }?>

	                                <button type="button" class="btn btn-outline-danger btn-theme mt-3" data-toggle="modal" data-target="#exampleModalLong">
										  Add Additional Details
									</button>   
	                                   
	                               <div class="clearfix"></div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

	       <?php $this->load->view('partial/footer') ?>
	    </div>
	</div>
</body>

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
