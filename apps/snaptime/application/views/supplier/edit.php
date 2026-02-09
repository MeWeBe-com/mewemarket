<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>Edit <?php echo $supplier->name; ?> | Scruffy Dog</title>
    <!--  Fonts and icons -->
    <?php $this->load->view('partial/head.php')?>


</head>
<body class="perfect-scrollbar-on">

    <!-- Main Container -->
    <div class="wrapper">

        <!-- Main SideBar Menu -->
         <?php  $this->load->view('partial/sidebar.php') ;?>
        <!-- Body Content Start-->
        <div class="main-panel">

              <?php  $this->load->view('partial/navbar.php') ;?>

    <div class="content pt-4 mt-1">
   <!--  <div class="row" style="margin-bottom:10px;"> -->
        <div class="col-lg-12 tx_bold6 p-0 text-capti">
            <?php if($this->session->userdata('role') != 'Supplier'){ ?>
                <a class="text-red text-capitalize" href="<?php echo base_url('supplier/')?>">External resource</a>
            <?php }else{
                echo "External resource";
            }?><span class="arrowCrumb"> /</span>
             Edit <?php echo $supplier->name; ?>

            <div class="space10"></div>
        </div>
   <!--  </div> -->
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title tx_bold6">Edit <?php echo $supplier->name; ?> </h4>
                    </div>
                    <div class="w-100 over_hidden"><hr></div>
                    <div class="card-content pt-0">
                        <form action="<?php echo base_url('supplier/store');?>"  method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $supplier->id ?>">
                            <div class="card-body js-animateCards animateCards animate-now">
                                
                                <?php if($this->session->userdata('role') != 'Supplier'){?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group custom_select_box">
                                            <label>Type <span class="text-light">*</span></label>
                                            <select class="form-control selectpicker" name="supplier_type_id">

                                                <?php foreach($supplier_type as $type){?>
                                                    <option value="<?php echo $type->id;?>" <?php echo $supplier->supplier_type_id == $type->id ? 'selected' : '' ?> ><?php echo $type->name;?></option><?php }?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Accounts Code</label>
                                            <input class="form-control border-input" maxlength="10" name="accounts_code" placeholder="Type Accounts Code" type="text" value="<?php echo $supplier->accounts_code; ?>">

                                        </div>
                                    </div>
                                </div> <?php }?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name <span class="text-light">*</span></label>
                                            <input class="form-control border-input" id="CompanyName" name="name" placeholder="Type Supplier Name" type="text" value="<?php echo $supplier->name; ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email <span class="text-light">*</span></label>
                                            <input class="form-control " maxlength="50" name="email" placeholder="Type Email Address" type="email" value="<?php echo $supplier->email; ?>">

                                        </div>
                                    </div>
                                </div>

                                <?php if($this->session->userdata('role') != 'Supplier'){ ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number <span class="text-light">*</span></label>
                                                <input class="form-control" name="phone_number" value="<?php echo $supplier->phone_number; ?>" placeholder="Type Your Phone Number" type="text"  required="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Website</label>
                                                <input class="form-control" type="url" value="<?php echo isset($supplier->url) ? $supplier->url : ''; ?>" name="website" placeholder="Type Your Website " >
                                            </div>
                                        </div>
                                    </div>


                                <?php }?>

                                <div class="row">
                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password <span class="text-light">*</span></label>
                                            <input style="cursor:pointer;" class="form-control picker__input" id="password"  name="password" placeholder="Enter Password" type="Password" required="" value="<?php echo $supplier->password; ?>"></div>

                                    </div>

                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm Password <span class="text-light">*</span></label>
                                        <input class="form-control" required="" id="confirmpassword"  type="password"  placeholder="Enter Confirm Password" value="<?php echo $supplier->password; ?>">
                                    <span class="text-danger"  id="Confirmerror" ></span>                                     
                                    </div>
                                </div>

                                </div> <?php if($this->session->userdata('role') != 'Supplier'){?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Upload Resume(CV) </label>
                                                <?php if(!empty($supplier->resume)){?>
                                                <a download href="<?php echo base_url('assets/supplier/'.$supplier->resume)?>" class="text-red text-underline pull-right">View Original Upload </a>
                                                <?php }?>
                                                <input class="form-control" name="resume"  type="file" >
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group z-index-15">
                                                <label>Type of Trade <span class="text-light">*</span></label>
                                                <select class="form-control selectpicker" data-live-search="true" name="trade_id" required>
                                                    <?php foreach($supplier_trade as $type){?>
                                                        <option <?php if($type->trade_id == $supplier->trade_id){ echo 'selected'; }?> value="<?php echo $type->trade_id;?>"><?php echo $type->trade_name;?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address <span class="text-light">*</span></label>
                                                <input class="form-control" type="text" value="<?php echo $supplier->address; ?>" name="address" placeholder="Type Your Address Here" required="">

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City <span class="text-light">*</span></label>
                                                <input class="form-control" type="text" value="<?php echo $supplier->city; ?>" name="city" placeholder="Type Your City Name Here" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>State/Province <span class="text-light">*</span></label>
                                                <input class="form-control" type="text" value="<?php echo $supplier->state; ?>" name="state" placeholder="Type Your State/Province Here" required="">

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Postal Code <span class="text-light">*</span></label>
                                                <input class="form-control" type="text" value="<?php echo $supplier->zipcode; ?>" name="zipcode" placeholder="Type Your Postal Code Here" required="">
                                            </div>
                                        </div>
                                    </div>

                                <div class="row">

                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Date <span class="text-light">*</span></label>
                                            <input style="cursor:pointer;" class="form-control picker__input"  name="start_date" placeholder="Select Start Date" type="date" value="<?php $date = date_create($supplier->start_date); echo date_format($date, 'Y-m-d') ?>"></div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group custom_select_box">
                                            <label>Department <span class="text-light">*</span></label>
                                            <select class="form-control selectpicker" name="department_type_id">

                                                <?php foreach($supplier_department as $department){?>
                                                    <option value="<?php echo $department->id;?>" <?php echo $supplier->department_id == $department->id ? 'selected' : '' ?> ><?php echo $department->name;?></option>
                                                <?php }?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Unit Payment Rate</label>
                                            <input class="form-control border-input" id="DailyRate" maxlength="100" name="unit_payment_rate" placeholder="Type Unit Payment Rate" type="number" value="<?php echo $supplier->unit_payment_rate; ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">  <div class="col-md-3  col-xs-6">
                                            <div class="form-group mb-0 clearfix">
                                                <label class="w-100">Skills</label>
                                                <div class="rate">
                                                    <input data-val="true" data-val-number="The field RatingSkill must be a number." data-val-required="The RatingSkill field is required." <?php echo $supplier->skills==5 ? 'checked="checked"' : ''; ?> id="skill5" name="skills" type="radio" value="5">
                                                    <label for="skill5" value="5">skill5</label>

                                                    <input id="skill4" name="skills" type="radio" value="4" <?php echo $supplier->skills==4 ? 'checked' : ''; ?>>
                                                    <label for="skill4" value="4">skill4</label>

                                                    <input id="skill3" name="skills" type="radio" value="3" <?php echo $supplier->skills==3 ? 'checked' : ''; ?>>
                                                    <label for="skill3" value="3">skill3</label>

                                                    <input id="skill2" name="skills" type="radio" value="2" <?php echo $supplier->skills==2 ? 'checked' : ''; ?>>
                                                    <label for="skill2" value="2">skill2</label>

                                                    <input id="skill1" name="skills" type="radio" value="1" <?php echo $supplier->skills==1 ? 'checked' : ''; ?>>
                                                    <label for="skill1" value="1">skill1</label>

                                                    <input id="skill0" name="skills" type="radio" value="0" <?php echo $supplier->skills==0 ? 'checked' : ''; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3  col-xs-6">
                                            <div class="form-group mb-0 clearfix">
                                                <label class="w-100">Quality</label>
                                                <div class="rate">
                                                    <input data-val="true" data-val-number="The field RatingQuality must be a number." <?php echo $supplier->quality==5 ? 'checked' : ''; ?> data-val-required="The RatingQuality field is required." id="quality5" name="quality" type="radio" value="5">
                                                    <label for="quality5" value="5">quality5</label>

                                                    <input id="quality4" name="quality" type="radio" value="4" <?php echo $supplier->quality==4 ? 'checked' : ''; ?>>
                                                    <label for="quality4" value="4">quality4</label>

                                                    <input id="quality3" name="quality" type="radio" value="3" <?php echo $supplier->quality==3 ? 'checked' : ''; ?>>
                                                    <label for="quality3" value="3">quality3</label>

                                                    <input id="quality2" name="quality" type="radio" value="2" <?php echo $supplier->quality==2 ? 'checked' : ''; ?>>
                                                    <label for="quality2" value="2">quality2</label>

                                                    <input id="quality1" name="quality" type="radio" value="1" <?php echo $supplier->quality==1 ? 'checked' : ''; ?>>
                                                    <label for="quality1" value="1">quality1</label>

                                                    <input id="quality0" name="quality" type="radio" value="0" <?php echo $supplier->quality==0 ? 'checked' : ''; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3  col-xs-6">
                                            <div class="form-group mb-0 clearfix">
                                                <label class="w-100">Teamwork</label>
                                                <div class="rate">
                                                    <input data-val="true" data-val-number="The field RatingTeamwork must be a number." <?php echo $supplier->teamwork==5 ? 'checked' : ''; ?> data-val-required="The RatingTeamwork field is required." id="teamwork5" name="teamwork" type="radio" value="5">
                                                    <label for="teamwork5" value="5">teamwork5</label>

                                                    <input id="teamwork4" name="teamwork" type="radio" value="4" <?php echo $supplier->teamwork==4 ? 'checked' : ''; ?>>
                                                    <label for="teamwork4" value="4">teamwork4</label>

                                                    <input id="teamwork3" name="teamwork" type="radio" value="3" <?php echo $supplier->teamwork==3 ? 'checked' : ''; ?>>
                                                    <label for="teamwork3" value="3">teamwork3</label>

                                                    <input id="teamwork2" name="teamwork" type="radio" value="2" <?php echo $supplier->teamwork==2 ? 'checked' : ''; ?>>
                                                    <label for="teamwork2" value="2">teamwork2</label>

                                                    <input id="teamwork1" name="teamwork" type="radio" value="1" <?php echo $supplier->teamwork==1 ? 'checked' : ''; ?>>
                                                    <label for="teamwork1" value="1">teamwork1</label>

                                                    <input  id="teamwork0" name="teamwork" type="radio" value="0" <?php echo $supplier->teamwork==0 ? 'checked' : ''; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3  col-xs-6">
                                            <div class="form-group mb-0 clearfix">
                                                <label class="w-100">Speed</label>
                                                <div class="rate">
                                                    <input data-val="true" data-val-number="The field RatingSpeed must be a number." <?php echo $supplier->speed==5 ? 'checked' : ''; ?> data-val-required="The RatingSpeed field is required." id="speed5" name="RatingSpeed" type="radio" value="5">
                                                    <label for="speed5" value="5">speed5</label>

                                                    <input id="speed4" name="speed" type="radio" value="4" <?php echo $supplier->speed==4 ? 'checked' : ''; ?>>
                                                    <label for="speed4" value="4">speed4</label>

                                                    <input id="speed3" name="speed" type="radio" value="3" <?php echo $supplier->speed==3 ? 'checked' : ''; ?>>
                                                    <label for="speed3" value="3">speed3</label>

                                                    <input id="speed2" name="speed" type="radio" value="2" <?php echo $supplier->speed==2 ? 'checked' : ''; ?>>
                                                    <label for="speed2" value="2">speed2</label>

                                                    <input id="speed1" name="speed" type="radio" value="1" <?php echo $supplier->speed==1 ? 'checked' : ''; ?>>
                                                    <label for="speed1" value="1">speed1</label>
                                                    <input id="speed0" name="speed" type="radio" value="0" <?php echo $supplier->speed==0 ? 'checked' : ''; ?>>
                                                </div>
                                            </div>
                                        </div></div>
                                    <div class="row col-lg-12 pr-0">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>NDA</label>
                                                <input class="form-control" type="file" name="nda">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Starter form</label>
                                                <input class="form-control" type="file" name="starter_form">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row col-lg-12 pr-0">
                                        <?php  if (isset($supplier->nda))
                                        { ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>NDA Document</label>
                                                <br>
                                                <a class="text-red" href="<?php echo base_url('files/download/'.$supplier->id.'/'.$supplier->nda)?>"><?php echo $supplier->nda;?></a> -
                                                <input type="checkbox" class="" value="1" <?php echo $supplier->nda_status == 1 ? 'checked' :'' ?> name="nda_status"> Approve Supplier Documents
                                            </div>
                                        </div>
                                        <?php }if (isset($supplier->starter_form)){ ?>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Starter form</label>
                                                <br>
                                                <a class="text-red" href="<?php echo base_url('files/download/'.$supplier->id.'/'.$supplier->starter_form)?>"><?php echo $supplier->starter_form; ?></a> -
                                                <input type="checkbox" class=""  value="1" <?php echo $supplier->starter_form_status ==1 ? 'checked' :'' ?> name="starter_form_status"> Approve Supplier Documents
                                            </div>
                                        </div>
                                        <?php } ?>


                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12"><div class="form-group">
                                            <label>Notes:</label>
                                            <textarea class="form-control border-input" cols="20" id="Notes" name="notes" placeholder="Type Notes" rows="5" type="text"><?php echo $supplier->notes; ?></textarea>

                                        </div></div>
                                    
                                </div>  <?php }?>
                                <div class="row">
                                <hr>
                                </div>
                                <!-- <h4 style="margin-bottom: 10px;margin-top: 10px;">Mandatory Qualifications &amp; Policies</h4>
                                 <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <h6>Qualifications</h6>
                                             <table>
                                                     <tbody><tr>
                                                         <td>
                                                             <input class="QualificationCheckbox" type="checkbox" name="Qualifications" value="1"> Trial assessment<br>
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <td>
                                                             <input class="QualificationCheckbox" type="checkbox" name="Qualifications" value="2"> Toolbox<br>
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <td>
                                                             <input class="QualificationCheckbox" type="checkbox" name="Qualifications" value="4"> Scruffy Dog induction<br>
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <td>
                                                             <input class="QualificationCheckbox" type="checkbox" name="Qualifications" value="3"> Health &amp; Safety test<br>
                                                         </td>
                                                     </tr>
                                             </tbody></table>

                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <h6>Policies</h6>
                                             <table>
                                                     <tbody><tr>
                                                         <td>
                                                             <input class="RatingCheckbox" type="checkbox" name="Ratings" value="3"> Employers Liability Insurance<br>
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <td>
                                                             <input class="RatingCheckbox" type="checkbox" name="Ratings" value="4"> Public Liability Insurance<br>
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <td>
                                                             <input class="RatingCheckbox" type="checkbox" name="Ratings" value="5"> Commercial Insurance<br>
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <td>
                                                             <input class="RatingCheckbox" type="checkbox" name="Ratings" value="6"> Health and safety policy<br>
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <td>
                                                             <input class="RatingCheckbox" type="checkbox" name="Ratings" value="2"> Professional Indemnity Insurance<br>
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <td>
                                                             <input class="RatingCheckbox" type="checkbox" name="Ratings" value="1"> Credit Score<br>
                                                         </td>
                                                     </tr>
                                             </tbody></table>
                                         </div>
                                     </div>
                                 </div>
                                 <hr>
                                 <h4 style="margin-bottom: 10px;margin-top: 10px;">Bank Details</h4>
                                 <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label>Bank or Building society address</label>
                                             <textarea class="form-control border-input" cols="20" placeholder="Type Bank or Building society address" rows="2" type="text"></textarea>

                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label>Postcode</label>
                                             <input class="form-control "  maxlength="10" name="BankPostCode" placeholder="Type Postcode" type="text" value="">

                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label>Account Name</label>
                                             <input class="form-control border-input" id="BankAccountName" name="BankAccountName" placeholder="Type Account Name" type="text" value="">

                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label>Account No</label>
                                             <input class="form-control " id="BankAccountNo" maxlength="20" name="BankAccountNo" placeholder="Type Account No" type="text" value="">

                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label>Sort Code</label>
                                             <input class="form-control border-input" id="BankSortCode" name="BankSortCode" placeholder="Type Sort Code" type="text" value="">

                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label>IBAN</label>
                                             <input class="form-control " id="BankIBAN" maxlength="20" name="BankIBAN" placeholder="Type IBAN" type="text" value="">

                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label>SWIFT</label>
                                             <input class="form-control border-input" id="BankSwift" name="BankSwift" placeholder="Type SWIFT" type="text" value="">

                                         </div>
                                     </div>
                                 </div> -->
                            </div>
                            <div class="clearfix"></div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <button type="submit" id="save"  class="btn btn-wd btn-info btn-fill bg-color has-loader">
                                    <span class="btn-label">
                                        <i class="ti-reload"></i>
                                    </span>
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>                </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Footer Bar Start -->
     <?php  $this->load->view('partial/footer.php'); ?>
    <!-- Footer Bar End -->
        </div>
    </div>

    <?php  $this->load->view('partial/footerscript.php');
    ?>

</body>
</html>
