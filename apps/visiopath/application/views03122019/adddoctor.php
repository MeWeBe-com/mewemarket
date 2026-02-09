<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../../assets/img/favicon.png">
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
	                                <form method="post" <?php if(isset($_GET['appview'])){ ?> action="<?php echo base_url();?>AddDoctor/AddNewDoctor" id="my_form" <?php }else{ ?> action="<?php echo base_url();?>admin/AddNewDoctor" <?}?> >
	                                    <div class="row">

	                                    	<?php if(isset($_GET['appview'])){?> <input type="hidden" class="form-control border-input" name="appview" value="yes"> <?php }?>

	                                    	<div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Username <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Username" name="username" required="">
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
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
	                                                <label>Dr. Department</label>
	                                                <input type="text" class="form-control border-input" placeholder="Department Name" name="department" >
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
	                                                <label>Phone Number <span>*</span></label>
	                                                <input type="number" class="form-control border-input" placeholder="Phone Number" name="mobile_number" required="">
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Date Of birth <span>*</span></label>
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
