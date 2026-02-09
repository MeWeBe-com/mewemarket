<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <title>Users | Scruffy Dog</title>
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
    <div class="container-fluid table-responsive">
        <div class="row">
            <div class="card">
                <div class="card-header project-filter-row">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="card-title tx_bold6">User list</h4>
                        </div>
                        <div class="col-md-8">
                            <div class="text-right supplier-action-box">
                                    <a class="btn btn-info btn-fill btn-wd bg-color" href="<?php echo base_url('user/CreateNewUser');?>">  Create  User</a>
<!-- <input class="form-control" id="search" name="search" placeholder="search" type="text"> -->                            </div>
                        </div>
                        <div class="w-100 over_hidden"><hr></div>
                    </div>
                     
                    
                </div>
                <div class="card-content pt-0">

                    <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%" id="datatables">
                        <thead>
                            <tr>

                                 <th>Action</th>
                              <!--   <th>Date&nbsp;</th> -->
                               
                                <th>Name</th> 
                                <th>Email</th>
                                <th>Phone</th>
                                
                                <th>Role</th>
                                <th>Status</th>
                               
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            foreach($users as $user){

                            ?>
                            <tr id="Deleted-<?php echo $user->user_id;?>">
                                <td>
                                    <a title="Edit" href="<?php echo base_url('user/CreateNewUser/'.$user->user_id);?>" class="linkColor text-red" style="margin-right:3px;">
                                        <span class="ti-pencil-alt"></span>
                                    </a>
                                    <a title="Delete" class="text-red" href="<?php echo base_url('user/delete/'.$user->user_id);?>" onclick="return confirm('Are you sure?')" class="customhover"><span class="ti-trash"></span></a>
                                </td>

                               <!--  <td><?php $date = date_create($user->created_at); echo date_format($date,'d/m/Y'); ?></td> -->
                                <td><?php echo $user->name; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td><?php echo $user->phone; ?></td>
                                <td><?php if($user->role == 1){ echo "Admin"; }else{ echo "Project Manager"; }  ?></td>
                                <td><?php if($user->status == 0){ echo "Active"; }else{ echo "Inactive"; }  ?></td>
                                
                              
                                    
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
