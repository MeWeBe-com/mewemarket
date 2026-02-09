<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Add New Doctor- LIMS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

     <!-- Bootstrap core CSS     -->
   <?php include('partial/head.php') ?>
</head>

<body>
  <?php if(!isset($_GET['appview'])){?>	
	<div class="wrapper">
		<?php include('partial/sidebar.php') ?>
	

	    <div class="main-panel">
			<?php include('partial/nav.php') ?>

	        <div class="content">	 
	<?php }?>
	            <div class="container-fluid">
	                <div class="row">
	                    
	                    <div class="col-lg-12 col-md-7">
	                        <div class="card">
	                            <div class="card-header">
	                                <h4 class="card-title">Add New Doctor</h4>
	                               
	                            </div>
	                            <div class="card-content">
	                                <form   enctype="multipart/form-data" method="post" <?php if(isset($_GET['appview'])){ ?> action="<?php echo base_url();?>AddDoctor/AddNewDoctor" id="my_form" <?php }else{ ?> action="<?php echo base_url();?>admin/AddNewDoctor" <?php }?> >
	                                    
	                                	 <legend></legend>
	                                    <div class="row">

                                            <input type="hidden" name="company_id" value="<?php echo $this->session->userdata('company_id'); ?>" >


                                            <?php if(isset($_GET['appview'])){ ?> <input type="hidden" class="form-control border-input" name="appview" value="yes"> <?php }?>

	                                    	<?php /*?><div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Username <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Username" name="username" required="">
	                                            </div>
	                                        </div><?php */?>
	                                        <div class="col-md-12">

	                                        	<h4 class="card-title mt-0">
		                                    		Personal Details:
		                                    	</h4>

	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Email address <span>*</span></label>
	                                                <input type="email" class="form-control border-input" name="email" required="" placeholder="Email Address">
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>First Name <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="First Name" name="first_name" required="">
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Last Name</label>
	                                                <input type="text" class="form-control border-input" placeholder="Last Name" name="last_name" >
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Password <span>*</span></label>
	                                                <input type="text" class="form-control border-input" name="password" placeholder="Password" required="">
	                                            </div>
	                                        </div>

	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Phone Number (including country code e.g. +447912345678) <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Phone Number" name="mobile_number" required="">
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Address</label>
	                                                <input type="text" class="form-control border-input" name="address" placeholder="Home Address" >
	                                            </div>
	                                        </div>

	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Secondary Email</label>
	                                               <input type="text" class="form-control border-input" name="secondary_email" placeholder="Secondary Email">
	                                            </div>
	                                        </div>

	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Date Of birth <span></span></label>
	                                                <input type="date" class="form-control border-input datepicker" name="DateOfBirth" placeholder="Date Of birth" >
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Gender</label>
	                                              <select class="form-control border-input" name="gender" required>
	                                              	<option value="male">Male</option>
	                                              	<option value="female">Female</option>
	                                              </select>
	                                            </div>
	                                        </div>
	                                    </div>

	                                    <legend></legend>

	                                    <div class="row">

	                                    	 <div class="col-md-12">
	                                    	 	<h4 class="card-title  mt-0">
		                                    		Work Details:
		                                    	</h4>
	                                    	 </div>

	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>GMC number</label>
	                                                <input type="number" class="form-control border-input" name="gmc_number" >
	                                            </div>
	                                        </div>

	                                         <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Work number</label>
	                                                <input type="number" class="form-control border-input" name="work_number" >
	                                            </div>
	                                        </div>
											
											
	                                        
											
											  <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Show Phone Number</label>
	                                                <select  class="form-control border-input" name="show_number">
	                                             <option value="0" >No</option>
	                                                	<option value="1"  selected="selected" >Yes</option>
	                                                </select>
	                                            </div>
	                                        </div>

	                                         <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Show Email</label>
	                                                <select  class="form-control border-input" name="show_email">
														<option value="0" >No</option>
	                                                	<option value="1"  selected="selected" >Yes</option>
	                                                </select>
	                                            </div>
	                                        </div>

	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Doctor Specialties (Commas seperated)</label>
	                                               <input type="text" class="form-control border-input" value="<?php  if(!empty($Doctordetails)){ echo $Doctordetails[0]->doctor_specialties; } ?>" name="doctor_specialties" placeholder="Doctor Specialties (Commas seperated)">
	                                            </div>
	                                        </div>

	                                        

											<div class="col-md-6">
												<div class="form-group">
													<label>Department</label>
													<input type="text" class="form-control border-input" placeholder="Department" name="department">
												</div>
											</div>

										</div>

										<legend></legend>

										<div class="row">

											<div class="col-md-12">
	                                    	 	<h4 class="card-title  mt-0">
		                                    		Doctor Documents:
		                                    	</h4>
	                                    	</div>
											
											<div class="col-md-12 mb-5">
	                                        	
	                                        	<div class="col-md-3">
	                                <input type="file" class="form-control border-input" name="Doctor_upload[]"  <?php if(!empty($DoctorFiles[0])){?> disabled="disabled" <?php }?> >
	                                        	  <?php if(!empty($DoctorFiles[0])){?>
	                                        	  	<div id="<?php echo $DoctorFiles[0]->doctor_upload_id?>">
	                                        	  		<a class="btn mt-2 btn-theme" href="<?php echo base_url()?><?php echo $DoctorFiles[0]->filename?>">View File</a>
	                                        	  		<a href="javascript:;" class="DelthisFile"  id="<?php echo $DoctorFiles[0]->doctor_upload_id?>" title="Delete this file"> <span class="pull-right mt-4 ti-close"></span> </a>
	                                        	  	</div>
	                                        	  <?php }?>
	                                        	</div>

	                                        	<div class="col-md-3">
	                                        	  <input type="file" class="form-control border-input" name="Doctor_upload[]"  <?php if(!empty($DoctorFiles[1])){?> disabled="disabled" <?php }?> >
	                                        	   <?php if(!empty($DoctorFiles[1])){?><div id="<?php echo $DoctorFiles[1]->doctor_upload_id?>">
	                                        	  		<a class="btn mt-2 btn-theme" href="<?php echo base_url()?><?php echo $DoctorFiles[1]->filename?>">View File</a> 
	                                        	  		<a href="javascript:;" class="DelthisFile"  id="<?php echo $DoctorFiles[1]->doctor_upload_id?>" title="Delete this file"><span class="pull-right mt-4 ti-close"></span> </a>
	                                        	  </div><?php }?>
	                                        	</div>

	                                        	<div class="col-md-3">
	                                        	  <input type="file" class="form-control border-input" name="Doctor_upload[]"  <?php if(!empty($DoctorFiles[2])){?> disabled="disabled" <?php }?> >
	                                        	   <?php if(!empty($DoctorFiles[2])){?><div id="<?php echo $DoctorFiles[2]->doctor_upload_id?>">
	                                        	  		<a class="btn mt-2 btn-theme" href="<?php echo base_url()?><?php echo $DoctorFiles[2]->filename?>">View File</a>
	                                        	  		<a href="javascript:;" class="DelthisFile"  id="<?php echo $DoctorFiles[2]->doctor_upload_id?>" title="Delete this file"><span class="pull-right mt-4 ti-close"></span></a>
	                                        	 </div> <?php }?>
	                                        	</div>

	                                        	<div class="col-md-3">
	                                        	  <input type="file" class="form-control border-input" name="Doctor_upload[]"  <?php if(!empty($DoctorFiles[3])){?> disabled="disabled" <?php }?> >
	                                        	   <?php if(!empty($DoctorFiles[3])){?><div id="<?php echo $DoctorFiles[3]->doctor_upload_id?>">
	                                        	  		<a class="btn mt-2 btn-theme" href="<?php echo base_url()?><?php echo $DoctorFiles[3]->filename?>">View File</a>
	                                        	  		<a href="javascript:;" class="DelthisFile" id="<?php echo $DoctorFiles[3]->doctor_upload_id?>" title="Delete this file"><span class="pull-right mt-4 ti-close"></span></a>
	                                        	  </div><?php }?>
	                                        	</div>
	                                        </div>

	                                    </div>

	                                    <legend></legend>

	                                    <div class="row">
											
	                                      <div class="col-md-12">
	                                            <div class="form-group">
	                                                <label>Admin notes </label>
	                                                <textarea class="form-control border-input" name="notes"></textarea>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    
	                                    <div class="text-center">
	                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Add Doctor</button>
	                                    </div>

	                                    <div id="server-results"></div>
	                                    <div class="clearfix"></div>
	                                </form>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	       <?php if(!isset($_GET['appview'])){?>  
	   		</div>
	      <?php include('partial/footer.php') ?> 
	    </div>
	</div><?php }?>
</body>

	
	<?php include('partial/footerscript.php') ?>

	<script>
		 $("#my_form").submit(function(event){
	            event.preventDefault();  
	            var post_url = $(this).attr("action"); 
	            var request_method = $(this).attr("method"); 
	            var form_data = $(this).serialize();
            
                $.ajax({
                url : post_url,
                type: request_method,
                data : form_data
            }).done(function(response){ //
                $("#server-results").html(response);
                $('#colorbox').hide();
                $('#cboxOverlay').hide();
                
            });
        });

	</script>

</html>
