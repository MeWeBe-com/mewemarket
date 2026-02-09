<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Show All Doctors - Lims</title>

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
            <a href="<?php echo base_url();?>admin/AddDoctor" class="btn btn-outline-danger login_btn">Add New Doctor</a>

           
          </div>
		 <div class="col-lg-2 col-md-6 col-sm-6 mt-3">
            <a href="<?php echo base_url();?>admin/exportDoctorUsers" class="btn btn-outline-danger login_btn">Export CSV</a>


           
          </div>
          <div class="col-lg-5 col-md-6 col-sm-6">
               <?php if(!empty($_GET['status'])){?>

                <?php if($_GET['status'] == "done"){?>
                <div class="alert alert-success mt-2 mb-0">
                    <span><b> Success - </b> New doctor has been added.</span>
                </div>
                <?php   
                }else{ ?>
                    <div class="alert alert-danger mt-2 mb-0">
                        <span><b> Fail - </b> There is Some problem Please try again</span>
                    </div>
                <?php }
            }?>
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
                                <div class="card-content"><span class="text-theme  bootstrap-table">Manage Doctors</span>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
									<?php if(isset($_GET['dataupdated'])){
												echo "<font color='green'>Data updated!</font><br>";
												}?>
                                    <table id="bootstrap-table" class="table-striped mytable" >
                                        <thead>
                                            <th data-field="action" >Action</th>
                                            <th data-field="id" data-sortable="true">Id</th>
                                            <th data-field="name" data-sortable="true">Doctor Name</th>
                                            <th data-field="email" data-sortable="true">Doctor Email </th>
                                            <th data-field="department" data-sortable="true">Department</th>
                                            <th data-field="mobile" data-sortable="true">Mobile Number</th>
                                            
                                             
                                        </thead>
                                        <tbody>



                                        <?php 
										
										foreach($doctors as $doctor){ ?>

                                            <tr id="<?php echo $doctor->doctor_id?>">
                                                <td> 

                                                    <div class="dropdown action-box">
                                                        
                                                          <ul class="dropdown-menu action-menu">

                                                            <li>
                                                              <a href="<?php echo base_url();?>admin/EditDoctor/<?php echo $doctor->doctor_id?>"> Edit </a>
                                                           </li>
                                                           <li>
                                                              <a onClick='return  confirm("By clicking this doctor will be deleted and all information will be lost.");'  href="<?php echo base_url();?>doctor/DeleteDoctorById/<?php echo $doctor->doctor_id?>" > Remove </a>
                                                           </li>
                                                           
                                                           
                                                           <?php 
                                                           $i = 0;
                                                           foreach($doctor->uploads as $uploads){
                                                           $i++;
                                                           ?>
                                                               <li>
                                                                  <a target="_blank" href="<?php echo base_url();?><?php echo $uploads->filename?>" >Doctor Document <?php echo $i?> </a>
                                                               </li>
                                                           <?php }?>
                                                          </ul>

                                                          
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo $doctor->doctor_id?>
                                                </td>
                                                <td><?php echo 'Dr. '.$doctor->doctor_name?></td>
                                                <td> <?php echo $doctor->email?> </td>
                                                <td><?php echo $doctor->department?></td>
                                                <td><?php echo $doctor->mobile_number?></td>
                                                
												
												
													
													
                                                <?php /*?><td class="td-actions text-center" style="">
                                                    <div class="table-icons">
                                                       
                                                        <a title="Edit" class="btn btn-simple btn-warning btn-icon table-action edit" href="<?php echo base_url();?>admin/EditDoctor/<?php echo $doctor->doctor_id?>"><i class="ti-pencil-alt"></i></a>

                                                        <a title="Remove" onClick='return  confirm("By clicking this doctor will be deleted and all information will be lost.");' class="btn btn-simple btn-danger btn-icon table-action remove" href="<?php echo base_url();?>doctor/DeleteDoctorById/<?php echo $doctor->doctor_id?>" ><i class="ti-close"></i></a></div></td><?php */?>
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
