<?php

include_once '../../../database/DatabaseConnect.php';

session_start();

$NEW_PASSWORD = mysqli_real_escape_string($conn,$_POST['new_password']);
$CONFIRM_PASSWORD = mysqli_real_escape_string($conn,$_POST['confirm_password']);
$USER = $_SESSION['user'];
$response="";

$query="UPDATE `employee` SET `EMPLOYEE_PASSWORD` = '$NEW_PASSWORD' WHERE employee.EMPLOYEE_NAME = '$USER'";

if (!mysqli_query($conn,$query)) {
  $response =  die('Error: ' . mysqli_error($conn));
  echo $response;
}
else {
  echo "Successfully changed the password";
}


    // For Security



mysqli_close($conn);

 ?>
