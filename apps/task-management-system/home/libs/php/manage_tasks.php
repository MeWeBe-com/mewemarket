<?php

include_once '../../../database/DatabaseConnect.php';

session_start();
//echo "1 record added";

// $TASK_CATEGORY=mysqli_real_escape_string($conn,$_POST['task_category']);
// $TASK_TITLE=mysqli_real_escape_string($conn,$_POST['task_title']);
// $TASK_AMOUNT=mysqli_real_escape_string($conn,$_POST['task_amount']);
// $DATE_ADDED=date("Y-m-d");
$ASSIGNED_BY=mysqli_real_escape_string($conn,$_SESSION['user']);
$DATE_COMPLETED=date("Y-m-d");
$response="";

$query="SELECT task.TASK_ID, task.TASK_TITLE , task.DATE_ASSIGNED, task.DATE_COMPLETED, task.TASK_AMOUNT, task_assignment.DATE_ACCEPTED,  task.TASK_AMOUNT_ASSIGNED, task.TASK_AMOUNT_DONE, GROUP_CONCAT(assigned_to ORDER BY assigned_to ASC SEPARATOR ', ') AS PEOPLE_ASSIGNED
FROM task_assignment
INNER JOIN task
ON task_assignment.TASK_ID = task.TASK_ID
WHERE task_assignment.ASSIGNED_BY = '$ASSIGNED_BY'
GROUP BY task_assignment.TASK_ID
ORDER BY task.DATE_ADDED DESC";

$TASK_ID = -1;

$result = mysqli_query($conn,$query);
$response .= '
           <table id="manage-tasks" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                     <th>Task Id</th>
                     <th>Task Title</th>
                     <th>Task Status</th>
                     <th>Date Assigned</th>
                     <th>Date Completed</th>
                     <th>Task Quantity</th>
                     <th>Quantity Assigned</th>
                     <th>Quantity Done</th>
                     <th>People Assigned</th>
                </tr>
              </thead>
              <tbody>';

if( mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_array($result)) {
      $status = compute_status($conn,$row);
      $TASK_ID = $row['TASK_ID'];
      $response .= '
              <tr>
                <td>'.$row['TASK_ID'].'</td>
                <td>'.$row['TASK_TITLE'].'</td>
                <td>'.$status.'</td>
                <td>'.$row['DATE_ASSIGNED'].'</td>
                <td>'.$row['DATE_COMPLETED'].'</td>
                <td>'.$row['TASK_AMOUNT'].'</td>
                <td>'.$row['TASK_AMOUNT_ASSIGNED'].'</td>
                <td>'.$row['TASK_AMOUNT_DONE'].'</td>
                <td>'.$row['PEOPLE_ASSIGNED'].'</td>
              </tr>';
    }
    $response .= '
              </tbody>
            </table>';
            echo $response;
  }
else {
  echo 'Error: Task Category either doesn\'t match and/or doesn\'t exist';
}

    // For Security
function compute_status($conn, $row){
  $status = "";

  if ($row['TASK_AMOUNT_ASSIGNED'] == 0){
    $status = '<span class="label label-danger">Not Assigned</span>';
  }
  else if($row['DATE_ACCEPTED'] == NULL && $row['TASK_AMOUNT_DONE'] > 0){
    $status = '<span class="label label-info">Partially Started</span>';
  }
  else if($row['DATE_ACCEPTED'] != NULL && $row['TASK_AMOUNT_DONE'] == 0){
    $status = '<span class="label label-warning">Not Started</span>';
  }
  else if($row['DATE_ACCEPTED'] == NULL){
    $status = '<span class="label label-warning">Not Started</span>';
  }
  else if ($row['TASK_AMOUNT_ASSIGNED'] >= 0 && $row['TASK_AMOUNT_DONE'] < $row['TASK_AMOUNT']){
    $status = '<span class="label label-info">On Going</span>';
  }
  else if ($row['TASK_AMOUNT_DONE'] == $row['TASK_AMOUNT']){
    $status = '<span class="label label-success">Completed</span>';
    if( is_null($row['DATE_COMPLETED'])){
      $DATE_COMPLETED=date("Y-m-d");
      $TASK_ID = $row['TASK_ID'];
      $query_completed_task_date = "UPDATE `task` SET `DATE_COMPLETED` = '$DATE_COMPLETED' WHERE `task`.`TASK_ID` = '$TASK_ID'";
      mysqli_query($conn,$query_completed_task_date);
    }

  }
  else{
    $status = '<span class="label label-danger">There is some error</span>';
  }
  return $status;
}


mysqli_close($conn);
?>
