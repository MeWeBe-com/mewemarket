<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>User Purchases | Mewemarket</title>

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
				<div class="col-sm-12 col-xxl-12 pr-sm-2 mb-3 mb-xxl-0">
					<div class="card">
						<div class="card-header d-flex flex-between-center bg-light py-2">
							<h5 class="mb-0">Purchases</h5>
						</div>
						<div class="card-body py-2 px-0">
							<?php
								if(!empty($products)){
							foreach($products as $product){?>
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
															<?php $slug = url_title($product->product_name, 'dash', true); ?>
															<a class="text-dark fs-0 fs-lg-1" href="<?php echo base_url('products/ViewProduct/'.$product->product_id.'/'.$slug);?>">
																<?php echo $product->product_name;?>
															</a>
														</h5>
														<p class="fs--1 mb-2 mb-md-3">
															<a class="text-500" href="#!">
																<?php echo $product->product_type;?>
															</a>
														</p>

														<ul class="list-unstyled d-none d-lg-block fs--1">
															<?php $details = explode(PHP_EOL,$product->key_benefits);
															foreach($details as $detail){ if(!empty($detail)){ ?>
																<li>
																	<span class="mb-2 d-inline-block">
																		 <?php echo $detail;?>
																	</span>
																</li>
															<?php }}?>

															<!--<li>
																<span class="fas fa-circle" data-fa-transform="shrink-12"></span>
																<span class="mb-2 d-inline-block">
																	  <?php /*$browsers = explode('|',$product->compatible_browsers);
																	  foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Compatible Browsers: '.$browser.'" class="badge badge-dark mr-1">'.$browser.'</span>'; } */?>
																  </span>
															</li>
															<li>
																<span class="fas fa-circle" data-fa-transform="shrink-12"></span>
																<span class="mb-2 d-inline-block">
																	  <?php /*$browsers = explode('|',$product->software_framework);
																	  foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Software Framework: '.$browser.'" class="badge badge-dark mr-1">'.$browser.'</span>' ; }*/?>
																  </span>
															</li>
															<li>
																<span class="fas fa-circle" data-fa-transform="shrink-12"></span>
																<span class="mb-2 d-inline-block">
																	  <?php /*$browsers = explode('|',$product->software_version);
																	  foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Software Version: '.$browser.'" class="badge badge-dark mr-1">'.$browser.'</span>' ; }*/?>
																  </span>
															</li>
															<li>
																<span class="fas fa-circle" data-fa-transform="shrink-12"></span>
																<span class="mb-2 d-inline-block">
																	  <?php /*$browsers = explode('|',$product->files_included);
																	  foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Files Included: '.$browser.'" class="badge badge-dark mr-1">'.$browser.'</span>' ; }*/?>
																  </span>
															</li>-->
														</ul>
													</div>
													<div class="col-lg-4 d-flex justify-content-between flex-column">
														<div class="text-left">
															<!--<div class="mb-2 ">
																<span class="fa fa-star <?php /*if($product->rating >= 1){ echo 'text-warning';} */?> "></span>
																<span class="fa fa-star <?php /*if($product->rating >= 2){ echo 'text-warning';} */?> "></span>
																<span class="fa fa-star <?php /*if($product->rating >= 3){ echo 'text-warning';} */?> "></span>
																<span class="fa fa-star <?php /*if($product->rating >= 4){ echo 'text-warning';} */?> "></span>
																<span class="fa fa-star <?php /*if($product->rating >= 5){ echo 'text-warning';} */?> "></span>
																<span class="ml-1">(<?php /*echo $product->rating; */?>)</span>
															</div>-->
															<!--<div class="d-none d-lg-block">
																<p class="fs--1 mb-1 text-center"> <strong><?php /*echo(number_format($product->total_sales));*/?> Sales</strong></p>
																<p class="fs--1 mb-1">Updated on: <strong class=""><?php /*$date = date_create($product->created_at); echo date_format($date,'d M,y');*/?></strong>
																</p>
															</div>-->
															<div class="d-none d-lg-block">
																<p class="fs--1 mb-1">Next Billing: <strong class=""><?php $date = date_create($product->billing_due_date); echo date_format($date,'d M,y');?></strong>
																</p>
															</div>
														</div>
														<div class="mt-md-2">

															<?php if($product->status != 'cancel'){?>
															<a class="btn btn-sm btn-primary d-lg-block mt-2 fs--1" target="_blank" href="<?php echo $product->app_url;?>">
																<span class="fas fa-cart-arrow-down"></span>
																<span class="ml-2 d-none d-md-inline-block Buytext">View</span>
															</a>
															<?php }?>

															<?php  if($product->status == 'activate'){ ?>
																<a class="btn btn-sm btn-success d-lg-block mt-2 fs--1" href="<?php echo base_url('products/ActivateProduct/'.$product->product_id);?>">
																	<span class="fas fa-level-up-alt"></span>
																	<span class="ml-2 d-none d-md-inline-block Buytext">Upgrade</span>
																</a>
															<?php }?>

															<?php  if($product->status == 'activate'){ ?>
																<a class="btn btn-sm btn-warning d-lg-block mt-2 fs--1" href="<?php echo base_url('billing/MySubscription/'.$product->subscription_id.'/'.'suspend'.'/'.$product->product_id);?>">
																	<span class="fas fa-exclamation-triangle"></span>
																	Suspend</a>
																<a class="btn btn-sm btn-danger d-lg-block mt-2 fs--1" href="<?php echo base_url('billing/MySubscription/'.$product->subscription_id.'/'.'cancel'.'/'.$product->product_id);?>">
																	<span class="fas fa-times"></span>
																	Cancel</a>
															<?php }elseif($product->status == 'suspend'){?>
																<a class="btn btn-sm btn-warning d-lg-block mt-2 fs--1" href="<?php echo base_url('billing/MySubscription/'.$product->subscription_id.'/'.'activate'.'/'.$product->product_id);?>">
																	<span class="fas fa-recycle"></span>
																	Re-activate</a>
																<a class="btn btn-sm btn-danger d-lg-block mt-2 fs--1" href="<?php echo base_url('billing/MySubscription/'.$product->subscription_id.'/'.'cancel'.'/'.$product->product_id);?>">
																	<span class="fas fa-times"></span>
																	Cancel
																</a>
															<?php }elseif($product->status == 'cancel'){?>

															<?php } ?>

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
						<div class="card-footer bg-light d-flex justify-content-center">
							<?php echo $pagination; ?>
							<!--<a class="btn btn-sm btn-link btn-block py-2" href="<?php /*echo base_url('category');*/?>">
								View More Tools<span class="fas fa-chevron-right ml-1 fs--2"></span>
							</a>-->
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
<?php $this->load->view('partial/footerscript');
function shortNumber($num)
{
	$units = ['', 'K', 'M', 'B', 'T'];
	for ($i = 0; $num >= 1000; $i++) {
		$num /= 1000;
	}
	return round($num, 1) . $units[$i];
}?>

</body>
</html>
