<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>Projects | Scruffy Dog</title>
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
    <div class="container-fluid table-responsive">
        <div class="row">
             
            <div class="card">
                <div class="card-header project-filter-row">

                    <div class="row">

                        <div class="col-md-4">
                            <h4 class="card-title tx_bold6 pt-2">Work Gallery</h4>
                        </div>
                        
                        <?php //print_r($projects)?>

                        <div class="col-md-8">
                            <div class="text-right supplier-action-box">

                            </div>
                        </div>
                        <div class="w-100 over_hidden"><hr></div>
                    </div>
                    
                </div>
                        <div class="card-content pt-0">

                            <div class="row gallery_home_min no-margin-gutters no-padding-gutters">

                                   <?php foreach ($projects as $project){
                                       if ($this->session->userdata('role') != 'Supplier') {
                                           $id = $project->supplier_id;
                                       } else {
                                           $id = $this->session->userdata('id');
                                       } ?>


                                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6  mb-3">
                                        <div class=" gallery_home bg-white ">

                                            <a href="<?php echo base_url('projects/Gallery/'.$project->id) ?>">
                                                <img src="<?php echo base_url('assets/supplier/' . $id . '/' . $project->screenshot_relation_id . '/' . $project->file) ?>"/>
                                            </a>

                                              <input class="checkbox" type="checkbox">
                                            <span class="mt-2 d-block"><?php $date = date_create($project->created_at);
                                                echo date_format($date, 'H:i d/m/Y'); ?></span>
                                            <span class="mt-1 d-block"><?php echo $project->name; ?></span>
                                        </div>
                                    </div>
                                    <?php }?>

                                </div>
                  
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
