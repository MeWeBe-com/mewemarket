<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Add Report Details - LIMS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


     <!-- Bootstrap core CSS     -->
  <?php $this->load->view('partial/head')?>
</head>

<body>
	<div class="wrapper">
		<?php $this->load->view('partial/sidebar')?>

	    <div class="main-panel">
			<?php $this->load->view('partial/nav')?>

	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    
	                    <div class="col-lg-8 col-md-7">
	                        <div class="card">
	                            <div class="card-header">
	                                <span class="text-theme bootstrap-table pl-0 mt-0 mb-0">Report Details</span>
	                            </div>
	                            <div class="card-content">
	                                <?php echo form_open_multipart('uploadreport/AddDetailReport');?>
	                                    <div class="row">

	                                    	  <a data-toggle="modal" data-target="#exampleModal" class="btn btn-outline-danger btn-theme mb-3 ml-4" ><span>Add Synopsis</span></a>


		                                    <input type="hidden" name="test_id" value="<?php echo $patient_details[0]->test_id?>">
		                                    <input type="hidden" name="patient_id" value="<?php echo $patient_details[0]->patient_id?>">

		                                      <div class="col-md-12">
		                                        <div class="form-group">
		                                            <label>Microscopy</label>
		                                            <textarea name="microscopy" class="form-control resize-open" rows="10"></textarea>
		                                        </div>
		                                    </div>

	                                    </div>

	                                     <div class="row">
	                                     	
	                                     	<?php if(!empty($error)){
	                                     		echo "Please select the correct Format file";
	                                     		}?>

		                                    <div class="col-md-12">
		                                        <div class="form-group">
		                                            <label>Attach File</label>
		                                            <input type="file" name="upload_file[]">

		                                            <div class="Multiple_Uploads">
			                                        		
			                                        </div>

		                                            <button type="button" class="add_new_file mt-3 btn btn-wd btn-theme">Add New Files</button>

		                                              <?php if(isset($_GET['error'])){
					                                    	echo "<span style='color:#ae1a41' class='ml-5 mb-3'>Filetype not match please use supported format </span>";
					                                    }?>

					                                

		                                        </div>
		                                    </div>

		                                  
		                                     <div class="col-md-12">
		                                        <div class="form-group">
		                                            <label>Snomed</label> 
		                                            
													<select class="tokenize-source-demo-2" name="snomed[]" multiple=""  style="display: none;">
													</select>
													
		                                        </div>
		                                    </div>
	                                    </div>

	                                  <!--  <div class="row">
	                                        <div class="col-md-12">
	                                            <div class="form-group">
	                                                <span>Last saved :</span>
	                                               <label> <?php echo $this->session->userdata('username')?> </label>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-12">
	                                            <div class="form-group">
	                                                <span>Published date :</span>
	                                               <label> </label>
	                                            </div>
	                                        </div>
	                                         <div class="col-md-12">
	                                            <div class="form-group">
	                                                <span>Last updated on : </span>
	                                                <label> </label>
	                                            </div>
	                                        </div>
	                                    </div>-->
	                                   
	                                
	                                    <div class="text-center">
	                                        <button type="submit" name="save" value="save" class="btn  btn-theme btn-wd ">Save</button>
	                                        <button type="submit" name="publish" value="publish" class="btn  btn-theme btn-wd  publish">Authorise and Publish</button>
	                                    </div>

	                                    <script>
	                                    		
	                                    		 $(document).ready(function(){
											       $('.publish').click(function(){ 
											            var retVal = confirm("Once you accept this and Authorise and publish the report, you will not be able to edit the report,\n it will be complete and submitted?");
											                   if( retVal == true ) {
											                      return true;
											                   } else {
											                      return false;
											                   }
											              
											         });
											    });

	                                    </script>

	                                    <div class="clearfix"></div>
	                                  <?php echo form_close();?>
	                            </div>
	                        </div>
	                    </div>

	                    <div class="col-lg-4">
	                    	<div class="card">
	                            <div class="card-header">
	                                <h4 class="card-title">Patient Details</h4>
	                            </div>
	                            <div class="card-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
	                                             <span>Name :</span><br/>
	                                             <label style="font-size:18px;color:#ae1a41"><?php echo  $patient_details[0]->last_name?>, <?php echo  $patient_details[0]->patient_name?></label>
                                            </div>
                                        </div>
                                        <?php /*?><div class="col-md-6">
                                            <div class="form-group">
                                            	 <span>Last Name :</span><br/>
                                                 <label><?php echo  $patient_details[0]->last_name?></label>
                                              
                                            </div>
                                        </div><?php */?>
                                    </div>

                                     <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Age :</span><br/>
	                                             <label>
	                                             <?php 
		                                             $date=$patient_details[0]->DateOfBirth;
													 $date = new DateTime($date);
														 $now = new DateTime();
														 $interval = $now->diff($date);
														 echo  $interval->y;
 
 
												?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            	 <span>Gender :</span><br/>
                                                 <label><?php echo $patient_details[0]->patientGender?></label>
                                              
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Specimen :</span><br/>
	                                             <label><?php  echo $testName[0]->TestTypeName; ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            	 <span>No of Specimen :</span><br/>
                                                 <label><?php echo $patient_details[0]->no_of_specimen?></label>
                                              
                                            </div>
                                        </div>
                                    </div>

                                    <?php /*?><div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Email :</span><br/>
	                                             <label><?php echo $patient_details[0]->email ; ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            	 <span>Mobile number :</span><br/>
                                                 <label><?php echo $patient_details[0]->mobile_number ; ?></label>
                                              
                                            </div>
                                        </div>
                                    </div><?php */?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Case reff# :</span><br/>
	                                             <label><img src="data:image/png;base64,<?php echo  $patient_details[0]->Client_case_number_barcode?>"></label>
	                                             <label><?php echo $patient_details[0]->Client_case_number?></label>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            	 <span>Visiopath number :</span><br/>
                                                 <label><img src="data:image/png;base64,<?php echo $patient_details[0]->visiopath_case_number_barcode?>"></label>
                                                 <label><?php echo $patient_details[0]->visiopath_number?></label>

                                            </div>
                                        </div>
                                    </div>

                                     <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Hospital number :</span><br/>
	                                             <label><?php echo $patient_details[0]->hospital_number?></label>

                                            </div>
                                        </div>
                                       <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>NHS number :</span><br/>
	                                             <label><?php echo $patient_details[0]->nhs_number?></label>

                                            </div>
                                        </div>

                                         <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Date created :</span><br/>
	                                             <label><?php  $date = $patient_details[0]->test_date;
														 $date = date_create($date);
														 $date = date_format($date,"d-m-Y"); 
 														 echo $date;?></label>

                                            </div>
                                        </div>
										
										
										
										<div class="col-md-12">
                                            <div class="form-group">
	                                             <span>Specimen :</span><br/>
	                                             <label><?php echo  nl2br($patient_details[0]->specimen_text);?></label>

                                            </div>
                                        </div>
										
										<div class="col-md-12">
                                            <div class="form-group">
	                                             <span>Clinical details :</span><br/>
	                                             <label><?php echo  nl2br($patient_details[0]->clinical_details);?></label>

                                            </div>
                                        </div>
										
										<div class="col-md-12">
                                            <div class="form-group">
	                                             <span>Macroscopic Details :</span><br/>
	                                             <label><?php echo  nl2br($patient_details[0]->macroscopic_details);?>
												 
												 
												 </label>

                                            </div>
                                        </div>
										
                                    </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

	       <?php $this->load->view('partial/footer')?>
		  
	    </div>
	</div>
</body>



	<?php $this->load->view('partial/footerscript')?>
	 <link rel="stylesheet" href="<?php echo base_url();?>assets/css/tokenize2.css">
		   <style>
	.tokenize-dropdown {
		z-index:100;
		margin-top:25px;
	}
	</style>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/tokenize2.js"></script>

  <script>
  $( function() {

	//$('.tokenize-demo').tokenize2({sortable: true,tokensAllowCustom: true});
	$('.tokenize-source-demo-2').tokenize2({
		dataSource: '<?php echo base_url();?>admin/getSnomed'
	});

  } );
  </script>

</html>

 												<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
												  <div class="modal-dialog" role="document">
												    <div class="modal-content">
												      <div class="modal-header">
												        <h5 class="modal-title" id="exampleModalLongTitle" >Log New Error</h5>
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
												          <span aria-hidden="true">&times;</span>
												        </button>
												      </div>
												       <form  method="post" action="<?php echo base_url()?>doctor/AddErrorLog" >
	<?php 
															$id = end($this->uri->segment_array());
														?>
												       	 <input type="hidden" class="form-control" name="test_id" value="<?php echo $id?>">
												      <div class="modal-body row">
												      

												       	
												        	 <div class="col-md-6">
						                                        <div class="form-group">
						                                            <label>Severity </label> 
						                                            <input type="text" class="form-control" placeholder="Severity" name="severity">
						                                        </div>
						                                    </div>

						                                     <div class="col-md-6">
						                                        <div class="form-group">
						                                            <label>Preventative Action </label> 
						                                            <input type="text" class="form-control" placeholder="Preventative Action" name="preventative_action">
						                                        </div>
						                                    </div>

						                                    <div class="col-md-6">
						                                        <div class="form-group">
						                                            <label>Details of non-conformity </label> 
						                                            <input type="text" class="form-control" placeholder="Preventative Action" name="non_conformity">
						                                        </div>
						                                    </div>

						                                    <div class="col-md-6">
						                                        <div class="form-group">
						                                            <label>Immediate corrective action </label> 
						                                            <input type="text" class="form-control" placeholder="Preventative Action" name="corrective_action">
						                                        </div>
						                                    </div>

						                                    <div class="col-md-6">
						                                        <div class="form-group">
						                                            <label>RCA and corrective action plan</label> 
						                                            <input type="text" class="form-control" placeholder="Preventative Action" name="action_plan">
						                                        </div>
						                                    </div>
												      </div>
												      <div class="modal-footer">
												        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												        <button type="submit"  name="submit" class="btn btn-primary">Submit Log</button>
												      </div>
												       </form>
												    </div>
												  </div>
												</div>


												<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">SELECT SYNOPSIS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form method="post" action="<?php echo base_url();?>uploadreport/UpdateSpecimenGenerateForm/<?php echo $patient_details[0]->test_id?>">
      <div class="modal-body">
       
        	<select class="form-control" name="specimen" required="" >
        		<?php foreach($testTypes as $test){?>
        			<option value="<?php echo $test->TestTypeId?>"><?php echo $test->TestTypeName?></option>
        		<?php }?>
        	</select>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Generate Form</button>
      </div>
  	</form>
    </div>
  </div>
</div>

 <script>
			                                        	$(".add_new_file").on('click', function () {

															  $(".Multiple_Uploads").append('<input class="mt-3" value="" type="file" name="upload_file[]">');
														});

														$('.DeleteThisAttachment').on('click', function(){
															var attach_id = $(this).attr('value');
															  var retVal = confirm("Are you sure you want to delete this attachment ?");
											                   if( retVal == true ) {
											                        $.ajax({url: "<?php echo base_url();?>uploadreport/DeleteThisAttachment/"+attach_id, success: function(result){
														                $(".multiple"+attach_id).remove();
														            	}
														            });
											                   } else {
											                      
											                   }

														});
			                                        </script>
