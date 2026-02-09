<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Hospital Details - LIMS
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <?php $this->load->view('partial/head') ?>
</head>

<body class="">
    <div class="wrapper ">
        <?php $this->load->view('partial/sidebar.php') ?>
            <div class="main-panel">
                <!-- Navbar -->
                <?php $this->load->view('partial/nav.php') ?>
                    <!-- End Navbar -->
                    <!-- <div class="panel-header panel-header-lg">

                          <canvas id="bigDashboardChart"></canvas>

                        </div> -->
                    <div class="content">

                        <div class="container-fluid">
                            <div class="col-md-12 bg-white pt-3 pb-3 brd-10 ">

                                <span class="text-theme  bootstrap-table mt-3 mb-3 d-block">Hospital Details</span>

                                <a target="blank" class="btn btn-outline-danger btn-theme login_btn mb-3" href="<?php echo base_url();?>messages/AddMessage?id=<?php echo $HospitalDetails[0]->id ?>&name=<?php echo $HospitalDetails[0]->hospital_name ?>">Send message to <?php echo $HospitalDetails[0]->hospital_name ?> </a>

                                <div class="row pb-4">

                                    <div class="col-lg-4">
                                        <span class="patient-value ">Name of Hospital</span>
                                        <br />
                                        <span class="patient-field"><?php echo $HospitalDetails[0]->hospital_name ?></span>
                                    </div>

                                    <div class="col-lg-4 <?php if($this->agent->is_mobile()){ echo "mt-5" ; }?>">
                                        <span class="patient-value">Email</span>
                                        <br />
                                        <span class="patient-field">
                                          <?php echo $HospitalDetails[0]->email;  ?>
                                        </span>
                                    </div>

                                    <div class="col-lg-4 <?php if($this->agent->is_mobile()){ echo "mt-5" ; }?>">
                                        <span class="patient-value">Address</span>
                                        <br />
                                        <span class="patient-field"> <?php echo $HospitalDetails[0]->address?></span>
                                    </div>

                                </div>

                                <br/>

                                <div class="row pb-4">

                                    <div class="col-lg-4">
                                        <span class="patient-value ">Contact number</span>
                                        <br />
                                        <span class="patient-field"><?php echo $HospitalDetails[0]->mobile_number ?></span>
                                    </div>

                                  <?php /*?>  <div class="col-lg-4 <?php if($this->agent->is_mobile()){ echo "mt-5" ; }?>">
                                        <span class="patient-value ">Hospital number</span>
                                        <br />
                                        <span class="patient-field"><?php echo $HospitalDetails[0]->phone ?></span>
                                    </div><?php */?>

                                </div>

                                <br />

                                <div class="table-responsive ">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>View</th>
                                                <th>Case ref</th>
                                                
                                                <th>Patient name</th>
                                                <th>Status</th>
                                                <th>Visio Path #</th>
                                                <th>Date Received</th>
                                                <th>Doctor Name</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 

                                              foreach($JobsDetails as $detail){?>
                                                <tr>
                                                    <td>
                                                        <?php  if(empty($detail->doctor_id)) {?>
                                                            <a class="btn btn-outline-danger btn-theme login_btn" href="#" disabled=""> Not Generated</a>
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
                                                        <a class="profile_link" href="<?php echo base_url();?>user/PatientDetails/<?php  echo $detail->patient_id; ?>">
                                                            <?php  echo $detail->patient_name." ".$detail->last_name; ?>
                                                        </a><br /><small> DOB: <?php $date=date_create($detail->DateOfBirth); echo date_format($date,$dateFormat); ?>
                                                    </td>
                                                    <td>
                                                        <?php if(empty($detail->doctor_id)){ ?>
                                                                    <strong> Unassigned </strong> 
                                                           <?php }elseif(!empty($detail->doctor_id) && empty($detail->doctor_approval)){ ?>
                                                                    <strong> Awaiting Start </strong> 
                                                           <?php }elseif($detail->authorised == '1'){ ?>
                                                                   <strong> Completed </strong> 
                                                              <?php  }else{ ?>
                                                                     <strong> Accepted </strong>
                                                              <?php  } ?>
                                                                
                                                    </td>
                                                    <td>
                                                        <?php echo $detail->visiopath_number; ?>
                                                    </td>
                                                    <td>
                                                        <?php $date=date_create($detail->test_date); echo date_format($date,$dateFormat); ?>
                                                    </td>
                                                    <td>

                                                    <?php  if(empty($detail->doctor_id)){ ?>
                                                        <strong> Unassigned </strong>
                                                    <?php }else{?>
                                                       
                                                        <a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php echo $detail->doctor_id; ?>">
                                                            <?php echo 'Dr. '.$detail->doctor_name; ?>
                                                        </a>
                                                    <?php }?>
                                                    </td>
                                                    
                                                </tr>
                                                <?php }?>

                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                    <?php $this->load->view('partial/footer.php') ?>
            </div>
    </div>
    <!--   Core JS Files   -->
    <?php $this->load->view('partial/footerscript.php') ?>
        <script>
            $(document).ready(function() {
                // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
                demo.initChartsPages();
            });
        </script>
</body>

</html>