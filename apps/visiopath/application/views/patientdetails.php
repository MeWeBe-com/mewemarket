<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Patient Details - LIMS
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <?php include('partial/head.php') ?>
</head>

<body class="">
    <div class="wrapper ">
        <?php include('partial/sidebar.php') ?>
            <div class="main-panel">
                <!-- Navbar -->
                <?php include('partial/nav.php') ?>
                    <!-- End Navbar -->
                    <!-- <div class="panel-header panel-header-lg">

  <canvas id="bigDashboardChart"></canvas>

</div> -->
                    <div class="content">

                        <div class="container-fluid">
                            <div class="col-md-12 bg-white pt-3 pb-3 brd-10 ">

                                <span class="text-theme  bootstrap-table mt-3 mb-3 d-block">Patient Details</span>

                                <div class="row pb-4">

                                    <div class="col-lg-4">
                                        <span class="patient-value ">Name of Patient</span>
                                        <br />
                                        <span class="patient-field patient_name"><?php echo $patientDetails[0]->patient_name ?> <?php echo $patientDetails[0]->last_name ?></span>
                                    </div>

                                    <div class="col-lg-4 <?php if($this->agent->is_mobile()){ echo "mt-5" ; }?>">
                                        <span class="patient-value">Date of birth</span>
                                        <br />
                                        <span class="patient-field"> <?php $date=date_create($patientDetails[0]->DateOfBirth); echo date_format($date,$dateFormat); ?></span>
                                    </div>

                                    <div class="col-lg-4 <?php if($this->agent->is_mobile()){ echo "mt-5" ; }?>">
                                        <span class="patient-value">Gender</span>
                                        <br />
                                        <span class="patient-field"> <?php echo $patientDetails[0]->gender?></span>
                                    </div>

                                </div>

                                <br/>

                                <div class="row pb-4">
                                    <div class="col-lg-4">
                                        <span class="patient-value">Address</span>
                                        <br />
                                        <span class="patient-field"> <?php echo $patientDetails[0]->address?> <?php echo $patientDetails[0]->address_two?></span>
                                    </div>

                                    <?php /*?>
                                        <div class="col-lg-4">
                                            <span class="patient-value">Referring clinician</span>
                                            <br />
                                            <span class="patient-field"> <?php echo $patientDetails[0]->doctor_name;  ?></span>
                                        </div>
                                        <?php */?>

                                            <div class="col-lg-4 <?php if($this->agent->is_mobile()){ echo "mt-5" ; }?>">
                                                <span class="patient-value">Email</span>
                                                <br />

                                                <span class="patient-field"> <?php echo $patientDetails[0]->email?>

        </span>
                                            </div>

                                            <div class="col-lg-4 <?php if($this->agent->is_mobile()){ echo "mt-5" ; }?>">
                                                <span class="patient-value">Contact Number</span>
                                                <br />

                                                <span class="patient-field"> <?php echo $patientDetails[0]->mobile_number?>

        </span>
                                            </div>

                                </div>

                                <br/>

                                <div class="row pb-4">

                                    <div class="col-lg-4">
                                        <span class="patient-value">Hospital Number</span>
                                        <br>

                                        <span class="patient-field"> <?php echo $patientDetails[0]->hospital_number?>       
        </span>
                                    </div>

                                    <div class="col-lg-4 <?php if($this->agent->is_mobile()){ echo "mt-5" ; }?>">
                                        <span class="patient-value">NHS Number</span>
                                        <br />

                                        <span class="patient-field"> <?php echo $patientDetails[0]->nhs_number?>

        </span>
                                    </div>
                                </div>

                                <br/>
                                <div class="table-responsive ">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>View</th>
                                                <th>Case ref</th>
                                                <th>Doctor name</th>
                                                <th>Status</th>
                                                <th>Visiopath #</th>
                                                <th>Date Received</th>
                                                <th>Institute Name</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 

                                              foreach($patientDetails[0]->test_details as $detail){?>
                                                <tr>
                                                    <td>
                                                        <?php if(empty($detail->doctor_id)) {?>
                                                          <a class="btn btn-outline-danger btn-theme login_btn" href="#" disabled> Not Generated</a>
                                                            <?php }elseif($userDataID == $detail->doctor_id) {?>
                                                            <a class="btn btn-outline-danger btn-theme login_btn" href="<?php echo base_url()?>uploadreport/EditReport/<?php echo $detail->test_id; ?>"> Edit Report</a>
                                                            <?php }else{?>
                                                                <?php if($detail->authorised == '1'){ ?>
                                                                    <a class="btn btn-outline-danger btn-theme login_btn" href="<?php echo base_url()?>hospital/ViewReport/<?php echo $detail->test_id; ?>"> View Report</a>
                                                                    <?php  }else{ ?>
                                                                        <a class="btn btn-outline-danger btn-theme login_btn" href="#" disabled> Not Generated</a>
                                                                        <?php  } ?>
                                                                <?php }?>
                                                    </td>
                                                    <td>
                                                        <?php echo $detail->Client_case_number; ?>
                                                    </td>
                                                    
                                                    <td>
                                                         <?php if(!empty($detail->doctor_id)){ ?>
                                                                    <a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php  echo $detail->doctor_id; ?>">
                                                                        <?php  echo 'Dr. '.$detail->doctor_name; ?>
                                                                    </a> 
                                                         <?php  }else{

                                                            $alreadyassign = $detail->test_doctor_report;

                                                                if(empty($alreadyassign)){
                                                                    echo 'Unassigned';
                                                                }else{
                                                                    foreach ($alreadyassign as $doctor) {
                                                                        if($doctor['status'] == 1){?>
                                                                            <a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php  echo $doctor['doctor_id']; ?>">
                                                                                <?php  echo 'Dr. '.$doctor['doctor_name']; ?>
                                                                            </a> 
                                                                        <?php }?>
                                                                    <?php }
                                                                }
                                                            ?>

                                                          
                                                            
                                                         <?php }?>
                                                       
                                                    </td>
                                                    <td>
                                                        <?php /*if(empty($detail->doctor_id)){ ?>
                                                                   <strong> Unassigned </strong> 
                                                              <?php  }elseif($detail->authorised == '1'){ ?>
                                                                   <strong> Completed </strong> 
                                                              <?php  }else{ ?>
                                                                     <strong> Accepted </strong>
                                                              <?php  }*/ ?>

                                                               <?php if($detail->authorised == 1){
                                                             echo "<strong class='text-success'>Completed</strong>";
                                                              }elseif(empty($alreadyassign)){
                                                                echo "<strong>Unassigned</strong>" ;
                                                              }elseif(in_array('1', array_column($alreadyassign, 'status'))) { // search value in the array
                                                                     echo "<strong>Accepted</strong>" ;
                                                              }elseif(in_array('0', array_column($alreadyassign, 'status'))) { // search value in the array
                                                                     echo "<strong class='text-danger'>Awaiting Acceptance</strong>" ;
                                                              }?>
                                                                
                                                    </td>
                                                    <td>
                                                        <?php echo $detail->visiopath_number; ?>
                                                    </td>
                                                    <td>
                                                        <?php $date=date_create($detail->test_date); echo date_format($date,$dateFormat); ?>
                                                    </td>
                                                    <td>
                                                        <a class="profile_link" href="<?php echo base_url();?>hospital/HospitalDetails/<?php echo $detail->hospital_id; ?>">
                                                            <?php echo $detail->hospital_name; ?>
                                                        </a>
                                                    </td>
                                                    
                                                </tr>
                                                <?php }?>

                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                    <?php include('partial/footer.php') ?>
            </div>
    </div>
    <!--   Core JS Files   -->
    <?php include('partial/footerscript.php') ?>
        <script>
            $(document).ready(function() {
                // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
                demo.initChartsPages();
            });
        </script>
</body>

</html>