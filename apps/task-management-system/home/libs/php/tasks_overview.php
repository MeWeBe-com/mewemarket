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
FROM task
LEFT JOIN task_assignment
ON task_assignment.TASK_ID = task.TASK_ID
GROUP BY task_assignment.TASK_ID
ORDER BY task.DATE_ADDED DESC";

$TASK_ID = -1;

$result = mysqli_query($conn,$query);
$response .= '
           <table id="task-overview" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                     <th>Task Id</th>
                     <th>Task Title</th>
                     <th>Task Status</th>
                     <th>Assigned To</th>
                     <th>Task Progress</th>
                </tr>
              </thead>
              <tbody>';

if( mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_array($result)) {
      $status = compute_status($conn,$row);
      $TASK_ID = $row['TASK_ID'];
      $PERCENTAGE = intval(($row['TASK_AMOUNT_DONE'] / $row['TASK_AMOUNT'])*100);
      $response .= '
              <tr>
                <td>'.$row['TASK_ID'].'</td>
                <td>'.$row['TASK_TITLE'].'</td>
                <td>'.$status.'</td>
                <td>'.$row['PEOPLE_ASSIGNED'].'</td>
                <td>
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="'.$PERCENTAGE.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$PERCENTAGE.'%;">
                      '.$PERCENTAGE.'%
                    </div>
                  </div>
                </td>
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

  if ($row['DATE_ASSIGNED'] == NULL){
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
