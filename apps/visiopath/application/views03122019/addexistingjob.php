<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
  Add New Job - LIMS
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

                             

                <form method="post" action="<?php echo base_url();?>admin/addExistingJobDetails">

                   <input type="hidden" class="form-control" name="patient_id" value="<?php echo $patientDetails[0]->patient_id ?>" required="">
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>First name <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="Fname" value="<?php echo $name[0]?>" placeholder="First Name" required="">
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Last name</label>
                        <input type="text" class="form-control" name="Lname" value="<?php echo $name[1]?>" placeholder="Last Name" >
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Specimen  <span class="text-theme">*</span></label>
                          <select class="form-control" name="specimen" required="">
                          <option>Select specimen</option>
                          <?php foreach($typeOfTest as $type){  ?>

                          <option value="<?php echo $type->TestTypeId?>"><?php echo $type->TestTypeName ?></option>

                          <?php  }?>

                        </select>
                      </div>
                    </div>
                  </div>
                   <div class="row">
                    <div class="col-md-4 pr-1">

                    <div class="form-group">
                        <label>Email address  <span class="text-theme">*</span></label>
                        <input type="email" class="form-control" value="<?php echo $patientDetails[0]->email?>" name="email_address" required="" placeholder="patient@gmail.com">
                      </div>

                    </div>
                    <div class="col-md-4 px-1">
                       <div class="form-group">
                        <label>Gender  <span class="text-theme">*</span></label>
                       <select class="form-control" name="gender" required="">
                          <option>Select Gender</option>
                          <option <?php if($patientDetails[0]->gender == 'Male'){ ?> selected <?php  } ?> value="Male">Male</option>
                          <option <?php if($patientDetails[0]->gender == 'Female'){ ?> selected <?php  } ?> value="Female">Female</option>
                          <option <?php if($patientDetails[0]->gender == 'Nor'){ ?> selected <?php  } ?> value="Nor">nor Specified</option>
                        </select>
                      </div>
                    </div>
                      <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Mobile number  <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" value="<?php echo $patientDetails[0]->mobile_number?>" name="mob_number" placeholder="Mobile number" required="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Address 1  <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" value="<?php echo $patientDetails[0]->address?>" name="address" placeholder="Address 1" required="">
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
                        <label>Date of birth  <span class="text-theme">*</span></label>
                        <input type="Date" class="form-control" name="DOB" placeholder="Date Of Birth" value="<?php echo $patientDetails[0]->DateOfBirth ?>" required="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Referring institution  <span class="text-theme">*</span></label>
                        <select class="form-control" name="Rinstitute" required="">
                          <option>Select institute</option>
                          <?php foreach($hospitals as $hospital){  ?>
                          <option <?php if($patientDetails[0]->hospital_id == $hospital->hospital_id){ ?> selected <?php }?> value="<?php echo $hospital->hospital_id?>">
                            <?php echo $hospital->hospital_name?></option>
                          <?php  }?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>No. of specimens  <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="no_of_specimen" placeholder="No of specimen" required="">
                      </div>
                    </div>
                       <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Amount  <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="amount" placeholder="amount" required="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Hosptial number  <span class="text-theme">*</span></label>
                         <input type="text" class="form-control" name="Hnumber" placeholder="Hosptial number" required="">

                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Case reference number  <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="Case_refrence_number" placeholder="2563584G" required="">
                      </div>
                    </div>
                      <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Type of test  <span class="text-theme">*</span></label>
                           <select class="form-control" name="type_of_test" required="">
                          <option>Select Type of test</option>
                          <?php foreach($typeOfTest as $type){  ?>

                          <option value="<?php echo $type->TestTypeId?>"><?php echo $type->TestTypeName ?></option>

                          <?php  }?>

                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                     <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Test date  <span class="text-theme">*</span></label>
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

                       <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Visiopath case number <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="visiopath_case_number" placeholder="19VP2" required="">
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
