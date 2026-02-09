<?php

include_once '../../../database/DatabaseConnect.php';

//echo "1 record added";

$TASK_CATEGORY=mysqli_real_escape_string($conn,$_POST['task_category']);
$TASK_TITLE=mysqli_real_escape_string($conn,$_POST['task_title']);
$TASK_AMOUNT=mysqli_real_escape_string($conn,$_POST['task_amount']);
$DATE_ADDED=date("Y-m-d");

$response="";

$query="SELECT * FROM task_category WHERE TASK_CATEGORY_TITLE = '$TASK_CATEGORY'";
$result = mysqli_query($conn,$query);
if( mysqli_num_rows($result) == 1){
  $query="INSERT INTO `task` (`TASK_CATEGORY`, `DATE_ASSIGNED`, `DATE_COMPLETED`, `TASK_TITLE`, `TASK_AMOUNT`, `TASK_PERCENTAGE`, `DATE_ADDED`) VALUES ('$TASK_CATEGORY', NULL, NULL, '$TASK_TITLE', '$TASK_AMOUNT', NULL, '$DATE_ADDED')";
  if (!mysqli_query($conn,$query)) {
    $response =  die('Error: ' . mysqli_error($conn));
    echo $response;
  }
  else {
    echo 'Success: Task was added.';
  }
}
else {
  echo 'Error: Task Category either doesn\'t match and/or doesn\'t exist';
}

    // For Security



mysqli_close($conn);
?>
