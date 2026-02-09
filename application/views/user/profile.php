<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>User Profile | MeweMarket</title>

	<!-- ===============================================-->
	<!--    Favicons-->
	<!-- ===============================================-->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url();?>assets/img/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>assets/img/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/img/favicons/favicon-16x16.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/img/favicons/favicon.ico">
	<link rel="manifest" href="<?php echo base_url();?>assets/img/favicons/manifest.json">
	<meta name="msapplication-TileImage" content="<?php echo base_url();?>assets/img/favicons/mstile-150x150.png">
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
		<?php $this->load->view('partial/sidebar')?>
		<div class="content">
			<?php $this->load->view('partial/header')?>

			<div class="card mb-3">
				<div class="card-header position-relative min-vh-25 mb-7">
					<div class="bg-holder rounded-3 rounded-bottom-0" style="background-image:url(<?php echo base_url();?>assets/img/generic/4.jpg);">
					</div>
					<!--/.bg-holder-->

					<div class="avatar avatar-5xl avatar-profile">
						<img class="rounded-circle img-thumbnail shadow-sm" src="<?php echo base_url();?>assets/img/team/avatar.png" width="200" alt="" />
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-lg-8">
							<h4 class="mb-3"> <?php echo ucfirst($userDetails->user_name);?> </span>
							</h4>
							<p class="fs--1 ">Company: <?php echo $userDetails->company_name; ?></p>
							<p class="fs--1 ">Email: <?php echo $userDetails->user_email; ?></p>
							<p class="fs--1 ">Created On: <?php $date = date_create($userDetails->created_at); echo date_format($date,'d M, y');?></p>

							<div class="border-dashed-bottom my-4 d-lg-none"></div>
						</div>

					</div>
				</div>
			</div>

			<div class="card mt-3">
				<div class="card-header bg-light">
					<div class="row align-items-center">
						<div class="col">
							<h5 class="mb-0" id="followers">Purchases Tools</h5>
						</div>
					</div>
				</div>
				<div class="card-body bg-light p-0">
					<?php
					if(!empty($billing_details)){
						foreach($billing_details as $product){?>
							<div class="col-12 p-3">
								<div class="p-1">
									<div class="row">
										<div class="col-sm-5 col-md-4">
											<div class="position-relative h-sm-100">
												<a class="d-block h-100" href="<?php echo base_url('products/ViewProduct/'.$product->product_id);?>">
													<img class="img-fluid fit-cover w-sm-100 h-sm-100 rounded absolute-sm-centered" src="<?php echo base_url('uploads/products/feature_img/'.$product->featured_image)?>" alt="" /></a>
												<div class="badge badge-pill badge-success position-absolute t-0 r-0 mr-2 mt-2 fs--2 z-index-2">New</div>
											</div>
										</div>
										<div class="col-sm-7 col-md-8">
											<div class="row">
												<div class="col-lg-8">
													<h5 class="mt-3 mt-sm-0">
														<a class="text-dark fs-0 fs-lg-1" href="<?php echo base_url('products/ViewProduct/'.$product->product_id);?>">
															<?php echo $product->product_name;?>
														</a>
													</h5>
													<p class="fs--1 mb-2 mb-md-3">
														<?php echo $product->product_type;?>
													</p>

													<ul class="list-unstyled d-none d-lg-block fs--1">
														<?php $details = explode(PHP_EOL,$product->key_benefits);
														foreach($details as $detail){  if(!empty($detail)){ ?>
															<li>
																<span class="fas fa-circle" data-fa-transform="shrink-12"></span>
																<span class="mb-2 d-inline-block">
													 <?php echo $detail;?>
												  </span>
															</li>
														<?php } }?>
													</ul>
												</div>
												<div class="col-lg-4 d-flex justify-content-between flex-column">
													<div class="text-left">
													</div>
													<div class="mt-md-2">
														<?php if($product->status != 'cancel'){?>
															<a class="btn btn-sm btn-primary d-lg-block mt-2 fs--1" target="_blank" href="<?php echo $product->app_url;?>">
																<span class="fas fa-cart-arrow-down"></span>
																<span class="ml-2 d-none d-md-inline-block Buytext">View</span>
															</a>
														<?php }?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } }else{?>
						<h6 class="px-3 mb-0">You have not purchased any tools.</h6>
					<?php }?>
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

</body>
</html>
