<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../../../assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>Home | Scruffy Dog</title>
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

            <div class="col-lg-12 tx_bold6 text-capti pl-0">
                    <a href="<?php echo base_url('projects') ?>" class="text-red">Projects</a>
                    /
                     <a href="<?php echo base_url('sub_projects/index/'.$project_bread->id); ?>" class="text-red"><?php echo $project_bread->name ?></a>
                    /
                      <a href="<?php echo base_url('tasks/index/'.$sub_project->id) ;?>" class="text-red"><?php echo $sub_project->name ?></a>
                    /
                    <?php echo $task->name ?>
                </div>

                <div class="space10"></div>

            <div class="card table-responsive">
                <div class="card-header project-filter-row">
                    <div class="row">
                        <div class="col-md-4 col-xs-6">
                            <h4 class="card-title tx_bold6 text-capti pt-2"><?php echo $task->name ?></h4>
                        </div>
                        <div class="col-md-8 col-xs-6">
                            <div class="text-right supplier-action-box">
                                <?php if($this->session->userdata('role') == '1') {?>
                                    <a class="btn btn-info btn-fill btn-wd bg-color" href="<?php echo base_url('sub_tasks/create/'.$task->id);?> ">
                                        Create Sub Task
                                    </a>
                                <?php } ?>
<!--                                 <input class="form-control" id="search" name="search" placeholder="search" type="text">
 -->                            </div>
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
                                <!-- <th>Description</th> -->
                              
                                <th>Screenshots</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($sub_tasks as $sub_task){
                                if($this->session->userdata('role') == 'Supplier'){
                                    $supplier_id = $this->session->userdata('id');
                                    $id = $this->session->userdata('id');
                                }else{
                                    $supplier_id = '';
                                    $id = '';
                                }
                                $screenshots = $this->supplier_screenshots_model->get_3_work_gallery($supplier_id,'sub_tasks',$sub_task->id);
                                ?>
                            <tr>
                                <td>
                                    <a title="Details" href="<?php echo base_url('sub_tasks/view/'.$sub_task->id)?>" class="linkColor text-red" style="margin-right:3px;">
                                        <span class="ti-book"></span>
                                    </a>
                                    <?php if($this->session->userdata('role') != 'Supplier') {?>
                                        <a title="Edit" href="<?php echo base_url('sub_tasks/edit/'.$sub_task->id);?>" class="linkColor text-red" style="margin-right:3px;">
                                            <span class="ti-pencil-alt"></span>
                                        </a>
                                        <a title="Delete" onclick="return confirm('Are you sure?')" href="<?php echo base_url('sub_tasks/delete/'.$sub_task->id)?>" class="customhover text-red"><span class="ti-trash"></span></a>
                                    <?php } ?>
                                </td>
                                
                                <td><a href="<?php echo base_url('sub_tasks/view/'.$sub_task->id); ?> " class="linkColor text-red text-underline text-capti customlinkSettings"><?php echo $sub_task->name?></a></td>
                                <td><?php foreach ($screenshots as $screenshot)
                                    {
                                        ?> <a class="venobox" data-gall="myGallery"
                                              title="<?php $date = date_create($screenshot->created_at);
                                              echo date_format($date, 'H:i d/m/Y'); ?>"
                                              href="<?php echo base_url('assets/supplier/' . $screenshot->supplier_id . '/' . $screenshot->relation_id . '/' . $screenshot->file) ?>">
                                        <img width="50" height="25" src="<?php echo base_url('assets/supplier/' . $screenshot->supplier_id. '/' . $screenshot->relation_id . '/' . $screenshot->file) ?>"/>
                                    </a>
                                        <?php
                                    }
                                    ?><a class="text-red text-underline" href="<?php echo base_url('sub_tasks/Gallery/'.$sub_task->id)?>">view all</a>
                                </td>


                                <td><?php if(!empty($sub_task->due_date)){  $date = date_create($sub_task->due_date); echo date_format($date,'d/m/Y'); } ?></td>

                            </tr>

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
