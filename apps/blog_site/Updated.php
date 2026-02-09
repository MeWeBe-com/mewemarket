<?php include('connection/config.php'); 

 	$id = $_GET['comment_id'];

 	$sql = 'UPDATE `article_comments` SET `comment_status`= 1 WHERE comment_id = '.$id;
 	$updated =  mysqlUpdate($sql);

 	$sql = 'SELECT * From `article_comments` as com 
 	left join category as cat
 	on cat.category_id = com.category_id
 	 WHERE com.comment_id = '.$id;
 	$comment =  mysqlFetchRow($sql);

 	if(!empty($comment['category_name'])){
 		echo("<script>location.href = '".$base_url."category/".$comment['category_name']."/';</script>");
 	}else{
 		echo("<script>location.href = '".$base_url."';</script>");
 	}




?>

