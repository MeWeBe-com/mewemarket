<!DOCTYPE html>
<html lang="en-US" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Pricing | MeweMarket</title>

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
										<?php echo "Pricing";?>
									</li>
								</ol>
							</nav>

							<div class="col-lg-12 col-xxl-4 pr-lg-2 mb-3 mb-lg-0">
								<div class="card mb-3">
									<div class="card-header bg-light text-center">
										<h2 class="fs-2 fs-md-3">A plan for every price</h2>
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
																		<!--<img src="<?php /*echo base_url();*/?>assets/img/illustrations/paper-plane.svg" width="50" alt="">-->
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
																	<a class="btn btn-outline-primary btn-block" href="<?php echo base_url('users/register/'); ?>">Buy Now</a>
																</div>
															</div>
														</div>
													<?php } } ?>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row no-gutters">
									<div class="col-lg-6 col-xl-7 col-xxl-8 mb-3 pr-lg-2 mb-3">
										<div class="card h-lg-100">
											<div class="card-body d-flex align-items-center">
												<div class="table-responsive fs--1">
													<table class="table table-striped border-bottom">
														<thead class="bg-200 text-900">
															<tr>
																<th class="border-0"></th>
																<th class="border-0 text-center">Users</th>

															</tr>
														</thead>
														<tbody>

														<?php foreach($packages as $package){ if($package->visibility !=  0){
															$feature = explode(PHP_EOL,$package->package_description); ?>
															<tr>
																<td class="align-middle">
																	<h6 class="mb-0 text-nowrap"><?php echo ucfirst($package->package_name); ?></h6>
																</td>

																<td class="align-middle text-center">
																	<?php echo $feature[0];  ?>
																</td>
															</tr>
														<?php }  }?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-xl-5 col-xxl-4 mb-3 pl-lg-2">
										<div class="card h-lg-100">
											<div class="bg-holder bg-card" style="background-image:url('assets/img/illustrations/corner-1.png');"></div>
											<!--/.bg-holder-->
											<div class="card-body position-relative">
												<h5 class="text-warning">Save up to XXX</h5>
												<p class="fs--1 mb-0">No need for developers, host-ing, designers etc. Lorem<br> ipsum dolor sit amet, consec-
													tetur adipiscing elit.</p>
												<a class="btn btn-link fs--1 text-warning mt-4 mt-lg-3 pl-0" href="#!"> Upgrade storage <span class="fas fa-chevron-right ml-1" data-fa-transform="shrink-4 down-1"></span></a>
											</div>
										</div>
									</div>
								</div>

								<div class="card mb-3">
									<div class="card-header">
										<h4 class="text-center mb-0">How it Works?</h4>
									</div>
									<div class="card-body bg-light">
										<h6> <a href="#!">How does MeweMarket's pricing work?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a></h6>
										<p class="fs--1 mb-0">The free version of MeweMarket is available for teams of up to 15 people. Our MeweMarket Premium plans of 15 or fewer qualify for a small team discount. As your team grows to 20 users or more and gets more value out of MeweMarket, you'll get closer to our standard monthly price per seat. The price of a paid MeweMarket plan is tiered, starting in groups of 5 and 10 users, based on the number of people you have in your Team or Organization.</p>
										<hr class="my-3" />
										<h6> <a href="#!">What forms of payment do you accept?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a></h6>
										<p class="fs--1 mb-0">You can purchase MeweMarket with any major credit card. For annual subscriptions, we can issue an invoice payable by bank transfer or check. Please contact us to arrange an invoice purchase. Monthly purchases must be paid for by credit card.</p>
										<hr class="my-3" />
										<h6> <a href="#!">We need to add more people to our team. How will that be billed?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a></h6>
										<p class="fs--1 mb-0">You can add as many new teammates as you need before changing your subscription. We will subsequently ask you to correct your subscription to cover current usage.</p>
										<hr class="my-3" />
										<h6> <a href="#!">How secure is MeweMarket?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a></h6>
										<p class="fs--1 mb-0">Protecting the data you trust to MeweMarket is our first priority. MeweMarket uses physical, procedural, and technical safeguards to preserve the integrity and security of your information. We regularly back up your data to prevent data loss and aid in recovery. Additionally, we host data in secure SSAE 16 / SOC1 certified data centers, implement firewalls and access restrictions on our servers to better protect your information, and work with third party security researchers to ensure our practices are secure.</p>
										<hr class="my-3" />
										<h6> <a href="#!">Will I be charged sales tax?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a></h6>
										<p class="fs--1 mb-0">As of May 2016, state and local sales tax will be applied to fees charged to customers with a billing address in the State of New York.</p>
										<hr class="my-3" />
										<h6> <a href="#!">Do you offer discounts?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a></h6>
										<p class="fs--1 mb-0">We've built in discounts at each tier for teams smaller than 15 members. We also offer two months for free in exchange for an annual subscription.</p>
										<hr class="my-3" />
										<h6> <a href="#!">Do you offer academic pricing?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a></h6>
										<p class="fs--1 mb-0">We're happy to work with student groups using MeweMarket. Contact Us</p>
										<hr class="my-3" />
										<h6> <a href="#!">Is there an on-premise version of MeweMarket?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a></h6>
										<p class="fs--1 mb-0">We are passionate about the web. We don't plan to offer an internally hosted version of MeweMarket. We hope you trust us to provide a robust and secure service so you can do the work only your team can do.</p>
										<hr class="my-3" />
										<h6> <a href="#!">What is your refund policy?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a></h6>
										<p class="fs--1 mb-0">We do not offer refunds apart from exceptions listed below. If you cancel your plan before the next renewal cycle, you will retain access to paid features until the end of your subscription period. When your subscription expires, you will lose access to paid features and all data associated with those features. Exceptions to our refund policy: canceling within 48 hours of initial charge will result in a full refund. If you cancel within this timeframe, you will lose access to paid features and associated data immediately upon canceling.</p>
									</div>

								</div>
<!--								<div class="row no-gutters">-->
<!--									<div class="col-lg-12 col-xl-12 col-xxl-12 mb-3 ">-->
<!--										<div class="card h-lg-100">-->
<!--											<div class="bg-holder bg-card" style="background-image:url('assets/img/illustrations/corner-1.png');"></div>-->
											<!--/.bg-holder-->
<!--											<div class="card-body position-relative text-center">-->
<!--												<h5 class="text-warning">Try free for 14 days</h5>-->
<!--												<p class="fs--1 mb-0">Description of service here that goes over a few lines Lorem ipsum dolor sit amet, consecte--->
<!--													<br />tur adipiscing elit. Pellentesque id velit accumsan, rutrum urna sed, fringilla nunc.</p>-->
<!--												<a class="btn btn-link fs--1 text-warning mt-4 mt-lg-3 pl-0" href="#!"> Upgrade storage <span class="fas fa-chevron-right ml-1" data-fa-transform="shrink-4 down-1"></span> </a>-->
<!--											</div>-->
<!--										</div>-->
<!--									</div>-->
<!--								</div>-->
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
