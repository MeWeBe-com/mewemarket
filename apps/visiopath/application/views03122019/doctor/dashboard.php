

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
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

      

	        <div class="container-fluid mt-3">
          <div class="col-lg-4 col-md-6 col-sm-6 ">
            <h3>Live Dashboard</h3>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
             
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 mt-4">
            <a href="<?php echo base_url();?>doctor/archive" class="text-theme">Go to Archive</a> 

          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
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

                        <div class="col-md-12">
                            <div class="">
                        <div class="row">
                    <div class="col-lg-4 col-sm-6">
                       <a href="<?php echo base_url();?>doctor/AwaitingApproval">
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
                                            <p>Awaiting approval</p>

                                            <?php 
                                            $i = 0;
                                            foreach($jobDetails as $job){

                                                if(empty($job->doctor_approval)){
                                                    $i++;
                                                }

                                                }?>

                                            <a style="color: #252422;" href="<?php echo base_url();?>doctor/AwaitingApproval"><?php echo $i; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div></a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
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
                                            <p>Awaiting report</p>
                                             <?php echo $awaitingReport?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="card"> 
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-pencil"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Awaiting report <sup> More then Week </sup></p>

                                            <?php echo $Overdues?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="card"> 
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-pencil"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Awaiting report <sup> More then 2 Week </sup></p>

                                            <?php echo $Abovetheweek?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="card"> 
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-pencil"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Awaiting report <sup> More then 3 Week </sup></p>

                                            <?php echo $Abovethetwoweek?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>


                    <div class="col-lg-4 col-sm-6">
                        <a style="color: #252422;" href="<?php echo base_url()?>uploadreport/AlreadySysponis"><div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-info text-center">
                                            <i class="ti-harddrives"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Complete this month</p>
                                            
                                            <?php echo $CompletedJob[0]->completed?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div></a>  
                    </div>
                </div>
                        </div> 


                            <div class="card">
                               <div class="card-content"> <h3>Routine Cases</h3>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table" class="table-striped my-table">
                                        <thead>
                                            <th data-field="Archive" >Archive</th>
                                            
                                            <th data-field="id" data-sortable="true">Case Ref.</th>
                                            <th data-field="name" data-sortable="true">Patient Name </th>
                                            <th data-field="specimen" data-sortable="true">Specimen</th>
                                            <th data-field="referring" data-sortable="true">referring Institution</th>
                                            <th data-field="date" data-sortable="true">Date Created</th>
                                            <th data-field="actions" class="td-actions text-right" >Action</th>
                                        </thead>
                                        <tbody>

                                        <?php foreach($jobDetails as $job){ //print_r($job);?>

                                            <tr id="<?php echo $job->test_id?>">
                                                <td>
                                                    <input class="AddtoArchive" value="<?php echo $job->test_id?>" type="checkbox">
                                                </td>

                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a href="<?php echo base_url();?>user/PatientDetails/<?php echo $job->test_id?>"> <?php echo $job->patient_name?> </a> </td>
                                                <td>
                                                    <?php 

                                                      foreach($testTypes as $test){ 
                                                                    if($test->TestTypeId == $job->specimen ){
                                                                        echo $test->TestTypeName;
                                                                    }
                                                                }

                                                       ?>
                                                </td>
                                                <td>
                                                    
                                                    <?php 

                                                      foreach($hospitals as $hospital){ 
                                                                    if($hospital->hospital_id == $job->hospital_id ){
                                                                        echo $hospital->hospital_name;
                                                                    }
                                                                }

                                                       ?>

                                                </td>
                                                <td><?php echo $job->test_date?>
                                                <td>

                                                     <div class="dropdown">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu"><?php if(!empty($job->viewReport)){
                                                            ?>  
                                                                <li> 
                                                                 <a href="<?php echo base_url();?>uploadreport/EditReport/<?php echo $job->test_id?>">
                                                                    Edit Report
                                                                </a></li> 
                                                          
                                                               <li>  <a  href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_id?>"  >
                                                                    View Report
                                                                </a></li>
                                                            <?php 
                                                        }else{?>
                                                              <li> <a href="<?php echo base_url();?>uploadreport/AddPatientReport/<?php echo $job->test_id?>">View Case</a></li>
                                                            <?php }?>
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
                                            </tr>

                                            
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--  end card  -->

                            <div class="card">
                               <div class="card-content bg-red"> <h3>Urgent Cases</h3>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table2" class="urgent table-striped my-table">
                                        <thead>
                                            <th data-field="Archive" >Archive</th>
                                            
                                            <th data-field="id" data-sortable="true">Case Ref.</th>
                                            <th data-field="name" data-sortable="true">Patient Name </th>
                                            <th data-field="specimen" data-sortable="true">Specimen</th>

                                            <th data-field="referring" data-sortable="true">referring Institution</th>
                                            <th data-field="date" data-sortable="true">Date Created</th>
                                            <th data-field="actions" class="td-actions text-right" >Action</th>
                                        </thead>
                                        <tbody>

                                        <?php foreach($urgentDetails as $job){ //print_r($job);?>

                                            <tr id="<?php echo $job->test_id?>">
                                                <td>
                                                    <input class="AddtoArchive" value="<?php echo $job->test_id?>" type="checkbox">
                                                </td>

                                                

                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a href="<?php echo base_url();?>user/PatientDetails/<?php echo $job->test_id?>"> <?php echo $job->patient_name?> </a> </td>
                                                <td>
                                                    <?php 

                                                      foreach($testTypes as $test){ 
                                                                    if($test->TestTypeId == $job->specimen ){
                                                                        echo $test->TestTypeName;
                                                                    }
                                                                }

                                                       ?>
                                                </td>
                                                 <td>
                                                    
                                                    <?php 

                                                      foreach($hospitals as $hospital){ 
                                                                    if($hospital->hospital_id == $job->hospital_id ){
                                                                        echo $hospital->hospital_name;
                                                                    }
                                                                }

                                                       ?>

                                                </td>
                                                <td><?php echo $job->test_date?>
                                                <td> 
                                                    <div class="dropdown">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu"><?php if(!empty($job->viewReport)){
                                                            ?>  
                                                                <li> 
                                                                 <a href="<?php echo base_url();?>uploadreport/EditReport/<?php echo $job->test_id?>">
                                                                    Edit Report
                                                                </a></li> 
                                                          
                                                               <li>  <a  href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_id?>"  >
                                                                    View Report
                                                                </a></li>
                                                            <?php 
                                                        }else{?>
                                                              <li> <a href="<?php echo base_url();?>uploadreport/AddPatientReport/<?php echo $job->test_id?>">View Case</a></li>
                                                            <?php }?>
                                                          </ul>
                                                    </div></td>
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
            $.ajax({url: "<?php echo base_url();?>admin/assignDoctortopatient?doctor_id="+cur_value, success: function(result){
             location.reload();
            //$('.assigndoctor').html("Hello <b>world!</b>");

        }});
     });
});


 $(document).ready(function(){
   $('.AddtoArchive').change(function(){ 
        if($(this).is(":checked")){
            var postId = $(this).val();
}           
            $.ajax({url: "<?php echo base_url();?>doctor/AddtoArchive?Post_id="+postId, success: function(result){
                $("#"+postId).remove();                    
            } 

        });
     });
});


 

        
</script>

</html>
