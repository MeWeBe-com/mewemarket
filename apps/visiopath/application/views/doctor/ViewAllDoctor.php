

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Doctor Dashboard - Lims</title>

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
            <div class="pull-right mt-3">
                <form>
                 <div class="dropdown">
                      <button href="#" class="btn btn-block dropdown-toggle btn-wd ButtonText" data-toggle="dropdown" aria-expanded="false">
                          Filter
                          <b class="caret"></b>
                      </button>
                      <ul class="dropdown-menu" id="dropdown-filter-menu">
                        <li class="AllIcon"><a href="#">All</a></li>
                        <li class="CompletedIcon"><a href="#">Completed</a></li>
                        <li class="AwaitingIcon"><a href="#">View and Start</a></li>
                        <li class="AcceptedIcon"><a href="#">Started</a></li>
                        
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
                          
                            <!--  end card  -->

                            <div class="card">
                               <div class="card-content "> <span class="text-theme  bootstrap-table">Urgent Cases</span>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table2" class="urgent table-striped my-table">
                                        <thead>
                                           
                                            <th data-field="actions" class="td-actions " >Actions</th>
                                            <th data-field="id" data-sortable="true">Case Ref</th>
                                            <th data-field="name" data-sortable="true">Patient Name </th>
                                            <th data-field="status" data-sortable="true">Status</th>
                                            <th data-field="referring" data-sortable="true">Referring Institution</th>
                                            <th data-field="box" data-sortable="true">Slides received</th>
                                            <th data-field="date" data-sortable="true">Date Created</th>

                                            
                                        </thead>
                                        <tbody>

                                        <?php foreach($urgentDetails as $key => $job){ 
                                          $number = $key;
                                          ?>

                                            <tr id="<?php echo $job->test_id?>" <?php if(($number % 2) == 0){ ?> class="danger"  <?php }?>>
                                               
                                                <td> 
                                                    <div class="dropdown action-box">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu action-menu">
                                                             <?php if($autoAccept == 1 && $job->primary_status != 1){ ?>
                                                                <li> 
                                                                 <a target="blank" href="<?php echo base_url();?>doctor/viewTestDetails/<?php echo $job->test_id?>">
                                                                    View & Start
                                                                </a></li> 
                                                            <?php }elseif($job->primary_status != 1){ ?>
                                                                <li> 
                                                                 <a  href="<?php echo base_url();?>doctor/viewTestDetails/<?php echo $job->test_id?>">
                                                                    View & Approve
                                                                </a></li> 
                                                            <?php }elseif(!empty($job->viewReport)){
                                                            ?>  
                                                                 <?php if($job->authorised != 'authorised'){?>
                                                              <li> 
                                                                 <a  href="<?php echo base_url();?>uploadreport/EditReport/<?php echo $job->test_id?>">
                                                                    Edit Report
                                                                </a></li> 

                                                            <?php }else{ ?>
                                                               
                                                            <?php }?>
                                                          
                                                                <li>  <a   href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_id?>"  >
                                                                    View Report
                                                                </a></li>

                                                                 <?php if($job->authorised != 'authorised'){?>
                                                                    <li>  <a   href="<?php echo base_url();?>uploadreport/EditReport/<?php echo $job->test_id?>#Authorise"  >
                                                                   Authorise Report
                                                                </a></li>
                                                                 <?php }?>
                                                            <?php 
                                                        }else{?>
                                                              <li> <a  href="<?php echo base_url();?>uploadreport/EditReport/<?php echo $job->test_id?>">View Case</a></li>
                                                            <?php }?>

                                                               <?php if($job->authorised == 'authorised' ){?>

                                                              <li>
                                                                <a class="AddtoArchive" href="javascript:;" value="<?php echo $job->test_id?>"> Move to archive </a>
                                                                </li>

                                                              <?php }?>

                                                              <?php /*foreach($job->multipleUploads as $file){  $file_name = explode('/', $file->upload_file);?>
                                                                  <li>
                                                                    <a target="_blank" href="<?php echo base_url().$file->upload_file ;?>"> <?php echo $file_name[2];?> </a>
                                                                  </li>
                                                            <?php }*/?>
                                                          </ul>
                                                    </div>
                                                  </td>
                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a class="profile_link" href="<?php echo base_url();?>user/PatientDetails/<?php echo $job->patient_id?>"> 
                                                    <?php echo $job->patient_name." ".$job->last_name ;?> 
                                                  </a><br /><small> DOB: <?php $date=date_create($job->DateOfBirth); echo date_format($date,$dateFormat); ?> </td>
                                                
                                                <td>
                                                    <?php if($autoAccept == 1 && $job->primary_status == 0){?>
                                                             <strong class='text-danger status-box'><a href="<?php echo base_url();?>doctor/viewTestDetails/<?php echo $job->test_id?>" style="text-decoration:underline">View and Start</a></strong>
                                                      <?php
                                                        }elseif(!empty($job->primary_status) && $job->primary_status == 0){?>
                                                             <strong class='text-danger status-box'><a href="<?php echo base_url();?>doctor/viewTestDetails/<?php echo $job->test_id?>" style="text-decoration:underline">View and Approve</a></strong>
                                                      <?php
                                                        }elseif($job->authorised == 'authorised'){
                                                             echo "<strong class='text-success status-box'>Completed</strong>";
                                                        }elseif(!empty($job->primary_status) && $job->primary_status == 1 ){ 
                                                             echo "<strong class='text-success status-box'>Started - <a style='text-decoration:underline;color:#ae1a41' href='".base_url()."uploadreport/EditReport/".$job->test_id."'>Edit Report</a>  </strong>"; 
                                                        } ?>
                                                                    
                                                </td>
                                                 <td><a class="profile_link" href="<?php echo base_url();?>hospital/HospitalDetails/<?php  echo $job->hospital_id ?>"> 
                                                    
                                                    <?php 

                                                      foreach($hospitals as $hospital){ 
                                                                    if($hospital->hospital_id == $job->hospital_id ){
                                                                        echo $hospital->hospital_name;
                                                                    }
                                                                }

                                                       ?></a>

                                                </td>

                                                 <td <?php if($job->box_received == 0 ){ ?> class="text-left" <?php  }?> id="check<?php echo $job->test_id?>">
                                                    <?php if($job->box_received == 0 ){ ?>
                                                        <div class="checkbox" id="check<?php echo $job->test_id?>"> 
                                                            <input id="checkbox1" type="checkbox" class="SetBoxReceived" value="<?php echo $job->test_id?>">
                                                            <label for="checkbox1"></label>
                                                        </div>
                                                    <?php }else{
                                                        echo "Slides Received";
                                                    }?>
                                                </td>

                                                <td><?php $date=date_create($job->test_date); echo date_format($date,$dateFormat); ?></td>

                                            </tr>

                                            
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php if(!isset($_GET['urgent'])){?>
                            <div class="card">
                               <div class="card-content"> <span class="text-theme  bootstrap-table">Routine Cases</span>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table" class="table-striped my-table">
                                        <thead>
                                           
                                            <th data-field="actions" class="td-actions " >Actions</th>
                                            <th data-field="id" data-sortable="true">Case Ref</th>
                                            <th data-field="name" data-sortable="true">Patient Name </th>
                                            <th data-field="status"  data-sortable="true">Status</th>
                                            <th data-field="referring" data-sortable="true">Referring Institution</th>
                                            <th data-field="box"  data-sortable="true">Slides received</th>
                                            <th data-field="date" data-sortable="true">Date Created</th>

                                            
                                        </thead>
                                        <tbody>

                                        <?php foreach($jobDetails as $job){ //print_r($job);?>

                                            <tr id="<?php echo $job->test_id?>">
                                                <td>

                                                     <div class="dropdown action-box">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu action-menu">
                                                             <?php /*if($job->authorised != 'authorised'){?>
                                                            <li> 
                                                                 <a  href="<?php echo base_url();?>admin/EditJob/<?php echo $job->test_id?>">
                                                                    Edit Job
                                                                </a>
                                                            </li> 
                                                            <?php }*/?>
                                                             <?php if($autoAccept == 1 && $job->primary_status == 0){ ?>
                                                                <li> 
                                                                 <a target="blank" href="<?php echo base_url();?>doctor/viewTestDetails/<?php echo $job->test_id?>">
                                                                    View & Start
                                                                </a></li> 
                                                            <?php }elseif($job->primary_status == 0){ ?>
                                                                <li> 
                                                                 <a target="blank" href="<?php echo base_url();?>doctor/viewTestDetails/<?php echo $job->test_id?>">
                                                                    View & Approve
                                                                </a></li> 
                                                            <?php }elseif(!empty($job->viewReport)){
                                                            ?>   
                                                                 <?php if($job->authorised != 'authorised'){?>
                                                              <li> 
                                                                 <a  href="<?php echo base_url();?>uploadreport/EditReport/<?php echo $job->test_id?>">
                                                                    Edit Report
                                                                </a></li> 

                                                            <?php }else{ ?>
                                                                
                                                            <?php }?>
                                                          
                                                               <li>  <a  href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_id?>"  >
                                                                    View Report
                                                                </a></li>
                                                                 <?php if($job->authorised != 'authorised'){?>
                                                                <li>  
                                                                  <a href="<?php echo base_url();?>uploadreport/EditReport/<?php echo $job->test_id?>#Authorise"  >
                                                                    Authorise Report
                                                                  </a>
                                                                </li> <?php }?>
                                                            <?php 
                                                        }else{?>
                                                              <li> <a target="blank" href="<?php echo base_url();?>uploadreport/EditReport/<?php echo $job->test_id?>">View Case</a></li>
                                                            <?php }?>

                                                             <?php if($job->authorised == 'authorised' ){?>

                                                            <li>
                                                              <a class="AddtoArchive" href="javascript:;" value="<?php echo $job->test_id?>"> Move to archive </a>
                                                          </li>

                                                        <?php }?>

                                                           <?php /*foreach($job->multipleUploads as $file){  $file_name = explode('/', $file->upload_file);?>
                                                                  <li>
                                                                    <a target="_blank" href="<?php echo base_url().$file->upload_file ;?>"> <?php echo $file_name[2];?> </a>
                                                                  </li>
                                                            <?php }*/?>
                                                          </ul>
                                                    </div>

                                                    <?php /*if(!empty($job->viewReport)){  
                                                           if($job->authorised == 'authorised'){?>
                                                                <a class="btn btn-outline-danger btn-theme" href="<?php echo base_url();?>uploadreport/EditReport/<?php echo $job->test_id?>">
                                                                    View Report
                                                                </a>
                                                            <?php
                                                        }else{?>
                                                                <a class="btn btn-outline-danger btn-theme" href="<?php echo base_url();?>uploadreport/EditReport/<?php echo $job->test_id?>">
                                                                    Edit Report
                                                                </a>
                                                            <?php
                                                        }
                                                      }else{ ?>
                                                         <a class="btn btn-outline-danger btn-theme" href="<?php echo base_url();?>uploadreport/AddPatientReport/<?php echo $job->test_id?>">View Case</a>

                                                    <?php  }*/?>

                                                   </td>
                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a class="profile_link" href="<?php echo base_url();?>user/PatientDetails/<?php echo $job->patient_id?>"> 
                                                  <?php echo $job->patient_name." ".$job->last_name ;?> </a>
                                                  <br /><small> DOB: <?php $date=date_create($job->DateOfBirth); echo date_format($date,$dateFormat); ?> </td>

                                                <td>
												
												                              <?php if($autoAccept == 1 && $job->primary_status == 0){?>
                                                             <strong class='text-danger status-box'><a href="<?php echo base_url();?>doctor/viewTestDetails/<?php echo $job->test_id?>" style="text-decoration:underline">View and Start</a></strong>
                                                      <?php
                                                        }elseif(!empty($job->primary_doctor_id) && $job->primary_status == 0){?>
                                                             <strong class='text-danger status-box'><a href="<?php echo base_url();?>doctor/viewTestDetails/<?php echo $job->test_id?>" style="text-decoration:underline">View and Approve</a></strong>
                                                      <?php
                                                        }elseif($job->authorised == 'authorised'){
                                                             echo "<strong class='text-success status-box'>Completed</strong>";
                                                        }elseif(!empty($job->primary_doctor_id) && $job->primary_status == 1 ){ 
                                                             echo "<strong class='text-success status-box'>Started - <a style='text-decoration:underline;color:#ae1a41' href='".base_url()."uploadreport/EditReport/".$job->test_id."'>Edit Report</a>  </strong>"; 
                                                        } ?>
                                                                    
                                                </td>

                                                <td><a class="profile_link" href="<?php echo base_url();?>hospital/HospitalDetails/<?php  echo $job->hospital_id ?>"> 
                                                    
                                                    <?php 

                                                      foreach($hospitals as $hospital){ 
                                                                    if($hospital->hospital_id == $job->hospital_id ){
                                                                        echo $hospital->hospital_name;
                                                                    }
                                                                }

                                                       ?></a>

                                                </td>

                                                 <td <?php if($job->box_received == 0 ){ ?> class="text-left" <?php  }?> id="check<?php echo $job->test_id?>">
                                                    <?php if($job->box_received == 0 ){ ?>
                                                        <div class="checkbox" >
                                                            <input id="checkbox1" type="checkbox" class="SetBoxReceived" value="<?php echo $job->test_id?>">
                                                            <label for="checkbox1"></label>
                                                        </div>
                                                    <?php }else{
                                                        echo "Slides Received";
                                                    }?>
                                                </td>

                                                <td><?php $date=date_create($job->test_date); echo date_format($date,$dateFormat); ?></td>
                                             
                                                
                                            </tr>

                                            
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--  end card  -->


                            <a href="<?php echo base_url();?>doctor/archive" class="btn btn-outline-danger btn-theme mb-4 btn-wd">Go to Archive</a> 
                            <!-- end col-md-12 -->

                          <?php }?>
                    
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

  if(selectedText == ""){ selectedText = "All"}
    
    $('.ButtonText').html(selectedText+' <b class="caret"></b>');

    if(selectedText == "All"){ $('.AllIcon').addClass('active') }else{ $('.AllIcon').removeClass('active') }
    if(selectedText == "Completed"){ $('.CompletedIcon').addClass('active') }else{ $('.CompletedIcon').removeClass('active') }
    if(selectedText == "View and Start"){ $('.AwaitingIcon').addClass('active') }else{ $('.AwaitingIcon').removeClass('active') }
    if(selectedText == "Started"){ $('.AcceptedIcon').addClass('active') }else{ $('.AcceptedIcon').removeClass('active') }
    if(selectedText == "Unassigned"){ $('.UnassignedIcon').addClass('active') }else{ $('.UnassignedIcon').removeClass('active') }

});
	</script>

    <script type="text/javascript">

        var $table = $('.my-table');

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
                    searchText: "<?php echo $_GET['name']?>",
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

     
<script>

     $(document).ready(function(){
      //$('.AddtoArchive').click(function(){ 
        $('body').on('click', '.AddtoArchive', function() {
          var postId = $(this).attr("value");

            $.ajax({url: "<?php echo base_url();?>doctor/AddtoArchive?Post_id="+postId, success: function(result){
                $("#"+postId).remove();                    
            } 
              
         });
    });

});

     $(document).ready(function(){
      //$('.SetBoxReceived').change(function(){ 
         $('body').on('change', '.SetBoxReceived', function() {
          var postId = $(this).attr("value");
            $.ajax({url: "<?php echo base_url();?>doctor/SetBoxReceived?test_id="+postId, success: function(result){
              $('#check'+postId).text('Slides Received');                  
             } 
            });
        });
    });



</script>

</html>
