<?php include('connection/config.php'); 

$sql = "SELECT *  FROM `general`";
	$general = mysqlFetchRow($sql); ?>
	
	<?php 

	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $general['meta_title']?></title>
	<meta name="keywords" content="<?php echo $general['meta_keyword']?>">
	<meta name="description" content="<?php if(!empty($general['meta_description'])){ echo iconv('UTF-8', 'ISO-8859-1//IGNORE',$general['meta_description']); } ?>">

	<meta name="author" content="High Five">
	<meta name="viewport" content="width=device-width, initial-scale=0.6">
	
	<?php include('header.php'); ?>

	<div class="container">
		<div class="wrapper mt-20">
			<?php include('left-menu.php'); ?><div class="md-sde display-inline">
				
				<h3 class="mt-5 mb-5">OOPS, Page not found </h3>

			</div><?php include('commentside.php'); ?><?php include('ad.php'); ?>
		</div>
	</div>

	<?php include('footer.php'); ?>

