<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Hospital Dashboard - Lims</title>

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
          <div class="col-lg-10 col-md-7 col-sm-6 pt-3"> 

            <?php if($this->session->userdata('First_Login') == 0 ){?>
              
                <div class="alert alert-warning col-lg-7 mb-3">
                    <span>Please go to your <a href="<?php echo base_url();?>setting/EditProfile/<?php echo $this->session->userdata('id');?>" class="theme-color">Profile page</a> to change your password.</span>
                </div><br /><br />
               <br />
                <div class="alert alert-warning col-lg-7 mb-2">
                    <span>To change your PIN go to your <a href="<?php echo base_url();?>setting/EditProfile/<?php echo $this->session->userdata('id');?>" class="theme-color">Profile Page</a>.</span>
                </div>

             
            <?php }?>
          </div>
          
          <div class="col-lg-2 col-md-5 col-sm-6 mt-3">
            <div class="pull-right ">
                <form>
                 <div class="dropdown">
                      <button href="#" class="btn btn-block dropdown-toggle btn-wd ButtonText" data-toggle="dropdown" aria-expanded="false">
                          Filter
                          <b class="caret"></b>
                      </button>
                      <ul class="dropdown-menu " id="dropdown-filter-menu">
                        <li class="AllIcon"><a href="#">All</a></li>
                        <li class="CompletedIcon"><a href="#">Completed</a></li>
                        <li class="AwaitingIcon"><a href="#">Awaiting Start</a></li>
                        <li class="InIcon"><a href="#">In Progress</a></li>
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

                          <div class="row">
                    <div class="col-lg-4 col-sm-6">
                       <a href="<?php echo base_url();?>hospital/ViewAll" >
                        <div class="card">
                          
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-warning text-center">

                                            <i class="ti-book"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Total Cases</p>

                                            <?php echo $TotalCases;  ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div></a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                         <a href="<?php echo base_url();?>hospital/ViewAll?Unassigned" >
                        <div class="card">

                           
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-success text-center">
                                            <i class="ti-folder"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Cases Unassigned</p>
                                             <?php echo $CasesUnassigned; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div></a>
                    </div>
                   
                    <div class="col-lg-4 col-sm-6">
                        <a style="color: #252422;" href="<?php echo base_url()?>hospital/ViewMyReport"><div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-info text-center">
                                            <i class="ti-harddrives"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Reports Available</p>
                                            
                                            <?php echo $ReportsAvailable?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div></a>  
                    </div>
                </div>
                            <div class="card">

                                <div class="card-content">
                                    <h3 class="text-theme  bootstrap-table">Routine Cases</h3>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table" class="table-striped my-table">
                                        <thead>
                                            <th data-field="status" >Actions</th>
                                            <th data-field="id" data-sortable="true">Case Ref </th>
                                            <th data-field="name" data-sortable="true">Patient Name </th>
                                            <th data-field="Status" data-sortable="true">Status</th>
                                            <th data-field="vp" data-sortable="true">Visiopath #</th>
											 <th data-field="doctor" data-sortable="true">Doctor name</th>
											
                                            
                                            <th data-field="date" data-sortable="true">Date created</th>
                                            
                                        </thead>
                                        <tbody>

                                        <?php foreach($jobDetails as $job){ //print_r($job);?>

                                            <tr id="<?php echo $job->primary_id?>">
                                                 <td >
                                                     <div class="dropdown action-box">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu action-menu">
                                                             <?php if($job->authorised == 1){?>
                                                                <li>
                                                                    <a href="<?php echo base_url()?>hospital/ViewReport/<?php echo $job->primary_id?>" value="<?php echo $job->primary_id?>"> View report </a>
                                                                </li>
                                                                <li>
                                                                     <a class="AddtoArchive" href="javascript:;" value="<?php echo $job->primary_id?>"> Move to archive </a>
                                                                </li>
                                                                
                                                            <?php }else{?>

                                                                 <li >
                                                                      <a href="<?php echo base_url();?>doctor/viewTestDetails/<?php echo $job->primary_id?>" >View details</a>
                                                                </li>

                                                           
                                                            <?php }?>
                                                             

                                                                
                                                          </ul>
                                                    </div>

                                                </td> 
                                               <td><?php echo $job->Client_case_number?></td>
                                                <td>
                                                    <a class="profile_link" href="<?php echo base_url();?>user/PatientDetails/<?php echo $job->patient_primary?>"><?php echo $job->patient_name?> <?php echo $job->last_name?></a> 
                                                    <br /><small> DOB: <?php $date=date_create($job->DateOfBirth); echo date_format($date,$dateFormat); ?>
                                                </td>
                                                <td> 
                                                    <?php
                                                        
                                                    
                                                        if($job->authorised == 1){ 
                                                            echo "<strong>Completed</strong>";
                                                        }elseif(empty($job->AssociateDoctors)){ 
                                                            echo "Unassigned" ;
                                                        }elseif(in_array('0', array_column($job->AssociateDoctors, 'status'))){ 
                                                             echo "Awaiting Start"; 
                                                        }elseif(in_array('1', array_column($job->AssociateDoctors, 'status'))){
                                                             echo "In Progress";
                                                           } ?>
                                                                    
                                                 </td>
                                                  <td><?php echo $job->visiopath_number ?><br>
                                                </td>
												<td>
												<?php /*if(empty($job->doctor_id)){ ?>
													Unassigned
												<?php }elseif(!empty($job->doctor_id) && empty($job->doctor_approval)){ ?>
													Awaiting Start
												<?php }else{?>
												<a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo $job->doctor_id?>"><?php echo 'Dr. '.$job->doctor_name?> 
												<?php }*/?>

                                                <?php if($job->authorised == 1){?>
                                                 <a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo $job->doctor_id?>"><?php echo 'Dr. '.$job->doctor_name?>
                                                <?php }elseif(empty($job->AssociateDoctors)){ ?>
                                                    Unassigned
                                                <?php }elseif(in_array('0', array_column($job->AssociateDoctors, 'status'))){ ?>
                                                    Awaiting Start
                                                <?php }else{

                                                    
                                                    foreach($job->AssociateDoctors as $doctors){ 
                                                        if($doctors['status'] == 1){ ?>
                                                             <a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo $doctors['doctor_id']?>"><?php echo 'Dr. '.$doctors['doctor_name']?> 
                                                    <?php  }break;
                                                    }
                                                    ?>
                                                <?php }?>
												</td>
                                                
                                               
                                                <td><?php $date=date_create($job->test_date); echo date_format($date,$dateFormat); ?></td>
                                                                                        
                                            </tr>
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--  end card  -->
                        </div> <!-- end col-md-12 -->

                    </div> <!-- end row -->
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

	 var $table = $('#bootstrap-table');
	var selectedText = $(this).text();
	if(selectedText == "All"){ selectedText = "";}
	$table.bootstrapTable('refreshOptions', {searchText:selectedText});

    if(selectedText == ""){ selectedText = "All"}
    
    $('.ButtonText').html(selectedText+' <b class="caret"></b>');

    if(selectedText == "All"){ $('.AllIcon').addClass('active') }else{ $('.AllIcon').removeClass('active') }
    if(selectedText == "Completed"){ $('.CompletedIcon').addClass('active') }else{ $('.CompletedIcon').removeClass('active') }
    if(selectedText == "Awaiting Start"){ $('.AwaitingIcon').addClass('active') }else{ $('.AwaitingIcon').removeClass('active') }
    if(selectedText == "In Progress"){ $('.InIcon').addClass('active') }else{ $('.InIcon').removeClass('active') }
    if(selectedText == "Unassigned"){ $('.UnassignedIcon').addClass('active') }else{ $('.UnassignedIcon').removeClass('active') }

});
	</script>

    <script type="text/javascript">

        var $table = $('#bootstrap-table');

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







 $(document).ready(function(){
   $('.AddtoArchive').click(function(){ 
            var postId = $(this).attr('value');
            $.ajax({url: "<?php echo base_url();?>hospital/AddtoArchive?Post_id="+postId, success: function(result){
                $("#"+postId).remove();                    
            } 

        });
     });
});



        
</script>

</html>
