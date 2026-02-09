<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Invoice - Lims</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

<?php include('partial/head.php'); ?>

</head>

<body>
	<div class="wrapper">
	      <?php include('partial/sidebar.php') ?>

	    <div class="main-panel">
			<?php include('partial/nav.php') ?>

	        <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table" class="table">
                                        <thead class="text-theme" >
                                           
                                            <th  data-field="id" data-sortable="true">CASE REF.</th>
                                            <th data-field="name" data-sortable="true">PATIENT NAME </th>
                                            <th data-field="date" data-sortable="true">DATE</th>
                                            <th data-field="typeoftest" >TYPE OF TEST</th>
                                            <th data-field="clinic" data-sortable="true">REFERRING CLINIC</th>
                                            <th data-field="doctor" data-sortable="true">DOCTOR</th>
                                            <th data-field="View" data-sortable="true">VIEW</th>
                                        </thead>
                                        <tbody>
                                      
                                      <?php //print_r($jobDetails) ;?>
                                      <?php foreach($jobDetails as $jobDetail){ ?>
                                            <tr>
                                               
                                                <td><?php echo $jobDetail->Client_case_number ?></td>
                                                <td><?php echo $jobDetail->patient_name ?></td>
                                                <td><?php echo $jobDetail->test_date ?></td>
                                                <td><?php 

              foreach($testTypes as $test){ 
                            if($test->TestTypeId == $jobDetail->specimen ){
                                echo $test->TestTypeName;
                            }
                        }

               ?></td>
                                                <td><?php foreach($hospitals as $hospital){ 
                                                      if($hospital->hospital_id == $jobDetail->hospital_id ){
                                                          echo $hospital->hospital_name;
                                                      }
                                                  } ?>  </td>
                                                                                <td><?php  foreach($doctors as $doctor){ 
                                                if($jobDetail->doctor_id == $doctor->doctor_id ){
                                                    echo $doctor->doctor_name;
                                                }
                                            } ?></td>
                                                 <td><a href="#" class="btn btn-outline-danger btn-theme" data-toggle="modal" data-target="#exampleModalCenter<?php echo $jobDetail->test_id ?>">View Invoice</a></td>
                                            </tr>

                                            <div class="modal fade" id="exampleModalCenter<?php echo $jobDetail->test_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" id="print2">
      <div class="modal-header">
        <h5 class="modal-title d-inline-block" id="exampleModalLongTitle">INVOICE #<?php echo $jobDetail->Client_case_number ?> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="row  pb-3">
         <div class="col-md-6">
           <small class="d-block">Job no.</small>
           <span><?php echo $jobDetail->Client_case_number ?></span>
         </div>

         <div class="col-md-6">
           <small class="d-block">Invoice Total </small>
           <span>£ <?php echo $jobDetail->amount ?></span>
         </div>
       </div>

        <div class="row  pb-3">
         <div class="col-md-6 ">
           <small class="d-block">Name of Doctor</small>
           <span><?php 

            foreach($doctors as $doctor){ 
                if($jobDetail->doctor_id == $doctor->doctor_id ){
                    echo $doctor->doctor_name;
                }
            }

           ?>
             

           </span>
         </div>

         <div class="col-md-6 ">
           <small class="d-block">Invoice date </small>
           <span> <?php echo $jobDetail->invoice_date ?></span>
         </div>
       </div>

       <div class="row  pb-3">
         <div class="col-md-6 ">
           <small class="d-block">Name of Patient</small>
           <span>Mr <?php echo $jobDetail->patient_name ?></span>
         </div>

         <div class="col-md-6 ">
           <small class="d-block">Invoice to </small>
           <span>

             <?php  

                   foreach($hospitals as $hospital){ 
                      if($hospital->hospital_id == $jobDetail->hospital_id ){
                          echo $hospital->hospital_name;
                      }
                  }

                                                     ?> 

           </span>
         </div>
       </div>

        <div class="row  pb-3">
         <div class="col-md-6 ">
           <small class="d-block">Type of Test</small>
           <span>
             
             <?php 

              foreach($testTypes as $test){ 
                            if($test->TestTypeId == $jobDetail->specimen ){
                                echo $test->TestTypeName;
                            }
                        }

               ?>
           </span>
         </div>

         <div class="col-md-6 ">
           <small class="d-block">Date sent </small>
           <span> <?php echo $jobDetail->test_date ?> </span>
         </div>
       </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-theme">DOWNLOAD</button>

        <input type="button" class="btn btn-theme" name="printbutton" value="Print" onclick="return print1('print2')"/>

        <button type="button" class="btn btn-theme">Resend</button>
      </div>
    </div>
  </div>
</div>
               <?php }?>                           
                                            
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--  end card  -->
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
                    showToggle: false,
                    showColumns: true,
                    pagination: true,
                    searchAlign: 'left',
                    pageSize: 8,
                    clickToSelect: false,
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

</html>
