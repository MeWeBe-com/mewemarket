<?php include('connection/config.php'); 


$sql = "SELECT article_id,description From `articles`";
$lines =  mysqlFetchRows($sql);

 	foreach($lines as $row){  

 		$description = $row['description'];
	 	$description = str_replace('�', '&nbsp;', $description);

	 	echo($description);

 	 	/* echo $sqls = "UPDATE `articles` SET `description`= '".$description."'  WHERE article_id = '".$row['article_id']."'";
	 	 $updated =  mysqlUpdate($sqls);
*/
 	}
 
 	

 	

?>



