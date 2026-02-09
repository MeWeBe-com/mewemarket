<!DOCTYPE html>
<html lang="en-US" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Select Package | MeweMarket</title>

<?php $this->load->view('partial/head') ;?>

  </head>
  <body>

   <main class="main" id="top">
		<div class="container" data-layout="container">
			<?php $this->load->view('partial/sidebar')?>
			<div class="content">
				<?php $this->load->view('partial/header')?>
				<div class="row">
					<div class="space mb-0 w-100"></div>
					<div class="w-100 ">
						<div class="row no-gutters">

							<nav aria-label="breadcrumb">
								<ol class="breadcrumb pt-0">
									<li class="breadcrumb-item fs--1">
										<a href="<?php echo base_url();?>">Home</a>
									</li>
									<li class="breadcrumb-item fs--1 active" aria-current="page">
										<?php echo "Select Package";?>
									</li>
								</ol>
							</nav>

							<div class="col-lg-12 col-xxl-4 pr-lg-2 mb-3 mb-lg-0">
								<div class="card mb-3">
									<div class="card-header bg-light text-center">
										<h2 class="fs-2 fs-md-3">Select Package For <?php echo $productdetails[0]->product_name?></h2>
									</div>
									<div class="card-body">
										<div class="row justify-content-center">
											<div class="col-12 col-lg-12">
												<div class="row">
													<?php  foreach($packages as $package){ if($package->visibility == 1){  ?>
														<div class="col-12 col-md">
															<div class="border rounded-soft overflow-hidden mb-3 mb-md-0">
																<div class="d-flex justify-content-between align-items-center <?php if($package->package_name == 'Plus'){ echo "recommended"; } ?> p-4">
																	<div>
																		<h3 class="font-weight-light fs-5 mb-0 text-primary"><?php echo ucfirst($package->package_name);?></h3>
																		<h2 class="font-weight-light mt-0 text-primary"><sup class="fs-1">&dollar;</sup><span class="fs-3"><?php echo $package->package_amount;?></span><span class="fs--2 mt-1">/ <?php echo $package->package_duration;?></span></h2>
																	</div>
																	<div class="pr-3">
																		<?php if($package->package_name == 'Basic'){?>
																			<i class="fas fa-paper-plane fs-6 text-primary"></i>
																		<?php }else if($package->package_name == 'Plus'){?>
																			<i class="fas fa-plane-departure fs-6 text-primary"></i>
																		<?php }else{ ?>
																			<i class="fas fa-rocket fs-6 text-primary"></i>
																		<?php }?>
																	</div>
																</div>
																<div class="p-4 bg-light <?php if($package->package_name == 'Plus'){ echo "recommended border-top"; } ?>">
																	<ul class="list-unstyled">
																		<?php $features = explode(PHP_EOL,$package->package_description);
																		foreach($features as $feature){?>
																			<li class="border-bottom py-2">
																				<span class="fas fa-check text-primary" data-fa-transform="shrink-2"> </span>
																				<?php echo $feature; ?>
																			</li>
																		<?php }?>
																	</ul>
																	<a class="btn btn-outline-primary btn-block" href="<?php echo base_url('payment/BuyProduct/'.$product_id.'/'.$this->session->userdata('user_id').'/'.$package->package_id.'?nocache'); ?>">
																		Pay Now
																	</a>
																</div>
															</div>
														</div>
													<?php } } ?>
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
    <?php $this->load->view('partial/footerscript') ;?>
  </body>
</html>
