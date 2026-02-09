<?php

include_once '../../../database/DatabaseConnect.php';

//echo "1 record added";

$TASK_ASSIGNMENT_ID = mysqli_real_escape_string($conn,$_POST['task_assignment_id']);
$DATE_ACCEPTED=date("Y-m-d");
// $PASSWORD = mysqli_real_escape_string($conn,$_POST['password']);

$response="";

$query="UPDATE `task_assignment` SET `DATE_ACCEPTED` = '$DATE_ACCEPTED' WHERE `task_assignment`.`TASK_ASSIGNMENT_ID` = $TASK_ASSIGNMENT_ID";

if (!mysqli_query($conn,$query)) {
  $response =  die('Error: ' . mysqli_error($conn));
  echo $response;
}
else {
  echo '<!-- Modal -->
<div class = "modal fade" id = "myModal" tabindex = "-1" role = "dialog"
   aria-labelledby = "myModalLabel" aria-hidden = "true">

   <div class = "modal-dialog">
      <div class = "modal-content">

         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>

            <h4 class = "modal-title" id = "myModalLabel">
               Notice!
            </h4>
         </div>

         <div class = "modal-body">
            <div class="alert alert-success" role="alert">You successfully accepted the assigned task.</div>
         </div>

         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Close
            </button>
         </div>

      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->

</div><!-- /.modal -->';
}


    // For Security



mysqli_close($conn);
?>
