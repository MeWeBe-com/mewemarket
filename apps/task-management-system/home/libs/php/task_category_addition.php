<?php

include_once '../../../database/DatabaseConnect.php';

//echo "1 record added";

$TASK_CATEGORY_TITLE=mysqli_real_escape_string($conn,$_POST['task_category']);
$TASK_DEPARTMENT=mysqli_real_escape_string($conn,$_POST['task_dept']);

$response="";

$query="SELECT * FROM departments WHERE DEPARTMENT_NAME = '$TASK_DEPARTMENT'";
$result = mysqli_query($conn,$query);
if( mysqli_num_rows($result) == 1){
  $query="INSERT INTO `task_category` (`TASK_CATEGORY_TITLE`, `TASK_CATEGORY_DEPARTMENT`) VALUES ('$TASK_CATEGORY_TITLE', '$TASK_DEPARTMENT')";
  if (!mysqli_query($conn,$query)) {
    $response =  die('Error: ' . mysqli_error($conn));
    echo $response;
  }
  else {
    echo 'Success: Task Category was added.';
  }
}
else {
  echo 'Error: Department doesn\'t exist';
}

    // For Security



mysqli_close($conn);
?>
