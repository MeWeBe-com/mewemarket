<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Edit Report Details - LIMS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


     <!-- Bootstrap core CSS     -->
  <?php $this->load->view('partial/head')?>

  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
 
<script src="<?php echo base_url();?>assets/js/plugin.js"></script>

</head>

<style>
	body{
		height: 100vh;
    	overflow-y: overlay;
	}

	.wrapper {
    	height: unset;
	}

</style>

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
	                                <span class="text-theme bootstrap-table pl-0 mt-0 mb-0">Edit Report Details</span>

	                                 <span class="pull-right autosavetext"></span>

	                                
	                            </div>
	                            <div class="card-content">
	                               <?php echo form_open_multipart('uploadreport/EditDetailReport/'.$patient_details[0]->test_id);?>
	                                    <div class="row">


	                                    	  <?php foreach($AllReports as $report){?>
	                                    	  <span class="Synopsismain" id="button<?php echo $report->id ;?>">	
	                                    	   <a class="btn btn-outline-danger btn-theme mb-3 ml-4 <?php if($ReportDetails[0]->authorised == 1){ echo 'd-none'; }?>" href="<?php echo base_url()?>uploadreport/GetForm/<?php echo $report->id ;?>">
	                                    	  	<span><?php echo 'Edit '.ucfirst($report->report_name) ;?></span>
	                                    	  </a>
	                                    	   <?php if($ReportDetails[0]->authorised != 1){ ?>
	                                    	  <a href="javascript:;"  value="<?php echo $report->id ;?>|<?php echo $report->testnameId ;?>" class="DeleteThisSynopsis"><i class="fa fa-close Deletesynopsis"></i></a>
	                                    	  <?php  }?>
	                                    	  </span>

	                                    	<?php  } ?>

	                                    	<a  data-toggle="modal" data-target="#exampleModal" class="btn btn-theme-outline mb-3 ml-4 <?php if($ReportDetails[0]->authorised == 1){ echo 'd-none'; }?>" href="javascript:;">
	                                    	  	<span>Add Synopsis</span>
	                                    	  </a>

	                                    	<?php /*if(empty($getFormValues)){?>

	                                    	  <a  data-toggle="modal" data-target="#exampleModal" class="btn btn-outline-danger btn-theme mb-3 ml-5 <?php if($ReportDetails[0]->authorised == 1){ echo 'd-none'; }?>" href="javascript:;">
	                                    	  	<span>Add Synopsis</span>
	                                    	  </a>
	                                    	   
	                                    	<?php }elseif(!empty($getFormValues)){?>

	                                    		 <a class="btn btn-outline-danger btn-theme mb-3 ml-4 <?php if($ReportDetails[0]->authorised == 1){ echo 'd-none'; }?>" href="<?php echo base_url()?>uploadreport/GetForm/<?php echo $patient_details[0]->test_id?>">
	                                    	  	<span>Edit Synopsis</span>
	                                    	  </a>

	                                    	<?php }*/

	                                    	if($ReportDetails[0]->authorised == 1 ){ ?>

	                                    	 <a class="btn btn-outline-danger btn-theme mb-3 ml-4" href="<?php echo base_url();?>hospital/ViewReport/<?php echo $patient_details[0]->test_id?>" >
	                                    	  	<span>View Report (PUBLISHED)</span>
	                                    	  </a>

	                                    	 <?php }else{?>
	                                    	 	<a class="btn btn-theme-outline mb-3 ml-4" href="<?php echo base_url();?>hospital/ViewReport/<?php echo $patient_details[0]->test_id?>" >
	                                    	  	<span>View Sample Report</span>
	                                    	  </a>
	                                    	<?php }?>

		                                    <input type="hidden" name="test_id" value="<?php echo $patient_details[0]->test_id?>">
		                                    <input type="hidden" name="patient_id" value="<?php echo $patient_details[0]->patient_id?>">





		                                      <div class="col-md-12 mt-2">
		                                        <div class="form-group">
		                                            <label>Microscopy</label>

		                                             <textarea name="microscopy" id="MicroscopicField" rows="15"  <?php if($ReportDetails[0]->authorised == 1){?> disabled <?php }?> class="resize-open form-control"><?php if(!empty($ReportDetails[0]->microscopy)){?><?php echo trim($ReportDetails[0]->microscopy);}else{echo $_POST['microscopy'];}?>
		                                             	
		                                             	<?php if(!empty($this->session->flashdata('microscopy') && empty($ReportDetails[0]->microscopy))){
		                                             		echo trim($this->session->flashdata('microscopy'));
		                                             	}?>

		                                             </textarea>

		                                    <?php /*?>        <textarea name="microscopy" id="MicroscopicField" rows="15" <?php if($ReportDetails[0]->authorised == 1){?> disabled <?php }?>  class="form-control resize-open jqte-test "><?php if(!empty($ReportDetails[0]->microscopy)){?><?php echo trim($ReportDetails[0]->microscopy);}else{echo $_POST['microscopy'];}?></textarea> <?php */?>

		                                    <script>
                                          CKEDITOR.replace( 'MicroscopicField', {
                                                language: 'en',
                                                removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,About,Link,Unlink,Source,Superscript,Subscript,Styles,Image,Paragraph',
                                                extraPlugins: 'autogrow'
                                                
                                                
                                            });

                                      </script>

		                                            <?php if(isset($_GET['microscopy'])){ ?>
		                                            	<p class="text-danger">
					                                        Microscopy cannot be empty please add details report.
					                                    </p>
		                                            <?php } ?>
		                                        </div>
	                                    </div>
										

		                                        
		                                    <div class="col-md-12">
		                                        <div class="form-group">
		                                            <label>Conclusion</label>
		                                           

		                                            <textarea rows="5" name="conclusion" id="ConclusionField" class="form-control resize-open" <?php if ($ReportDetails[0]->authorised == 1){ echo 'disabled'; } ?>><?php if(!empty($ReportDetails[0]->conclusion)){?><?php echo trim($ReportDetails[0]->conclusion) ;}else{echo $_POST['conclusion'];}?></textarea>

		                                            <script>
                                          		CKEDITOR.replace( 'ConclusionField', {
	                                                language: 'en',
	                                                removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,About,Link,Unlink,Source,Superscript,Subscript,Styles,Image,Paragraph',
	                                                extraPlugins: 'autogrow'
                                                });

                                         
                                      </script>
		                                        </div>
		                                    </div>

		                                </div>

	                                    <?php //print_r($ReportDetails[0]);?>

	                                     <div class="row">
	                                     	
	                                     	<?php if(!empty($error)){
	                                     		echo "Please select the correct Format file";
	                                     		}?>

		                                    <div class="col-md-12">
		                                        <div class="form-group"> 
		                                            <label>Attach file </label> 
		                                      
			                                        <?php if($ReportDetails[0]->authorised != 1 && empty($multipleUploads)){ ?>  
														<input value="<?php echo $ReportDetails[0]->attach_file ?>" type="file" name="upload_file[]"> 
			                                        <?php }?>

			                                        <?php if($ReportDetails[0]->authorised != 1 ){ ?>
			                                        	<div class="Multiple_Uploads">
			                                        		<?php 
			                                        		$i = 1;
			                                        		foreach($multipleUploads as $file){ 
			                                        			$file_name = explode('/', $file->upload_file);

			                                        			?> 
			                                        			<span class="multiple<?php echo $file->report_upload_id; ?>">
			                                        					<?php echo $i.". "; ?> <a class="theme-color" href="<?php echo base_url().$file->upload_file ;?>"><?php echo $file_name[2];?></a>  

			                                        					<a  class="DeleteThisAttachment theme-color" title="Delete This Attcahment" value="<?php echo $file->report_upload_id; ?>">
			                                        						<i class="ti-close"></i>
			                                        					</a>
			                                        			</span><br/>

			                                        		<?php $i++; }?>
			                                        	</div>

			                                        	<button type="button" class="add_new_file mt-3 btn btn-wd btn-theme">Add New Files</button>
			                                        <?php  }?>

			                                        <?php if($ReportDetails[0]->authorised == 1 && !empty($multipleUploads)){?>

			                                        	<div class="Multiple_Uploads ">
			                                        		<?php 
			                                        		$i = 1;
			                                        		foreach($multipleUploads as $file){ 
			                                        			$file_name = explode('/', $file->upload_file);

			                                        			?> 
			                                        			<span class="multiple<?php echo $file->report_upload_id; ?>">
			                                        					<?php echo $i.". "; ?> <a class="theme-color" href="<?php echo base_url().$file->upload_file ;?>"><?php echo $file_name[2];?></a>  

			                                        			</span><br/>

			                                        		<?php $i++; }?>
			                                        	</div>

			                                       <?php  }
			                                        ?>

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
		                                              
		                                              <?php if(isset($_GET['error'])){
					                                    	echo "<span style='color:#ae1a41' class='ml-5 mb-3'>Filetype not match please use supported format </span>";
					                                    }?>
		                                        </div>
		                                    </div>

		                                   
		                                    <div class="col-md-12">
		                                        <div class="form-group ui-widget">
		                                            <label for="tags">Snomed</label> 
		                                           <?php /*?> <input type="text" name="snomed" <?php if($ReportDetails[0]->authorised == 1){?> disabled <?php }?>  value="<?php echo $ReportDetails[0]->snomed ?>" placeholder="Snomed" class="form-control" id="tags"><?php */?>
													
													<?php if($ReportDetails[0]->authorised == 1){?>
														<br><?php echo str_replace("|","<br> ",$ReportDetails[0]->snomed) ?>
													<?php }else{?>
													<select id="snomedField" class="tokenize-source-demo-2" name="snomed[]" multiple=""  style="display: none;" <?php if($ReportDetails[0]->authorised == 1){?> disabled <?php }?>>
													<?php if(!empty($ReportDetails[0]->snomed)){
														$arrOption = explode("|",$ReportDetails[0]->snomed);
														foreach($arrOption as $option){
													?>
														<option selected value="<?php echo $option?>"><?php echo $option?></option>
													<?php }}?>
													
													</select>
													<?php }?>

													 <?php if(isset($_GET['snomed'])){ ?>
		                                            	<p class="text-danger">
					                                        Snomed cannot be empty please add snomed code.
					                                    </p>
		                                            <?php } ?>
		                                        </div>
		                                    </div>

		                                </div>
										 
	                                    <div class="row" id="Authorise">
	                                        <div class="col-md-12">
	                                           <!-- <div class="form-group">
	                                                <span>Last authorised by :</span>
	                                               <label> <?php echo $this->session->userdata('username')?> </label>
	                                            </div>-->
	                                        </div>
	                                        <div class="col-md-12">
	                                            <div class="form-group">
	                                                <span>Last saved: </span>
	                                               <label> Dr. <?php echo $doctor_details->doctor_name;?> </label>
	                                            </div>
	                                        </div>
	                                        <?php if($ReportDetails[0]->authorised == 1){ ?>
	                                         <div class="col-md-12">
	                                            <div class="form-group">
	                                                <span>Published date: </span>
	                                                <label><?php $date=date_create($ReportDetails[0]->update_time); echo date_format($date,$dateFormat) ; ?>  </label>
	                                            </div>
	                                        </div>

	                                    <?php }?>
	                                    </div>
	                                   
	                                <?php if($ReportDetails[0]->authorised != 1){ ?>
	                                    <div class="text-center">
	                                        <button type="submit" name="save" value="save" class="btn  btn-wd btn-theme">Save</button>
	                                        <button type="submit"  name="publish" value="publish" class="btn  btn-theme btn-wd publish" onClick='return  confirm("Once you accept this and Authorise and publish the report, you will not be able to edit the report, it will be complete and submitted ");'  >Authorise and Publish</button>
	                                    </div> <?php }?>
	                                    <div class="clearfix"></div>
	                                  <?php echo form_close();?>

 									<?php if($ReportDetails[0]->authorised == 1){ ?>
 											<?php $doctor_id = $this->session->userdata('UserDetail_Id');
	                               	 	if(in_array($doctor_id, array_column($AssociateDoctors, 'doctor_id'))){

	                               	?>
	                                    <div class="text-center">
	                                        <button  class="btn btn-outline-danger btn-theme mb-3 ml-5 AddSupplementary">
											 Add supplementary report
											</button>
	                                    </div> <?php }
	                                }?>

	                                    <div id="myDiv"  <?php if(!isset($_GET['snomedempty'])){ ?> style="display:none;" <?php }else{?> style="display:block;" <?php }?> >
	                                    	  <form  method="post" action="<?php echo base_url()?>uploadreport/AddAdditionalReport/<?php echo $patient_details[0]->test_id?>" >
	                                    	<div class="col-md-12 mt-3">
		                                        <div class="form-group ui-widget">
		                                            <label for="tags">Snomed</label> 
		                                           
													<select id="snomedField" class="tokenize-source-demo-2" name="snomed[]" multiple=""  style="display: none;" >
													<?php if(!empty($ReportDetails[0]->snomed)){
														$arrOption = explode("|",$ReportDetails[0]->snomed);
														foreach($arrOption as $option){
													?>
														<option selected value="<?php echo $option?>"><?php echo $option?></option>
													<?php }}?>
													
													</select>
													

													 <?php if(isset($_GET['snomedempty'])){ ?>
		                                            	<p class="text-danger">
					                                        Snomed cannot be empty please add snomed code.
					                                    </p>
		                                            <?php } ?>
		                                        </div>
		                                    </div>

		                                    <div class="row">
												      
														<?php 
															$id = end($this->uri->segment_array());
														?>
												       	 <input type="hidden" class="form-control" name="test_id" value="<?php echo $id?>">
												      <div class="col-lg-12 ">
												      

												       	
												        	 <div class="col-md-12">
						                                        <div class="form-group">
						                                            <label>Title</label> 
						                                            <input type="text" class="form-control" placeholder="Title" name="title" required="">
						                                        </div>
						                                    </div>

						                                     <div class="col-md-12">
						                                        <div class="form-group">
						                                            <label>Report Details</label> 
						                                        <?php /*?>    <textarea class="form-control supply-test" placeholder="Comments" name="comments" rows="5" required=""></textarea> <?php */?>


						                                            <textarea rows="5" name="comments" id="comments" class="form-control resize-open"></textarea>

		                                            <script>
		                                          		CKEDITOR.replace( 'comments', {
			                                                language: 'en',
			                                                removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,About,Styles',
			                                                extraPlugins: 'autogrow'
		                                                });
													</script>

						                                        </div>
						                                    </div>
												      </div>
												      <div class="modal-footer">
												       <!-- <button type="submit"  name="save" value="yes" class="btn btn-outline-danger btn-theme">Save</button>-->
												        <button type="submit"  name="publish" value="yes" class="btn btn-outline-danger btn-theme" onClick='return  confirm("Once you accept this and Authorise and publish the report, you will not be able to edit the report, it will be complete and submitted ");'>Publish</button>
												      </div>
												      
											 	    </div>
											 	</form>

	                                    </div>


	                                    <script>
	                                    		
	                                    		$('.AddSupplementary').click(function() {
													  $('#myDiv').toggle('slow', function() {
													    // Animation complete.
													  });
													});

	                                    </script>

	                                    <?php if(!empty($Additionalreports)){ ?>

	                                    	<?php /*?><table class="table table-striped">
	                                    		<thead>
	                                        <tr>
	                                    	<th>User</th>
	                                    	<th>Title</th>
	                                    	<th>Comments</th>
	                                    	<th>Date</th>
	                                    	
	                                    </tr></thead>
	                                    <tbody>
	                                    	<?php foreach($Additionalreports as $logs){ ?>

	                                    	<tr>
	                                        
	                                        	<td><?php echo $logs->first_name." ".$logs->last_name?></td>
	                                        	<td><?php echo $logs->title?></td>
	                                        	<td><?php echo $logs->Comments?></td>
	                                        	<td><?php $date=date_create($logs->date); echo date_format($date,$dateFormat); ?></td>
	                                        </tr>

	                                    	<?php }?>
	                                       
	                                        
	                                    </tbody>
	                                </table> <?php */?>

	                                	<legend></legend>

	                                	<div class="row">
	                                		<div class="col-md-12 form-group">
	                                			<label>Supplementary Report</label>
	                                		</div>


	                                		<?php foreach($Additionalreports as $logs){ ?>

	                                		<div class="row">
	                                			<div class="container-fluid">

		                                		<div class="col-md-12">
		                                            <div class="form-group">
		                                                <span>Doctor name: </span>
		                                               <label> Dr. <?php echo $logs->first_name." ".$logs->last_name?> </label>
		                                            </div>
		                                        </div>
		                                        <div class="col-md-12">
		                                            <div class="form-group">
		                                                <span>Subject: </span>
		                                               <label> <?php echo $logs->title ;?> </label>
		                                            </div>
		                                        </div>
		                                        <div class="col-md-12">
		                                            <div class="form-group">
		                                                <span>Date: </span>
		                                               <label><?php $date=date_create($logs->date); echo date_format($date,$dateFormat).' '.date_format($date,'H:i a');?> </label>
		                                            </div>
		                                        </div>
		                                        <div class="col-md-12">
		                                            <div class="form-group">
		                                                <span>Report Details: </span><br />
		                                               <label><?php echo $logs->Comments; ?> </label>
		                                            </div>
		                                        </div>
		                                       </div>
		                                    </div>

	                                		<legend></legend>


	                                    <?php }?>

	                                	</div>

	                                     <?php }?>
	                                   
	                            </div>
	                        </div>
	                    </div>

	                    <div class="col-lg-4">
	                    	<div class="card">
	                            <div class="card-header">
	                                <span class="text-theme bootstrap-table pl-0">Patient Details</span>

	                                <?php if($ReportDetails[0]->authorised != 1){?>

	                                <a href="<?php echo base_url();?>admin/EditJob/<?php echo $patient_details[0]->test_id ;?> " class="theme-color text-theme bootstrap-table pl-0 pull-right">Edit Job</a> <?php }?>
	                            </div>
	                            <div class="card-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
	                                             <span>Name: </span><br/>
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
	                                             <span>Age: </span><br/>
	                                             <label>
	                                             <?php 
		                                             $date=$patient_details[0]->DateOfBirth;
													 $date = new DateTime($date);
														 $now = new DateTime();
														 $interval = $now->diff($date);
														 echo  $interval->y;

														 $date = $patient_details[0]->DateOfBirth;
														 $date = date_create($date);
														 $date = date_format($date,$dateFormat); 
 														 echo " (dob: ".$date.")";
 
 
												?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            	 <span>Gender: </span><br/>
                                                 <label><?php echo $patient_details[0]->patientGender?></label>
                                              
                                            </div>
                                        </div>
                                    </div>

                                 <?php /*?>  <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Specimen: </span><br/>
	                                             <label><?php  echo $testName[0]->TestTypeName; ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            	 <span>No of Specimen: </span><br/>
                                                 <label><?php echo $patient_details[0]->no_of_specimen?></label>
                                              
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
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
	                                             <span>Case ref #: </span><br/>
	                                             <label><img src="data:image/png;base64,<?php echo  $patient_details[0]->Client_case_number_barcode?>"></label>
	                                             <label><?php echo $patient_details[0]->Client_case_number?></label>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            	 <span>Visiopath #: </span><br/>
                                                 <label><img src="data:image/png;base64,<?php echo $patient_details[0]->visiopath_case_number_barcode?>"></label>
                                                 <label><?php echo $patient_details[0]->visiopath_number?></label>

                                            </div>
                                        </div>
                                    </div>

                                     <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Hospital number: </span><br/>
	                                             <label><?php echo $patient_details[0]->hospital_number?></label>

                                            </div>
                                        </div>
                                       <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>NHS number: </span><br/>
	                                             <label><?php echo $patient_details[0]->nhs_number?></label>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Date created: </span><br/>
	                                             <label><?php 
	                                             		 $date = $ReportDetails[0]->test_date;
														 $date = date_create($date);
														 $date = date_format($date,$dateFormat); 
 														 echo $date;
 
	                                             ?></label>

                                            </div>
                                        </div>


                                        <?php if(!empty($patient_details[0]->address)){?>
                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Patient address: </span><br/>
	                                             <label><?php echo $patient_details[0]->address?></label>

                                            </div>
                                        </div>
                                    	<?php }?>
                                        
										
										
										
										<div class="col-md-12">
                                            <div class="form-group">
	                                             <span>Specimen: </span><br/>
	                                             <label><?php echo  nl2br($patient_details[0]->specimen_text);?></label>

                                            </div>
                                        </div>
										
										<div class="col-md-12">
                                            <div class="form-group">
	                                             <span>Clinical details: </span><br/>
	                                             <label><?php echo  nl2br($patient_details[0]->clinical_details);?></label>

                                            </div>
                                        </div>
										
										<div class="col-md-12">
                                            <div class="form-group">
	                                             <span>Macroscopic Details: </span><br/>
	                                             <label><?php echo  nl2br($patient_details[0]->macroscopic_details);?>
												 
												 
												 </label>

                                            </div>
                                        </div>
                                        <?php if(!empty($RequestForm)){?>
                                        <div class="col-md-12">
                                            <div class="form-group">
	                                             <span>Request Form: </span><br/>
	                                             <label>
												 <?php 

												 $i = 1;

												 foreach($RequestForm as $file){
												 	$file_name =  explode('/', $file->upload_file); ?>
												 	<?php echo $i.'. ' ;?><a target="_blank" class="theme-color" href="<?php echo base_url().$file->upload_file;?>"><?php echo $file_name[2];?></a><br />
												 <?php	$i++;
												 }

												 ?>
												 
												 </label>

                                            </div>
                                        </div> 
                                    	<?php } ?>
										
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
												        <h5 class="modal-title" id="exampleModalLongTitle" style="display:inline-block">Add supplementary report</h5>
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
												          <span aria-hidden="true">&times;</span>
												        </button>
												      </div>
												       <form  method="post" action="<?php echo base_url()?>uploadreport/AddAdditionalReport/<?php echo $patient_details[0]->test_id?>" >
	<?php 
															$id = end($this->uri->segment_array());
														?>
												       	 <input type="hidden" class="form-control" name="test_id" value="<?php echo $id?>">
												      <div class="modal-body row">
												      

												       	
												        	 <div class="col-md-12">
						                                        <div class="form-group">
						                                            <label>Title</label> 
						                                            <input type="text" class="form-control" placeholder="Title" name="title" required="">
						                                        </div>
						                                    </div>

						                                     <div class="col-md-12">
						                                        <div class="form-group">
						                                            <label>Report Details</label> 
						                                            <textarea class="form-control supply-test" placeholder="Comments" name="comments" rows="5" required=""></textarea>
						                                        </div>
						                                    </div>
												      </div>
												      <div class="modal-footer">
												       <!-- <button type="submit"  name="save" value="yes" class="btn btn-outline-danger btn-theme">Save</button>-->
												        <button type="submit"  name="publish" value="yes" class="btn btn-outline-danger btn-theme" onClick='return  confirm("Once you accept this and Authorise and publish the report, you will not be able to edit the report, it will be complete and submitted ");'>Publish</button>
												      </div>
												       </form>
												    </div>
												  </div>
												</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title d-inline-block" id="exampleModalLabel">SELECT SYNOPSIS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form method="post" action="<?php echo base_url();?>uploadreport/UpdateSpecimenGenerateForm/<?php echo $patient_details[0]->test_id?>">
      	<div class="modal-body">
      	<div class="row">
	      	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	      		<div class="form-group">
		      		<div class="col-lg-4">Report Name: </div>

		      		<div class="col-lg-8">
		      			<input class="form-control" type="text" name="report_name" Placeholder="E.g(Liver Tumor)">
		      		</div>
		      	</div>
	      	</div>

	      	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
	      		<div class="form-group">
		      		<div class="col-lg-4"> Select Synopsis: </div>

		      		<div class="col-lg-8">
		      			<select class="form-control" name="specimen" required="" >
			        		<?php foreach($testTypes as $test){?>
			        			<option value="<?php echo $test->TestTypeId?>"><?php echo $test->TestTypeName?></option>
			        		<?php }?>
			        	</select>
		      		</div>
	      		</div>
	      	</div>
       		
        </div>	
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Generate Form</button>
      </div>
  	</form>
    </div>
  </div>
</div>


<?php if(isset($_GET['authorise'])){?>
	<script>
		$(document).ready(function(){
	   $('html, body').animate({
	        scrollTop: $('#Authorise').offset().top
	    }, 'slow');
	});	

	</script>
<?php }?>

 <?php if($ReportDetails[0]->authorised != 1 ){ ?>

<script type="text/javascript">
/*	function saveEditReport (){
	
}

	setInterval(function(){ 
		var microscopy = $('#MicroscopicField').val();
		var conclusion = $('#ConclusionField').val(); 
		var snomed = $('#snomedField').val();

		$.post( "<?php echo base_url();?>uploadreport/Autosave/<?php echo $patient_details[0]->test_id?>", { microscopy: microscopy,conclusion: conclusion, snomed: snomed })
		  .done(function( data ) {
		   	$('.autosavetext').show();
		   	$('.autosavetext').text('Autosaved');

		   	 $('.autosavetext').delay(2500).fadeOut('slow');
		  });

	}, 60000);*/
</script>
<?php }?>
   <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.js" charset="utf-8"></script>
<script>
	$('.jqte-test').jqte({
       // "css":"example",
        "source":false,
		//"unlink":false,
		//"link":false,
		"indent":false,
		"outdent":false,
		//"sup":false,
		"left":false,
		"center":false,
		"right":false,
		"remove":false,
		"sub":false,
		
		"format":false,
		
      //  "titletext":false
    });
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
	
	$(".jqte-test").bind('paste', function() {
		alert($(this).val());
	});
	
	
	
	$(document).on("paste", ".jqte-test", function(e) {
	e.preventDefault();
	var text = e.originalEvent.clipboardData.getData("text/plain");
	document.execCommand("insertText", false, text);
	$(".jqte_tool_19").click();

});


<?php if($ReportDetails[0]->authorised == 1){?>
$(".jqte_editor").prop('contenteditable','false');
<?php }?>

</script>

<script>
	$('.supply-test').jqte({
       // "css":"example",
        "source":false,
		//"unlink":false,
		//"link":false,
		"indent":false,
		"outdent":false,
		//"sup":false,
		"left":false,
		"center":false,
		"right":false,
		"remove":false,
		"sub":false,
		
		"format":false,
		
      //  "titletext":false
    });
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.supply-test').jqte({"status" : jqteStatus})
	});
	
	$(".supply-test").bind('paste', function() {
		alert($(this).val());
	});
	
	
	
	$(document).on("paste", ".supply-test", function(e) {
	e.preventDefault();
	var text = e.originalEvent.clipboardData.getData("text/plain");
	document.execCommand("insertText", false, text);
	$(".jqte_tool_19").click();

});


	$(document).ready(function(){
           $('.DeleteThisSynopsis').click(function(){ 
           	  var postId = $(this).attr("value");

           	   var res = postId.split("|");

                $.ajax({url: "<?php echo base_url();?>uploadreport/DeleteSynopsisByReportId?ids="+postId, success: function(result){
                $("#button"+res[1]).remove();
                //location.reload();                     
            	}
                  
             });
        });
});




</script>