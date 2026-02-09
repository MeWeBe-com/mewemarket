<?php

include_once '../../../database/DatabaseConnect.php';

session_start();
//echo "1 record added";

// $TASK_CATEGORY=mysqli_real_escape_string($conn,$_POST['task_category']);
// $TASK_TITLE=mysqli_real_escape_string($conn,$_POST['task_title']);
// $TASK_AMOUNT=mysqli_real_escape_string($conn,$_POST['task_amount']);
// $DATE_ADDED=date("Y-m-d");
$ASSIGNED_BY=mysqli_real_escape_string($conn,$_SESSION['user']);
$response="";

$query="SELECT * FROM `task` WHERE task.TASK_AMOUNT_ASSIGNED = 0";

$result = mysqli_query($conn,$query);
$response .= '
           <table id="un-assigned-tasks" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
              <thead>
                <tr>
                     <th>Task Id</th>
                     <th>Task Title</th>
                     <th>Task Category</th>
                     <th>Task Amount</th>
                </tr>
              </thead>
              <tbody>';

if( mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_array($result)) {
      //$status = compute_status($row);
      $response .= '
              <tr>
                <td>'.$row['TASK_ID'].'</td>
                <td>'.$row['TASK_TITLE'].'</td>
                <td>'.$row['TASK_CATEGORY'].'</td>
                <td>'.$row['TASK_AMOUNT'].'</td>
              </tr>';
    }
    $response .= '
              </tbody>
            </table>';
            echo $response;
  }
else {
  echo 'info: Task either doesn\'t match and/or doesn\'t exist';
}



mysqli_close($conn);
?>
