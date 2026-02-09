<script>
var html_data = "";
$(document).ready(function(){
  $.ajax({
    type: 'GET',
    url: 'libs/php/employee_list_retrieve.php',
    //data: form_data,
    // beforeSend: function()
    // {
    //   //$("#error").fadeOut();
    //   $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
    // },
    success: function (response) {
      // console.log(response);
      html_data = response;
      $('#task_assigned').html(html_data);
    }
  });
  console.log($('#task_assigned :selected').text());
});

</script>

<form class="form-signin col-md-4 col-md-offset-4" method="post" id="assign-task-form" autocomplete="off">

        <h3 class="form-signin-heading" align="center">Assign A Task</h3><hr />

        <div id="status">
        <!-- error will be showen here ! -->
        </div>

        <div class="form-group">
        <input type="text" class="form-control" placeholder="ID Of The Task" name="task_id" id="task_id" />
        </div>

        <div class="form-group">
        <input type="text" class="form-control" placeholder="Amount Of The Task" name="task_amount" id="task_amount" />
        </div>

        <div class="form-group">
        <!-- <input type="text" class="form-control" id="task_assigned" /> -->
        <select class="form-control" id="task_assigned"></select>
        </div>

        <div class="form-group">
        <input type="date" class="form-control" placeholder="Assign Date (Year-Month-Day)" name="date_assigned" id="date_assigned" />
        </div>

        <div class="form-group">
        <input type="text" class="form-control" placeholder="Comment/Instructions" name="manager_comment" id="manager_comment" />
        </div>
        <!-- <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" id="password" />
        </div>

        <div class="form-group">
        <input type="password" class="form-control" placeholder="Retype Password" name="cpassword" id="cpassword" />
        </div>
      <hr /> -->
        <hr />
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-save" id="btn-submit">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Assign Task
   </button>
        </div>

 </form>
