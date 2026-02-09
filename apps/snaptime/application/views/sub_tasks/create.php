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
        <div class="col-lg-12 tx_bold6 p-0 text-capti">
           <a href="<?php echo base_url();?>projects"  class="text-red">Projects</a> / <a  class="text-red" href="<?php echo base_url('sub_projects/index/'.$mainproject->id);?>"><?php echo $mainproject->name?></a> / <a   class="text-red" href="<?php echo base_url('tasks/index/'.$sub_project->id);?>"><?php echo $sub_project->name ;?></a> / <a  class="text-red" href="<?php echo base_url();?>sub_tasks/index/<?php echo $task->id;?>"><?php echo $task->name?></a> /   Create Sub Task
        </div>



        <div class="space10"></div>
        <div class="card-content">
        <div class="">
            <div class="card">
                
                <div class="card-content">
                    <div class="row">
                        <div class="card-header pl-15 pt-0 pr-15 clearfix">
                    <h4 class="mt-2 mb-0 tx_bold6 text-capti pull-left">Create New Sub Task</h4>
                </div>
                <div class="w-100 over_heddin"><hr></div>

                    <?php echo validation_errors(); ?>
                        <form action="<?php echo base_url('sub_tasks/store/'.$task->id);?>" method="post" >

                            <div class="col-md-12">
                                <div class="row">

                                    <div class="card-body card-content pt-0">
                                        <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Sub Task Name <span class="text-light">*</span></label>
                                                    <?php echo form_error('sub_task_name'); ?>
                                                    <input class="form-control border-input" maxlength="100" name="sub_task_name" placeholder="Type Sub Task Name" type="text" value="<?php echo set_value('sub_task_name')?>" required>
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group z-index-20">
                                                    <label>Priority</label>
                                                    <select class="form-control selectpicker" name="priority">
                                                        <option value="1" <?php echo set_value('priority') == '1' ? 'selected' : '' ?> >Low</option>
                                                        <option value="2" <?php echo set_value('priority') == '2' ? 'selected' : '' ?>>Medium</option>
                                                        <option value="3" <?php echo set_value('priority') == '3' ? 'selected' : '' ?>>High</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group custom_select_box">
                                                    <label>Status</label>
                                                    <select class="form-control selectpicker" name="status">
                                                        <option value="1" <?php echo set_value('status') == '1' ? 'selected' : '' ?>>Pending</option>
                                                        <option value="2" <?php echo set_value('status') == '2' ? 'selected' : '' ?>>Complete</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="form-group custom_select_box">
                                            <label>Assign External resource <span class="text-light">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" multiple name="suppliers[]" required>
                                          
                                          <?php foreach($suppliers as $supplier){?>
                                            <option value="<?php echo $supplier->id;?>"><?php echo $supplier->name;?></option>
                                            <?php }?>
                                        </select>
                                       
                                        </div>
                                    </div>
                                        </div>

                                          <div class="row">
                                       
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Due Date <span class="text-light">*</span></label>
                                                <input id="due_date_picker" style="cursor:pointer;" class="form-control picker__input" name="due_date" placeholder="Select Due Date" type="date"  required=""></div>
                                        </div>
                                    </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control border-input editor" maxlength="100" name="description"><?php echo set_value('description')?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"><hr></div>
                                        <div class="row">
                                            <div class="col-md-5 pull-right text-right">
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
