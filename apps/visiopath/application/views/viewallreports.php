<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>View All Patient Reports - Lims</title>

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
          <div class="col-lg-3 col-md-6 col-sm-6 mt-3">
          
          </div>
          <div class="col-lg-5 col-md-6 col-sm-6">
             
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 mt-4">
           

          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
             

            <div class="col-lg-7 col-md-6 col-sm-6 pull-right mt-2">
                
            </div>
          </div>
        </div>

      

       
            <div class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <span class="text-theme  bootstrap-table">View All Reports</span>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table" class="table-striped">
                                        <thead>
                                            <th data-field="actions" class=" text-center" >Actions</th>
                                            <th data-field="id" data-sortable="true">Case ref</th>
                                            <th data-field="name" data-sortable="true">Patient Name </th>
                                            <th data-field="vp" data-sortable="true">Visiopath #</th>
                                            <th data-field="Hn" data-sortable="true">Hospital #</th>
											<th data-field="doctor" data-sortable="true">Doctor name</th>
                                            <th data-field="referring" data-sortable="true">Referring Institute</th>
                                            <th data-field="date" data-sortable="true">Date created</th>
                                            
                                        </thead>
                                        <tbody>

                                        <?php foreach($jobDetails as $job){  //print_r($job); exit;?>

                                            <tr id="<?php echo $job->test_id?>">
                                                <td>
                                                    <div class="">
                                                            <a title="View Report" class="btn btn-simple btn-info btn-icon table-action view" href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_id?>" ><i class="ti-eye"></i></a>

                                                            <a title="Print Report" target="_blank" class="btn btn-simple btn-warning btn-icon table-action edit" href="<?php echo base_url();?>report/view/<?php echo $job->test_id?>" data-original-title=""><i class="ti-printer"></i></a>
                                                    </div>
                                                </td>
                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a class="profile_link" href="<?php echo base_url();?>user/PatientDetails/<?php echo $job->patient_id?>">
                                                        <?php echo $job->patient_name." ".$job->last_name; ?> </a> 
                                                     <br /><small> DOB: <?php $date=date_create($job->DateOfBirth); echo date_format($date,$dateFormat); ?>
                                                </td>
                                                <td><?php echo $job->visiopath_number?> </td>
                                                  <td>  <?php echo $job->hospital_number ?></td>

                                                
												<td><a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo $job->doctor_id?>"> 
													   <?php echo 'Dr. '.$job->doctor_name ?></a></td>
                                                <td><a class="profile_link" href="<?php echo base_url();?>hospital/HospitalDetails/<?php echo $job->hospital_id?>"> <?php echo $job->hospital_name ?></a></td>
                                                <td><?php $date=date_create($job->test_date); echo date_format($date,$dateFormat); ?></td>
                                                
                                            </tr>

                                            <?php //print_r($job)?>
                                        
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
