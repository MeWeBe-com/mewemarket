<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Verification Login - Lims</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <?php include('partial/head.php') ?>
</head>

<body>

	<div id="background-carousel">
    <div id="carouselExampleFade" class="carousel  fade" data-ride="carousel">
      <div class="carousel-inner">
        <div class="item active" style="background-image:url('assets/img/background/bg1.jpg')"></div>
        <div class="item" style="background-image:url('assets/img/background/bg2.jpg')"></div>
        <div class="item" style="background-image:url('assets/img/background/bg3.jpg')"></div>
        <div class="item " style="background-image:url('assets/img/background/bg7.jpg')"></div>
        <div class="item" style="background-image:url('assets/img/background/bg4.jpg')"></div>
        <div class="item" style="background-image:url('assets/img/background/bg5.jpg')"></div>
        <div class="item" style="background-image:url('assets/img/background/bg6.jpg')"></div>
       
      </div>
    </div>
</div>

    <nav class="navbar navbar-transparent navbar-absolute">
	    <div class="container">
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
	                <span class="sr-only">Toggle navigation</span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	            </button>
	            <a class="navbar-brand" href="index.php"><img src="<?php echo base_url()?>assets/img/logo.png"></a>
	        </div>
	        <div class="collapse navbar-collapse">
	            <ul class="nav navbar-nav navbar-right">

	            </ul>
	        </div>
	    </div>
	</nav>

	<div class="wrapper wrapper-full-page">
		<div class="full-page lock-page" data-color="green" data-image="<?php echo base_url()?>assets/img/background/homebg1.jpg">
	    <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
	        <div class="content">
	            <form method="post" action="<?php echo base_url()?>user/VerificationLogin">
	                <div class="card card-lock">
	                    <div class="author">
	                        <img class="avatar" src="<?php echo base_url()?>assets/img/faces/face-0.jpg" alt="...">
	                    </div>
	                    <h4><?php if($this->session->userdata('roleId') ==1){
								echo 'Admin';
							}
						elseif($this->session->userdata('roleId') == 2){

								echo 'Doctor';
								
						}elseif($this->session->userdata('roleId') == 3){

								echo 'Hospital';
						} ?></h4>

						<span><?php echo "Verification Code:".$this->session->userdata('Verification_code')?></span>

	                    <span class="help-block">Check your Email for Code.</span>
	                    <div class="form-group">
	                        <input type="text" placeholder="Enter Code" required="true" name="Verification_code" class="form-control">
	                    </div>
	                    <button type="submit" class="btn btn-wd">Unlock</button>
	                </div>
	            </form>
	        </div>
	    	<footer class="footer footer-transparent">
	            <div class="container">
	                <div class="copyright">
	                    &copy; <script>document.write(new Date().getFullYear())</script>, made with 
	                    <i class="fa fa-heart heart"></i> by <a href="index.php">VisioPath</a>
	                </div>
	            </div>
	        </footer>
	    </div>
	</div>
</body>

	<?php include('partial/footerscript.php') ?>

	<script type="text/javascript">
        $().ready(function(){
            demo.checkFullPageBackgroundImage();

            setTimeout(function(){
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700)
        });
	</script>

</html>
