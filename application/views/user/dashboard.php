<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>User Dashboard | MeweMarket</title>

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
			<div class="row no-gutters">
				<div class="col-md-4 col-xxl-3 mb-3 pr-md-2 pl-xxl-2">
					<div class="card h-md-100">
						<div class="card-body">
							<div class="row h-100 justify-content-between no-gutters">
								<div class="col-5 col-sm-7 col-xxl pr-2">
									<h6 class="mt-1">Activated Tools</h6>
									<div class="fs--2 mt-3">
										<div class="d-flex flex-between-center mb-1">
											<div class="d-flex align-items-center">
												<span class="font-weight-semi-bold fs-0">
													<?php echo $ActivateTools->Total?>
												</span>
											</div>

										</div>

									</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-cart-arrow-down fs-7 mr-3 text-success"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-xxl-3 mb-3 pr-md-2 pl-xxl-2">
					<div class="card h-md-100">
						<div class="card-body">
							<div class="row h-100 justify-content-between no-gutters">
								<div class="col-5 col-sm-7 col-xxl pr-2">
									<h6 class="mt-1">Suspended Tools</h6>
									<div class="fs--2 mt-3">
										<div class="d-flex flex-between-center mb-1">
											<div class="d-flex align-items-center">
												<span class="font-weight-semi-bold fs-0">
													<?php echo $SuspendTools->Total?>
												</span>
											</div>

										</div>

									</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-exclamation-triangle fs-7 mr-3 text-warning"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-xxl-3 mb-3 pr-md-2 pl-xxl-2">
					<div class="card h-md-100">
						<div class="card-body">
							<div class="row h-100 justify-content-between no-gutters">
								<div class="col-5 col-sm-7 col-xxl pr-2">
									<h6 class="mt-1">Cancelled Tools</h6>
									<div class="fs--2 mt-3">
										<div class="d-flex flex-between-center mb-1">
											<div class="d-flex align-items-center">
												<span class="font-weight-semi-bold fs-0">
													<?php echo $CancelTools->Total;?>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-times  fs-7 mr-3 text-danger"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row no-gutters">
				<div class="col-sm-12 col-xxl-12 pr-sm-2 mb-3 mb-xxl-0">
					<div class="card">
						<div class="card-header d-flex flex-between-center bg-light py-2">
							<h5 class="mb-0">Purchase Tools</h5>
						</div>
						<div class="card-body py-2 px-0">
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
																		<span class="mb-2 d-inline-block">
													 <?php echo $detail;?>
												  </span>
																	</li>
																<?php } }?>
<!--																<li>-->
<!--																	<span class="fas fa-circle" data-fa-transform="shrink-12"></span>-->
<!--																	<span class="mb-2 d-inline-block">-->
<!--																	  --><?php //$browsers = explode('|',$product->compatible_browsers);
//																	  foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Compatible Browsers: '.$browser.'" class="badge badge-dark mr-1">'.$browser.'</span>'; } ?>
<!--																  </span>-->
<!--																</li>-->
<!--																<li>-->
<!--																	<span class="fas fa-circle" data-fa-transform="shrink-12"></span>-->
<!--																	<span class="mb-2 d-inline-block">-->
<!--																	  --><?php //$browsers = explode('|',$product->software_framework);
//																	  foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Software Framework: '.$browser.'" class="badge badge-dark mr-1">'.$browser.'</span>' ; }?>
<!--																  </span>-->
<!--																</li>-->
<!--																<li>-->
<!--																	<span class="fas fa-circle" data-fa-transform="shrink-12"></span>-->
<!--																	<span class="mb-2 d-inline-block">-->
<!--																	  --><?php //$browsers = explode('|',$product->software_version);
//																	  foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Software Version: '.$browser.'" class="badge badge-dark mr-1">'.$browser.'</span>' ; }?>
<!--																  </span>-->
<!--																</li>-->
<!--																<li>-->
<!--																	<span class="fas fa-circle" data-fa-transform="shrink-12"></span>-->
<!--																	<span class="mb-2 d-inline-block">-->
<!--																	  --><?php //$browsers = explode('|',$product->files_included);
//																	  foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Files Included: '.$browser.'" class="badge badge-dark mr-1">'.$browser.'</span>' ; }?>
<!--																  </span>-->
<!--																</li>-->
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
<!--																<div class="d-none d-lg-block">-->
<!--																	<p class="fs--1 mb-1 text-center"> <strong>--><?php //echo(number_format($product->total_sales));?><!-- Sales</strong></p>-->
<!--																	<p class="fs--1 mb-1">Updated on: <strong class="">--><?php //$date = date_create($product->created_at); echo date_format($date,'d M,y');?><!--</strong>-->
<!--																	</p>-->
<!--																</div>-->
																<?php if($product->status != 'cancel'){?>
																	<div class="d-none d-lg-block">
																		<p class="fs--1 mb-1">Next Billing: <strong class=""><?php $date = date_create($product->billing_due_date); echo date_format($date,'d M,y');?></strong>
																		</p>
																	</div>
																<?php }else{ ?>
																	<div class="d-none d-lg-block">
																		<p class="fs--1 mb-1">Next Billing: <strong class="">Cancel</strong>
																		</p>
																	</div>
																<?php }?>
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
																	<a class="btn btn-sm btn-warning d-lg-block mt-2" href="<?php echo base_url('billing/MySubscription/'.$product->subscription_id.'/'.'suspend'.'/'.$product->product_id);?>">
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
						<div class="card-footer bg-light p-0">
							<a class="btn btn-sm btn-link btn-block py-2" href="<?php echo base_url('users/purchases');?>">
								View All Purchases<span class="fas fa-chevron-right ml-1 fs--2"></span>
							</a>
						</div>
					</div>
				</div>
			</div>

			<!--<div class="row no-gutters">
				<div class="col-lg-12 col-xl-12 pr-lg-2 mb-3">
					<div class="card h-lg-100 overflow-hidden">
						<div class=" card-body p-0">
							<div class="falcon-data-table w-100">
								<table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100" data-options='{"searching":false,"responsive":false,"pageLength":15,"info":true,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39; p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
									<thead class="bg-200">
									<tr>
										<th class="sort">Product Name</th>
										<th class="sort">Subscription Date</th>
										<th class="sort">Next Due Date</th>
										<th class="sort">Status</th>
										<th class="sort">Action</th>
									</tr>
									</thead>
									<tbody class="bg-white">
									<?php /*if(!empty($billing_details)){
										foreach($billing_details as $bill){*/?>
											<tr class="border-bottom border-200">
												<td>
													<div class="media align-items-center position-relative">
														<div class="media-body ">
																<a class="text-dark stretched-link" href="javascript:;"><?php /*echo $bill->product_name;*/?></a></h6>
													</div>
												</td>
												<td class="align-middle  font-weight-semi-bold">
													<?php /*$date = date_create($bill->billing_date); echo date_format($date,'d-F-Y')*/?>
												</td>
												<td class="align-middle pr-card">
													<div class="d-flex align-items-center">
														<div class="font-weight-semi-bold ">
															<?php /*$date = date_create($bill->billing_due_date); echo date_format($date,'d-F-Y')*/?>
														</div>
													</div>
												</td>
												<td class="align-middle pr-card">
													<div class="d-flex align-items-center">
														<div class="font-weight-semi-bold ">
															<?php /*if($bill->status == 'activate'){ */?>
																<span class="badge badge-success"><?php /*echo ucfirst($bill->status); */?></span>
															<?php /*}elseif($bill->status == 'suspend'){*/?>
																<span class="badge badge-warning"><?php /*echo ucfirst($bill->status); */?></span>
															<?php /*}elseif($bill->status == 'cancel'){*/?>
																<span class="badge badge-danger"><?php /*echo ucfirst($bill->status); */?></span>
															<?php /*} */?>
														</div>
													</div>
												</td>
												<td class="align-middle pr-card">
													<div class="dropdown text-sans-serif btn-reveal-trigger">
														<button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" id="dropdown-weather-update" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
														<div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown-weather-update">
															<div class="bg-white py-2">
																<?php /*if(!empty($bill->app_url)){*/?>
																<a class="dropdown-item" href="<?php /*echo $bill->app_url;*/?>">View</a>
																<a class="dropdown-item" href="<?php /*echo base_url('products/ActivateProduct/'.$bill->product_id)*/?>">Update</a>
																<?php /*} if($bill->status == 'activate'){ */?>
																	<a class="dropdown-item" href="<?php /*echo base_url('billing/MySubscription/'.$bill->subscription_id.'/'.'suspend'.'/'.$bill->product_id);*/?>">Suspend</a>
																	<a class="dropdown-item" href="<?php /*echo base_url('billing/MySubscription/'.$bill->subscription_id.'/'.'cancel'.'/'.$bill->product_id);*/?>">Cancel</a>
																<?php /*}elseif($bill->status == 'suspend'){*/?>
																	<a class="dropdown-item" href="<?php /*echo base_url('billing/MySubscription/'.$bill->subscription_id.'/'.'activate'.'/'.$bill->product_id);*/?>">Re-activate</a>
																	<a class="dropdown-item" href="<?php /*echo base_url('billing/MySubscription/'.$bill->subscription_id.'/'.'cancel'.'/'.$bill->product_id);*/?>">Cancel</a>
																<?php /*}elseif($bill->status == 'cancel'){*/?>
																<?php /*} */?>
															</div>
														</div>
													</div>
												</td>
											</tr>
										<?php /*} }else{ */?>
										<tr class="border-bottom border-200">
											<td>
												<h6 class="mb-0">No Records Found</h6>
											</td>
										</tr>
									<?php /*}*/?>
									</tbody>
									<tfoot class="bg-200">
									<tr>
										<th class="sort">Product Name</th>
										<th class="sort">Subscription Date</th>
										<th class="sort">Next Due Date</th>
										<th class="sort">Status</th>
										<th class="sort">Action</th>
									</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>-->
			<!--<div class="row no-gutters">
				<div class="col-sm-12 col-xxl-12 pr-sm-2 mb-3 mb-xxl-0">
					<div class="card">
						<div class="card-header d-flex flex-between-center bg-light py-2">
							<h5 class="mb-0">Purchases</h5>

						</div>
						<div class="card-body py-2 px-0">
							<?php
/*								if(!empty($products)){
							foreach($products as $product){*/?>
								<div class="col-12 p-3">
									<div class="p-1">
										<div class="row">
											<div class="col-sm-5 col-md-4">
												<div class="position-relative h-sm-100">
													<a class="d-block h-100" href="<?php /*echo base_url('products/ViewProduct/'.$product->product_id);*/?>">
														<img class="img-fluid fit-cover w-sm-100 h-sm-100 rounded absolute-sm-centered" src="<?php /*echo base_url('uploads/products/feature_img/'.$product->featured_image)*/?>" alt="" /></a>
													<div class="badge badge-pill badge-success position-absolute t-0 r-0 mr-2 mt-2 fs--2 z-index-2">New</div>
												</div>
											</div>
											<div class="col-sm-7 col-md-8">
												<div class="row">
													<div class="col-lg-8">
														<h5 class="mt-3 mt-sm-0">
															<a class="text-dark fs-0 fs-lg-1" href="<?php /*echo base_url('products/ViewProduct/'.$product->product_id);*/?>">
																<?php /*echo $product->product_name;*/?>
															</a>
														</h5>
														<p class="fs--1 mb-2 mb-md-3">
															<a class="text-500" href="#!">
																<?php /*echo $product->product_type;*/?>
															</a>
														</p>

														<ul class="list-unstyled d-none d-lg-block">
															<li>
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
															</li>
														</ul>
													</div>
													<div class="col-lg-4 d-flex justify-content-between flex-column">
														<div class="text-left">
															<div class="mb-2 ">
																<span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-300"></span><span class="ml-1">(8)</span>
															</div>
															<div class="d-none d-lg-block">
																<p class="fs--1 mb-1"> <strong><?php /*echo(rand(10,100));*/?> Sales</strong></p>
																<p class="fs--1 mb-1">Updated on: <strong class=""><?php /*$date = date_create($product->created_at); echo date_format($date,'d/m/Y');*/?></strong>
																</p>
															</div>
														</div>
														<div class="mt-md-2">
															<?php /*if(!empty($product->demo_link)){*/?>
																<a class="btn btn-sm btn-outline-secondary border-300 d-lg-block mt-2 mr-2 mr-lg-0" target="_blank" href="<?php /*echo $product->demo_link;*/?>">
																	<span class="fab fa-trello"></span><span class="ml-2 d-none d-md-inline-block">Live Preview</span>
																</a>
															<?php /*}*/?>
															<a id="<?php /*echo $product->product_id;*/?>" value="<?php /*echo $product->product_id;*/?>" class="btn btn-sm btn-primary d-lg-block mt-2 Deactivated" href="javascript:;">
																	<span class="fas fa-cart-arrow-down"></span>
																	<span class="ml-2 d-none d-md-inline-block Buytext">Activated</span>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php /*} }else{*/?>
							<h6 class="px-3 mb-0">You have not purchased any tools.</h6>
							<?php /*}*/?>
						</div>
						<div class="card-footer bg-light p-0">
							<a class="btn btn-sm btn-link btn-block py-2" href="<?php /*echo base_url('category');*/?>">
								View More Tools<span class="fas fa-chevron-right ml-1 fs--2"></span>
							</a>
						</div>
					</div>
				</div>
			</div>-->
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
