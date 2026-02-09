<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title> <?php echo ($products[0]->product_name);?> | <?php echo $products[0]->category_name ;?> | MeweMarket</title>

	<?php $this->load->view('partial/head') ;?>

	  <link href="<?php echo base_url();?>assets/lib/plyr/plyr.css" rel="stylesheet">
  </head>
  <body>

  <main class="main" id="top">
	  <div class="container" data-layout="container">
		  <?php $this->load->view('partial/sidebar')?>

		  <div class="content">
			  <?php $this->load->view('partial/header')?>
			  <div class="row">
				  <div class="space mb-0 w-100"></div>
				  <div class="row no-gutters w-100">

					  <nav aria-label="breadcrumb">
						  <ol class="breadcrumb pt-0">
							  <li class="breadcrumb-item fs--1">
								  <a href="<?php echo base_url();?>">Home</a>
							  </li>
							  <li class="breadcrumb-item fs--1" >
								  <a href="<?php echo base_url('category');?>">
									  <?php echo 'Categories';?>
								  </a>
							  </li>
							  <li class="breadcrumb-item fs--1" >
								  <a href="<?php echo base_url('category/ViewCategory/'.$products[0]->category_id);?>">
									  <?php echo $products[0]->category_name ;?>
								  </a>
							  </li>
							  <li class="breadcrumb-item fs--1 active" aria-current="page">
								  <?php echo ($products[0]->product_name);?>
							  </li>
						  </ol>
					  </nav>

					  <div class="card mb-3 w-100">
						  <div class="card-body">
							  <div class="row">
								  <div class="col-lg-6 mb-4 mb-lg-0">
									  <img class="rounded w-100 fit-cover" src="<?php echo base_url('uploads/products/feature_img/'.$products[0]->featured_image)?>" alt="">
									  <div class="col-lg-12 text-center row pl-0 pr-0 no-gutters">
										  <div class="col-6 pr-3">
											  <?php if(empty($this->session->userdata('user_id'))){if ($products[0]->payment_type == 1){?>
																<a id="activate" value="<?php echo $products[0]->product_id;?>" class="btn btn-sm btn-primary d-lg-block mt-2 Deactivated fs--1" href="<?php echo $product->demo_link;?>">
																	<span class="fas fa-cart-arrow-down"></span>
																	<span class="ml-2 d-none d-md-inline-block">Free</span>
																</a>
															<?php }else{ ?>
												  <a class="btn btn-sm btn-primary d-lg-block mt-2 notlogin" href="javascript:;">
													  <span class="fas fa-cart-arrow-down"></span>
													  <span class="ml-2 d-none d-md-inline-block ">Activate</span>
												  </a>
											  <?php } }else{?>
												  <?php  if ($products[0]->payment_type == 1){ ?>
																<a id="activate" value="<?php echo $products[0]->product_id;?>" class="btn btn-sm btn-primary d-lg-block mt-2 Deactivated fs--1" href="<?php echo $product->demo_link;?>">
																	<span class="fas fa-cart-arrow-down"></span>
																	<span class="ml-2 d-none d-md-inline-block">Free</span>
																</a>
															<?php }elseif (in_array($products[0]->product_id, array_column($userproducts, 'product_id'))){ ?>
													  <a id="activate" value="<?php echo $products[0]->product_id;?>" class="btn btn-sm btn-primary d-lg-block mt-2 Deactivated" target="_blank" href="<?php echo $userproducts[0]->app_url;?>">
														  <span class="fas fa-cart-arrow-down"></span>
														  <span class="ml-2 d-none d-md-inline-block Buytext<?php echo $products[0]->product_id;?>">Activated</span>
													  </a>
												  <?php }else{ ?>
													  <a id="activate" value="<?php echo $products[0]->product_id;?>" class="btn btn-sm btn-primary d-lg-block mt-2 " href="<?php echo base_url('products/ActivateProduct/'.$products[0]->product_id)?>">
														  <span class="fas fa-cart-plus"></span>
														  <span class="ml-2 d-none d-md-inline-block Buytext<?php echo $products[0]->product_id;?>">Activate</span>
													  </a>
												  <?php  }?>
											  <?php }?>
										  </div>
										  <?php if(!empty($products[0]->demo_link)){?>
										  <div class="col-6 pl-3 pl-sm-0"><a class="btn btn-sm btn-outline-secondary border-300 d-lg-block mt-2 mr-2 mr-lg-0" target="_blank" href="<?php echo $products[0]->demo_link;?>">
												  <span class="fab fa-trello"></span><span class="ml-2 d-none d-md-inline-block">Live Preview</span>
											  </a></div>
										  <?php }?>
									  </div>

								  </div>
								  <div class="col-lg-6">
									  <h5>
										  <?php echo ($products[0]->product_name);?>
									  </h5>
									  <span class="fs--1 mb-2 d-block" href="#!"><?php echo ($products[0]->product_type);?></span>
									  	  <span class="fs--1 <?php if($products[0]->rating >= 1){ echo 'fa fa-star text-warning' ; }else{ echo 'fa fa-star' ; } ?>"></span>
										  <span class="fs--1 <?php if($products[0]->rating >= 2){ echo 'fa fa-star text-warning' ; }else{ echo 'fa fa-star' ; } ?>"></span>
										  <span class="fs--1 <?php if($products[0]->rating >= 3){ echo 'fa fa-star text-warning' ; }else{ echo 'fa fa-star' ; } ?>"></span>
										  <span class="fs--1 <?php if($products[0]->rating >= 4){ echo 'fa fa-star text-warning' ; }else{ echo 'fa fa-star' ; } ?>"></span>
										  <span class="fs--1 <?php if($products[0]->rating >= 5){ echo 'fa fa-star text-warning' ; }else{ echo 'fa fa-star' ; } ?> star-icon"></span>
										  <span class="ml-1 fs--1 text-600 ">(<?php echo $products[0]->rating;?>)</span>

									 	  <ul class="list-unstyled d-none d-lg-block mt-3 fs--1">

											  <?php $details = explode(PHP_EOL,$products[0]->key_benefits);
											  foreach($details as $detail){ if(!empty($detail)){  ?>
											  <li>
												  <span class="mb-2 d-inline-block">
													 <?php echo $detail;?>
												  </span>
											  </li>
											  <?php }}?>
									  </ul>
									  <div class="btn-group">
										  <?php $slug = url_title($products[0]->product_name, 'dash', true); ?>
										  <div class="btn btn--label btn--group-item fs--1 bg-dark">Share</div>
										  <a onclick="OpenWindow(1)" id="1" class="btn btn--group-item fs--1 bg-dark" data-social-network="Facebook"  data-href="https://www.facebook.com/sharer/sharer.php?display=popup&amp;u=<?php echo base_url('products/ViewProduct/'.$products[0]->product_id.'/'.$slug);?>" ><span class="fab fa-facebook-f"></span></a>
										  <a onclick="OpenWindow(2)" id="2" class="btn btn--group-item fs--1 bg-dark" data-social-network="Twitter"   data-href="https://twitter.com/intent/tweet?text=Check out <?php echo ($products[0]->product_name);?> on Mewemarket&url=<?php echo base_url('products/ViewProduct/'.$products[0]->product_id);?>"><span class="fab fa-twitter"></span></a>
										  <a onclick="OpenWindow(3)" id="3" class="btn btn--group-item fs--1 bg-dark" data-social-network="Pinterest" data-href="http://pinterest.com/pin/create/button?description=<?php echo ($products[0]->product_name);?>&media=<?php echo base_url('uploads/products/feature_img/'.$products[0]->featured_image)?>&url=<?php echo base_url('products/ViewProduct/'.$products[0]->product_id.'/'.$slug);?>"><span class="fab fa-pinterest-p"></span></a>
									  </div>
								  </div>
							  </div>
							  <div class="row">
								  <div class="col-12">
									  <div class="fancy-tab overflow-hidden mt-2">
										  <div class="nav-bar">
											  <div class="nav-bar-item active pl-0 pr-2 pr-sm-4">
												  <div class="mt-1 fs--1">Description</div>
											  </div>
											<!--  <div class="nav-bar-item px-2 px-sm-4">
												  <div class="mt-1 fs--1">Key Features</div>
											  </div>-->
											<!--  <?php /*if(!empty($product_images)){*/?>
												  <div class="nav-bar-item px-2 px-sm-4" id="review">
													  <div class="mt-1 fs--1">Screenshots</div>
												  </div>
											  --><?php /* } */?>
										  </div>
										  <div class="tab-contents">
											  <div class="tab-content active fs--1">
											  	<?php echo nl2br($products[0]->description);
											  	if(!empty($products[0]->product_video)){ ?>

												  <video class="mt-3"
													  controls
													  crossorigin
													  playsinline
													  width="100%"
													  data-poster="<?php echo base_url('uploads/products/product_video/'.$products[0]->product_video);?>"
													  id="player">

													  <!-- Video files -->
													  <source
														  src="<?php echo base_url('uploads/products/product_video/'.$products[0]->product_video);?>"
														  type="video/mp4"
														  size="576"
													  />
													  <source
														  src="<?php echo base_url('uploads/products/product_video/'.$products[0]->product_video);?>"
														  type="video/mp4"
														  size="720"
													  />
													  <source
														  src="<?php echo base_url('uploads/products/product_video/'.$products[0]->product_video);?>"
														  type="video/mp4"
														  size="1080"
													  />
												</video>
												  <?php }?>

												  <?php foreach($product_images as $key => $image){ ?>
														<img class="d-block w-100 mb-3" src="<?php echo base_url('uploads/products/ss/'.$image->image)?>" alt="<?php echo $key;?>" />
												  <?php }?>
											  </div>

											  <div class="tab-content ">
												  <?php echo nl2br($products[0]->key_benefits);?>
											  </div>
											  <!--<div class="tab-content">
												  <div class="row no-gutters">
													  <div class="carousel slide carousel-fade" id="carouselExampleFade" data-ride="carousel">
														  <div class="carousel-inner rounded">
															  <?php /*foreach($product_images as $key => $image){ */?>
															  <div class="carousel-item <?php /*if($key == 0 ){ echo "active"; }*/?>">
																  <img class="d-block w-100" src="<?php /*echo base_url('uploads/products/ss/'.$image->image)*/?>" alt="First slide" />
															  </div>
														 		<?php /*}*/?>
														  </div>
														  <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
															  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
															  <span class="sr-only">Previous</span>
														  </a>
														  <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
															  <span class="carousel-control-next-icon" aria-hidden="true"></span>
															  <span class="sr-only">Next</span>
														  </a>
													  </div>
												  </div>
											  </div>-->
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

  <script src="<?php echo base_url();?>assets/lib/plyr/plyr.polyfilled.min.js"></script>

  <script>
	  function OpenWindow(id) {
		  var link = $('#'+id).attr('data-href');
		  var name = $('#'+id).attr('data-social-network');

		  console.log(link);

		  window.open(link, name, "width=500,height=500")
	  }
  </script>

  </body>
</html>
