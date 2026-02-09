<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Search User - Lims</title>

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
           
          </div>
          <div class="col-lg-5 col-md-6 col-sm-6 mt-3">
          
         

             </div>
          <div class="col-lg-2 col-md-6 col-sm-6 mt-4">
            

          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
             <div class="col-lg-5 col-md-6 col-sm-6 pull-left mt-4">  
              
            </div>

            <div class="col-lg-7 col-md-6 col-sm-6 pull-right mt-2">
               
            </div>

          </div>

           <div class="col-lg-10">
              <?php if(!empty($_GET['status'])){?>

                <?php if($_GET['status'] == "done"){?>
                <div class="alert alert-success mt-1">
                    <span><b> Success - </b> user password has been changed.</span>
                </div>
                <?php   
                }else{ ?>
                    <div class="alert alert-danger mt-1">
                        <span><b> Fail - </b> There is Some problem Please try again</span>
                    </div>
                <?php }
            }?>
          </div>
        </div>

       
            <div class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <span class="text-theme  bootstrap-table">Search User</span>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table" class="table-striped mytable">
                                       <thead>
                                          
                                            <th data-field="id" >Id</th>
                                            <th data-field="username" data-sortable="true">Username</th>
                                            <th data-field="Role" data-sortable="true">Role </th>
                                            <th data-field="Email" data-sortable="true">Email</th>
                                            <th data-field="Mobile Number" data-sortable="true">Mobile Number</th>
                                            <th data-field="actions" class="td-actions text-right" >Actions</th>
                                        </thead>
                                        <tbody>

                                        <?php foreach($AllUser as $job){ ?>

                                            <tr >
                                                <td>
                                                    <?php echo $job->id?>
                                                </td>

                                                <td><?php echo $job->first_name?> <?php echo $job->last_name?></td>
                                                <td>
                                                    
                                                    <?php 
													if($job->roleId == 1){
                                                      echo "Admin";
                                                    }elseif($job->roleId == 2){
                                                      echo "Doctor";
                                                    }else{
                                                      echo "Hospital";
                                                    }?>


                                                </td>
                                                <td><?php echo $job->email?></td>
                                                <td>
                                                   <?php echo $job->mobile_number ?>
                                                 </td>
                                                <td>
												 <a title="Send Message" class="btn btn-simple btn-success btn-icon table-action " href="<?php echo base_url()?>messages/AddMessage?id=<?php echo $job->id?>&name=<?php echo $job->first_name?>"><i class="ti-email"></i></a>
												<?php if($job->roleId == 1){?>
												<?php /*?><a title="Edit" class="btn btn-simple btn-warning btn-icon table-action edit" href="<?php echo base_url()?>admin/ChangeUserPassword/<?php echo $job->id?>"><i class="ti-pencil-alt"></i></a><?php */?>
												<?php }elseif($job->roleId == 2){?>
                                                   <a title="Edit" class="btn btn-simple btn-warning btn-icon table-action edit" href="<?php echo base_url()?>admin/editDoctor/<?php echo $job->doctor_id?>"><i class="ti-pencil-alt"></i></a>
												 <?php }elseif($job->roleId == 3){?>
                                                    <a title="Edit" class="btn btn-simple btn-warning btn-icon table-action edit" href="<?php echo base_url()?>admin/EditHospital/<?php echo $job->hospital_id?>"><i class="ti-pencil-alt"></i></a>
                                                  <?php }?>
                                                 
                                                </td>
                                                 
                                            </tr>
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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


 $(document).ready(function(){
   $('.AddtoArchive').change(function(){ 

        if($(this).is(":checked")){
            var postId = $(this).val();
}           
            $.ajax({url: "<?php echo base_url();?>admin/AddtoArchive?Post_id="+postId, success: function(result){
                $("#"+postId).remove();                    
            } 

        });
     });
});

  $(document).ready(function(){
   $('.AddtoUrgent').change(function(){ 
        if($(this).is(":checked")){
            var postId = $(this).val();
}           
            $.ajax({url: "<?php echo base_url();?>doctor/AddtoUrgent?Post_id="+postId, success: function(result){
                $("#"+postId).remove(); 
                location.reload();                   
            } 

        });
     });
});

  $(document).ready(function(){
   $('.RemovetoUrgent').change(function(){ 
        if($(this).is(":unchecked")){
            var postId = $(this).val();
}           
            $.ajax({url: "<?php echo base_url();?>doctor/RemovetoUrgent?Post_id="+postId, success: function(result){
                $("#"+postId).remove();
                location.reload();                    
            } 

        });
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
