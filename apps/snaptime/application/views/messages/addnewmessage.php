<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>New Message | Scruffy Dog</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


     <!-- Bootstrap core CSS     -->
  <?php $this->load->view('partial/head.php') ?>
</head>

<body class="perfect-scrollbar-on ">
	<div class="wrapper">
		<?php $this->load->view('partial/sidebar.php') ?>

	    <div class="main-panel">
			<?php $this->load->view('partial/navbar.php') ?>

	        <div class="content pt-3 mt-1">
	            <div class="container-fluid">
	                <div class="row">
	                    
		                <div class="col-md-12 pl-0 pr-0">
		                    <div class="card">
		                    	<div class="card-header project-filter-row">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="card-title tx_bold6 mb-0 pt-2">New Message</h4>
                        </div>
                        
                        
                    </div>
                     
                </div>
                <div class="w-100"><hr class="mb-2"></div>
		                        <form id="allInputsFormValidation" class="form-horizontal pb-4" action="<?php echo base_url()?>messages/SendMessage" method="post" novalidate="">
		                            <div class="card-content">

 		                                <input type="hidden" name="sender" value="<?php echo $this->session->userdata('id')?>" />


										 <?php if(!isset($_GET['id'])){?>
		                                 <fieldset>
		                                    <div class="form-group z-index-20">
		                                        <label class="col-sm-2 control-label">
													Type: 
												</label>
		                                        <div class="col-sm-8"> 
		                                            <select class="form-control selectpicker" name="receiver_role">
														<option value="">Select Type</option>


														<?php if($this->session->userdata('role') == 'Supplier'){?>
															<option value="1">Admin</option>
															<option value="0"> Project Manager</option>
														<?php  }elseif($this->session->userdata('role') == 1){?>
															<option value="0"> Project Manager</option>
															<option value="3"> Supplier</option>
														<?php }elseif($this->session->userdata('role') == 0){?>
															<option value="1">Admin</option>
															<option value="3"> Supplier</option>
														<?php }?>

														<!-- <?php if($this->session->userdata('role') == 1){ ?>
															<option value="0"> Project Manager</option>
															<option value="3"> Supplier</option>
														<?php }?>
														<?php  if($this->session->userdata('role') === 0){ ?>
															<option value="1">Admin</option>
															<option value="3"> Supplier</option>
														<?php }?>
														<?php if($this->session->userdata('role') === 'Supplier'){ ?>
															<option value="1">Admin</option>
															<option value="0"> Project Manager</option>
														<?php }?> -->
													</select>
		                                        </div>
		                                       
		                                    </div>
		                                </fieldset>

		                                <fieldset>
		                                    <div class="form-group custom_select_box">
		                                        <label class="col-sm-2 control-label">
													To: 
												</label>
		                                        <div class="col-sm-8">
		                                            <select name="receiver" id="User" class="form-control selectpicker">
														<option>Select To</option>
													</select>
		                                        </div>
		                                       
		                                    </div>
		                                </fieldset>
				<?php }else{?>
										<fieldset>
		                                    <div class="form-group">
		                                        <label class="col-sm-2 control-label">
													To: 
												</label>
		                                        <div class="col-sm-8" >
		                                           <strong> <?php echo $_GET['name']?></strong>
													<input type="hidden" name="receiver" id="User" value="<?php echo $_GET['id']?>" >
		                                        </div>
		                                       
		                                    </div>
		                                </fieldset>
				<?php }?>
				
				
		                                <fieldset>
		                                    <div class="form-group">
		                                        <label class="col-sm-2 control-label">
													Subject:
												</label>
		                                        <div class="col-sm-8">
		                                            <input class="form-control"
		                                                   type="text"
		                                                   name="title"
		                                                   required="required"
                                                           placeholder="Type Subject"
													/>
		                                        </div>
		                                       
		                                    </div>
		                                </fieldset>

		                                <fieldset>
		                                    <div class="form-group">
		                                        <label class="col-sm-2 control-label">
													Message: 
												</label>
		                                        <div class="col-sm-8">
		                                           <textarea class="form-control" placeholder="Type Your Message Here" rows="5" name="message"></textarea>
		                                        </div>
		                                    </div>
		                                </fieldset>

		                               
		                             
		                            </div>
									<div class="card-footer text-center">
										<button type="submit" class="btn btn-info btn-fill btn-wd bg-color">Send Message</button>
									</div>
		  						</form>
		                    </div>
		                </div>
	                </div>
	            </div>
	        </div>

			<?php $this->load->view('partial/footer.php') ?>
	    </div>
	</div>
</body>

	<!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
	<?php $this->load->view('partial/footerscript.php') ?>

	<script>
		
		$(document).ready(function(){
		   $('.Getuser').change(function(){ 
		        var Typeid = $(this).val();
		        
            $.ajax({url: "<?php echo base_url();?>messages/GetusersByid?Typeid="+Typeid, success: function(result){
				$('#User').empty();
            	var dt = JSON.parse(result); 
            	
            	 $.each(dt, function(key, value) {

                	$('#User').append($("<option></option>").attr("value", value.id).text(value.username));

            	});
            	
			}	 

        });
     });
});

	</script>

    <script type="text/javascript">
        $().ready(function(){
			$('#registerFormValidation').validate();
            $('#loginFormValidation').validate();
            $('#allInputsFormValidation').validate();
        });
    </script>

</html>
