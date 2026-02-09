<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <title>Timesheet | Scruffy Dog</title>
    <!--  Fonts and icons -->
    <?php $this->load->view('partial/head.php') ?>
</head>
<body class="perfect-scrollbar-on">
<!-- Main Container -->
<div class="wrapper">
    <!-- Main SideBar Menu -->
    <?php $this->load->view('partial/sidebar.php'); ?>
    <!-- Body Content Start-->
    <div class="main-panel">
        <?php $this->load->view('partial/navbar.php'); ?>
        <div class="content pt-4 mt-1">
            <div class="container-fluid table-responsive">
                <div class="row">

                    <div class="col-lg-12 tx_bold6 text-capti pl-0">
                        <?php if($this->session->userdata('role') != 'Supplier'){ ?>
                        <a class="text-red text-capitalize" href="<?php echo base_url('timesheet/')?>">Timesheet </a>
                        <?php }else{
                            echo "Timesheet";
                        }?> /
                        <?php if ($by_supplier = "true") {
                            if (is_array($supplier_name)) {
                                echo implode(',', $supplier_name);
                            } else {
                                echo $supplier_name;
                            }

                        } else if ($by_project) {
                            echo $project[0]->name;
                        } ?>
                    </div>

                    <div class="space10"></div>
                    <div class="card">
                        <div class="card-header project-filter-row">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="card-title tx_bold6 text-capti">
                                        <?php if ($by_supplier = "true") {
                                            if (is_array($supplier_name)) {
                                                echo implode(',', $supplier_name);
                                            } else {
                                                echo $supplier_name;
                                            }

                                        } else if ($by_project) {
                                            echo $project[0]->name;
                                        } ?></h4>
                                </div>
                                <div class="w-100 over_hidden">
                                    <hr>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-2 col-xs-12">

                                         <div class="user_time_chart mt-0">
                                            <ul class="kt-margin-b-0">
                                                <li>
                                                    <span id="display_total_hour">0</span>
                                                    <p>Total hours</p>
                                                </li>
                                            </ul>
                                        </div>
                                 </div>
 
                                <div class="col-md-10 col-xs-12 pull-right mt-2">

                                        <form enctype="multipart/form-data" <?php echo ($this->session->userdata('role') == 'Supplier') ? "action=" . base_url('timesheet/show/' . $this->session->userdata('id') . '') . "" : "action=" . base_url('timesheet/show/' . $supplier_get_id ) . "" ?>
                                              action="<?php echo base_url('timesheet/show/' . $first) ?>" method="post">

                                            <div class="text-left col-lg-12 p-0">

                                                <div class="col-lg-5 p-1">
                                                    <input style="cursor:pointer;"
                                                           name="date_range" class="form-control border-input "
                                                           placeholder="Select Start Date" type="text"
                                                           value="<?php echo date('d/m/Y',strtotime($first)).' - '.date('d/m/Y',strtotime($last)); ?>">
                                                </div>
                                                <div class="col-lg-5 p-1">
                                                    <div >
                                                        <select class="form-control mt-0 pt-1 selectpicker"
                                                                name="project_id">
                                                            <option value="">Select Project</option>
                                                            <?php foreach ($assigned_projects[0] as $assigned_project) { ?>
                                                                <option value="<?php echo $assigned_project->id; ?>" <?php echo ($project_id == $assigned_project->id) ?  'selected' : '' ?>><?php echo $assigned_project->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-lg-3 p-1">-->
                                                <!--                                                    <div id="sub_project_div">-->
                                                <!--                                                        <select class="form-control mt-0 pt-1 selectpicker"-->
                                                <!--                                                                name="sub_project_id" id="sub_project">-->
                                                <!--                                                        </select>-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="col-lg-3 p-1">-->
                                                <!--                                                    <div id="tasks_div">-->
                                                <!--                                                        <select class="form-control mt-0 pt-1 selectpicker"-->
                                                <!--                                                                name="task_id" id="task">-->
                                                <!--                                                        </select>-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="col-lg-3 p-1">-->
                                                <!--                                                    <div id="sub_tasks_div">-->
                                                <!--                                                        <select class="form-control mt-0 pt-1 selectpicker"-->
                                                <!--                                                                name="sub_task_id" id="sub_task">-->
                                                <!---->
                                                <!--                                                        </select>-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <?php /* elseif ($this->session->userdata('role') == '0') {
                                                        ?>
                                                        <div class="col-lg-7 p-0">

                                                            <div id="project_div">

                                                                <select class="form-control mt-0 pt-1 selectpicker"
                                                                        name="project_id" id="project_id">
                                                                    <option value="">Select Project</option>
                                                                    <?php foreach ($assigned_projects as $assigned_project) { ?>
                                                                        <option value="<?php echo $assigned_project->id; ?>"><?php echo $assigned_project->name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div id="supplier_div">
                                                                <select class="form-control mt-0 pt-1 selectpicker"
                                                                        name="supplier_id" id="supplier_id">
                                                                    <option value="">Select Supplier</option>
                                                                    <?php foreach ($suppliers as $supplier) { ?>
                                                                        <option value="<?php echo $supplier->id; ?>"><?php echo $supplier->name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php } */ ?>

                                                <div class=" col-lg-2 pl-0">
                                                    <input class="btn btn-info btn-fill pull-left btn-wd bg-color"
                                                           type="submit" name="search" value="Search">
                                                </div>
                                            </div>
                                        </form>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class=" bd-1">
                        </div>
                        <div class="table-responsive" id="projectListDiv">
                            <div class="card-content table-responsive table-full-width">
                                <div class="card-content table-responsive table-full-width custom_time_trk">
                                    <table id="bootstrap-table" class="table table-striped">
                                        <thead>
                                        <th style="width: 15%" class="pl-0">Days</th>
                                        <th style="width: 70%">Breakdown</th>
                                        <th style="" class="text-left ">Hours</th>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($dates as $date) { ?>
                                            <tr>
                                                <td class="pl-0">
                                                    <span class="days-name"><?php echo date('D', strtotime($date)); ?></span> <?php echo date('d', strtotime($date)) . ' ' . date('M', strtotime($date)) ?>
                                                </td>

                                                <td>

                                                    <?php
                                                    if(isset($time_checks))
                                                    {
                                                        foreach ($time_checks as $key => $time_check) {
                                                            if ($time_check->date == $date) {
                                                                ?>
                                                                <div class="custom_project_name text-left"
                                                                     data-html="true"
                                                                     data-toggle="tooltip" title="<p class='text-left'><?php if(!empty($time_check->time_notes)){ echo ($time_check->time_notes); } else if ($by_supplier) {
                                                                    echo implode(',', $supplier_name);
                                                                } else if ($by_project) {
                                                                    echo $project[$key]->name;
                                                                } ?></p>"
                                                                     data-total-minutes=<?php echo $time_check->total; ?>>
                                                                    <ul>
                                                                        <li><span><?php
                                                                                if ($by_supplier) {
                                                                                    echo $project[$key]->name;
                                                                                } else if ($by_project) {
                                                                                    echo $time_check->name;
                                                                                }
                                                                                ?></span></li>
                                                                        <li>
                                                                            : <?php echo date('h:i:s a', strtotime($time_check->clockin)); ?>
                                                                            - <?php echo date('h:i:s a', strtotime($time_check->clockout)); ?></li>
                                                                    </ul>
                                                                </div>
                                                            <?php }
                                                        }

                                                    ?>

                                                </td>

                                                <td class=" text-right" width="100%">
                                                    <ul class="custom_count_wrk">
                                                        <li><span class="pull-left ">Total</span><span
                                                                    class="pull-left ml-10 tx_bold6 total_minutes">2.75hr</span>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>

                                        <?php }} ?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- <input id="CP" name="CP" type="hidden" value="1">
                     <table class="table table-striped prj-dir-table" id="proj-table">
                        <thead>
                            <tr>
                                <th>Date&nbsp;</th>
                                <th>Accounts Code</th>
                                <th>Name</th>
                                <th>Client</th>
                                <th>View Sub Projects</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            foreach ($projects as $project) {

                                ?>
                            <tr>
                                <td><?php $date = date_create($project->created_at);
                                echo date_format($date, 'd/m/Y'); ?></td>
                                <td><?php echo $project->accounts_code ?></td>
                                <td><?php echo $project->name ?></td>
                                <td><?php echo $project->client_name ?></td>
                                <td>
                                    <a href="<?php echo base_url('sub_projects/index/' . $project->id); ?>" class="linkColor customlinkSettings">View</a></td>

                                    <td>
                                    <a title="Details" href="<?php echo base_url('projects/view/' . $project->id) ?>" class="linkColor" style="margin-right:3px;">
                                            <span class="ti-book"></span>
                                        </a>
                                        <?php if ($this->session->userdata('role') != 'Supplier') { ?>
                                        <a title="Edit" href="<?php echo base_url('projects/edit/' . $project->id) ?>" class="linkColor" style="margin-right:3px;">
                                            <span class="ti-pencil-alt"></span>
                                        </a>
                                        <a title="Delete" href="<?php echo base_url('projects/delete/' . $project->id); ?>" class="customhover"><span class="ti-trash"></span></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php } ?>
                        </tbody>
                    </table> -->
                        </div>


                        <div class="fixed-table-pagination">

                        </div>


                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bar Start -->

        <!-- Footer Bar End -->
        <?php $this->load->view('partial/footer.php'); ?>
    </div>
</div>
<?php $this->load->view('partial/footerscript.php'); ?>
<script>
    function callMethod(date) {
        var url = '<?php echo base_url('timesheet/show/' . $supplier_get_id)?>/' + date;
        window.location.href = url;
    }

    $(document).ready(function () {
        var total = 0;
        $('#bootstrap-table tr').each(function () {
            var $this = $(this);
            var total_minutes = 0;
            $this.find(".custom_project_name").each(function () {
                total_minutes += Number($(this).attr('data-total-minutes'));
            });
            $this.find('.total_minutes').text(((total_minutes) / 60).toFixed(2) + "hr");
            total += total_minutes;
        });
        $('#display_total_hour').text(((total) / 60).toFixed(2));
        $('#supplier_div').hide();
        $('#project_div').hide();
        $('select[name="search_by"]').on('change', function () {
            if ($(this).val() == 'project') {
                $('#supplier_div').hide();
                $('#project_div').show();

            } else if ($(this).val() == 'supplier') {
                $('#supplier_div').show();
                $('#project_div').hide();
            }
        });
        if ($('select[name="search_by"] option:selected').val() == 'project') {
            $('#supplier_div').hide();
            $('#project_div').show();

        } else if ($('select[name="search_by"] option:selected').val() == 'supplier') {
            $('#supplier_div').show();
            $('#project_div').hide();
        }
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body>
</html>