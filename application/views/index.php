<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>MeweMarket</title>


	<?php $this->load->view('partial/head')?>

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

			<div class="row">
				<div class="space  mb-0 w-100"></div>
				<!--<div class="w-100 ">
					<div class="row no-gutters">
						<div class="col-lg-6 col-xxl-4 pr-lg-2 mb-3 mb-lg-0">
							<div class="card h-100">
								<div class="card-header d-flex flex-between-center">
									<h5 class="mb-0 ">Latest Video</h5>
								</div>
								<div class="bg-light card-body">
									<div class="player" data-plyr-provider="youtube" data-plyr-embed-id="bTqVqk7FSmY"></div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-xxl-4 pl-lg-2">
							<div class="card">

								<div class="card-header d-flex flex-between-center">
									<h5 class="mb-0">Latest Products</h5>
									<a class="btn btn-sm btn-link pr-0 pb-0 mb-0 mt-0 pt-0 fs--1" href="#!">View All</a>
								</div>
								<div class="card-body bg-light pb-0">
									<div class="position-relative">
										<a href="javascript:;" class="d-inline-block h-100 py-lg-7 w-100">
											<div class="bg-holder rounded-soft overlay overlay-2" style="background-image:url(<?php /*echo base_url();*/?>assets/img/products/2.jpg);">

											</div>
										</a>
									</div>
								</div>
								<div class="card-body bg-light">
									<div class="position-relative">
										<a href="javascript:;" class="d-inline-block h-100 py-lg-7 w-100">
											<div class="bg-holder rounded-soft overlay overlay-2" style="background-image:url(<?php /*echo base_url();*/?>assets/img/products/7.jpg);">
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>-->
				<div class="position-relative  mb-3">
					<div class="bg-holder rounded-soft overlay overlay-0" style="background-image:url(<?php echo base_url();?>assets/img/generic/office_table.jpg);">

					</div> <!--/.bg-holder-->
					<div class="position-relative vh-40 w-100 text-center py-lg-5 px-lg-10">
						<h3 class="font-weight-light text-white w-100 overflow-hidden">A smarter way to tell about <span class="typed-text font-weight-bold ml-1" data-typed-text='["new features.","product updates.","a new idea.","an announcment."]'></span></h3>
						<p class="w-100 font-weight-light d-inline-block text-white text-300">is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>

					</div>
				</div>
				<div class="card mb-3">

					<div class="card-header d-flex flex-between-center bg-light ">
						<h5 class="mb-0">Products</h5><a class="btn btn-sm btn-link pr-0 fs--1" href="#!"></a>
					</div>
					<div class="card-body">
						<div class="row">
							<?php foreach($Products as $product){?>
							<div class="col-12 p-3">
								<div class="p-1">
									<div class="row">
										<div class="col-sm-5 col-md-4">
											<div class="position-relative h-sm-100">
												<?php $slug = url_title($product->product_name, 'dash', true); ?>
												<a class="d-block h-100" href="<?php echo base_url('products/ViewProduct/'.$product->product_id.'/'.$slug);?>">
													<img class="img-fluid fit-cover w-sm-100 h-sm-100 rounded absolute-sm-centered" src="<?php echo base_url('uploads/products/feature_img/'.$product->featured_image)?>" alt="" /></a>
												<div class="badge badge-pill badge-success position-absolute t-0 r-0 mr-2 mt-2 fs--2 z-index-2"><?php echo $product->featured_tag;?></div>
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
														<span class="text-500" href="#!">
															<?php echo $product->product_type;?>
														</span>
													</p>

													<ul class="list-unstyled d-none d-lg-block mb-0 fs--1">
														<?php $details = explode(PHP_EOL,$product->key_benefits);
														foreach($details as $detail){  ?>
															<li>
																<span class="mb-2 d-inline-block">
													 <?php echo $detail;?>
												  </span>
															</li>
														<?php }?>
<!--														<li>-->
<!--															<span class="fas fa-circle" data-fa-transform="shrink-12"></span>-->
<!--															<span class="mb-2 d-inline-block">-->
<!--															  --><?php //$browsers = explode('|',$product->compatible_browsers);
//															  foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Compatible Browsers: '.$browser.'" class="badge badge-dark dark__bg-dark mr-1">'.$browser.'</span>'; } ?>
<!--														    </span>-->
<!--														</li>-->
<!---->
<!--														<li>-->
<!--															<span class="fas fa-circle" data-fa-transform="shrink-12"></span>-->
<!--															<span class="mb-2 d-inline-block">-->
<!--															  --><?php //$browsers = explode('|',$product->software_framework);
//															   foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Software Framework: '.$browser.'" class="badge badge-dark dark__bg-dark mr-1">'.$browser.'</span>' ; }?>
<!--														    </span>-->
<!--														</li>-->
<!--														<li>-->
<!--															<span class="fas fa-circle" data-fa-transform="shrink-12"></span>-->
<!--															<span class="mb-2 d-inline-block">-->
<!--															  --><?php //$browsers = explode('|',$product->software_version);
//															  foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Software Version: '.$browser.'" class="badge badge-dark dark__bg-dark mr-1">'.$browser.'</span>' ; }?>
<!--														    </span>-->
<!--														</li>-->
<!--														<li>-->
<!--															<span class="fas fa-circle" data-fa-transform="shrink-12"></span>-->
<!--															<span class="mb-2 d-inline-block">-->
<!--															  --><?php //$browsers = explode('|',$product->files_included);
//															   foreach($browsers as $browser){ echo '<span data-toggle="tooltip" data-placement="top" title="Files Included: '.$browser.'" class="badge badge-dark dark__bg-dark mr-1">'.$browser.'</span>' ; }?>
<!--														    </span>-->
<!--														</li>-->
													</ul>
												</div>
												<div class="col-lg-4 d-flex justify-content-between flex-column">
													<div class="text-left">
														<div class="mb-2 ">
															<span class="fa fa-star <?php if($product->rating >= 1){ echo 'text-warning';} ?> "></span>
															<span class="fa fa-star <?php if($product->rating >= 2){ echo 'text-warning';} ?> "></span>
															<span class="fa fa-star <?php if($product->rating >= 3){ echo 'text-warning';} ?> "></span>
															<span class="fa fa-star <?php if($product->rating >= 4){ echo 'text-warning';} ?> "></span>
															<span class="fa fa-star <?php if($product->rating >= 5){ echo 'text-warning';} ?> "></span>
															<span class="ml-1">(<?php echo $product->rating; ?>)</span>
														</div>
														<div class="d-none d-lg-block">
															<p class="fs--1 mb-1 text-center"> <strong><?php echo shortNumber($product->total_sales); ?> Sales</strong></p>
															<p class="fs--1 mb-1">Updated on: <strong class=""> <?php $date = date_create($product->created_at); echo date_format($date,'d M, y');?></strong>
															</p>
														</div>
													</div>

													<div class="mt-md-2">

													<?php if(empty($this->session->userdata('user_id'))){ ?>
														<a class="fs--1 btn btn-sm btn-outline-danger border-300 d-lg-block mt-2 mr-2 mr-lg-0 hearticon">
															<span class="hearticon far fa-heart"></span>
															<span class="ml-2 d-none d-md-inline-block">Favourites</span>
														</a>
														<?php }else{ ?>

														<a value="<?php echo $product->product_id;?>" id="heart<?php echo $product->product_id;?>" class="fs--1 btn btn-sm btn-outline-danger border-300 d-lg-block mt-2 mr-2 mr-lg-0 <?php if(!in_array($product->product_id, array_column($userfavourite, 'product_id')) && !empty($this->session->userdata('user_id'))){ echo 'hearticon '; }else{ echo 'dehearticon active'; }?>">
															<span value="<?php echo $product->product_id;?>" id="<?php echo $product->product_id;?>" class="<?php if(!in_array($product->product_id, array_column($userfavourite, 'product_id')) && !empty($this->session->userdata('user_id'))){ echo 'hearticon far fa-heart'; }else{ echo 'dehearticon fas fa-heart'; }?>"></span>
															<span class="ml-2 d-none d-md-inline-block">Favourites</span>
														</a>

														<?php }?>
														<?php if(!empty($product->demo_link)){?>
														<a class="btn btn-sm btn-outline-secondary border-300 d-lg-block mt-2 mr-2 mr-lg-0 fs--1" target="_blank" href="<?php echo $product->demo_link;?>">
															<span class="fab fa-trello"></span><span class="ml-2 d-none d-md-inline-block">Live Preview</span>
														</a><?php }?>

														<?php if(empty($this->session->userdata('user_id'))){

															 if ($product->payment_type == 1){?>
																<a id="activate" value="<?php echo $product->product_id;?>" class="btn btn-sm btn-primary d-lg-block mt-2 Deactivated fs--1" href="<?php echo $product->demo_link;?>">
																	<span class="fas fa-cart-arrow-down"></span>
																	<span class="ml-2 d-none d-md-inline-block">Free</span>
																</a>
															<?php }else{ ?>
															<a class="btn btn-sm btn-primary d-lg-block mt-2 notlogin fs--1" href="javascript:;">
																	<span class="fas fa-cart-arrow-down"></span>
																	<span class="ml-2 d-none d-md-inline-block ">Activate</span>
															</a>
														<?php } }else{  $key = array_search($product->product_id, array_column($userproducts, 'product_id'));

															  if ($product->payment_type == 1){?>
																<a id="activate" value="<?php echo $product->product_id;?>" class="btn btn-sm btn-primary d-lg-block mt-2 Deactivated fs--1" href="<?php echo $product->demo_link;?>">
																	<span class="fas fa-cart-arrow-down"></span>
																	<span class="ml-2 d-none d-md-inline-block">Free</span>
																</a>
															<?php } elseif (in_array($product->product_id, array_column($userproducts, 'product_id')) && $userproducts[$key]->status == 'activate'){ ?>
																<a id="activate" value="<?php echo $product->product_id;?>" class="btn btn-sm btn-primary d-lg-block mt-2 Deactivated fs--1" href="<?php echo $userproducts[$key]->app_url; ?>">
																	<span class="fas fa-cart-arrow-down"></span>
																	<span class="ml-2 d-none d-md-inline-block Buytext<?php echo $product->product_id;?>">Activated</span>
																</a>
															<?php }elseif (in_array($product->product_id, array_column($userproducts, 'product_id')) && $userproducts[$key]->status == 'suspend'){ ?>
																<a id="activate" value="<?php echo $product->product_id;?>" class="btn btn-sm btn-primary d-lg-block mt-2 Deactivated fs--1" href="<?php echo base_url('users/dashboard');?>">
																	<span class="fas fa-cart-arrow-down"></span>
																	<span class="ml-2 d-none d-md-inline-block Buytext<?php echo $product->product_id;?>">Re-activate</span>
																</a>
															<?php }else{ ?>
																<a id="activate" value="<?php echo $product->product_id;?>" class="btn btn-sm btn-primary d-lg-block mt-2 fs--1" href="<?php echo base_url('products/ActivateProduct/'.$product->product_id)?>">
																	<span class="fas fa-cart-plus"></span>
																	<span class="ml-2 d-none d-md-inline-block Buytext<?php echo $product->product_id;?>">Activate</span>
																</a>
															<?php  }?>
														<?php }?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-lg-12 mb-3 px-0">
					<div class="col-lg-12 mb-3 px-0">
						<div class="card h-lg-100">
							<div class="card-header d-flex flex-between-center bg-light py-2">
								<h5 class="mb-0">Categories</h5>
<!--								<a class="btn btn-sm btn-link pr-0 fs--1" href="--><?php //echo base_url('category')?><!--">View All</a>-->
							</div>
							<div class="card-body fs--1">
								<div class="row no-gutters text-center fs--1">
									<?php foreach($categories as $category){?>
										<?php $slug = url_title($category->category_name, 'dash', true);?>
									<a class="col-6 col-md-4 col-lg-4 col-xxl-2 mb-1" href="<?php echo base_url('category/ViewCategory/'.$category->category_id.'/'.$slug)?>">
											<div class="bg-white p-3 h-100">
											  <span>
											  <i class="<?php echo $category->category_icon?> text-dark fs-4 mb-2"></i>
											  </span>
												<h6 class="mb-1">
													<?php echo $category->category_name?>
												</h6>
											</div>
									</a>
									<?php }?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 px-0">
						<div class="card mb-3">
							<div class="card-header d-flex flex-between-center bg-light py-2">
								<h5 class="mb-0 pt-1 pb-2">What our clients say</h5>
							</div>
							<div class="container">
								<div class="row justify-content-center">
									<div class="col-lg-12 col-xl-12 pb-4">
										<div class="owl-carousel owl-theme owl-theme-dark" data-options='{"margin":30,"nav":true,"autoplay":true,"autoplayHoverPause":true,"loop":true,"dots":true,"items":2}'>
											<div class="row mt-6">
												<div class="col-lg-6 mt-6 mt-lg-0">
													<div class="card card-span h-100">
														<div class="card-span-img"><span class="far fa-user fs-5 text-success"></span></div>
														<div class="card-body pt-6 pb-4">
															<h6 class="mb-2">Ibby S</h6>
															<p class="fs--1">I am really satisfied with my applications. I couldn't have asked for more than this. Thanks for the great service.</p>
															<a class="fs--2 mb-3 d-inline-block text-decoration-none" href="#review" data-tab-target="#review" data-fancyscroll data-offset="80"><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning "></span></a>
														</div>

													</div>
												</div>

												<div class="col-lg-6 mt-6 mt-lg-0">
													<div class="card card-span h-100">
														<div class="card-span-img"><span class="far fa-user fs-6 text-danger"></span></div>
														<div class="card-body pt-6 pb-4">
															<h6 class="mb-2">Jack F</h6>
															<p class="fs--1">It's really wonderful. Mewemarket is worth much more than I paid. This is simply unbelievable!</p>
															<a class="fs--2 mb-3 d-inline-block text-decoration-none" href="#review" data-tab-target="#review" data-fancyscroll data-offset="80"><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning "></span></a>
														</div>
													</div>
												</div>
											</div>

											<div class="row mt-6">

												<div class="col-lg-6 mt-6 mt-lg-0">
													<div class="card card-span h-100">
														<div class="card-span-img">
															<span class="far fa-user fs-5 text-success"></span>
														</div>
														<div class="card-body pt-6 pb-4">
															<h6 class="mb-2">Patti Q</h6>
															<p class="fs--1">This is simply unbelievable! Mewemarket has really helped our business.</p>
															<a class="fs--2 mb-3 d-inline-block text-decoration-none" href="#review" data-tab-target="#review" data-fancyscroll data-offset="80"><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning "></span></a>
														</div>
													</div>
												</div>
												<div class="col-lg-6 mt-6 mt-lg-0">
													<div class="card card-span h-100">
														<div class="card-span-img"><span class="far fa-user fs-6 text-danger"></span></div>
														<div class="card-body pt-6 pb-4">
															<h6 class="mb-2">Archibold U</h6>
															<p class="fs--1">Best. Product. Ever! I would also like to say thank you to all your staff. It's really wonderful. It's exactly what I've been looking for</p>
															<a class="fs--2 mb-3 d-inline-block text-decoration-none" href="#review" data-tab-target="#review" data-fancyscroll data-offset="80"><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning "></span></a>
														</div>
													</div>
												</div>
											</div>


											<div class="row mt-6">

												<div class="col-lg-6 mt-6 mt-lg-0">
													<div class="card card-span h-100">
														<div class="card-span-img">
															<span class="far fa-user fs-5 text-success"></span>
														</div>
														<div class="card-body pt-6 pb-4">
															<h6 class="mb-2">Moyna I</h6>
															<p class="fs--1">It's incredible. Mewemarket should be nominated for service of the year</p>
															<a class="fs--2 mb-3 d-inline-block text-decoration-none" href="#review" data-tab-target="#review" data-fancyscroll data-offset="80"><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning "></span></a>
														</div>
													</div>
												</div>
												<div class="col-lg-6 mt-6 mt-lg-0">
													<div class="card card-span h-100">
														<div class="card-span-img"><span class="far fa-user fs-6 text-danger"></span></div>
														<div class="card-body pt-6 pb-4">
															<h6 class="mb-2">Amabelle F</h6>
															<p class="fs--1">Mewemarket was the best investment I ever made. We've used Mewemarket for the last five Months. Mewemarket impressed me on multiple levels.</p>
															<a class="fs--2 mb-3 d-inline-block text-decoration-none" href="#review" data-tab-target="#review" data-fancyscroll data-offset="80"><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span class="fa fa-star text-warning "></span></a>
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>
							<!-- end of .container-->
						</div>
					</div>
				</div>
			</div>

			<?php $this->load->view('partial/footer'); ?>
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



<?php if(isset($_GET['passwordChanged'])){ ?>

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

				toastr.success('You have successfully changed your password.');


			});
		});



	</script>



<?php  }?>





</body>

</html>
