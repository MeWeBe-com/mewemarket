<div class="lft-sde display-inline">
		<div class="removeBorder">
			<div class="spacer"></div>
		</div>
		<div class="text-center ">
			<a href="<?php echo $base_url;?><?php echo $_GET['company_name'];?>/p1">
				<img width="110px" alt="Logo" src="<?php echo $base_url?>/img/logo/<?php echo($general['logo']);?>" />
			</a>
		</div>

		<?php

		if(isset($_GET['cat_name'])){ $cat_name = $_GET['cat_name'] ; }

		if(!empty($cat_name)){

		 $cat_name = str_replace("-", " ", $cat_name);
		 //$cat_name = str_replace("and", "&", $cat_name);


		  $Query = "SELECT category_id FROM `category` where category_name = '".$cat_name."'";
		  $Cat_id = mysqlFetchRows($Query);

		  $category_id = $Cat_id[0]['category_id'];
		  }

		  if(isset($_GET['sub_cat_name'])){ $sub_cat_name = $_GET['sub_cat_name'] ;
			   $sub_cat_name = str_replace("-", " ", $sub_cat_name);
			   //$sub_cat_name = str_replace("and", "&", $sub_cat_name); 

				$sql = "SELECT sub_category_id FROM `sub_category` where sub_category_name = '".$sub_cat_name."' And category_id = ".$category_id."";
			  	$Sub_Cat_id = mysqlFetchRows($sql);
			  	$Sub_Cat_id = $Sub_Cat_id[0]['sub_category_id'];

			  }else{
			  	$Sub_Cat_id = '';
			  }

		?>
				
		<?php $Query = "SELECT * FROM `category` where company_id = '".$company_id."' order by order_id asc ";
			$Categories = mysqlFetchRows($Query);
			?>

			<form  class="mt-10 mb-10 SearchBox" method="get"  action="<?php echo $base_url;?><?php echo $_GET['company_name']?>/search/">
				<input class="pt-5 pr-5 pl-5 pb-5"  type="text" name="search" placeholder="Search ..." />
			</form>

			<nav>
				<ul>
					<li>
						<a href="<?php echo $base_url;?><?php echo $_GET['company_name'];?>/p1">
							Home 
						</a>
					</li>
					
					<?php foreach($Categories as $cat){ ?>
						<li>
							<a <?php if(!empty($category_id) && $category_id === $cat['category_id']){ echo 'class="active"' ; };
							?>  href="<?php echo $base_url;?><?php echo $_GET['company_name'];?>/category/<?php echo slug($cat['category_name'])?>/">
							<?php
								$Query = "SELECT * FROM `sub_category` where category_id = '".$cat['category_id']."' order by order_id asc";
								$sub_category = mysqlFetchRows($Query);
								if(!empty($sub_category)){
									$arrows = "&nbsp;»";
								}else{
									$arrows = "";
								}
							?>
								<?php echo $cat['category_name'] ;?><?php echo $arrows ;?> 
							</a>
						<?php 

						if(!empty($category_id) && $category_id == $cat['category_id']){
						
							if(!empty($sub_category)){ echo '<ul class="sub-menu pt-10 pb-10 pl-20">'; } 
							foreach($sub_category as $sub){?>
								<li>
								<a <?php if(!empty($Sub_Cat_id && $Sub_Cat_id == $sub['sub_category_id'])){ echo 'class="active"' ;}?> href="<?php echo $base_url;?><?php echo $_GET['company_name'];?>/categorys/<?php echo slug($cat['category_name'])?>/<?php echo slug($sub['sub_category_name']) ;?>/">
									<?php echo $sub['sub_category_name'] ;?> 
								</a>
							</li>
						<?php  } if(!empty($sub_category)){  echo '</ul>'; } 
						}
						?>
					<?php }?>
					</li>
				</ul>
			</nav>
		<div class="removeBorderright">
			<div class="spacer"></div>
		</div>
		
	</div>