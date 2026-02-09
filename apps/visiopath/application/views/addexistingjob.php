<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
  Add Existing Patient Job - LIMS
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
 <?php include('partial/head.php') ?>
</head>

<body class="">
  <div class="wrapper ">
    <?php include('partial/sidebar.php') ?>
    <div class="main-panel">
      <!-- Navbar -->
      <?php include('partial/nav.php') ?>
      <!-- End Navbar -->
      <!-- <div class="panel-header panel-header-sm">




</div> -->

<?php //print_r($patientDetails);
  
  $name = $patientDetails[0]->patient_name;
  $name = explode(" ", $name);

?>

   <div class="content">
              <div class="container-fluid">
                  <div class="row">
                      
                      <div class="col-lg-12 col-md-7">
                          <div class="card">
                              <div class="card-header">
                                  <h4 class="card-title">Add Existing Job</h4>
                              </div>
                              <div class="card-content">

                             

                <form method="post" action="<?php echo base_url();?>admin/addExistingJobDetails" accept-charset="utf-8" enctype="multipart/form-data">

                   <input type="hidden" class="form-control" name="patient_id" value="<?php echo $patientDetails[0]->patient_id ?>" required="">
                    <input type="hidden" name="company_id" value="<?php echo $this->session->userdata('company_id');?>">

                    <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Patient first name <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="Fname" value="<?php echo $patientDetails[0]->patient_name?>" placeholder="First Name"  >
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Last name <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="Lname" value="<?php echo $patientDetails[0]->last_name?>" placeholder="Last Name"  >
                      </div>
                    </div>

                    <div class="col-md-4 pl-1">

                    <div class="form-group">
                        <label>Email address  </label>
                        <input type="email" class="form-control" value="<?php echo $patientDetails[0]->email?>" name="email_address" placeholder="patient@gmail.com" >
                      </div>

                    </div>

                  
                  </div>
                   <div class="row">
                    
                    <div class="col-md-4 pr-1">
                       <div class="form-group">
                        <label>Gender  <span class="text-theme">*</span></label>
                       <select class="form-control" name="gender" required="" >
                          <option value="" >Select Gender</option>
                          <option <?php if($patientDetails[0]->gender == 'Male'){ ?> selected <?php  } ?> value="Male">Male</option>
                          <option <?php if($patientDetails[0]->gender == 'Female'){ ?> selected <?php  } ?> value="Female">Female</option>
                          <option <?php if($patientDetails[0]->gender == 'Nor'){ ?> selected <?php  } ?> value="Nor">nor Specified</option>
                        </select>
                      </div>
                    </div>
                      <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Mobile number  </label>
                        <input type="text" class="form-control" value="<?php echo $patientDetails[0]->mobile_number?>" name="mob_number" placeholder="Mobile number" >
                      </div>
                    </div>
                      <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Date of birth  <span class="text-theme">*</span></label>
                        <input type="Date" class="form-control" name="DOB" placeholder="Date Of Birth" value="<?php echo $patientDetails[0]->DateOfBirth ?>" required="" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Address 1 </label>
                        <input type="text" class="form-control" value="<?php echo $patientDetails[0]->address?>" name="address" placeholder="Address 1" >
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Address 2</label>
                        <input type="text" class="form-control"  value="<?php echo $patientDetails[0]->address_two?>" name="address_two" placeholder="Address 2" >
                      </div>
                    </div>

                     <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>NHS number  </label>
                         <input type="text" class="form-control" name="nhs_number" placeholder="NHS number" value="<?php echo $patientDetails[0]->nhs_number?>" >

                      </div>
                    </div>

                    </div>

                       
                  
                  <div class="row">

                     <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Hospital number  </label>
                         <input type="text" class="form-control" name="Hnumber" placeholder="Hosptial number" value="<?php echo $patientDetails[0]->hospital_number?>">

                      </div>
                    </div>

                    <!-- <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Specimen  <span class="text-theme">*</span></label>
                          <select class="form-control" name="specimen" >
                          <option value="">Other</option>
                          <?php foreach($typeOfTest as $type){  ?>

                          <option value="<?php echo $type->TestTypeId?>"><?php echo $type->TestTypeName ?></option>

                          <?php  }?>
                         

                        </select>
                      </div>
                    </div>-->

                      <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Client reference number  <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="Case_refrence_number" placeholder="2563584G" required="">
                      </div>
                    </div>

                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Referring institution  <span class="text-theme">*</span></label>
                        <select class="form-control" name="Rinstitute" required="">
                          <option value="" >Select institute</option>
                          <?php foreach($hospitals as $hospital){  ?>
                          <option <?php if($patientDetails[0]->hospital_id == $hospital->hospital_id){ ?> selected <?php }?> value="<?php echo $hospital->hospital_id?>">
                            <?php echo $hospital->hospital_name?></option>
                          <?php  }?>
                        </select>
                      </div>
                    </div>
                   
                     
                       
                  </div>

                  <div class="row">

                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Date received  <span class="text-theme">*</span></label>
                          <input type="Date" class="form-control" name="test_date" required="">
                      </div>
                    </div>

                      <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Case type <span class="text-theme">*</span></label>
                          <select class="form-control" name="case_type" required="">
                            <option value="0">Routine case</option>
                            <option value="1">Urgent case</option>
                        </select>
                      </div>
                    </div>

                   
                   
                     <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>No. of specimens  <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="no_of_specimen" placeholder="No of specimen" required="">
                      </div>
                    </div>
                       
                  </div>

                  <div class="row">
                    
                     <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Visiopath case number <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="visiopath_case_number" value="<?php echo $visiopath_number?>" placeholder="19VP2" required="">
                         <?php if(isset($_GET['VPexist'])){?>
                          <span style="color:#ae1a41">This Visiopath Case Number exists, please change it.</span>
                        <?php }?>
                      </div>
                    </div>

                  </div>

                  <legend></legend>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label for="exampleInputEmail1"><h4 class="card-title  mt-0 mb-0">Invoice Values: </h4> </label>
                         
                      </div>
                    </div>

                    <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "px-1"; }?>">
                      <div class="form-group">
                        <label>Pathologists Fee </label>
                        <div class="input-group">
                        
                        <span class="input-group-addon">£</span>
                        <input type="text" class="form-control" name="pathologists_fee" placeholder="Pathologists fee" >
                      </div>
                      </div>
                    </div>

                    <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "pl-1"; }?>">
                      <div class="form-group">
                        <label>Specimen Fee </label>
                         <div class="input-group">
                        
                        <span class="input-group-addon">£</span>
                        <input type="text" class="form-control" name="specimen_fee" placeholder="Specimen fee" >
                      </div></div>
                    </div>

                  </div>

                  <legend></legend>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                      <label><h4 class="card-title mt-0 mb-3">Request Form: </h4></label>
                      <input type="file" name="upload_file[]">

                      <div class="Multiple_Uploads">
                        
                    </div>

                      <button type="button" class="add_new_file mt-3 btn btn-wd btn-theme">Add New Files</button>

                        <?php if(isset($_GET['error'])){
                      echo "<span style='color:#ae1a41' class='ml-5 mb-3'>Filetype not match please use supported format </span>";
                    }?>

                 

                  </div>
                </div>
           </div>

            <legend></legend>

                  <div class="row">
                     
                     <div class="col-md-6 px-1">
                      <div class="form-group">
                        <label>Specimen</label>
                          <textarea name="specimen_text" rows="10" class="form-control" ></textarea>
                      </div>
                    </div>
          
          
                    <div class="col-md-6 px-1">
                      <div class="form-group">
                        <label>Clinical details</label>
                          <textarea name="clinical_details" rows="10" class="form-control" ></textarea>
                      </div>
                    </div>
          
          
                    <div class="col-md-12 px-1">
                      <div class="form-group">
                        <label>Macroscopic Details</label>
                          <textarea name="macroscopic_details" rows="10" class="form-control" ></textarea>
                      </div>
                    </div>
          
          
                  <div class="col-md-12 px-1">
                      <div class="form-group">
                        <label>Admin Notes</label>
                          <textarea name="notes" class="form-control" ></textarea>
                      </div>
                    </div>
                  
                  </div>

                  <div class="row">
                    <div class="update text-center">
                      <button type="submit" class="btn btn-theme btn-round">Submit</button>
                    </div>
                  </div>
                </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
  
 

    
      <?php include('partial/footer.php') ?>
    </div>
  </div>
  <!--   Core JS Files   -->
 <?php include('partial/footerscript.php') ?>
</body>

</html>

<script>
                      $(".add_new_file").on('click', function () {

                            $(".Multiple_Uploads").append('<input class="mt-3"  type="file" name="upload_file[]">');
                        });

                        $('.DeleteThisAttachment').on('click', function(){
                          var attach_id = $(this).attr('value');
                            var retVal = confirm("Are you sure you want to delete this attachment ?");
                                     if( retVal == true ) {
                                          $.ajax({url: "<?php echo base_url();?>uploadreport/DeleteThisAttachment/"+attach_id, success: function(result){
                                        $(".multiple"+attach_id).remove();
                                      }
                                    });
                                     } else {
                                        
                                     }

                        });
                    </script>
