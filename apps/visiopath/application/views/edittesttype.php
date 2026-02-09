<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Edit Form - LIMS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


     <!-- Bootstrap core CSS     -->
   
  <?php include('partial/head.php'); ?>

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
	                                <h4 class="card-title">Edit Form</h4>
	                               

	                            </div>
	                            <div class="card-content">
								
	                                <form method="post" action="<?php echo base_url();?>admin/updateTestType/<?php echo $TestType->TestTypeId?>/">
									
	                                 <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Form Name <span>*</span></label>
	                                                <input type="text" class="form-control border-input"  name="TestTypeName" value="<?php echo $TestType->TestTypeName?>">
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Short Name</label>
	                                                <input type="text" class="form-control border-input" name="shortName"   value="<?php echo $TestType->shortName?>">
	                                            </div>
	                                        </div>
											<div class="col-md-12">
	                                            <div class="form-group">
	                                                <label for="exampleInputEmail1">Terms <span>*</span></label>
	                                                <textarea class="form-control border-input" name="terms" required="" rows="15" ><?php echo $TestType->terms?></textarea>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    
	                                    
	                                    
	                                   
										
	                                    <div class="text-center">
	                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Edit Form</button>

	                                        <a href="<?php echo base_url();?>formbuild/EditForm/<?php echo $TestType->TestTypeId?>" class="btn btn-info btn-fill btn-wd">Edit Form Fields</a>
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
