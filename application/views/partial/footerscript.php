    <script src="<?php echo base_url('assets/js/jquery.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/js/popper.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/@fortawesome/all.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/stickyfilljs/stickyfill.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/sticky-kit/sticky-kit.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/is_js/is.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/lodash/lodash.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/perfect-scrollbar/perfect-scrollbar.js?A')?>"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:100,200,300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <script src="<?php echo base_url('assets/lib/prismjs/prism.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/chart.js/Chart.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/datatables/js/jquery.dataTables.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/datatables-bs4/dataTables.bootstrap4.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/datatables.net-responsive/dataTables.responsive.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/leaflet/leaflet.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/leaflet.markercluster/leaflet.markercluster.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/echarts/echarts.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/progressbar.js/progressbar.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/owl.carousel/owl.carousel.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/dropzone/dropzone.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/tinymce/tinymce.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/jquery-validation/jquery.validate.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/flatpickr/flatpickr.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/plyr/plyr.polyfilled.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/fancybox/jquery.fancybox.min.js?A')?>"></script>
    <script src="<?php echo base_url('assets/lib/select2/select2.min.js?A')?>"></script>
	<script src="<?php echo base_url('assets/lib/toastr/toastr.min.js?A')?>"></script>
	<script src="<?php echo base_url('assets/js/theme.js?A')?>"></script>



	<script>
		// Prevents menu from closing when clicked inside
		document.getElementById("login_modal").addEventListener('click', function (event) {
			event.stopPropagation();
		});

		$(document).ready(function(){
			$('#mode').on('click',function(){

				$('.loaderOverlay').show();

				setTimeout(function(){
					$('.loaderOverlay').hide();
				}, 5000);


				if($(this).prop("checked") == true){
					var file = "<?php echo base_url();?>assets/css/theme-dark.css";
					$('#Theme').attr('href',file);
					$.ajax({url: "<?php echo base_url();?>users/ThemeMode/2", success: function(result){
						}
					});
				}

				else if($(this).prop("checked") == false){
					var file = "<?php echo base_url();?>assets/css/theme.css";
					$('#Theme').attr('href',file);
					$.ajax({url: "<?php echo base_url();?>users/ThemeMode/1", success: function(result){
						}
					});
				}

			});

			$('#LightMode').on('click',function(){

				$('.loaderOverlay').css('display','block');

				/*setTimeout(function(){
					$('.loaderOverlay').hide();
				}, 5000);*/

				$('#mode').removeAttr('checked');

				var file = "<?php echo base_url();?>assets/css/theme.css";
				$('#Theme').attr('href',file);

				$.ajax({url: "<?php echo base_url();?>user/ThemeModeLight/1", success: function(result){
					}
				});
			});

			$('#darkMode').on('click',function(){

				$('.loaderOverlay').css('display','block');



				$('#mode').attr('checked','checked');

				var file = "<?php echo base_url();?>assets/css/theme-dark.css";
				$('#Theme').attr('href',file);

				$.ajax({url: "<?php echo base_url();?>user/ThemeModeDark/2", success: function(result){

					}
				});
			});
		});
	</script>

	<script>
		$(document).ready(function(){
			$('body').on('click', '.hearticon', function() {
				var product_id = $(this).attr('value');

				$.ajax({url: "<?php echo base_url();?>users/AddtoFavourite?product_id="+product_id, success: function(result){
						if(result == 'Done'){
							$('#heart'+product_id).removeClass('hearticon');
							$('#heart'+product_id).addClass('dehearticon active');

							toastr.options = {
								"debug": false,
								"newestOnTop": false,
								"positionClass": "toast-top-right",
								"closeButton": true,
								"toastClass": "animated  fadeInDown",
							};

							toastr.success('This tool successfully added in your favourite list');

						}else{
							toastr.options = {
								"debug": false,
								"newestOnTop": false,
								"positionClass": "toast-top-right",
								"closeButton": true,
								"toastClass": "animated  fadeInDown",
							};
							toastr.error('Please login to add this tool in your favourite.');
						}
					}
				});

			});


			$('body').on('click', '.dehearticon', function(){
				var product_id = $(this).attr('value');

				$.ajax({url: "<?php echo base_url();?>users/RemoveFromFavourite?product_id="+product_id, success: function(result){
						if(result == 'Done'){
							$('#heart'+product_id).removeClass('dehearticon');
							$('#heart'+product_id).removeClass('active');
							$('#heart'+product_id).addClass('hearticon');


							toastr.options = {
								"debug": false,
								"newestOnTop": false,
								"positionClass": "toast-top-right",
								"closeButton": true,
								"toastClass": "animated  fadeInDown",
							};

							toastr.success('This tool removed successfully from your favourite list');

						}
					}
				});

			});
		});

		$('body').on('click', '.notlogin', function(){
			toastr.options = {
				"debug": false,
				"newestOnTop": false,
				"positionClass": "toast-top-right",
				"closeButton": true,
				"toastClass": "animated  fadeInDown",
			};
			toastr.error('Please login to activate this tool.');
		});


	</script>

	<?php  if(!empty($this->session->userdata('user_id'))){?>
		<script>
			$(document).ready(function () {
				$('.Activate').on('click',function(){
					var product_id = $(this).attr('value');
					var r = confirm("Are you sure you want to Activate this tool!");
					if (r == true) {
						window.location.replace("<?php echo base_url();?>payment/BuyProduct/"+product_id+'/'+"<?php echo $this->session->userdata('user_id');?>");
					} else {

					}
				});
			});
		</script>
	<?php }?>

	<?php  if(isset($_GET['loginerror'])){?>
		<script>
			toastr.options = {
				"debug": false,
				"newestOnTop": false,
				"positionClass": "toast-top-right",
				"closeButton": true,
				"toastClass": "animated  fadeInDown",
			};
			toastr.error('These credentials do not match our records.');
		</script>
	<?php }?>

	<?php  if(isset($_GET['RegisterSuccess'])){?>
		<script>
			toastr.options = {
				"debug": false,
				"newestOnTop": false,
				"positionClass": "toast-top-right",
				"closeButton": true,
				"toastClass": "animated  fadeInDown",
			};
			toastr.success('You have successfully registered. Please check your email.');
		</script>
	<?php }?>


