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
                            <h4 class="card-title tx_bold6 pt-2">Projects</h4>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="text-right supplier-action-box">
                                <?php if($this->session->userdata('role') == '1') {?>
                                    <a class="btn btn-info btn-fill btn-wd bg-color" href="<?php echo base_url('projects/create');?>">
                                        Create Project
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
                               <th  width="15%">Type</th>
                                <th width="15%" orderable="true">Name</th>
                                <th width="15%" >Client</th>
                                <?php if($this->session->userdata('role') != '0') {?>
                                <th width="15%" >Manager</th>
                                <?php }?>
                                <th width="15%" >Status</th>
                                <!-- <th width="15%">Accounts Code</th> -->
                                <th width="12%">Due Date&nbsp;</th>
                                
                               
                                <th width="30%" class="pr-0 text-center">View Sub Projects</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            foreach($projects as $project){ //print_r($project);

                            ?>
                            <tr>
                                <td>

                                        <a title="Restore" onclick="return confirm('Are you sure?')" href="<?php echo base_url('projects/restore/'.$project->id);?>" class="customhover text-red"><span class="ti-reload"></span></a>
                                </td>

                                <td><?php echo $project->project_type?></td>
                                <td><a href="<?php echo base_url('projects/view/'.$project->id)?>" class="text-red text-underline text-capti"><?php echo $project->name?></a></td>
                                <td><?php echo $project->client_name?></td>
                                <?php if($this->session->userdata('role') != '0') {?>
                                <td><?php echo $project->manager_name?></td>
                                <?php }?>
                                <!-- <td ><?php echo $project->accounts_code?></td> -->
                                <td><?php if ($project->status == 1) {
                                        echo "Pending";
                                    } else if ($project->status == 2) {
                                        echo "Completed";
                                    } ?></td>
                                <td class="pr-0"><?php if(!empty($project->due_date)){ $date = date_create($project->due_date); echo date_format($date,'d/m/Y'); } ?></td>
                               

                                <td class="text-center"><a href="<?php echo base_url('sub_projects/index/'.$project->id);?>" class="linkColor customlinkSettings text-red text-underline">View</a></td>

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
