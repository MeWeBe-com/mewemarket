<div class="rgt-md-sde display-inline pb-20">
		<div class="removeBorderfromright">
			<div class="spacer"></div>
		</div>
		<a href="javascript:;" onclick="Append()" class="font-wgt-600 thm-clr add_comments text-underline">Have a comment or QA? </a>
		<div class="mt-10">

            <?php if(isset($_POST['name'])) {

				if(empty($_POST['category_id'])){
					 $comments = str_replace( "'", "", $_POST['comments']) ;
				  $sql = "INSERT INTO `article_comments`(  `name`, `email`, `title`, `comment_text`, `comment_status`) VALUES ('".$_POST['name']."','".$_POST['email']."','".$_POST['title']."','".$comments."','0')";
				}else{
					 $comments = str_replace( "'", "", $_POST['comments']) ;
                      $sql = "INSERT INTO `article_comments`( `category_id`, `name`, `email`, `title`, `comment_text`, `comment_status`) VALUES ('".$_POST['category_id']."','".$_POST['name']."','".$_POST['email']."','".$_POST['title']."','".$comments."','0')";
				}

				$insertedID = mysqlInsert($sql);

				$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			} ?>

			<?php if(isset($comments)){
				/*echo "<div class='error_message'> Comments posted. Please verify your comments by clicking on the link sent to email address ".$_GET['Message']." </div>"; */

				echo "<div class='error_message'> Thank you, your comment has been submitted for moderation.</div>"; 
			}?>
			<?php $action = "$_SERVER[REQUEST_URI]";?>
			

				<?php if(!empty($category_id)){
					$category = $category_id;
				}else{
					$category = '';
				}?>

				
				<?php if(!empty($category_id)){
					$category_id = 'category_id = "'.$category_id.'"';
				}else{
					$category_id = 'category_id is null';
				}?>

			
				<?php $url = explode("/", $_SERVER['PHP_SELF']);
				$key =  array_key_last($url);

				if($url[$key] == 'awards.php'){
					$category_id =  array_key_last($Categories) + 1;
				} 
				?>

                <div id="Forms">

                </div>

		</div>

		<h5 class="mt-10 font-wgt-600 ">Comments and QA</h5>

		<?php 

		 $sql = "SELECT *  FROM `article_comments` where comment_status = 2 and  $category_id and company_id = '".$company_id."' order by comment_id desc limit 10";
		$comments = mysqlFetchRows($sql);

		foreach($comments as $comment){
			$date = date_create($comment['comment_created']); 
		?>

		<div class="commentBox">
			<h4 >
				 <?php echo $comment['title'];?>
			</h4>
			<p class="gry-clr">
				 <?php echo $comment['comment_text'];?> 
			</p>
			<span class="mt-10 thm-clr">By <?php echo $comment['name'];?>, <?php echo date_format($date,"d M y");?></span>

		</div> <?php }?>		

	</div>

