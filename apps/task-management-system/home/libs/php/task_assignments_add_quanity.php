<?php

include_once '../../../database/DatabaseConnect.php';

//echo "1 record added";

$TASK_ASSIGNMENT_ID = mysqli_real_escape_string($conn,$_POST['task_assignment_id']);
$TASK_DONE_QUANTITY = mysqli_real_escape_string($conn,$_POST['done_quantity']);
$TASK_DONE_QUANTITY += 1;
$TASK_ASSIGNED_QUANTITY = mysqli_real_escape_string($conn,$_POST['assigned_quantity']);
$DATE_ACCEPTED=date("Y-m-d");
// $PASSWORD = mysqli_real_escape_string($conn,$_POST['password']);

$response="";

$query="UPDATE `task_assignment` SET `DONE_AMOUNT` = '$TASK_DONE_QUANTITY'
WHERE `task_assignment`.`TASK_ASSIGNMENT_ID` = '$TASK_ASSIGNMENT_ID'
AND task_assignment.ASSIGNED_AMOUNT > task_assignment.DONE_AMOUNT";

$query_add = "UPDATE `task`
INNER JOIN task_assignment
ON task.TASK_ID = task_assignment.TASK_ID
SET task.TASK_AMOUNT_DONE = task.TASK_AMOUNT_DONE+1
WHERE `task_assignment`.`TASK_ASSIGNMENT_ID` = '$TASK_ASSIGNMENT_ID'";

if (!mysqli_query($conn,$query) || !mysqli_query($conn,$query_add)) {
  $response =  die('Error: ' . mysqli_error($conn));
  echo $response;
}
else {
  if ($TASK_DONE_QUANTITY == $TASK_ASSIGNED_QUANTITY){
    $TASK_DONE_QUANTITY = -2;
  }
  echo $TASK_DONE_QUANTITY;
}


    // For Security



mysqli_close($conn);
?>
