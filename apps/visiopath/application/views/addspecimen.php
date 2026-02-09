<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Add New Form - LIMS</title>

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
	                                <h4 class="card-title">Add New Form</h4>
	                               
	                            </div>
	                            <div class="card-content">
	                                <form method="post" action="<?php echo base_url();?>admin/AddNewTestType" >
	                                    <div class="row">

	                                    	<div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Form Name <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Test Type Name" name="TestTypeName" required="">
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Short Name <span>*</span></label>
	                                                <input type="text" class="form-control border-input" name="shortName" required="" placeholder="Short Name">
	                                            </div>
	                                        </div>
											<div class="col-md-12">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Terms <span>*</span></label>
	                                                <textarea class="form-control border-input" name="terms" required="" rows="15" ></textarea>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    
	                                  
	                                   
	                                    
	                                    <div class="text-center">
	                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Add Form</button>
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
	            var post_url = $(this).attr("acti