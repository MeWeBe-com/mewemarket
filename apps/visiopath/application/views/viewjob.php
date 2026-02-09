<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Patient/Test Details  - LIMS
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
           <?php /*?> <a href="<?php echo base_url();echo $user;?>" class="btn btn-outline-danger btn-theme login_btn">Go back</a><?php */?>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
           
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
           
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">

        </div>
      </div>


     
        

        <div class="container-fluid">
          <div class="col-md-12 bg-white pt-3 pb-3 brd-10 mt-3">

          <div class="row pb-4">
            
            <div class="col-lg-4"> 
              <span class="patient-value ">Name of Patient</span><br />
              <span class="patient-field patient_name"><?php echo $patientDetails[0]->patient_name ?> <?php echo $patientDetails[0]->last_name ?></span>
            </div>

             <div class="col-lg-4">
              <span class="patient-value">Referring institution</span><br />
              <span class="patient-field">

              <a class="profile_link" href="<?php echo base_url();?>hospital/hospitalDetails/<?php  echo $patientDetails[0]->test_details[0]->hospital_id; ?>">
                <?php  
                    echo $patientDetails[0]->test_details[0]->hospital_name;
                 ?></a></span>
            </div>

             <div class="col-lg-4">
              <span class="patient-value">Date of birth</span><br />
              <span class="patient-field"><?php $date=date_create($patientDetails[0]->DateOfBirth); echo date_format($date,$dateFormat); ?></span>
            </div>

          </div>
<div class="row pb-4">
            
            <div class="col-lg-4"> 
              <span class="patient-value ">Email</span><br />
              <span class="patient-field"><?php echo $patientDetails[0]->email ?></span>
            </div>

             <div class="col-lg-4">
              <span class="patient-value">Address</span><br />
              <span class="patient-field">

              <?php  
                                echo $patientDetails[0]->address;
                           
                 ?></span>
            </div>

             <div class="col-lg-4">
              <span class="patient-value">Contact Number</span><br />
              <span class="patient-field"> <?php echo $patientDetails[0]->mobile_number?></span>
            </div>

          </div>
         

           <div class="row pb-4">

             <div class="col-lg-4">
              <span class="patient-value">Gender</span><br />
              <span class="patient-field"> <?php echo $patientDetails[0]->gender?></span>
            </div>
             
             <div class="col-lg-4">
              <span class="patient-value">Hospital Number</span><br />
              <span class="patient-field"> <?php echo $patientDetails[0]->hospital_number;  ?></span>
            </div>
			<div class="col-lg-4">
              <span class="patient-value">NHS Number</span><br />
              <span class="patient-field"> <?php echo $patientDetails[0]->nhs_number;  ?></span>
            </div>

</div>
 <div class="row pb-4">
 
            <div class="col-lg-4">
              <span class="patient-value">Client case number</span><br />
              
			  <img src="data:image/png;base64,<?php echo $patientDetails[0]->Client_case_number_barcode?>">
			   <br>
			  <span class="patient-field"> <?php echo $patientDetails[0]->test_details[0]->Client_case_number?>
			 
			  </span>
            </div>
  
  <div class="col-lg-4">
              <span class="patient-value">Visiopath case number</span><br />
              
        <img src="data:image/png;base64,<?php echo $patientDetails[0]->visiopath_case_number_barcode?>">
         <br>
        <span class="patient-field"> <?php echo $patientDetails[0]->test_details[0]->visiopath_number?>
       
        </span>
            </div>
			
			</div>		
			 <div class="row pb-4">
				 
				 
					<div class="col-lg-12">
					  <span class="patient-value">Specimen</span><br />
					  <span class="patient-field"> <?php echo nl2br($patientDetails[0]->test_details[0]->specimen_text);  ?></span>
					</div>
					</div>		
			 <div class="row pb-4">
					<div class="col-lg-12">
					  <span class="patient-value">Clinical details</span><br />
					  <span class="patient-field"> <?php echo nl2br($patientDetails[0]->test_details[0]->clinical_details);  ?></span>
					</div>
					</div>		
			 <div class="row pb-4">
					<div class="col-lg-12">
					  <span class="patient-value">Macroscopic Details</span><br />
					  <span class="patient-field"> <?php echo nl2br($patientDetails[0]->test_details[0]->macroscopic_details);  ?></span>
					</div>
					
			 </div>

        <div class="row">
          <div class="col-md-12 px-1">
                             <span class="patient-value">Request Form</span>
                            <div class="Multiple_Uploads ">
                              <?php 
                              $i = 1;
                              foreach($multipleUploads as $file){ 
                                $file_name = explode('/', $file->upload_file);

                                ?> 
                                <span class="multiple<?php echo $file->id; ?>">
                                    <?php echo $i.". "; ?> <a class="theme-color" target='_blank' href="<?php echo base_url().$file->upload_file ;?>"><?php echo $file_name[2];?></a>  
                                
                                </span><br/>

                              <?php $i++; }?>
                            </div>

                           
                          </div>
        </div>

        <?php if($this->session->userdata('roleId') == 2){?>

        <legend class="mt-5"></legend>

         <div class="row">
          <div class="col-md-12 px-1">
                             <span class="patient-value">Invoice Amount: <?php  if(empty($patientDetails[0]->test_details[0]->pathologists_fee)){echo "N/A" ; }else{  echo '£'.$patientDetails[0]->test_details[0]->pathologists_fee; } ;?></span>
                            
                          </div>
        </div>

        

        <div class="table-responsive">
			
                        <table class="table table-striped">
                                      <thead>
                                        <tr>
                                          <th>View</th>
                                          <th>Id</th>
                                          <th>Doctor name</th>
                                          <th>No of specimen</th>
                                          <th>Date Received</th>
                                          
                                        </tr>
                                      </thead>
                                      <tbody> 
									  
                                        <?php 

                                      
										
										
										foreach($patientDetails[0]->test_details as $detail){?>
                                          <tr>
                                            <td>
                                                 <?php if($detail->doctor_approval == 1){?>
                          Accepted
                         <?php }else{?>
                                                  <a class="btn btn-outline-danger btn-theme login_btn" href="<?php echo base_url()?>doctor/ApproveJobByMultipleDoctor/<?php echo $detail->test_id; ?>/<?php echo $this->session->userdata('UserDetail_Id')?>"> <?php if($autoAccept != 1 ){ echo 'Accept'; }else{ echo "Start Case" ;}?>  </a>
                                             
                                                  <a class="btn btn-outline-danger btn-theme login_btn <?php if($autoAccept == 1 ){ echo 'd-none'; }?>" href="<?php echo base_url()?>doctor/DeclineJobByDoctor/<?php echo $detail->test_id; ?>" > Decline</a>
                                                <?php }?>
                                               </td>
                                           <td>
                                                 <?php echo $detail->test_id; ?>
                                               </td>
                                               <td>
                                                <a class="profile_link" href="<?php echo base_url();?>doctor/DoctorDetails/<?php  echo $this->session->userdata('UserDetail_Id'); ?>"> <?php  echo 'Dr. '.$this->session->userdata('username')?></a>
                                               </td>
                                               
                                               <td>
                                                 <?php echo $detail->no_of_specimen ?>
                                               </td>
                                               <td>
                                                 <?php $tdate = date_create($detail->test_date); echo date_format($tdate,$dateFormat); ?>
                                               </td>
                                                
                                          </tr> <?php }?>
                                         
                                      </tbody>
                                  </table>

                                  </div>

                                <?php }?>
         


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
