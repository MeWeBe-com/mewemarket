<?php

include_once '../../../database/DatabaseConnect.php';

session_start();
//echo "1 record added";

// $TASK_CATEGORY=mysqli_real_escape_string($conn,$_POST['task_category']);
// $TASK_TITLE=mysqli_real_escape_string($conn,$_POST['task_title']);
// $TASK_AMOUNT=mysqli_real_escape_string($conn,$_POST['task_amount']);
// $DATE_ADDED=date("Y-m-d");
// $EMPLOYEE_NAME = mysqli_real_escape_string($conn,$_POST['employee']);
$REPORT_PERIOD=mysqli_real_escape_string($conn,$_POST['period']);
$response="";

$response .= '
<table id="task-report" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
   <thead>
   <tr>
    <th>Artisan Name</th>';
$query_task_category = "SELECT task_category.TASK_CATEGORY_TITLE FROM task_category";
$query_employee = "SELECT employee.EMPLOYEE_NAME FROM employee
                   WHERE employee.EMPLOYEE_PRIVILEGE = 3
                   OR employee.EMPLOYEE_PRIVILEGE = 2
                   ORDER By employee.EMPLOYEE_NAME";
$result_category = mysqli_query($conn,$query_task_category);
$result_employee = mysqli_query($conn,$query_employee);
$task = array();
while ($row = mysqli_fetch_array($result_category)) {
  $response .= '
            <th>'.$row['TASK_CATEGORY_TITLE'].'</th>
            ';
  $task[] = $row['TASK_CATEGORY_TITLE'];
}

$response .= '</tr>
  </thead>
  <tbody>
';
if($REPORT_PERIOD == 'w'){
  while($row_employee = mysqli_fetch_array($result_employee)){
    $response .= '
    <tr>
    <td>'.$row_employee['EMPLOYEE_NAME'].'</td>
    ';
    // $response .=  '
    //   <td>6</td>
    // ';
    $employee = $row_employee['EMPLOYEE_NAME'];
    $counter = 0;
    while ($counter < sizeof($task)) {
      $query_task_amount = "SELECT ROUND(COALESCE(SUM(task_assignment.DONE_AMOUNT * task_category.UNIT_TASK_TIME),0), 2) AS DONE_AMOUNT_HOUR
                            FROM task
                            INNER JOIN task_assignment
                            ON task_assignment.TASK_ID = task.TASK_ID
                            INNER JOIN task_category
                            ON task_category.TASK_CATEGORY_TITLE = task.TASK_CATEGORY
                            WHERE task_assignment.ASSIGNED_TO = '$employee' AND task.TASK_CATEGORY LIKE '%$task[$counter]%' AND task_assignment.DATE_ASSIGNED >= DATE(NOW()) - INTERVAL 7 DAY";
      $result_task_amount = mysqli_query($conn,$query_task_amount);
      $response .=  '
        <td>'.mysqli_fetch_assoc($result_task_amount)['DONE_AMOUNT_HOUR'].'</td>
      ';
      $counter++;
    }
    $response .= '</tr>
    ';
  }
  $response .= '<tr>
  <td>Total</td>';
  $counter = 0;
  while($counter < sizeof($task)){
    $query_total_task_amount = "SELECT ROUND(COALESCE(SUM(task_assignment.DONE_AMOUNT * task_category.UNIT_TASK_TIME),0), 2) AS DONE_AMOUNT_HOUR
                                FROM task
                                INNER JOIN task_assignment
                                ON task_assignment.TASK_ID = task.TASK_ID
                                INNER JOIN task_category
                                ON task_category.TASK_CATEGORY_TITLE = task.TASK_CATEGORY
                                WHERE task.TASK_CATEGORY LIKE '%$task[$counter]%' AND task_assignment.DATE_ASSIGNED >= DATE(NOW()) - INTERVAL 7 DAY ";
    $result_total_task_amount = mysqli_query($conn,$query_total_task_amount);
    $response .=  '
      <td>'.mysqli_fetch_assoc($result_total_task_amount)['DONE_AMOUNT_HOUR'].'</td>
    ';
    $counter++;
  }
$response .= '
</tr>
</tbody>
</table>';

}

else if($REPORT_PERIOD == 'm'){
  while($row_employee = mysqli_fetch_array($result_employee)){
    $response .= '
    <tr>
    <td>'.$row_employee['EMPLOYEE_NAME'].'</td>
    ';
    // $response .=  '
    //   <td>6</td>
    // ';
    $employee = $row_employee['EMPLOYEE_NAME'];
    $counter = 0;
    while ($counter < sizeof($task)) {
      $query_task_amount = "SELECT ROUND(COALESCE(SUM(task_assignment.DONE_AMOUNT * task_category.UNIT_TASK_TIME),0), 2) AS DONE_AMOUNT_HOUR
                            FROM task
                            INNER JOIN task_assignment
                            ON task_assignment.TASK_ID = task.TASK_ID
                            INNER JOIN task_category
                            ON task_category.TASK_CATEGORY_TITLE = task.TASK_CATEGORY
                            WHERE task_assignment.ASSIGNED_TO = '$employee' AND task.TASK_CATEGORY LIKE '%$task[$counter]%' AND task_assignment.DATE_ASSIGNED >= DATE(NOW()) - INTERVAL 30 DAY ";
      $result_task_amount = mysqli_query($conn,$query_task_amount);
      $response .=  '
        <td>'.mysqli_fetch_assoc($result_task_amount)['DONE_AMOUNT_HOUR'].'</td>
      ';
      $counter++;
    }
    $response .= '</tr>';
  }

  $response .= '<tr>
  <td>Total</td>';
  $counter = 0;
  while($counter < sizeof($task)){
    $query_total_task_amount = "SELECT ROUND(COALESCE(SUM(task_assignment.DONE_AMOUNT * task_category.UNIT_TASK_TIME),0), 2) AS DONE_AMOUNT_HOUR
                                FROM task
                                INNER JOIN task_assignment
                                ON task_assignment.TASK_ID = task.TASK_ID
                                INNER JOIN task_category
                                ON task_category.TASK_CATEGORY_TITLE = task.TASK_CATEGORY
                                WHERE task.TASK_CATEGORY LIKE '%$task[$counter]%' AND task_assignment.DATE_ASSIGNED >= DATE(NOW()) - INTERVAL 30 DAY ";
    $result_total_task_amount = mysqli_query($conn,$query_total_task_amount);
    $response .=  '
      <td>'.mysqli_fetch_assoc($result_total_task_amount)['DONE_AMOUNT_HOUR'].'</td>
    ';
    $counter++;
  }

$response .= '
</tbody>
</table>';

}

if($REPORT_PERIOD == 'y'){
  while($row_employee = mysqli_fetch_array($result_employee)){
    $response .= '
    <tr>
    <td>'.$row_employee['EMPLOYEE_NAME'].'</td>
    ';
    // $response .=  '
    //   <td>6</td>
    // ';
    $employee = $row_employee['EMPLOYEE_NAME'];
    $counter = 0;
    while ($counter < sizeof($task)) {
      $query_task_amount = "SELECT ROUND(COALESCE(SUM(task_assignment.DONE_AMOUNT * task_category.UNIT_TASK_TIME),0), 2) AS DONE_AMOUNT_HOUR
                            FROM task
                            INNER JOIN task_assignment
                            ON task_assignment.TASK_ID = task.TASK_ID
                            INNER JOIN task_category
                            ON task_category.TASK_CATEGORY_TITLE = task.TASK_CATEGORY
                            WHERE task_assignment.ASSIGNED_TO LIKE '%$employee%' AND task.TASK_CATEGORY LIKE '%$task[$counter]%' AND task_assignment.DATE_ASSIGNED >= DATE(NOW()) - INTERVAL 365 DAY";
      $result_task_amount = mysqli_query($conn,$query_task_amount);
      $response .=  '
        <td>'.mysqli_fetch_assoc($result_task_amount)['DONE_AMOUNT_HOUR'].'</td>
      ';
      $counter++;
    }
    $response .= '</tr>';
  }

  $response .= '<tr>
  <td>Total</td>';
  $counter = 0;
  while($counter < sizeof($task)){
    $query_total_task_amount = "SELECT ROUND(COALESCE(SUM(task_assignment.DONE_AMOUNT * task_category.UNIT_TASK_TIME),0), 2) AS DONE_AMOUNT_HOUR
                                FROM task
                                INNER JOIN task_assignment
                                ON task_assignment.TASK_ID = task.TASK_ID
                                INNER JOIN task_category
                                ON task_category.TASK_CATEGORY_TITLE = task.TASK_CATEGORY
                                WHERE task.TASK_CATEGORY LIKE '%$task[$counter]%' AND task_assignment.DATE_ASSIGNED >= DATE(NOW()) - INTERVAL 365 DAY ";
    $result_total_task_amount = mysqli_query($conn,$query_total_task_amount);
    $response .=  '
      <td>'.mysqli_fetch_assoc($result_total_task_amount)['DONE_AMOUNT_HOUR'].'</td>
    ';
    $counter++;
  }
$response .= '
</tbody>
</table>';

}

echo $response;
mysqli_close($conn);
?>
