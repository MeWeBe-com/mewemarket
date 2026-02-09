<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>Manage Packages | SaasCloud</title>

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
				<div class="col-md-12 col-xxl-12 mb-3 pr-md-2">
					<div class="card h-md-100">
						<div class="card-header pb-0">
							<div class="row align-items-center">
								<div class="col">
									<h5 class="mb-0 mt-2 d-flex align-items-center">Manage Packages</h5>
								</div>
								<div class="col-auto">
									<a class="btn btn-falcon-default btn-sm" href="<?php echo base_url('admin/create_package')?>">
										<span class="fas fa-pencil-alt fs--2 mr-1"></span>NEW
									</a>
								</div>
							</div>
						</div>
						<div class="card-body d-flex align-items-end px-0">
							<div class="falcon-data-table w-100">
								<table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100" data-options='{"searching":false,"responsive":false,"pageLength":15,"info":true,"lengthChange":false,"sWrapper":"falcon-data-table-wrapper","dom":"<&#39;row mx-1&#39;<&#39;col-sm-12 col-md-6&#39;l><&#39;col-sm-12 col-md-6&#39;f>><&#39;table-responsive&#39;tr><&#39;row no-gutters px-1 py-3 align-items-center justify-content-center&#39;<&#39;col-auto&#39; p>>","language":{"paginate":{"next":"<span class=\"fas fa-chevron-right\"></span>","previous":"<span class=\"fas fa-chevron-left\"></span>"}}}'>
									<thead class="bg-200">
										<tr>
											<th class="sort">Package Name</th>
											<th class="sort">Package Amount</th>
											<th class="sort">Package Duration</th>
											<th class="sort">Package Visibility</th>
											<th class="sort">Created Date</th>
											<th class="sort">Action</th>
										</tr>
									</thead>
									<tbody class="bg-white">


									<?php foreach($packages as $key => $package){ ?>

										<tr>
											<td><?php echo $package->package_name ;?></td>
											<td><?php echo $package->package_amount ;?></td>
											<td><?php echo $package->package_duration ;?></td>
											<td><?php if($package->visibility == 1){ echo "Visible"; }else{ echo "Hidden"; } ?></td>
											<td><?php $date = date_create($package->created_at); echo date_format($date,'d/m/Y');  ?></td>
											<td >
												<div class="dropdown text-sans-serif btn-reveal-trigger">
													<button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" id="dropdown-running-projects" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
													<div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown-running-projects">
														<div class="bg-white py-2">
															<a class="dropdown-item" href="<?php echo base_url('admin/create_package/'.$package->package_id);?>">Edit</a>
															<a class="dropdown-item" href="<?php echo base_url('pricing');?>">View</a>
															<div class="dropdown-divider"></div>
															<a class="dropdown-item text-danger" value="<?php echo $package->package_id ;?>" href="#!">Remove</a>
														</div>
													</div>
												</div>
											</td>
										</tr>

									<?php }?>

									</tbody>
									<tfoot class="bg-200">
										<tr>
											<th>Package Name</th>
											<th>Package Amount</th>
											<th>Package Duration</th>
											<th>Package Visibility</th>
											<th>Created Date</th>
											<th>Action</th>
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
