<?php require_once('../check_login.php');?>
<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('../connect.php');

extract($_POST);
$company = $_SESSION['company_id'];
   $sql = "INSERT INTO `tbl_tax`(`company_id`,`taxname`, `percentage`, `shortcode`) VALUES ('$company','$taxname', '$percentage', '$shortcode')";

 if ($conn->query($sql) === TRUE) {
      $_SESSION['success']=' Record Successfully Added';
     ?>
<script type="text/javascript">
window.location="../view_tax.php";
</script>
<?php
} else {
      $_SESSION['error']='Something Went Wrong';
?>
<script type="text/javascript">
window.location="../view_tax.php";
</script>
<?php } ?>