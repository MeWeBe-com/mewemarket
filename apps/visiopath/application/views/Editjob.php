<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Edit Job - LIMS
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/select2.min.css">
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

   <div class="content">
              <div class="container-fluid">
                  <div class="row">
                      
                      <div class="col-lg-12 col-md-7">
                          <div class="card">
                              <div class="card-header">
                                  <h4 class="card-title">Edit Job # <?php echo $TestDetails[0]->test_id?></h4>
                              </div>
                              <div class="card-content">

                             

                <form method="post" action="<?php echo base_url();?>admin/EditJobDetailsByAdmin/<?php echo $TestDetails[0]->test_id?>" accept-charset="utf-8" enctype="multipart/form-data">
                  <input type="hidden" name="patient_id"  value="<?php echo $patient[0]->patient_id ?>" >
                   <?php // print_r($patient)?>
                  <div class="row">
                    <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "pr-1"; }?>">
                      <div class="form-group">
                        <label>Patient name <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="Fname" placeholder="First Name" required="" <?php if($roleId == 2 ){ ?> disabled <?php } ?> value="<?php echo $patient[0]->patient_name?>">
                      </div>
                    </div>
                    <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "px-1"; }?>">
                      <div class="form-group">
                        <label>Last name <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" name="Lname" placeholder="Last Name" required="" <?php if($roleId == 2 ){ ?> disabled <?php } ?>  value="<?php echo $patient[0]->last_name?>" >
                      </div>
                    </div> 
                  <div class="col-md-4 <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "pl-1"; }?>">
                       

                      <div class="form-group">
                        <label>Email address  </label>
                        <input type="email" class="form-control" name="email_address" <?php if($roleId == 2 ){ ?> disabled <?php } ?>  placeholder="patient@gmail.com" value="<?php echo $patient[0]->email ?>" readonly="">
                      </div>
                    </div>

                     
                  </div>
                   <div class="row">
                    <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "pr-1"; }?>">
                       <div class="form-group">
                        <label>Gender  <span class="text-theme">*</span></label>
                       <select class="form-control" name="gender" required="" <?php if($roleId == 2 ){ ?> disabled <?php } ?>>
                          <option>Select Gender</option>
                          <option value="Male" <?php if($patient[0]->gender == "Male"){?> selected="selected" <?php }?>>Male</option>
                          <option value="Female" <?php if($patient[0]->gender == "Female"){?> selected="selected" <?php }?>>Female</option>
                          <option value="Nor" <?php if($patient[0]->gender == "Nor"){?> selected="selected" <?php }?>>Not Specified</option>
                        </select>
                      </div>
                    </div>
                      <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "px-1"; }?>">
                      <div class="form-group">
                        <label>Mobile number </label>
                        <input type="text" class="form-control" <?php if($roleId == 2 ){ ?> disabled <?php } ?> name="mob_number" placeholder="Mobile number" value="<?php echo $patient[0]->mobile_number ?>" >
                      </div>
                    </div>
                      <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "pl-1"; }?>">
                      <div class="form-group">
                        <label>Hospital number</label>
                        <input type="text" class="form-control"  name="Hnumber" placeholder="Hospital Number" value="<?php echo $patient[0]->hospital_number ?>" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "pr-1"; }?>">
                      <div class="form-group">
                        <label>Address 1  </label>
                        <input type="text" class="form-control" name="address" <?php if($roleId == 2 ){ ?> disabled <?php } ?> placeholder="Address 1"  value="<?php echo $patient[0]->address ?>">
                      </div>
                    </div>
                    <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "px-1"; }?>">
                      <div class="form-group">
                        <label>Address 2</label>
                        <input type="text" class="form-control" name="address_two" <?php if($roleId == 2 ){ ?> disabled <?php } ?> placeholder="Address 2" value="<?php echo $patient[0]->address_two ?>" >
                      </div>
                    </div>
                     <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "pl-1"; }?>">
                      <div class="form-group">
                        <label>Date of birth  <span class="text-theme">*</span></label>
                        <input type="Date" class="form-control" name="DOB" <?php if($roleId == 2 ){ ?> disabled <?php } ?> placeholder="Date Of Birth" required="" value="<?php echo $patient[0]->DateOfBirth ?>">
                      </div>
                    </div>
					
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Referring institution  <span class="text-theme">* </span><?php if($roleId == 1 ){ ?>  [<a class='ajax ' href="<?php echo base_url();?>admin/AddHospital?appview">Add institute</a>] <?php }?></label>
                        <select class="form-control" <?php if($roleId == 2 ){ ?> disabled <?php } ?> name="Rinstitute" id="Rinstitute" required="">
                          <option>Select institute</option>
                          <?php foreach($hospitals as $hospital){  ?>
                          <option <?php if($TestDetails[0]->hospital_id == $hospital->hospital_id){ echo "selected"; }?> value="<?php echo $hospital->hospital_id?>"><?php echo $hospital->hospital_name?></option>
                          <?php  }?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>No. of specimens  <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" value="<?php echo $TestDetails[0]->no_of_specimen?>" name="no_of_specimen" placeholder="No of specimen" required="">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Date received  <span class="text-theme">*</span></label>
                          <input type="Date" <?php if($roleId == 2 ){ ?> disabled <?php } ?> class="form-control"  value="<?php echo $TestDetails[0]->test_date?>" name="test_date" required="">
                      </div>
                    </div>
                       
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Client reference number  <span class="text-theme">*</span></label>
                        <input type="text" class="form-control" <?php if($roleId == 2 ){ ?> disabled <?php } ?> value="<?php echo $TestDetails[0]->Client_case_number?>" name="Case_refrence_number" placeholder="2563584G" required="">
                      </div>
                    </div>
                        <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Case type <span class="text-theme">*</span></label>
                          <select class="form-control" <?php if($roleId == 2 ){ ?> disabled <?php } ?> name="case_type" required="">
                            <option <?php if($TestDetails[0]->urgent == 1){ ?> selected <?php }?> value="1">Urgent case</option>
                            <option <?php if($TestDetails[0]->urgent == 0){ ?> selected <?php }?> value="0">Routine case</option>
                        </select>
                      </div>
                    </div>
                     <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Visiopath case number <span class="text-theme">*</span></label>
                        <input type="text" <?php if($roleId == 2 ){ ?> disabled <?php } ?> class="form-control" value="<?php echo $TestDetails[0]->visiopath_number?>" name="visiopath_case_number" placeholder="19VP2" required="">
                        <?php if(isset($_GET['VPexist'])){?>
                          <span style="color:#ae1a41">This Visiopath Case Number exists, please change it.</span>
                        <?php }?>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                     
                   <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "pr-1"; }?>">
                      <div class="form-group">
                        <label>NHS number</label>
                        <input type="text" class="form-control" name="nhs_number"  value="<?php echo $patient[0]->nhs_number?>">
                      </div>
                    </div>

                    <div class="col-md-4 px-1" <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "px-1"; }?>>
                      <div class="form-group">
                        <label>Select Doctor<span class="text-theme"></span></label>

                         <select <?php if($roleId == 2 ){ ?> disabled <?php } ?> class="form-control select2" multiple="multiple" Placeholder="Unassign" name="doctor_id[]" >
                          <?php foreach($doctors as $doctor){ 
                             $selected = '';
                              if(in_array($doctor->doctor_id, array_column($Assigndoctors, 'doctor_id'))) { // search value in the array
                                $selected = "selected";
                               }
                           ?>
                          <option <?php if($TestDetails[0]->doctor_id == $doctor->doctor_id){ echo "selected"; }?> <?php echo $selected;?> value="<?php echo $doctor->doctor_id?>"><?php echo 'Dr. '.$doctor->doctor_name?></option>
                          <?php  }?>
                        </select>
                      </div>
                    </div>

                  </div>


                  <legend></legend>

                  <div class="row">
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><label><h4 class="card-title mb-0 mt-0">Invoice Values: </h4></label> </label>
                           
                        </div>
                    </div>

                    <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "px-1"; }?>">
                      <div class="form-group">
                        <label>Pathologists Fee </label>
                         <div class="input-group">
                        
                        <span class="input-group-addon">£</span>
                        <input type="text" class="form-control" name="pathologists_fee" placeholder="Pathologists fee"  <?php if($roleId == 2 ){?> readonly <?php }?>   value="<?php
                        if(!empty($TestDetails[0]->pathologists_fee)){  echo ' '.$TestDetails[0]->pathologists_fee ; }?> ">
                        
                      </div>
                       </div>
                    </div>

                <?php if($roleId == 1 ){?>
                    <div class="col-md-4  <?php if($this->agent->is_mobile()){ echo "px-1" ; }else{ echo "pr-1"; }?>">
                      <div class="form-group">
                        <label>Specimen Fee </label>
                         <div class="input-group">
                        
                        <span class="input-group-addon">£</span>
                        <input type="text" class="form-control" name="specimen_fee" placeholder="Specimen fee" value="<?php echo $TestDetails[0]->specimen_fee?>" >
                      </div>
                      </div>
                    </div>
                <?php }?>

                    


                  </div>

                   <legend></legend>


                  <?php if($roleId == 1 ){ ?>  
                       <div class="row mb-3">
                          <div class="col-md-12 px-1">
                             <label><h4 class="card-title mb-4 mt-0">Request Form: </h4></label>
                           <?php if(empty($multipleUploads)){?>  <input type="file" name="upload_file[]"><?php }?>
                            <div class="Multiple_Uploads ">
                              <?php 
                              $i = 1;
                              foreach($multipleUploads as $file){ 
                                $file_name = explode('/', $file->upload_file);

                                ?> 
                                <span class="multiple<?php echo $file->id; ?>">
                                    <?php echo $i.". "; ?> <a class="theme-color" href="<?php echo base_url().$file->upload_file ;?>"><?php echo $file_name[2];?></a>  
                                    <a  class="DeleteThisAttachment theme-color" title="Delete This Attcahment" value="<?php echo $file->id; ?>">
                                                          <i class="ti-close"></i>
                                                        </a>
                                </span><br/>

                              <?php $i++; }?>
                            </div>

                            <button type="button" class="add_new_file mt-3 btn btn-wd btn-theme">Add New Files</button>
                          </div>
                       </div>

                        <legend></legend>

                    <?php }?>

                  <div class="row mt-3">

                  <!--  <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Select Specimen</label>
                         <select class="form-control" name="specimen">
                          <option value="">Other</option>
                          <?php foreach($typeOfTest as $test){  ?>
                          <option <?php if($TestDetails[0]->specimen == $test->TestTypeId){ echo "selected"; }?> value="<?php echo $test->TestTypeId?>"><?php echo $test->TestTypeName ;?></option>
                          <?php  }?>
                        </select>
                      </div>
                    </div>-->



					          <div class="col-md-6 px-1">
                      <div class="form-group">
                        <label>Specimen</label>
                          <textarea name="specimen_text" rows="10" class="form-control" ><?php echo $TestDetails[0]->specimen_text?></textarea>
                      </div>
                    </div>
					
					
					          <div class="col-md-6 px-1">
                      <div class="form-group">
                        <label>Clinical details</label>
                          <textarea name="clinical_details" rows="10" class="form-control" ><?php echo $TestDetails[0]->clinical_details?></textarea>
                      </div>
                    </div>
					
					          <div class="col-md-12 px-1">
                      <div class="form-group">
                        <label>Macroscopic Details</label>
                          <textarea name="macroscopic_details"  class="form-control" rows="10"><?php echo $TestDetails[0]->macroscopic_details?></textarea>
                      </div>
                    </div>
					<?php if($roleId == 1 ){ ?>  
					          <div class="col-md-12 px-1">
                      <div class="form-group">
                        <label>Admin Notes</label>
                          <textarea name="notes" class="form-control"  ><?php echo $TestDetails[0]->notes?></textarea>
                      </div>
                    </div>


          <?php } ?>        
                  </div>



        

                


                  <div class="row">
                    <div class="update text-center">
                      <button type="submit" class="btn btn-wd btn-theme">Submit</button>
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

 <script>
 
$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

})
</script>
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
                                          $.ajax({url: "<?php echo base_url();?>admin/DeleteAdminFileById/"+attach_id, success: function(result){
                                        $(".multiple"+attach_id).remove();
                                      }
                                    });
                                     } else {
                                        
                                     }

                        });
                    </script>
