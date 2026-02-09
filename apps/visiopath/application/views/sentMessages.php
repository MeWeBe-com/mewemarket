<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Messages - Lims</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

<?php include('partial/head.php'); ?>

</head>

<body>
	<div class="wrapper">
	      <?php include('partial/sidebar.php') ?>

	    <div class="main-panel">
			<?php include('partial/nav.php') ?>

	        <div class="content pt-3">

              <div class="row">
          <div class="col-lg-2 col-md-6 col-sm-6">
            
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
           
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
           
          </div>
          <div class="col-lg-12 col-md-6 col-sm-6">

            <div class="col-lg-6 col-md-6 col-sm-6 pull-left ">  
              <a href="<?php echo base_url()?>messages" class="btn btn-outline-danger btn-theme login_btn btn-wd">Inbox</a>

              <a href="javascript:;" class="btn btn-outline-danger btn-theme login_btn active btn-wd">Sent</a>
            </div>

          <div class="col-lg-6 col-md-6 col-sm-6 pull-right text-right">
           <!--   <a href="javascript:;" class="btn btn-outline-danger btn-theme login_btn">Mark as read</a>

              <a href="javascript:;" class="btn btn-outline-danger btn-theme login_btn">Delete</a>-->
          </div>


        </div>
      </div>
                <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <span class="text-theme  bootstrap-table">Sent Messages</span>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table" class="table">
                                        <thead  >
                                          <!-- <th data-field="state" data-checkbox="true"></th>-->
                                            <th data-field="date" data-sortable="true">Date </th>
                                            <th data-field="from" data-sortable="true">To </th>
                                            <th data-field="title" data-sortable="true">Title</th>
                                            <th data-field="time" >Time</th>
                                          </thead>
                                        <tbody>
                                           

                                           <?php foreach($messages as $message){ 
                                            $date = date_create($message->message_time);?>
                                                <tr>
                                                   <!-- <td></td>-->
                                                    <td><?php echo date_format($date,$dateFormat)?></td>
                                                    <td>

                                                    <?php 
													$message->first_name;
                                                         /*foreach($AllUsers as $user){ 
                                                            if($user->id == $message->receiver_id){
                                                                echo $user->username ;
                                                            }
                                                        }*/
                                                    ?>

                                                    </td>
                                                    <td>
                                                      <a class="theme-color" href="<?php echo base_url();?>messages/ShowMessage/<?php echo $message->message_id?>">
                                                       
                                                             <?php echo $message->title ?> 
                                                       
                                                      </a> 
                                                    </td>
                                                    <td> <?php echo date_format($date,"H:i:s")?> </td>
                                                </tr>

                                         <?php } ?>
                                            
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
