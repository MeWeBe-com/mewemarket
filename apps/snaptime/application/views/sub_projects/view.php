<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title><?php echo $sub_project->name; ?> | Scruffy Dog</title>
    <!--  Fonts and icons -->
    <?php $this->load->view('partial/head.php')?>

</head>
<body class="perfect-scrollbar-on">

    <!-- Main Container -->
    <!-- Main Container -->
    <div class="wrapper">

        <!-- Main SideBar Menu -->
         <?php $this->load->view('partial/sidebar.php') ;?>
        <!-- Body Content Start-->
        <div class="main-panel">
             <!-- Top Menu Bar Start -->
            <?php $this->load->view('partial/navbar.php') ;?>
            
             <!-- Top Menu Bar ENd -->
            
            <div class="">
                <div class="col-lg-12 p-0">
                    <div class="space10"></div>
                    <div class="col-lg-12 tx_bold6 text-capti">  
                        <a href="<?php echo base_url('projects')?>"  class="text-red">Projects</a> /
                        <a href="<?php echo base_url('projects/view/'.$project->id)?>"  class="text-red"><?php echo $project->name?></a> / 
                        <?php echo $sub_project->name; ?>
                    </div>

                    <div class="space10"></div>
                        <div class="col-md-7">
                            <div class="card <?php if($this->session->userdata('role') != 'Supplier'){ echo 'project-card-admin' ; }else{ echo 'project-card-supplier'; } ?>">
                                <div class="card-header row">
                                    <div class="col-md-6  col-sm-6 col-xs-12">
                                    <h4 class="card-title tx_bold6 text-capti"><?php echo $sub_project->name; ?></h4></div>
                                    <div class="col-md-6  col-sm-6 col-xs-6 text-right">
                                    <!-- <a href="#" class="mb0 btn btn-outline-dark  btn-wd">Download brief </a> -->
                                  
                                    </div>
                                </div>
                                
                                <div class="card-content  table-full-width">
                                    <div class="card-header row pt-0">
                                        <div class="col-md-6  col-sm-6 col-xs-6">
                                            <!-- <span>29th June 2020</span> -->
                                            <span><?php if(!empty($sub_project->created_at)){?> <?php echo date("jS F Y",strtotime($sub_project->created_at));  ?> <?php }?></span>
                                        </div>
                                        <?php if(!empty($sub_project->due_date)){?>
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-right secondary-color">
                                            <span>Due Date: <?php echo date("jS F Y",strtotime($sub_project->due_date)); ?></span>
                                        </div> <?php }?>
                                    </div>

                                    <div class="col-md-12  col-sm-6 col-xs-12 pt-3 pb-3">
                                        <span>Status: <?php if($sub_project->status == 1){echo "<span class='text-danger'>Pending</span>";}else if($sub_project->status == 2){echo "<span class='text-success'>Completed</span>";}?></span>
                                    </div>

                                    <!-- <div class="col-md-12 col-sm-6 col-xs-12 pt-3 pb-3">
                                        <h6>Outline of the sub_project here </h6>
                                            <?php echo $sub_project->description; ?>
                                    </div> -->
                                    
                                </div>
                            </div>
                        </div>
                          <div class="col-md-5">
                            <div class="card <?php if($this->session->userdata('role') != 'Supplier'){ echo 'project-card-admin' ; }else{ echo 'project-card-supplier'; } ?>">
                                <div class="card-header">
                                    <h4 class="card-title tx_bold6">
                                        <?php if($this->session->userdata('clockin')){?>
                                            Logged in <a class="text-red text-underline" href="<?php echo base_url($this->session->userdata('table').'/view/'.$this->session->userdata('project_id')); ?>"><?php echo $this->session->userdata('project_name');?></a>
                                        <?php }else{ ?>
                                            Log Time <?php if ($this->session->userdata('role') != 'Supplier') { ?> <small>(Suppliers Start/Stop time from here)</small><?php } ?>
                                        <?php } ?>
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                        <span class="Timer" id="running_timer">00:00:00</span>

                                        <?php if($this->session->userdata('role')  == 'Supplier'){ ?>
                                        <a href="#" onclick="<?php if($this->session->userdata('clockin') !== FALSE) {echo "stop()";}else {echo "start()";}?>"  class=" mt-3 mb-3 btn btn-outline-dark btn-fill  btn-block  "> <?php if($this->session->userdata('clockin') !== FALSE) {echo "Pause / Stop"; }else{echo "Start"; } ?></a>
                                   <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="col-lg-12 p-0">
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h4 class="card-title tx_bold6">Notes</h4>
<!--                                         <p class="mt4 category">W/C 29th June</p> -->       
                                            <!--  <p class="mb0 text-left mt-2 category">3rd June 2020 08:47 </p> -->
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <!-- <p class="mb0 text-right">See detail </p> -->
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <!-- <p class="mb0">Adam Roberts | sub_project Manager</p> -->
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            
                                        </div>

                                        <div class="col-lg-12">
                                               <?php echo $sub_project->description; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <h4 class="card-title tx_bold6">Tasks</h4>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <p class="mb0 text-right"><p class="mb0 text-right"><!-- <a href="team.php" > View team members </a>  --> </p> </p>
                                    </div>
                                </div>
                                <div class="card-content">
                                     <table class="table table-responsive">
                                         <thead>
                                            <tr>
                                                <th class="pl-0">Action</th>
                                                <th class="pl-0">Name</th>
                                              <!--   <th>Description</th> -->
                                                <th>Priority</th>
                                                <th>Status</th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                        <?php foreach($tasks as $task)
                                               {
                                                   ?>
                                            <tr>
                                                 <td class="pl-0">
                                                    <a title="View" href="<?php echo base_url('tasks/view/'.$task->id)?>" class="linkColor text-red" style="margin-right:3px;">
                                                            <span class="ti-book"></span>
                                                        </a>
                                                </td>
                                                <td class="pl-0"><a href="<?php echo base_url('tasks/view/'.$task->id)?>" class="linkColor text-red text-underline text-capti" ><?php echo $task->name?></a> </td>
                                                <!-- <td><?php echo $task->description?></td> -->
                                                <td><?php if($task->priority == 1){echo 'Low'; }elseif($task->priority == 2) {echo "Medium";} elseif($task->priority == 3) {echo "High";}?></td>
                                                <td><?php if($task->status==1){echo "Pending";}elseif($task->status==2) {echo "Completed";} ?></td>

                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <?php if($this->session->userdata('role') != 'Supplier'){?>

                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <h4 class="card-title tx_bold6">Assigned Suppliers</h4>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <form enctype="multipart/form-data" method="post" action="" class="">

                                            <div class="text-left col-lg-12 col-md-12  col-sm-12  col-xs-12 p-0 mb-3 mt-0">
                                                <div class="col-lg-8  col-xs-6 p-1">
                                                    <input style="cursor:pointer;"
                                                           name="date_range" class="form-control border-input "
                                                           placeholder="Select Start Date" type="text"
                                                           value="<?php if(!empty($start_date)){ echo date('d/m/Y',strtotime($start_date)).' - '.date('d/m/Y',strtotime($end_date)); }?>" max='<?php echo date("d-m-Y");?>' >

                                                </div>
                                                <div class="col-lg-2 col-xs-6">
                                                    <input class="btn btn-info btn-fill pull-left btn-wd bg-color"
                                                           type="submit" name="search" value="Search">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-content">
                                     <table class="table table-responsive">
                                         <thead>
                                            <tr>
                                                <th class="pl-0">Name</th>
                                                <th>Total Timesheets</th>
<!--                                                <th class="text-center">Payment Rate</th>-->
<!--                                                <th class="text-center">Skills</th>-->
<!--                                               <th class="text-center">Quality</th>-->
<!--                                               <th class="text-center">Team Work</th>-->
<!--                                               <th class="text-center">Speed</th>-->
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                           <?php $grand_total=0; foreach($assigned_suppliers as $assigned_supplier) {?>
                                            <tr>
                                                <td class="pl-0">
                                                    <a href="<?php echo base_url('supplier/view/'.$assigned_supplier->supplier_id) ;?>" class="text-red text-underline ">
                                                        <?php echo $assigned_supplier->supplier_name;?>
                                                    </a>
                                                </td>
                                                <td> <?php //echo $total=rand(10,50); $grand_total += $total?>
                                                    <?php echo number_format($assigned_supplier->WorkingHours,2).'hr';?>
                                                </td>
<!--                                                <td class="text-center"> --><?php //echo $assigned_supplier->unit_payment_rate;?><!--</td>-->
<!--                                                <td class="text-center"> --><?php //echo $assigned_supplier->skills;?><!--</td>-->
<!--                                                <td class="text-center">--><?php //echo $assigned_supplier->quality;?><!--</td>-->
<!--                                                <td class="text-center">--><?php //echo $assigned_supplier->teamwork;?><!--</td>-->
<!--                                                <td class="text-center">--><?php //echo $assigned_supplier->speed;?><!--</td>-->
                                            </tr>
                                           <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <?php } ?>

                        <?php if ($this->session->userdata('role') != 'Supplier') { ?>

                            <!-- <div class="col-md-12">
                                <div class="card ">
                                    <div class="card-header row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <h4 class="card-title tx_bold6">Total Timesheets</h4>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <p class="mb0 text-right">
                                            <p class="mb0 text-right">
                                                 <a href="team.php" > View team members </a>   </p> </p>
                                        </div>
                                    </div>
                                    <div class="card-content"> <h3><?php echo $grand_total; ?> Hours</h3>
                                    </div>
                                </div>
                            </div> --> <?php } ?>

                         <div class="col-md-12" id="gallery">
                            <div class="card">
                               <div class="card-header row">
                                    <div class="col-md-6 col-sm-12 col-xs-6">
                                        <h4 class="card-title tx_bold6">Gallery</h4>
                                    </div>
                                    <div class="col-md-6  col-sm-6 col-xs-6"><?php if(!empty($work_gallery)){?>

                                        <p class="mb0 text-right">
                                            <?php if($this->session->userdata('role') == 'Supplier'){?>
                                                <button class=" btn-sm btn btn-fill bg-color" id="upload_ss_button" data-target="screenshot_modal" data-toggle="modal">
                                                    Upload Screenshots
                                                </button>
                                            <?php }?>

                                            <a href="<?php echo base_url('sub_projects/Gallery/'.$sub_project->id); ?>" class=" btn-sm btn btn-fill bg-color">View All </a>

                                        </p>

                                <?php }?><!--    </div>-->
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-3 pb-3">
                                    <div class="col-md-6 col-sm-6 col-xs-12 no-padding-gutters">
                                        <h4 class="card-title tx_bold4">Screenshots</h4>
                                    </div>

                                </div>

                               

                                <div class="row gallery_home_min no-margin-gutters no-padding-gutters">
                                  <?php foreach ($work_gallery as $gallery) { ?>

                                     <?php 
                                    if($this->session->userdata('role') != 'Supplier'){
                                        $id = $gallery->supplier_id;
                                    }else{
                                        $id = $this->session->userdata('id');
                                    }

                                ?>

                                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 mb-3">
                                        <div class=" gallery_home bg-white">

                                            <a class="venobox" data-gall="myGallery" title="<?php $date = date_create($gallery->created_at);
                                              echo date_format($date,'H:i d/m/Y'); ?>" href="<?php echo base_url('assets/supplier/'.$id.'/'.$gallery->relation_id.'/'.$gallery->file); ?>">
                                                        <img src="<?php echo base_url('assets/supplier/'.$id.'/'.$gallery->relation_id.'/'.$gallery->file); ?>" />
                                            </a>  
                                            <span class="mt-3 d-inline-block"><?php $date = date_create($gallery->created_at);
                                              echo date_format($date,'H:i d/m/Y'); ?></span>
                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>

                        </div>

<!--                        <div class="col-md-12">-->
<!--                            <div class="card">-->
<!--                               <div class="card-header row">-->
<!--                                    <div class="col-md-6 col-sm-12 col-xs-12">-->
<!--                                        <h4 class="card-title tx_bold6">Photos</h4>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <div class="col-lg-12 col-md-12 mb-4 mt-4 col-sm-12 col-xs-12 mt-3 mb-3">-->
<!--                                    <div class="col-md-2 col-sm-6 col-xs-12 no-padding-gutters">-->
<!--                                        <a href="#" class="mb0 btn btn-outline-dark btn-fill  btn-block ">Upload</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                            </div>-->
<!---->
<!--                        </div>-->
                    </div>
             </div>


            <!-- Footer Bar Start -->
           <?php $this->load->view('partial/footer.php') ;?>
            <!-- Footer Bar End -->
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <div class="modal fade" id="upload_ss_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="col-lg-12 text-center">
                                <h5>
                                    Upload Screenshot Manually
                                </h5>
                                <form action="<?php echo base_url('sub_projects/upload_ss').'/'.$this->uri->segment(3);?>" method="post" enctype="multipart/form-data">
                                    <div class="col-lg-12 p-1 mb-3">
                                        <input class="form-control" type="file" name="screenshots[]" multiple />
                                    </div>
                                    <div class="col-lg-12 p-1 text-left mb-3">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control"></textarea>
                                    </div>
                                    <button type="submit" class=" btn-info btn btn-fill bg-color">Submit</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                                </form>
                            </div>
                        </div>
                        <div class="modal-footer border-0">

                        </div>
                    </div>
                </div>
            </div>

            <?php  $this->load->view('partial/footerscript.php') ;?>
            <script>
                $(document).ready(function(){
                    $("#upload_ss_button").click(function(){
                        $("#upload_ss_modal").modal('show');
                    });
                });
            </script>
</body>
</html>
