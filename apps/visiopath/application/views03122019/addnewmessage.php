<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../../assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>New Message - LIMS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


     <!-- Bootstrap core CSS     -->
  <?php include('partial/head.php') ?>
</head>

<body>
	<div class="wrapper">
		<?php include('partial/sidebar.php') ?>

	    <div class="main-panel">
			<?php include('partial/nav.php') ?>

	        <div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    
		                <div class="col-md-12">
		                    <div class="card">
		                        <form id="allInputsFormValidation" class="form-horizontal" action="<?php echo base_url()?>messages/SendMessage" method="post" novalidate="">
		                            <div class="card-content">
		                                <h4 class="card-title">New Message</h4>
		                                <input type="hidden" name="sender" value="<?php echo $this->session->userdata('id')?>" />

		                                 <fieldset>
		                                    <div class="form-group">
		                                        <label class="col-sm-2 control-label">
													Type :
												</label>
		                                        <div class="col-sm-8">
		                                            <select class="form-control Getuser" >
														<option>Select Type</option>
														<option value="2"> Doctor</option>
														<option value="3"> Institute</option>
													</select>
		                                        </div>
		                                       
		                                    </div>
		                                </fieldset>

		                                <fieldset>
		                                    <div class="form-group">
		                                        <label class="col-sm-2 control-label">
													To :
												</label>
		                                        <div class="col-sm-8">
		                                            <select name="receiver" id="User" class="form-control">
														<option>Select Type</option>
													</select>
		                                        </div>
		                                       
		                                    </div>
		                                </fieldset>

		                                <fieldset>
		                                    <div class="form-group">
		                                        <label class="col-sm-2 control-label">
													Subject :
												</label>
		                                        <div class="col-sm-8">
		                                            <input class="form-control"
		                                                   type="text"
		                                                   name="title"
		                                                   required="required"
													/>
		                                        </div>
		                                       
		                                    </div>
		                                </fieldset>

		                                <fieldset>
		                                    <div class="form-group">
		                                        <label class="col-sm-2 control-label">
													Message :
												</label>
		                                        <div class="col-sm-8">
		                                           <textarea class="form-control" placeholder="Your Message Here" rows="3" name="message"></textarea>
		                                        </div>
		                                    </div>
		                                </fieldset>

		                               
		                             
		                            </div>
									<div class="card-footer text-center">
										<button type="submit" class="btn btn-info btn-fill">Submit</button>
									</div>
		  						</form>
		                    </div>
		                </div>
	                </div>
	            </div>
	        </div>

			<?php include('partial/footer.php') ?>
	    </div>
	</div>
</body>

	<!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
	<?php include('partial/footerscript.php') ?>

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
