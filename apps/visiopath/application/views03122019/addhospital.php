<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../../assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Add New Hospital - LIMS</title>

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
	                                <h4 class="card-title">Add New Hospital</h4>
	                               

	                            </div>
	                            <div class="card-content">
	                                <form method="post" action="<?php echo base_url();?>admin/AddNewHospital">
	                                    <div class="row">

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
	                                                <label>Hospital Number</label>
	                                                <input type="text" class="form-control border-input" placeholder="Hospital Number" name="hospital_number" >
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Address</label>
	                                                <input type="text" class="form-control border-input" name="address" placeholder="Hospital Address" >
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Phone Number <span>*</span></label>
	                                                <input type="number" class="form-control border-input" placeholder="Phone Number" name="mobile_number" required="">
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
	      <?php include('partial/footer.php') ?> 
	    </div>
	</div><?php }?>
</body>

	<!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
	<?php include('partial/footerscript.php') ?>

</html>
