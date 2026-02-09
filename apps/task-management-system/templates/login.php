<?php
if($_POST)
{
    include '../libs/config.php';
    $username=$_POST['username'];
    $password=$_POST['password'];
    $sUser=mysqli_real_escape_string($conn,$username);
    $sPass=mysqli_real_escape_string($conn,$password);
    // For Security 
    $query="SELECT * From admin where username='$sUser' and passcode='$sPass'";
    $result=mysqli_query($conn,$query);
    if(mysqli_num_rows($result)==1)
    {
        session_start();
        $_SESSION['anything']='something';
        //header('location:index.php');
        echo "string";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>I&C</title>

	<!-- Bootstrap -->
	<link href="libs/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="libs/css/login.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
  </head>
  <body>
  	<div class="container">
  		<div class="row">
  			<div class="col-md-6 col-md-offset-3">
  				<div class="panel panel-login">
  					<div class="panel-heading">
  						<div class="row">
  							<div class="col-xs-6">
  								<a href="#" class="active" id="login-form-link">Admin Login</a>
  							</div>
  							<div class="col-xs-6">
  								<a href="#" id="register-form-link">Staff Login</a>
  							</div>
  						</div>
  						<hr>
  					</div>
  					<div class="panel-body">
  						<div class="row">
  							<div class="col-lg-12">
  								<form id="login-form" action="http://localhost:8000/adminlogin" method="post" role="form" style="display: block;">
  									<div class="form-group">
  										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
  									</div>
  									<div class="form-group">
  										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
  									</div>
  									<!-- <div class="form-group text-center">
  										<input type="checkbox" tabindex="3" class="" name="remember" id="remember">
  										<label for="remember"> Remember Me</label>
  									</div> -->
  									<div class="form-group">
  										<div class="row">
  											<div class="col-sm-6 col-sm-offset-3">
  												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
  											</div>
  										</div>
  									</div>
  									<!-- <div class="form-group">
  										<div class="row">
  											<div class="col-lg-12">
  												<div class="text-center">
  													<a href="http://phpoll.com/recover" tabindex="5" class="forgot-password">Forgot Password?</a>
  												</div>
  											</div>
  										</div>
  									</div> -->
  								</form>
  								<form id="register-form" method="post" role="form" style="display: none;">
  									<div class="form-group">
  										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
  									</div>
  									<!-- <div class="form-group">
  										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
  									</div> -->
  									<div class="form-group">
  										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
  									</div>
  									<!-- <div class="form-group">
  										<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
  									</div> -->
  									<div class="form-group">
  										<div class="row">
  											<div class="col-sm-6 col-sm-offset-3">
  												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="LOG IN">
  											</div>
  										</div>
  									</div>
  								</form>
  							</div>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="libs/js/bootstrap.min.js"></script>

  	<script type="text/javascript">
  		$(function() {

    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

});
  	</script>
  </body>
  </html>