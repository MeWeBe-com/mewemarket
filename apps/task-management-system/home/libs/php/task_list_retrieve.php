<?php

include_once '../../../database/DatabaseConnect.php';

//echo "1 record added";

// $TASK_CATEGORY_TITLE=mysqli_real_escape_string($conn,$_POST['task_category']);
// $TASK_DEPARTMENT=mysqli_real_escape_string($conn,$_POST['task_dept']);

$response="";

$query="SELECT TASK_CATEGORY_TITLE FROM `task_category`";
$result = mysqli_query($conn,$query);
$response = "";
// $response .= '';


  if (!mysqli_query($conn,$query)) {
    //echo "ERROR";
    $response =  die('Error: ' . mysqli_error($conn));
    echo $response;
  }
  else {
    while ($row = mysqli_fetch_array($result)) {
      //$status = compute_status($row);
      $response .= '<option value="'.$row['TASK_CATEGORY_TITLE'].'">'.$row['TASK_CATEGORY_TITLE'].'</option>';
    }
    echo $response;
  }
// $response .= '</select>';

    // For Security



mysqli_close($conn);
?>
