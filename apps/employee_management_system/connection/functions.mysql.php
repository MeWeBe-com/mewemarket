<?php
function mysqlQuery( $query ){
	global $db;
	$res = mysqli_query($db,$query) or die(mysqli_error());
	return $res;
}
function mysqlFetchRow($query){
	$res = mysqlQuery($query);
	if(mysqli_num_rows($res)>0){
		return mysqli_fetch_assoc($res);
	}else{
		return false;
	}	
}
function mysqlFetchRows($query){
	$res = mysqlQuery($query);
	if(mysqli_num_rows($res)>0){
		$rows = array();
		while($rs = mysqli_fetch_assoc($res)){
			$rows[] = $rs;
		}
		return $rows;
	}else{
		return array();
	}	
}
function mysqlFetchSingle($query){
	$res = mysqlQuery($query);
	if(mysqli_num_rows($res)>0){
		$t = mysqli_fetch_array($res);
		return $t[0];
	}else{
		return false;
	}	
}
function mysqlUpdate($query){
		global $db;
	mysqlQuery($query);
	return mysqli_affected_rows($db);
}
function mysqlInsert($query){
		global $db;

	mysqlQuery($query);
	return mysqli_insert_id($db);
}
?>