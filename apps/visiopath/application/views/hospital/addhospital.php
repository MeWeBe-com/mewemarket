<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Add New Hospital - LIMS</title>

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
	                                <h4 class="card-title">Add New Hospital</h4>
	                               

	                            </div>
	                            <div class="card-content">
								<?php if(!isset($_GET['appview'])){?>
	                                <form method="post" action="<?php echo base_url();?>admin/AddNewHospital"  >
								<?php }else{?>
								    <form method="post" action="<?php echo base_url();?>admin/AddNewHospital/json" id="my_form" >
								<?php }?>

									<legend></legend>
	                                    <div class="row">
                                            <input type="hidden" name="company_id" value="<?php echo $this->session->userdata('company_id'); ?>" >

	                                    	<div class="col-lg-12">
	                                     		<h4 class="card-title mt-0">Institute Details: </h4>
	                                     	</div>

	                                    	<?php /*?><div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Username <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Username" name="username" required="">
	                                            </div>
	                                        </div><?php */?>
	                                        <div class="col-md-12">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Email address <span>*</span></label>
	                                                <input type="email" class="form-control border-input" name="email" required="" placeholder="Email Address">
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Institute Name <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Institute Name" name="hospital_name" required="">
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Contact Name</label>
	                                                <input type="text" class="form-control border-input" placeholder="Contact Name" name="first_name" >
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
	                                                <label>Phone Number <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Phone Number" name="mobile_number" required="">
	                                            </div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Hospital Pin <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Pincode" name="hospital_pincode" minlength="6" maxlength="6" required="">
	                                            </div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-12">
	                                            <div class="form-group">
	                                                <label>Address</label>
	                                                <input type="text" class="form-control border-input" name="address" placeholder="Hospital Address" >
	                                            </div>
	                                        </div>
	                                        
											<div class="col-md-12">
	                                            <div class="form-group">
	                                                <label>Admin notes </label>
	                                                <textarea class="form-control border-input" name="notes" ></textarea>
	                                            </div>
	                                        </div>
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
	                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Add Hospital</button>
	                                    </div>
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
	</div><?php }else{?>
	
	<script>
		 $("#my_form").submit(function(event){
	            event.preventDefault();  
	            var post_url = $(this).attr("action"); 
	            var request_method = $(this).attr("method"); 
	            var form_data = $(this).serialize();
            
                $.ajax({
                url : post_url,
				
                type: request_method,
                data : form_data,
				dataType: "json"
            }).done(function(response){ //
				let dropdown = $('#Rinstitute');

				dropdown.empty();
				
				dropdown.append('<option disabled>Select institute</option>');
				dropdown.prop('selectedIndex', 0);
				
				  $.each(response, function (key, entry) {
				  
					dropdown.append('<option value="'+entry.hospital_id+'">'+entry.hospital_name+'</option>');
				  });
                //$("#server-results").html(response);
                $('#colorbox').hide();
                $('#cboxOverlay').hide();
                
            });
        });

	</script>
	
	<?php }?>
</body>

	<!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
	 <?php $this->load->view('partial/footerscript')?>

</html>
