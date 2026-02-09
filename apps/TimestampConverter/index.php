<!DOCTYPE html>
<html lang="en">
	<head>
        <?php $base = "https://www.mewemarket.com/apps/TimestampConverter/"?>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>

	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $base.$_GET['company_name']?>"><?php echo $_GET['company_name'];?></a>

            <a class="navbar-brand pull-right" href="<?php echo $base.$_GET['company_name'];?>">TimeStamp To Date Time</a>
            <a class="navbar-brand pull-right" href="<?php echo $base.$_GET['company_name'];?>/dateconverter.php">Date Time To TimeStamp </a>
		</div>
	</nav>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">Timestamp To Date Time Converter</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<form method="POST">
				<div class="form-group">
					<label>Timestamp:</label>
					<input type="number" value="<?php echo time();?>" name="time" class="form-control" />
				</div>
				
				<center><button class="btn btn-primary" name="convert"><span class="glyphicon glyphicon-random"></span> Convert</button></center>
			</form>
			<br />
			<?php include 'converter.php'?>
		</div>
	</div>
</body>	
</html>
