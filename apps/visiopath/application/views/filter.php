<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Filter by <?php echo $query ;?> - Lims</title>

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
          
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 mt-3">
          
         
             </div>
         
          <div class="col-lg-4 col-md-6 col-sm-6 mt-3 text-right">
           
          </div>

           
    </div>


       
            <div class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                        	<div class="card">
                                <div class="card-content ">
                                  <span class="text-theme  bootstrap-table"></span>
                                    <div class="toolbar">
                                         

                                    </div>
                                    <table id="bootstrap-table2" class="table-striped mytable urgent">
                                        <thead>
                                           
                                            <th data-field="actions" class="td-actions " >Actions</th>
                                            <th data-field="id" data-sortable="true">Case ref</th>
                                            <th data-field="name" data-sortable="true">Patient name </th>
                                            <th data-field="salary" data-sortable="true">Date created</th>
                                            <th data-field="clinic" data-sortable="true">Referring clinic</th>
                                            <th data-field="doctor" data-sortable="true">Doctor name</th>
                                            <th data-field="Status" data-sortable="true">Status</th>
                                            
                                        </thead>
                                        <tbody>

                                        <?php foreach($testDetails as $key => $job){  ?>

                                            <tr id="<?php echo $job->test_primary_id ?>"  <?php if($job->urgent == 1){ ?> class="" <?php  }?>>
                                                <td>

                                                     <div class="dropdown action-box">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu action-menu">
                                                          
                                                            <?php /*if($job->authorised == 1){?>  
                                                                <li>
                                                                    <a target="blank" href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_primary_id ?>" > View Report </a>
                                                                </li>
                                                           <?php }?>

                                                            <?php if($job->urgent != 1){?>

                                                                <li>
                                                                    <a class="AddtoUrgent" href="javascript:;" value="<?php echo $job->test_primary_id ?>"> Add urgent </a>
                                                                </li>
                                                            <?php }else{?>
                                                                <li>
                                                                    <a class="RemovetoUrgent" href="javascript:;" value="<?php echo $job->test_primary_id ?>"> Remove urgent </a>
                                                                </li>
                                                            <?php }*/?>

                                                               
                                                                
                                                                <?php  if($job->authorised == 1){?>
                                                                   
                                                                <?php }else{ ?>

                                                                     <li>
                                                                        <a href="<?php echo base_url();?>admin/EditJob/<?php echo $job->test_primary_id ?>" value="<?php echo $job->test_primary_id ?>" > Edit Job 
                                                                        </a>
                                                                    </li>

                                                                <?php }?>
                                                          </ul>
                                                    </div>

                                                 </td>
                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a class="profile_link" href="<?php echo base_url()?>user/PatientDetails/<?php echo $job->patient_primary_id?>"> 
                                                        <?php echo $job->patient_name." ".$job->last_name; ?> 
                                                    </a><br /><small><?php $date=date_create($job->DateOfBirth); echo date_format($date,$dateFormat); ?></small>
                                                </td>
                                                <td><?php $date=date_create($job->test_date); echo date_format($date,$dateFormat); ?></td>
                                                <td><a class="profile_link" href="<?php echo base_url()?>hospital/HospitalDetails/<?php echo $job->hospital_id ?>">
                                                    <?php  

                                                    foreach($hospitals as $hospital){ 
                                                                if($hospital->hospital_id == $job->hospital_id ){
                                                                    echo $hospital->hospital_name;
                                                                }
                                                            }

                                                     ?> </a>
                                                 </td>
                                                <td class="assigntext<?php echo $job->test_primary_id ?>">

                                                    <?php if(empty($job->doctor_id)){ ?>
                                                    <select class="assigndoctor">
                                                      <option>Select Doctor</option>
                                                      <?php foreach($doctors as $doctor){  ?>
                                                        <option value="<?php echo $doctor->doctor_id ?>|<?php echo $job->test_primary_id ?>"><?php echo 'Dr. '.$doctor->doctor_name ?></option>
                                                      <?php  }?>
                                                    </select>
                                                    <?php    }else{

                                                        foreach($doctors as $doctor){ 
                                                            if($job->doctor_id == $doctor->doctor_id ){
                                                              ?> 
                                                              <a class="profile_link" href="<?php echo base_url()?>doctor/DoctorDetails/<?php echo $job->doctor_id ?>">
                                                                    <?php echo $doctor->doctor_name ?> 
                                                               </a>
                                                               <?php
                                                            }
                                                        }



                                                        }?>
        
                                                 </td>

                                                  <td class="assigndoctor<?php echo $job->test_primary_id ?>"> 
                                                    <?php if(empty($job->doctor_id)){ 
                                                            echo "<strong>Unassigned</strong>" ;
                                                        }elseif(!empty($job->doctor_id) && empty($job->doctor_approval)){ 
                                                             echo "<strong class='text-danger'>Awaiting Acceptance</strong>"; 
                                                        }elseif($job->authorised == 1){
                                                             echo "<strong class='text-success'>Completed</strong>";
                                                        }else{
                                                            echo "<strong>Accepted</strong>";
                                                        } ?><br />

                                                        <small>
                                                            <?php if($job->box_received == 1){
                                                                echo "(Box Received)";
                                                            }else{
                                                                echo "(Not Delivered)";
                                                            }?>
                                                        </small>
                                                                    
                                                 </td>
                                                  
                                                
                                            </tr>
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
  		                          
								  
								  
								  
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
					searchText:"<?php echo $query ;?>",
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

    </script>

      <script type="text/javascript">
       /**/
      

 $(document).ready(function(){
   $('.assigndoctor').change(function(){ 
            var cur_value = $('option:selected',this).attr('value');

            var cur_text = $('option:selected',this).text();
            
            var res = cur_value.split("|");

            var retVal = confirm("The Doctor will be notified, and the job will be set to Waiting for Approval\nAre you sure?");
               if( retVal == true ) {
                  $.ajax({url: "<?php echo base_url();?>admin/assignDoctortopatient?doctor_id="+cur_value, success: function(result){
                        // location.reload();
                        $('.assigndoctor'+res[1]).html("<strong class='text-danger'>Awaiting Acceptance</strong><br /><small>(Not Delivered)</small>");

                        $('.assigntext'+res[1]).html("<a class='profile_link' href='<?php echo base_url();?>doctor/DoctorDetails/"+res[0]+"'>"+ cur_text  +"</a>");

                    }});
               } else {
                  
               }

          
     });
});

	 $(document).ready(function(){
	   $('.AddtoArchive').click(function(){ 
	   	  var postId = $(this).attr("value");

	        $.ajax({url: "<?php echo base_url();?>admin/AddtoArchive?Post_id="+postId, success: function(result){
                $("#"+postId).remove();                    
            } 
	          
	     });
	});

});

	$(document).ready(function(){
           $('.AddtoUrgent').click(function(){ 
           	  var postId = $(this).attr("value");

                $.ajax({url: "<?php echo base_url();?>doctor/AddtoUrgent?Post_id="+postId, success: function(result){
                $("#"+postId).remove();
                location.reload();                    
            	}
                  
             });
        });
});
                                                            
     $(document).ready(function(){
           $('.RemovetoUrgent').click(function(){ 
           	  var postId = $(this).attr("value");

                $.ajax({url: "<?php echo base_url();?>doctor/RemovetoUrgent?Post_id="+postId, success: function(result){
                $("#"+postId).remove();
                                    
            	}
                  
             });
        });
});


     $(document).ready(function(){
       $('.sendInvoice').click(function(){ 

        var postId = $(this).attr("value");

            var retVal = confirm("The Institute will be sent the generated Invoice for this job\nAre you sure?");
                   if( retVal == true ) {
                      window.location.assign("<?php echo base_url();?>invoice/generateInvoice/"+postId)
                   } else {
                      
                   }
              
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
