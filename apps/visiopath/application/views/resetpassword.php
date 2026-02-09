<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Please enter your desired new password - Lims</title>

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

#cycler{position:relative; display:none;}
#cycler img{position:absolute;z-index:1; width:100% }
#cycler img.active{z-index:3; }
body{
overflow:hidden;
}
.navbar-brand{
margin-bottom:15px;
}
   </style>
</head>

<body >

<div id="cycler" class="login-cycler">
<img  class="active" src="<?php echo base_url();?>assets/img/background/bg1.jpg" alt="My image" />	
<img  src="<?php echo base_url();?>assets/img/background/bg2.jpg" alt="My image" />	
<img src="<?php echo base_url();?>assets/img/background/bg3.jpg" alt="My image" />		
<img src="<?php echo base_url();?>assets/img/background/bg4.jpg" alt="My image" />		
<img src="<?php echo base_url();?>assets/img/background/bg5.jpg" alt="My image" />		
<img src="<?php echo base_url();?>assets/img/background/bg6.jpg" alt="My image" />		

</div>

<script type="text/javascript">
function cycleImages(){
      var $active = $('#cycler .active');
      var $next = ($active.next().length > 0) ? $active.next() : $('#cycler img:first');
      $next.css('z-index',2);//move the next image up the pile
      $active.fadeOut(1500,function(){//fade out the top image
	  $active.css('z-index',1).show().removeClass('active');//reset the z-index and unhide the image
          $next.css('z-index',3).addClass('active');//make the next image the top one
      });
    }
$(window).ready(function(){
	$("#cycler").show();
})
$(document).ready(function(){

// run every 7s
setInterval('cycleImages()', 3000);
})

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

    <div class="wrapper wrapper-full-page <?php if($this->agent->is_mobile()){ echo "AbsoluteResponsive" ;}?>">
        <div class="full-page login-page" data-color="" > 
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <form method="post" action="">
							
                                <div class="card card-lock" data-background="color" data-color="blue">
                                    
                                    <div class="card-content d-inline-block">
                                        
										<a href="<?php echo base_url();?>" >
                                            <img src="<?php echo base_url();?>assets/img/logo.png" style="margin-bottom:20px;">
                                        </a>
                                        <div  class="col-lg-12">
                                             <div class="form-group">
                                            <label>New password</label>
                                            <input type="password" placeholder="Password" name="password"  class="form-control input-no-border">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm new password</label>
                                            <input type="password" placeholder="Confirm Password" name="cpassword" class="form-control input-no-border">
											
											 <?php if(isset($_GET['error'])){
												echo "<font color='#AE1A41'>Password do not match!</font>";
												}?>
	
											
                                        </div>

                                       

                                            <div class="d-block text-center">
                                                 <button type="submit" class="btn btn-fill btn-wd ">Change Password</button>
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
