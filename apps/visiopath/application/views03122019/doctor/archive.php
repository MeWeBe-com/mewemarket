<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Archive - Lims</title>

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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div>
                                    <table id="bootstrap-table" class="table-striped">
                                        <thead>
                                            <th data-field="archive" >ARCHIVE</th>
                                            <th data-field="id" data-sortable="true">CASE REF.</th>
                                            <th data-field="name" data-sortable="true">PATIENT NAME </th>
                                            <th data-field="date" data-sortable="true">DATE</th>
                                            <th data-field="clinic" data-sortable="true">REFERRING CLINIC</th>
                                            
                                        </thead>
                                        <tbody>

                                        <?php foreach($jobDetails as $job){ ?>

                                            <tr id="<?php echo $job->test_id?>">
                                             <td>
                                                    <input class="RemoveFromArchive" value="<?php echo $job->test_id?>" type="checkbox" checked>
                                                </td>
                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><?php echo $job->patient_name?></td>
                                                <td><?php echo $job->test_date?></td>
                                                <td> <?php  

                                                    foreach($hospitals as $hospital){ 
                                                                if($hospital->hospital_id == $job->hospital_id ){
                                                                    echo $hospital->hospital_name;
                                                                }
                                                            }

                                                     ?>  </td>
                                               
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

      <script type="text/javascript">
   

    $(document).ready(function(){
   $('.RemoveFromArchive').change(function(){ 

        if($(this).is(":unchecked")){
            var postId = $(this).val();
}           
            $.ajax({url: "<?php echo base_url();?>doctor/RemoveFromArchive?Post_id="+postId, success: function(result){
                $("#"+postId).remove();                    
            } 

        });
     });
});


        
</script>

</html>
