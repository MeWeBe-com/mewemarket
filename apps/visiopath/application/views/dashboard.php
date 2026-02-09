<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
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

	        <div class="container-fluid ">
          <div class="col-lg-4 col-md-6 col-sm-6 mt-3">
            <a href="<?php echo base_url();?>admin/addJob" class="btn btn-outline-danger login_btn btn-wd">Add New Job</a>

            <a href="<?php echo base_url();?>admin/ChooseExistingPatient" class="btn btn-outline-danger login_btn btn-wd <?php if($this->agent->is_mobile()){ echo "pull-right"; }?>">Add <?php if($this->agent->is_mobile()){}else{echo 'From'; }?> Existing Job</a>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 mt-3">
          <?php if($this->session->userdata('user_type') != 1){?>

          <a class=' btn btn-outline-danger login_btn btn-wd' href="<?php echo base_url();?>admin/AddDoctor">Add doctor</a>

          <a class=' btn btn-outline-danger login_btn btn-wd <?php if($this->agent->is_mobile()){ echo "pull-right"; }?>' href="<?php echo base_url();?>admin/AddHospital">Add institute</a>
        <?php }?>
             </div>
         
          <div class="col-lg-4 col-md-6 col-sm-6 mt-3 text-right">
            <div class="">
                <form>
                 <div class="dropdown">
                      <button href="#" class="btn btn-block dropdown-toggle btn-wd ButtonText" data-toggle="dropdown" aria-expanded="false">
                          Filter
                          <b class="caret"></b>
                      </button>
                      <ul class="dropdown-menu" id="dropdown-filter-menu">
                        <li class="AllIcon"><a href="#">All</a></li>
                        <li class="CompletedIcon"><a href="#">Completed</a></li>
                        <li class="AwaitingIcon"><a href="#">Awaiting Acceptance</a></li>
                        <li class="AcceptedIcon"><a href="#">Accepted</a></li>
                        <li class="UnassignedIcon"><a href="#">Unassigned</a></li>
                        
                      </ul>
                </div>
              </form>
            </div>
          </div>

           <?php if($this->session->userdata('First_Login') == 0 ){?>

           <div class="col-lg-6 col-md-6 col-sm-6 mt-3  ">

                <div class="alert alert-warning mb-2">
                    
                    <span>To validate your mobile and get the verification code by SMS, go to the <a class="theme-color" href="<?php echo base_url();?>setting/EditProfile/<?php echo $this->session->userdata('id');?>">Profile Page. </a> </span>
                    
                </div>
           </div>

           <?php }?>
    </div>


       
            <div class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">

                             <div class="">
                        <div class="row">
                    <div class="col-lg-4 col-sm-6"> 
                        <a href="<?php echo base_url();?>admin/ViewAll">
                        <div class="card">

                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-book"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Urgent cases</p>
                                            <?php echo $urgent[0]->total;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div></a>
                    </div>
                    <div class="col-lg-4 col-sm-6"> <a href="<?php echo base_url();?>admin/ViewAll">
                        <div class="card">

                           
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-success text-center">
                                            <i class="ti-folder"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Routine cases</p>
                                             <?php echo $routineCases[0]->total;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div></a>
                    </div>
                    <div class="col-lg-4 col-sm-6"> <a href="<?php echo base_url();?>admin/filter?query=Accepted">
                        <div class="card"> 
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="ti-pencil"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Accepted cases</p>
                                            <?php print_r($acceptedCase);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div></a>
                    </div>

                    <div class="col-lg-4 col-sm-6"> <a href="<?php echo base_url();?>admin/filter?query=Unassigned">
                        <div class="card"> 
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-pencil"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Unallocated cases</p>

                                            <?php  echo $notallocated[0]->total;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div></a>
                    </div>

                    <div class="col-lg-4 col-sm-6"> <a href="<?php echo base_url();?>admin/Logs?DoctorLoggedIn">
                        <div class="card"> 
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-success text-center">
                                            <i class="ti-pencil"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Doctors logged in</p>
                                            <?php  echo $doctorOnline[0]->totalDoctor;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div></a>
                    </div>

                      <div class="col-lg-4 col-sm-6"> <a href="<?php echo base_url();?>messages">
                        <div class="card"> 
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="ti-comment-alt"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Unread messages</p>
                                             <?php //$this->load->model('messages_model');
                                                $unread =  $this->message_model->GetUnreadMessages($this->session->userdata('id'));

                                                echo $unread[0]->unread;

                                                ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div></a>
                    </div>

                    <div class="col-lg-4 col-sm-6"> <a href="<?php echo base_url();?>admin/filter?query=Awaiting Acceptance">
                        <div class="card"> 
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-comment-alt"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Awaiting acceptance</p>
                                             <?php echo $UnacceptedCases; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div></a>
                    </div>

                    <div class="col-lg-4 col-sm-6"> <a href="<?php echo base_url();?>admin/ViewAllReports">
                        <div class="card"> 
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-success text-center">
                                            <i class="ti-eye"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>View completed reports</p>
                                             <?php echo $ViewableReports; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div></a>
                    </div>

                    <div class="col-lg-4 col-sm-6"> <a href="<?php echo base_url();?>archive">
                        <div class="card"> 
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="ti-view-list-alt"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="numbers">
                                            <p>Archived</p>
                                             <?php echo $TotalArchived; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div></a>
                    </div>

                </div>
                        </div> 



                           <?php /*?>  <div class="card">
                                <div class="card-content">
                                    <div class="toolbar">
                                       
                                    </div>
                                    <table id="bootstrap-table" class="table-striped mytable">
                                       <thead>
                                            
                                             <th data-field="Urgent" >Urgent</th>
                                            <th data-field="id" data-sortable="true">Case ref.</th>
                                            <th data-field="name" data-sortable="true">Patient name </th>
                                            <th data-field="salary" data-sortable="true">Date created</th>
                                            <th data-field="clinic" data-sortable="true">Referring clinic</th>
                                            <th data-field="doctor" data-sortable="true">Doctor</th>
                                            <th data-field="Status" data-sortable="true">Status</th>
                                            <th data-field="state" >Archive</th>
                                            <th data-field="actions" class="td-actions text-right" >Actions</th>
                                        </thead>
                                        <tbody>

                                        <?php foreach($jobDetails as $job){ ?>

                                            <tr id="<?php echo $job->test_id?>">
                                                 <td>
                                                    <input class="AddtoUrgent" value="<?php echo $job->test_id?>" type="checkbox">
                                                </td>

                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a href="<?php echo base_url()?>user/PatientDetails/<?php echo $job->test_id?>"> <?php echo $job->patient_name?> </a></td>
                                                <td><?php echo $job->test_date?></td>
                                                <td>
                                                    <?php  

                                                    foreach($hospitals as $hospital){ 
                                                                if($hospital->hospital_id == $job->hospital_id ){
                                                                    echo $hospital->hospital_name;
                                                                }
                                                            }

                                                     ?> 
                                                 </td>
                                                <td>

                                                    <?php if(empty($job->doctor_id)){ ?>
                                                    <select class="assigndoctor">
                                                      <option>Select Doctor</option>
                                                      <?php foreach($doctors as $doctor){  ?>
                                                        <option value="<?php echo $doctor->doctor_id?>|<?php echo $job->test_id?>"><?php echo $doctor->doctor_name ?></option>
                                                      <?php  }?>
                                                    </select>
                                                    <?php    }else{

                                                        foreach($doctors as $doctor){ 
                                                            if($job->doctor_id == $doctor->doctor_id ){
                                                                echo $doctor->doctor_name;
                                                            }
                                                        }



                                                        }?>
        
                                                 </td>
                                                 <td> 
                                                    <?php if(empty($job->doctor_id)){ 
                                                            echo "<strong>Unassigned</strong>" ;
                                                        }elseif(!empty($job->doctor_id) && empty($job->doctor_approval)){ 
                                                             echo "<strong class='text-danger'>Awaiting Acceptance</strong>"; 
                                                        }elseif(!empty($job->sentinvoice)){
                                                             echo "<strong class='text-success'>Completed</strong>";
                                                        }else{
                                                            echo "<strong>Accepted</strong>";
                                                        } ?>
                                                                    
                                                 </td>
                                                   <td>
                                                    <input class="AddtoArchive" value="<?php echo $job->test_id?>" type="checkbox">
                                                </td>
                                                <td>

                                                    <?php if(empty($job->invoicealreadySend)){?>

                                                    <a  class="btn btn-outline-danger btn-theme" <?php if(empty($job->sentinvoice)){ echo "Disabled" ;}else{?> href="<?php echo base_url();?>invoice/generateInvoice/<?php echo $job->test_id?>"<?php }?> > Send invoice </a>
                                                    <?php }else{ ?> <a class="btn btn-outline-danger btn-theme" disabled=""> Invoice Sent </a> <?php  }?>    
                                                     

                                                 </td>
                                            </tr>
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div><?php */?>
							<div class="card">
                                <div class="card-content ">
                                  <span class="text-theme  bootstrap-table">Awaiting report more than 3 weeks</span>
                                    <div class="toolbar">
                                         

                                    </div>
                                    <table id="bootstrap-table2"  class="table-striped mytable urgent">
                                        <thead>
                                            <th data-field="actions" class="td-actions" >Actions</th>
                                            <th data-field="id" data-sortable="true">Case ref</th>
                                            <th data-field="name" data-sortable="true">Patient name </th>
                                            <th data-field="Status" data-sortable="true">Status</th>
                                            <th data-field="salary" data-sortable="true">Date created</th>
                                            <th data-field="doctor" data-sortable="true">Doctor name</th>
                                            <th data-field="clinic" data-sortable="true">Referring clinic</th>
                                            
                                            
                                            
                                        </thead>
                                        <tbody>

                                        <?php foreach($OverduesMoreThenTwoweek as $key => $job){  $number = $key; ?>

                                            <tr id="<?php echo $job->test_primary_id ?>" <?php if(($number % 2) == 0){ ?> class="info"  <?php  }?>>
                                                <td>

                                                     <div class="dropdown action-box">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu action-menu">
                                                          <?php if(empty($job->invoicealreadySend)){
                                                                if(!empty($job->sentinvoice)){
                                                            ?>  
                                                                <li><a class="sendInvoice" value="<?php echo $job->test_primary_id ?>"  href="javascript:;" > Send invoice </a>
                                                                </li>
                                                           <?php }}?>

                                                           <?php if(!empty($job->invoicealreadySend)){?>  
                                                                <li>
                                                                    <a target="blank" href="<?php echo base_url();?>doctor/GetInvoiceDownload/<?php echo $job->test_primary_id ?>" > View invoice </a>
                                                                </li>
                                                           <?php }?>

                                                            <?php if($job->report == 'Available' && $job->authorised != 1){?>
                                                                    <li>
                                                                        <a href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_primary_id ?>" value="<?php echo $job->test_primary_id ?>" > View Report Status
                                                                        </a>
                                                                    </li>
                                                                <?php }?>

                                                            <?php if($job->authorised == 1){?>  
                                                                <li>
                                                                    <a target="blank" href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_primary_id ?>" > View Report </a>
                                                                </li>
                                                           <?php }?>

                                                                <li>
                                                                    <a class="AddtoUrgent" href="javascript:;" value="<?php echo $job->test_primary_id ?>"> Make Urgent </a>
                                                                </li>

                                                                <?php if($job->authorised != 1){?>
                                                                    <li>
                                                                        <a href="<?php echo base_url();?>admin/EditJob/<?php echo $job->test_primary_id ?>" value="<?php echo $job->test_primary_id ?>" > Edit Job 
                                                                        </a>
                                                                    </li>
                                                                <?php }?>

                                                                 <?php if($job->authorised == 1){?> 
                                                                     <li>
                                                                         <a class="AddtoArchive" href="javascript:;" value="<?php echo $job->test_primary_id ?>"> Move to Archive </a>
                                                                    </li>
                                                                <?php }?>
                                                          </ul>
                                                    </div>


                                                 </td>
                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a class="profile_link" href="<?php echo base_url()?>user/PatientDetails/<?php echo $job->patient_primary_id?>"> 
                                                        <?php echo $job->patient_name." ".$job->last_name; ?> 
                                                    </a><br /><small> DOB: <?php $date=date_create($job->DateOfBirth); echo date_format($date,$dateFormat); ?> </small>
                                                </td>
                                                 <td class="assigndoctor<?php echo $job->test_primary_id ?>"> 

                                                     <?php 
                                                        $alreadyassign = $job->test_doctor_report;
                                                      ?>

                                                      <?php if($job->authorised == 1){
                                                             echo "<strong class='text-success'>Completed</strong>";
                                                      }elseif(empty($alreadyassign)){
                                                        echo "<strong>Unassigned</strong>" ;
                                                      }elseif(in_array('1', array_column($alreadyassign, 'status'))) { // search value in the array
                                                             echo "<strong>Accepted</strong>" ;
                                                      }elseif(in_array('0', array_column($alreadyassign, 'status'))) { // search value in the array
                                                             echo "<strong class='text-danger'>Awaiting Acceptance</strong>" ;
                                                      }?>

                                                <br />

                                                        <small>
                                                            <?php if($job->box_received == 1){
                                                                echo "(Slides Received)";
                                                            }else{
                                                                echo "(Not Delivered)";
                                                            }?>
                                                        </small>
                                                                    
                                                 </td>
                                                <td><?php $date=date_create($job->test_date); echo date_format($date,$dateFormat); ?></td>
                                                 <td class="assigntext<?php echo $job->test_primary_id ?>">

                                                    <?php if($job->authorised != 1){ ?>
                                                    <select class="assigndoctor">
                                                      <option>Select Doctor</option>
                                                      <?php foreach($doctors as $doctor){ $disable = '';
                                                         $disable = '';
                                                         if(in_array($doctor->doctor_id, array_column($alreadyassign, 'doctor_id'))) { // search value in the array
                                                              $disable = "disabled";
                                                          }
                                                        ?>
                                                        <option <?php echo $disable;?> value="<?php echo $doctor->doctor_id ?>|<?php echo $job->test_primary_id ?>"><?php echo 'Dr. '.$doctor->doctor_name ?></option>
                                                      <?php  }?>
                                                    </select><br />
                                                    <?php  foreach($alreadyassign as $assigndoctors){ 
                                                        if($assigndoctors['status'] == 1){ ?>
                                                             <a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo $assigndoctors['doctor_id']?>"><?php echo 'Dr. '.$assigndoctors['doctor_name'] ?></a><br /> 
                                                    <?php  }
                                                    }  }else{

                                                        foreach($doctors as $doctor){ 
                                                            if($job->doctor_id == $doctor->doctor_id ){
                                                              ?> 
                                                              <a class="profile_link" href="<?php echo base_url()?>doctor/DoctorDetails/<?php echo $job->doctor_id ?>">
                                                                    <?php echo 'Dr. '.$doctor->doctor_name ?> 
                                                               </a>
                                                               <?php
                                                            }
                                                        }



                                                        }?>
        
                                                 </td>
                                                <td><a class="profile_link" href="<?php echo base_url()?>hospital/HospitalDetails/<?php echo $job->hospital_id ?>">
                                                    <?php  

                                                    foreach($hospitals as $hospital){ 
                                                                if($hospital->hospital_id == $job->hospital_id ){
                                                                    echo $hospital->hospital_name;
                                                                }
                                                            }

                                                     ?> </a>
                                                 </td>
                                                 
                                            </tr>
                                        
                                            <?php  }?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
  		                          
								  
								  
								  
								  <div class="card">
                                <div class="card-content ">
                                  <span class="text-theme  bootstrap-table" style="color:#ae1a41">Urgent Cases</span>
                                    <div class="toolbar">
                                         

                                    </div>
                                    <table id="bootstrap-table2" class="table-striped mytable urgent">
                                        <thead>
                                           
                                            <th data-field="actions" class="td-actions " >Actions</th>
                                            <th data-field="id" data-sortable="true">Case ref</th>
                                            <th data-field="name" data-sortable="true">Patient name </th>
                                            <th data-field="Status" data-sortable="true">Status</th>
                                            <th data-field="salary" data-sortable="true">Date created</th>
                                            <th data-field="doctor" data-sortable="true">Doctor name</th>
                                            <th data-field="clinic" data-sortable="true">Referring clinic</th>
                                            
                                            
                                            
                                        </thead>
                                        <tbody>

                                        <?php foreach($UrgentsJobs  as $key => $job){ $number = $key;
                                          ?>

                                            <tr id="<?php echo $job->test_primary_id ?>" <?php if(($number % 2) == 0){ ?> class="danger"  <?php  }?>>
                                                <td>

                                                     <div class="dropdown action-box">
                                                          <button href="#" class="btn btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                              <i class="glyphicon fa fa-columns"></i>
                                                              <b class="caret"></b>
                                                          </button>
                                                          <ul class="dropdown-menu action-menu">
                                                          <?php if(empty($job->invoicealreadySend)){
                                                                if(!empty($job->sentinvoice)){
                                                            ?>  
                                                                <li><a class="sendInvoice" value="<?php echo $job->test_primary_id ?>"  href="javascript:;" > Send invoice </a>
                                                                </li>
                                                           <?php }}?>

                                                           <?php if(!empty($job->invoicealreadySend)){?>  
                                                                <li>
                                                                    <a target="blank" href="<?php echo base_url();?>doctor/GetInvoiceDownload/<?php echo $job->test_primary_id ?>" > View invoice </a>
                                                                </li>
                                                           <?php }?>

                                                           <?php if($job->report == 'Available' && $job->authorised != 1){?>
                                                                    <li>
                                                                        <a href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_primary_id ?>" value="<?php echo $job->test_primary_id ?>" > View Report Status
                                                                        </a>
                                                                    </li>
                                                                <?php }?>

                                                            <?php if($job->authorised == 1){?>  
                                                                <li>
                                                                    <a target="blank" href="<?php echo base_url();?>hospital/ViewReport/<?php echo $job->test_primary_id ?>" > View Report </a>
                                                                </li>
                                                           <?php }?>

                                                                <li>
                                                                    <a class="RemovetoUrgent" href="javascript:;" value="<?php echo $job->test_primary_id ?>"> Remove urgent </a>
                                                                </li>

                                                                <?php if($job->authorised != 1){?> <li>
                                                             <a href="<?php echo base_url();?>admin/EditJob/<?php echo $job->test_primary_id ?>" value="<?php echo $job->test_primary_id ?>" > Edit Job </a>
                                                           </li> <?php }?>

                                                            <?php if($job->authorised == 1){?> 
                                                                <li>
                                                                    <a class="AddtoArchive" href="javascript:;" value="<?php echo $job->test_primary_id ?>"> Move to Archive </a>
                                                                </li>
                                                            <?php }?>
                                                          </ul>
                                                    </div>

                                                

                                                 </td>
                                                <td><?php echo $job->Client_case_number?></td>
                                                <td><a class="profile_link" href="<?php echo base_url()?>user/PatientDetails/<?php echo $job->patient_primary_id ?>"> 
                                                    <?php echo $job->patient_name." ".$job->last_name; ?></a>
                                                    <br /><small> DOB: <?php $date=date_create($job->DateOfBirth); echo date_format($date,$dateFormat); ?> 
                                                </td>
                                                <td class="assigndoctor<?php echo $job->test_primary_id ?>"> 
                                                    <?php 
                                                        $alreadyassign = $job->test_doctor_report;
                                                      ?>

                                                      <?php if($job->authorised == 1){
                                                             echo "<strong class='text-success'>Completed</strong>";
                                                      }elseif(empty($alreadyassign)){
                                                        echo "<strong>Unassigned</strong>" ;
                                                      }elseif(in_array('1', array_column($alreadyassign, 'status'))) { // search value in the array
                                                             echo "<strong>Accepted</strong>" ;
                                                      }elseif(in_array('0', array_column($alreadyassign, 'status'))) { // search value in the array
                                                             echo "<strong class='text-danger'>Awaiting Acceptance</strong>" ;
                                                      }?>

                                                  <br />

                                                        <small>
                                                            <?php if($job->box_received == 1){
                                                                echo "(Slides Received)";
                                                            }else{
                                                                echo "(Not Delivered)";
                                                            }?>
                                                        </small>
                                                                    
                                                 </td>
                                                <td><?php $date=date_create($job->test_date); echo date_format($date,$dateFormat); ?></td>
                                                <td class="assigntext<?php echo $job->test_primary_id ?>">

                                                    <?php if($job->authorised != 1){ ?>
                                                    <select class="assigndoctor">
                                                      <option>Select Doctor</option>
                                                      <?php foreach($doctors as $doctor){
                                                        $disable = '';
                                                         if(in_array($doctor->doctor_id, array_column($alreadyassign, 'doctor_id'))) { // search value in the array
                                                              $disable = "disabled";
                                                          }
                                                        ?>
                                                        <option <?php echo $disable;?> value="<?php echo $doctor->doctor_id?>|<?php echo $job->test_primary_id ?>"><?php echo 'Dr. '.$doctor->doctor_name ?></option>
                                                      <?php  }?>
                                                    </select><br />
                                                    <?php  

                                                    foreach($alreadyassign as $doctors){ 
                                                        if($doctors['status'] == 1){ ?>
                                                             <a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo $doctors['doctor_id']?>"><?php echo 'Dr. '.$doctors['doctor_name'];?> </a><br />
                                                    <?php  }
                                                    }

                                                      }else{

                                                        foreach($doctors as $doctor){ 
                                                            if($job->doctor_id == $doctor->doctor_id ){
                                                                ?> 
                                                              <a class="profile_link" href="<?php echo base_url()?>doctor/DoctorDetails/<?php echo $job->doctor_id ?>">
                                                                    <?php echo 'Dr. '.$doctor->doctor_name ?> 
                                                               </a>
                                                               <?php
                                                            }
                                                        }



                                                        }?>
        
                                                 </td>
                                                <td><a class="profile_link" href="<?php echo base_url()?>hospital/HospitalDetails/<?php echo $job->hospital_id ?>">
                                                    <?php  

                                                    foreach($hospitals as $hospital){ 
                                                                if($hospital->hospital_id == $job->hospital_id ){
                                                                    echo $hospital->hospital_name;
                                                                }
                                                            }

                                                     ?> </a>
                                                 </td>
                                                
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
	<?php include('partial/footerscript.php') ?>


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
</body>

	<script type="text/javascript">
    	$(document).ready(function(){
			demo.initOverviewDashboard();
			demo.initCirclePercentage();
			

    	});

$("#dropdown-filter-menu a").click(function(){
	var $table = $('.mytable');
	var selectedText = $(this).text();
	if(selectedText == "All"){ selectedText = "";}
	$table.bootstrapTable('refreshOptions', {searchText:selectedText});

     if(selectedText == ""){ selectedText = "All"}
    
    $('.ButtonText').html(selectedText+' <b class="caret"></b>');

    if(selectedText == "All"){ $('.AllIcon').addClass('active') }else{ $('.AllIcon').removeClass('active') }
    if(selectedText == "Completed"){ $('.CompletedIcon').addClass('active') }else{ $('.CompletedIcon').removeClass('active') }
    if(selectedText == "Awaiting Acceptance"){ $('.AwaitingIcon').addClass('active') }else{ $('.AwaitingIcon').removeClass('active') }
    if(selectedText == "Accepted"){ $('.AcceptedIcon').addClass('active') }else{ $('.AcceptedIcon').removeClass('active') }
    if(selectedText == "Unassigned"){ $('.UnassignedIcon').addClass('active') }else{ $('.UnassignedIcon').removeClass('active') }
});

	</script>


      <script type="text/javascript">
       /**/
      

 $(document).ready(function(){
  // $('.assigndoctor').change(function(){ 
    $('body').on('change', '.assigndoctor', function() {
            var cur_value = $('option:selected',this).attr('value');

            var cur_text = $('option:selected',this).text();
            
            var res = cur_value.split("|");

            var retVal = confirm("The Doctor will be notified, and the job will be set to Waiting for Approval\nAre you sure?");
               if( retVal == true ) {
                  $.ajax({url: "<?php echo base_url();?>admin/assignDoctortopatient?doctor_id="+cur_value, success: function(result){
                        // location.reload();
                       // $('.assigndoctor'+res[1]).html("<strong class='text-danger'>Awaiting Acceptance</strong><br /><small>(Not Delivered)</small>");

                        //$('.assigntext'+res[1]).html("<a class='profile_link' href='<?php echo base_url();?>doctor/DoctorDetails/"+res[0]+"'>"+ cur_text  +"</a>");

                        alert('This job is assigned to '+ cur_text );

                    }});
               } else {
                  
               }

          
     });
});


    </script>

    <script>

	 $(document).ready(function(){
	   $('.AddtoArchive').click(function(){
       $('body').on('click', '.AddtoArchive', function() { 
	   	  var postId = $(this).attr("value");

	        $.ajax({url: "<?php echo base_url();?>admin/AddtoArchive?Post_id="+postId, success: function(result){
                $("#"+postId).remove();                    
            } 
	          
	     });
	});

});

	$(document).ready(function(){
        //$('.AddtoUrgent').click(function(){ 
             $('body').on('click', '.AddtoUrgent', function() {
           	  var postId = $(this).attr("value");

                $.ajax({url: "<?php echo base_url();?>doctor/AddtoUrgent?Post_id="+postId, success: function(result){
                $("#"+postId).remove();
                location.reload();                    
            	}
                  
             });
        });
});
                                                            
     $(document).ready(function(){
           //$('.RemovetoUrgent').click(function(){
             $('body').on('click', '.RemovetoUrgent', function() {
           	  var postId = $(this).attr("value");

                $.ajax({url: "<?php echo base_url();?>doctor/RemovetoUrgent?Post_id="+postId, success: function(result){
                $("#"+postId).remove();
                location.reload();                    
            	}
                  
             });
        });
});


     $(document).ready(function(){

     // $('.sendInvoice').click(function(){ 
         $('body').on('click', '.sendInvoice', function() {

        var postId = $(this).attr("value");

            var retVal = confirm("The Institute will be sent the generated Invoice for this job\nAre you sure?");
                   if( retVal == true ) {
                      window.location.assign("<?php echo base_url();?>invoice/generateInvoice/"+postId)
                   } else {
                      
                   }
              
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
