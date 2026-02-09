<?php

include_once '../../../database/DatabaseConnect.php';

session_start();
//echo "1 record added";

// $TASK_CATEGORY=mysqli_real_escape_string($conn,$_POST['task_category']);
// $TASK_TITLE=mysqli_real_escape_string($conn,$_POST['task_title']);
// $TASK_AMOUNT=mysqli_real_escape_string($conn,$_POST['task_amount']);
// $DATE_ADDED=date("Y-m-d");
$EMPLOYEE_NAME = mysqli_real_escape_string($conn,$_POST['employee']);
$REPORT_PERIOD=mysqli_real_escape_string($conn,$_POST['period']);
$response="";

$query_task_list = "SELECT task_category.TASK_CATEGORY_TITLE FROM  task_category";

if($REPORT_PERIOD == 'Weekly'){
  $query="Select task_category.TASK_CATEGORY_TITLE, SUM(task_assignment.DONE_AMOUNT) AS QUANTITY_DONE, SUM(task_assignment.ASSIGNED_AMOUNT) AS QUANTITY_ASSIGNED, ROUND(task_assignment.DONE_AMOUNT * task_category.UNIT_TASK_TIME, 2) AS HOURS_WORKED
  from task
  INNER JOIN task_assignment
  ON task_assignment.TASK_ID = task.TASK_ID
  INNER JOIN task_category
  ON task.TASK_CATEGORY = task_category.TASK_CATEGORY_TITLE
  WHERE task_assignment.ASSIGNED_TO='$EMPLOYEE_NAME' AND task_assignment.DATE_ASSIGNED >= DATE(NOW()) - INTERVAL 7 DAY
  GROUP BY task_category.TASK_CATEGORY_TITLE";
}
else if($REPORT_PERIOD == 'Monthly'){
  $query="Select task_category.TASK_CATEGORY_TITLE, SUM(task_assignment.DONE_AMOUNT) AS QUANTITY_DONE, SUM(task_assignment.ASSIGNED_AMOUNT) AS QUANTITY_ASSIGNED, ROUND(task_assignment.DONE_AMOUNT * task_category.UNIT_TASK_TIME, 2) AS HOURS_WORKED
  from task
  INNER JOIN task_assignment
  ON task_assignment.TASK_ID = task.TASK_ID
  INNER JOIN task_category
  ON task.TASK_CATEGORY = task_category.TASK_CATEGORY_TITLE
  WHERE task_assignment.ASSIGNED_TO='$EMPLOYEE_NAME' AND task_assignment.DATE_ASSIGNED >= DATE(NOW()) - INTERVAL 30 DAY
  GROUP BY task_category.TASK_CATEGORY_TITLE";
}
else if($REPORT_PERIOD == 'Yearly'){
  $query="Select task_category.TASK_CATEGORY_TITLE, SUM(task_assignment.DONE_AMOUNT) AS QUANTITY_DONE, SUM(task_assignment.ASSIGNED_AMOUNT) AS QUANTITY_ASSIGNED, ROUND(task_assignment.DONE_AMOUNT * task_category.UNIT_TASK_TIME, 2) AS HOURS_WORKED
  from task
  INNER JOIN task_assignment
  ON task_assignment.TASK_ID = task.TASK_ID
  INNER JOIN task_category
  ON task.TASK_CATEGORY = task_category.TASK_CATEGORY_TITLE
  WHERE task_assignment.ASSIGNED_TO='$EMPLOYEE_NAME' AND task_assignment.DATE_ASSIGNED >= DATE(NOW()) - INTERVAL 365 DAY
  GROUP BY task_category.TASK_CATEGORY_TITLE";
}



// $TASK_ID = -1;

// $result = mysqli_query($conn,$query_task_list);
//
// while ($row = mysqli_fetch_array($result)) {
//   // $status = compute_status($conn,$row);
//   // $TASK_ID = $row['TASK_ID'];
//   // $PERCENTAGE = intval(($row['TASK_AMOUNT_DONE'] / $row['TASK_AMOUNT'])*100);
//   $response .= $row['TASK_CATEGORY_TITLE'].',';
// }
//
// $response = substr($response, 0, -1);
$result = mysqli_query($conn,$query);
$response .= 'Task Title,Quantity Assigned,Quantity Done,Hours Worked'."\n";

if( mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_array($result)) {
      // $status = compute_status($conn,$row);
      // $TASK_ID = $row['TASK_ID'];
      // $PERCENTAGE = intval(($row['TASK_AMOUNT_DONE'] / $row['TASK_AMOUNT'])*100);
      $response .= $row['TASK_CATEGORY_TITLE'].','.$row['QUANTITY_ASSIGNED'].','.$row['QUANTITY_DONE'].','.$row['HOURS_WORKED']."\n";
    }

  }
else {
  echo 'Error: Task Category either doesn\'t match and/or doesn\'t exist';
}

$response = substr($response, 0, -1);
    // For Security
// function compute_status($conn, $row){
//   $status = "";
//
//   if ($row['TASK_AMOUNT_ASSIGNED'] == 0){
//     $status = '<span class="label label-danger">Not Assigned</span>';
//   }
//   else if($row['DATE_ACCEPTED'] == NULL){
//     $status = '<span class="label label-warning">Not Started</span>';
//   }
//   else if ($row['TASK_AMOUNT_ASSIGNED'] >= 0 && $row['TASK_AMOUNT_DONE'] < $row['TASK_AMOUNT']){
//     $status = '<span class="label label-info">On Going</span>';
//   }
//   else if ($row['TASK_AMOUNT_DONE'] == $row['TASK_AMOUNT']){
//     $status = '<span class="label label-success">Completed</span>';
//     if( is_null($row['DATE_COMPLETED'])){
//       $DATE_COMPLETED=date("Y-m-d");
//       $TASK_ID = $row['TASK_ID'];
//       $query_completed_task_date = "UPDATE `task` SET `DATE_COMPLETED` = '$DATE_COMPLETED' WHERE `task`.`TASK_ID` = '$TASK_ID'";
//       mysqli_query($conn,$query_completed_task_date);
//     }
//
//   }
//   else{
//     $status = '<span class="label label-danger">There is some error</span>';
//   }
//   return $status;
// }


echo $response;
mysqli_close($conn);
//
// // Creates a new csv file and store it in tmp directory
//   $new_csv = fopen('report.csv', 'w');
//   fputcsv($new_csv, $response);
//   fclose($new_csv);
//
//   // output headers so that the file is downloaded rather than displayed
//   header("Content-type: text/csv");
//   header("Content-disposition: attachment; filename = report.csv");
//   readfile("report.csv");


?>
