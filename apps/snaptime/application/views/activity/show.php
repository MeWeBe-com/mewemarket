<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>Access Log | Scruffy Dog</title>
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

                  <div class="col-lg-12 tx_bold6 text-capti pl-0">
                        <?php if($this->session->userdata('role') != 'Supplier'){ ?>
                        <a class="text-red text-capitalize" href="<?php echo base_url('activity/')?>">Activities </a>
                        <?php }else{
                            echo "Activities";
                        }?> /
                        <?php echo ucfirst($supplier_name);?> Access Log
                    </div>

                    <div class="space10"></div>  
                    <div class="card">
                        <div class="card-header project-filter-row">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="card-title tx_bold6">Access Log</h4>
                                </div>
                                <div class="w-100 over_hidden"><hr></div>
                            </div>

                        </div>
                        <div class="card-content pt-0">

                            <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%" id="datatables">
                                    <thead>
                                    <tr>
                                        <!-- <th>Name</th> -->
                                        <th>Date</th>
                                        <th>Action</th>
                                        <th>IP Address</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php

                                    foreach($activities as $activity){
                                        ?>
                                        <tr>
                                           <!--  <td><?php echo $activity->name; ?></td> -->
                                            <td><?php $date = date_create($activity->created_at); echo date_format($date,'d/m/Y h:i:s'); ?></td>
                                            <td>
                                            <?php if(!empty($activity->url)){ ?>
                                                <a class="text-red text-underline" href="<?php echo $activity->url ?>"><?php echo $activity->action ?></a>
                                            <?php }else{ ?>
                                                <?php echo $activity->action ?>
                                            <?php }?></td>
                                           <!-- <td><a class="text-red text-underline" href="<?php /*echo $activity->url */?>"><?php /*echo $activity->action */?></a></td>
                                           --> <td><?php echo $activity->ip?></td>

                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>


                            <div class="fixed-table-pagination">

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
