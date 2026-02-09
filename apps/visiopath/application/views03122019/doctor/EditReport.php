<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../../assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Edit Report Details - LIMS</title>

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
	                                <h4 class="card-title">Report Details</h4>
	                            </div>
	                            <div class="card-content">
	                                <?php echo form_open_multipart('uploadreport/EditDetailReport/'.$patient_details[0]->test_id.'');?>
	                                    <div class="row">

	                                    	<?php  

	                                    	if($ReportDetails[0]->authorised != 1){?>

	                                    	  <a class="btn btn-outline-danger btn-theme mb-3 ml-5" href="<?php echo base_url()?>uploadreport/GetForm/<?php echo $patient_details[0]->test_id?>">
	                                    	  	<span>Add synopsis</span>
	                                    	  </a>
	                                    	   
	                                    	<?php }

	                                    	

	                                    	if($ReportDetails[0]->authorised = 1){ ?>

	                                    	 <a class="btn btn-outline-danger btn-theme mb-3 ml-5" href="https://www.reviewschef.com/lims_system/hospital/ViewReport/<?php echo $patient_details[0]->test_id?>" >
	                                    	  	<span>View report</span>
	                                    	  </a>

	                                    	 <?php }?>

		                                    <input type="hidden" name="test_id" value="<?php echo $patient_details[0]->test_id?>">
		                                    <input type="hidden" name="patient_id" value="<?php echo $patient_details[0]->patient_id?>">

		                                      <div class="col-md-12">
		                                        <div class="form-group">
		                                            <label>Microscopy</label>
		                                            <textarea name="microscopy" class="form-control"><?php if(!empty($ReportDetails[0]->microscopy)){?> <?php echo $ReportDetails[0]->microscopy ;}?>
		                                            </textarea>
		                                        </div>
		                                    </div>


		                                    <?php if($ReportDetails[0]->authorised == 1){?>
		                                        
		                                    <div class="col-md-12">
		                                        <div class="form-group">
		                                            <label>Supplementary report</label>
		                                            <textarea name="additional_comment" class="form-control"><?php if(!empty($ReportDetails[0]->additional_comment)){?> <?php echo $ReportDetails[0]->additional_comment ;}?></textarea>
		                                        </div>
		                                    </div>

		                                <?php }?>
	                                        
	                                    </div>

	                                     <div class="row">
	                                     	
	                                     	<?php if(!empty($error)){
	                                     		echo "Please select the correct Format file";
	                                     		}?>

		                                    <div class="col-md-12">
		                                        <div class="form-group">
		                                            <label>Attach file</label>
		                                            <input value=" <?php echo $ReportDetails[0]->attach_file ?>" type="file" name="attach_file">
		                                        </div>
		                                    </div>

		                                    <?php if($ReportDetails[0]->authorised != 1){?>

		                                     <div class="col-md-12">
		                                        <div class="form-group">
		                                            <label>Authorise and publish  </label> <input class="authorised" type="checkbox" value="1" name="authorised">
		                                        </div>
		                                    </div>

		                                      <script>
	                                    		
	                                    		$(document).ready(function(){
												   $('.authorised').change(function(){ 
												        if($(this).is(":checked")){
												            if(confirm("Once submitted you will not be able to edit this Report")){
														       return true;
														   }
														    else{
														        return false;
														  }  
														}   

														      
												            
												     });
												});

	                                    </script>

		                                	<?php }?>
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-12">
	                                            <div class="form-group">
	                                                <span>Last authorised by :</span>
	                                               <label> <?php echo $this->session->userdata('username')?> </label>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-12">
	                                            <div class="form-group">
	                                                <span>Last update by :</span>
	                                               <label> <?php echo $this->session->userdata('username')?> </label>
	                                            </div>
	                                        </div>
	                                         <div class="col-md-12">
	                                            <div class="form-group">
	                                                <span>Last updated on : </span>
	                                                <label><?php echo $ReportDetails[0]->update_time ;?>  </label>
	                                            </div>
	                                        </div>
	                                    </div>
	                                   
	                                
	                                    <div class="text-center">
	                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Save</button>
	                                    </div>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Name :</span><br/>
	                                             <label><?php

	                                               $name = explode(" ", $patient_details[0]->patient_name);


	                                              echo  ucfirst($name[0])?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            	 <span>SurName :</span><br/>
                                                 <label><?php echo ucfirst($name[1]) ?></label>
                                              
                                            </div>
                                        </div>
                                    </div>

                                     <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Date of birth :</span><br/>
	                                             <label>
	                                             <?php 
		                                             $date=date_create($patient_details[0]->DateOfBirth);
													 echo date_format($date,"d-m-Y");
												?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            	 <span>Case reference number :</span><br/>
                                                 <label><?php echo $patient_details[0]->Client_case_number?></label>
                                              
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
	                                             <span>Specimen :</span><br/>
	                                             <label><?php 

	                                               foreach($testTypes as $type){ 
                                                            if($type->TestTypeId == $patient_details[0]->specimen ){
                                                                echo $type->TestTypeName;
                                                            }
                                                        } ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            	 <span>No of Specimen :</span><br/>
                                                 <label><?php echo $patient_details[0]->no_of_specimen?></label>
                                              
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

</html>

