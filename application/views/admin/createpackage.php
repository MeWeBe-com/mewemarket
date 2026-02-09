<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>Create Package | MeweMarket</title>

	<!-- ===============================================-->
	<!--    Favicons-->
	<!-- ===============================================-->
	<link rel="apple-touch-icon" sizes="180x180" href="../assets/img/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicons/favicon-16x16.png">
	<link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicons/favicon.ico">
	<link rel="manifest" href="../assets/img/favicons/manifest.json">
	<meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
	<meta name="theme-color" content="#ffffff">

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

		<?php $this->load->view('admin/sidebar')?>
		<div class="content">
			<?php $this->load->view('admin/topbar')?>
			<div class="row no-gutters">
				<div class="col-md-12 col-xxl-12 mb-3 pr-md-2">
					<div class="card mb-3">
						<div class="card-header">
							<h5 class="mb-0">Add Package</h5>
						</div>
						<div class="card-body bg-light">
							<form method="POST" action="<?php echo base_url('admin/AddPackage')?>">
								<input class="form-control"
									   type="hidden"
									   name="package_id"
									   value="<?php if(!empty($package[0]->package_id)){ echo $package[0]->package_id; } ?>">
								<div class="form-row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="event-name">
												Package Title
											</label>
											<input class="form-control"
												   id="event-name"
												   type="text"
												   name="package_name"
												   placeholder="Package Title"
												   value="<?php if(!empty($package[0]->package_name)){ echo $package[0]->package_name; } ?>">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="package-duration">
												Package Duration
											</label>
											<input class="form-control"
												   id="package-duration"
												   name="package_duration"
												   type="text"
												   placeholder="Month,Quater,Half Year,Year"
												   value="<?php if(!empty($package[0]->package_duration)){ echo $package[0]->package_duration; } ?>"></div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="package-amount">
												Package Amount
											</label>
											<input class="form-control"
												   id="package-amount"
												   name="package_amount"
												   type="text"
												   placeholder="Package Amount"
												   value="<?php if(!empty($package[0]->package_amount)){ echo $package[0]->package_amount; } ?>"></div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="Visibility">
												Visibility
											</label> <br />
											<div class="custom-control custom-radio custom-control-inline">
												<input class="custom-control-input"
													   id="visible"
													   type="radio"
													   name="visibility"
													   <?php if(empty($package[0]->visibility) || $package[0]->visibility == 1 ){ echo 'checked'; }?>
													   value="1">
												<label class="custom-control-label" for="visible">Visible</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input class="custom-control-input"
													   id="hidden"
													   type="radio"
													   name="visibility"
													   value="0"
														<?php if(!empty($package[0]->visibility) && $package[0]->visibility == 0){ echo 'checked'; }?>>
												<label class="custom-control-label" for="hidden">Hidden</label>
											</div>

										</div>
									</div>

									<div class="col-12">
										<hr class="border-dashed border-bottom-0">
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<label for="user_limit">
												Max Users
											</label>
											<input class="form-control"
												   id="user_limit"
												   name="user_limit"
												   type="text"
												   placeholder="10"
												   value="<?php if(!empty($package[0]->user_limit)){ echo $package[0]->user_limit; } ?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="tools_limit">
												Max Tools
											</label>
											<input class="form-control"
												   id="tools_limit"
												   name="tools_limit"
												   type="text"
												   placeholder="20"
												   value="<?php if(!empty($package[0]->tools_limit)){ echo $package[0]->tools_limit; } ?>"></div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="reports">
												Max Reports
											</label>
											<input class="form-control"
												   id="reports"
												   name="reports"
												   type="text"
												   placeholder="2"
												   value="<?php if(!empty($package[0]->reports)){ echo $package[0]->reports; } ?>"></div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label for="event-description">
												Description
											</label>
											<textarea name="package_description"
													  class="form-control"
													  id="event-description"
													  rows="6"><?php if(!empty($package[0]->package_description)){ echo $package[0]->package_description; } ?></textarea>
										</div>
									</div>
									<div class="col-12 d-flex justify-content-end">
										<button class="btn btn-primary" type="submit">Save </button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<?php $this->load->view('admin/footer')?>
		</div>
		<div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog" aria-labelledby="authentication-modal-label" aria-hidden="true">
			<div class="modal-dialog mt-6" role="document">
				<div class="modal-content border-0">
					<div class="modal-header px-5 text-white position-relative modal-shape-header">
						<div class="position-relative z-index-1">
							<div>
								<h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>
								<p class="fs--1 mb-0">Please create your free Falcon account</p>
							</div>
						</div>
						<button class="close text-white position-absolute t-0 r-0 mt-1 mr-1" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body py-4 px-5">
						<form>
							<div class="form-group">
								<label for="modal-auth-name">Name</label>
								<input class="form-control" type="text" id="modal-auth-name" />
							</div>
							<div class="form-group">
								<label for="modal-auth-email">Email address</label>
								<input class="form-control" type="email" id="modal-auth-email" />
							</div>
							<div class="form-row">
								<div class="form-group col-6">
									<label for="modal-auth-password">Password</label>
									<input class="form-control" type="password" id="modal-auth-password" />
								</div>
								<div class="form-group col-6">
									<label for="modal-auth-confirm-password">Confirm Password</label>
									<input class="form-control" type="password" id="modal-auth-confirm-password" />
								</div>
							</div>
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="modal-auth-register-checkbox" />
								<label class="custom-control-label" for="modal-auth-register-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
							</div>
							<div class="form-group">
								<button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Register</button>
							</div>
						</form>
						<div class="w-100 position-relative mt-5">
							<hr class="text-300" />
							<div class="position-absolute absolute-centered t-0 px-3 bg-white text-sans-serif fs--1 text-500 text-nowrap">or register with</div>
						</div>
						<div class="form-group mb-0">
							<div class="row no-gutters">
								<div class="col-sm-6 pr-sm-1"><a class="btn btn-outline-google-plus btn-sm btn-block mt-2" href="#"><span class="fab fa-google-plus-g mr-2" data-fa-transform="grow-8"></span> google</a></div>
								<div class="col-sm-6 pl-sm-1"><a class="btn btn-outline-facebook btn-sm btn-block mt-2" href="#"><span class="fab fa-facebook-square mr-2" data-fa-transform="grow-8"></span> facebook</a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="toast bg-white notice" id="cookie-notice" role="alert" data-options='{"autoShow":false,"autoShowDelay":3000,"showOnce":true,"cookieExpireTime":7200000}' data-autohide="false" aria-live="assertive" aria-atomic="true">
			<div class="toast-body d-flex justify-content-center px-5">
				<div class="d-lg-flex align-items-center text-center">
					<button class="close text-shadow-none position-absolute t-0 r-0 p-2 mr-2 mt-2" type="button" data-dismiss="toast" aria-label="Close"><span class="font-weight-medium" aria-hidden="true">×</span></button><img class="mr-2" src="../assets/img/icons/cookie.png" width="20" alt="" />
					<p class="mb-2 mb-lg-0">
						Our site uses cookies. By continuing to use our site, you agree to our <a class="text-underline" href="../components/cookie-notice.html">Cookie Policy</a>.</p>
					<button class="btn btn-primary btn-sm ml-3" type="button" data-dismiss="toast" aria-label="Close">Ok, I Understand</button>
				</div>
			</div>
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

</body>

</html>
