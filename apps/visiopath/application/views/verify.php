<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Verification Login - Lims</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <?php include('partial/head.php') ?>
 <style>
   
  body {
    -webkit-transform: translatez(0);
    -moz-transform: translatez(0);
    -ms-transform: translatez(0);
    -o-transform: translatez(0);
    transform: translatez(0);
}

#cycler{position:absolute; display:none;width:100%;}
#cycler img{position:absolute;z-index:1; width:100% }
#cycler img.active{z-index:3; }
body{
overflow:hidden;
}
   </style>
</head>

<script >

    

    $( document ).ready(function() {
        var original = $( window ).height();
        $("body").css("height", original);
    });

    $( window ).resize(function() {
        var Vheight = $( window ).height();
        $("body").css("height", Vheight);
     });
    
    $( window ).resize(function() {
      var height = $( window ).height();
      var Nheight =  height + 10% 
      $(".login-cycler").css("height", Nheight);
    });

</script>

<body >



	

   <div class="wrapper wrapper-full-page <?php if($this->agent->is_mobile()){ echo "AbsoluteResponsive" ;}?>">

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
setInterval('cycleImages()', 5000);
})

</script>

		<div class="full-page lock-page" data-color="green" >
	    <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
	        <div class="content">
	            <form method="post" action="<?php echo base_url()?>user/VerificationLogin">
	                <div class="card card-lock">
	                    <div class="author">
	                        <img class="avatar" src="<?php echo base_url()?>assets/img/faces/face-0.jpg" alt="...">
	                    </div>
	                    <h4><?php if($this->session->userdata('roleId') == 1 && $this->session->userdata('user_type') == 1){
								echo 'DE';
							}elseif($this->session->userdata('roleId') ==1){
								echo 'Admin';
							}
						elseif($this->session->userdata('roleId') == 2){

								echo 'Doctor';
								
						}elseif($this->session->userdata('roleId') == 3){

								echo 'Hospital';
						} ?></h4>

						<?php if($this->session->userdata('company_id') == 1){ ?>
							<span>
								<?php echo "Verification Code:".$this->session->userdata('Verification_code')?>
							</span>
						<?php }?>

	                    <span class="help-block">Check your email for the code.</span>
	                    <div class="form-group">
	                        <input type="text" placeholder="Enter Code" required="true" name="Verification_code" class="form-control" autocomplete="off">
							
							 <?php 
							 
							 if(isset($_GET['expire'])){
								echo "<font color='#AE1A41'>Code does not match!</font>";
								}
								if(isset($_GET['invalidNumber'])){
								echo "<font color='#AE1A41'>You have an invalid mobile number setup in your profile, use your email to login or contact support.</font>";
								}
								
								
								?>


                             <div class="checkbox">
                                  <input id="checkbox15" type="checkbox" name="remember_me" value="1">
                                  <label for="checkbox15">
                                  Remember Me <i></i>
                                  </label>
                             </div>
		                                 

							 
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
