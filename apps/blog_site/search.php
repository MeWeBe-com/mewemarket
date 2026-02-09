<?php include('connection/config.php');

$Getcompany = "SELECT *  FROM `company` where company_name = '".$_GET['company_name']."'";
$company_details = mysqlFetchRow($Getcompany);
$company_id = $company_details['company_id'];

$sql = "SELECT *  FROM `general` where company_id = '".$company_id."'";
$general = mysqlFetchRow($sql); ?>
	
	<?php  $keyword = $_GET['search'];

	if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    	$page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
    }

    $total_records_per_page = 25 ;

    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";

	$sql = "SELECT COUNT(*) As total_records FROM `articles` where title like '%".$keyword."%' OR description like '%".$keyword."%' And status = 1";
	$total_records = mysqlFetchRow($sql);

	$total_records = $total_records['total_records'];
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1;

	$pagin = "?search=".$keyword."&page_no=";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $general['meta_title']?></title>
	<meta name="keywords" content="<?php echo $general['meta_keyword']?>">
	<meta name="description" content="<?php if(!empty($general['meta_description'])){ echo remove_bad_characters($general['meta_description']); } ?>">

	<meta name="author" content="High Five">
	<meta name="viewport" content="width=device-width, initial-scale=0.6">

	<link rel="icon" href="/img/favicon.ico" type="image/gif" sizes="16x16">
	
	<?php include('header.php'); ?>

	<div class="container">
		<div class="wrapper mt-20">
			<?php include('left-menu.php'); ?><div class="md-sde display-inline">
				
				<h4 class="mt-5 mb-5">Search results for "<?php echo $keyword ;?>"</h4>

				<?php
					$Query = "SELECT art.*,cat.category_name,sub.sub_category_name FROM `articles` as art 
								left join `sub_category` as sub on sub.sub_category_id =  art.sub_category_id 
								inner join `category` as cat on cat.category_id = art.category_id
								where title like '%".$keyword."%' OR description like '%".$keyword."%'
								AND art.status = 1 AND art.company_id = '".$company_id."'
								LIMIT $offset, $total_records_per_page";
					$Articles = mysqlFetchRows($Query);


					if(empty($Articles)){
						$keyword = explode(' ', $keyword);

						if(!empty($keyword)){

							foreach($keyword as $key){
								 $Query = "SELECT art.*,cat.category_name,sub.sub_category_name FROM `articles` as art 
								left join `sub_category` as sub on sub.sub_category_id =  art.sub_category_id 
								inner join `category` as cat on cat.category_id = art.category_id
								where title like '%".$key."%' OR description like '%".$key."%'
								AND art.status = 1 AND art.company_id = '".$company_id."'
								LIMIT $offset, $total_records_per_page";
								$Articles = mysqlFetchRows($Query);
							}
						
						}else{

							$keyword = substr($keyword,0,4);

							 $Query = "SELECT art.*,cat.category_name,sub.sub_category_name FROM `articles` as art 
								left join `sub_category` as sub on sub.sub_category_id =  art.sub_category_id 
								inner join `category` as cat on cat.category_id = art.category_id
								where title like '%".$keyword."%' OR description like '%".$keyword."%'
								AND art.status = 1 AND art.company_id = '".$company_id."'
								LIMIT $offset, $total_records_per_page";
								$Articles = mysqlFetchRows($Query);

						}
					}

					foreach($Articles as $art){

					$Query = "SELECT COUNT('status') as Likes FROM `article_like` where article_id = '".$art['article_id']."' ";
					$Likes = mysqlFetchRow($Query);	?>

						<div class="article pt-10 pb-10">
							<h3><?php echo remove_bad_characters( $art['title']); ;?></h3> 
							<span  class="gry-clr"><?php $date=date_create($art['created_at']);
								echo date_format($date,"d F Y"); ?> <?php if(!empty($art['source'])){?> (<?php echo $art['source'];?>) <?php }?>
								<span id="like_<?php echo $art['article_id'] ;?>" class="speech" onclick="heart(<?php echo $art['article_id'] ;?>)">
									&#x2764; <?php echo $Likes['Likes'];?>
								</span>
							</span>
							<div>
								<img class="articleimg" alt="<?php echo remove_bad_characters( $art['title']); ;?>" 
								src="<?php echo $base_url;?>lib.php?path=img/articleimg/<?php echo $art['feature_img'];?>&width=200&height=200"/>
							</div>

							<p class="pt-10 pb-10 font-wgt-600">
								<?php echo remove_bad_characters( $art['short_description']);?>
							</p>

							<?php if(!empty($art['description'])){?>

							<a class="thm-clr font-wgt-600" href="/article/<?php echo slug($art['category_name'])?>/<?php  if(!empty($art['sub_category_name'])){ echo slug($art['sub_category_name']).'/' ; } ?><?php echo $art['slug']; ?>">Read More</a>

							<?php }?>
						</div>

				<?php } ?>

				<?php if($total_no_of_pages > 1){?>
<ul class="pagination">
                    <?php
                    $pn = $page_no;
                    $total_pages = $total_no_of_pages;

                    $pagLink = "";
                    if($pn>=2) {   
           				 echo "<li><a href='?page_no=".($pn-1)."'>  Prev </a></li>";   
   					}       
                       
			    	for ($i=1; $i<=$total_pages; $i++) {   
			            if ($i == $pn) {   
			                  $pagLink .= "<li class = 'active'><a href='?page_no="  
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
                </ul> <?php }?>

			</div><?php include('commentside.php'); ?><?php include('ad.php'); ?>
		</div>
	</div>

	<?php include('footer.php'); ?>

