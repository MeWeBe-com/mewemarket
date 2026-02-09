<?php include("DBdetails.php");
$db = mysqli_connect(LOCALHOST, USERNAME, PASSWORD);
global $db;
mysqli_select_db($db,DATABASE);

include("functions.mysql.php");
include("functions.php");
include("array.php");
//include("../lib/array.php");
$base = "https://".$_SERVER['HTTP_HOST']."/"; 
$sitetitle = ""; 

function remove_bad_characters($Str) {  
  $StrArr = str_split($Str); $NewStr = '';
  foreach ($StrArr as $Char) {    
    $CharNo = ord($Char);
    if ($CharNo == 163) { $NewStr .= $Char; continue; } // keep £ 
    if ($CharNo > 31 && $CharNo < 127) {
      $NewStr .= $Char;    
    }
  }  
  return $NewStr;
}

$base_url = 'https://wachatrade.com/';
?>