<?php require_once('../check_login.php');?>
<?php
date_default_timezone_set('Asia/Kolkata');
$current_date = date('Y-m-d');
include('../connect.php');

extract($_POST);
$company = $_SESSION['company_id'];

$sql = "INSERT INTO `tbl_booking`(`company_id`,`name`, `roomname`, `kidno`, `adultno`, `fromdate`, `todate`,`taxdiscount`, `totalamount`, `advance_paid`) VALUES ('$company','$name', '$roomname', '$kidno', '$adultno', '$fromdate', '$todate', '$taxdiscount', '$totalamount', '$advance_paid')";

 if ($conn->query($sql) === TRUE) {
      $_SESSION['success']=' Record Successfully Added';
     ?>
<script type="text/javascript">
window.location="../view_booking.php";
</script>
<?php
} else {
      $_SESSION['error']='Something Went Wrong';
?>
<script type="text/javascript">
window.location="../view_booking.php";
</script>
<?php } ?>