<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Edit Hospital - LIMS</title>

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
	                                <h4 class="card-title">Edit Hospital</h4>
	                               

	                            </div>
	                            <div class="card-content">
								
	                                <form method="post" action="<?php echo base_url();?>admin/updateHospital/<?php echo $hospital->hospital_id?>/">
									<input type="hidden" value="<?php echo $hospital_user->id?>" name="user_id">
	                                 
									<legend></legend>
	                                 <div class="row">

	                                 	<div class="col-lg-12">
	                                     		<h4 class="card-title mt-0">Institute Details: </h4>
	                                     	</div>

	                                        <div class="col-md-12">
	                                            <div class="form-group">
	                                                <label>Institute Name <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Institute Name" name="institute_name" value="<?php echo $hospital->hospital_name?>">
	                                            </div>
	                                        </div>
	                                        <?php /*?><div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Last Name</label>
	                                                <input type="text" class="form-control border-input" name="last_name"   value="<?php echo $hospital_user->last_name?>">
	                                            </div>
	                                        </div><?php */?>
	                                    </div>
	                                    <div class="row">
										<div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Contact Name <span>*</span></label>
	                                                <input type="text" class="form-control border-input"  name="first_name" value="<?php echo $hospital_user->first_name?>">
	                                            </div>
	                                        </div>
	                                        
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Email address</label>
	                                                <input type="text" class="form-control border-input" placeholder="Email Address" name="emai" readonly=""  value="<?php echo $hospital_user->email?>">
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Password <span>*</span></label>
	                                                <input type="password" class="form-control border-input" name="password"  onfocus="this.value=''"  placeholder="Password" value="password">
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Phone Number <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Phone Number" name="mobile_number" value="<?php echo $hospital->phone?>">
	                                            </div>
	                                        </div>
	                                    </div>

	                                     <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Hospital Pin <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Pincode" name="hospital_pincode" required="" value="<?php echo $hospital->hospital_pincode?>" >
	                                            </div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-12">
	                                            <div class="form-group">
	                                                <label>Address</label>
	                                                <input type="text" class="form-control border-input" name="address" placeholder="Hospital Address" value="<?php echo $hospital->address?>" >
	                                            </div>
	                                        </div>
	                                        
											<div class="col-md-12">
	                                            <div class="form-group">
	                                                <label>Admin notes </label>
	                                                <textarea class="form-control border-input" name="notes" ><?php echo $hospital_user->notes?></textarea>
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
	                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Edit Hospital</button>
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
	</div><?php }?>
</body>

	<!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
	 <?php $this->load->view('partial/footerscript')?>

</html>
