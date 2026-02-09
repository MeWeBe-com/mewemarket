<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>Create Department | Scruffy Dog</title>
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
        <div class="col-lg-12 tx_bold6 p-0 text-capti">
           <a href="<?php echo base_url('settings');?>"  class="text-red">Settings</a> / <a href="<?php echo base_url('departments');?>"  class="text-red">Departments</a>  / Create Department
        </div>
        <div class="space10"></div>
        <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header pl-15 pr-15 clearfix">
                    <h4 class="card-title tx_bold6 pull-left">Create New Department</h4>
                </div>
                 <div class="w-100 over_hidden"><hr></div>
                <div class="card-content pt-0">
                    <div class="row">
                        <form action="<?php echo base_url('departments/store');?>" method="post" >
                            <div class="col-md-12">
                                <div class=" ">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Department Name <span class="text-light">*</span></label>
                                                    <input class="form-control border-input" maxlength="100" name="name" placeholder="Type Department Name" type="text" value="" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 pull-right text-right mb-4">
                                                <input type="Submit" id="save" class="btn btn-info btn-fill btn-wd bg-color" value="Create" />
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                            
                            <div class="clearfix"></div>
                    </div>
                </div>
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
