<?php
session_start();
$company_name = $_SESSION['company_name'];

session_unset();
session_destroy();
?>
<script language="javascript">
document.location="<?php echo $company_name;?>";
</script>
