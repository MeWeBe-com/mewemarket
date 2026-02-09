<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title><?php if(!empty($users)){ ?>
                       Edit <?php if(!empty($users)){ echo $users[0]->name; }?>
                <?php }else{ ?>
                     Create New User
                <?php }?> | Scruffy Dog</title>
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
   <!--  <div class="row" style="margin-bottom:10px;"> -->
       <!--  <div class="col-md-12 custombreadcrumb">
            <a href="<?php echo base_url();?>user">Users</a><span class="arrowCrumb"> / </span>
                <?php if(!empty($users)){ ?>
                       <a href="#">Edit <?php if(!empty($users)){ echo $users[0]->name; }?></a>
                <?php }else{ ?>
                     <a href="#">Create New User</a>
                <?php }?>
        </div> -->

        <div class="col-lg-12 tx_bold6 p-0 text-capti">
           <a href="<?php echo base_url();?>user" class="text-red">Users</a> / <?php if(!empty($users)){ ?>
                       Edit <?php if(!empty($users)){ echo $users[0]->name; }?> 
                <?php }else{ ?>
                     Create New User
                <?php }?>
        <!-- </div> -->
        <div class="space10"></div>
    </div>
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-header pl-15 pr-15">
                        <h4 class="card-title tx_bold6 text-capti"><?php if(!empty($users)){ ?>
                       Edit <?php if(!empty($users)){ echo $users[0]->name; }?> 
                <?php }else{ ?>
                     Create New User
                <?php }?></h4>
                    </div>
                    <div class="w-100 over_hedding"><hr></div>
                    <div class="card-content pt-0">
                        <form action="<?php echo base_url()?>user/AddNewUser"  method="post">                      
                        <input name="id" type="hidden" value="<?php if(!empty($users)){ echo $users[0]->user_id; }?>" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name <span class="text-light">*</span></label>
                                        <input class="form-control border-input" maxlength="50" name="name" placeholder="Type User Name" type="text" value="<?php if(!empty($users)){ echo $users[0]->name; }?>" required="">
                                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-light">*</span></label>
                                    <input class="form-control " required="" maxlength="50" name="email" placeholder="Type Email Address" type="email" value="<?php if(!empty($users)){ echo $users[0]->email; }?>">                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password <span class="text-light">*</span></label>
                                    <input class="form-control" placeholder="Enter Password" id="password" maxlength="50" name="password" type="password" <?php if(empty($users)){ echo 'required' ; }?>>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm Password <span class="text-light">*</span></label>
                                    <input class="form-control" id="confirmpassword" maxlength="50"  type="password" placeholder="Enter Confirm Password" <?php if(empty($users)){ echo 'required' ; }?>>
                                    <span class="text-danger" id="Confirmerror"></span>                                     
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Telephone No.</label>
                                        <input class="form-control border-input" maxlength="20" name="phone"  placeholder="Type Telephone No" type="text" value="<?php if(!empty($users)){ echo $users[0]->phone; }?>"  >
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group z-index-20">
                                        <label>Status <span class="text-light">*</span></label>
                                        <select class="form-control selectpicker" required="" name="status">
                                            <option <?php if(!empty($users) && $users[0]->status == '0' ){ echo 'selected'; }?> value="0">Active</option>
                                            <option <?php if(!empty($users) && $users[0]->status == '1' ){ echo 'selected'; }?> value="1">Inactive</option>
                                            <option <?php if(!empty($users) && $users[0]->status == '2' ){ echo 'selected'; }?> value="2">Suspended</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group custom_select_box">
                                        <label>Role <span class="text-light">*</span></label>
                                        <select class="form-control selectpicker"  name="role" required="">
                                            <option value="">Select Role</option>
                                            <option <?php if(!empty($users) && $users[0]->role == '0' ){ echo 'selected'; }?> value="0">Project Manager</option>
                                            <?php if($this->session->userdata('role') == 1){ ?>
                                                <option <?php if(!empty($users) && $users[0]->role == '1' ){ echo 'selected'; }?> value="1">Admin</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row"><hr></div>
                            <div class="text-right mb-4 mt-2">
                            <button type="submit" id="save" class="btn btn-wd btn-info btn-fill bg-color has-loader" >
                                <span class="btn-label">
                                    <i class="ti-reload"></i>
                                </span><?php if(!empty($users)){ ?>
                                      Update
                                <?php }else{ ?>
                                     Create
                                <?php }?>
                            </button>
                        </div>
                        </div>
                        <div class="clearfix"></div>
                       </form> 
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
