<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Edit Company - LIMS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

     <!-- Bootstrap core CSS     -->
   <?php $this->load->view('partial/head.php') ?>
</head>

<body>
  <?php if(!isset($_GET['appview'])){?>	
	<div class="wrapper">
		<?php $this->load->view('partial/sidebar.php') ?>
	

	    <div class="main-panel">
			<?php $this->load->view('partial/nav.php') ?>

	        <div class="content">	 
	<?php }?>
	            <div class="container-fluid">
	                <div class="row">
	                    
	                    <div class="col-lg-12 col-md-7">
	                        <div class="card">
	                            <div class="card-header">
	                                <h4 class="card-title">Edit Company</h4>
	                               
	                            </div>
	                            <div class="card-content">
	                                <form method="post" enctype="multipart/form-data" action="<?php echo base_url();?>admin/EditCompanyDetails" >

										<legend></legend>

	                                     <div class="row">

	                                     
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Company Name <span>*</span></label>
	                                                <input type="text" class="form-control border-input" placeholder="Company Name" name="company_name" required="" value="<?php echo $CompanyDetails[0]->company_name; ?>">
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Company Email</label>
	                                                <input type="email" class="form-control border-input" placeholder="Company Email" name="company_email" value="<?php echo $CompanyDetails[0]->company_email; ?>">
	                                            </div>
	                                        </div>
	                                    </div>

	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>Company Logo </label>
                                                    <?php if(!empty($CompanyDetails[0]->company_logo)){?>
                                                        <a target="_blank" class="profile_link pull-right text-right" href="<?php echo base_url('assets/uploads/'.$CompanyDetails[0]->company_logo); ?>" >View File </a>
	                                                <?php }?>
	                                                <input type="file" class="form-control border-input" name="company_logo" >
	                                            </div>
	                                        </div>

	                                    </div>

	                                    <div class="text-center">
	                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Save</button>
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
	      <?php $this->load->view('partial/footer.php') ?>
	    </div>
	</div><?php }?>
</body>

	
	<?php $this->load->view('partial/footerscript.php') ?>

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
