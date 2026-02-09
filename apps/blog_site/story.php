<?php include('connection/config.php'); 

 	$title = $_GET['title'];

 	$title = str_replace('-', '+', $title);
 
 	echo("<script>location.href = '".$base_url."search/?search=".$title."&tag=true';</script>");
 	

?>

