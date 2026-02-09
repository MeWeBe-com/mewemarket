<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','saasthemes_client_management_system');
define('DB_PASS','1000Dollar');
define('DB_NAME','saasthemes_client_management_system');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>