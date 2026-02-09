<?php session_start(); include('../connection/config.php'); error_reporting(1)?>

<?php if(empty($_SESSION)){
    echo '<script type="text/javascript">
           window.location = "login.php";
      </script>';
  }

   $row['company_name'] = $_SESSION['company_name'];
   $url = $base_url.$row['company_name'].'/p1';
   session_unset();
   session_destroy();
   echo '<script type="text/javascript">
           window.location = "'.$url.'";
      </script>';
 ;?>

