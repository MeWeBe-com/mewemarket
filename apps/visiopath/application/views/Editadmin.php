<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Edit Admin - LIMS</title>

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
	                                <h4 class="card-title">Edit Admin</h4>
	                               
	                            </div>
	                            <div class="card-content">
	                                <form method="post" action="<?php echo base_url();?>admin/EditAdminDetails/<?php echo $userDetails[0]->id; ?>" >

										<legend></legend>

	                                     <div class="row">

	                                     	<div class="col-lg-12">
	                                     		<h4 class="card-title mt-0">Personal Details: </h4>
	                                     	</div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>First Name <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="First Name" name="first_name" required="" value="<?php echo $userDetails[0]->first_name; ?>">
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Last Name</label>
	                                                <input type="text" class="form-control border-input" placeholder="Last Name" name="last_name" value="<?php echo $userDetails[0]->last_name; ?>">
	                                            </div>
	                                        </div>
	                                    </div>

	                                    <div class="row">

	                                    	
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Email address <span>*</span></label>
	                                                <input type="email" class="form-control border-input" name="email" required="" placeholder="Email Address" value="<?php echo $userDetails[0]->email; ?>">
	                                            </div>
	                                        </div>

	                                         <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Mobile Number (including country code e.g. +447912345678) <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Phone Number" name="mobile_number" required="" value="<?php echo $userDetails[0]->mobile_number; ?>">
	                                            </div>
	                                        </div>
	                                    </div>
	                                   
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Password <span>*</span></label>
	                                                <input type="text" class="form-control border-input" name="password" placeholder="Password" >
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Address</label>
	                                                <input type="text" class="form-control border-input" name="address" placeholder="Home Address" value="<?php echo $userDetails[0]->address; ?>">
	                                            </div>
	                                        </div>
	                                   
	                                    </div>
	                                    <div class="row">
	                                         <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>User Type</label>
	                                                <select name='user_type' class="form-control border-input">
	                                                	<option <?php if($userDetails[0]->user_type == 0){ echo 'selected' ;} ?> value='0'>Admin</option>
	                                                	<option <?php if($userDetails[0]->user_type == 1){ echo 'selected' ;} ?> value='1'>Data Entry</option>
	                                                </select>
	                                            </div>
	                                        </div>
	                                       
	                                    </div>
	                                   
	                                    
	                                    <div class="text-center">
	                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Edit Admin</button>
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
