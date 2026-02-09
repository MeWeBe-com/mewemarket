<?php include('connection/config.php'); 

include('slug.php');

$Getcompany = "SELECT *  FROM `company` where company_name = '".$_GET['company_name']."'";
$company_details = mysqlFetchRow($Getcompany);
$company_id = $company_details['company_id'];

$sql = "SELECT *  FROM `general` where company_id = '".$company_id."'";
$general = mysqlFetchRow($sql);

?>


<?php  $cat_name = $_GET['cat_name'] ;
	   $cat_name = str_replace("-", " ", $cat_name);
	   //$cat_name = str_replace("and", "&", $cat_name);


	  $Query = "SELECT category_id,category_description FROM `category` where category_name = '".$cat_name."'";
	  $Cat_id = mysqlFetchRows($Query);

	  $category_id = $Cat_id[0]['category_id'];
	   $category_description = $Cat_id[0]['category_description'];

	  if(isset($_GET['sub_cat_name']) && $_GET['sub_cat_name'] != 'main'){ $sub_cat_name = $_GET['sub_cat_name'] ;
	   $sub_cat_name = str_replace("-", " ", $sub_cat_name);
	   $sub_cat_name = str_replace("and", "&", $sub_cat_name); 

		$sql = "SELECT sub_category_id FROM `sub_category` where sub_category_name = '".$sub_cat_name."' And category_id = ".$category_id."";
	  	$Sub_Cat_id = mysqlFetchRows($sql);
	  	$Sub_Cat_id = $Sub_Cat_id[0]['sub_category_id'];

	  	$subSql = "And art.sub_category_id = '".$Sub_Cat_id."' ";
	  }else{ $subSql = "And art.sub_category_id IS NULL";}

	   if(isset($_GET['article'])){ 

		   	$article = $_GET['article'] ;
		  
		}

	     $Query = "SELECT art.*,cat.category_name,sub.sub_category_name FROM `articles` as art 
					left join `sub_category` as sub on sub.sub_category_id =  art.sub_category_id 
					inner join `category` as cat on cat.category_id = art.category_id
					where art.slug = '".$article."' and art.category_id = '".$category_id."' ".$subSql."
					"; 

					$Article = mysqlFetchRow($Query);

					$meta_title = $Article['meta_title'];
				  	$meta_keyword = $Article['meta_keyword'];
				  	$meta_description = $Article['meta_description'];
	  ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php if(!empty($meta_title)){ echo $meta_title.' - '  ; }else{ echo $Article['title'].' - '  ; } ?>Wachatrade</title>
	<?php if(!empty($meta_keyword)){ ?>
		<meta name="keywords" content="<?php if(!empty($meta_keyword)){ echo $meta_keyword ; }?>">
	<?php } ?>

	<meta name="description" content="<?php if(!empty($meta_description)){ echo remove_bad_characters($meta_description)  ; }else{ 
		echo substr_replace(strip_tags(remove_bad_characters( $Article['description'])), "", 160);
	} ?>">
	
	<meta name="viewport" content="width=device-width, initial-scale=0.6">

	<link rel="icon" href="<?php echo $base_url?>/img/favicon.ico" type="image/gif" sizes="16x16">
	
	<?php include('header.php');

	 ?>

	
	<div class="container">
		<div class="wrapper mt-20">
			<?php include('left-menu.php'); ?><div class="md-sde display-inline">
				<div class="Description_box">
					<p class="thm-clr font-wgt-600">
						<?php echo  remove_bad_characters($category_description); ?>
					</p>
				</div>

				<?php 
				$Query = "SELECT COUNT('status') as Likes FROM `article_like` where article_id = '".$Article['article_id']."' ";
						$Likes = mysqlFetchRow($Query); ?>

				<div class="article pt-10 pb-10">
					<h2><?php echo  remove_bad_characters($Article['title']); //iconv('UTF-8', 'ISO-8859-1//IGNORE', $Article['title']); ?></h2>
					<span  class="gry-clr"><?php $date=date_create($Article['created_at']);
							echo date_format($date,"d F Y"); ?><?php if(!empty($art['source'])){?> (<?php echo $Article['source'] ;?>) <?php }?>
						<span class="speech" id="like_<?php echo $Article['article_id'] ;?>" onclick="heart(<?php echo $Article['article_id'] ;?>)">
							&#x2764; <?php echo $Likes['Likes'] ;?>
						</span>
					</span>
					<div>
						<img class="articleimginner" alt="<?php echo $Article['title'] ;?>" 
						src="<?php echo $base_url?>/img/articleimg/<?php echo $Article['feature_img'];?>"/>
					</div>

					<div class="ArticleText">

					<?php if(!empty($Article['description'])){?>
					<p >
						<?php //echo iconv('CP1252', 'ASCII//TRANSLIT', $Article['description']);?>

						<?php $text =  remove_bad_characters($Article['description']);
						echo str_replace("<a href","<a target='_blank' href",$text);
						 //$text = iconv('UTF-8', 'ISO-8859-1//IGNORE', $Article['description']); ?>


					</p>
					<?php }else{ ?>
						<p >
						<?php echo remove_bad_characters($Article['short_description']); //iconv('UTF-8','ISO-8859-1//IGNORE', $Article['short_description']); ?>
					</p>
					<?php }?>

					</div>


				</div>
				
			</div><?php include('commentside.php'); ?><?php include('ad.php'); ?>
		</div>
	</div>

	<?php include('footer.php'); ?>


