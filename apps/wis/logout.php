<?php ob_start();
  require_once('includes/load.php');
  if(!$session->logout()) {redirect($_SESSION['company_name']."");}
?>
