<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Doctor Details - LIMS
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
        <div class="row">
          <div class="col-lg-2 col-md-6 col-sm-6">
           <?php /*?> <a href="<?php echo base_url();echo $user;?>" class="btn btn-outline-danger btn-theme login_btn">Go back</a><?php */?>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
           
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
           
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">

        </div>
      </div>


     
        

        <div class="content">
          <div class="col-md-12 bg-white pt-3 pb-3 brd-10 mt-3">

          <div class="row pb-4">
            
            <div class="col-lg-4"> 
              <span class="patient-value ">Name of doctor</span><br />
              <span class="patient-field"><?php echo $DoctorDetails[0]->doctor_name ?></span>
            </div>

             <div class="col-lg-4">
              <span class="patient-value">Email</span><br />
              <span class="patient-field">

              <?php  
                                echo $DoctorDetails[0]->email;
                           
                 ?></span>
            </div>

             <div class="col-lg-4">
              <span class="patient-value">Mobile number</span><br />
              <span class="patient-field"> <?php echo $DoctorDetails[0]->mobile_number?></span>
            </div>

          </div>

           <br/>

          <div class="row pb-4">

             <div class="col-lg-4">
              <span class="patient-value">Address</span><br />
              <span class="patient-field"> <?php echo $DoctorDetails[0]->address?></span>
            </div>
             
             <div class="col-lg-4">
              <span class="patient-value">Secondary email</span><br />
              <span class="patient-field"> <?php echo $DoctorDetails[0]->secondary_email;  ?></span>
            </div>


 
            <div class="col-lg-4">
              <span class="patient-value">Work number</span><br />
              
			  
			       <span class="patient-field"> <?php echo $DoctorDetails[0]->work_number?></span>
            </div>
  
          </div>
          <br>
          <div class="row pb-4">

              <div class="col-lg-4">
              <span class="patient-value">Gmc number</span><br />
              
       
        <span class="patient-field"> <?php echo $DoctorDetails[0]->gmc_number?>
       
        </span>
            </div>

            <div class="col-lg-4">
              <span class="patient-value">Doctor specialties</span><br />
              <span class="patient-field"> <?php echo $DoctorDetails[0]->doctor_specialties?></span>
            </div>

             <div class="col-lg-4">
              <span class="patient-value">Department</span><br />
              <span class="patient-field"> 
              <?php echo $DoctorDetails[0]->department;
                            ?></span>
            </div>

         </div>
          
         <br/>

         <table class="table table-striped">
                                      <thead>
                                          <tr><th>Id</th>
                                            <th>Patient name</th>
                                        <th>Test type</th>
                                        <th>No of specimen</th>
                                        <th>Test date</th>
                                        
                                        <th>View</th>
                                      </tr></thead>
                                      <tbody> 
									  
                                        <?php 
										
										
										foreach($JobsDetails as $detail){ ?>
                                          <tr>
                                           <td>
                                                 <?php echo $detail->primary_id; ?>
                                               </td>
                                               <td>
                                                <?php  echo $detail->patient_name; ?>
                                               </td>
                                               <td>
                                                  <?php  echo $detail->TestTypeName; ?>
                                               </td>
                                               <td>
                                                 <?php echo $detail->no_of_specimen ?>
                                               </td>
                                               <td>
                                                 <?php echo $detail->test_date; ?>
                                               </td>
                                               <td>
                                                 <?php if($detail->authorised == '1'){
												 ?>
                                                  <a class="btn btn-outline-danger btn-theme login_btn" href="<?php echo base_url()?>hospital/ViewReport/<?php echo $detail->primary_id; ?>"> View Report</a>
                                                <?php  }else{ ?>
                                                  <a class="btn btn-outline-danger btn-theme login_btn" href="#" disabled> Not Generated</a>
                                                <?php  } ?>
                                               </td>
                                          </tr> <?php }?>
                                         
                                      </tbody>
                                  </table>

       

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
