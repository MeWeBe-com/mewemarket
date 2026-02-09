<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Hospital Invoice - Lims</title>

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
          <?php /*?><div class="col-lg-2 col-md-6 col-sm-6">
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
          </div><?php */?>
        </div>

      

       
            <div class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="card">
                                          
                                            <div class="card-content">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <div class="icon-big icon-warning text-center">

                                                            <i class="ti-money"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-9">
                                                        <div class="numbers">
                                                            <p>Total value</p>

                                                            
                                                            <?php  if(empty($TotalValue)){ echo '0';}else{ echo number_format($TotalValue); } ?>

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
                                                        <div class="icon-big icon-warning text-center">

                                                            <i class="ti-money"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-9">
                                                        <div class="numbers">
                                                            <p>Total Paid</p>

                                                            
                                                            <?php  if(empty($PaidValue)){ echo '0';}else{ echo number_format($PaidValue) ;} ?>

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
                                                        <div class="icon-big icon-warning text-center">

                                                            <i class="ti-money"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-9">
                                                        <div class="numbers">
                                                            <p>Total Unpaid</p>

                                                            
                                                            <?php  if(empty($UnPaidValue)){ echo '0';}else{ echo number_format($UnPaidValue)  ;} ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <form method='get'>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Start date:</label>
                                                <input type="date" name="startdate" class="form-control border-input">
                                            </div>
                                        </div>
                                         <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>End date:</label>
                                                <input type="date" name="enddate" class="form-control border-input">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <br />
                                                <input type="submit" value="submit" class="mt-2 btn btn-outline-danger btn-theme">

                                                <a href="<?php echo base_url();?>admin/hospitalInvoice" class="mt-2 btn btn-outline-danger btn-theme">Reset</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> 
                            <div class="card">
                                <div class="card-content">
                                    <span class="text-theme  bootstrap-table">Institute Invoices</span>
                                    <div class="toolbar">
                                        <!--Here you can write extra buttons/actions for the toolbar-->
                                    </div> 
                                    <table id="bootstrap-table" class="table-striped mytable">
                                        <thead> 
                                            <th data-field="Invoice" class=" text-left" >Action</th> 
                                            <th data-field="paid" data-sortable="true" class=" text-left" >Paid</th>
											                      
											
                                            <th data-field="id" data-sortable="true">Case ref</th>
                                            <th data-field="name" data-sortable="true">Patient Name </th>
                                            <th data-field="vp" data-sortable="true">Visiopath #</th>
                                            <th data-field="doctor" data-sortable="true">Doctor Name</th>
                                            <th data-field="referring" data-sortable="true">Referring Institute</th>
                                            <th data-field="amount" data-sortable="true">Amount</th>
                                            <th data-field="date" data-sortable="true">Invoice Date</th>
                                            
                                        </thead>
                                        <tbody>



                                        <?php foreach($jobDetails as $job){?>

                                            <tr id="<?php echo $job->test_id?>">
                                                <td>

                                                 <!-- <a   class="btn btn-outline-danger btn-theme" href="<?php echo base_url();?>hospital/viewInvoice/<?php echo $job->test_id?>">
                                                  View Invoice
                                                </a>-->

                                                 <div class="dropdown action-box">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu action-menu">
                                                            <?php if($job->hospital_sent == 0){?>
                                                                <li>
                                                                    <a href="<?php echo base_url();?>admin/sendInvoiceHospital/<?php echo $job->test_id?>"> Send Invoice </a>
                                                                </li>
                                                         <?php }?>

                                                                <li>
                                                                    <a target="_blank" href="<?php echo base_url();?>hospital/viewInvoice/<?php echo $job->test_id?>"> View Invoice </a>
                                                                </li>

                                                          </ul>
                                                    </div>

                                                </td>
											<td class="text-center">
											
											<?php 
											 //print_r($job);
											if($job->hospital_paid == 1){?>
											     <div class="checkbox ">
                                                    <input id="checkbox1" type="checkbox" class="unpayInvoice" checked value="<?php echo $job->test_id?>">
                                                    <label for="checkbox1">
                                                    </label>
                                                </div>

											<?php }elseif($job->hospital_sent == 1){?>
												
                                                <div class="checkbox ">
                                                    <input id="checkbox1" type="checkbox" class="payInvoice" value="<?php echo $job->test_id?>">
                                                    <label for="checkbox1">
                                                    </label>
                                                </div>

											
											<?php }?>
												</td>
												
												
                                                <td><a  class="profile_link" href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_id?>"><?php echo $job->Client_case_number?></a></td>
                                                <td><a  class="profile_link" href="<?php echo base_url();?>user/PatientDetails/<?php echo $job->patient_id?>"><?php echo $job->patient_name?> <?php echo $job->last_name?></a>  <br /><small> DOB: <?php $date=date_create($job->DateOfBirth); echo date_format($date,$dateFormat); ?></td>
                                                <td><?php echo $job->visiopath_number?> </td>
                                                
                                                 <td><a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo $job->doctor_id?>"> <?php echo 'Dr. '.$job->doctor_name;?></a></td>
                                                <td><a class="profile_link" href="<?php echo base_url();?>hospital/HospitalDetails/<?php echo $job->hospital_id?>">
                                                    <?php echo $job->hospital_name;?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($job->specimen_fee)){ echo "£".$job->specimen_fee ;}else{ echo 'N/A' ;}?>
                                                </td>
                                                <td><?php $date=date_create($job->invoice_date); echo date_format($date,$dateFormat); ?></td>
                                                
                                                
                                            </tr>

                                            <?php //print_r($job)?>
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--  end card  -->

                            <?php if(!empty($this->input->get('startdate'))){
                                $startdate = '?startdate='.$this->input->get('startdate');
                            }else{
                                $startdate ='';
                            }?>

                             <?php if(!empty($this->input->get('enddate'))){
                                $enddate = '&enddate='.$this->input->get('enddate');
                            }else{
                                $enddate ='';
                            }?>

                             <a href="<?php echo base_url();?>admin/AllHospitalInvoiceexport<?php echo $startdate.$enddate; ?>" class="btn btn-outline-danger btn-theme mb-5 btn-wd">Export Invoice CSV</a>
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
  // $('.payInvoice').change(function(){
    $('body').on('change', '.payInvoice', function() {  
        if($(this).is(":checked")){
            var postId = $(this).val();
}           

            var retVal = confirm("By clicking Paid - An email will be sent to confirm that this Invoice has been paid");
               if( retVal == true ) {
                   $.ajax({url: "<?php echo base_url();?>admin/payInvoiceHospital/"+postId, success: function(result){
                        location.reload();                    
                    } 

                    });
               } else {
                  $(this).prop('checked', false);
               }

           
     });
});

 $(document).ready(function(){
   //$('.unpayInvoice').change(function(){
    $('body').on('change', '.unpayInvoice', function() {  
        if($(this).is(":unchecked")){
            var postId = $(this).val();
}           

           // var retVal = confirm("By clicking Paid - An email will be sent to confirm that this Invoice has been paid");
              // if( retVal == true ) {
                   $.ajax({url: "<?php echo base_url();?>admin/UnpayInvoiceHospital/"+postId, success: function(result){
                        location.reload();                    
                    } 

                    });
              // } else {
                  
             //  }

           
     });
});
        
</script>

</html>
