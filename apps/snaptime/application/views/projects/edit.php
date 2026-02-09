<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>Edit <?php echo $project->name; ?> | Scruffy Dog</title>
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
                <a href="<?php echo base_url('projects');?>"  class="text-red">Projects</a>  / Edit <?php echo $project->name; ?>


               <!--  <a href="<?php echo base_url('projects');?>">Main Directory</a>  / <a href="<?php echo base_url('projects/edit/'.$project->id);?>">Edit <?php echo $project->name; ?></a> -->
            </div>



            <div class="space10"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="card">
                        <div class="card-header pl-15 pr-15 clearfix">
                            <h4 class="card-title tx_bold6 pull-left text-capti">Edit <?php echo $project->name; ?> Project</h4>
                        </div>
                        <div class="w-100 over_hidden"><hr></div>
                        <div class="card-content pt-0">
                            <div class="row">
                                <form action="<?php echo base_url('projects/store') ?>" method="post" >
                                    <input type="hidden" name="id" value="<?php echo $project->id ?>">
                                    <div class="col-md-12">
                                        <div class="">
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group custom_select_box">
                                                            <label>Type <span class="text-light">*</span></label>
                                                            <select class="form-control selectpicker" name="type_id" required="">
                                                                <option value="">Select Project Type</option>
                                                                <?php foreach($project_types as $type){?>
                                                                    <option value="<?php echo $type->id ;?>" <?php echo ($project->type_id == $type->id) ? 'selected' : '' ?> ><?php echo $type->project_type ;?></option>
                                                                <?php }?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Project Name <span class="text-light">*</span></label>
                                                            <input class="form-control border-input" maxlength="100" name="name" placeholder="Type Project Name" type="text" value="<?php echo $project->name; ?>" required="">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
<!--                                                    <div class="col-md-6">-->
<!--                                                        <div class="form-group">-->
<!--                                                            <label>Accounts Code <span class="text-light">*</span></label>-->
<!--                                                            <input class="form-control border-input" maxlength="100" name="accounts_code" placeholder="Type Project Accounts Code" type="text" value="--><?php //echo $project->accounts_code; ?><!--" >-->
<!--                                                        </div>-->
<!--                                                    </div>-->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Client Name </label>
                                                            <input class="form-control border-input"  maxlength="100" name="client_name" placeholder="Type Client Name" type="text" value="<?php echo $project->client_name; ?>" >

                                                        </div>
                                                    </div>

<!--                                                    <div class="col-md-6">-->
<!--                                                        <div class="form-group">-->
<!--                                                            <label>Project Number </label>-->
<!--                                                            <input class="form-control border-input"  maxlength="100" name="accounts_number" placeholder="Type Project Number" type="text" value="--><?php //echo $project->accounts_number; ?><!--" >-->
<!--                                                        </div>-->
<!--                                                    </div>-->

<!--                                                    <div class="col-md-6">-->
<!--                                                        <div class="form-group custom_select_box">-->
<!--                                                            <label>Line Manager <span class="text-light">*</span></label>-->
<!--                                                            <select class="form-control selectpicker" name="user_id" required="">-->
<!--                                                                <option value="">Select Line Manager</option>-->
<!--                                                                --><?php //foreach($project_managers as $manager){?>
<!--                                                                    <option value="<?php //echo $manager->user_id ;?>" <?php //echo ($project->user_id == $manager->user_id) ? 'selected' : '' ?><?php //echo $manager->name ;?></option>-->
<!--                                                                --><?php //}?>
<!--                                                            </select>-->
<!--                                                        </div>-->
<!--                                                    </div>-->

                                                    <?php if($this->session->userdata('role') == 1){?>
                                                        <div class="col-md-6">
                                                            <div class="form-group custom_select_box">
                                                                <label>Line Manager <span class="text-light">*</span></label>
                                                                <select class="form-control selectpicker" name="user_id" required="">
                                                                    <option value="">Select Line Manager</option>
                                                                    <?php foreach($ProjectManagers as $manager){?>
                                                                        <option <?php echo ($project->user_id == $manager->user_id) ? 'selected' : '' ?> value="<?php echo $manager->user_id ;?>"><?php echo $manager->name ;?></option>
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
                                        <select class="form-control selectpicker" data-live-search="true" multiple id="suppliers" name="suppliers[]" required="">
                                          
                                          <?php foreach($suppliers as $supplier){?>
                                            <option value="<?php echo $supplier->id;?>" <?php foreach($supplier_relations as $supplier_relation) { if($supplier_relation->supplier_id == $supplier->id){echo 'selected';} } ?>><?php echo $supplier->name;?></option>
                                            <?php }?>
                                        </select>
                                                <input type="hidden" name="remove_suppliers">
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
                                                            <input id="due_date_picker" style="cursor:pointer;" class="form-control picker__input" name="due_date" placeholder="Select Due Date" type="date" value="<?php echo $project->due_date; ?>" required=""></div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                        <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea class="form-control editor" rows="2" name="description"><?php echo $project->description; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="row mr-0 ml-0"><hr></div>
                                                         <div class="row">
                                                            
                                                    <div class="col-md-5 mr-4 mb-4 pull-right text-right mb-4">
                                                        <input type="Submit" id="save" class="btn btn-info btn-fill btn-wd bg-color" value="Update" />
                                                    </div>
                                                </div>

                                    </div>

                                       
                                    </div>

                                                

                                            </div>
                                        </div>
                                    
                                </form>
</div>
                                <div class="clearfix"></div>
                    
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
<script>
    $(document).ready(function () {


        $('#suppliers').on('change',function () {
            var originalArray = new Array();
            var implodedArray = '';
            $(this).find('option').not(':selected').each(function(k,v){
                 originalArray.push(v.value);
                var separator = ',';
                implodedArray = originalArray.join(separator);
            });
           $('input[name="remove_suppliers"]').val(implodedArray);

        });

    });
</script>
</body>
</html>
