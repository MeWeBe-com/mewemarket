<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>Departments | Scruffy Dog</title>
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
            <div class="container-fluid ">
                <div class="row">
                    <div class="card table-responsive">
                        <div class="card-header project-filter-row">

                            <div class="row">

                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <h4 class="card-title tx_bold6 pt-2">Departments</h4>
                                </div>

                                <div class="col-md-8 col-sm-6 col-xs-6">
                                    <div class="text-right supplier-action-box">
                                        <?php if($this->session->userdata('role') == '1') {?>
                                            <a class="btn btn-info btn-fill btn-wd bg-color" href="<?php echo base_url('departments/create');?>">
                                                Create Department
                                            </a>
                                        <?php } ?>

                                    </div>
                                </div>
                                <div class="w-100 over_hidden"><hr></div>
                            </div>

                        </div>
                        <div class="card-content pt-0">

                            <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%" id="datatables">
                                <thead>
                                <tr>
                                    <th width="15%">Action</th>
                                    <th width="15%" orderable="true">Name</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php

                                foreach($departments as $department){
                                     ?>
                                    <tr>
                                        <td>
                                        <a title="Edit" href="<?php echo base_url('departments/edit/'.$department->id)?>" class="linkColor edit text-red" style="margin-right:3px;">
                                                    <span class="ti-pencil-alt"></span>
                                                </a>

                                            <a title="Delete" onclick="return confirm('Are you sure?')" href="<?php echo base_url('departments/delete/'.$department->id);?>" class="customhover text-red"><span class="ti-trash"></span></a>
                                        </td>
                                        <td><?php echo $department->name?></a></td>

                                    </tr>

                                <?php }?>
                                </tbody>
                            </table>
                        </div>


                        <div class="clearfix"></div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Bar Start -->
        <?php  $this->load->view('partial/footer.php') ;?>
        <!-- Footer Bar End -->
    </div>



</div>

<?php  $this->load->view('partial/footerscript.php') ;?>

</body>
</html>
