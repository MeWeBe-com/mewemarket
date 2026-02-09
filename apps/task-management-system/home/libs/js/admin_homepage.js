$(document).ready(function(){
	fetch_all_task_data();
});

$( ".replacediv").click(function() {

	var clickedValue = $(this).text();

	if(clickedValue.includes("Add A New Task Category")){
		$("#insert-heading").html("");
		$("#insert-element").hide();
		$("#insert-element").load("snippet/add_new_task_type.php");
		$("#insert-element").fadeIn(1000);
		// $("#insert-element").fadeOut(0).load("snippet/add_new_task_type.php").fadeIn('slow');
	}
	else if (clickedValue.includes("Add A New Task")) {
		$("#insert-heading").html("");
		$("#insert-element").hide();
		$("#insert-element").load("snippet/add_new_task.php");
		$("#insert-element").fadeIn(1000);
		// $("#insert-element").fadeOut(0).load("snippet/add_new_task.php").fadeIn('slow');
	}
	else if (clickedValue.includes("Add New Artisan")) {
		$("#insert-heading").html("");
		$("#insert-element").hide();
		$("#insert-element").load("snippet/add_new_artisan.php");
		$("#insert-element").fadeIn(1000);
		// $("#insert-element").fadeOut(0).load("snippet/add_new_task.php").fadeIn('slow');
	}
	else if (clickedValue.includes("Add New Manager")) {
		$("#insert-heading").html("");
		$("#insert-element").hide();
		$("#insert-element").load("snippet/add_new_manager.php");
		$("#insert-element").fadeIn(1000);
		// $("#insert-element").fadeOut(0).load("snippet/add_new_task.php").fadeIn('slow');
	}
	else if (clickedValue.includes("Assign Task")) {
		$("#insert-heading").html("");
		$("#insert-element").hide();
		$("#insert-element").load("snippet/assign_task.php");
		$("#insert-element").fadeIn(1000);
		// $("#insert-element").fadeOut(0).load("snippet/add_new_task.php").fadeIn('slow');
	}
	else if (clickedValue.includes("Change Password")) {
		$("#insert-heading").html("");
		$("#insert-element").hide();
		$("#insert-element").load("snippet/change_password.php");
		$("#insert-element").fadeIn(1000);
	}
	else if (clickedValue.includes("Home")) {
		fetch_all_task_data();
		// $("#insert-heading").html("");
		// $("#insert-element").hide();
		// $("#insert-element").load("snippet/assign_task.php");
		// $("#insert-element").fadeIn(1000);
		// $("#insert-element").fadeOut(0).load("snippet/add_new_task.php").fadeIn('slow');
	}
	else if (clickedValue.includes("Manage Tasks")) {
		// $("#insert-element").hide();
		// $("#insert-element").load("snippet/manage_tasks.php");
		// $("#insert-element").fadeIn(1000);
		// $("#insert-element").fadeOut(0).load("snippet/add_new_task.php").fadeIn('slow');
		fetch_manage_task_data();
	}
	else if (clickedValue.includes("Un-assigned Tasks")) {
		fetch_un_assigned_task_data();
	}
	else if (clickedValue.includes("Pending Assignments")) {
		fetch_pending_assignments_data();
	}
	else if (clickedValue.includes("Ongoing Assignments")) {
		fetch_ongoing_assignments_data();
	}
	else if (clickedValue.includes("Manage Completed Assignments")) {
		fetch_completed_assignments_data();
	}
	else if (clickedValue.includes("Artisan Stats")) {
		fetch_employee_list_data();
	}


});

//--------------------------Task Category Registration------------------------------------------//
$(document.body).on("submit", '#task-category-register-form',function(e){
	//alert("hey");
	e.preventDefault();

	var task_category = document.getElementById("task_category").value;
	var task_dept = document.getElementById("task_dept").value;

	if (task_category == '' || task_dept == '') {
		//alert('please add value');
		$('#status').html('<div class = "alert alert-info">Please fill up all the fields.</div>');
	}
	else {
		var form_data = $('#task-category-register-form').serialize();

		$.ajax({
			type: 'POST',
			url: 'libs/php/task_category_addition.php',
			data: form_data,
			beforeSend: function()
			{
				//$("#error").fadeOut();
				$("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success: function (response) {
				if(response.split(':')[0].includes("Error")){
					$('#status').html('<div class = "alert alert-danger">' + response + '</div>');
				}
				else {
					$('#status').html('<div class = "alert alert-success">' + response + '</div>');
				}

			},
			complete: function()
			{
				$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create New Task Category');
			}
		});
	}
	//$('#task-category-register-form').reset();
	document.getElementById("task-category-register-form").reset();

});
//--------------------------Task Category Registration------------------------------------------//

//--------------------------Task Registration------------------------------------------//
$(document.body).on("submit", '#task-register-form',function(e){
	// alert("hey");
	e.preventDefault();
	// alert($('#task_category :selected').text());
	var task_title = document.getElementById("task_title").value;
	var task_category = document.getElementById("task_category").value;
	var task_amount = document.getElementById("task_amount").value;
	// task_category = "Backup";
	// console.log("val is");
	// console.log(task_category);

	if (task_category == '' || task_title == '' || task_amount == '') {
		//alert('please add value');
		$('#status').html('<div class = "alert alert-info">Please fill up all the fields.</div>');
	}
	else if(parseInt(task_amount) <= 0){
		$('#status').html('<div class = "alert alert-info">Enter a positive numeric value for Task Amount.</div>');
	}
	else if (isNaN(task_amount)) {
		$('#status').html('<div class = "alert alert-info">Enter a numeric value for Task Amount.</div>');
	}
	else {
		// var form_data = .serialize();

		$.ajax({
			type: 'POST',
			url: 'libs/php/task_addition.php',
			data: {"task_title": task_title, "task_category": task_category, "task_amount" : task_amount},
			beforeSend: function()
			{
				//$("#error").fadeOut();
				$("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success: function (response) {
				if(response.split(':')[0].includes("Error")){
					$('#status').html('<div class = "alert alert-danger">' + response + '</div>');
				}
				else {
					$('#status').html('<div class = "alert alert-success">' + response + '</div>');
				}

			},
			complete: function()
			{
				$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create New Task');
			}
		});
	}
	//$('#task-category-register-form').reset();
	document.getElementById("task-register-form").reset();

});

//--------------------------Task Registration------------------------------------------//

//--------------------------Artisan Registration------------------------------------------//
$(document.body).on("submit", '#artisan-register-form',function(e){
	//alert("hey");
	e.preventDefault();

	var artisan_name = document.getElementById("artisan_name").value;
	var password = document.getElementById("password").value;
	var re_password = document.getElementById("re_password").value;

	if (artisan_name == '' || password == '' || re_password == '') {
		//alert('please add value');
		$('#status').html('<div class = "alert alert-info">Please fill up all the fields.</div>');
	}
	else if (password != re_password) {
		$('#status').html('<div class = "alert alert-info">Passwords didn\'t match.</div>');
	}
	else if (password.length < 6) {
		$('#status').html('<div class = "alert alert-info">Password should be at least 6 characters long.</div>');
	}
	else {
		var form_data = $('#artisan-register-form').serialize();

		$.ajax({
			type: 'POST',
			url: 'libs/php/artisan_addition.php',
			data: form_data,
			beforeSend: function()
			{
				//$("#error").fadeOut();
				$("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success: function (response) {
				if(response.split(':')[0].includes("Error")){
					$('#status').html('<div class = "alert alert-danger">' + response + '</div>');
				}
				else {
					$('#status').html('<div class = "alert alert-success">' + response + '</div>');
				}

			},
			complete: function()
			{
				$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create New Artisan');
			}
		});
	}
	//$('#task-category-register-form').reset();
	document.getElementById("artisan-register-form").reset();

});

//--------------------------Artisan Registration------------------------------------------//

//--------------------------Manager Registration------------------------------------------//
$(document.body).on("submit", '#manager-register-form',function(e){
	//alert("hey");
	e.preventDefault();

	var artisan_name = document.getElementById("manager_name").value;
	var password = document.getElementById("password").value;
	var re_password = document.getElementById("re_password").value;

	if (manager_name == '' || password == '' || re_password == '') {
		//alert('please add value');
		$('#status').html('<div class = "alert alert-info">Please fill up all the fields.</div>');
	}
	else if (password != re_password) {
		$('#status').html('<div class = "alert alert-info">Passwords didn\'t match.</div>');
	}
	else if (password.length < 6) {
		$('#status').html('<div class = "alert alert-info">Password should be at least 6 characters long.</div>');
	}
	else {
		var form_data = $('#manager-register-form').serialize();

		$.ajax({
			type: 'POST',
			url: 'libs/php/manager_addition.php',
			data: form_data,
			beforeSend: function()
			{
				//$("#error").fadeOut();
				$("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success: function (response) {
				if(response.split(':')[0].includes("Error")){
					$('#status').html('<div class = "alert alert-danger">' + response + '</div>');
				}
				else {
					$('#status').html('<div class = "alert alert-success">' + response + '</div>');
				}

			},
			complete: function()
			{
				$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create New Manager');
			}
		});
	}
	//$('#task-category-register-form').reset();
	document.getElementById("manager-register-form").reset();

});
//--------------------------Manager Registration------------------------------------------//

//--------------------------Task Assignment------------------------------------------//
$(document.body).on("submit", '#assign-task-form',function(e){
	e.preventDefault();

	var task_id = document.getElementById("task_id").value;
	var task_amount = document.getElementById("task_amount").value;
	var task_assigned = document.getElementById("task_assigned").value;
	var date_assigned = document.getElementById("date_assigned").value;
	var manager_comment = document.getElementById("manager_comment").value;
	// alert(date_assigned+task_id+task_amount+task_assigned);
	var flag = 0;
	if (task_id == '' || task_amount == '' || task_assigned == '' || date_assigned == '') {
		//alert('please add value');
		$('#status').html('<div class = "alert alert-info">Please fill up all the fields.</div>');
	}
	else if (parseInt(task_id) <=0 || parseInt(task_amount) <=0 ){
		$('#status').html('<div class = "alert alert-info">Enter a positive numeric value for Task ID and/or Task Amount.</div>');
	}
	else if (isNaN(task_id) || isNaN(task_amount)) {
		$('#status').html('<div class = "alert alert-info">Enter a numeric value for Task ID and/or Task Amount.</div>');
	}
	else {
		//var form_data = $('#assign-task-form').serialize();
		// alert("everything is fine");

		$.ajax({
			type: 'POST',
			url: 'libs/php/assign_task.php',
			data: {"task_id": task_id, "task_assigned": task_assigned, "task_amount" : task_amount, "date_assigned": date_assigned, "manager_comment": manager_comment},
			beforeSend: function()
			{
				//$("#error").fadeOut();
				$("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success: function (response) {
				if(response.split(':')[0].includes("Error")){
					$('#status').html('<div class = "alert alert-danger">' + response + '</div>');
				}
				else {
					$('#status').html('<div class = "alert alert-success">' + response + '</div>');
				}

			},
			complete: function()
			{
				$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Assign Task');
			}
		});
	}

	document.getElementById("assign-task-form").reset();
});
//--------------------------Task Assignment------------------------------------------//

//--------------------------Fetching Task Data For Further Management------------------//
function fetch_manage_task_data(){
	$.ajax({
		url:"libs/php/manage_tasks.php",
		method:"POST",
		success:function(data){
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There Is NO Task Under Your Supervision</div>');
			}
			else{
				$("#insert-heading").html("<h2 align='center'>Your Managed Tasks</h2>")
				$("#insert-element").hide();
				$("#insert-element").html(data);
				$("#manage-tasks").DataTable();
				$("#insert-element").fadeIn(1000);
			}

		}
	});
}
//--------------------------Fetching Task Data For Further Management------------------//

//--------------------------Fetching Task Data For Un-assigned Tasks------------------//
function fetch_un_assigned_task_data(){
	$.ajax({
		url:"libs/php/un_assigned_tasks.php",
		method:"POST",
		success:function(data){
			if(data.split(':')[0] == "info"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-warning">There is no un-assigned task.</div>');
			}
			else{
				$("#insert-heading").html("<h2 align='center'>Un-assigned Tasks</h2>")
				$("#insert-element").hide();
				var data_add = '<div class="col-md-8 col-md-offset-2">' + data + '</div>';
				$("#insert-element").html(data_add);
				$("#un-assigned-tasks").DataTable();
				$("#insert-element").fadeIn(1000);
			}

		}
	});
}
//--------------------------Fetching Task Data For Un-assigned Tasks------------------//

//--------------------------Fetching Task Data For Un-assigned Tasks------------------//
function fetch_pending_assignments_data(){
	$.ajax({
		url:"libs/php/pending_assignments.php",
		method:"POST",
		success:function(data){
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-info">You have no pending assignment!</div>');
			}
			else{
				$("#insert-heading").html("<h2 align='center'>Pending Assignments</h2>")
				$("#insert-element").hide();
				var data_add = '<div class="col-md-8 col-md-offset-2">' + data + '</div>';
				$("#insert-element").html(data_add);
				$("#pending-assignments").DataTable();
				$("#insert-element").fadeIn(1000);
			}

		}
	});
}
//--------------------------Fetching Task Data For Un-assigned Tasks------------------//

//--------------------------Update Task Assignment When Task Is Accepted------------------------------------//
$(document.body).on( 'click', '.task-assignments-accept', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	var data=[];
	$.each($tds, function() {               // Visits every single <td> element
		data.push($(this).text());
	});
	console.log(data[0]);
	$.ajax({
		method: 'post',
		url: 'libs/php/task_assignments_accept.php',
		data: {
			task_assignment_id: data[0]
		},
		success: function( data ) {
			// console.log(data);
			//fetch_pending_assignments_data();
			$("#insert-modal").html(data);
			$('#myModal').modal('show');
			fetch_pending_assignments_data();
		}
	});

});
//--------------------------Update Task Assignment When Task Is Accepted------------------------------------//

//--------------------------Fetching Task Data For Un-assigned Tasks------------------//
function fetch_ongoing_assignments_data(){
	$.ajax({
		url:"libs/php/ongoing_assignments.php",
		method:"POST",
		success:function(data){
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error!</div>');
			}
			if(data.split(':')[0] == "info"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-info">There is no ongoing assignment.</div>');
			}
			else{
				$("#insert-heading").html("<h2 align='center'>Ongoing Assignments</h2>")
				$("#insert-element").hide();
				var data_add = '<div class="col-md-8 col-md-offset-2">' + data + '</div>';
				$("#insert-element").html(data_add);
				$("#ongoing-assignments").DataTable();
				$("#insert-element").fadeIn(1000);
			}

		}
	});
}
//--------------------------Fetching Task Data For Un-assigned Tasks------------------//

//--------------------------Update Task Amount For Ongoing Tasks On Addition------------------//
$(document.body).on( 'click', '.add-task-done-quantity', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var row_index = $(this).parent().parent().parent().index();

	var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	var data=[];
	$.each($tds, function() {               // Visits every single <td> element
		data.push($(this).text());
	});
	// alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/task_assignments_add_quanity.php',
		data: {
			task_assignment_id: data[0],
			done_quantity: data[5],
			assigned_quantity: data[4]
		},
		success: function( data ) {
			if (data == -2){
				$("#ongoing-assignments").dataTable().fnUpdate('<p align="center"><span class="label label-success">Done!<span style="display:inline-block; width: 8px;"></span><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></span><p>', row_index, 5);
			}
			else{
				var cell_val = `<td>` + data + `<span style="display:inline-block; width: 5px;"></span>
				<div class="btn-group btn-group-xs" role="group" style="float:right;">
				<button type="button" class="btn btn-default add-task-done-quantity"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
				<button type="button" class="btn btn-default remove-task-done-quantity"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
				</div>`;
				$("#ongoing-assignments").dataTable().fnUpdate(cell_val, row_index, 5);
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Update Task Amount For Ongoing Tasks On Addition------------------//

//--------------------------Update Task Amount For Ongoing Tasks On Rmoval------------------//
$(document.body).on( 'click', '.remove-task-done-quantity', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	// alert( $(this).parent().rowIndex );
	var row_index = $(this).parent().parent().parent().index();
	// alert(row_index);

	// var rowIndex = $(this.closest("tr").index());
	var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	var data=[];
	// var row_index = $(this).parent().index();
	// var col_index = $(this).index();
	$.each($tds, function() {               // Visits every single <td> element
		data.push($(this).text());
	});
	// alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/task_assignments_remove_quanity.php',
		data: {
			task_assignment_id: data[0],
			done_quantity: data[5]
		},
		success: function( data ) {
			// console.log(data);
			//fetch_pending_assignments_data();
			// $("#insert-modal").html(data);
			// $('#myModal').modal('show');
			//oTable.fnUpdate( 'Example update', 0, 0 ); // Single cell
			var cell_val = `<td>` + data + `<span style="display:inline-block; width: 5px;"></span>
			<div class="btn-group btn-group-xs" role="group" style="float:right;">
			<button type="button" class="btn btn-default add-task-done-quantity"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
			<button type="button" class="btn btn-default remove-task-done-quantity"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
			</div>`;
			$("#ongoing-assignments").dataTable().fnUpdate(cell_val, row_index, 5);
			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row
			// 					fetch_ongoing_assignments_data();
		}
	});

});
//--------------------------Update Task Amount For Ongoing Tasks On Removal------------------//

//--------------------------Fetching Task Data For Completed Assignments------------------//
function fetch_completed_assignments_data(){
	$.ajax({
		url:"libs/php/completed_assignments.php",
		method:"POST",
		success:function(data){
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error!</div>');
			}
			if(data.split(':')[0] == "info"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-info">There is no assignment to manage.</div>');
			}
			else{
				$("#insert-heading").html("<h2 align='center'>Manage Completed Assignments</h2>")
				$("#insert-element").hide();
				var data_add = '<div class="col-md-10 col-md-offset-1">' + data + '</div>';
				$("#insert-element").html(data_add);
				$("#completed-assignments").DataTable();
				$("#insert-element").fadeIn(1000);
			}

		}
	});
}
//--------------------------Fetching Task Data For Completed Assignments------------------//

//--------------------------Update Completed Tasks On Action Complete------------------//
$(document.body).on( 'click', '.status-task-complete', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var row_index = $(this).parent().parent().parent().index();
	// alert(row_index);
	var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	var data=[];
	$.each($tds, function() {               // Visits every single <td> element
		data.push($(this).text());
	});
	var artisan_comment = $('#artisan_comment').val();
	// alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/mark_task_completed.php',
		data: {
			task_assignment_id: data[0],
			artisan_comment: artisan_comment,
			assigned_quantity: data[4]
		},
		success: function( data ) {
			if (data == "Success"){
				fetch_completed_assignments_data();
			}
			else{
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-info">There was an error!</div>');
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Update Completed Tasks On Action Complete------------------//

//--------------------------Update Task Amount For Completed Tasks On Action Incomplete------------------//
$(document.body).on( 'click', '.status-task-incomplete', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var row_index = $(this).parent().parent().parent().index();
	// alert(row_index);
	var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	var data=[];
	$.each($tds, function() {               // Visits every single <td> element
		data.push($(this).text());
	});
	// alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/mark_task_incomplete.php',
		data: {
			task_assignment_id: data[0],
			done_quantity: data[5],
			assigned_quantity: data[4]
		},
		success: function( data ) {
			if (data.split(':')[0] == "Success"){
				fetch_completed_assignments_data();
			}
			else{
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-info">There was an error!</div>');
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Update Task Amount For Completed Tasks On Action Incomplete------------------//

//--------------------------Fetching Overview Of Task Data------------------//
function fetch_all_task_data(){
	$.ajax({
		url:"libs/php/tasks_overview.php",
		method:"POST",
		success:function(data){
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error fetching the data!</div>');
			}
			else{
				$("#insert-heading").html("<h2 align='center'>Task Overview</h2>")
				$("#insert-element").hide();
				$("#insert-element").html(data);
				$("#task-overview").DataTable();
				$("#insert-element").fadeIn(1000);
			}

		}
	});
}
//--------------------------Fetching Overview Of Task Data------------------//

//--------------------------Fetching And Rendering Employee List------------------//
function fetch_employee_list_data(){
	$.ajax({
		url:"libs/php/employee_list.php",
		method:"POST",
		success:function(data){
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error fetching the data!</div>');
			}
			else{
				$("#insert-heading").html("<h2 align='center'>Artisans</h2>")
				$("#insert-element").hide();
				$("#insert-element").html(data);
				// $("#task-overview").DataTable();
				$("#insert-element").fadeIn(1000);
			}

		}
	});
}
//--------------------------Fetching And Rendering Employee List------------------//

//--------------------------Render Artisan Weekly Report------------------//
$(document.body).on( 'click', '.artisan-weekly-report', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var employee_name = $(this).parent().parent().text().split('\n')[0];
	// console.log(employee_name);
	// var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	// var data=[];
	// $.each($tds, function() {               // Visits every single <td> element
	// 	data.push($(this).text());
	// });
	// // alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/employee_task_report.php',
		data: {
			employee: employee_name,
			period: 'w'
		},
		success: function( data ) {
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error fetching the data!</div>');
			}
			else{
				$("#insert-heading").html("<h2 align='center'>Weekly Task Report Of " + employee_name + "</h2>" + "<div class='row text-center' style='margin-bottom:15px; margin-top: 15px;'><button type='button' class='btn btn-primary artisan-report'>Download Weekly Report of " + employee_name + "</button></div>");
				$("#insert-element").hide();
				data = '<div class= "col-md-6 col-md-offset-3">' + data + '</div>';
				$("#insert-element").html(data);
				$("#task-report").DataTable();
				$("#insert-element").fadeIn(1000);
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Render Artisan Weekly Report------------------//

//--------------------------Render Artisan Monthly Report------------------//
$(document.body).on( 'click', '.artisan-monthly-report', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var employee_name = $(this).parent().parent().text().split('\n')[0];
	// console.log(employee_name);
	// var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	// var data=[];
	// $.each($tds, function() {               // Visits every single <td> element
	// 	data.push($(this).text());
	// });
	// // alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/employee_task_report.php',
		data: {
			employee: employee_name,
			period: 'm'
		},
		success: function( data ) {
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error fetching the data!</div>');
			}
			else{
				$("#insert-heading").html("<h2 align='center'>Monthly Task Report Of " + employee_name + "</h2>" + "<div class='row text-center' style='margin-bottom:15px; margin-top: 15px;'><button type='button' class='btn btn-primary artisan-report'>Download Monthly Report of " + employee_name + "</button></div>");
				$("#insert-element").hide();
				data = '<div class= "col-md-6 col-md-offset-3">' + data + '</div>';
				$("#insert-element").html(data);
				$("#task-report").DataTable();
				$("#insert-element").fadeIn(1000);
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Render Artisan Monthly Report------------------//

//--------------------------Render Artisan Yearly Report------------------//
$(document.body).on( 'click', '.artisan-yearly-report', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var employee_name = $(this).parent().parent().text().split('\n')[0];
	// console.log(employee_name);
	// var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	// var data=[];
	// $.each($tds, function() {               // Visits every single <td> element
	// 	data.push($(this).text());
	// });
	// // alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/employee_task_report.php',
		data: {
			employee: employee_name,
			period: 'y'
		},
		success: function( data ) {
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error fetching the data!</div>');
			}
			else{
				$("#insert-heading").html("<h2 align='center'>Yearly Task Report Of " + employee_name + "</h2>" + "<div class='row text-center' style='margin-bottom:15px; margin-top: 15px;'><button type='button' class='btn btn-primary artisan-report'>Download Yearly Report of " + employee_name + "</button></div>");
				$("#insert-element").hide();
				data = '<div class= "col-md-6 col-md-offset-3">' + data + '</div>';
				$("#insert-element").html(data);
				$("#task-report").DataTable();
				$("#insert-element").fadeIn(1000);
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Render Artisan Yearly Report------------------//

//--------------------------Change Password------------------------------------------//
$(document.body).on("submit", '#change-password-form',function(e){
	//alert("hey");
	e.preventDefault();

	// var old_password = document.getElementById("old_password").value;
	var new_password = document.getElementById("new_password").value;
	var confirm_password = document.getElementById("confirm_password").value;

	if (new_password.length < 6){
		$('#status').html('<div class = "alert alert-info">Password should be atleast 6 characters long.</div>');
	}
	else if (confirm_password == '' || new_password == '') {
		//alert('please add value');
		$('#status').html('<div class = "alert alert-info">Please fill up all the fields.</div>');
	}
	else if (new_password != confirm_password){
		$('#status').html('<div class = "alert alert-info">New and confirm passwords do not match.</div>');
	}
	else {
		var form_data = $('#change-password-form').serialize();

		$.ajax({
			type: 'POST',
			url: 'libs/php/change_password.php',
			data: form_data,
			beforeSend: function()
			{
				//$("#error").fadeOut();
				$("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success: function (response) {
				if(response.split(':')[0].includes("Error")){
					$('#status').html('<div class = "alert alert-danger">' + response + '</div>');
				}
				else {
					$('#status').html('<div class = "alert alert-success">' + response + '</div>');
				}

			},
			complete: function()
			{
				$("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Change Password');
			}
		});
	}
	//$('#task-category-register-form').reset();
	document.getElementById("task-category-register-form").reset();

});
//--------------------------Change Password------------------------------------------//

//--------------------------Download Artisan Report----------------------------------//
$(document.body).on( 'click', '.artisan-report', function (e){
	e.preventDefault();
		var data = $(this).text();
		var time_period = data.split(' ')[1];
		var employee_name = data.split(' ')[4];
		var filename = time_period + " report of " + employee_name;
	$("#task-report").tableToCSV(filename);

	// $('<table style="width:100%"><tr><th>Firstname</th><th>Lastname</th> <th>Age</th></tr><tr><td>Jill</td><td>Smith</td> <td>50</td></tr><tr><td>Eve</td><td>Jackson</td> <td>94</td></tr></table>').tableToCSV(filename);



// 	var data = $(this).text();
// 	var time_period = data.split(' ')[1];
// 	var employee_name = data.split(' ')[4];
// 	//alert(employee_name);
// 	$.ajax({
// 		type: 'POST',
// 		url: 'libs/php/download_artisan_report.php',
// 		data: {
// 			employee: employee_name,
// 			period: time_period
// 		},
// 		success: function (response) {
// 			// if(response.split(':')[0].includes("Error")){
// 			// 	$('#status').html('<div class = "alert alert-danger">' + response + '</div>');
// 			// }
// 			// else {
// 			// 	$('#status').html('<div class = "alert alert-success">' + response + '</div>');
// 			// }
// 			console.log(response);
// 		}
// 	});
// // }

});
//--------------------------Download Artisan Report----------------------------------//

//--------------------------Render Artisans Weekly Total Report------------------//
$(document.body).on( 'click', '.artisan-total-weekly-report', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var employee_name = $(this).parent().parent().text().split('\n')[0];
	// console.log(employee_name);
	// var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	// var data=[];
	// $.each($tds, function() {               // Visits every single <td> element
	// 	data.push($(this).text());
	// });
	// // alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/all_employee_task_report.php',
		data: {
			period: 'w'
		},
		success: function( data ) {
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error fetching the data!</div>');
			}
			else{
				// $("#insert-heading").html("<h2 align='center'>Weekly Task Report Of " + employee_name + "</h2>" + "<div class='row text-center' style='margin-bottom:15px; margin-top: 15px;'><button type='button' class='btn btn-primary artisan-report'>Download Weekly Report of " + employee_name + "</button></div>");
				// $("#insert-element").hide();
				// data = '<div class= "col-md-6 col-md-offset-3">' + data + '</div>';
				// $("#insert-element").html(data);
				// $("#task-report").DataTable();
				// $("#insert-element").fadeIn(1000);
				// console.log(data);
				$(data).tableToCSV("Weekly Report");
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Render Artisans Weekly Total Report------------------//

//--------------------------Render Artisans Monthly Total Report------------------//
$(document.body).on( 'click', '.artisan-total-monthly-report', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var employee_name = $(this).parent().parent().text().split('\n')[0];
	// console.log(employee_name);
	// var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	// var data=[];
	// $.each($tds, function() {               // Visits every single <td> element
	// 	data.push($(this).text());
	// });
	// // alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/all_employee_task_report.php',
		data: {
			period: 'm'
		},
		success: function( data ) {
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error fetching the data!</div>');
			}
			else{
				// $("#insert-heading").html("<h2 align='center'>Weekly Task Report Of " + employee_name + "</h2>" + "<div class='row text-center' style='margin-bottom:15px; margin-top: 15px;'><button type='button' class='btn btn-primary artisan-report'>Download Weekly Report of " + employee_name + "</button></div>");
				// $("#insert-element").hide();
				// data = '<div class= "col-md-6 col-md-offset-3">' + data + '</div>';
				// $("#insert-element").html(data);
				// $("#task-report").DataTable();
				// $("#insert-element").fadeIn(1000);
				// console.log(data);
				$(data).tableToCSV("Monthly Report");
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Render Artisans Monthly Total Report------------------//

//--------------------------Render Artisans Yearly Total Report------------------//
$(document.body).on( 'click', '.artisan-total-yearly-report', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var employee_name = $(this).parent().parent().text().split('\n')[0];
	// console.log(employee_name);
	// var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	// var data=[];
	// $.each($tds, function() {               // Visits every single <td> element
	// 	data.push($(this).text());
	// });
	// // alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/all_employee_task_report.php',
		data: {
			period: 'y'
		},
		success: function( data ) {
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error fetching the data!</div>');
			}
			else{
				// $("#insert-heading").html("<h2 align='center'>Weekly Task Report Of " + employee_name + "</h2>" + "<div class='row text-center' style='margin-bottom:15px; margin-top: 15px;'><button type='button' class='btn btn-primary artisan-report'>Download Weekly Report of " + employee_name + "</button></div>");
				// $("#insert-element").hide();
				// data = '<div class= "col-md-6 col-md-offset-3">' + data + '</div>';
				// $("#insert-element").html(data);
				// $("#task-report").DataTable();
				// $("#insert-element").fadeIn(1000);
				// console.log(data);
				$(data).tableToCSV("Yearly Report");
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Render Artisans Yearly Total Report (Hours)------------------//

//--------------------------Render Artisans Weekly Total Report------------------//
$(document.body).on( 'click', '.artisan-total-weekly-report-hour', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var employee_name = $(this).parent().parent().text().split('\n')[0];
	// console.log(employee_name);
	// var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	// var data=[];
	// $.each($tds, function() {               // Visits every single <td> element
	// 	data.push($(this).text());
	// });
	// // alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/all_employee_task_report_hour.php',
		data: {
			period: 'w'
		},
		success: function( data ) {
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error fetching the data!</div>');
			}
			else{
				// $("#insert-heading").html("<h2 align='center'>Weekly Task Report Of " + employee_name + "</h2>" + "<div class='row text-center' style='margin-bottom:15px; margin-top: 15px;'><button type='button' class='btn btn-primary artisan-report'>Download Weekly Report of " + employee_name + "</button></div>");
				// $("#insert-element").hide();
				// data = '<div class= "col-md-6 col-md-offset-3">' + data + '</div>';
				// $("#insert-element").html(data);
				// $("#task-report").DataTable();
				// $("#insert-element").fadeIn(1000);
				// console.log(data);
				$(data).tableToCSV("Weekly Report");
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Render Artisans Weekly Total Report (Hours)------------------//

//--------------------------Render Artisans Monthly Total Report------------------//
$(document.body).on( 'click', '.artisan-total-monthly-report-hour', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var employee_name = $(this).parent().parent().text().split('\n')[0];
	// console.log(employee_name);
	// var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	// var data=[];
	// $.each($tds, function() {               // Visits every single <td> element
	// 	data.push($(this).text());
	// });
	// // alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/all_employee_task_report_hour.php',
		data: {
			period: 'm'
		},
		success: function( data ) {
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error fetching the data!</div>');
			}
			else{
				// $("#insert-heading").html("<h2 align='center'>Weekly Task Report Of " + employee_name + "</h2>" + "<div class='row text-center' style='margin-bottom:15px; margin-top: 15px;'><button type='button' class='btn btn-primary artisan-report'>Download Weekly Report of " + employee_name + "</button></div>");
				// $("#insert-element").hide();
				// data = '<div class= "col-md-6 col-md-offset-3">' + data + '</div>';
				// $("#insert-element").html(data);
				// $("#task-report").DataTable();
				// $("#insert-element").fadeIn(1000);
				// console.log(data);
				$(data).tableToCSV("Monthly Report");
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Render Artisans Monthly Total Report (Hours)------------------//

//--------------------------Render Artisans Yearly Total Report (Hours)------------------//
$(document.body).on( 'click', '.artisan-total-yearly-report-hour', function () {
	// 	var $row = $(this).closest("tr");
	// console.log($row);
	var employee_name = $(this).parent().parent().text().split('\n')[0];
	// console.log(employee_name);
	// var $tds = $(this).closest("tr").find("td");             // Finds all children <td> elements
	// var data=[];
	// $.each($tds, function() {               // Visits every single <td> element
	// 	data.push($(this).text());
	// });
	// // alert(data);
	$.ajax({
		method: 'post',
		url: 'libs/php/all_employee_task_report_hour.php',
		data: {
			period: 'y'
		},
		success: function( data ) {
			if(data.split(':')[0] == "Error"){
				$("#insert-element").hide();
				$("#insert-heading").html('<div class = "alert alert-danger">There was an error fetching the data!</div>');
			}
			else{
				// $("#insert-heading").html("<h2 align='center'>Weekly Task Report Of " + employee_name + "</h2>" + "<div class='row text-center' style='margin-bottom:15px; margin-top: 15px;'><button type='button' class='btn btn-primary artisan-report'>Download Weekly Report of " + employee_name + "</button></div>");
				// $("#insert-element").hide();
				// data = '<div class= "col-md-6 col-md-offset-3">' + data + '</div>';
				// $("#insert-element").html(data);
				// $("#task-report").DataTable();
				// $("#insert-element").fadeIn(1000);
				// console.log(data);
				$(data).tableToCSV("Yearly Report");
			}

			// $('#example').dataTable().fnUpdate('Zebra' , $('tr#3692')[0], 1 );
			// oTable.fnUpdate( ['a', 'b', 'c', 'd', 'e'], 1 ); // Row

		}
	});

});
//--------------------------Render Artisans Yearly Total Report (Hours)------------------//
