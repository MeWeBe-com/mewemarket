<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>Manage Subscription | MeweMarket</title>

	<!-- ===============================================-->
	<!--    Stylesheets-->
	<!-- ===============================================-->

	<?php $this->load->view('partial/head') ?>
	<link href="<?php echo base_url('assets/lib/toastr/toastr.min.css')?>" rel="stylesheet">



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
				<div class="col-md-4 col-xxl-12 mb-3 pr-md-2 pl-xxl-2">
					<div class="card h-md-100">
						<div class="card-body">
							<div class="row h-100 justify-content-between no-gutters">
								<div class="col-5 col-sm-7 col-xxl pr-2">
									<h6 class="mt-1">Earning All Time</h6>
									<div class="fs--2 mt-3">
										<div class="d-flex flex-between-center mb-1">
											<div class="d-flex align-items-center">
												<span class="font-weight-semi-bold fs-0">
													<?php echo "$".number_format($AllTimeEarning,2)?>
												</span>
											</div>

										</div>

									</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-calendar fs-7 mr-3 text-success"></i>
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
									<h6 class="mt-1">Earning This Year</h6>
									<div class="fs--2 mt-3">
										<div class="d-flex flex-between-center mb-1">
											<div class="d-flex align-items-center">
												<span class="font-weight-semi-bold fs-0">
													<?php echo "$".number_format($ThisYearEarning,2)?>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-calendar-alt fs-7 mr-3 text-warning"></i>
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
									<h6 class="mt-1">Earning This Month</h6>
									<div class="fs--2 mt-3">
										<div class="d-flex flex-between-center mb-1">
											<div class="d-flex align-items-center">
												<span class="font-weight-semi-bold fs-0">
													<?php echo "$".number_format($ThisMonthEarning,2)?>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-calendar-day  fs-7 mr-3 text-info"></i>
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
									<h5 class="mb-0 mt-2 d-flex align-items-center">Manage Subscription</h5>
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

										</tr>
									<?php }?>

									</tbody>
									<tfoot class="bg-200">
										<tr>
											<th class="sort">User Name</th>
											<th class="sort">Paid Amount</th>
											<th class="sort">Package Name</th>
											<th class="sort">Billing Date</th>
											<th class="sort">Next Billing Date</th>

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
<script src="<?php echo base_url('assets/lib/toastr/toastr.min.js')?>"></script>


<script>
	$(document).ready(function() {

		toastr.options = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": false,
			"progressBar": true,
			"positionClass": "toast-top-right",
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "3000",
			"extendedTimeOut": "3000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};

		<?php if(isset($_GET['Added'])){ ?>
		toastr.success('New Package Added Succesfully');
		<?php }  if(isset($_GET['Updated'])){?>

		toastr.info('Package Updated Succesfully');

		<?php } ?>



	});
</script>

</body>

</html>
