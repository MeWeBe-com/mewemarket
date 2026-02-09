	<!-- ===============================================-->
	<!--    Favicons-->
	<!-- ===============================================-->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url();?>assets/img/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>assets/img/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/img/favicons/favicon-16x16.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/img/favicons/favicon.ico">
	<link rel="manifest" href="<?php echo base_url();?>assets/img/favicons/manifest.json">
	<meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
	<meta name="theme-color" content="#ffffff">
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->

    <script src="<?php echo base_url('assets/js/config.navbar-vertical.js?A')?> "></script>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="<?php echo base_url('assets/lib/perfect-scrollbar/perfect-scrollbar.css?A');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/prismjs/prism-okaidia.css?A');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css?A');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css?A');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/leaflet/leaflet.css?A');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/leaflet.markercluster/MarkerCluster.css?A');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/leaflet.markercluster/MarkerCluster.Default.css?A');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/owl.carousel/owl.carousel.css?A');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/dropzone/dropzone.min.css?A');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/lib/toastr/toastr.min.css?A');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/lib/flatpickr/flatpickr.min.css?A');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/plyr/plyr.css?A');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/fancybox/jquery.fancybox.min.css?A');?>" rel="stylesheet">

	<meta name="google-site-verification" content="3c4q_qocIk8Xi1mO9uqkuDmoTarNK38l3vGmOxvJ9f4" />

	<?php  if($this->input->cookie('theme_mode') == 1){?>
		<link async href="<?php echo base_url();?>assets/css/theme.css?b" id="Theme" rel="stylesheet">
	<?php }elseif($this->input->cookie('theme_mode') == 2){ ?>
		<link async href="<?php echo base_url();?>assets/css/theme-dark.css?b" id="Theme" rel="stylesheet">
	<?php }else{ ?>
		<link async href="<?php echo base_url();?>assets/css/theme-dark.css?b" id="Theme" rel="stylesheet">
	<?php } ?>

	<link href="<?php echo base_url('assets/css/custom.css?A');?>" rel="stylesheet">

	<script type='text/javascript'>
		window.smartlook||(function(d) {
			var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
			var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
			c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
		})(document);
		smartlook('init', '56d8bdd735752b67f92182709f6be157c520c8d0');
	</script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-HSCJP271FF"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-HSCJP271FF');
	</script>


