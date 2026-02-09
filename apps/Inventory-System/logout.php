<?php 

require_once 'php_action/core.php';
$company_name = $_SESSION['company_name'];
session_unset();
session_destroy();

header('location: '.$company_name);

?>