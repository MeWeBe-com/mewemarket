<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
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
        <div class="row">
          <div class="col-lg-2 col-md-6 col-sm-6">
            <a href="<?php echo base_url();echo $user;?>" class="btn btn-outline-danger btn-theme login_btn">Go back</a>
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
              <span class="patient-value ">Name of Patient</span><br />
              <span class="patient-field"><?php echo $patientDetails[0]->patient_name ?></span>
            </div>

             <div class="col-lg-4">
              <span class="patient-value">Referring institution</span><br />
              <span class="patient-field">

              <?php  foreach($hospitals as $hospital){ 
                            if($hospital->hospital_id == $patientDetails[0]->hospital_id ){
                                echo $hospital->hospital_name;
                            }
                        }

                 ?></span>
            </div>

             <div class="col-lg-4">
              <span class="patient-value">Date of birth</span><br />
              <span class="patient-field"> <?php echo $patientDetails[0]->DateOfBirth?></span>
            </div>

          </div>

           <br/>

           <div class="row pb-4">

             <div class="col-lg-4">
              <span class="patient-value">Gender</span><br />
              <span class="patient-field"> <?php echo $patientDetails[0]->gender?></span>
            </div>
             
             <div class="col-lg-4">
              <span class="patient-value">Referring clinician</span><br />
              <span class="patient-field"> <?php foreach($doctors as $doctor){ 
                        if($patientDetails[0]->doctor_id == $doctor->doctor_id ){
                            echo $doctor->doctor_name;
                        }
                    }  ?></span>
            </div>


 
            <div class="col-lg-4">
              <span class="patient-value">Client case number</span><br />
              
			  <img src="data:image/png;base64,<?php echo $patientDetails[0]->Client_case_number_barcode?>">
			   <br>
			  <span class="patient-field"> <?php echo $patientDetails[0]->Client_case_number?>
			 
			  </span>
            </div>
  

          </div>

           <br/>

           <div class="row pb-4">

              <div class="col-lg-4">
              <span class="patient-value">Visiopath case number</span><br />
              
        <img src="data:image/png;base64,<?php echo $patientDetails[0]->visiopath_case_number_barcode?>">
         <br>
        <span class="patient-field"> <?php echo $patientDetails[0]->visiopath_number?>
       
        </span>
            </div>

             <div class="col-lg-4">
              <span class="patient-value">Test date</span><br />
              <span class="patient-field"> <?php echo $patientDetails[0]->test_date?></span>
            </div>

             <div class="col-lg-4">
              <span class="patient-value">Specimen</span><br />
              <span class="patient-field"> <?php 

              foreach($testTypes as $test){ 
                            if($test->TestTypeId == $patientDetails[0]->specimen ){
                                echo $test->TestTypeName;
                            }
                        }

               ?></span>
            </div>

          </div>

        <br/>

      

         <br/>

         <table class="table table-striped">
                                      <thead>
                                          <tr><th>Id</th>
                                            <th>Doctor name</th>
                                        <th>Test type</th>
                                        <th>No of specimen</th>
                                        <th>Test date</th>
                                        <th>Amount</th>
                                        <th>View</th>
                                      </tr></thead>
                                      <tbody> 
                                        <?php foreach($patientDetails as $detail){?>
                                          <tr>
                                           <td>
                                                 <?php echo $detail->test_id; ?>
                                               </td>
                                               <td>
                                                <?php 
                                                if(empty($detail->doctor_id)){
                                                      echo "Doctor Not assign";
                                                    }
                                                foreach($doctors as $doctor){ 


                                                    if($detail->doctor_id == $doctor->doctor_id ){
                                                        echo $doctor->doctor_name;
                                                    }else{ }
                                                }  ?>
                                               </td>
                                               <td>
                                                 <?php  foreach($testTypes as $test){ 
                                                        if($test->TestTypeId == $detail->specimen ){
                                                            echo $test->TestTypeName;
                                                        }
                                                    } ; ?> 
                                               </td>
                                               <td>
                                                 <?php echo $detail->no_of_specimen ?>
                                               </td>
                                               <td>
                                                 <?php echo $detail->test_date; ?>
                                               </td>
                                               <td>
                                                 <?php echo $detail->amount ?>
                                               </td>
                                               <td>
                                                 <?php if($detail->sentinvoice == 'Enable'){?>
                                                  <a class="btn btn-outline-danger btn-theme login_btn" href="<?php echo base_url()?>hospital/ViewReport/<?php echo $detail->test_id; ?>"> View Report</a>
                                                <?php  }else{ ?>
                                                  <a class="btn btn-outline-danger btn-theme login_btn" href="#" disabled> View Report</a>
                                                <?php  } ?>
                                               </td>
                                          </tr> <?php }?>
                                         
                                      </tbody>
                                  </table>

       

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
