<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">



	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>Payment Completed | MeweMarket</title>

	<?php $this->load->view('partial/head')?>

</head>
<body>

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
	<div class="container" data-layout="container">
		<?php $this->load->view('partial/sidebar')?>
		<div class="content">
			<?php $this->load->view('partial/header')?>

			<div class="row">
				<div class="col-lg-12 col-xxl-5 py-3">
					 <div class="card">
            <div class="card-body overflow-hidden text-center pt-5">
              <div class="row justify-content-center">
                <div class="col-7 col-md-5">
                	<img class="img-fluid " src="<?php echo base_url();?>assets/img/illustrations/shield.png" alt="" />
                </div>
              </div>
              <h3 class="mt-3 font-weight-normal fs-2 mt-md-4 fs-md-3">Thanks for your subscription</h3>
              <p class="lead">Your payment <!--of <strong>$1 USD</strong>--> is completed.<br class="d-none d-md-block" />
              	You will receive a email notification soon.
              </p>
              <div class="row justify-content-center mt-5 mb-4">
                <div class="col-md-7">
                  <a class="btn btn-primary btn-block" href="<?php echo base_url('users/dashboard');?>">Go Back</a>
                </div>
              </div>
            </div>
           
          </div>
				</div>
			</div>
			<?php $this->load->view('partial/footer'); ?>

		</div>
	</div>
</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->

<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<?php $this->load->view('partial/footerscript')?>

<?php if(isset($_GET['Done'])){ ?>

	<script type="text/javascript">

		$(document).ready(function() {
			$(function () {
				// Toastr options
				toastr.options = {
					"debug": false,
					"newestOnTop": false,
					"positionClass": "toast-top-right",
					"closeButton": true,
					"toastClass": "animated  fadeInDown",
				};

				toastr.success('Please check your Email for password reset link.');


			});
		});



	</script>

<?php  }?>

<?php if(isset($_GET['emailnotfound'])){ ?>

	<script type="text/javascript">

		$(document).ready(function() {
			$(function () {
				// Toastr options
				toastr.options = {
					"debug": false,
					"newestOnTop": false,
					"positionClass": "toast-top-right",
					"closeButton": true,
					"toastClass": "animated  fadeInDown",
				};

				toastr.error('Invalid Email Address.');


			});
		});



	</script>

<?php  }?>

<?php if(isset($_GET['notfound'])){ ?>

	<script type="text/javascript">

		$(document).ready(function() {
			$(function () {
				// Toastr options
				toastr.options = {
					"debug": false,
					"newestOnTop": false,
					"positionClass": "toast-top-right",
					"closeButton": true,
					"toastClass": "animated  fadeInDown",
				};

				toastr.error('Please Enter your email again.');


			});
		});



	</script>

<?php  }?>

</body>

</html>
