<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>View All Jobs- Lims</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

<?php include('partial/head.php'); ?>
</head>
<body>
	<div class="wrapper">
	    <?php include('partial/sidebar.php') ?>

	    <div class="main-panel">
			<?php include('partial/nav.php') ?>

	        <div class="container-fluid ">
          <div class="col-lg-4 col-md-6 col-sm-6 mt-3">
            <a href="<?php echo base_url();?>admin/addJob" class="btn btn-outline-danger login_btn btn-wd">Add New Job</a>

            <a href="<?php echo base_url();?>admin/ChooseExistingPatient" class="btn btn-outline-danger login_btn btn-wd">Add <?php if($this->agent->is_mobile()){ }else{ echo 'From'; }?> Existing Job</a>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 mt-3">
          </div>
          <div class=""></div>
          <div class="col-lg-4 col-md-6 col-sm-6 mt-3">
            <div class="pull-right">
                <form>
                 <div class="dropdown">
                      <button href="#" class="btn btn-block dropdown-toggle btn-wd ButtonText" data-toggle="dropdown" aria-expanded="false">
                          Filter
                          <b class="caret"></b>
                      </button>
                     <ul class="dropdown-menu">
                        <li class="AllIcon"><a href="#">All</a></li>
                        <li class="CompletedIcon"><a href="#">Completed</a></li>
                        <li class="AwaitingIcon"><a href="#">Awaiting Acceptance</a></li>
                        <li class="AcceptedIcon"><a href="#">Accepted</a></li>
                        <li class="UnassignedIcon"><a href="#">Unassigned</a></li>
                      </ul>
                </div>
              </form>
            </div>
          </div>
        </div>

            <div class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class=""></div>
                        <div class="card">
                                <div class="card-content ">
                                    <span class="text-theme  bootstrap-table">Urgent Cases</span>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table2" class="table-striped mytable urgent">
                                        <thead>
                                            <th data-field="actions" class="td-actions " >Actions</th>
                                            <th data-field="id" data-sortable="true">Case ref</th>
                                            <th data-field="name" data-sortable="true">Patient name</th>
                                            <th data-field="Status" data-sortable="true">Status</th>
                                            <th data-field="salary" data-sortable="true">Date created</th>
                                             <th data-field="doctor" data-sortable="true">Doctor name</th>
                                            <th data-field="clinic" data-sortable="true">Referring clinic</th>
                                        </thead>
                                        <tbody>
                                        <?php foreach($UrgentsJobs as $key => $job){   $number = $key; ?>
                                            <tr id="<?php echo $job->test_primary_id ?>" <?php if(($number % 2) == 0){ ?> class="danger"  <?php }?>>
                                                <td>
                                                    <div class="dropdown action-box">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu action-menu">
                                                         <?php if(empty($job->invoicealreadySend)){
                                                                if(!empty($job->sentinvoice)){  ?>
                                                                <li>
                                                                    <a class="sendInvoice" value="<?php echo $job->test_primary_id ?>"  href="javascript:;" > Send invoice </a>
                                                                </li>
                                                           <?php } } ?>

                                                           <?php if(!empty($job->invoicealreadySend)){ ?>
                                                                <li>
                                                                    <a target="blank" href="<?php echo base_url();?>doctor/GetInvoiceDownload/<?php echo $job->test_primary_id ?>" > View invoice </a>
                                                                </li>
                                                           <?php } ?>

                                                           <?php if($job->report == 'Available' && $job->authorised != 1){ ?>
                                                                    <li>
                                                                        <a href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_primary_id ?>" value="<?php echo $job->test_primary_id ?>" > View Report Status
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>

                                                            <?php if($job->authorised == 1){ ?>
                                                                <li>
                                                                    <a target="blank" href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_primary_id ?>" > View Report </a>
                                                                </li>
                                                           <?php } ?>
                                                                <li>
                                                                    <a href="javascript:;" class="RemovetoUrgent" value="<?php echo $job->test_primary_id ?>"> Remove Urgent </a>
                                                                </li>
                                                                <?php if($job->authorised != 1){ ?> <li>
                                                             <a href="<?php echo base_url();?>admin/EditJob/<?php echo $job->test_primary_id ?>" value="<?php echo $job->test_primary_id ?>" > Edit Job </a>
                                                           </li> <?php } ?>
                                                          <?php if($job->authorised == 1){ ?>
                                                              <li>
                                                                <a href="javascript:;" class="AddtoArchive" value="<?php echo $job->test_primary_id ?>" > Move to Archive </a>
                                                              </li>
                                                          <?php } ?>
                                                         </ul>
                                                    </div>
                                                 </td>
                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a class="profile_link" href="<?php echo base_url()?>user/PatientDetails/<?php echo $job->patient_primary_id ?>"> 
                                                    <?php echo $job->patient_name." ".$job->last_name; ?> </a>
                                                    <br /><small> DOB: <?php $date=date_create($job->DateOfBirth); echo date_format($date,$dateFormat); ?></td>
                                                <td class="assigndoctor<?php echo $job->test_primary_id; ?>">
                                                    <?php $alreadyassign = $job->test_doctor_report;  ?>
                                                      <?php if($job->authorised == 1){
                                                             echo "<strong class='text-success'>Completed</strong>";
                                                      }elseif(empty($alreadyassign)){
                                                        echo "<strong>Unassigned</strong>" ;
                                                      }elseif(in_array('1', array_column($alreadyassign, 'status'))) { // search value in the array
                                                             echo "<strong>Accepted</strong>" ;
                                                      }elseif(in_array('0', array_column($alreadyassign, 'status'))) { // search value in the array
                                                             echo "<strong class='text-danger'>Awaiting Acceptance</strong>" ;
                                                      } ?>
                                                        <br />
                                                        <small>
                                                            <?php if($job->box_received == 1){
                                                                echo "(Slides Received)";
                                                            }else{
                                                                echo "(Not Delivered)";
                                                            } ?>
                                                        </small>
                                                 </td>
                                                <td><?php $date=date_create($job->test_date); echo date_format($date,$dateFormat); ?></td>
                                                 <td class="assigntext<?php echo $job->test_primary_id ?>">
                                                    <?php if($job->authorised != 1){ ?>
                                                    <select class="assigndoctor">
                                                      <option>Select Doctor</option>
                                                      <?php foreach($doctors as $doctor){ 
                                                         $disable = '';
                                                         if(in_array($doctor->doctor_id, array_column($alreadyassign, 'doctor_id'))) { // search value in the array
                                                              $disable = "disabled";
                                                          }
                                                       ?>
                                                        <option <?php echo $disable;?> value="<?php echo $doctor->doctor_id?>|<?php echo $job->test_primary_id; ?>"><?php echo 'Dr. '.$doctor->doctor_name ?></option>
                                                      <?php  } ?>
                                                    </select> <br />
                                                    <?php  foreach($alreadyassign as $assigndoctors){ 
                                                          if($assigndoctors['status'] == 1){ ?>
                                                            <a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo $assigndoctors['doctor_id']?>">
                                                              <?php echo 'Dr. '.$assigndoctors['doctor_name'];?> </a><br />
                                                    <?php  }
                                                        }
                                                  }else{
                                                        foreach($doctors as $doctor){ 
                                                            if($job->doctor_id == $doctor->doctor_id ){
                                                                ?> 
                                                              <a class="profile_link" href="<?php echo base_url()?>doctor/DoctorDetails/<?php echo $job->doctor_id ?>">
                                                                    <?php echo 'Dr. '.$doctor->doctor_name ?> 
                                                               </a>
                                                               <?php
                                                            }
                                                        }
                                                        } ?>
                                                 </td>
                                                <td><a class="profile_link" href="<?php echo base_url()?>hospital/HospitalDetails/<?php echo $job->hospital_id ?>">
                                                    <?php foreach($hospitals as $hospital){
                                                                if($hospital->hospital_id == $job->hospital_id ){
                                                                    echo $hospital->hospital_name;
                                                                }
                                                            }
                                                     ?> </a>
                                                 </td>
                                            </tr>
                                            <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                           <div class="card">
                                <div class="card-content">
                                    <span class="text-theme  bootstrap-table">Routine Cases</span>
                                    <div class="toolbar">
                                    </div>
                                    <table id="bootstrap-table" class="table-striped mytable">
                                       <thead>
                                            <th data-field="actions" class="td-actions" >Actions</th>
                                            <th data-field="id" data-sortable="true">Case ref</th>
                                            <th data-field="name" data-sortable="true">Patient name </th>
                                            <th data-field="Status" data-sortable="true">Status</th>
                                            <th data-field="salary" data-sortable="true">Date created</th>
                                             <th data-field="doctor" data-sortable="true">Doctor name</th>
                                            <th data-field="clinic" data-sortable="true">Referring clinic</th>

                                        </thead>
                                        <tbody>
                                        <?php foreach($jobDetails as $key => $job){ //print_r($job);
                                         $number = $key;
                                          ?>
                                            <tr id="<?php echo $job->test_primary_id ?>" <?php if(($number % 2) == 0){ ?> class=""  <?php  }?>>
                                                <td>
                                                    <div class="dropdown action-box">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu action-menu">
                                                         <?php if(empty($job->invoicealreadySend)){
                                                                if(!empty($job->sentinvoice)){
                                                            ?>  
                                                                <li><a class="sendInvoice" value="<?php echo $job->test_primary_id ?>"  href="javascript:;" > Send invoice </a>
                                                                </li>
                                                           <?php } } ?>
                                                           <?php if(!empty($job->invoicealreadySend)){ ?>
                                                                <li>
                                                                    <a target="blank" href="<?php echo base_url();?>doctor/GetInvoiceDownload/<?php echo $job->test_primary_id ?>" > View invoice </a>
                                                                </li>
                                                           <?php } ?>
                                                           <?php if($job->report == 'Available' && $job->authorised != 1){ ?>
                                                                    <li>
                                                                        <a href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_primary_id ?>" value="<?php echo $job->test_primary_id ?>" > View Report Status
                                                                        </a>
                                                                    </li>
                                                                <?php }?>
                                                            <?php if($job->authorised == 1){ ?>
                                                                <li>
                                                                    <a target="blank" href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_primary_id ?>" > View Report </a>
                                                                </li>
                                                           <?php } ?>
                                                           <li>
                                                             <a href="javascript:;" class="AddtoUrgent" value="<?php echo $job->test_primary_id  ?>" > Make Urgent </a>
                                                           </li>
                                                           <?php if($job->authorised != 1){ ?> <li>
                                                             <a href="<?php echo base_url();?>admin/EditJob/<?php echo $job->test_primary_id ?>" value="<?php echo $job->test_primary_id ?>" > Edit Job </a>
                                                           </li> <?php } ?>
                                                           <?php if($job->authorised == 1){ ?>
                                                            <li>
                                                                    <a href="javascript:;" class="AddtoArchive" value="<?php echo $job->test_primary_id ?>" > Move to Archive </a>
                                                                </li>
                                                            <?php } ?>
                                                          </ul>
                                                    </div>
                                                 </td>
                                                 <td><?php echo $job->Client_case_number; ?></td>
                                                <td><a class="profile_link" href="<?php echo base_url()?>user/PatientDetails/<?php echo $job->patient_primary_id ?>"> <?php echo $job->patient_name." ".$job->last_name; ?> </a>  <br /><small> DOB: <?php $date=date_create($job->DateOfBirth); echo date_format($date,$dateFormat); ?></td>
                                                  <td class="assigndoctor<?php echo $job->test_primary_id ?>">
                                                     <?php 
                                                        $alreadyassign = $job->test_doctor_report;
                                                      ?>
                                                      <?php if($job->authorised == 1){
                                                             echo "<strong class='text-success'>Completed</strong>";
                                                      }elseif(empty($alreadyassign)){
                                                        echo "<strong>Unassigned</strong>" ;
                                                      }elseif(in_array('1', array_column($alreadyassign, 'status'))) { // search value in the array
                                                             echo "<strong>Accepted</strong>" ;
                                                      }elseif(in_array('0', array_column($alreadyassign, 'status'))) { // search value in the array
                                                             echo "<strong class='text-danger'>Awaiting Acceptance</strong>" ;
                                                      }?>
                                                  <br />
                                                        <small>
                                                            <?php if($job->box_received == 1){
                                                                echo "(Slides Received)";
                                                            }else{
                                                                echo "(Not Delivered)";
                                                            }?>
                                                        </small>
                                                 </td>
                                                <td><?php $date=date_create($job->test_date); echo date_format($date,$dateFormat); ?></td>
                                                 <td class="assigntext<?php echo $job->test_primary_id ?>">
                                                    <?php if($job->authorised != 1){ ?>
                                                    <select class="assigndoctor">
                                                      <option>Select Doctor</option>
                                                      <?php foreach($doctors as $doctor){
                                                        $disable = '';
                                                         if(in_array($doctor->doctor_id, array_column($alreadyassign, 'doctor_id'))) { // search value in the array
                                                              $disable = "disabled";
                                                          }
                                                       ?>
                                                        <option <?php echo $disable?> value="<?php echo $doctor->doctor_id?>|<?php echo $job->test_primary_id ?>"><?php echo 'Dr. '.$doctor->doctor_name ?></option>
                                                      <?php  }?>
                                                    </select><br />
                                                    <?php   foreach($alreadyassign as $assigndoctors){ 
                                                          if($assigndoctors['status'] == 1){ ?>
                                                             <a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo $assigndoctors['doctor_id']?>"><?php echo 'Dr. '.$assigndoctors['doctor_name'];?> </a><br /> 
                                                    <?php  }
                                                        }   }else{
                                                        foreach($doctors as $doctor){ 
                                                            if($job->doctor_id == $doctor->doctor_id ){
                                                                ?> 
                                                              <a class="profile_link" href="<?php echo base_url()?>doctor/DoctorDetails/<?php echo $job->doctor_id ?>">
                                                                    <?php echo 'Dr. '.$doctor->doctor_name ?> 
                                                               </a>
                                                               <?php
                                                            }
                                                        }
                                                        }?>
                                                 </td>
                                                <td> <a class="profile_link" href="<?php echo base_url()?>hospital/HospitalDetails/<?php echo $job->hospital_id ?>">
                                                    <?php foreach($hospitals as $hospital){
                                                                if($hospital->hospital_id == $job->hospital_id ){
                                                                    echo $hospital->hospital_name;
                                                                }
                                                            }
                                                     ?> </a>
                                                 </td>
                                            </tr>
                                            <?php  }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="<?php echo base_url();?>archive" class="btn btn-outline-danger btn-theme mb-5 btn-wd">Go to Archive</a>

                             <a href="<?php echo base_url();?>admin/allJobsexport" class="btn btn-outline-danger btn-theme mb-5 btn-wd">Export CSV</a>
                        </div> <!-- end col-md-12 -->
                    </div> <!-- end row -->
                </div>
            </div>
           <?php include('partial/footer.php') ?>
	    </div>
	</div>
</body>

	<?php include('partial/footerscript.php') ?>

	<script type="text/javascript">
    	$(document).ready(function(){
			//demo.initOverviewDashboard();
			//demo.initCirclePercentage();

    	});

      $(".dropdown-menu a").click(function(){
  var $table = $('.mytable');
  var selectedText = $(this).text();
  if(selectedText == "All"){ selectedText = "";}
  $table.bootstrapTable('refreshOptions', {searchText:selectedText});

   if(selectedText == ""){ selectedText = "All"}
    
    $('.ButtonText').html(selectedText+' <b class="caret"></b>');

    if(selectedText == "All"){ $('.AllIcon').addClass('active') }else{ $('.AllIcon').removeClass('active') }
    if(selectedText == "Completed"){ $('.CompletedIcon').addClass('active') }else{ $('.CompletedIcon').removeClass('active') }
    if(selectedText == "Awaiting Acceptance"){ $('.AwaitingIcon').addClass('active') }else{ $('.AwaitingIcon').removeClass('active') }
    if(selectedText == "Accepted"){ $('.AcceptedIcon').addClass('active') }else{ $('.AcceptedIcon').removeClass('active') }
    if(selectedText == "Unassigned"){ $('.UnassignedIcon').addClass('active') }else{ $('.UnassignedIcon').removeClass('active') }
});

        var $table = $('.mytable');

            function operateFormatter(value, row, index) {
                return [
                    '<div class="table-icons">',
                        '<a rel="tooltip" title="View" class="btn btn-simple btn-info btn-icon table-action view" href="javascript:void(0)">',
                            '<i class="ti-image"></i>',
                        '</a>',
                        '<a rel="tooltip" title="Edit" class="btn btn-simple btn-warning btn-icon table-action edit" href="javascript:void(0)">',
                            '<i class="ti-pencil-alt"></i>',
                        '</a>',
                        '<a rel="tooltip" title="Remove" class="btn btn-simple btn-danger btn-icon table-action remove" href="javascript:void(0)">',
                            '<i class="ti-close"></i>',
                        '</a>',
                    '</div>',
                ].join('');
            }

            $().ready(function(){
                window.operateEvents = {
                    'click .view': function (e, value, row, index) {
                        info = JSON.stringify(row);

                        swal('You click view icon, row: ', info);
                        console.log(info);
                    },
                    'click .edit': function (e, value, row, index) {
                        info = JSON.stringify(row);

                        swal('You click edit icon, row: ', info);
                        console.log(info);
                    },
                    'click .remove': function (e, value, row, index) {
                        console.log(row);
                        $table.bootstrapTable('remove', {
                            field: 'id',
                            values: [row.id]
                        });
                    }
                };

                $table.bootstrapTable({
                    toolbar: ".toolbar",
                    clickToSelect: true,
                    showRefresh: false,
                    search: true,
                    showToggle: true,
                    showColumns: true,
                    pagination: true,
                    searchAlign: 'left',
                    pageSize: 8,
                    clickToSelect: true,
                    pageList: [8,10,25,50,100],

                    formatShowingRows: function(pageFrom, pageTo, totalRows){
                        //do nothing here, we don't want to show the text "showing x of y from..."
                    },
                    formatRecordsPerPage: function(pageNumber){
                        return pageNumber + " rows visible";
                    },
                    icons: {
                        refresh: 'fa fa-refresh',
                        toggle: 'fa fa-th-list',
                        columns: 'fa fa-columns',
                        detailOpen: 'fa fa-plus-circle',
                        detailClose: 'ti-close'
                    }
                });

                //activate the tooltips after the data table is initialized
                $('[rel="tooltip"]').tooltip();

                $(window).resize(function () {
                    $table.bootstrapTable('resetView');
                });
            });

 $(document).ready(function(){
//   $('.assigndoctor').change(function(){ 
   $('body').on('change', '.assigndoctor', function() {
            var cur_value = $('option:selected',this).attr('value');

            var cur_text = $('option:selected',this).text();

            var res = cur_value.split("|");
            
            var retVal = confirm("The Doctor will be notified, and the job will be set to Waiting for Approval\nAre you sure?");
               if( retVal == true ) {
                  $.ajax({url: "<?php echo base_url();?>admin/assignDoctortopatient?doctor_id="+cur_value, success: function(result){
                       $('.assigndoctor'+res[1]).html("<strong class='text-danger'>Awaiting Acceptance</strong><br /><small>(Not Delivered)</small>");

                       $('.assigntext'+res[1]).html("<a class='profile_link' href='<?php echo base_url();?>doctor/DoctorDetails/"+res[0]+"'>"+ cur_text  +"</a>");
                       
                        alert('This job is assigned to '+ cur_text );
                    }
                });
               } else {
                  
               }
     });
});

   $(document).ready(function(){
	 $('body').on('click', '.AddtoArchive', function() {
        var postId = $(this).attr("value");

          $.ajax({url: "<?php echo base_url();?>admin/AddtoArchive?Post_id="+postId, success: function(result){
                $("#"+postId).remove();                    
            }
       });
  });
});

  $(document).ready(function(){
         //  $('.AddtoUrgent').click(function(){ 
		   $('body').on('click', '.AddtoUrgent', function() {
              var postId = $(this).attr("value");
                $.ajax({url: "<?php echo base_url();?>doctor/AddtoUrgent?Post_id="+postId, success: function(result){
                $("#"+postId).remove();
                location.reload();                    
              }
             });
        });
});
                                                            
     $(document).ready(function(){
          // $('.RemovetoUrgent').click(function(){ 
		    $('body').on('click', '.RemovetoUrgent', function() {
              var postId = $(this).attr("value");
                $.ajax({url: "<?php echo base_url();?>doctor/RemovetoUrgent?Post_id="+postId, success: function(result){
                $("#"+postId).remove();
                location.reload();                    
              }
             });
        });
});

 $(document).ready(function(){
  // $('.sendInvoice').click(function(){ 
$('body').on('click', '.sendInvoice', function() {
    var postId = $(this).attr("value");
        var retVal = confirm("The Institute will be sent the generated Invoice for this job\nAre you sure?");
               if( retVal == true ) {
                  window.location.assign("<?php echo base_url();?>invoice/generateInvoice/"+postId)
               } else {
               }
     });
});

         $("#my_form").submit(function(event){
            event.preventDefault();  
            var post_url = '<?php echo base_url();?>AddDoctor/AddNewDoctor'; 
            var request_method = $(this).attr("method"); 
            var form_data = $(this).serialize();
                $.ajax({
                url : post_url,
                type: request_method,
                data : form_data
            }).done(function(response){ //
                $("#server-results").html(response);
                $('#colorbox').hide();
            });
        });
    </script>
</html>
