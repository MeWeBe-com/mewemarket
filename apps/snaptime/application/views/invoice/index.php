<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>Invoices | Scruffy Dog</title>
    <!--  Fonts and icons -->
    <?php $this->load->view('partial/head.php')?>

</head>
<body class="perfect-scrollbar-on ">

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
                                    <h4 class="card-title tx_bold6">Select External resource</h4>
                                </div>
                                <div class="w-100 over_hidden"><hr></div>
                            </div>

                        </div>
                        <div class="card-content pt-0">

                            <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%" id="datatables">
                                <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Name</th>

                                    <th>Type</th>

                                  <!--  <th class="text-center pr-0">Accounts Code</th>
                                    <th class="text-center pr-0">Rating</th>-->
                                    <th class="text-center pr-0">Department</th>
                                    <th>Date&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php

                                foreach($suppliers as $supplier){
                                    ?>
                                    <tr>
                                        <td>
                                            <a title="View"  class="text-red" href="<?php echo base_url('invoice/show/'.$supplier->id.'/')?>" class="linkColor" style="margin-right:3px;">
                                                <span class="ti-book"></span>
                                            </a>
                                        </td>
                                        <td><a title="View"  class="text-red text-underline" href="<?php echo base_url('invoice/show/'.$supplier->id.'/')?>" style="margin-right:3px;"><?php echo $supplier->name; ?></a> </td>
                                        <td><?php echo $supplier->supplier_name; ?></td>

<!--                                        <td class="text-center">--><?php //echo $supplier->accounts_code; ?><!--</td>-->
<!--                                        <td class="text-center">--><?php //echo $supplier->skills; ?><!--</td>-->
                                        <td class="text-center"><?php echo $supplier->department_name; ?></td>
                                        <td><?php $date = date_create($supplier->created_at); echo date_format($date,'d/m/Y'); ?></td>



                                    </tr>

                                <?php }
                                ?>
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
