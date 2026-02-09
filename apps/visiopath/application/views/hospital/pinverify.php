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


    <?php $this->load->view('partial/head.php') ?>
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


<style>
	.form-group .ver {
    margin: 0 2px;
    text-align: center;
    line-height: 40px;
    font-size: 22px;
    border: solid 1px #ccc;
    box-shadow: 0 0 5px #ccc inset;
    outline: none;
    width: 100%;
    transition: all 0.2s ease-in-out;
    border-radius: 3px;
}

.form-group .ver:focus {
    border-color: #ae1a41;
	box-shadow: 0 0 5px #ae1a41 inset;
}

</style>

	<?php
		function addOrdinalNumberSuffix($num) {
		    if (!in_array(($num % 100),array(11,12,13))){
		      switch ($num % 10) {
		        // Handle 1st, 2nd, 3rd
		        case 1:  return $num.'st';
		        case 2:  return $num.'nd';
		        case 3:  return $num.'rd';
		      }
		    }
		    return $num.'th';
		  }
	?>

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
	            <form method="post" action="<?php echo base_url()?>hospital/PinVerificationLogin">
	                <div class="card card-lock">
	                    <div class="author mt-3">
	                        <img class="avatar" src="<?php echo base_url()?>assets/img/faces/face-0.jpg" alt="...">
	                    </div>
	                    <h4 class="mt-3 mb-4"><?php if($this->session->userdata('roleId') == 3){

								echo 'Hospital';
						} ?></h4>

						<?php /*?><span><?php echo "Verification Code:".$this->session->userdata('Verification_code')?></span><span class="help-block">Check your email for the pincode.</span><?php */?>

	                    Enter the numbers of your pin for verification:
	                    <div class="form-group mt-3">
	                    <!--<input type="text" placeholder="Enter Code" required="true" name="hospital_pincode" class="form-control" autocomplete="off">-->
	                    	<?php
	                    	$hospital_pincode = $this->session->userdata('hospital_pincode');
	                    		
								for($i=0; $i<strlen($hospital_pincode); $i++){
	                    		//foreach($hospital_pincode as $key=>$pin){
	                    				
	                    				 $inputNumber[$i]['name'] = addOrdinalNumberSuffix($i+1);
	                    				
	                    				$inputNumber[$i]['hidden'] = md5($hospital_pincode[$i]);
	                    		}
	                    		
	                    		//$inputNumber = array_rand($inputNumber);
	                    		shuffle($inputNumber);
	                    	?>
	                    	<div class="col-lg-4">
	                    		<label class="width100"><?php echo $inputNumber[0]['name']?> #</label>
	                    		 <input type="hidden" class="ver" id="first_number[data]" name="first_number[data]" value="<?php echo $inputNumber[0]['hidden']?>">
	                    		 <input type="text" class="ver" id="first_number[value]" name="first_number[value]" maxlength="1" value>
	                    	</div>

	                    	<div class="col-lg-4">
	                    		<label class="width100"><?php echo $inputNumber[1]['name']?> #</label>
	                    		 <input type="hidden" class="ver" id="second_number[data]" name="second_number[data]" value="<?php echo $inputNumber[1]['hidden']?>">
	                    		 <input type="text" class="ver" id="second_number[value]" name="second_number[value]"  maxlength="1">
	                    	</div>

	                    	<div class="col-lg-4">
	                    		<label class="width100"><?php echo $inputNumber[2]['name']?> #</label>
	                    		 <input type="hidden" class="ver" id="third_number[data]" name="third_number[data]" value="<?php echo $inputNumber[2]['hidden']?>">
	                    		 <input type="text" class="ver" id="third_number[value]" name="third_number[value]"  maxlength="1">
	                    	</div>
	                    	
							 <?php if(isset($_GET['pinNotMatch'])){
								echo "<font color='#AE1A41'>PinCode does not match!</font>";
							}?>

						</div>
	                    <button type="submit" class="btn btn-wd mt-3" class="verify">Verify</button>

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

	<?php $this->load->view('partial/footerscript') ?>

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
