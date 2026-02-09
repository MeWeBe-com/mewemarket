<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>User Setting - LIMS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


     <!-- Bootstrap core CSS     -->
   <?php include('partial/head.php') ?>
</head>

<body>
	<div class="wrapper">
		<?php include('partial/sidebar.php') ?>

	    <div class="main-panel">
			<?php include('partial/nav.php') ?>

	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">

	                	<div class="col-lg-12 col-md-7">
	                        <div class="card">
	                            <div class="card-header">
	                                <h4 class="card-title">Edit Profile</h4>
	                            </div>
	                            <div class="card-content">
								 <?php if(isset($_GET['passwordNotMatch'])){?>
									<div class="alert alert-danger mt-1">
										<span><b> Failed - </b> Current password do not match.</span>
									</div>

									<?php }?>

									<?php if(isset($_GET['pincodeNotMatch'])){?>
									<div class="alert alert-danger mt-1">
										<span><b> Failed - </b> Current pincode do not match.</span>
									</div>
									
									
									<?php }?>
									
									<?php if(isset($_GET['newPasswordNotMatch'])){?>
									<div class="alert alert-danger mt-1">
										<span><b> Failed - </b> New password do not match.</span>
									</div>
									
									
									<?php }?>

									<?php if(isset($_GET['newPincodeNotMatch'])){?>
									<div class="alert alert-danger mt-1">
										<span><b> Failed - </b> New password do not match.</span>
									</div>
									
									
									<?php }?>
									
									
									<?php if(isset($_GET['updated'])){?>
									<div class="alert alert-success mt-1">
										<span><b> Success - </b> Profile Updated.</span>
									</div>
									
									
									<?php }?>
	                                <form method="post" action="<?php echo base_url();?>setting/UpdateProfile/<?php echo $Userdetails[0]->id ?>" enctype="multipart/form-data">
	                                    
										
										 <div class="row">
										 	<div class="col-md-12">
	                                            <div class="form-group">
	                                                <label>Email: </label>
													 <input type="text" class="form-control border-input" name="email" readonly="" value="<?php echo $Userdetails[0]->email?>">
	                                            
													
	                                            </div>
	                                        </div>
										
										
											
											</div>

											<legend></legend>
											
											<div class="row">
											<div class="col-md-12">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1"><h4 class="card-title mb-0 mt-0">Change Password: </h4> </label>
	                                               
	                                            </div>
	                                        </div>
											
											<div class="col-md-12">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Current Password</label>
	                                                <input type="password" class="form-control border-input" name="oldpassword" value="" autocomplete="off">
	                                            </div>
	                                        </div>
											<div class="col-md-6">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">New Password</label>
	                                                <input type="password" class="form-control border-input" name="password" value=""  autocomplete="off"> 
	                                            </div>
	                                        </div>
											
											
											<div class="col-md-6">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Confirm New Password</label>
	                                                <input type="password" class="form-control border-input" name="cpassword" value="" aurocomplete="off">
	                                            </div>
	                                        </div>

	                                        </div>

	                                        <?php if($Userdetails[0]->roleId == 3){?> <legend></legend> <?php }?>

	                                        
	                                         <div class="row">
	                                        <?php if($Userdetails[0]->roleId == 3){?>
	                                        	<div class="col-md-12">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1"> <h4 class="card-title mb-0 mt-0">Change Pincode: </h4> </label>
	                                               
	                                            </div>
	                                        </div>
											
											<div class="col-md-12">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Current pincode</label>
	                                                <input type="password" class="form-control border-input" name="oldhospital_pincode" value="" minlength="6" maxlength="6" autocomplete="off">
	                                            </div>
	                                        </div>
											<div class="col-md-6">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">New pincode</label>
	                                                <input type="password" minlength="6" maxlength="6" class="form-control border-input" name="hospital_pincode" value=""  autocomplete="off"> 
	                                            </div>
	                                        </div>
											
											
											<div class="col-md-6">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Confirm New pincode</label>
	                                                <input type="password" minlength="6" maxlength="6" class="form-control border-input" name="chospital_pincode" value="" autocomplete="off">
	                                            </div>
	                                        </div>

	                                        
	                                        <?php }?>

	                                        </div>

	                                        <legend></legend>

	                                        <div class="row">


											<div class="col-md-12">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1"><h4 class="card-title mb-0 mt-0">Personal Details: </h4></label>
	                                               
	                                            </div>
	                                        </div>
										<?php if($Userdetails[0]->roleId == 3){?>	
											
											<div class="col-md-12">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Institute Name</label>
	                                                <input type="text" class="form-control border-input" name="institute_name" value="<?php  echo $Hospitaldetails[0]->hospital_name;?>" placeholder="Institute Name" > 
	                                            </div>
	                                        </div>
											
											<?php /*?><div class="col-md-6">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Hospital Number</label>
	                                                <input type="text" class="form-control border-input" name="hospital_number" value="<?php  echo $Hospitaldetails[0]->hospital_number;?>" placeholder="Institute Name" > 
	                                            </div>
	                                        </div><?php */?>
											
											
										<?php }?>
											</div>
											
											
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Contact Name</label>
	                                                <input type="text" class="form-control border-input" name="first_name" value="<?php echo $Userdetails[0]->first_name?>">
	                                            </div>
	                                        </div>
											<?php if($Userdetails[0]->roleId != 3){?>	
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Last Name</label>
	                                                <input type="text" class="form-control border-input" placeholder="Last Name" name="last_name" value="<?php echo $Userdetails[0]->last_name?>">
	                                            </div>
	                                        </div>
											<?php }?>
	                                    </div>
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Address</label>
	                                                <input type="text" class="form-control border-input" name="address" placeholder="Home Address" value="<?php echo $Userdetails[0]->address?>">
	                                            </div>
	                                        </div>

	                                        <?php if($Userdetails[0]->roleId == 3){?>
		                                        <div class="col-md-6">
		                                            <div class="form-group">
		                                                <label>Phone Number</label>
		                                                <input type="number" class="form-control border-input" placeholder="Phone Number" name="mobile_number" value="<?php echo $Userdetails[0]->mobile_number?>">
		                                            </div>
		                                        </div>

	                                         <?php }?>
	                                    </div>



	                                    <?php if($Userdetails[0]->roleId == 1 || $Userdetails[0]->roleId == 2){?>
	                                    
	                                    <legend></legend>

	                                    <div class="container mr-0 ml-0 pr-0 pl-0">

	                                    <div class="col-md-12 pl-0">
	                                        <div class="form-group">
	                                                <label for="exampleInputEmail1"><strong>Validate your Mobile to receive Verification SMS:</strong> </label>
	                                               
	                                        </div>
	                                    </div>

	                                    <div class="col-md-8 pl-0 col-xs-12">
	                                            <div class="form-group col-md-8 pl-0 col-sm-8 col-xs-10">
	                                                <label>Phone Number (including country code e.g. +447912345678)</label>
	                                                <input type="text" class="form-control border-input" id="mobile_number" placeholder="Phone Number" name="mobile_number" value="<?php echo $Userdetails[0]->mobile_number?>">
	                                                <span class="notValid"></span>
	                                            </div>
	                                            <div class="form-group col-md-3 pl-0 col-sm-4 <?php if($this->agent->is_mobile()){ if($Userdetails[0]->mobile_verified == 1){ echo 'col-xs-2' ; }else{ echo 'col-xs-12' ; }  }?>">
	                                            	<?php if($Userdetails[0]->mobile_verified == 0){?>


	                                            	<button type="button" id="SendValidation" class="mt-4-5 <?php if($this->agent->is_mobile()){ echo "mt-0";  }?> btn btn-outline-danger btn-theme btn-wd">
	                                            		Send Validation Code
	                                            	</button>
	                                            <?php }else{?>
	                                            	<span class="mt-5 d-inline-block">
	                                            		<img class="VerifyImg" src="<?php echo base_url();?>assets/img/success.png" alt="Verified"/>
	                                            	</span> 


	                                            <?php }?>
	                                            </div>
	                                    </div>

	                                    <div class="col-md-8 pl-0" id="ValidationRow" style="display:none">
	                                     	<div class="form-group col-md-6 pl-0">
	                                            <label>Enter Validation Code</label>
	                                            <input type="text" id="ValidationInput" minlength="6" maxlength="6" class="form-control border-input" placeholder="Enter Validation Code">
	                                            <span class="error"></span>
	                                        </div>
	                                        <div class="form-group col-md-3">
	                                            <button type="button" id="CheckCode" class=" <?php if($this->agent->is_mobile()){ echo 'mt-0' ; }else{ echo "mt-4-5" ;}?> btn btn-outline-danger btn-theme btn-wd">
	                                            	Submit
	                                            </button>
	                                           
	                                            </div>
	                                    </div>

	                                    <div class="col-md-8 pl-0 <?php if($Userdetails[0]->mobile_verified == 1){ ?> d-inline-block<?php }?>" id="Codevia" <?php if($Userdetails[0]->mobile_verified == 0){ ?> style="display:none"<?php }?> >
	                                     	<div class="col-md-12 pl-0">
		                                        <div class="form-group">
		                                                <label for="exampleInputEmail1"><strong>Receive Verification Code via:</strong> </label>
		                                        </div>
	                                    	</div>

	                                     	<div class="form-group col-md-4 pl-0">
	                                            <label>Email</label>
	                                            <input type="checkbox" class="form-control border-input w45p" value="1" name="codeviaEmail" <?php if($Userdetails[0]->codeviaEmail == 1){ ?> checked <?php }?> >
	                                        </div>
	                                        <div class="form-group col-md-4 pl-0">
	                                            <label>Mobile</label>
	                                            <input type="checkbox" class="form-control border-input w45p" value="1" name="codeviaSms"  <?php if($Userdetails[0]->codeviaSms == 1){ ?> checked <?php }?>>
	                                        </div>
	                                    </div>

	                                </div>

	                                    <legend></legend>

	                                <?php }?>

	                                    <div class="row">
	                                        

	                                        <?php if($Userdetails[0]->roleId == 2){?>



	                                         <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>GMC number</label>
	                                                <input type="number" class="form-control border-input" name="gmc_number" value="<?php  if(!empty($Doctordetails)){ echo $Doctordetails[0]->gmc_number;  }?>">
	                                            </div>
	                                        </div>

	                                         <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Work number</label>
	                                                <input type="number" class="form-control border-input" name="work_number" value="<?php if(!empty($Doctordetails)){ echo $Doctordetails[0]->work_number ;} ?>">
	                                            </div>
	                                        </div>

	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Show Number on report</label>
	                                                <select  class="form-control border-input" name="show_number">
	                                                	<option value="0" <?php if ($Doctordetails[0]->show_number == 0){?> selected="selected" <?php }?>>No</option>
	                                                	<option value="1" <?php if ($Doctordetails[0]->show_number == 1){?> selected="selected" <?php }?>>Yes</option>
	                                                </select>
	                                            </div>
	                                        </div>

	                                         <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Show Email on report</label>
	                                                <select  class="form-control border-input" name="show_email">
														<option value="0" <?php if ($Doctordetails[0]->show_email == 0){?> selected="selected" <?php }?>>No</option>
	                                                	<option value="1" <?php if ($Doctordetails[0]->show_email == 1){?> selected="selected" <?php }?>>Yes</option>
	                                                </select>
	                                            </div>
	                                        </div>

	                                          <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Secondary Email</label>
	                                               <input type="text" value="<?php  if(!empty($Doctordetails)){  echo $Doctordetails[0]->secondary_email ;} ?>" class="form-control border-input" name="secondary_email" placeholder="Secondary Email">
	                                            </div>
	                                        </div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Department</label>
													<input type="text" class="form-control border-input" placeholder="Department" name="department" value="<?php echo $Doctordetails[0]->department?>">
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
	                                                <label>Gender</label>
	                                                <select  class="form-control border-input" name="gender">
														<option value="male" <?php if ($Doctordetails[0]->gender == "male"){?> selected="selected" <?php }?>>Male</option>
	                                                	<option value="female" <?php if ($Doctordetails[0]->gender == "female"){?> selected="selected" <?php }?>>Female</option>
	                                                </select>
	                                            </div>
	                                        </div>

	                                    </div>

	                                    <legend></legend>

	                                    <div class="row">

	                                        <div class="col-md-12 mb-5">
	                                        	
	                                        	<h4 class="card-title ">Doctor Documents</h4>

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

	                                        <?php }else{?>
	                                       
	                                      <?php }?>
	                                    </div>
	                                    
										<div class="row ">
					                <!--   <div class="col-md-12">
					                      <div class="card-title">
					                        <h3>Alerts</h3>
					                      </div>

					                        <div class="col-md-1 pl-3">
					                          <a href="#" class="text-dark"><i class="nc-icon nc-check-2"></i>  Enable</a>
					                     </div>

					                     <div class="col-md-1 pl-1 text-theme">
					                       <a href="#" class="text-theme"><i class="nc-icon nc-simple-remove"></i> Disable</a> 
					                     </div>
					                   </div>-->
					                   

					                   </div>

					                  

	                                    <div class="text-center">
	                                        <button type="submit" class="btn btn-outline-danger btn-theme btn-wd">Update Profile</button>
	                                    </div>
	                                    <div class="clearfix"></div>
	                                </form>
	                            </div>
	                        </div>
	                    </div>

	                    <?php if($this->session->userdata('roleId') == 1){?>

	                    

	                    <!-- <div class="col-lg-12 col-md-7">
	                        <div class="card">
	                            <div class="card-header">
	                                <h4 class="card-title">Form Builder</h4>
	                               
	                            </div>
	                            <div class="card-content">
	                                <a href="<?php echo base_url()?>" class="btn btn-info btn-fill btn-wd">Add New Form</a>
	                            </div>
	                        </div>
	                    </div>-->

	                <?php }?>
	                </div>
	            </div>
	        </div>

	       <?php include('partial/footer.php') ?>
	    </div>
	</div>
</body>

	<!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
	<?php include('partial/footerscript.php') ?>

	<script>
		
		$(document).ready(function() {
		  $(".DelthisFile").click(function(e) {
		    var id = $(this).attr('id');
		    $.ajax({
		      url: '<?php echo base_url()?>setting/DeleteThisFile?id='+id,
		     
		      success: function(result) {
		        $("#"+id).fadeOut(100);
				$("#"+id).parent().find("input").removeAttr("disabled")
		      }
		      
		    });
		  });
		});

		$(document).ready(function() {
		  $("#SendValidation").on('click',function() {
		    var phoneNumber = $('#mobile_number').val();

		    $.ajax({
		      url: '<?php echo base_url()?>setting/SendValidationCode?id=<?php echo $Userdetails[0]->id?>&phoneNumber='+phoneNumber,
		     
		      success: function(result) {

				if(result == "--Fail--"){
					$('.notValid').html('<span style="color:#AE1A41">Number is not valid for UK</span>')
				}else{
					$("#ValidationRow").fadeIn(100);
		        	$("#SendValidation").hide();
				}


		      /*  $("#ValidationRow").fadeIn(100);
		        $("#SendValidation").hide();*/
		       
		      }
		    });
		  });
		});

</script>



	<script>
		$(document).ready(function() {
		  $("#CheckCode").on('click',function() {
		    var submitCode = $('#ValidationInput').val();
		   
		    $.ajax({
		      		url: '<?php echo base_url()?>setting/checkCode?code='+submitCode,
		     
				      success: function(result) {

				      	if(result == "--done--"){
				        
				        	$.ajax({
				      		  url: '<?php echo base_url()?>setting/UpdateVerifiedStatus?id=<?php echo $Userdetails[0]->id?>',
				     
						      success: function(result) {
						        $("#Codevia").fadeIn(100);
				    			$('#ValidationRow').hide();	
						      }
						    });

						}else{
							$('.error').html('<span style="color:#AE1A41">Code doesnt match</span>')
						}
				      }
			});
		  });
		});

	</script>

</html>
