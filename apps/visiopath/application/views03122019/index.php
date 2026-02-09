<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Login - Lims</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


     <!-- Bootstrap core CSS     -->
   <?php include('partial/head.php') ?>
   <style>
   
  body {
    -webkit-transform: translatez(0);
    -moz-transform: translatez(0);
    -ms-transform: translatez(0);
    -o-transform: translatez(0);
    transform: translatez(0);
}
   </style>
</head>

<body>



  <div id="background-carousel">
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
      <div class="carousel-inner">
       
        <div class="item active" style="background-image:url('assets/img/background/bg6.jpg')"></div>
       
      </div>
    </div>
</div>

<script>
var currentBackground = 0;

var backgrounds = [];

backgrounds[0] = 'assets/img/background/bg1.jpg';

backgrounds[1] = 'assets/img/background/bg2.jpg';

backgrounds[2] = 'assets/img/background/bg3.jpg';

backgrounds[3] = 'assets/img/background/bg4.jpg';

backgrounds[4] = 'assets/img/background/bg5.jpg';

backgrounds[5] = 'assets/img/background/bg6.jpg';





// Leave the next 5 lines as they are.
var loadedimages = new Array();
for(var i=0; i<backgrounds.length; i++) {
loadedimages[i] = new Image();
loadedimages[i].src = backgrounds[i];
}






function changeBackground() {

    currentBackground++;

    if(currentBackground > 5) currentBackground = 0;

    $('.carousel-inner .item').fadeOut(1000,function() {
        $('.carousel-inner .item').css('background-image',"url('"+backgrounds[currentBackground]+"')");
        $('.carousel-inner .item').fadeIn(500);
    });


    setTimeout(changeBackground, 5000);
}
setTimeout(changeBackground, 5000);
</script>


    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="jumbotron-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><!--<img src="assets/img/logo.png">--></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                   <!-- <li>
                       <a href="register.html">
                            Register
                        </a>
                    </li>
					<li>
                       <a href="../dashboard/overview.html">
                            Dashboard
                        </a>
                    </li>-->
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" data-color="" > 
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-sm-6 col-md-offset-2 col-sm-offset-3">
                            <form method="post" action="<?php echo base_url();?>user/Login">
                                <div class="card" data-background="color" data-color="blue">
                                    <div class="card-header">
                                        <a class="navbar-brand" href="<?php echo base_url();?>">
                                            <img class="login-logo" src="<?php echo base_url();?>assets/img/logo.png">
                                        </a>
                                    </div>
                                    <div class="card-content d-inline-block">
                                        <div class="col-lg-6">
                                            <span>
                                                At Visiopath we provide a comprehensive and customised Diagnostic Histopathology services to the NHS and Private Sector across all specialities.  Our mission is to alleviate the pressures on departments and enrich pathology services all over the UK. Our team comprises histopathologists who hold substantive NHS posts and are specialists in their respective fields. The team comprises, clinical and operational staff – all of whom support and provide a fully managed Histopathology Service.
                                            </span>
                                        </div>

                                        <div  class="col-lg-6">
                                             <div class="form-group">
                                            <label>Email address</label>
                                            <input type="email" placeholder="Enter email" name="email"  class="form-control input-no-border">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" placeholder="Password" name="password" class="form-control input-no-border">
                                        </div>

                                        <?php if(isset($_GET['error'])){
                                            echo "User not Exit";
                                            }?>

                                             <?php if(isset($_GET['expire'])){
                                            echo "Code expire please login again";
                                            }?>

                                            <div class="d-block text-center">
                                                 <button type="submit" class="btn btn-fill btn-wd ">Let's go</button>
                                            </div>

                                            
                                        </div>

                                       
                                    </div>
                                    <div class="card-footer text-center">
                                       
                                        <div class="forgot">
                                          <!--  <a href="#pablo">Forgot your password?</a>-->
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        	<footer class="footer footer-transparent">
                <div class="container">
                    <div class="copyright">
                        &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="http://www.visiopath.com/">VisioPath</a>
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
<div style="display:block;">
<img src="assets/img/background/bg1.jpg" width="1" height="1" border="0" alt="Image 01">
<img src="assets/img/background/bg2.jpg" width="1" height="1" border="0" alt="Image 02">
<img src="assets/img/background/bg3.jpg" width="1" height="1" border="0" alt="Image 03">
<img src="assets/img/background/bg4.jpg" width="1" height="1" border="0" alt="Image 04">
<img src="assets/img/background/bg5.jpg" width="1" height="1" border="0" alt="Image 05">
<img src="assets/img/background/bg6.jpg" width="1" height="1" border="0" alt="Image 05">

</div>

</html>
