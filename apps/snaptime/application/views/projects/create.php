<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>Create New Main Project | Scruffy Dog</title>
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
        <div class="col-lg-12 tx_bold6 p-0 text-capti">
           <a href="<?php echo base_url();?>projects" class="text-red">Projects</a>  /  Create Project
        </div>
        <div class="space10"></div>
        <div class="container-fluid">
        <div class="row">
            <div class="card">

                <div class="card-header pl-15 pr-15 clearfix">
                    <h4 class="card-title tx_bold6 pull-left">Create New Main Project</h4>
                </div>

                <div class="w-100 over_hidden"><hr></div>
                <div class="card-content pt-0">
                    <div class="row">
                        <form action="<?php echo base_url('projects/store');?>" method="post" >
                            <div class="col-md-12">
                                     <div class="card-body ">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group z-index-15">
                                                    <label>Type <span class="text-light">*</span></label>
                                                    <select class="form-control selectpicker" name="type_id" required="">
                                                        <option value="">Select Project Type</option>
                                                        <?php foreach($ProjectTypes as $type){?>
                                                            <option value="<?php echo $type->id ;?>"><?php echo $type->project_type ;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Project Name <span class="text-light">*</span></label>
                                                    <input class="form-control border-input" maxlength="100" name="name" placeholder="Type Project Name" type="text" value="" required="">
                                                   
                                                </div>
                                            </div>

<!--                                            <div class="col-md-6">-->
<!--                                                <div class="form-group">-->
<!--                                                    <label>Accounts Code </label>-->
<!--                                                    <input class="form-control border-input" maxlength="100" name="accounts_code" placeholder="Type Project Accounts Code" type="text" value="" >-->
<!--                                                </div>-->
<!--                                            </div>-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Client Name </label>
                                                    <input class="form-control border-input"  maxlength="100" name="client_name" placeholder="Type Client Name" type="text" value="" >
                                                   
                                                </div>
                                            </div>

<!--                                            <div class="col-md-6">-->
<!--                                                <div class="form-group">-->
<!--                                                    <label>Project Number</label>-->
<!--                                                    <input class="form-control border-input"  maxlength="100" name="accounts_number" placeholder="Type Project Number" type="text" value="" >-->
<!--                                                </div>-->
<!--                                            </div>-->

                                            <?php if($this->session->userdata('role') == 1){?>

                                            <div class="col-md-6">
                                                <div class="form-group z-index-15">
                                                    <label>Line Manager <span class="text-light">*</span></label>
                                                    <select class="form-control selectpicker" data-live-search="true" name="user_id" required="">
                                                        <option value="">Select Line Manager</option>
                                                         <?php foreach($ProjectManagers as $manager){?>
                                                            <option value="<?php echo $manager->user_id ;?>"><?php echo $manager->name ;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php }else{?>
                                                <input name="user_id"  type="hidden" value="<?php echo $this->session->userdata('id') ;?>" >


                                            <?php } ?>


                                            <div class="col-md-6">
                                            <div class="form-group custom_select_box">
                                            <label>Assign External resource <span class="text-light">*</span></label>
                                        <select class="form-control selectpicker " data-live-search="true" multiple="multiple" name="suppliers[]" required="">
                                          
                                          <?php foreach($suppliers as $supplier){?>
                                            <option value="<?php echo $supplier->id;?>"><?php echo $supplier->name;?></option>
                                            <?php }?>
                                        </select>
                                       
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group custom_select_box">
                                            <label>Status</label>
                                            <select class="form-control selectpicker " name="status">
                                                <option value="1">Pending</option>
                                                <option value="2">Complete</option>
                                            </select>
                                        </div>
                                        </div>

                                            

                                        	<div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Due Date <span class="text-light">*</span></label> 
                                                    <input style="cursor:pointer;" class="form-control picker__input" id="due_date_picker" name="due_date" placeholder="Select Due Date" type="date" value="" required=""></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control editor" rows=5 name="description"></textarea>
                                                    </div>
                                                </div>

                                            
                                        </div>

                                    </div>

                                    <div class="row"><hr></div>
                                        <div class="row">
                                            <div class="col-md-5 mb-4 pull-right text-right">
                                                <input type="Submit" id="save" class="btn btn-info btn-fill btn-wd bg-color" value="Create" />
                                            </div>
                                        </div>
                                        
                                </div>
                                 </form>
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
