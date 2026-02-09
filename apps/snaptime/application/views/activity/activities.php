<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <title>Activities | Scruffy Dog</title>
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
                        <a class="text-red text-capitalize" href="<?php echo base_url('activity/')?>">Activities </a>
                        <?php }else{
                            echo "Activities";
                        }?> /
                        <?php echo $supplier_name; ?>
                    </div>

                    <div class="space10"></div>
                    
                    <div class="card">
                        <div class="card-header project-filter-row">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="card-title tx_bold6 text-capti">
                                        Activity - <?php echo $supplier_name; ?></h4>
                                </div>
                                <div class="w-100 over_hidden">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12 pull-right p-0">
                                    <?php if ($this->session->userdata('role') == 'Supplier' || $this->session->userdata('role') == '0' || $this->session->userdata('role') == '1') {
                                    ?>

                                    <form enctype="multipart/form-data" <?php echo ($this->session->userdata('role') == 'Supplier') ? "action=" . base_url('activity/activities/' . $this->session->userdata('id') . '/' . $this->uri->segment(4)) . "" : "action=" . base_url('activity/activities/'.$this->uri->segment(3)) . "" ?>
                                          method="post">

                                        <div class="text-left  col-lg-12 p-0">

                                                <div class="col-lg-5 p-1">
                                                    <input style="cursor:pointer;"
                                                           name="date_range" class="form-control border-input "
                                                           placeholder="Select Start Date" type="text"
                                                           value="<?php echo date('d/m/Y',strtotime($first)).' - '.date('d/m/Y',strtotime($last)); ?>">
                                                </div>
                                                <div class="col-lg-5 p-1">
                                                    <div id="project_div">
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

                                            <div class="col-lg-2">
                                                <input class="btn btn-info btn-fill pull-left btn-wd bg-color"
                                                       type="submit" name="search" value="Search">
                                            </div>
                                        </div>

                                </form>

                                <?php } ?>
                            </div>

                        </div>
                     </div>
                    <br>


                    <div class=" bd-1">
    <?php ?>

                    </div>
                    <div class="table-responsive" id="projectListDiv">
                        <div class="card-content table-responsive table-full-width">
                            <div class="card-content table-responsive table-full-width custom_time_trk">
                                <table id="bootstrap-table" class="table table-striped">
                                    <thead>
                                    <th style="width: 15%" class="pl-0">Name</th>
                                    <th style="width: 15%">Type</th>
                                    <th class="text-left" style="width:15%">Hours</th>
                                    <th class="text-right" style="width: 55%">Screenshots</th>
                                    </thead>
                                    <tbody>
                                    <?php if (isset($projects)) {
                                        foreach ($projects as $project_key => $project) {
                                            if (isset($project) && $project != null && $screenshots['total'][$project_key] !=0) {

                                                ?>
                                                <tr>
                                                    <td class="pl-0">
                                                            <span><a class="text-red text-underline"
                                                                                       href="<?php echo base_url($project->table_name . '/view/' . $project->id); ?>"><?php echo $project->name; ?></a></span>
                                                    </td>
                                                    <td>
                                                        <span><?php echo ucwords(str_replace('_', ' ', rtrim($project->table_name, 's'))) ?></span>
                                                    </td>
                                                    <td class=" text-right">
                                                        <ul class="custom_count_wrk">
                                                            <li>
                                                                <a class="text-red text-underline"
																
                                                                   href="<?php echo base_url('timesheet/show/' . $project->supplier_id . '/'.$first."/".$last."/".$project->id."/".$project->table_name) ?>"><span
                                                                            class="pull-left ml-10 tx_bold6 total_minutes"><?php if (isset($screenshots['total'][$project_key])) {
                                                                            echo $screenshots['total'][$project_key];
                                                                        } else {
                                                                            echo '0';
                                                                        } ?> Hours</span></a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td class=" text-right">

                                                        <?php
                                                        if (isset($screenshots)) {
                                                            foreach ($screenshots as $screenshot_key => $screenshot) {
															
                                                                if ($screenshot_key == $project->name) {
                                                                    foreach ($screenshot as $item_key => $items) {
																	
                                                                        ?>
                                                                        <div class="custom_project_name w139p text-left"
                                                                             data-toggle="tooltip">
                                                                            <a href="<?php echo base_url($project->table_name . '/Gallery/' . $project->id); ?>">
                                                                                <img src="<?php echo base_url('assets/supplier/' . $project->supplier_id . '/' . $items->relation_id . '/' . $items->file); ?>">
                                                                            </a>
                                                                        </div>
                                                                    <?php }
                                                                }
                                                            }

                                                            ?>


                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php }
                                        }
                                    } ?>


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
        var url = '<?php echo base_url('activity/activities/' . $this->session->userdata('id')) ?>/' + date;
        window.location.href = url;
    }

    $(document).ready(function () {
        $('select[name="project_id"]').change(function () {
            var project_id = $(this).val();
            if (project_id != '') {
                $.ajax({
                    url: "<?php echo base_url('dynamic_dependent/fetch_sub_project'); ?>",
                    method: "POST",
                    data: {project_id: project_id},
                    success: function (data) {
                        console.log(data);
                        // $('#state').html(data);
                        $('#sub_project').html(data);
                        $('#sub_project').selectpicker("refresh");
                        $('#task').html('<option value="">Select Task</option>');
                        $('#sub_task').html('<option value="">Select Sub Task</option>');
                        $('#task').selectpicker("refresh");
                        $('#sub_task').selectpicker("refresh");

                        // $('select[name="project_id"]').html('<option value="">Select City</option>');
                    }
                });
            } else {
                $('#sub_project').html('<option value="">Select Sub Project</option>');
                $('#task').html('<option value="">Select Task</option>');
                $('#sub_task').html('<option value="">Select Sub Task</option>');
                $('#sub_project').selectpicker("refresh");
                $('#task').selectpicker("refresh");
                $('#sub_task').selectpicker("refresh");

            }
        });

        $('#sub_project').change(function () {
            var sub_project = $(this).val();
            if (sub_project != '') {
                $.ajax({
                    url: "<?php echo base_url('dynamic_dependent/fetch_task'); ?>",
                    method: "POST",
                    data: {sub_project_id: sub_project},
                    success: function (data) {
                        $('#task').html(data);
                        $('#task').selectpicker('refresh');
                    }
                });
            } else {
                $('#task').html('<option value="">Select Task</option>');
                $('#task').selectpicker('refresh');

            }
        });
        $('#task').change(function () {
            var task = $(this).val();
            if (task != '') {
                $.ajax({
                    url: "<?php echo base_url('dynamic_dependent/fetch_sub_task'); ?>",
                    method: "POST",
                    data: {task_id: task},
                    success: function (data) {
                        $('#sub_task').html(data);
                        $('#sub_task').selectpicker('refresh');
                    }
                });
            } else {
                $('#task').html('<option value="">Select Task</option>');
                $('#task').selectpicker('refresh');

            }
        });

        // $('#supplier_div').hide();
        // $('#project_div').hide();
        $('#search_by_div').hide();
        // $('select[name="search_by"]').on('change', function () {
        //     if ($(this).val() == 'project') {
        //         $('#supplier_div').hide();
        //         $('#sub_project_div').hide();
        //         $('#tasks_div').hide();
        //         $('#sub_tasks_div').hide();
        //         $('#project_div').show();
        //
        //     } else if ($(this).val() == 'sub_project') {
        //         $('#supplier_div').hide();
        //         $('#project_div').hide();
        //         $('#sub_project_div').show();
        //         $('#tasks_div').hide();
        //         $('#sub_tasks_div').hide();
        //     } else if ($(this).val() == 'tasks') {
        //         $('#supplier_div').hide();
        //         $('#project_div').hide();
        //         $('#sub_project_div').hide();
        //         $('#tasks_div').show();
        //         $('#sub_tasks_div').hide();
        //     } else if ($(this).val() == 'sub_tasks') {
        //         $('#supplier_div').hide();
        //         $('#project_div').hide();
        //         $('#sub_project_div').hide();
        //         $('#tasks_div').hide();
        //         $('#sub_tasks_div').show();
        //     } else if ($(this).val() == 'supplier') {
        //         $('#supplier_div').show();
        //         $('#project_div').hide();
        //         $('#sub_project_div').hide();
        //         $('#tasks_div').hide();
        //         $('#sub_tasks_div').hide();
        //     }
        // });
        // if ($('select[name="search_by"] option:selected').val() == 'project') {
        //     $('#supplier_div').hide();
        //     $('#project_div').show();
        //     $('#sub_project_div').hide();
        //     $('#tasks_div').hide();
        //     $('#sub_tasks_div').hide();
        //
        // } else if ($('select[name="search_by"] option:selected').val() == 'supplier') {
        //     $('#supplier_div').show();
        //     $('#project_div').hide();
        //     $('#sub_project_div').hide();
        //     $('#tasks_div').hide();
        //     $('#sub_tasks_div').hide();
        // }else if ($('select[name="search_by"] option:selected').val() == 'sub_project') {
        //     $('#supplier_div').hide();
        //     $('#project_div').hide();
        //     $('#sub_project_div').show();
        //     $('#tasks_div').hide();
        //     $('#sub_tasks_div').hide();
        // }else if ($('select[name="search_by"] option:selected').val() == 'tasks') {
        //     $('#supplier_div').hide();
        //     $('#project_div').hide();
        //     $('#sub_project_div').hide();
        //     $('#tasks_div').show();
        //     $('#sub_tasks_div').hide();
        // }else if ($('select[name="search_by"] option:selected').val() == 'sub_tasks') {
        //     $('#supplier_div').hide();
        //     $('#project_div').hide();
        //     $('#sub_project_div').hide();
        //     $('#tasks_div').hide();
        //     $('#sub_tasks_div').show();
        // }
    });
</script>
</body>
</html>