<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>External resource | Scruffy Dog</title>
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

 <div class="content pt-4 mt-1  ">
    <div class="container-fluid table-responsive">
        <div class="row">
            <div class="card">
                <div class="card-header project-filter-row">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-6">
                            <h4 class="card-title tx_bold6  pt-2">External resource</h4>
                        </div>
                        <?php if($this->session->userdata('role') == 1){?>
                        <div class="col-md-8 col-sm-6 col-xs-6">
                            <div class="text-right supplier-action-box">
                                <a class="btn btn-info btn-fill btn-wd bg-color" href="<?php echo base_url('supplier/create');?>">  Create Supplier</a>
                                <!-- <input class="form-control" id="search" name="search" placeholder="search" type="text"> -->
                            </div>
                        </div> <?php }?>
                        <div class="w-100 over_hidden"><hr></div>
                    </div>
                     
                </div>
                <div class="card-content pt-0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group custom_select_box">
                                <label>Type </label>
                                <select class="form-control selectpicker" name="supplier_type" id="supplier_type" required="">
                                   <option value="">Select Type</option>
                                    <?php foreach($supplier_type as $type){?>
                                        <option value="<?php echo $type->id;?>"><?php echo $type->name;?></option>
                                    <?php }?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group custom_select_box">
                                <label>Department</label>
                                <select class="form-control selectpicker" name="department" id="department" required="">
                                    <option value="">Select Department</option>
                                    <?php foreach($supplier_department as $supplier_department){?>
                                        <option value="<?php echo $supplier_department->id;?>"><?php echo $supplier_department->name;?></option>
                                    <?php }?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%" id="datatables">
                    <thead>
                            <tr>
                                <?php if($this->session->userdata('role') == '1'){ ?>
                                <th>Action</th> <?php }?>
                                <th>Name</th>
                                 <th>Phone Number</th>
                                <th class="text-left">Screenshots</th>
                                <th class="text-left pr-0">Type</th>
                                <th class="text-left pr-0">Department</th>
                                <th class="text-left pr-0">Address</th>
                                <th class="text-left pr-0">Rating</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach($suppliers as $supplier){

                                $screenshots = $this->supplier_screenshots_model->get_3_work_gallery_by_supplier($supplier->id);
                                $department = $this->supplier_model->GetSupplierDepartmentByID($supplier->department_id);
                               ?>
                            <tr>
                                <?php if($this->session->userdata('role') == '1'){ ?>
                                <td>
                                    <?php if(!empty($supplier->resume)){?>
                                    <a  title="Resume" download href="<?php echo base_url('assets/supplier/'.$supplier->resume)?>" class="text-red">
                                        <span class="ti-file"></span>
                                    </a>
                                    <?php }?>
                                    <a title="Edit" href="<?php echo base_url('supplier/edit/'.$supplier->id)?>" class="linkColor text-red" style="margin-right:3px;">
                                        <span class="ti-pencil-alt"></span>
                                    </a>
                                    <a href="<?php echo base_url('supplier/delete/'.$supplier->id)?>" title="Delete" onclick="return confirm('Are you sure?')" class="customhover text-red"><span class="ti-trash"></span></a>
                                </td>
                                <?php }?>
                             <!--   <td><?php $date = date_create($supplier->created_at); echo date_format($date,'d/m/Y'); ?></td> -->
                                <td><a href="<?php echo base_url('supplier/view/'.$supplier->id)?>" class="linkColor text-red text-underline" style="margin-right:3px;">
                                    <?php echo $supplier->name; ?></a>
                                </td>
                                <td><?php echo $supplier->phone_number;?></td>
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
                                    ?>
                                    <a class="text-red text-underline" href="<?php echo base_url('projects/Gallery/'.$supplier->id)?>">view all</a></td>
                                <td class="text-left"><?php $supplier_type = $this->supplier_model->GetSupplierTypeByID($supplier->supplier_type_id);
                                    echo isset($supplier_type->name) ? $supplier_type->name : '';?></td>
                                <td class="text-left"><?php echo isset($department->name) ? $department->name : ''?></td>
                                <td class="text-left"><?php if(!empty($supplier->address)){ echo $supplier->address.', '.$supplier->city.'<br />'.$supplier->state.', '.$supplier->zipcode ;}?></td>
                                <td class="text-left"><?php echo $supplier->skills;?></td>
                               
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
<script>

</script>

</body>
</html>
