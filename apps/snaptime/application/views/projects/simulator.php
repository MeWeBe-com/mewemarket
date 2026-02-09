<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <title>Screenshot Simulator | Scruffy Dog</title>
    <!--  Fonts and icons -->
    <?php $this->load->view('partial/head.php') ?>

</head>
<body class="perfect-scrollbar-on">

<div class="wrapper">

    <!-- Main SideBar Menu -->
    <?php //$this->load->view('partial/sidebar.php'); ?>
    <!-- Body Content Start-->
    <div class="main-panel">
        <div class="col-md-12 pl-3">
            <h3>Screenshot Simulator</h3>
        </div>
        <!-- Top Menu Bar ENd -->

        <div class="">
            <div class="col-lg-12 p-0">
                <div class="space10"></div>
                <div class="col-lg-12 tx_bold6 text-capti">
                    
                    <?php if($module == 'projects'){ ?>
                       <a target="_blank" href="<?php echo base_url('projects') ?>" class="text-red">Projects</a> / <?php echo $project->name; ?>
                    <?php }elseif($module == 'sub_projects'){?>
                       <a target="_blank" href="<?php echo base_url('projects')?>"  class="text-red">Projects</a> /
                       <a target="_blank" href="<?php echo base_url('projects/view/'.$project->id)?>"  class="text-red"><?php echo $project->name?></a> / 
                       <?php echo $sub_project->name; ?>
                    <?php }elseif($module == 'tasks'){?>
                        <a target="_blank" href="<?php echo base_url('projects')?>"  class="text-red">Projects</a> / 
                         <a target="_blank" href="<?php echo base_url('projects/view/'.$project->id)?>"  class="text-red"><?php echo $project->name; ?> </a> /
                         <a target="_blank" href="<?php echo base_url('sub_projects/view/'.$sub_project->id)?>"  class="text-red"><?php echo $sub_project->name; ?> </a> /
                         <?php echo $tasks->name; ?>
                    <?php }elseif($module == 'sub_tasks'){?>
                        <a target="_blank" href="<?php echo base_url('projects')?>" class="text-red">Projects</a> / 
                        <a target="_blank" href="<?php echo base_url('projects/view/'.$project->id)?>" class="text-red"><?php echo $project->name; ?> </a> / 
                        <a target="_blank" href="<?php echo base_url('sub_projects/view/'.$sub_project->id)?>" class="text-red"><?php echo $sub_project->name; ?> </a> /
                        <a target="_blank" href="<?php echo base_url('tasks/view/'.$tasks->id)?>" class="text-red"><?php echo $tasks->name; ?> </a> / 
                         <?php echo $sub_task->name; ?>
                   <?php  } ?>

                </div>

                <div class="space10"></div>
                <div class="col-md-7">
                    <div class="card <?php if ($this->session->userdata('role') != 'Supplier') {
                        echo 'project-card-admin';
                    } else {
                        echo 'project-card-supplier';
                    } ?>  ">
                        <div class="card-header row">
                            <div class="col-md-12  col-sm-6 col-xs-12">
                                <h5>Time Log started for this task.</h5>

                                <h5>A Screenshot will be sent every 15mins.</h5>

                                <h5>To Stop the Time/Screenshots Log back in to the website and press Stop.</h5>

                                <h5>Send a screenshot now or select an image to upload:</h5>

                                <p>
                                    <button type="button" class="btn btn-wd btn-info btn-fill bg-color has-loader">
                                        SCREENSHOT
                                    </button>

                                     <button type="button" class="btn btn-wd btn-info btn-fill bg-color has-loader">
                                        UPLOAD IMAGE
                                    </button>
                                </p>
 
                            </div>
                        </div>
                        <div class="space10"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div class="col-lg-12 p-0">
                <div class="col-md-12" id="gallery">
                    <div class="card">
                        <div class="card-header row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <h4 class="card-title tx_bold6">Gallery</h4>
                            </div>
                            <div class="space10"></div>
                        </div>

                        <div id="latestImage" class="row gallery_home_min no-margin-gutters no-padding-gutters">

                          <!--   <?php if (!empty($screenshots)) {
                                foreach ($screenshots as $shots) {
                                    if ($this->session->userdata('role') != 'Supplier') {
                                        $id = $shots->supplier_id;
                                    } else {
                                        $id = $this->session->userdata('id');
                                    }
                                    ?>
                                    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6  mb-3">
                                        <div class=" gallery_home bg-white">

                                            <a class="venobox" data-gall="myGallery"
                                               title="<?php $date = date_create($shots->created_at);
                                               echo date_format($date, 'H:i d/m/Y'); ?>"
                                               href="<?php echo base_url('assets/' . $id . '/' . $shots->relation_id . '/' . $shots->file) ?>">
                                                <img src="<?php echo base_url('assets/' . $id . '/' . $shots->relation_id . '/' . $shots->file) ?>"/>
                                            </a>
                                            <span class="mt-3 d-block"><?php $date = date_create($shots->created_at);
                                                echo date_format($date, 'H:i d/m/Y'); ?></span>
                                            <span class="mb-3 d-block"><?php echo $shots->project_name; ?></span>

                                        </div>
                                    </div>
                                <?php }
                            } ?> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Footer Bar Start -->
        <?php $this->load->view('partial/footer.php'); ?>
        <!-- Footer Bar End -->
    </div>
</div>

<?php $this->load->view('partial/footerscript.php'); ?>

<script>
    
    <?php
    if($this->session->userdata('send_image') != false && $this->session->userdata('role') =='Supplier'){

    ?>

    ScreenShot();

    setInterval(function () {
        ScreenShot();
    }, 60000);

    function ScreenShot(){
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
        var date = dt.getDay() + "-" + dt.getMonth() + "-" + dt.getFullYear();

        $.ajax({
            url: '<?php echo base_url();?>activity/store_screenshot',
            method: 'post',
            dataType: "json",
            data: {
                supplier_id: '<?php echo $this->session->userdata('id')?>',
                relation_id: '<?php if ($this->session->userdata('relation_id') !== null) {
                    echo $this->session->userdata('relation_id');
                } ?>',
                status: 1, image: '<?php echo base_url();?>home/create_image/' + date + time
            },
            success: function (response) {

                var base_url = "<?php echo base_url()?>";
                //console.log("<img src='"+base_url+"'assets/'"+response.supplier_id+"'/'"+response.relation_id+"'/'"+response.file+"'");

                $('#latestImage').prepend('<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 mb-3"><div class=" gallery_home bg-white"><img src="'+base_url+'assets/supplier/'+response.supplier_id+'/'+response.relation_id+'/'+response.file+'"><span class="mt-3 d-inline-block">'+response.created_at+'</span></div></div>');

                ;

            }
        });
    }


   $(window).bind('beforeunload', function(e) {
    // Your code and validation
        if (confirm) {
            return "Are you sure?";
        }
    });

    <?php } ?>

</script>

</body>
</html>
