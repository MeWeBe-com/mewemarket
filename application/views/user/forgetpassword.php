<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">




	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>Forget Password | MeweMarket</title>


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
					<div class="card overflow-hidden z-index-1">
						<div class="card-body p-0">
							<div class="row no-gutters h-100">
								<div class="col-md-5 text-white text-center bg-card-gradient">
									<div class="position-relative p-4 pt-md-5 pb-md-7">
										<div class="bg-holder bg-auth-card-shape" style="background-image:url(<?php echo base_url();?>assets/img/illustrations/half-circle.png);">
										</div>
										<!--/.bg-holder-->
										<div class="z-index-1 position-relative">
											<a class="text-white mb-4 text-sans-serif font-weight-extra-bold fs-4 d-inline-block" href="<?php echo base_url();?>">
												<img class="mr-2" src="<?php echo base_url();?>assets/img/illustrations/logo.png" alt="" width="140" />
											</a>
											<p class="text-white opacity-75">With the power of Falcon, you can now focus only on functionaries for your digital products, while leaving the UI design on us!</p>
										</div>
									</div>
									<div class="mt-3 mb-4 mt-md-4 mb-md-5">
										<p class="mb-0 mt-4 mt-md-5 fs--1 font-weight-semi-bold text-white opacity-75">Read our <a class="text-underline text-white" href="#!">terms</a> and <a class="text-underline text-white" href="#!">conditions </a></p>
									</div>
								</div>
								<div class="col-md-7 d-flex flex-center">
									<div class="p-4 p-md-5 flex-grow-1">
										<div class="text-center text-md-left">
											<h4 class="mb-0"> Forgot your password?</h4>
											<p class="mb-4">Enter your email and we'll send you a reset link.</p>
										</div>
										<div class="row justify-content-center">
											<div class="col-sm-8 col-md">
												<form class="mb-3" action="<?php echo base_url();?>users/VerifyEmailPassword" method="post">
													<div class="form-group">
														<input class="form-control" type="email" name="user_email" required placeholder="Email address" />
													</div>
													<div class="form-group">
														<button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Send reset link</button>
													</div>
												</form><a class="fs--1 text-600" href="<?php echo base_url();?>">I can't recover my account using this page<span class="d-inline-block ml-1">&rarr;</span></a>
											</div>
										</div>
									</div>
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
