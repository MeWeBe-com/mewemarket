<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>Admin Dashboard | Mewemarket</title>

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

		<?php $this->load->view('admin/sidebar')?>
		<div class="content">
			<?php $this->load->view('admin/topbar')?>

			<div class="row no-gutters">
				<div class="col-md-4 col-xxl-3 mb-3 pr-md-2 pl-xxl-2">
					<div class="card h-md-100">
						<div class="card-body">
							<div class="row h-100 justify-content-between no-gutters">
								<div class="col-5 col-sm-7 col-xxl pr-2">
									<h6 class="mt-1">Total User</h6>
									<div class="fs--2 mt-2">
										<div class="d-flex flex-between-center mb-1">
											<div class="d-flex align-items-center">
												<span class="font-weight-semi-bold fs-2">
													<?php echo $TotalUsers->Total;?>
												</span>
											</div>

										</div>

									</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-users fs-7 mr-3"></i>
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
									<h6 class="mt-1">Activated Tools</h6>
									<div class="fs--2 mt-2">
										<div class="d-flex flex-between-center mb-1">
											<div class="d-flex align-items-center">
												<span class="font-weight-semi-bold fs-2">
													<?php echo $ActivatedTools->Total;?>
												</span>
											</div>

										</div>

									</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-tools fs-7 mr-3"></i>
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
									<h6 class="mt-1">Total Packages</h6>
									<div class="fs--2 mt-2">
										<div class="d-flex flex-between-center mb-1">
											<div class="d-flex align-items-center">
												<span class="font-weight-semi-bold fs-2">
													<?php echo $TotalPackages->Total;?>
												</span>
											</div>

										</div>

									</div>
								</div>
								<div class="col-auto">
									<i class="far fa-list-alt fs-7 mr-3"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row no-gutters">
				<div class="col-md-12 col-xxl-12 mb-3 pr-md-2">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<div class="row align-items-center">
								<div class="col">
									<h6 class="mb-0 mt-2 d-flex align-items-center">Users Subscription</h6>
								</div>
								<div class="col-auto">

								</div>
							</div>
						</div>
						<div class="card-body d-flex align-items-end px-0">
							<div class="falcon-data-table w-100">
								<table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100" data-options='{"searching":false,"responsive":false,"pageLength":15,"info":true,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39; p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
									<thead class="bg-200">
									<tr>
										<th class="sort">User Name</th>
										<th class="sort">Paid Amount</th>
										<th class="sort">Product Name</th>
										<th class="sort">Billing Date</th>
										<th class="sort">Next Billing Date</th>
										<th class="sort">Status</th>
										<th class="sort">Action</th>
									</tr>
									</thead>
									<tbody class="bg-white">
									<?php foreach($Subscription as $key => $subs){  ?>
										<tr>
											<td><?php echo ucfirst($subs->user_name);?></td>
											<td><?php echo '$'.$subs->package_amount ;?></td>
											<td><?php echo $subs->product_name ;?></td>
											<td><?php $date = date_create($subs->billing_date); echo date_format($date,'d/m/Y');  ?></td>
											<td><?php $date = date_create($subs->billing_due_date); echo date_format($date,'d/m/Y');  ?></td>
											<td>
												<?php if($subs->status == 'activate'){ ?>
													<span class="badge badge-success"><?php echo $subs->status; ?></span>
												<?php }elseif($subs->status == 'suspend'){?>
													<span class="badge badge-warning"><?php echo $subs->status; ?></span>
												<?php }elseif($subs->status == 'cancel'){?>
													<span class="badge badge-danger"><?php echo $subs->status; ?></span>
												<?php } ?>
											</td>
											<td>
												<div class="dropdown text-sans-serif btn-reveal-trigger">
													<button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" id="dropdown-weather-update" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
													<div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown-weather-update">
														<div class="bg-white py-2">
															<a class="dropdown-item" href="<?php echo $subs->app_url;?>">View</a>
															<?php if($subs->status == 'activate'){ ?>
																<a class="dropdown-item" href="<?php echo base_url('payment/MySubscription/'.$subs->subscription_id.'/'.'suspend'.'/'.$subs->product_id);?>">Suspend</a>
																<a class="dropdown-item" href="<?php echo base_url('payment/MySubscription/'.$subs->subscription_id.'/'.'cancel'.'/'.$subs->product_id);?>">Cancel</a>
															<?php }elseif($subs->status == 'suspend'){?>
																<a class="dropdown-item" href="<?php echo base_url('payment/MySubscription/'.$subs->subscription_id.'/'.'activate'.'/'.$subs->product_id);?>">Re-activate</a>
																<a class="dropdown-item" href="<?php echo base_url('payment/MySubscription/'.$subs->subscription_id.'/'.'cancel'.'/'.$subs->product_id);?>">Cancel</a>
															<?php }elseif($subs->status == 'cancel'){?>
															<?php } ?>
														</div>
													</div>
												</div>
											</td>
										</tr>
									<?php }?>
									</tbody>
									<tfoot class="bg-200">
									<tr>
										<th class="sort">User Name</th>
										<th class="sort">Paid Amount</th>
										<th class="sort">Product Name</th>
										<th class="sort">Billing Date</th>
										<th class="sort">Next Billing Date</th>
										<th class="sort">Status</th>
										<th class="sort">Action</th>
									</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php $this->load->view('admin/footer')?>
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
