<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
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
           <h3>Search User</h3> 
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
        </div>

      

       
            <div class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">

                                    
                                    <form method="post" action="<?php echo base_url()?>admin/changethisuserpassword/<?php echo $user_id?>">
                                        
                                      <div class="form-group">
                                        <label>Enter new password :</label>
                                        <input type="text" class="form-control border-input" placeholder="New Password" name="newpassword" >

                                      </div>

                                      <div class="text-center">
                                        <input class="btn btn-info btn-fill btn-wd" type="submit" name="submit" value="Change Password">
                                        </div>

                                    </form>
                                   
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
