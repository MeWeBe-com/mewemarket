<?php

include_once '../../../database/DatabaseConnect.php';

session_start();
//echo "1 record added";

// $TASK_CATEGORY=mysqli_real_escape_string($conn,$_POST['task_category']);
// $TASK_TITLE=mysqli_real_escape_string($conn,$_POST['task_title']);
// $TASK_AMOUNT=mysqli_real_escape_string($conn,$_POST['task_amount']);
// $DATE_ADDED=date("Y-m-d");
$ASSIGNED_TO=mysqli_real_escape_string($conn,$_SESSION['artisan']);
$response="";

$query="SELECT task_assignment.TASK_ASSIGNMENT_ID, task_assignment.DATE_ACCEPTED, task_assignment.DATE_ASSIGNED, task_assignment.ASSIGNED_BY, task_assignment.ASSIGNED_AMOUNT, task_assignment.DONE_AMOUNT, task.TASK_TITLE
FROM task_assignment
INNER JOIN task
ON task.TASK_ID = task_assignment.TASK_ID
WHERE task_assignment.ASSIGNED_TO = '$ASSIGNED_TO'
AND task_assignment.DATE_ACCEPTED IS NOT NULL
AND task_assignment.ASSIGNED_AMOUNT != task_assignment.DONE_AMOUNT";

$result = mysqli_query($conn,$query);
$response .= '
           <table id="ongoing-assignments" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                     <th>Task Assignment Id</th>
                     <th>Task Title</th>
                     <th>Assigned By</th>
                     <th>Assigned Date</th>
                     <th>Assigned Quantity</th>
                     <th>Done Quantity</th>
                </tr>
              </thead>
              <tbody>';

if( mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_array($result)) {
      //$status = compute_status($row);
      $response .= '
              <tr>
                <td>'.$row['TASK_ASSIGNMENT_ID'].'</td>
                <td>'.$row['TASK_TITLE'].'</td>
                <td>'.$row['ASSIGNED_BY'].'</td>
                <td>'.$row['DATE_ASSIGNED'].'</td>
                <td>'.$row['ASSIGNED_AMOUNT'].'</td>
                <td>'.$row['DONE_AMOUNT'].'<span style="display:inline-block; width: 5px;"></span>
                <div class="btn-group btn-group-xs" role="group" style="float:right;">
                <button type="button" class="btn btn-default add-task-done-quantity"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                <button type="button" class="btn btn-default remove-task-done-quantity"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
                </div>
                </td>
              </tr>';
    }
    $response .= '
              </tbody>
            </table>';
            echo $response;
  }
else  if( mysqli_num_rows($result) == 0){
  echo 'info: there is no ongoing assignments';
}
else {
  echo 'Error: Task either doesn\'t match and/or doesn\'t exist';
}



mysqli_close($conn);
?>
