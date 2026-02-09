<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <title>Home | Scruffy Dog</title>
    <!--  Fonts and icons -->
    <?php include('partial/head.php') ?>
</head>
<body class="perfect-scrollbar-on sidebar-mini">

<!-- Main Container -->
<div class="wrapper">

    <!-- Main SideBar Menu -->
    <?php include('partial/sidebar.php'); ?>
    <!-- Body Content Start-->
    <div class="main-panel">

        <?php include('partial/navbar.php'); ?>

        <div class="content p-0">
            <div class="col-lg-12 p-0">
                <div class="space10"></div>
                <div class="col-md-6">
                    <div class="card card-height">
                        <div class="card-header row">
                            <div class="col-md-6  col-sm-6 col-xs-4">
                                <h4 class="card-title tx_bold6">Projects</h4>
                            </div>

                            <div class="col-md-6  col-sm-6 col-xs-8">
                                <p class="mb0 text-right"><a href="<?php echo base_url('projects'); ?>"
                                                             class="text-red text-underline">View all </a>
                                    <a href="<?php echo base_url('projects/archive_projects'); ?>"
                                       class="text-red ml-3 text-underline">View all archive </a>
                                </p>
                                <!--  <p class="category pull-right text-center">Deadline</p>-->
                            </div>
                        </div>

                        <table class="table table-responsive mb-2">
                            <thead>
                            <tr>
                                <th style="width:40%"></th>
                                <th class="category text-left pt-1 pb-1 ">Manager(s)</th>
                                <th class="category text-right pt-1 pb-1 ">Deadline</th>
                            </tr>
                            </thead>
                        </table>

                        <div class="card-content table-responsive home_table table-full-width pb-4 pt-4">
                            <table class="table table-striped">
                                <tbody>
                                <?php if (!empty($LatestProject)) {
                                    foreach ($LatestProject as $project) { ?>

                                        <tr>
                                            <td style="width:40%;" class="text-capti ">
                                                <a class="text-red text-underline"
                                                   href="<?php echo base_url('projects/view/' . $project->project_id); ?>"><?php echo $project->project_name; ?></a>
                                                <?php if ($this->session->userdata('role') != 'Supplier') { ?> <br/>
                                                    <small><a class="text-red text-underline"
                                                              href="<?php echo base_url('sub_projects/create/' . $project->id); ?>">
                                                            Add Subproject</a></small>
                                                <?php } else { ?>
                                                    <br/>
                                                    <small><?php $date = date_create($project->created_date);
                                                        echo date_format($date, 'dS M Y'); ?></small>
                                                    <br>
                                                    <small><a data-toggle="modal"
                                                              class="text-red text-underline btn-fil upload_ss_button"
                                                              href="#" data-id="<?php echo $project->relation_id; ?>"
                                                              data-target="screenshot_modal">Add Screenshot</a></small>
                                                <?php } ?>
                                            </td>

                                            <td style="width:37%;" class="text-capti ">
                                                    <span class="TitleEmphasis-100">
                                                    <?php if ($this->session->userdata('role') != '0') { ?>
                                                        <?php echo $project->manager_name; ?>
                                                    <?php } ?></span>
                                            </td>

                                            <td style="width:23%;"
                                                class="text-right"><?php $date = date_create($project->due_date);
                                                echo date_format($date, 'dS M Y'); ?></td>
                                        </tr> <?php }

                                } else { ?>
                                    <tr>
                                        <td class="text-capti ">No data found</td>
                                    </tr>


                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php if ($this->session->userdata('role') != 'Supplier') { ?>
                    <div class="col-md-6">
                        <div class="card card-height">
                            <div class="card-header row">
                                <div class="col-md-8  col-sm-6 col-xs-6">
                                    <h4 class="card-title tx_bold6">External resources</h4>
                                </div>

                                <div class="col-md-4  col-sm-6 col-xs-6">
                                    <p class="mb0 text-right"><a href="<?php echo base_url(); ?>supplier"
                                                                 class="text-red text-underline">View all </a></p>
                                    <!--  <p class="category pull-right text-center">Status</p>-->
                                </div>
                            </div>

                            <table class="table table-responsive mb-2">
                                <thead>
                                <tr>
                                    <th style="width:30%"></th>
                                    <th class="category text-left pt-1 pb-1 ">Project(s)</th>
                                    <th class="category text-left pt-1 pb-1 ">Contact Details</th>
                                    <th class="category text-right pt-1 pb-1 ">Status</th>
                                </tr>
                                </thead>
                            </table>

                            <div class="card-content table-responsive home_table table-full-width">
                                <table class="table table-responsive mb-2">

                                    <tbody>
                                    <?php foreach ($Latestsuppliers as $key => $supplier) { ?>
                                        <tr>
                                            <td style="width:30%">
                                                <div class="author text-left float-left">
                                                    <a
                                                            href="<?php echo base_url('supplier/view/' . $supplier->supplier_id) ?>"
                                                            class="text-capti text-red text-underline">
                                                        <span class=""><?php echo $supplier->supplier_name; ?></span></a>
                                                    <br/>
                                                    <div class="rate" style="height:23px">
                                                        <input <?php if ($supplier->skills == 5) {
                                                            echo 'checked';
                                                        } ?> id="skill<?php echo $key ?>5"
                                                             name="skills<?php echo $key ?>" type="radio" value="5">
                                                        <label class="disabledStar" for="skill<?php echo $key ?>5"
                                                               value="5">skill5</label>

                                                        <input id="skill<?php echo $key ?>4"
                                                               name="skills<?php echo $key ?>" type="radio"
                                                               value="4" <?php if ($supplier->skills == 4) {
                                                            echo 'checked="true"';
                                                        } ?>>
                                                        <label class="disabledStar" for="skill<?php echo $key ?>4"
                                                               value="4">skill4</label>

                                                        <input id="skill<?php echo $key ?>3"
                                                               name="skills<?php echo $key ?>" type="radio"
                                                               value="3" <?php if ($supplier->skills == 3) {
                                                            echo 'checked="true"';
                                                        } ?>>
                                                        <label class="disabledStar" for="skill<?php echo $key ?>3"
                                                               value="3">skill3</label>

                                                        <input id="skill<?php echo $key ?>2"
                                                               name="skills<?php echo $key ?>" type="radio"
                                                               value="2" <?php if ($supplier->skills == 2) {
                                                            echo 'checked="true"';
                                                        } ?>>
                                                        <label class="disabledStar" for="skill<?php echo $key ?>2"
                                                               value="2">skill2</label>

                                                        <input id="skill<?php echo $key ?>1"
                                                               name="skills<?php echo $key ?>" type="radio"
                                                               value="1" <?php if ($supplier->skills == 1) {
                                                            echo 'checked="true"';
                                                        } ?>>
                                                        <label class="disabledStar" for="skill<?php echo $key ?>1"
                                                               value="1">skill1</label>

                                                        <input disabled="true" id="skill<?php echo $key ?>0"
                                                               name="skills<?php echo $key ?>" type="radio"
                                                               value="0" <?php if ($supplier->skills == 0) {
                                                            echo 'checked="true"';
                                                        } ?>>
                                                    </div>
                                                    <!-- <br>
                                                     <div class="" style="height:23px">

                                                     </div>-->
                                                </div>
                                            </td>

                                            <td style="width:25%"><a
                                                        href="<?php echo base_url('projects/view/' . $supplier->project_id); ?>"
                                                        class="text-red text-underline"><?php echo $supplier->project_name ?></a>
                                            </td>
                                            <td style="width:25%"><a data-toggle="tooltip"

                                                   title="Send Message To <?php echo $supplier->supplier_name; ?>"
                                                   href="mailto:<?php echo $supplier->email; ?>?&subject=<?php echo $supplier->project_name . ' - ' . date('d-M-Y', strtotime('NOW')) . ' - ' . date('h:i a', strtotime('NOW')) ?>&body=Hi%20<?php echo $supplier->supplier_name; ?>"
                                                   rel="EMAIL">
                                                    <i class="fa fa-envelope text-red"></i></a>
                                                <a data-toggle="tooltip"
                                                   title="Website"
                                                   href="<?php echo $supplier->website; ?>"
                                                   rel="Website">
                                                    <i class="fa fa-globe text-red"></i></a>
                                                <a data-toggle="tooltip"
                                                   title="Send Message To <?php echo $supplier->phone_number; ?>"
                                                   href="tel:<?php echo $supplier->phone_number; ?>"
                                                   rel="Phone">
                                                    <i class="fa fa-phone text-red"></i></a>
                                            </td>
                                            <td style="width:10%"></td>
                                            <td style="width:10%" class="text-center"><span class="online"></span></td>
                                        </tr> <?php } ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($this->session->userdata('role') == 'Supplier') { ?>

                    <?php if (!empty($this->session->userdata('clockin'))) { ?>

                        <div class="col-md-6">
                            <div class="card card-height">
                                <div class="card-header">
                                    <h4 class="card-title tx_bold6">Logged in <a class="text-red text-underline"
                                                                                 href="<?php echo base_url($this->session->userdata('table') . '/view/' . $this->session->userdata('project_id')); ?>"> <?php echo $this->session->userdata('project_name'); ?></a>
                                    </h4>

                                </div>
                                <div class="card-content">
                                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                        <span class="Timer" id="running_timer">00:00</span>
                                        <?php if ($this->session->userdata('role') == 'Supplier') { ?>
                                            <a href="#"
                                               onclick="<?php if ($this->session->userdata('clockin') !== FALSE) {
                                                   echo "stop()";
                                               } else {
                                                   echo "start()";
                                               } ?>"
                                               class=" mt-3 mb-3 btn btn-outline-dark btn-fill  btn-block "> <?php if ($this->session->userdata('clockin') !== FALSE) {
                                                    echo "Pause / Stop";
                                                } else {
                                                    echo "Start";
                                                } ?></a>
                                        <?php } ?>
                                    </div>

                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                        </div>


                    <?php } else { ?>

                        <div class="col-md-6">
                            <div class="card card-height">
                                <div class="card-header">
                                    <h4 class="card-title tx_bold6">You are not logged in for any project</h4>

                                </div>
                                <div class="card-content">
                                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                        <span class="Timer" id="running_timer">00:00:00</span>

                                    </div>

                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php }
                    ?>

                    <?php
                } ?>

            </div>
            <div class="col-lg-12 p-0">
                <div class="col-md-6">
                    <div class="card card-height">
                        <div class="card-header row">
                            <div class="col-md-4  col-sm-6 col-xs-6">
                                <h4 class="card-title tx_bold6">Tasks</h4>
                            </div>
                        </div>

                        <table class="table table-responsive mb-2">
                            <thead>
                            <tr>
                                <th style="width:43%"></th>
                                <th class="category text-left pt-1 pb-1 ">Manager(s)</th>
                                <th class="category text-right pt-1 pb-1 ">Deadline</th>
                            </tr>
                            </thead>
                        </table>



                        <div class="card-content table-responsive home_table table-full-width pb-4 pt-4">
                            <table class="table table-striped">
                                <tbody>
                                <?php
                                if (!empty($LatestTasks)) {
                                    foreach ($LatestTasks as $LatestTask) {
                                        ?>

                                        <tr>
                                            <td class="text-capti ">
                                                <a class="text-red text-underline"
                                                   href="<?php echo base_url('tasks/view/' . $LatestTask->task_id); ?>"><?php echo $LatestTask->task_name; ?></a>
                                                <?php if ($this->session->userdata('role') != 'Supplier') { ?> <br/>
                                                    <small><a class="text-red text-underline"
                                                              href="<?php echo base_url('sub_projects/create/' . $LatestTask->id); ?>">
                                                            Add Subproject</a></small>
                                                <?php } else { ?>
                                                    <br/> <small><?php $date = date_create($LatestTask->created_date);
                                                        echo date_format($date, 'dS M Y'); ?></small>
                                                <?php } ?>
                                            </td>

                                            <td class="text-capti"><?php echo $LatestTask->manager_name ?></td>
                                            <td class="text-right"><?php $date = date_create($LatestTask->due_date);
                                                echo date_format($date, 'dS M Y'); ?></td>
                                        </tr>

                                        <?php
                                    }
                                } else { ?>
                                    <tr>
                                        <td class="text-capti ">No data found</td>
                                    </tr>


                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card pb-4 card-height">
                        <div class="card-header row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h4 class="card-title tx_bold6">Work gallery</h4>

                            </div>
                            <div class="col-md-6  col-sm-6 col-xs-6 ">
                                <!-- <p class="mb0 text-right"><a href="javascript:;">View all</a></p> -->
                                <p class="pull-right">
                                    <!--  <button class="btn-danger btn-sm btn btn-fill">Screenshots</button> -->
                                <p class="mb0 text-right"><a class="text-red text-underline"
                                                             href="<?php echo base_url('workgallery') ?>">View all</a>
                                </p>
                                </p>
                            </div>
                        </div>
                        <div class="row gallery_home_min">
                            <?php foreach ($LatestScreenshots as $screenshot) {

                                if ($this->session->userdata('role') != 'Supplier') {
                                    $id = $screenshot->supplier_id;
                                } else {
                                    $id = $this->session->userdata('id');
                                }

                                ?>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                    <div class="card ">
                                        <div class="card-content gallery_home text-center">
                                            <a class="venobox" data-gall="myGallery"
                                               title="<?php $date = date_create($screenshot->created_at);
                                               echo date_format($date, 'H:i d/m/Y'); ?>"
                                               href="<?php echo base_url('/assets/supplier/' . $id . '/' . $screenshot->relation_id . '/' . $screenshot->file) ?>">
                                                <img src="<?php echo base_url('/assets/supplier/' . $id . '/' . $screenshot->relation_id . '/' . $screenshot->file) ?>"/>
                                            </a>
                                            <span class="mt-3 d-block"><?php $date = date_create($screenshot->created_at);
                                                echo date_format($date, 'H:i d/m/Y'); ?></span>
                                            <span class=" d-block"><?php echo $screenshot->project_name; ?></span>
                                            <?php //if($this->session->userdata('role') !== 'Supplier'){
                                            ?>
                                            <span class=" d-block mb-3"><?php echo $screenshot->supplier_name; ?></span> <?php //}
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-lg-12 p-0">
                <?php if ($this->session->userdata('role') == 'Supplier') { ?>
                    <div class="col-md-12" id="time_breakdown">
                        <div class="card card-height">
                            <div class="card-header row">
                                <div class="col-md-8  col-sm-12 col-xs-6">
                                    <h4 class="card-title tx_bold6">Time breakdown</h4>

                                    <p class="mt4 category"><?php $date = date_create($firstMonth);
                                        echo date_format($date, 'd/m/Y'); ?> - <?php $date = date_create($lastMonth);
                                        echo date_format($date, 'd/m/Y'); ?></p>
                                </div>
                                <div class="col-md-4  col-sm-12 col-xs-6">
                                    <div class="col-md-12 col-xs-12 pull-right p-0">
                                        <?php if ($this->session->userdata('role') == 'Supplier') { ?>

                                            <form enctype="multipart/form-data" action="<?php echo base_url('home') ?>#time_breakdown"
                                                  method="post">
                                                <div class="col-lg-12 p-0">
                                                    <div class="pull-right col-lg-7 p-1">
                                                        <div id="project_div">
                                                            <select id="project_id" class="form-control  mt-0 pt-1 selectpicker"
                                                                    name="project_id">
                                                                <option value="">Select Project</option>
                                                                <?php foreach ($assigned_projects as $projects) {
                                                                   ?>
                                                                    <option value="<?php echo $projects->id; ?>" <?php if (!empty($project_id) && $project_id == $projects->id) {
                                                                        echo 'selected';
                                                                    } ?>><?php echo $projects->name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 invisible">
                                                        <input class="btn btn-info btn-fill pull-left btn-wd bg-color"
                                                               type="submit" name="search" value="Search">
                                                    </div>
                                                </div>

                                            </form>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div id="chartActivity"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($this->session->userdata('role') != 'Supplier') { ?>

                    <div class="col-md-12" id="time_breakdown">
                        <div class="card card-height">
                            <div class="card-header row">
                                <div class="col-md-8  col-sm-12 col-xs-12">
                                    <h4 class="card-title tx_bold6"> Time breakdown </h4>

                                    <p class="mt4 category"><?php $date = date_create($firstMonth);
                                        echo date_format($date, 'd/m/Y'); ?> - <?php $date = date_create($lastMonth);
                                        echo date_format($date, 'd/m/Y'); ?></p>
                                </div>
                                <div class="col-md-4  col-sm-12 col-xs-12">
                                    <div class="col-md-12 col-xs-12 pull-right p-0">


                                        <form enctype="multipart/form-data" action="<?php echo base_url('dashboard') ?>#time_breakdown" data-target="time_breakdown"
                                              method="post">
                                            <div class="col-lg-12 p-0">
                                                <div class="pull-right col-lg-7 p-1 col-xs-6">
                                                    <div id="project_div">
                                                        <select  id="project_id"  class="form-control mt-0 pt-1 selectpicker"
                                                                name="project_id">
                                                            <option value="">Select Project</option>
                                                            <?php foreach ($assigned_projects as $assigned_project) { ?>
                                                                <option value="<?php echo $assigned_project->id; ?>" <?php if (!empty($project_id) && $project_id == $assigned_project->id) {
                                                                    echo 'selected';
                                                                } ?>>
                                                                    <?php echo $assigned_project->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 invisible">
                                                    <input class=" btn btn-info btn-fill pull-left btn-wd bg-color"
                                                           type="submit" name="search" value="Search">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div id="chartActivity"></div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>


        <!-- Footer Bar Start -->
        <?php include('partial/footer.php'); ?>
        <!-- Footer Bar End -->
    </div>
</div>

<div id="archive-popup" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">

                <p>You are Archiving the Quotation so it will be Disable / Paused, are you sure?</p>

            </div>

            <div class="modal-footer">
                <div class=" pull-right">

                    <a href="javascript:void(0)" data-dismiss="modal"
                       class="btn btn-info btn-wd popup-sec-btn">cancel</a>
                    <a href="javascript:void(0)" data-dismiss="modal"
                       class="btn btn-info archive-ok btn-fill btn-wd bg-color">Ok</a>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="editBudgetModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div id="editBudgetDiv"></div>
        </div>
    </div>
</div>
<div id="CommentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Comments</h4>
            </div>
            <div id="commentList"></div>
        </div>

    </div>
</div>
<div id="costModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Budget</h4>
            </div>
            <div id="addBudgetDiv"></div>
        </div>

    </div>
</div>


<div id="createQuotation" class="modal fade" role="dialog">
    <div class="modal-dialog large-modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Please Enter Details</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Client Name</label>
                            <input type="text" class="form-control" placeholder="Enter client name" name="">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Client Address</label>
                            <textarea style="resize: none;" class="form-control" rows="2"
                                      placeholder="Enter Address"></textarea>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact Name Of Project</label>
                            <input type="text" class="form-control" placeholder="Enter Contact name" name="">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Project Name</label>
                            <input type="text" class="form-control" placeholder="Enter Project name" name="">
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Draft Quote</label>
                            <textarea style="resize: none;" class="form-control" rows="2"
                                      placeholder="Draft Quote"></textarea>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Expiry Date</label>
                            <input type="text" class="form-control datepicker" placeholder="Enter Expiry Date"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" class="form-control" placeholder="Enter Account Number" name="">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Reference</label>
                            <input type="text" class="form-control" placeholder="Enter Reference" name="">
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>VAT Number</label>
                            <input type="text" class="form-control" placeholder="Enter VAT Number" name="">
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="form-group mt-36">
                            <label>VAT To Be Included</label>
                            <input style="margin-left: 20px; vertical-align: top;" type="checkbox" class="" name="">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Terms</label>
                            <textarea style="resize: none;" class="form-control" rows="2"
                                      placeholder="Enter Terms"></textarea>
                        </div>

                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <div class="col-md-5 pull-right">
                    <a href="javascript:void(0)" data-dismiss="modal"
                       class="btn btn-info btn-fill btn-wd bg-color">Ok</a>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="editQuotation" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Quotation</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" class="form-control" placeholder="Enter client name" name="">
                </div>
                <div class="form-group">
                    <label>Client Address</label>
                    <textarea style="resize: none;" class="form-control" rows="2"
                              placeholder="Enter Address"></textarea>
                    <!-- <input type="text" class="form-control" placeholder="Enter client address" name="">
                    <input style="margin-top: 7px;" type="text" class="form-control" placeholder="Address Line 2" name=""> -->
                </div>
                <div class="form-group">
                    <label>Contact Name Of Project</label>
                    <input type="text" class="form-control" placeholder="Enter Contact name" name="">
                </div>
                <div class="form-group">
                    <label>Project Name</label>
                    <input type="text" class="form-control" placeholder="Enter Project name" name="">
                </div>

                <div class="form-group">
                    <label>VAT To Be Included</label>
                    <input style="margin-left: 20px; vertical-align: top;" type="checkbox" class="" name="">
                </div>
            </div>

            <div class="modal-footer">
                <div class="col-md-5 pull-right">
                    <a href="javascript:void(0)" data-dismiss="modal"
                       class="btn btn-info btn-fill btn-wd bg-color">Ok</a>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="createSubItem" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Please Enter Sub item Details</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Sub Item Name</label>
                    <input type="text" class="form-control" placeholder="Enter Sub Item Name"/>
                </div>


                <div class="form-group">
                    <label>Sub Item Quantity</label>
                    <input type="text" class="form-control" placeholder="Enter Sub Item Quantity"/>
                </div>
            </div>

            <div class="modal-footer">
                <div class="col-md-5 pull-right">
                    <a href="#" class="btn btn-info btn-fill btn-wd bg-color">Ok</a>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="revenueModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Retail</h4>
            </div>
            <div id="addRevenueBudgetDiv"></div>
        </div>

    </div>
</div>
<!-- Main Container End -->


<div id="AddQualModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Qualification</h4>
            </div>
            <div id="addQualDiv"></div>
        </div>

    </div>
</div>

<div id="AddRatsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Policy</h4>
            </div>
            <div id="addRatsDiv"></div>
        </div>

    </div>
</div>
<div id="lookupModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content  modal-lg">
            <div class="modal-header">
                <h4 class="card-title pl-30">Supplier Lookup</h4>

            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="lookupDiv" class="card"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="DelPopup" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Confirm</h4>
            </div>
            <div class="modal-body">
                Do you want to delete this item?
            </div>
            <div class="modal-footer">
                <input id="Itemtobedelete" type="hidden" value=""/>
                <button onclick="DeleteItem();" type="button" class="btn btn-link waves-effect">OK</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmPopup" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Confirm</h4>
            </div>
            <div class="modal-body">
                Do you want to delete this item?
            </div>
            <div class="modal-footer">
                <input type="hidden" id="DeleteRowId"/>
                <button id="confirmPopupTrue" onclick="DeleteOk();" type="button" class="btn btn-link waves-effect">OK
                </button>
                <button id="confirmPopupCancel" type="button" class="btn btn-link waves-effect" data-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="archivePopup" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Alert</h4>
            </div>
            <div class="modal-body">
                You are Archiving the project so it will be Disable / Paused, are you sure?
            </div>
            <div class="modal-footer">
                <input type="hidden" id="DeleteRowId"/>
                <button id="archivePopupTrue" onclick="ArchiveOk();" type="button" class="btn btn-link waves-effect">
                    OK
                </button>
                <button id="archivePopupCancel" type="button" class="btn btn-link waves-effect" data-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="upload_ss_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-lg-12 text-center">
                    <h5>
                        Upload Screenshot Manually
                    </h5>
                    <form id="ss_form" action="<?php echo base_url('projects/upload_ss'); ?>" method="post"
                          enctype="multipart/form-data">
                        <div class="col-lg-12 p-1 mb-3">
                            <input class="form-control" type="file" name="screenshots[]" multiple/>
                        </div>
                        <div class="col-lg-12 p-1 text-left mb-3">
                            <label>Description</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <button type="submit" class=" btn-info btn btn-fill bg-color">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                    </form>
                </div>
            </div>
            <div class="modal-footer border-0">
            </div>
        </div>
    </div>
</div>


<div id="EditModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div id="editDiv"></div>
        </div>
    </div>
</div>

<?php include('partial/footerscript.php'); ?>


<script type="text/javascript">


    $(document).ready(function () {

        $('#project_id').on('change',function () {
            $('input[name="search"]').trigger('click');
        });

        $(".upload_ss_button").click(function () {
            var relation_id = $(this).data('id');
            var ss_form = document.getElementById('ss_form');
            var action_url = "<?php echo base_url('projects/upload_ss') . '/';?>" + relation_id;
            ss_form.action = action_url;
            $("#upload_ss_modal").modal('show');
        });

        /*  **************** 24 Hours Performance - single line ******************** */
        var dataPerformance = {
            labels: ['01pm', '9pm', '11pm', '2am', '4am', '8am', '2pm', '5pm', '8pm', '11pm', '4am'],
            series: [
                [1, 6, 8, 7, 4, 7, 8, 12, 16, 17, 14, 13]
            ]
        };

        var optionsPerformance = {
            showPoint: false,
            lineSmooth: true,
            height: "200px",
            axisX: {
                showGrid: false,
                showLabel: true
            },
            axisY: {
                offset: 40,

            },
            low: 0,
            high: 16,
            height: "250px"
        };


        Chartist.Line('#chartPerformance', dataPerformance, optionsPerformance);

        /*   **************** 2014 Sales - Bar Chart ********************    */
        var dates = [];
        var values = [];

        <?php

        foreach($time_table as $time){
            foreach($dates as $date){
        ?>

        <?php if($date == $time->date) { ?>
        dates.push("<?php echo date('d-m-Y',strtotime($date));?>");
        values.push((parseInt("<?php echo $time->Total_Time;?>") / 60) );
        <?php  }
        }
        }?>

        var data = {
            labels: dates,
            series: [values],
        };

        var options = {
            seriesBarDistance: 5,
            axisX: {
                showGrid: false
            },
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: '7 whole grain flakes'
                    }
                }]
            },
            height: "250px"
        };

        var responsiveOptions = [
            ['screen and (max-width: 640px)', {
                seriesBarDistance: 10,
                axisX: {
                    labelInterpolationFnc: function (values) {
                        return values[0]+values[1]+values[2]+values[3]+values[4];
                    }
                }
            }]
        ];

        Chartist.Bar('#chartActivity', data, options, responsiveOptions);


        /*  **************** NASDAQ: AAPL - single line with points ******************** */

        var dataStock = {
            labels: ['\'07', '\'08', '\'09', '\'10', '\'11', '\'12', '\'13', '\'14', '\'15'],
            series: [
                [22.20, 34.90, 42.28, 51.93, 62.21, 80.23, 62.21, 82.12, 102.50, 107.23]
            ]
        };

        var optionsStock = {
            lineSmooth: false,
            height: "200px",
            axisY: {
                offset: 40,
                labelInterpolationFnc: function (value) {
                    return '$' + value;
                }

            },
            low: 10,
            height: "250px",
            high: 110,
            classNames: {
                point: 'ct-point ct-green',
                line: 'ct-line ct-green'
            }
        };

        Chartist.Line('#chartStock', dataStock, optionsStock);

        /*  **************** Views  - barchart ******************** */

        var dataViews = {

            labels: ['Feb', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            series: [
                [542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895]
            ]
        };

        var optionsViews = {
            seriesBarDistance: 10,
            classNames: {
                bar: 'ct-bar'
            },
            axisX: {
                showGrid: false,

            },
            height: "250px"

        };

        var responsiveOptionsViews = [
            ['screen and (max-width: 640px)', {
                seriesBarDistance: 5,
                axisX: {
                    labelInterpolationFnc: function (value) {
                        return value[0];
                    }
                }
            }]
        ];

        Chartist.Bar('#chartViews', dataViews, optionsViews, responsiveOptionsViews);

    });

</script>


</body>
</html>
