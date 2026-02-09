<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../../assets/img/favicon.png">
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
	                                <form method="post" action="<?php echo base_url();?>setting/UpdateProfile/<?php echo $Userdetails[0]->id ?>" enctype="multipart/form-data">
	                                    <div class="row">

	                                    
	                                        
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Username</label>
	                                                <input type="text" class="form-control border-input" placeholder="Username" name="username" value="<?php echo $Userdetails[0]->username?>">
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Password</label>
	                                                <input type="password" class="form-control border-input" name="password" value="<?php echo $Userdetails[0]->original_password?>">
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>First Name</label>
	                                                <input type="text" class="form-control border-input" name="first_name" value="<?php echo $Userdetails[0]->first_name?>">
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Last Name</label>
	                                                <input type="text" class="form-control border-input" placeholder="Last Name" name="last_name" value="<?php echo $Userdetails[0]->last_name?>">
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Address</label>
	                                                <input type="text" class="form-control border-input" name="address" placeholder="Home Address" value="<?php echo $Userdetails[0]->address?>">
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Phone Number</label>
	                                                <input type="number" class="form-control border-input" placeholder="Phone Number" name="mobile_number" value="<?php echo $Userdetails[0]->mobile_number?>">
	                                            </div>
	                                        </div>
	                                    </div>
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
	                                                	<option value="0">No</option>
	                                                	<option value="1">Yes</option>
	                                                </select>
	                                            </div>
	                                        </div>

	                                         <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Show Email on report</label>
	                                                <select  class="form-control border-input" name="show_email">
	                                                	<option value="1">Yes</option>
	                                                	<option value="0">No</option>
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
	                                                <label>Doctor Specialties (Commas seperated)</label>
	                                               <input type="text" class="form-control border-input" value="<?php  if(!empty($Doctordetails)){ echo $Doctordetails[0]->doctor_specialties; } ?>" name="doctor_specialties" placeholder="Doctor Specialties (Commas seperated)">
	                                            </div>
	                                        </div>

	                                        <div class="col-md-12 mb-5">
	                                        	
	                                        	<h3>Doctor Documents</h3>

	                                        	<div class="col-md-3">
	                                        	  <input type="file" class="form-control border-input" name="Doctor_upload[]" >
	                                        	  <?php if(!empty($DoctorFiles[0])){?>
	                                        	  	<div id="<?php echo $DoctorFiles[0]->doctor_upload_id?>">
	                                        	  		<a class="btn mt-2 btn-theme" href="<?php echo base_url()?><?php echo $DoctorFiles[0]->filename?>">View File</a>
	                                        	  		<a href="javascript:;" class="DelthisFile"  id="<?php echo $DoctorFiles[0]->doctor_upload_id?>" title="Delete this file"> <span class="pull-right mt-4 ti-close"></span> </a>
	                                        	  	</div>
	                                        	  <?php }?>
	                                        	</div>

	                                        	<div class="col-md-3">
	                                        	  <input type="file" class="form-control border-input" name="Doctor_upload[]" >
	                                        	   <?php if(!empty($DoctorFiles[1])){?><div id="<?php echo $DoctorFiles[1]->doctor_upload_id?>">
	                                        	  		<a class="btn mt-2 btn-theme" href="<?php echo base_url()?><?php echo $DoctorFiles[1]->filename?>">View File</a> 
	                                        	  		<a href="javascript:;" class="DelthisFile"  id="<?php echo $DoctorFiles[1]->doctor_upload_id?>" title="Delete this file"><span class="pull-right mt-4 ti-close"></span> </a>
	                                        	  </div><?php }?>
	                                        	</div>

	                                        	<div class="col-md-3">
	                                        	  <input type="file" class="form-control border-input" name="Doctor_upload[]" >
	                                        	   <?php if(!empty($DoctorFiles[2])){?><div id="<?php echo $DoctorFiles[2]->doctor_upload_id?>">
	                                        	  		<a class="btn mt-2 btn-theme" href="<?php echo base_url()?><?php echo $DoctorFiles[2]->filename?>">View File</a>
	                                        	  		<a href="javascript:;" class="DelthisFile"  id="<?php echo $DoctorFiles[2]->doctor_upload_id?>" title="Delete this file"><span class="pull-right mt-4 ti-close"></span></a>
	                                        	 </div> <?php }?>
	                                        	</div>

	                                        	<div class="col-md-3">
	                                        	  <input type="file" class="form-control border-input" name="Doctor_upload[]" >
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
	                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Update Profile</button>
	                                    </div>
	                                    <div class="clearfix"></div>
	                                </form>
	                            </div>
	                        </div>
	                    </div>

	                    <?php if($this->session->userdata('roleId') == 1){?>

	                    <div class="col-lg-12 col-md-7">
	                        <div class="card">
	                            <div class="card-header">
	                                <h4 class="card-title">User Password Reset</h4>
	                               
	                            </div>
	                            <div class="card-content">
	                                <a href="<?php echo base_url()?>admin/SearchUser" class="btn btn-info btn-fill btn-wd">Search User</a>
	                            </div>
	                        </div>
	                    </div>

	                     <div class="col-lg-12 col-md-7">
	                        <div class="card">
	                            <div class="card-header">
	                                <h4 class="card-title">Form Builder</h4>
	                               
	                            </div>
	                            <div class="card-content">
	                                <a href="<?php echo base_url()?>" class="btn btn-info btn-fill btn-wd">Add New Form</a>
	                            </div>
	                        </div>
	                    </div>

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
		      }
		      
		    });
		  });
		});

	</script>

</html>
