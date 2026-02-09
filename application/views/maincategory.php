<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Categories | MeweMarket</title>

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
							  <li class="breadcrumb-item fs--1" aria-current="page">
								  Categories
							  </li>

						  </ol>
					  </nav>


					  <div class="card mb-3 w-100">
						  <div class="card-header bg-light">
							  <div class="row align-items-center">
								  <div class="col">
									  <h5 class="mb-0" id="followers">Categories <span class="d-none d-sm-inline-block"></span></h5>
								  </div>

							  </div>
						  </div>
						  <div class="card-body bg-light p-0">
							  <div class="row no-gutters text-center fs--1 bg-white">
								  <?php foreach($categories as $category){?>
									  <?php $slug = url_title($category->category_name, 'dash', true);?>
								  <div class="col-6 col-md-4 col-lg-4 col-xxl-2 mb-1">
									  <div class="bg-white p-3 h-100">
										  <a href="<?php echo base_url('category/ViewCategory/'.$category->category_id.'/'.$slug)?>">
											  <span>
											  <i class="<?php echo $category->category_icon?> text-dark fs-4 mb-2"></i>
											  </span>
										  </a>

										  <h6 class="mb-1">
											  <a class="text-dark " href="<?php echo base_url('category/ViewCategory/'.$category->category_id.'/'.$slug)?>"><?php echo $category->category_name?></a>
										  </h6>

									  </div>
								  </div>

								  <?php }?>

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

  	<script>
		$(document).ready(function () {
			$('.Deactivated').on('click',function(){
				var product_id = $(this).attr('value');

				$.ajax({url: "<?php echo base_url();?>users/DeleteTools?product_id="+product_id, success: function(result){
						if(result == 'Done'){
							$('#'+product_id).removeClass('Deactivated');
							$('#'+product_id).addClass('Activate');
							$('.Buytext').text('Activate');
						}else{

						}
					}
				});

			});
		});

		$(document).ready(function(){
			$('.Activate').on('click', function() {
				var product_id = $(this).attr('value');

				$.ajax({url: "<?php echo base_url();?>users/ActivateTools?product_id="+product_id, success: function(result){
						if(result == 'Done'){
							$('#'+product_id).removeClass('Activate');
							$('#'+product_id).addClass('Deactivated');
							$('.Buytext').text('Activated');
						}else{
							alert('Limit Exceed');
						}
					}
				});
			});
		});
	</script>

  </body>
</html>
