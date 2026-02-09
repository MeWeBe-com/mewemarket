<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Edit Doctor- LIMS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

     <!-- Bootstrap core CSS     -->
     <?php $this->load->view('partial/head')?>
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
	                                <h4 class="card-title">Edit Doctor</h4>
	                               
	                            </div>
	                            <div class="card-content">
	                                <form method="post" action="<?php echo base_url();?>admin/updateDoctor/<?php echo $Doctordetails[0]->doctor_id?>" enctype="multipart/form-data">
									
									<input type="hidden" value="<?php echo $Userdetails[0]->id?>" name="user_id">
										
										<legend></legend>

	                                    <div class="row">

	                                    	<?php if(isset($_GET['appview'])){?> <input type="hidden" class="form-control border-input" name="appview" value="yes"> <?php }?>

	                                    	<div class="col-md-12">
	                                    	 	<h4 class="card-title  mt-0">
		                                    		Personal Details:
		                                    	</h4>
	                                    	</div>

	                                    	
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Email: </label>
													 <input type="text" class="form-control border-input" name="email" value="<?php echo $Userdetails[0]->email?>">
	                                            
													
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
	                                                <label>Phone Number (including country code e.g. +447912345678)</label>
	                                                <input type="text" class="form-control border-input" placeholder="Phone Number" name="mobile_number" value="<?php echo $Userdetails[0]->mobile_number?>">
	                                            </div>
	                                        </div>
											
											
	                                    </div>

	                                    <div class="row">
	                                    	<div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Secondary Email</label>
	                                               <input type="text" value="<?php  if(!empty($Doctordetails)){  echo $Doctordetails[0]->secondary_email ;} ?>" class="form-control border-input" name="secondary_email" placeholder="Secondary Email">
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

	                                    	<div class="col-md-12">
	                                    	 	<h4 class="card-title  mt-0">
		                                    		Work Details:
		                                    	</h4>
	                                    	</div>
	                                        
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
	                                                <label>Show Phone Number</label>
	                                                <select  class="form-control border-input" name="show_number">
	                                                	<option value="0" <?php if ($Doctordetails[0]->show_number == 0){?> selected="selected" <?php }?>>No</option>
	                                                	<option value="1" <?php if ($Doctordetails[0]->show_number == 1){?> selected="selected" <?php }?>>Yes</option>
	                                                </select>
	                                            </div>
	                                        </div>

	                                         <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Show Email</label>
	                                                <select  class="form-control border-input" name="show_email">
														<option value="0" <?php if ($Doctordetails[0]->show_email == 0){?> selected="selected" <?php }?>>No</option>
	                                                	<option value="1" <?php if ($Doctordetails[0]->show_email == 1){?> selected="selected" <?php }?>>Yes</option>
	                                                </select>
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
	                                        
	                                      <div class="col-md-12">
	                                            <div class="form-group">
	                                                <label>Admin notes </label>
	                                                <textarea class="form-control border-input" name="notes"> <?php echo $Userdetails[0]->notes?></textarea>
	                                            </div>
	                                        </div>
	                                    
	                                    
	                                    <div class="text-center">
	                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Edit Doctor</button>
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
	      <?php $this->load->view('partial/footer')?>
	    </div>
	</div><?php }?>
</body>

	 <?php $this->load->view('partial/footerscript')?>
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

	</script>

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
