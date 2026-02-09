<?php 

 $sql = "SELECT article_id,title,slug From `articles` where slug IS NULL";
$lines =  mysqlFetchRows($sql);


 if(!empty($lines)){
 	foreach($lines as $row){

 	//	print_r($row);
 	 $sql = "UPDATE `articles` SET `slug`= '".slug($row['title'])."'  WHERE article_id = '".$row['article_id']."'";
 	$updated =  mysqlUpdate($sql);

 	}
 }
 	

 	

?>

