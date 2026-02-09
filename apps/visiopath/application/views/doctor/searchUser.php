

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Search - Lims</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

<?php $this->load->view('partial/head')?>



</head>

<body>
	<div class="wrapper">
	    

        <?php $this->load->view('partial/sidebar')?>

	    <div class="main-panel">
			
            <?php $this->load->view('partial/nav')?>

      

	        <div class="container-fluid ">
          <div class="col-lg-4 col-md-6 col-sm-6 ">
           
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
             
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
            

          </div>
         <div class="col-lg-2 col-md-6 col-sm-6">
           
          </div>
        </div>

      

       
            <div class="content ">
                <div class="container-fluid">
                  <div class="row">
                        <div class="col-md-12">
                          
                            <!--  end card  -->

                            

                            <div class="card">
                               <div class="card-content"> <span class="text-theme  bootstrap-table">Search</span>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table" class="table-striped my-table">
                                        <thead>
                                            <th data-field="id" data-sortable="true">Case Ref.</th>
                                            <th data-field="Vp" data-sortable="true">Visiopath #</th>
                                            <th data-field="name" data-sortable="true">Patient Name </th>
											 <th data-field="hnumber" data-sortable="true">Hospital Number </th>
                                            <th data-field="status" data-sortable="true">Status</th>
                                            <?php if($this->session->userdata('roleId') == 3 || $this->session->userdata('roleId') == 1){ ?>
                                              <th data-field="doctor" data-sortable="true">Doctor name</th>
                                             <?php } ?>
                                            <?php if($this->session->userdata('roleId') == 2 || $this->session->userdata('roleId') == 1){ ?>
                                                <th data-field="referring" data-sortable="true">Hospital name</th> 
                                            <?php } ?>
                                            
                                            <th data-field="date" data-sortable="true">Date Created</th>
                                            <th data-field="dob" data-sortable="true" class="display-none">Date Of Birth</th>
                                            <th data-field="address" data-sortable="true" class="display-none">Address</th>
                                        </thead>
                                        <tbody>

                                        <?php foreach($Jobs as $job){ //print_r($job);?>

                                            <tr id="<?php echo $job->test_id?>">
                                                <td><?php echo $job->Client_case_number?></td>
                                                  <td><?php echo $job->visiopath_number?></td>
                                                <td><a class="profile_link" href="<?php echo base_url();?>user/PatientDetails/<?php echo $job->patient_id?>"> 
                                                  <?php echo $job->patient_name." ".$job->last_name ;?> </a> </td>
                                               
													<td><?php echo $job->hospital_number?></td>
                                                <td>
												
												                             <?php if(empty($job->doctor_id)){  
                                                        ?>
                                                             <strong>Unassign</strong>
                                                      
                              												<?php }elseif(!empty($job->doctor_id) && empty($job->doctor_approval)){  
                              													?>
                                                             <strong class='text-danger'><a href="<?php echo base_url();?>doctor/viewTestDetails/<?php echo $job->test_id?>" style="text-decoration:underline">Awating approve</a></strong>
                                                      <?php
                                                        }elseif($job->authorised == 'authorised'){
                                                             echo "<strong class='text-success'>Completed</strong>";
                                                        }elseif(!empty($job->doctor_id) && !empty($job->doctor_approval)){ 
                                                             echo "<strong class='text-success'>Accepted </strong>"; 
                                                        } ?>
                                                                    
                                                </td>
                                                <?php if($this->session->userdata('roleId') == 3 || $this->session->userdata('roleId') == 1){ ?>
                                                 <td>

                                                    <?php if(empty($job->doctor_id)){
                                                             echo "<strong >Unassign </strong>";
                                                        }else{  ?>
                                                              <a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php  echo $job->doctor_id ?>"> 
                                                      <?php echo 'Dr. '.$job->doctor_name; ?>
                                                    </a> 
                                                      <?php  }?>
                                                </td>
                                              <?php } ?>
                                                <?php if($this->session->userdata('roleId') == 2 || $this->session->userdata('roleId') == 1){ ?>
                                                  <td>
                                                    <a class="profile_link" href="<?php echo base_url();?>hospital/HospitalDetails/<?php  echo $job->hospital_id ?>"> 
                                                      <?php echo $job->hospital_name; ?>
                                                    </a>
                                                  </td>
                                                <?php } ?>
                                                

                                                <td><?php $date=date_create($job->test_date); echo date_format($date,"d-m-Y"); ?></td>
                                                <td><?php $date=date_create($job->DateOfBirth); echo date_format($date,"d-m-Y"); ?></td>
                                                <td><?php echo $job->address; ?></td>
                                                
                                             
                                                
                                            </tr>

                                            
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--  end card  -->
                            <!-- end col-md-12 -->
                    </div> <!-- end row -->
                  </div>
                </div>
            </div>

            <?php $this->load->view('partial/footer')?>
	    </div>
	</div>
</body>

     <?php $this->load->view('partial/footerscript')?>

  



	<script type="text/javascript">
    	$(document).ready(function(){
			demo.initOverviewDashboard();
			demo.initCirclePercentage();

    	});

$("#dropdown-filter-menu a").click(function(){
	var $table = $('.my-table');
	var selectedText = $(this).text();
	if(selectedText == "All"){ selectedText = "";}
	$table.bootstrapTable('refreshOptions', {searchText:selectedText});
});
	</script>

    <script type="text/javascript">

        var $table = $('.my-table');

        $table.bootstrapTable('hideColumn', 'address');

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
                    searchText:"<?php echo $_GET['query']?>",
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
            $.ajax({url: "<?php echo base_url();?>admin/assignDoctortopatient?doctor_id="+cur_value, success: function(result){
             location.reload();
            //$('.assigndoctor').html("Hello <b>world!</b>");

        }});
     });
});
    
</script>

<script>

     $(document).ready(function(){
       $('.AddtoArchive').click(function(){ 
          var postId = $(this).attr("value");

            $.ajax({url: "<?php echo base_url();?>doctor/AddtoArchive?Post_id="+postId, success: function(result){
                $("#"+postId).remove();                    
            } 
              
         });
    });

});

     $(document).ready(function(){
       $('.SetBoxReceived').change(function(){ 
          var postId = $(this).attr("value");
            $.ajax({url: "<?php echo base_url();?>doctor/SetBoxReceived?test_id="+postId, success: function(result){
              $('#check'+postId).text('Box Received');                  
             } 
            });
        });
    });



</script>

</html>
