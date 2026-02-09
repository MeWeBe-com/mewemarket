<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="<?php echo base_url();?>assets/lib/dropzone/dropzone.min.css" rel="stylesheet">
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<title>Create Product | MeweMarket</title>

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
				<div class="col-md-12 col-xxl-12 mb-3 pr-md-2">
					<div class="card mb-3">
						<div class="card-header">
							<h5 class="mb-0">Add Product</h5>
						</div>
						<div class="card-body bg-light">
							<form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/AddProduct')?>">
								<input class="form-control"
									   type="hidden"
									   name="product_id"
									   value="<?php if(!empty($product[0]->product_id)){ echo $product[0]->product_id; } ?>">
								<div class="form-row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="event-name">
												Product Title
											</label>
											<input class="form-control"
												   id="event-name"
												   type="text"
												   name="product_name"
												   required=""
												   placeholder="Product Name"
												   value="<?php if(!empty($product[0]->product_name)){ echo $product[0]->product_name; } ?>">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="package-duration">
												Product Category
											</label>
											<select required="" class="custom-select" required id="wizard-country" name="category_id">
												<option value="">Select Product Category ...</option>
												<?php foreach($categories as $category){  ?>
													<option <?php if(!empty($category) && !empty($product) && $category->category_id == $product[0]->category_id){ echo "selected"; }?> value="<?php echo $category->category_id;?>"><?php echo $category->category_name;?></option>
												<?php }?>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="package-amount">
												Product Type
											</label>
											<input class="form-control"
												   id="package-amount"
												   name="product_type"
												   type="text"
												   required=""
												   placeholder="Package Type"
												   value="<?php if(!empty($product[0]->product_type)){ echo $product[0]->product_type; } ?>"></div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label for="Visibility">
												Product Demo link
											</label>
											<input class="form-control"
												   name="demo_link"
												   type="url"
												   placeholder="Demo link"
												   required=""
												   value="<?php if(!empty($product[0]->demo_link)){ echo $product[0]->demo_link; } ?>">
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label for="Visibility">
												Featured Image
											</label>
											<input class="form-control"
												   name="featured_image"
												   type="file"
												   placeholder="" >
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label for="Visibility">
												Product Video
											</label>
											<input class="form-control"
												   name="product_video"
												   type="file"
												   placeholder="Product Video" >
										</div>
									</div>
								</div>
								<div class="col-12 px-0">
										<div class="form-group">
											<label for="event-description">
												Description
											</label>
											<textarea name="description"
													  class="form-control d-none tinymce "
													  id="event-description"
													  required=""
													  rows="6"><?php if(!empty($product[0]->description)){ echo $product[0]->description; } ?></textarea>
										</div>
									</div>

									<div class="col-12">
										<hr class="border-dashed border-bottom-0">
									</div>

									<div class="col-12 px-0">
										<div class="form-group">
											<label for="event-description">
												Key Benefits
											</label>
											<textarea name="key_benefits"
													  class="form-control"
													  id="event-description"
													  required=""
													  rows="6"><?php if(!empty($product[0]->key_benefits)){ echo $product[0]->key_benefits; } ?></textarea>
										</div>
									</div>

								<div class="col-12">
									<hr class="border-dashed border-bottom-0">
								</div>

								<div class="form-row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="browsers">
												Compatible Browsers
											</label>
											<?php if(!empty($product[0]->compatible_browsers)){ $compatible_browsers = explode('|',$product[0]->compatible_browsers) ; } ?>
											<select required="" class="form-control selectpicker" id="browsers" multiple size="1" name="compatible_browsers[]" data-options='{"placeholder":"Select Compatible Browsers..."}'>
												<option <?php if(!empty($compatible_browsers)){ if (in_array("IE6", $compatible_browsers)) {echo "selected";} }?> value="IE6">IE6</option>
												<option <?php if(!empty($compatible_browsers)){ if (in_array("Firefox", $compatible_browsers)) {echo "selected";} }?> value="Firefox">Firefox</option>
												<option <?php if(!empty($compatible_browsers)){ if (in_array("Safari", $compatible_browsers)) {echo "selected";} }?> value="Safari">Safari</option>
												<option <?php if(!empty($compatible_browsers)){ if (in_array("Chrome", $compatible_browsers)) {echo "selected";} }?> value="Chrome">Chrome</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="Files Included">
												Files Included
											</label>
											<?php if(!empty($product[0]->files_included)){ $files_included = explode('|',$product[0]->files_included) ; } ?>
											<select required="" class="form-control selectpicker" id="Files Included" multiple size="1" name="files_included[]" data-options='{"placeholder":"Select Files Included..."}'>
												<option <?php if(!empty($files_included)){ if (in_array("HTML", $files_included)) {echo "selected";} }?> value="HTML">HTML</option>
												<option <?php if(!empty($files_included)){ if (in_array("CSS", $files_included)) {echo "selected";} }?> value="CSS">CSS</option>
												<option <?php if(!empty($files_included)){ if (in_array("JavaScript JS", $files_included)) {echo "selected";} }?> value="JavaScript JS">JavaScript JS</option>
												<option <?php if(!empty($files_included)){ if (in_array("JavaScript JSON", $files_included)) {echo "selected";} }?> value="JavaScript JSON">JavaScript JSON</option>
												<option <?php if(!empty($files_included)){ if (in_array("PHP", $files_included)) {echo "selected";} }?> value="PHP">PHP</option>
												<option <?php if(!empty($files_included)){ if (in_array("XML", $files_included)) {echo "selected";} }?> value="XML">XML</option>
												<option <?php if(!empty($files_included)){ if (in_array("SQL", $files_included)) {echo "selected";} }?> value="SQL">SQL</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="Software Framework">
												Software Framework
											</label>
											<?php if(!empty($product[0]->software_framework)){ $software_framework = explode('|',$product[0]->software_framework) ; } ?>
											<select required="" class="form-control selectpicker" id="Software Framework" multiple size="1" name="software_framework[]" data-options='{"placeholder":"Select Software Framework..."}'>
												<option <?php if(!empty($software_framework)){ if (in_array("Core PHP", $software_framework)) {echo "selected";} }?> value="Core PHP">Core PHP</option>
												<option <?php if(!empty($software_framework)){ if (in_array("CodeIgniter", $software_framework)) {echo "selected";} }?> value="CodeIgniter">CodeIgniter</option>
												<option <?php if(!empty($software_framework)){ if (in_array("Laravel", $software_framework)) {echo "selected";} }?> value="Laravel">Laravel</option>
												<option <?php if(!empty($software_framework)){ if (in_array("Kohana", $software_framework)) {echo "selected";} }?> value="Kohana">Kohana</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="Software Version">
												Software Version
											</label>
											<?php if(!empty($product[0]->software_version)){ $software_version = explode('|',$product[0]->software_version) ; } ?>
											<select required="" class="form-control selectpicker" id="Software Version" multiple size="1" name="software_version[]" data-options='{"placeholder":"Select Software Framework..."}'>
												<option <?php if(!empty($software_version)){ if (in_array("PHP 5.x", $software_version)) {echo "selected";} }?> value="PHP 5.x">PHP 5.x</option>
												<option <?php if(!empty($software_version)){ if (in_array("PHP 7.x", $software_version)) {echo "selected";} }?> value="PHP 7.x">PHP 7.x</option>
												<option <?php if(!empty($software_version)){ if (in_array("MySQL 4.x", $software_version)) {echo "selected";} }?> value="MySQL 4.x">MySQL 4.x</option>
												<option <?php if(!empty($software_version)){ if (in_array("MySQL 5.x", $software_version)) {echo "selected";} }?> value="MySQL 5.x">MySQL 5.x</option>
											</select>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label for="Software Version">
												Api Type
											</label>
											<select required="" class="form-control selectpicker" id="api_type"  size="1" name="api_type" data-options='{"placeholder":"Select Api Type..."}'>
												<option <?php if(!empty($product[0]->api_type) && $product[0]->api_type == 'saas_app' ){ echo  'selected'; } ?> value="saas_app">Saas App</option>
												<option value="clone_app" <?php if(!empty($product[0]->api_type) && $product[0]->api_type == 'clone_app' ){ echo  'selected'; } ?>>Clone App</option>
												<option value="normal_app" <?php if(!empty($product[0]->api_type) && $product[0]->api_type == 'normal_app' ){ echo  'selected'; } ?>>Normal App</option>
											</select>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label for="api_url">
												Api URL
											</label>
											<input class="form-control"
												   name="api_url"
												   type="url"
												   placeholder="Api url"
												   value="<?php if(!empty($product[0]->api_url)){ echo $product[0]->api_url; } ?>" >
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label for="rating">
												Star Rating
											</label>
											<select required="" class="form-control selectpicker" id="rating"  size="1" name="rating" data-options='{"placeholder":"Select Star Rating..."}'>
												<option  value="1" <?php if(!empty($product[0]->rating) && $product[0]->rating == '1' ){ echo  'selected'; } ?>>1</option>
												<option value="2" <?php if(!empty($product[0]->rating) && $product[0]->rating == '2' ){ echo  'selected'; } ?>>2</option>
												<option value="3" <?php if(!empty($product[0]->rating) && $product[0]->rating == '3' ){ echo  'selected'; } ?>>3</option>
												<option value="4" <?php if(!empty($product[0]->rating) && $product[0]->rating == '4' ){ echo  'selected'; } ?>>4</option>
												<option value="5" <?php if(!empty($product[0]->rating) && $product[0]->rating == '5' ){ echo  'selected'; } ?>>5</option>

											</select>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label for="Total Sales">
												Total Sales
											</label>
											<input class="form-control"
												   name="total_sales"
												   type="text"
												   placeholder="Total Sales Ex( 100, 200, 300 )"
												   value="<?php if(!empty($product[0]->total_sales)){ echo $product[0]->total_sales; } ?>" >
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label for="Featured Tag">
												Featured Tag
											</label>
											<input class="form-control"
												   name="featured_tag"
												   type="text"
												   placeholder="Featured Tag Ex( New, Top Seller, Responsive)"
												   value="<?php if(!empty($product[0]->featured_tag)){ echo $product[0]->featured_tag; } ?>" >
										</div>
									</div>

									<?php if(!empty($product[0])){ $id = $product[0]->product_id; }else{ $id = ""; } ?>

								<div class="col-lg-12  mb-3">
										<div class="card-body bg-light">
											<div class="dropzone dropzone-multiple p-0" data-dropzone data-options='{"url":"<?php echo base_url();?>admin/UploadGalleryImages/<?php echo $id;?>"}'>
												<div class="fallback">
													<input type="file" name="gallery[]">
												</div>
												<div class="dz-message" data-dz-message>
													<img class="mr-2" src="<?php echo base_url();?>assets/img/icons/cloud-upload.svg" width="25" alt="">
													Drop your files here
												</div>

												<?php if(!empty($productImages)){ ?>
													<div  class="dz-preview dz-preview-multiple m-0 d-flex flex-column">
														<div class="media align-items-center mb-3 pb-3 border-bottom btn-reveal-trigger">
															<img class="dz-image" src="..." alt="..." data-dz-thumbnail>
															<div class="media-body d-flex flex-between-center">
																<div>
																	<h6 data-dz-name></h6>
																	<div class="d-flex align-items-center">
																		<p class="mb-0 fs--1 text-400 line-height-1" data-dz-size></p>
																		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
																	</div>
																</div>
																<div class="dropdown text-sans-serif">
																	<button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h"></span></button>
																	<div class="dropdown-menu dropdown-menu-right border py-0">
																		<div class="bg-white py-2"><a class="dropdown-item" value="" href="#!"  data-dz-remove>Remove File</a></div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<?php foreach($productImages as $gallery){   ?>

														<div id="Remove<?php echo $gallery->id;?>" class="dz-preview dz-preview-multiple m-0 d-flex flex-column">
															<div class="media align-items-center mb-3 pb-3 border-bottom btn-reveal-trigger">
																<img class="dz-image" src="<?php echo base_url();?>/uploads/products/ss/<?php echo $gallery->image;?>" alt="..." data-dz-thumbnail>
																<div class="media-body d-flex flex-between-center">
																	<div>
																		<h6 data-dz-name> <?php echo $gallery->image;?></h6>
																		<div class="d-flex align-items-center">
																			<p class="mb-0 fs--1 text-400 line-height-1" data-dz-size></p>
																			<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
																		</div>
																	</div>
																	<div class="dropdown text-sans-serif">
																		<button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h"></span></button>
																		<div class="dropdown-menu dropdown-menu-right border py-0">
																			<div class="bg-white py-2 px-2 cursor-pointer"><span class="Remove" value="<?php echo $gallery->id;?>">Remove File</span></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>

													<?php } }else{?>
												<div  class="dz-preview dz-preview-multiple m-0 d-flex flex-column">
													<div class="media align-items-center mb-3 pb-3 border-bottom btn-reveal-trigger">
														<img class="dz-image" src="..." alt="..." data-dz-thumbnail>
														<div class="media-body d-flex flex-between-center">
															<div>
																<h6 data-dz-name></h6>
																<div class="d-flex align-items-center">
																	<p class="mb-0 fs--1 text-400 line-height-1" data-dz-size></p>
																	<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
																</div>
															</div>
															<div class="dropdown text-sans-serif">
																<button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h"></span></button>
																<div class="dropdown-menu dropdown-menu-right border py-0">
																	<div class="bg-white py-2"><a class="dropdown-item" value="" href="#!"  data-dz-remove>Remove File</a></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<?php }?>

										</div>
									</div>

								<div class="col-12">
									<hr class="border-dashed border-bottom-0">
								</div>

								<div class="col-12 d-flex justify-content-end">
									<button class="btn btn-primary" type="submit">Save </button>
								</div>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<?php $this->load->view('admin/footer')?>
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
		<div class="toast bg-white notice" id="cookie-notice" role="alert" data-options='{"autoShow":false,"autoShowDelay":3000,"showOnce":true,"cookieExpireTime":7200000}' data-autohide="false" aria-live="assertive" aria-atomic="true">
			<div class="toast-body d-flex justify-content-center px-5">
				<div class="d-lg-flex align-items-center text-center">
					<button class="close text-shadow-none position-absolute t-0 r-0 p-2 mr-2 mt-2" type="button" data-dismiss="toast" aria-label="Close"><span class="font-weight-medium" aria-hidden="true">×</span></button><img class="mr-2" src="../assets/img/icons/cookie.png" width="20" alt="" />
					<p class="mb-2 mb-lg-0">
						Our site uses cookies. By continuing to use our site, you agree to our <a class="text-underline" href="../components/cookie-notice.html">Cookie Policy</a>.</p>
					<button class="btn btn-primary btn-sm ml-3" type="button" data-dismiss="toast" aria-label="Close">Ok, I Understand</button>
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
<?php $this->load->view('partial/footerscript')?>
<script src="<?php echo base_url()?>assets/lib/tinymce/tinymce.min.js"></script>

<script>

	$(document).ready(function(){
		$('.Remove').on('click', function() {
			var gallery_id = $(this).attr('value');
			$.ajax({url: "<?php echo base_url();?>admin/DeleteGalleryImageById/"+gallery_id, success: function(result){
					$('#Remove'+gallery_id).remove();
				}
			});
		});
	});

</script>

</body>

</html>
