<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>Support | Mewemarket</title>

	<!-- ===============================================-->
	<!--    Favicons-->
	<!-- ===============================================-->


	<!-- ===============================================-->
	<!--    Stylesheets-->
	<!-- ===============================================-->

	<?php $this->load->view('partial/head') ?>

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
			<div class="row no-gutters">
				<div class="col-lg-12 pr-lg-2">
					<div class="card mb-3">
						<div class="card-header">
							<h5 class="mb-0">Support</h5>
						</div>
						<div class="card-body bg-light">
							<form method="post" class="form-validation" action="<?php echo base_url('users/verifySupport')?>">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="first-name">Full Name *</label>
											<input class="form-control" id="full_name" type="text" name="full_name" value="" required placeholder="Type your full name here">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="last-name">Email *</label>
											<input class="form-control" id="email" type="email" name="email" value="" required placeholder="Type your Email here">
										</div>
									</div>

									<div class="col-lg-12">
										<div class="form-group">
											<label for="street">Subject *</label>
											<input class="form-control" id="subject" type="text" name="subject" value="" required placeholder="Type your subject here">
										</div>
									</div>

									<div class="col-lg-12">
										<div class="form-group">
											<label for="street">Message </label>
											<textarea rows="4"  class="form-control" id="message" type="text" name="message" placeholder="Type your message here"></textarea>
										</div>
									</div>

									<div class="col-lg-12">
										<hr class="border-dashed border-bottom-0">
									</div>

									<div class="col-12 d-flex justify-content-end">
										<button class="btn btn-primary" type="submit">Send </button>
									</div>
								</div>
							</form>
						</div>
					</div>

				</div>

			</div>
			<?php $this->load->view('partial/footer')?>
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
				toastr.success('Thank you for contacting us – we will get back to you soon!');
			});
		});

	</script>
<?php  }?>


</body>

</html>
