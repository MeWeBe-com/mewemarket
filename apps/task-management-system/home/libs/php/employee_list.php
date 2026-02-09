<?php

include_once '../../../database/DatabaseConnect.php';

session_start();
//echo "1 record added";

// $TASK_CATEGORY=mysqli_real_escape_string($conn,$_POST['task_category']);
// $TASK_TITLE=mysqli_real_escape_string($conn,$_POST['task_title']);
// $TASK_AMOUNT=mysqli_real_escape_string($conn,$_POST['task_amount']);
// $DATE_ADDED=date("Y-m-d");
$ASSIGNED_BY=mysqli_real_escape_string($conn,$_SESSION['user']);
// $DATE_COMPLETED=date("Y-m-d");
$response="";

$query="select employee.EMPLOYEE_NAME
FROM employee
WHERE employee.EMPLOYEE_PRIVILEGE = 3
ORDER BY employee.EMPLOYEE_NAME ASC";

// $TASK_ID = -1;

$result = mysqli_query($conn,$query);
// <div class='row text-center' style='margin-bottom:15px; margin-top: 15px;'><button type="button" class="btn btn-primary artisan-report">Download Weekly Report of " + employee_name + "</button></div>

$response .= '
<div class="list-group col-md-4 col-md-offset-4">
<a href="#" class="list-group-item">Download Report (Q)
<div class="btn-group btn-group-xs" role="group" style="float:right;">
  <button type="button" class="btn btn-default artisan-total-weekly-report">Week</button>
  <button type="button" class="btn btn-default artisan-total-monthly-report">Month</button>
  <button type="button" class="btn btn-default artisan-total-yearly-report">Year</button>
</div>
</a>

<a href="#" class="list-group-item">Download Report (H)
<div class="btn-group btn-group-xs" role="group" style="float:right;">
  <button type="button" class="btn btn-default artisan-total-weekly-report-hour">Week</button>
  <button type="button" class="btn btn-default artisan-total-monthly-report-hour">Month</button>
  <button type="button" class="btn btn-default artisan-total-yearly-report-hour">Year</button>
</div>
</a>
</div>
<div class="list-group col-md-4 col-md-offset-4">';

if( mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_array($result)) {
      // $status = compute_status($conn,$row);
      // $TASK_ID = $row['TASK_ID'];
      // $PERCENTAGE = intval(($row['TASK_AMOUNT_DONE'] / $row['TASK_AMOUNT'])*100);
      $response .= '
      <a href="#" class="list-group-item">'.$row['EMPLOYEE_NAME'].'
      <div class="btn-group btn-group-xs" role="group" style="float:right;">
        <button type="button" class="btn btn-success artisan-weekly-report">Week</button>
        <button type="button" class="btn btn-info artisan-monthly-report">Month</button>
        <button type="button" class="btn btn-warning artisan-yearly-report">Year</button>
      </div>
      </a>
              ';
    }
    $response .= '
            </div>';
            echo $response;
  }
else {
  echo 'Error: Task Category either doesn\'t match and/or doesn\'t exist';
}

    // For Security


mysqli_close($conn);
?>
