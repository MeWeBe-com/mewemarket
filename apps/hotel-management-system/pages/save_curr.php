<?php require_once('../check_login.php');?>
<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('../connect.php');

extract($_POST);
$company = $_SESSION['company_id'];
   $sql = "INSERT INTO `tbl_currency`(`company_id`, `currcode`, `currsymbol`) VALUES ('$company','$currcode', '$currsymbol')";

 if ($conn->query($sql) === TRUE) {
      $_SESSION['success']=' Record Successfully Added';
     ?>
<script type="text/javascript">
window.location="../view_curr.php";
</script>
<?php
} else {
      $_SESSION['error']='Something Went Wrong';
?>
<script type="text/javascript">
window.location="../view_curr.php";
</script>
<?php } ?>