<?php include('connection/config.php'); 

$article_id = $_GET['article_id'];
$ip = $_SERVER['REMOTE_ADDR'];

	$Query = "SELECT * FROM `article_like` where ip = '".$ip."' AND article_id = '".$article_id."' ";
	$like = mysqlFetchRows($Query);

	if(empty($like)){
		$sql = "INSERT INTO `article_like` (`article_id`, `ip`, `status`) VALUES ('".$article_id."','".$ip."','1')";
		$general = mysqlInsert($sql);

		$Query = "SELECT COUNT('status') as Likes FROM `article_like` where article_id = '".$article_id."' ";
		$Likes = mysqlFetchRow($Query);

		echo $Likes['Likes'];

	}else{

		$Query = "SELECT COUNT('status') as Likes FROM `article_like` where article_id = '".$article_id."' ";
		$Likes = mysqlFetchRow($Query);

		echo $Likes['Likes'];
	}



 ?>

