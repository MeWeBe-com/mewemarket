<?php
ob_start();
session_start();

include('header.php');
$loginError = '';
if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
	include 'Invoice.php';
	$invoice = new Invoice();
	$user = $invoice->loginUsers($_POST['email'], $_POST['pwd']); 
	if(!empty($user)) {
		$_SESSION['user'] = $user[0]['first_name'];
		$_SESSION['userid'] = $user[0]['id'];
		$_SESSION['email'] = $user[0]['email'];		
		$_SESSION['address'] = $user[0]['address'];
		$_SESSION['mobile'] = $user[0]['mobile'];
        $_SESSION['company_name'] = $user[0]['company_name'];
        $_SESSION['logo'] = $user[0]['logo'];


		echo '<script type="text/javascript">
           window.location = "invoice_list.php"
      </script>';

	} else {
		$loginError = "Invalid email or password!";
	}
}
?>
<title>Invoice Generator</title>
<script src="js/invoice.js"></script>
<link href="css/style.css?a" rel="stylesheet">
<?php include('container.php');?>
<div class="row">	
	<div class="demo-heading">
		<h2>Simple Invoice Generator</h2>
	</div>
	<div class="login-form">		
		<h4>Invoice User Login:</h4>		
		<form method="post" action="">
			<div class="form-group">
			<?php if ($loginError ) { ?>
				<div class="alert alert-warning"><?php echo $loginError; ?></div>
			<?php } ?>
			</div>
			<div class="form-group">
				<input name="email" id="email" type="email" class="form-control" placeholder="Email address" autofocus="" required>
			</div>
			<div class="form-group">
				<input type="password" id="pwd" class="form-control" name="pwd" placeholder="Password" required>
			</div>  
			<div class="form-group">
				<button type="submit" name="login" class="btn btn-info">Login</button>
			</div>
		</form>
		<br>

	</div>

	<?php if($_GET['company_name'] == 'demo'){ ?>
		<div class="login-form">
		<h4>
			Demo Login Details:
		</h4>
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
				<td>
					Demo@example.com
				</td>
				<td>
					Password
				</td>
				<td>
					<button type="button" class="btn btn-info Copies" >
						Copy
					</button>
				</td>
			</tbody>
		</table>

	</div>
	<?php }?>

</div>		
</div>
<?php include('footer.php');?>

<script>
	$(document).ready(function(){
		$('.Copies').on('click',function(){
			$('#email').val('demo@example.com');
			$('#pwd').val('password');
		});
	});
</script>
