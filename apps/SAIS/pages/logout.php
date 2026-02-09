<?php

session_start();
$base = 'https://www.mewemarket.com/apps/SAIS/';
// 2. Unset all the session variables
unset($_SESSION['MEMBER_ID']);
unset($_SESSION['FIRST_NAME']);
unset($_SESSION['LAST_NAME']);
unset($_SESSION['GENDER']);
unset($_SESSION['EMAIL']);
unset($_SESSION['PHONE_NUMBER']);
unset($_SESSION['JOB_TITLE']);
unset($_SESSION['PROVINCE']);
unset($_SESSION['CITY']);
unset($_SESSION['TYPE']);
unset($_SESSION['pointofsale']);
?>

<script type="text/javascript">
    var location = "<?php echo $base.''.$_SESSION['COMPANY_NAME'].'/pages/login.php'?>";
    console.log(location);
</script>
