<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
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

#cycler{position:absolute; display:none;width:100%;}
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

<script >

    $( document ).ready(function() {
        var original = $(window).height();
        $("body").css("height", original);
    });

    $( window ).resize(function() {
        var Vheight = $( window ).height();
        $("body").css("height", Vheight);
     });
    
    $( window ).resize(function() {
      var height = $( window ).height();
      var Nheight =  height + 10% 
      $("#cycler").css("height", Nheight);
    });

</script>

<body >

    



<?php /*?>

  <div id="background-carousel">
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
      <div class="carousel-inner">
       
        <div class="item active" style="background-image:url('assets/img/background/bg6.jpg')"></div>
       
      </div>
    </div>
</div><?php */?>

<script>
/*
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

*/
</script>

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


        <div class="full-page login-page" data-color="" > 
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                            <form method="post" action="<?php echo base_url();?>user/Login">
                                <div class="card" data-background="color" data-color="blue">
                                    <div class="card-header">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <a class="navbar-brand pl-0 pr-0" href="<?php echo base_url();?>">
                                            <img class="login-logo" src="<?php echo base_url();?>assets/uploads/<?php echo $this->session->userdata('company_logo');?>">
                                        </a>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <h3 class="mt-3 mb-0"><?php echo $company_name; ?></h3>
                                        </div>
                                    </div>

                                    <div class="card-content d-inline-block">
                                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
											<?php $record_num = $this->uri->segment($this->uri->total_segments());
											if($record_num == "demo" || $record_num == "Demo"){?>
												<table class="loginTable">
																<thead>
																<th>
																	Email:
																</th>
																<th>
																	Password:
																</th>
																<th>
																	Action:
																</th>
																</thead>
																<tbody>
																<tr>
																	<td>
																		demo@example.com
																	</td>
																	<td>
																		Password
																	</td>
																	<td>
																		<button type="button" class="btn btn-info Copies" >
																			Admin
																		</button>
																	</td>
																</tr>
																<tr>
																	<td>
																		doctor@example.com
																	</td>
																	<td>
																		Password
																	</td>
																	<td>
																		<button type="button" class="btn btn-info Doctor" >
																			Doctor
																		</button>
																	</td>
																</tr>
																<tr>

																	<td>
																		hospital@example.com
																	</td>
																	<td>
																		Password
																	</td>
																	<td>
																		<button type="button" class="btn btn-info Hospital" >
																			Hospital
																		</button>
																	</td>
																</tr>
																</tbody>
															</table>
											<?php }else{?>
											<span>
                                                At Visiopath we provide a comprehensive and customised Diagnostic Histopathology services to the NHS and Private Sector across all specialities.  Our mission is to alleviate the pressures on departments and enrich pathology services all over the UK. Our team comprises histopathologists who hold substantive NHS posts and are specialists in their respective fields. The team comprises, clinical and operational staff – all of whom support and provide a fully managed Histopathology Service.
												                     <br /><br />
                                            </span>
											<?php }?>
                                        </div>

                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                             <div class="form-group">
                                            <label>Email address</label>
                                                 <input type="hidden" name="company_id" value="<?php echo $company_id; ?>" >

                                                 <input type="email" placeholder="Enter email" name="email" id="email"  class="form-control input-no-border">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" placeholder="Password" name="password" id="pwd" class="form-control input-no-border">
											<a class="theme-color" href="<?php echo base_url();?>user/forgetpassword/">Forgot Password?</a><br>
											 <?php if(isset($_GET['error'])){
												echo "<font color='#AE1A41'>User doesn't exist!</font>";
												}?>

                                            <?php if(isset($_GET['companyerror'])){
                                                echo "<font color='#AE1A41'>Company doesn't exist!</font>";
                                            }?>
	
											 <?php if(isset($_GET['expire'])){
												echo "<font color='#AE1A41'>Code expired please try again!</font>";
												}?>
												
												 <?php if(isset($_GET['passwordchanged'])){
												echo "<font color='green'>Password changed!</font>";
												}?>

                                        </div>

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
                        &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="http://www.visiopath.com/">Visiopath</a>
                    </div>
                </div>
            </footer>
        </div>
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

		$(document).ready(function(){
			$('.Copies').on('click',function(){
				$('#email').val('demo@example.com');
				$('#pwd').val('Password');
			});

			$('.Doctor').on('click',function(){
				$('#email').val('doctor@example.com');
				$('#pwd').val('Password');
			});

			$('.Hospital').on('click',function(){
				$('#email').val('hospital@example.com');
				$('#pwd').val('Password');
			});
		});
		 
	
	</script>


<div style="display:none;">
<img src="assets/img/background/bg1.jpg" width="1" height="1" border="0" alt="Image 01">
<img src="assets/img/background/bg2.jpg" width="1" height="1" border="0" alt="Image 02">
<img src="assets/img/background/bg3.jpg" width="1" height="1" border="0" alt="Image 03">
<img src="assets/img/background/bg4.jpg" width="1" height="1" border="0" alt="Image 04">
<img src="assets/img/background/bg5.jpg" width="1" height="1" border="0" alt="Image 05">
<img src="assets/img/background/bg6.jpg" width="1" height="1" border="0" alt="Image 05">

</div>

</html>
