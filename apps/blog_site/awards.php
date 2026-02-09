<?php include('connection/config.php'); 

$sql = "SELECT *  FROM `general`";
	$general = mysqlFetchRow($sql);

$sql = "SELECT * FROM `awards`";
	$awards = mysqlFetchRow($sql); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php if(!empty($awards['meta_title'])){ echo $awards['meta_title'].' - '  ; } ?><?php echo $general['meta_title']?></title>
	<meta name="keywords" content="<?php if(!empty($awards['meta_keyword'])){ echo $awards['meta_keyword'] ; }?>">
	<meta name="description" content="<?php if(!empty($awards['meta_description'])){ echo $awards['meta_description'] ; } ?>">
	<meta name="author" content="High Five">
	<meta name="viewport" content="width=device-width, initial-scale=0.6">
	
	<?php include('header.php'); ?>
	
	<div class="container">
		<div class="wrapper mt-20">
			<?php include('left-menu.php'); ?><div class="md-sde display-inline">
				<?php if(!empty($awards['awards_summary']) ){?>		
				<div class="thm-clr font-wgt-600">
					<?php echo $awards['awards_summary'];?>	
				</div>

			<?php }?>

			<?php if(!empty($awards['content']) ){?>		
					<?php echo $awards['content'];?>	
			<?php }?>
				

			</div><?php include('commentside.php'); ?><?php include('ad.php'); ?>
		</div>
	</div>

	<?php include('footer.php'); ?>

