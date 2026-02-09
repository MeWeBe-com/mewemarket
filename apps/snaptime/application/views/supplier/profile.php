<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <title>View <?php echo($supplier->name); ?> | Scruffy Dog</title>
    <!--  Fonts and icons -->
    <?php $this->load->view('partial/head.php') ?>

</head>
<body class="perfect-scrollbar-on">
<!-- Main Container -->
<!-- Main Container -->
<div class="wrapper">

    <!-- Main SideBar Menu -->
    <?php $this->load->view('partial/sidebar.php'); ?>
    <!-- Body Content Start-->
    <div class="main-panel">
        <div class="col-md-12 p-0">
            <!-- Top Menu Bar Start -->
            <?php $this->load->view('partial/navbar.php'); ?>

        </div>
        <!-- Top Menu Bar ENd -->

        <div class="">
            <div class="col-lg-12 p-0">
                <div class="space10"></div>
                <div class="col-lg-12 tx_bold6 text-capti">
                    <?php if($this->session->userdata('role') != 'Supplier'){ ?>
                    <a class="text-red text-capitalize" href="<?php echo base_url('supplier/')?>">External resource </a>
                    <?php }else{
                        echo " External resource";
                    }?> /
                    <?php echo($supplier->name); ?>
                </div>

                <div class="space10"></div>
                <div class="col-lg-12 ">
                    <div class="card">
                        <div class="col-lg-12 col-md-8">
                            <div class="card-content  table-full-width">
                                <div class="card-header row pt-0">
                                    <div class="col-md-6  col-sm-6 col-xs-12 p-0">

                                        <h4 class="card-title tx_bold6 text-capti">
                                            <?php echo($supplier->name); ?>
                                        </h4>

                                        <div class="pb-3">Joined Date: <?php $date = date_create($supplier->created_at);
                                                echo date_format($date, 'F dS Y'); ?> </div>

                                        <div class="pb-3 pt-3 pb-3">
                                            <span>Skills: <div class="rate" style="padding-top:4px;height:23px;display: inline-block !important;float:none ">
                                                            <input   <?php if($supplier->skills == 5) { echo 'checked' ; }?> id="skill5" name="skills" type="radio" value="5">
                                                            <label class="disabledStar" for="skill5" value="5">skill5</label>

                                                            <input  id="skill4" name="skills" type="radio" value="4" <?php if($supplier->skills == 4) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="skill4" value="4">skill4</label>

                                                            <input   id="skill3" name="skills" type="radio" value="3" <?php if($supplier->skills == 3) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="skill3" value="3">skill3</label>

                                                            <input  id="skill2" name="skills" type="radio" value="2" <?php if($supplier->skills == 2) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="skill2" value="2">skill2</label>

                                                            <input  id="skill1" name="skills" type="radio" value="1" <?php if($supplier->skills == 1) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="skill1" value="1">skill1</label>

                                                            <input disabled="true" id="skill0" name="skills" type="radio" value="0" <?php if($supplier->skills == 0) { echo 'checked="true"' ; }?>>
                                                        </div>
                                            </span>
                                        </div>

                                        <div class="pb-3 pt-3 pb-3"> <span>Teamwork: <div class="rate" style="padding-top:4px;height:23px;display: inline-block !important;float:none ">
                                                            <input   <?php if($supplier->teamwork == 5) { echo 'checked' ; }?> id="teamwork5" name="teamwork" type="radio" value="5">
                                                            <label class="disabledStar" for="teamwork5" value="5">skill5</label>

                                                            <input  id="teamwork4" name="teamwork" type="radio" value="4" <?php if($supplier->teamwork == 4) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="teamwork4" value="4">skill4</label>

                                                            <input   id="teamwork3" name="teamwork" type="radio" value="3" <?php if($supplier->teamwork == 3) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="teamwork3" value="3">skill3</label>

                                                            <input  id="teamwork2" name="teamwork" type="radio" value="2" <?php if($supplier->teamwork == 2) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="teamwork2" value="2">skill2</label>

                                                            <input  id="teamwork1" name="teamwork" type="radio" value="1" <?php if($supplier->teamwork == 1) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="teamwork1" value="1">skill1</label>

                                                            <input disabled="true" id="teamwork0" name="teamwork" type="radio" value="0" <?php if($supplier->teamwork == 0) { echo 'checked="true"' ; }?>>
                                                        </div></span>
                                        </div>
                                        <div class="pb-3 pt-3 pb-3">
                                            <span>Email: <a class="text-red text-underline" href="mailto:<?php echo ($supplier->email)?>"><?php echo ($supplier->email)?></a> </span>
                                        </div>
                                        <?php if(isset($supplier->starter_form)){?>
                                        <div class="pb-3 pt-3 pb-3">
                                            <span>Starter Form: <a class="text-red text-underline" href="<?php echo base_url('files/download/'.$supplier->id.'/'.$supplier->starter_form)?>"><?php echo ($supplier->starter_form)?></a> <?php if($supplier->starter_form_status ==1){?><i class="ti ti-check">Approved Supplier Document</i> <?php } ?> </span>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="col-md-6  col-sm-6 col-xs-12 p-0 text-left mt-2">

                                        <div class="col-md-12  col-sm-6 col-xs-12 pt-3 pb-3">
                                                <span>Phone Number: <a class="text-red text-underline" href="tel:<?php echo ($supplier->phone_number)?>"><?php echo ($supplier->phone_number)?></a> </span>
                                        </div>
                                        <div class="col-md-12  col-sm-6 col-xs-12 pt-3 pb-3">
                                            <span>Website: <a class="text-red text-underline" href="<?php echo ($supplier->website)?>"><?php echo ($supplier->website)?></a> </span>
                                        </div>

                                        <div class="col-md-12  col-sm-6 col-xs-12 pt-3 pb-3">
                                            <span>Quality: <div class="rate" style="padding-top:4px;height:23px;display: inline-block !important;float:none ">
                                                            <input <?php if($supplier->quality == 5) { echo 'checked' ; }?> id="quality5" name="quality" type="radio" value="5">
                                                            <label class="disabledStar" for="quality5" value="5">skill5</label>

                                                            <input  id="quality4" name="quality" type="radio" value="4" <?php if($supplier->quality == 4) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="quality4" value="4">skill4</label>

                                                            <input   id="quality3" name="quality" type="radio" value="3" <?php if($supplier->quality == 3) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="quality3" value="3">skill3</label>

                                                            <input  id="quality2" name="quality" type="radio" value="2" <?php if($supplier->quality == 2) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="quality2" value="2">skill2</label>

                                                            <input  id="quality1" name="quality" type="radio" value="1" <?php if($supplier->quality == 1) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="quality1" value="1">skill1</label>

                                                            <input disabled="true" id="quality0" name="quality" type="radio" value="0" <?php if($supplier->quality == 0) { echo 'checked="true"' ; }?>>
                                                        </div></span>
                                        </div>

                                        <div class="col-md-12  col-sm-6 col-xs-12 pt-3 pb-3">
                                            <span>Speed: <div class="rate" style="padding-top:4px;height:23px;display: inline-block !important;float:none ">
                                                            <input <?php if($supplier->speed == 5) { echo 'checked' ; }?> id="speed5" name="speed" type="radio" value="5">
                                                            <label class="disabledStar" for="speed5" value="5">skill5</label>

                                                            <input  id="speed4" name="speed" type="radio" value="4" <?php if($supplier->speed == 4) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="speed4" value="4">skill4</label>

                                                            <input   id="speed3" name="speed" type="radio" value="3" <?php if($supplier->speed == 3) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="speed3" value="3">skill3</label>

                                                            <input  id="speed2" name="speed" type="radio" value="2" <?php if($supplier->speed == 2) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="speed2" value="2">skill2</label>

                                                            <input  id="speed1" name="speed" type="radio" value="1" <?php if($supplier->speed == 1) { echo 'checked="true"' ; }?>>
                                                            <label class="disabledStar" for="speed1" value="1">skill1</label>

                                                            <input disabled="true" id="speed0" name="speed" type="radio" value="0" <?php if($supplier->speed == 0) { echo 'checked="true"' ; }?>>
                                                        </div> </span>
                                        </div>
                                        <div class="col-md-12  col-sm-6 col-xs-12 pt-3 pb-3">
                                            <span>Supplier Type: <a class="text-red text-underline" ><?php echo (isset($supplier_type->name)? $supplier_type->name  :'')?></a> </span>
                                        </div>
                                        <?php if(isset($supplier->nda)){?>
                                        <div class="col-md-12  col-sm-6 col-xs-12 pt-3 pb-3">
                                            <span>NDA Document <a class="text-red text-underline" href="<?php echo base_url('files/download/'.$supplier->id.'/'.$supplier->nda)?>" ><?php echo (isset($supplier->nda)? $supplier->nda  :'')?></a> <?php if($supplier->nda_status == 1){ ?><i class="ti ti-check">Approved Supplier Document</i> <?php } ?></span>
                                        </div>
                                        <?php } ?>
                                 </div>
                        </div>
<!--                        <div class="col-lg-3 col-md-4">-->
<!---->
<!--                            <div class=" ">-->
<!--                                <div class="card-content pt-0 pb-0">-->
<!--                                    <ul class="list-unstyled team-members">-->
<!--                                        <li>-->
<!--                                            <div class="row">-->
<!--                                                <div class="col-xs-3">-->
<!---->
<!--                                                </div>-->
<!--                                                <div class="col-xs-6 mt-3 ml-3">-->
<!--                                                    --><?php //echo($supplier->name); ?>
<!--                                                    <br>-->
<!--                                                    <span class="text-success"> <small>Online</small></span>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </li>-->
<!---->
<!---->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>

            </div>
        </div>

        <div class="">
            <div class="col-lg-12 p-0">

                <?php //print_r($projects);?>

                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h4 class="card-title tx_bold6">Projects Assigned</h4>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <form enctype="multipart/form-data" method="post" action="" class="">
                                    <div class="text-left col-lg-12 col-md-12  col-sm-12  col-xs-12 p-0 mb-3 mt-0">
                                        <div class="col-lg-8 p-1">
                                            <input style="cursor:pointer;"
                                                   name="date_range" class="form-control border-input "
                                                   placeholder="Select Start Date" type="text"
                                                   value="<?php if(!empty($start_date)){ echo date('d/m/Y',strtotime($start_date)).' - '.date('d/m/Y',strtotime($end_date)); }?>" max='<?php echo date("Y-m-d");?>' >
                                        </div>
                                        <div class="col-lg-2">
                                            <input class="btn btn-info btn-fill pull-left btn-wd bg-color"
                                                   type="submit" name="search" value="Search">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-content">
                            <table class="table table-striped table-no-bordered table-hover" cellspacing="0"
                                   width="100%" id="datatables">
                                <thead>
                                <tr>
                                    <th width="30%"></th>
<!--                                    <th class="pl-0 text-center" width="30%">Time logged this week</th>-->
                                    <!--   <th>Description</th> -->
<!--                                    <th width="30%" class="pl-0 text-center">Time logged total</th>-->
                                    
                                    <th width="30%" class="pl-0 text-center">Total Timesheets</th>
                                    <th width="30%" class="pl-0 text-center">Deadline</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $grand_total=0; foreach ($projects as $project) { ?>
                                    <tr>
                                        <th>
                                            <a class="text-red text-capti"
                                               href="<?php echo base_url('projects/view/' . $project->id) ?>"><?php echo $project->name; ?></a>
                                        </th>
<!--                                        <td class="pl-0 text-center" width="30%">8</td>-->
                                        <!--  <td><?php echo $sub_project->description ?></td> -->
<!--                                        <td width="30%" class="pl-0 text-center">22</td>-->
                                      
                                        <td width="30%"
                                            class="pl-0 text-center"><?php echo number_format($project->WorkingHours,2).'hr' ; ?></td>

                                              <td width="30%"
                                            class="pl-0 text-center"><?php $date = date_create($project->due_date);
                                            echo date_format($date, 'F dS Y'); ?></td>

                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                   <!--  <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4 class="card-title tx_bold6">Total Timesheets</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="mb0 text-right">
                                    <p class="mb0 text-right">
                                         </p> </p>
                                </div>
                            </div>
                            <div class="card-content"> <h3><?php echo $grand_total;?> Hours</h3>
                            </div>
                        </div>
                    </div> -->

                <div class="col-md-12">
                    <div class="card pb-4">
                        <div class="card-header row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h4 class="card-title tx_bold6">Work gallery</h4>

                            </div>

                            <?php //print_R($projectsscreenshot);?>

                            <div class="col-md-6  col-sm-6 col-xs-6">
                                <!-- <p class="mb0 text-right"><a href="javascript:;">View all</a></p> -->
                                <p class="pull-right">
                                   <!--  <button class="bg-color btn-sm btn btn-fill">Screenshots</button> -->
                                    <p class="mb0 text-right"><a class="text-red text-underline" href="<?php echo base_url('workgallery')?>">View all</a></p>
                                </p>
                            </div>
                        </div>
                        <div class="row mt-4 gallery_home_min gallery_three">
                            <?php foreach ($projectsscreenshot as $screenshot) {  ?>
                                <div class="col-lg-2">
                                    <div class="card">
                                        <div class="card-content gallery_home text-center">
                                            <img  style="height:70px !important" src="<?php echo base_url('assets/' . $screenshot->supplier_id . '/' . $screenshot->screenshot_relation_id . '/' . '' . $screenshot->file . ''); ?>"
                                                 alt="">
                                        </div>
                                        <div class="mt-3 col-lg-12 mt-4 p-0">
                                            <span class=" d-block mb-2"><?php $date = date_create($screenshot->created_at);
                                                echo date_format($date, 'H:i d/m/Y'); ?></span>
                                            <span class=" d-block"><a class="text-red text-capti tx_bold6"
                                                                      href="<?php echo base_url('projects/Gallery/' . $screenshot->project_id) ?>"><?php echo $screenshot->name ?></a></span>
                                        </div>

                                    </div>
                                </div> <?php } ?>
                        </div>
                    </div>
                </div>

                <!--  <div class="col-md-12">
                      <div class="card">
                         <div class="card-header row">
                              <div class="col-md-6 col-sm-12 col-xs-12">
                                  <h4 class="card-title tx_bold6">Photos</h4>
                              </div>
                          </div>

                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 mb-3">
                              <div class="col-md-2 mt-4 mb-4 col-sm-6 col-xs-12 no-padding-gutters">
                                  <a href="#" class="mb0 btn btn-outline-dark btn-fill  btn-block ">Upload</a>
                              </div>
                          </div>

                      </div>

                  </div> -->
            </div>

        </div>


        <!-- Footer Bar Start -->
        
        <!-- Footer Bar End -->
 
    <?php $this->load->view('partial/footer.php'); ?>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-lg-12 text-center">
                    <h5>
                        10:40 Monday June 29th
                    </h5>

                    <h4 class="mt-3">
                        Screenshot will be taken in
                    </h4>

                    <span class="Timer">
                    5
                </span>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partial/footerscript.php'); ?>

</body>
</html>
