<?php
session_start();
include('connect.php');

$sql = "SELECT * FROM `company` where company_id = ".$_SESSION['company_id'];
$result = $conn->query($sql);
$row =  $result->fetch_assoc();

session_destroy(); //destroy the session
 
?>
<script>
window.location = "<?php echo $row['company_name'];?>";
</script>
<?php //to redirect back to "index.php" after logging out
  exit;
?>