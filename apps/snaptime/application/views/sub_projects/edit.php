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
            <a href="<?php echo base_url();?>projects" class="text-red">Projects</a> / <a  class="text-red" href="<?php echo base_url('sub_projects/index/'.$mainproject->id)?>"><?php echo $mainproject->name?></a> / Edit <?php echo $project->name ?>  
        </div>

        <div class="space10"></div>
        <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header pl-15 pr-15 clearfix">
                    <h4 class="card-title tx_bold6 text-capti pull-left">Edit <?php echo $project->name ?> </h4>
                </div>
                <div class="w-100 over_hidden"><hr></div>
                <div class="card-content pt-0">
                    <div class="row">
                        <form action="<?php echo base_url('sub_projects/store/'.$project->project_id);?>" method="post" >
                        <input type="hidden" name="id" value="<?php echo $project->id ?>">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="card-body">
                                        <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Sub Project Name <span class="text-light">*</span></label>
                                                    <input class="form-control border-input" maxlength="100" name="sub_project_name" placeholder="Type Sub Project Name" type="text" value="<?php echo $project->name ?>" required>
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group z-index-20">
                                                    <label>Priority</label>
                                                    <select class="form-control selectpicker" name="priority">
                                                    <option value="1" <?php echo ($project->priority == '1') ? 'selected' : '' ?>>Low</option>
                                                        <option value="2" <?php echo ($project->priority == '2') ? 'selected' : '' ?>>Medium</option>
                                                        <option value="3" <?php echo ($project->priority == '3') ? 'selected' : '' ?>>High</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group custom_select_box">
                                                    <label>Status</label>
                                                    <select class="form-control selectpicker" name="status">
                                                    <option value="1" <?php echo ($project->status == '1') ? 'selected' : '' ?>>Pending</option>
                                                        <option value="2" <?php echo ($project->status == '2') ? 'selected' : '' ?>>Complete</option>
                                                    </select>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-6">
                                            <div class="form-group custom_select_box">
                                            <label>Assign External resource <span class="text-light">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" multiple id="suppliers"  name="suppliers[]" required>
                                          
                                          <?php foreach($suppliers as $supplier){?>
                                            <option value="<?php echo $supplier->id;?>" <?php foreach($supplier_relations as $supplier_relation) { if($supplier_relation->supplier_id == $supplier->id){echo 'selected';} } ?>><?php echo $supplier->name;?></option>
                                            <?php }?>
                                        </select>
                                                <input type="hidden" name="remove_suppliers">
                                            </div>
                                    </div>
                                    </div>

                                    <div class="row">
                                       
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
                                                    <textarea class="form-control border-input editor" maxlength="100"  name="description"><?php echo $project->description?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                                       <hr>

                                                       </div>
                                        <div class="row">
                                            <div class="col-md-5 pull-right text-right mb-4 ">
                                                <input type="Submit" id="save" class="btn btn-info btn-fill btn-wd bg-color" value="Update" />
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
