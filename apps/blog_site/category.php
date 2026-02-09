<?php include('connection/config.php');

$Getcompany = "SELECT *  FROM `company` where company_name = '".$_GET['company_name']."'";
$company_details = mysqlFetchRow($Getcompany);
$company_id = $company_details['company_id'];

$sql = "SELECT *  FROM `general` where company_id = '".$company_id."'";
$general = mysqlFetchRow($sql);

  ?>

<?php  $cat_name = $_GET['cat_name'];
	   $cat_name = str_replace("-", " ", $cat_name);
	   //$cat_name = str_replace("and", "&", $cat_name);

	   $Query = "SELECT * FROM `category` where category_name = '".$cat_name."'";
	   $Cat_id = mysqlFetchRows($Query);

	   if(empty($Cat_id)){
	   echo '<script type="text/javascript">
           window.location = "https://www.wachatrade.com/?moreinfohere"
      </script>';
	   }

	  $category_id = $Cat_id[0]['category_id'];

	  $category_description = $Cat_id[0]['category_description'];

	  $category_name = $Cat_id[0]['category_name'];
	  $category_title = $Cat_id[0]['meta_title'];
	  $category_keyword = $Cat_id[0]['meta_keyword'];
	  $category_description = $Cat_id[0]['meta_description'];
	  $addsql = "where art.category_id = $category_id And art.sub_category_id IS NULL And art.status = 1" ;

	  if(isset($_GET['sub_cat_name'])){ $sub_cat_name = $_GET['sub_cat_name'] ;
	   $sub_cat_name = str_replace("-", " ", $sub_cat_name);
	   //$sub_cat_name = str_replace("and", "&", $sub_cat_name); 

		$sql = "SELECT * FROM `sub_category` where sub_category_name = '".$sub_cat_name."' And category_id = ".$category_id."";
	  	$Sub_Cat = mysqlFetchRows($sql);
	  	$Sub_Cat_id = $Sub_Cat[0]['sub_category_id'];

	  	$category_name = $Sub_Cat[0]['sub_category_name'];
	  	$category_title = $Sub_Cat[0]['meta_title'];
	  	$category_keyword = $Sub_Cat[0]['meta_keyword'];
	  	$category_description = $Sub_Cat[0]['meta_description'];

	  }
	  if(!empty($Sub_Cat_id)){ $addsql = "where art.category_id = $category_id And art.sub_category_id = $Sub_Cat_id And art.status = 1" ; };
	  ?>

<?php 

	if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    	$page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
    }

    $total_records_per_page = 25 ;

    $offset = ($page_no-1) * $total_records_per_page;
    //echo $offset;

	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";

	 $sql = "SELECT COUNT(*) As total_records FROM `articles` as art 
			left join `sub_category` as sub on sub.sub_category_id =  art.sub_category_id 
			inner join `category` as cat on cat.category_id = art.category_id
			".$addsql." ";

	$total_records = mysqlFetchRow($sql);

	  $total_records = $total_records['total_records'];
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php if(!empty($category_title)){ echo $category_title.' - '  ; }else{  echo $category_name.' - ' ; } ?><?php echo $general['meta_title']?></title>
	<?php if(!empty($category_keyword)){ ?>
		<meta name="keywords" content="<?php echo remove_bad_characters($category_keyword); ?>">
	<?php }  if(!empty($category_description)){ ?>
	<meta name="description" content="<?php echo remove_bad_characters($category_description);  ?>">
	<?php }?>

	<meta name="viewport" content="width=device-width, initial-scale=0.6">

	<link rel="icon" href="/img/favicon.ico" type="image/gif" sizes="16x16">
	
	<?php include('header.php'); ?>

	<div class="container">
		<div class="wrapper mt-20">
			<?php include('left-menu.php'); ?><div class="md-sde display-inline">
				
				<?php 

				if(!empty($Sub_Cat_id)){ $sql = "And art.sub_category_id = $Sub_Cat_id" ; }else{ $sql = "" ;};

				   $Query = "SELECT art.*,cat.category_name,cat.category_description,sub.sub_category_name FROM `articles` as art 
								left join `sub_category` as sub on sub.sub_category_id =  art.sub_category_id 
								inner join `category` as cat on cat.category_id = art.category_id
								".$addsql." order by art.article_id  desc LIMIT $offset, $total_records_per_page" ;

					$Articles = mysqlFetchRows($Query); ?>

					<?php if(empty($Sub_Cat_id) && empty($Articles)){

						$Query = "SELECT * FROM `sub_category` where category_id = '".$category_id."' order by sub_category_id asc limit 1";
						$firstcategory = mysqlFetchRow($Query);
						
						if(!empty($firstcategory)){
						echo("<script>location.href = '".$base_url."categorys/".slug($category_name)."/".slug($firstcategory['sub_category_name'])."/';</script>");}
					}?>

				<?php 	if(!empty($category_description)){ ?>

				<div class="Description_box thm-clr font-wgt-600">
						<?php  echo remove_bad_characters( $category_description); ?>
				</div>
				
				<?php  }

					foreach($Articles as $art){	

						$Query = "SELECT COUNT('status') as Likes FROM `article_like` where article_id = '".$art['article_id']."' ";
						$Likes = mysqlFetchRow($Query);

						?>

						<div class="article pt-10 pb-10">
							<h2><?php echo ucfirst(remove_bad_characters( $art['title'])) ;?></h2> 
							<span  class="gry-clr"><?php $date=date_create($art['created_at']);
							 echo date_format($date,"d F Y"); ?> <?php if(!empty($art['source'])){?> (<?php echo $art['source'];?>) <?php };?>
								<span id="like_<?php echo $art['article_id'] ;?>" class="speech" onclick="heart(<?php echo $art['article_id'] ;?>)">
									&#x2764; <?php echo $Likes['Likes'];?>
								</span>
							</span>
							<div>
								<img class="articleimg" alt="<?php echo ucfirst($art['title']) ;?>" 
								src="<?php echo $base_url;?>lib.php?path=img/articleimg/<?php echo $art['feature_img'];?>&width=200&height=200"/>
							</div>

							<p class="pt-10 pb-10 font-wgt-600">
								<?php echo remove_bad_characters( $art['short_description']); ?>
							</p>

							<?php if(!empty($art['description'])){?>

							<a class="thm-clr font-wgt-600" href="<?php echo $base_url;?><?php echo $_GET['company_name']?>/article/<?php echo slug($art['category_name'])?>/<?php  if(!empty($art['sub_category_name'])){ echo slug($art['sub_category_name']).'/' ; } ?><?php echo $art['slug']; ?>">Read More</a>

							<?php }?>
						</div>

				<?php } ?>
				
				
				
			<ul class="pagination">
                    <?php
                    $pn = $page_no;
                    $total_pages = $total_no_of_pages;

                   if($pn>=2) {   
           				 echo "<li><a href='?page_no=".($pn-1)."'>  Prev </a></li>";   
   					}       
                       
			    	for ($i=1; $i<=$total_pages; $i++) {   
			            if ($i == $pn) {   
			                  $pagLink .= "<li class = 'active'><a  href='?page_no="  
			                                                    .$i."'>".$i." </a></li>";   
			              }               
			              else  {   
			                  $pagLink .= "<li><a href='?page_no=".$i."'>   
			                                                    ".$i." </a></li>";     
			              }   
				    };     
				    echo $pagLink;   
			      
				    if($pn<$total_pages){   
				              echo "<li><a href='?page_no=".($pn+1)."'>  Next </a></li>";   
				    }   
                    ?>
                </ul>

            
                

			</div><?php include('commentside.php'); ?><?php include('ad.php'); ?>
		</div>
	</div>

	<?php include('footer.php'); ?>

