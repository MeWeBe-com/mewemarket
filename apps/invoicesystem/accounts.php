<?php 
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['first_name'])) {
	$invoice->updateUser($_POST,$_FILES);
	echo '<script type="text/javascript">
           window.location = "invoice_list.php"
      </script>';
}
	$UserValues = $invoice->getUser();
?>
<title>Invoice Generator</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container content-invoice">
    	<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="" enctype="multipart/form-data">
	    	<div class="load-animate animated fadeInUp">
		    	<div class="row">
		    		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		    			<h1 class="title">Invoice Generator</h1>
						<?php include('menu.php');?>			
		    		</div>		    		
		    	</div>
                <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                        <div class="form-group">
                            <label>Company Name</label>
                            <input value="<?php echo $UserValues['company_name']; ?>" required type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name" autocomplete="off">
                        </div>
                    </div>

		      		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		      			<div class="form-group">
                            <label>First Name</label>
							<input value="<?php echo $UserValues['first_name']; ?>" required type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" autocomplete="off">
						</div>
		      		</div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input value="<?php echo $UserValues['last_name']; ?>" required type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" autocomplete="off">
                        </div>
                    </div>
		      	</div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input value="<?php echo $UserValues['mobile']; ?>" required type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input value="<?php echo $UserValues['email']; ?>" required type="text" class="form-control" name="email" id="email" placeholder="Email Address" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Address</label>
                            <input value="<?php echo $UserValues['address']; ?>"  required type="text" class="form-control" name="address" id="address" placeholder="Address" autocomplete="off">
                        </div>
                    </div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
							<label>Background Color</label>
							<input value="<?php echo $UserValues['color']; ?>"  required type="color" class="form-control" name="color" id="color" placeholder="Color" autocomplete="off">
						</div>
					</div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Upload Logo</label>
                            <input type="file" class="form-control" name="logo" id="logo" value="<?php echo $UserValues['logo']; ?>">
                        </div>
                    </div>

					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<?php if(!empty($UserValues['logo'])){ ?>
								<img src="images/logo/<?php echo $UserValues['logo']; ?>" width="200" />
							<?php }?>
					</div>
                </div>

		      	<div class="row">	
		      		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<div class="form-group">
							<input data-loading-text="Updating User ..." type="submit" name="invoice_btn" value="Save User" class="btn btn-success submit_btn invoice-save-btm">
			      		</div>
		      		</div>
		      	</div>
		      	<div class="clearfix"></div>		      	
	      	</div>
		</form>			
    </div>
</div>	
<?php include('footer.php');?>
