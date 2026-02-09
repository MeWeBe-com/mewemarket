<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
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

      

	        <div class="container-fluid mt-3">
          <div class="col-lg-4 col-md-6 col-sm-6 mt-3">
            <a href="<?php echo base_url();?>admin/addJob" class="btn btn-outline-danger login_btn">Add job</a>

            <a href="<?php echo base_url();?>admin/ChooseExistingPatient" class="btn btn-outline-danger login_btn">Edit job</a>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 mt-3">
          
          <a class='ajax btn btn-outline-danger login_btn' href="https://www.reviewschef.com/lims_system/admin/AddDoctor?appview">Add doctor</a>

             </div>
          <div class="col-lg-2 col-md-6 col-sm-6 mt-4">
            <!--<a href="<?php echo base_url();?>archive" class="text-theme btn btn-outline-danger">Go to Archive</a> -->

          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
             <div class="col-lg-5 col-md-6 col-sm-6 pull-left mt-4">  
              Filter  :
            </div>

            <div class="col-lg-7 col-md-6 col-sm-6 pull-right mt-2">
                <form>
                 <div class="dropdown">
                      <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          Select
                          <b class="caret"></b>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a href="#">All</a></li>
                        <li><a href="#">Complete</a></li>
                        <li><a href="#">Pending</a></li>
                        <li><a href="#">Unassigned</a></li>
                        <li><a href="#">Approved</a></li>
                        <li><a href="#">Awaiting approval</a></li>
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

                             <div class="">
                        </div> 

                        <div class="card">
                                <div class="card-content bg-red">
                                    <h3>Urgent Cases</h3>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table2" class="table-striped mytable urgent">
                                        <thead>
                                           
                                             <th data-field="Urgent" >Urgent</th>
                                            <th data-field="id" data-sortable="true">Case ref.</th>
                                            <th data-field="name" data-sortable="true">Patient name </th>
                                            <th data-field="salary" data-sortable="true">Date created</th>
                                            <th data-field="clinic" data-sortable="true">Referring clinic</th>
                                            <th data-field="doctor" data-sortable="true">Doctor</th>
                                            <th data-field="Status" data-sortable="true">Status</th>
                                             <th data-field="state" >Archive</th>
                                            <th data-field="actions" class="td-actions text-right" >Actions</th>
                                        </thead>
                                        <tbody>

                                        <?php foreach($UrgentsJobs as $job){ ?>

                                            <tr id="<?php echo $job->test_id?>">
                                              
                                                <td>
                                                    <input class="RemovetoUrgent" value="<?php echo $job->test_id?>" type="checkbox" checked>
                                                </td>
                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a href="<?php echo base_url()?>user/PatientDetails/<?php echo $job->test_id?>"> <?php echo $job->patient_name?> </a></td>
                                                <td><?php echo $job->test_date?></td>
                                                <td>
                                                    <?php  

                                                    foreach($hospitals as $hospital){ 
                                                                if($hospital->hospital_id == $job->hospital_id ){
                                                                    echo $hospital->hospital_name;
                                                                }
                                                            }

                                                     ?> 
                                                 </td>
                                                <td>

                                                    <?php if(empty($job->doctor_id)){ ?>
                                                    <select class="assigndoctor">
                                                      <option>Select Doctor</option>
                                                      <?php foreach($doctors as $doctor){  ?>
                                                        <option value="<?php echo $doctor->doctor_id?>|<?php echo $job->test_id?>"><?php echo $doctor->doctor_name ?></option>
                                                      <?php  }?>
                                                    </select>
                                                    <?php    }else{

                                                        foreach($doctors as $doctor){ 
                                                            if($job->doctor_id == $doctor->doctor_id ){
                                                                echo $doctor->doctor_name;
                                                            }
                                                        }



                                                        }?>
        
                                                 </td>
                                                  <td> 
                                                    <?php if(empty($job->doctor_id)){ 
                                                            echo "<strong>Unassigned</strong>" ;
                                                        }elseif(!empty($job->doctor_id) && empty($job->doctor_approval)){ 
                                                             echo "<strong class='text-danger'>Awaiting Acceptance</strong>"; 
                                                        }elseif(!empty($job->sentinvoice)){
                                                             echo "<strong class='text-success'>Completed</strong>";
                                                        }else{
                                                            echo "<strong>Accepted</strong>";
                                                        } ?>
                                                                    
                                                 </td>
                                                   <td>
                                                    <input class="AddtoArchive" value="<?php echo $job->test_id?>" type="checkbox">
                                                </td>
                                                <td>

                                                    <div class="dropdown">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                          <?php if(empty($job->invoicealreadySend)){?>  
                                                                <li><a class="<?php if(empty($job->sentinvoice)){}else{ echo "sendInvoice".$job->test_id ;} ?> " <?php if(empty($job->sentinvoice)){ echo "Disabled" ;}else{?> href="#" <?php }?> > Send invoice </a>
                                                                </li>
                                                           <?php }?>

                                                           <?php if(!empty($job->invoicealreadySend)){?>  
                                                                <li>
                                                                    <a href="<?php echo base_url();?>doctor/GetInvoiceDownload/<?php echo $job->test_id?>" > View invoice </a>
                                                                </li>
                                                           <?php }?>

                                                            <?php if(!empty($job->sentinvoice)){?>  
                                                                <li>
                                                                    <a href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_id?>" > View Report </a>
                                                                </li>
                                                           <?php }?>
                                                          </ul>
                                                    </div>

                                                    <?php /*if(empty($job->invoicealreadySend)){?>

                                                        <a  class="btn btn-outline-danger btn-theme sendInvoice<?php echo $job->test_id?>" <?php if(empty($job->sentinvoice)){ echo "Disabled" ;}else{?> href="#"<?php }?> > Send invoice </a>
                                                    <?php }else{ ?> <a class="btn btn-outline-danger btn-theme" disabled=""> Invoice Sent </a>  <?php  }*/?>

                                                      <script>
                                                            
                                                             $(document).ready(function(){
                                                                   $('.sendInvoice<?php echo $job->test_id?>').click(function(){ 

                                                                        var retVal = confirm("The Institute will be sent the generated Invoice for this job\nAre you sure?");
                                                                               if( retVal == true ) {
                                                                                  window.location.assign("<?php echo base_url();?>invoice/generateInvoice/<?php echo $job->test_id?>")
                                                                               } else {
                                                                                  
                                                                               }
                                                                          
                                                                     });
                                                                });

                                                     </script>    
                                                     

                                                 </td>
                                            </tr>
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>



                           <div class="card">
                                <div class="card-content">
                                    <div class="toolbar">
                                       
                                    </div>
                                    <table id="bootstrap-table" class="table-striped mytable">
                                       <thead>
                                            
                                             <th data-field="Urgent" >Urgent</th>
                                            <th data-field="id" data-sortable="true">Case ref.</th>
                                            <th data-field="name" data-sortable="true">Patient name </th>
                                            <th data-field="salary" data-sortable="true">Date created</th>
                                            <th data-field="clinic" data-sortable="true">Referring clinic</th>
                                            <th data-field="doctor" data-sortable="true">Doctor</th>
                                            <th data-field="Status" data-sortable="true">Status</th>
                                            <th data-field="state" >Archive</th>
                                            <th data-field="actions" class="td-actions text-right" >Actions</th>
                                        </thead>
                                        <tbody>

                                        <?php foreach($jobDetails as $job){ ?>

                                            <tr id="<?php echo $job->test_id?>">
                                                 <td>
                                                    <input class="AddtoUrgent" value="<?php echo $job->test_id?>" type="checkbox">
                                                </td>

                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a href="<?php echo base_url()?>user/PatientDetails/<?php echo $job->test_id?>"> <?php echo $job->patient_name?> </a></td>
                                                <td><?php echo $job->test_date?></td>
                                                <td>
                                                    <?php  

                                                    foreach($hospitals as $hospital){ 
                                                                if($hospital->hospital_id == $job->hospital_id ){
                                                                    echo $hospital->hospital_name;
                                                                }
                                                            }

                                                     ?> 
                                                 </td>
                                                <td>

                                                    <?php if(empty($job->doctor_id)){ ?>
                                                    <select class="assigndoctor">
                                                      <option>Select Doctor</option>
                                                      <?php foreach($doctors as $doctor){  ?>
                                                        <option value="<?php echo $doctor->doctor_id?>|<?php echo $job->test_id?>"><?php echo $doctor->doctor_name ?></option>
                                                      <?php  }?>
                                                    </select>
                                                    <?php    }else{

                                                        foreach($doctors as $doctor){ 
                                                            if($job->doctor_id == $doctor->doctor_id ){
                                                                echo $doctor->doctor_name;
                                                            }
                                                        }



                                                        }?>
        
                                                 </td>
                                                 <td> 
                                                    <?php if(empty($job->doctor_id)){ 
                                                            echo "<strong>Unassigned</strong>" ;
                                                        }elseif(!empty($job->doctor_id) && empty($job->doctor_approval)){ 
                                                             echo "<strong class='text-danger'>Awaiting Acceptance</strong>"; 
                                                        }elseif(!empty($job->sentinvoice)){
                                                             echo "<strong class='text-success'>Completed</strong>";
                                                        }else{
                                                            echo "<strong>Accepted</strong>";
                                                        } ?>
                                                                    
                                                 </td>
                                                   <td>
                                                    <input class="AddtoArchive" value="<?php echo $job->test_id?>" type="checkbox">
                                                </td>
                                                <td>

                                                    <div class="dropdown">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                          <?php if(empty($job->invoicealreadySend)){?>  
                                                                <li><a class="<?php if(empty($job->sentinvoice)){}else{ echo "sendInvoice".$job->test_id ;} ?> " <?php if(empty($job->sentinvoice)){ echo "Disabled" ;}else{?> href="#" <?php }?> > Send invoice </a>
                                                                </li>
                                                           <?php }?>

                                                           <?php if(!empty($job->invoicealreadySend)){?>  
                                                                <li>
                                                                    <a href="<?php echo base_url();?>doctor/GetInvoiceDownload/<?php echo $job->test_id?>" > View invoice </a>
                                                                </li>
                                                           <?php }?>

                                                            <?php if(!empty($job->sentinvoice)){?>  
                                                                <li>
                                                                    <a href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_id?>" > View Report </a>
                                                                </li>
                                                           <?php }?>
                                                            
                                                          </ul>
                                                    </div>

                                                    <?php /*if(empty($job->invoicealreadySend)){?>

                                                    <a  class="btn btn-outline-danger btn-theme sendInvoice<?php echo $job->test_id?>" <?php if(empty($job->sentinvoice)){ echo "Disabled" ;}else{?> href="#"<?php }?> > Send invoice </a>
                                                    <?php }else{ ?> <a class="btn btn-outline-danger btn-theme" disabled=""> Invoice Sent </a> <?php  }*/?>    
                                                     <script>
                                                            
                                                             $(document).ready(function(){
                                                                   $('.sendInvoice<?php echo $job->test_id?>').click(function(){ 

                                                                        var retVal = confirm("The Institute will be sent the generated Invoice for this job\nAre you sure?");
                                                                               if( retVal == true ) {
                                                                                  window.location.assign("<?php echo base_url();?>invoice/generateInvoice/<?php echo $job->test_id?>")
                                                                               } else {
                                                                                  
                                                                               }
                                                                          
                                                                     });
                                                                });

                                                     </script>

                                                 </td>
                                            </tr>
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <a href="<?php echo base_url();?>archive" class="btn btn-outline-danger btn-theme mb-5">Go to Archive</a>
<!--  end card  -->
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
			demo.initOverviewDashboard();
			demo.initCirclePercentage();

    	});


	</script>

    <script type="text/javascript">

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
                    showToggle: false,
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

    </script>

      <script type="text/javascript">
       /**/
      

 $(document).ready(function(){
   $('.assigndoctor').change(function(){ 
            var cur_value = $('option:selected',this).attr('value');
            var retVal = confirm("The Doctor will be notified, and the job will be set to Waiting for Approval\nAre you sure?");
               if( retVal == true ) {
                  $.ajax({url: "<?php echo base_url();?>admin/assignDoctortopatient?doctor_id="+cur_value, success: function(result){
                         location.reload();
                        //$('.assigndoctor').html("Hello <b>world!</b>");

                    }});
               } else {
                  
               }

          
     });
});



 $(document).ready(function(){
   $('.AddtoArchive').change(function(){ 

        if($(this).is(":checked")){
            var postId = $(this).val();
}           
            $.ajax({url: "<?php echo base_url();?>admin/AddtoArchive?Post_id="+postId, success: function(result){
                $("#"+postId).remove();                    
            } 

        });
     });
});

  $(document).ready(function(){
   $('.AddtoUrgent').change(function(){ 
        if($(this).is(":checked")){
            var postId = $(this).val();
}           
            $.ajax({url: "<?php echo base_url();?>doctor/AddtoUrgent?Post_id="+postId, success: function(result){
                $("#"+postId).remove(); 
                location.reload();                   
            } 

        });
     });
});

  $(document).ready(function(){
   $('.RemovetoUrgent').change(function(){ 
        if($(this).is(":unchecked")){
            var postId = $(this).val();
}           
            $.ajax({url: "<?php echo base_url();?>doctor/RemovetoUrgent?Post_id="+postId, success: function(result){
                $("#"+postId).remove();
                location.reload();                    
            } 

        });
     });
});





        
       

    </script>

    <script>
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
