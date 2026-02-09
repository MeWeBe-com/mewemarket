<?php

include_once '../../../database/DatabaseConnect.php';

//echo "1 record added";

session_start();

// get session from database or create you own
// $username = $_SESSION['user'];

// echo "Success:". $username;

$TASK_ID=mysqli_real_escape_string($conn,$_POST['task_id']);
$TASK_AMOUNT=mysqli_real_escape_string($conn,$_POST['task_amount']);
$ASSIGNED_TO=mysqli_real_escape_string($conn,$_POST['task_assigned']);
$DATE_ASSIGNED=mysqli_real_escape_string($conn,$_POST['date_assigned']);
$MANAGER_COMMENT=mysqli_real_escape_string($conn,$_POST['manager_comment']);
$ASSIGNED_BY=mysqli_real_escape_string($conn,$_SESSION['user']);


$DATE_VAL = explode('-', $DATE_ASSIGNED);

$DATE_ASSIGNED = $DATE_VAL[0].'-'.$DATE_VAL[1].'-'.$DATE_VAL[2];
// var_dump($DATE_ASSIGNED);

$response="";

$query_user="SELECT * FROM employee WHERE EMPLOYEE_NAME = '$ASSIGNED_TO'";
$result_user = mysqli_query($conn,$query_user);

$query_task="SELECT * FROM task WHERE TASK_ID = '$TASK_ID'";
$result_task = mysqli_query($conn,$query_task);

$query_task_assignment="SELECT * FROM task WHERE TASK_ID = '$TASK_ID'";
$result_task_assignment = mysqli_fetch_assoc(mysqli_query($conn,$query_task_assignment));


if (!validateDate($DATE_ASSIGNED)){
  // $response= die('Error: Assign Date is in wrong format.);
  echo "Error: Assign Date is in wrong format.";
  exit();
}
elseif(strtotime($DATE_ASSIGNED) < strtotime(date('Y-m-d')))
{
  echo "Error: You cannot assign a date which has past.";
  exit();
}
elseif (mysqli_num_rows($result_user) != 1) {
  echo "Error: User ". $ASSIGNED_TO. " doesn't exist.";
  exit();
}
elseif (mysqli_num_rows($result_task) != 1) {
  echo "Error: Task ID: ". $TASK_ID. " doesn't exist.";
  exit();
}
elseif ($TASK_AMOUNT > ($result_task_assignment['TASK_AMOUNT'] - $result_task_assignment['TASK_AMOUNT_ASSIGNED']) ){
  $result_task = mysqli_fetch_assoc($result_task);
  echo "Error: You can only assign " . ($result_task_assignment['TASK_AMOUNT'] - $result_task_assignment['TASK_AMOUNT_ASSIGNED']) . " " . $result_task['TASK_TITLE'] . "(s) or less.";
  exit();
}
elseif(mysqli_num_rows(mysqli_query($conn,"SELECT Assigned_to from task_assignment where TASK_ID = '$TASK_ID' and ASSIGNED_TO = '$ASSIGNED_TO'")) == 1) {
  # code...UPDATE `task_assignment` SET `ASSIGNED_AMOUNT` = '40' WHERE `task_assignment`.`TASK_ASSIGNMENT_ID` = 1;
  $ALREADY_ASSIGNED_AMOUNT = mysqli_fetch_assoc(mysqli_query($conn,"SELECT ASSIGNED_AMOUNT from task_assignment where ASSIGNED_TO = '$ASSIGNED_TO'"))['ASSIGNED_AMOUNT'];
  $ADD_AMOUNT = $ALREADY_ASSIGNED_AMOUNT + $TASK_AMOUNT;

  $query_update_task_table = "UPDATE `task` SET `TASK_AMOUNT_ASSIGNED` = `TASK_AMOUNT_ASSIGNED` + $TASK_AMOUNT WHERE `task`.`TASK_ID` = '$TASK_ID'";

  if (!mysqli_query($conn,"UPDATE `task_assignment` SET `ASSIGNED_AMOUNT` = `ASSIGNED_AMOUNT` + $TASK_AMOUNT WHERE `task_assignment`.`TASK_ID` = '$TASK_ID' and `task_assignment`.`ASSIGNED_TO` = '$ASSIGNED_TO'")) {
    $response =  die('Error: ' . mysqli_error($conn));
    echo $response;
    exit();
  }
  else{
    if (!mysqli_query($conn,$query_update_task_table)) {
      $response =  die('Error: ' . mysqli_error($conn));
      echo $response;
      exit();
    }
    else {
      $result_task = mysqli_fetch_assoc($result_task);
      echo "Success: " . $TASK_AMOUNT . " additional " . $result_task['TASK_TITLE'] . "(s)" . " is assigned to " . $ASSIGNED_TO;
    }
  }
}
else{
  $query_assignment="INSERT INTO `task_assignment` (`ASSIGNED_TO`, `ASSIGNED_BY`, `DATE_ASSIGNED`, `TASK_ID`, `ASSIGNED_AMOUNT`, `MANAGER_COMMENT`) VALUES ('$ASSIGNED_TO', '$ASSIGNED_BY', '$DATE_ASSIGNED', '$TASK_ID', '$TASK_AMOUNT', '$MANAGER_COMMENT')";
  $query_update_task_table = "UPDATE `task` SET `DATE_ASSIGNED` = '$DATE_ASSIGNED', `TASK_AMOUNT_ASSIGNED` = `TASK_AMOUNT_ASSIGNED`+'$TASK_AMOUNT' WHERE `task`.`TASK_ID` = '$TASK_ID'";
  if (!mysqli_query($conn,$query_assignment)) {
    $response =  die('Error: ' . mysqli_error($conn));
    echo $response;
    exit();
  }
  elseif (!mysqli_query($conn,$query_update_task_table)) {
    $response =  die('Error: ' . mysqli_error($conn));
    echo $response;
    exit();
  }
  else{
    // echo 'Success: Task was assigned and updated.';
    $result_task = mysqli_fetch_assoc($result_task);
    echo "Success: " . $TASK_AMOUNT . " " . $result_task['TASK_TITLE'] . "(s)" . " is assigned to " . $ASSIGNED_TO;
  }
}





function validateDate($date)
{
  $d = DateTime::createFromFormat('Y-m-d', $date);
  return $d && $d->format('Y-m-d') === $date;
}


mysqli_close($conn);
?>
