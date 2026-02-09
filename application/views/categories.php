<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title><?php echo $category[0]->category_name;?> | MeweMarket</title>

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
				  <div class="row no-gutters w-100">

					  <nav aria-label="breadcrumb">
						  <ol class="breadcrumb pt-0">
							  <li class="breadcrumb-item fs--1">
								  <a href="<?php echo base_url();?>">Home</a>
							  </li>
							  <li class="breadcrumb-item fs--1" >
								   <a href="<?php echo base_url('category');?>">Categories</a>
							  </li>
							  <li class="breadcrumb-item fs--1" aria-current="page">
								  <?php echo $category[0]->category_name;?>
							  </li>

						  </ol>
					  </nav>

					  <div class="card mb-3 w-100">
						  <div class="card-body">
							  <div class="row justify-content-between align-items-center">
								  <div class="col-sm-auto mb-2 mb-sm-0">
									  <h5 class="mb-0"><?php echo $category[0]->category_name;?></h5>
								  </div>

							  </div>
						  </div>
					  </div>
					  <div class="card mb-3 w-100">
						  <div class="card-body p-0 overflow-hidden">
							  <div class="row no-gutters">
							<?php if(empty($products)){ ?>
								<h3 class="px-3 py-3">No Result Found</h3>
							 <?php }else{
								foreach($products as $product){?>
								<div class="col-12 p-3">
									<div class="p-1">
										  <div class="row">
											  <div class="col-sm-5 col-md-4">
												  <div class="position-relative h-sm-100">
													  <a class="d-block h-100" href="<?php echo base_url('products/ViewProduct/'.$product->product_id);?>">
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
															  <span class="text-500">
																  <?php echo $product->product_type;?>
															  </span>
														  </p>

														  <ul class="list-unstyled d-none d-lg-block fs--1">
															  <?php $details = explode(PHP_EOL,$product->key_benefits);
															  foreach($details as $detail){  ?>
																  <li>
																	  <span class="mb-2 d-inline-block">
													 <?php echo $detail;?>
												  </span>
																  </li>
															  <?php }?>
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
																  <p class="fs--1 mb-1">Updated on: <strong class=""><?php $date = date_create($product->created_at); echo date_format($date,'d M, y');?></strong>
																  </p>
															  </div>
														  </div>
														  <div class="mt-md-2">
															<?php if(empty($this->session->userdata('user_id'))){ ?>
																<a class="btn btn-sm btn-outline-danger border-300 hearticon w-100" href="#!" data-toggle="tooltip" data-placement="top" title="Add to Wish List">
																	<span class="hearticon far fa-heart mr-1"></span>Favourites
																</a>

															<?php }else{ ?>
															  <a value="<?php echo $product->product_id;?>" id="heart<?php echo $product->product_id;?>" class="fs--1 btn btn-sm btn-outline-danger border-300 d-lg-block mt-2 mr-2 mr-lg-0 <?php if(!in_array($product->product_id, array_column($userfavourite, 'product_id')) && !empty($this->session->userdata('user_id'))){ echo 'hearticon '; }else{ echo 'dehearticon active'; }?>">
																  <span value="<?php echo $product->product_id;?>" id="<?php echo $product->product_id;?>" class="<?php if(!in_array($product->product_id, array_column($userfavourite, 'product_id')) && !empty($this->session->userdata('user_id'))){ echo 'hearticon far fa-heart'; }else{ echo 'dehearticon fas fa-heart'; }?>"></span>
																  <span class="ml-2 d-none d-md-inline-block">Favourites</span>
															  </a> <?php }?>
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
															  <?php } }else{?>


																  <?php $key = array_search($product->product_id, array_column($userproducts, 'product_id'));

																   if ($product->payment_type == 1){ ?>
																<a id="activate" value="<?php echo $product->product_id;?>" class="btn btn-sm btn-primary d-lg-block mt-2 Deactivated fs--1" href="<?php echo $product->demo_link;?>">
																	<span class="fas fa-cart-arrow-down"></span>
																	<span class="ml-2 d-none d-md-inline-block">Free</span>
																</a>
															<?php }elseif (in_array($product->product_id, array_column($userproducts, 'product_id')) && $userproducts[$key]->status == 'activate'){ ?>
																	  <a id="activate" value="<?php echo $product->product_id;?>" class="fs--1 btn btn-sm btn-primary d-lg-block mt-2 Deactivated" href="<?php echo $userproducts[$key]->app_url; ?>">
																		  <span class="fas fa-cart-arrow-down"></span>
																		  <span class="ml-2 d-none d-md-inline-block Buytext<?php echo $product->product_id;?>">Activated</span>
																	  </a>
																  <?php }elseif (in_array($product->product_id, array_column($userproducts, 'product_id')) && $userproducts[$key]->status == 'suspend'){ ?>
																	  <a id="activate" value="<?php echo $product->product_id;?>" class="fs--1 btn btn-sm btn-primary d-lg-block mt-2 Deactivated" href="<?php echo base_url('users/dashboard');?>">
																		  <span class="fas fa-cart-arrow-down"></span>
																		  <span class="ml-2 d-none d-md-inline-block Buytext<?php echo $product->product_id;?>">Re-activate</span>
																	  </a>
																  <?php }else{ ?>
																	  <a id="activate" value="<?php echo $product->product_id;?>" class="fs--1 btn btn-sm btn-primary d-lg-block mt-2 " href="<?php echo base_url('products/ActivateProduct/'.$product->product_id)?>">
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
								<?php } }?>


							  </div>
						  </div>
						  <div class="card-footer border-top d-flex justify-content-center">
							  <?php echo $pagination;?>
							  <!--  <div>
									<button class="btn btn-falcon-default btn-sm mr-1 mr-sm-2" type="button" disabled data-toggle="tooltip" data-placement="top" title="Prev"><span class="fas fa-chevron-left"></span></button><a class="btn btn-sm btn-falcon-default text-primary mr-2" href="#!">1</a><a class="btn btn-sm btn-falcon-default mr-2" href="#!">2</a><a class="btn btn-sm btn-falcon-default mr-2" href="#!"><span class="fas fa-ellipsis-h"></span></a><a class="btn btn-sm btn-falcon-default mr-2" href="#!">35</a>
									<button class="btn btn-falcon-default btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Next"><span class="fas fa-chevron-right"></span></button>
								</div>-->
							</div>
					  </div>
				  </div>
			  </div>

			  <?php $this->load->view('partial/footer'); ?>
		  </div>

	  </div>
  </main>
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
