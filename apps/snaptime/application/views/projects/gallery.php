<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <title><?php echo $project->name; ?> | Scruffy Dog</title>
    <!--  Fonts and icons -->
    <?php $this->load->view('partial/head') ?>

</head>
<body class="perfect-scrollbar-on">

<!-- Main Container -->
<!-- Main Container -->
<div class="wrapper">

    <!-- Main SideBar Menu -->
    <?php $this->load->view('partial/sidebar'); ?>
    <!-- Body Content Start-->
    <div class="main-panel">
        <div class="col-md-12 p-0">
            <!-- Top Menu Bar Start -->
            <?php $this->load->view('partial/navbar'); ?>

        </div>
        <!-- Top Menu Bar ENd -->

        <div class="content pt-4 mt-1 pl-0 pr-0">
                <div class="col-lg-12 ">
                    <div class="space10"></div>
                    <div class="col-lg-12 tx_bold6 pl-0"> 
                       <a href="<?php echo base_url('workgallery');?>" class="text-red"> Work gallery </a> / <!-- <a href="<?php echo base_url('projects/view/'.$work_gallery[0]->projects_id);?>" class="text-red"> --> <?php echo isset($project->name) ? $project->name : ''; ?> <!-- </a>  -->
                    </div>

                    <div class="space10"></div>
                        <div class="col-md-12 p-0">
                            <div class="card ">
                                <div class="card-header row">
                                    <div class="col-md-12  col-sm-12 col-xs-12">
                                        <h4 class="card-title tx_bold6 text-capti"><?php echo isset($project->name) ? $project->name : ''; ?></h4>
                                     </div>

                                    <div class="col-md-12 pl-0"> 
                                         <div class="w-100"><hr></div>
                                       <form enctype="multipart/form-data" method="post" action="" class="">

                                        <div class="text-left col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0 mb-3 mt-0">
                                                <div class="col-lg-5 p-1">
                                                    <input style="cursor:pointer;"
                                                           name="date_range" class="form-control border-input "
                                                           placeholder="Select Start Date" type="text"
                                                           value="<?php if(!empty($start_date)){ echo date('d/m/Y',strtotime($start_date)).' - '.date('d/m/Y',strtotime($end_date)); }?> " >
                                                </div>

                                            <?php if($this->session->userdata('role') != 'Supplier'){?>

                                            <div class="col-lg-5 p-1">
                                                <div >
                                                    <select class="form-control mt-0 pt-1 selectpicker"
                                                            name="supplier_id">
                                                        <option value="">Select Supplier</option>
                                                        <?php foreach ($suppliers as $supplier) { ?>
                                                            <option value="<?php echo $supplier->id; ?>"  <?php echo ($SelectedSupplier == $supplier->id) ?  'selected' : '' ?>><?php echo $supplier->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php }?>
                                                
                                            <div class="col-lg-2">
                                                <input class="btn btn-info btn-fill pull-left btn-wd bg-color"
                                                       type="submit" name="search" value="Search">
                                            </div>

                                        </div>

                                </form>


                                    </div>

                                   </div>

                                <div class="card-content  table-full-width pt-0">
                                    <div class="card-header row pt-0">
                                        <div class="col-md-4 mt-3 mb-3 col-sm-6 col-xs-12">
                                            <span class="mt-1 mb-0 tx_bold6">Screen shots</span>
                                        </div>
                                       <!--  <div class="col-md-4  col-sm-6 col-xs-12">
                                            <label class="mt-3">Sort by: <a class="pr-2 active" href="#">Newest</a> | <a href="#">Oldest</a></label>
                                        </div> -->
                                        <!-- <div class="col-md-4 col-sm-6 col-xs-12 text-right secondary-color">
                                            <h5 class="mt-1 mb-0"><a class="pr-2 delete" href="javascript:;" >Delete</a> <a href="">Organise</a></h5>
                                        </div> -->
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3 deletedbox">
                                    <div class="col-md-4  col-sm-6 col-xs-12 pl-0">
                                        <a href="javascript:;" class="mb0 btn btn-outline-dark btn-fill btn-wd">Delete Selected </a>

                                        <a href="javascript:;" class="mb0 btn btn-danger btn-fill btn-wd cancel">Cancel </a>
                                    </div>
                                </div>

<!--                                <div class=" col-lg-12 ">-->
<!--                                   -->
<!--                                    <div class="col-md-1  col-sm-2 col-xs-3 pl-0">-->
<!--                                        <span>30/6/20</span> -->
<!--                                    </div>-->
<!--                                    <div class="col-md-11  col-sm-10 col-xs-9">-->
<!--                                       <hr class="mt-3"/>-->
<!--                                    </div>-->
<!--                                    -->
<!--                                </div>-->



                                <div class="row gallery_home_min no-margin-gutters no-padding-gutters">

                                   <?php if(!empty($work_gallery)){ foreach ($work_gallery as $gallery){

                                       if ($this->session->userdata('role') != 'Supplier') {
                                           $id = $gallery->supplier_id;
                                       } else {
                                           $id = $this->session->userdata('id');
                                       }

                                       ?>
                                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6  mb-3">
                                        <div class=" gallery_home bg-white ">

                                            <a class="venobox" data-gall="myGallery"
                                               title="<?php $date = date_create($gallery->created_at);
                                               echo date_format($date, 'H:i d/m/Y'); ?>"
                                               href="<?php echo base_url('assets/supplier/' . $id . '/' . $gallery->relation_id . '/' . $gallery->file) ?>">
                                                <img src="<?php echo base_url('assets/supplier/' . $id . '/' . $gallery->relation_id . '/' . $gallery->file) ?>"/>
                                            </a>

                                              <input class="checkbox" type="checkbox">
                                            <span class="mt-2 d-block"><?php $date = date_create($gallery->created_at);
                                                echo date_format($date, 'H:i d/m/Y'); ?></span>
                                            <!-- <span class="mt-1 d-block"><?php echo $gallery->projects_name; ?></span> -->
                                            <span class="mt-1 d-block"><?php echo $gallery->supplier_name; ?></span>
                                        </div>
                                    </div>



                                    <?php } ?> <div class="dataTables_paginate paging_numbers col-lg-12" ><?php echo $pagination;  ?></div><?php }else { ?>

                                        <h4 class="pl-4 mt-0">No data found</h4>

                                    <?php } ?>

                                </div>

                            </div>

                            </div>
                        </div>
                          
                    </div>
       

        
        <!-- Footer Bar Start -->
        
        <!-- Footer Bar End -->
         <?php $this->load->view('partial/footer'); ?>

    </div>
</div>


<?php $this->load->view('partial/footerscript'); ?>

</body>
</html>

