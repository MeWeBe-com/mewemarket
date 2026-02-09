<script>
var html_data = "";
$(document).ready(function(){
  $.ajax({
    type: 'GET',
    url: 'libs/php/task_list_retrieve.php',
    //data: form_data,
    // beforeSend: function()
    // {
    //   //$("#error").fadeOut();
    //   $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
    // },
    success: function (response) {
      // console.log(response);
      html_data = response;
      $('#task_category').html(html_data);
    }
  });
  console.log($('#task_category :selected').text());
});

</script>

<form class="form-signin col-md-4 col-md-offset-4" method="post" id="task-register-form" autocomplete="off">

        <h3 class="form-signin-heading" align="center">Add A New Task</h3><hr />

        <div id="status">
        <!-- error will be showen here ! -->
        </div>

        <div class="form-group">
        <input type="text" class="form-control" placeholder="Title Of The Task" name="task_title" id="task_title" />
        </div>

        <div class="form-group">
          <select class="form-control" id="task_category"></select>
        </div>

        <div class="form-group">
        <input type="text" class="form-control" placeholder="Amount Of The Task" name="task_amount" id="task_amount" />
        </div>

        <hr />
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-save" id="btn-submit">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Create New Task
   </button>
        </div>

 </form>
