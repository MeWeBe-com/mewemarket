<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Dashboard - Lims</title>

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
          <div class="col-lg-3 col-md-6 col-sm-6 mt-3">
            <a href="<?php echo base_url();?>admin/addJob" class="btn btn-outline-danger login_btn">Add Job</a>

             <a href="<?php echo base_url();?>admin/addJob" class="btn btn-outline-danger login_btn">Add Existing Job</a>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            
          </div>
        </div>

            <div class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table" class="table-striped">
                                        <thead>
                                            <th data-field="id" >ID</th>
                                            <th data-field="id" >CASE REF.</th>
                                            <th data-field="name" >PATIENT NAME </th>
                                            <th data-field="salary" >GENDER</th>
                                            <th data-field="clinic" >DATE OF BIRTH</th>
                                            <th data-field="Status" >MOBILE NUMBER</th>
                                            <th data-field="actions" class="td-actions text-right" >ACTIONS</th>
                                        </thead>
                                        <tbody>

                                        <?php foreach($patients as $patient){ ?>

                                            <tr>
                                                <td><?php echo $patient->patient_id?></td>
                                                <td><?php echo $patient->Client_case_number?></td>
                                                <td><?php echo $patient->patient_name?></a></td>
                                                <td><?php echo $patient->gender?></td>
                                                <td><?php echo $patient->DateOfBirth?> </td>
                                                <td><?php echo $patient->mobile_number?> </td>
                                                <td><a class="btn btn-outline-danger btn-theme" href="<?php echo base_url();?>admin/AddExistingjob/<?php echo $patient->patient_id?>">Add Existing Job</a></td>
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
