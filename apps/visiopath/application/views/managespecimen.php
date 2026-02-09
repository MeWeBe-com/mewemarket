<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Show All Test Type - Lims</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

<?php include('partial/head.php'); ?>

</head>

<body>
	<div class="wrapper">
	  <?php if(!isset($_GET['appview'])){?>  <?php include('partial/sidebar.php') ?> <?php }?>

	    <div class="main-panel">
			<?php include('partial/nav.php') ?>

      

	        <div class="container-fluid ">
          <div class="col-lg-2 col-md-6 col-sm-6 mt-3">
            <a href="<?php echo base_url();?>admin/AddTestType" class="btn btn-outline-danger login_btn">Add specimen</a>


           
          </div>
		  <?php /*?><div class="col-lg-2 col-md-6 col-sm-6 mt-3">
            <a href="<?php echo base_url();?>admin/exportAdminUsers" class="btn btn-outline-danger login_btn">Export CSV</a>


           
          </div><?php */?>
          <div class="col-lg-5 col-md-6 col-sm-6">

                <?php if($_GET['status'] == "done"){?>
                <div class="alert alert-success mt-1">
                    <span><b> Success - </b> New Test Type has been added.</span>
                </div>
				
				
                <?php   
                }
				 if(isset($_GET['datadeleted'])){?>
                <div class="alert alert-warning  mt-1">
                    <span><b> Success - </b>Test Type has been deleted.</span>
                </div>
				
				<?php   
                }
				 if(isset($_GET['dataupdated'])){?>
                <div class="alert alert-success  mt-1">
                    <span><b> Success - </b>Test Type Updated.</span>
                </div>
				
				<?php }?>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 mt-4">
            

          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
             <div class="col-lg-5 col-md-6 col-sm-6 pull-left mt-4">  
             
            </div>

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
                                    <span class="text-theme  bootstrap-table">Manage Specimen</span>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table" class="table-striped" >
                                        <thead>
                                             <th data-field="Action" >Action </th>
                                            <th data-field="id" >ID</th>
                                            <th data-field="name" data-sortable="true">Specimen Name</th>
                                            <th data-field="fname" data-sortable="true">Short Name </th>
                                            
                                        </thead>
                                        <tbody>



                                        <?php foreach($admins as $admin){ ?>

                                            <tr id="<?php echo $admin->TestTypeId?>">
                                                <td>
                                                    <div class="table-icons">
                                                       

                                                        <a rel="tooltip" title="Edit" class="btn btn-simple btn-warning btn-icon table-action edit" href="<?php echo base_url();?>admin/editTestType/<?php echo $admin->TestTypeId?>"><i class="ti-pencil-alt"></i></a>

                                                        <a rel="tooltip" title="Remove" onClick='return  confirm("By clicking this specimen will be deleted and all information will be lost.");' class="btn btn-simple btn-danger btn-icon table-action remove" href="<?php echo base_url();?>admin/deleteTestType/<?php echo $admin->TestTypeId?>"><i class="ti-close"></i></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo $admin->TestTypeId?>
                                                </td>
                                                <td><?php echo $admin->TestTypeName?></td>
                                                <td> <?php echo $admin->shortName?> </td>
                                               
                                                 
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
   


        
</script>

</html>
