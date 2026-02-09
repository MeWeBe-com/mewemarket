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
	<link rel="stylesheet" type="text/css" href="libs/css/adminlogin.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
  </head>
  <body>
<div class="login">
    <h1>User Login</h1>
    <form action="http://localhost:8000/login" method="post" enctype="application/x-www-form-urlencoded">
    	<input type="text" name="username" id="username" placeholder="Username" required="required" />
        <input type="password" name="password" placeholder="Password" required="required" />
        <button type="submit" class="btn btn-primary btn-block btn-large">Let me in.</button>
    </form>
    <br>

<!-- login bootsnipp -->
</div>
</body>
</html>
