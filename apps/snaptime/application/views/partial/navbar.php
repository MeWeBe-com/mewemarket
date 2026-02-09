<nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-fill btn-icon"><i class="ti-more-alt"></i></button>
                    </div>

                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar bar1"></span>
                            <span class="icon-bar bar2"></span>
                            <span class="icon-bar bar3"></span>
                        </button>
                        <a class="navbar-brand js_quotation_title" href="#"></a>
                    </div>
                    <div class="collapse navbar-collapse pl-0">
                    <?php if($this->session->userdata('clockin')){
                        ?>
                    <ul class="nav navbar-nav navbar-left">
                            <li class="">
                                <a class="dropdown-toggle user-name pl-0" href="<?php echo base_url($this->session->userdata('table').'/view/'.$this->session->userdata('project_id')); ?>" >

                                    <span class="bg-color label" style="
                                        letter-spacing: 2px;
                                        border-radius: 1px;
                                        font-size: 10px;
                                        vertical-align: bottom;text-transform: capitalize;
                                    ">Logged in <?php echo $this->session->userdata('project_name');?></span>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-toggle user-role" data-toggle="dropdown" aria-expanded="false">
                                    <i class="ti-alarm-clock"></i><p>&nbsp; <?php echo $this->session->userdata('clockin');?></p>
                                </a>
                            </li>
                            
                        </ul>
                    <?php } ?>
                    
                        <ul class="nav navbar-nav navbar-right">

<!--                            <li class="dropdown open">-->
<!--                                <a href="#notifications" class="dropdown-toggle btn-rotate" data-toggle="dropdown" aria-expanded="true">-->
<!--                                    <i class="ti-bell"></i>-->
<!--                                    <span class="notification">0</span>-->
<!--                                    <p class="hidden-md hidden-lg">-->
<!--                                        Notifications-->
<!--                                        <b class="caret"></b>-->
<!--                                    </p>-->
<!--                                </a>-->
<!--                                <ul class="dropdown-menu" id="noti_menu">-->
<!---->
<!--                                </ul>-->
<!--                            </li>-->

                            <li class="">
                                <a class="dropdown-toggle user-name" data-toggle="dropdown" aria-expanded="false">

                                    <span class="bg-color label" style="
                                        letter-spacing: 2px;
                                        border-radius: 1px;
                                        font-size: 10px;
                                        vertical-align: bottom;
                                        cursor: initial;text-transform: capitalize;
                                    "><?php if($this->session->userdata('role') == 1){ echo 'Admin'; }elseif($this->session->userdata('role') == "Supplier"){echo "Supplier";}else{ echo "Manager" ;} ?></span>
                                </a>
                            </li>

                              <?php if($this->session->userdata('role') != 'Supplier'){ ?>

                            <li>
                                <a href="<?php echo base_url('user/CreateNewUser/'.$this->session->userdata('id'));?>" class="dropdown-toggle user-role text-capti">
                                    <i class="ti-user"></i><p>&nbsp; <?php echo $this->session->userdata('username');?></p>
                                </a>
                            </li>

                             <?php }?>

                               <?php if($this->session->userdata('role') == 'Supplier'){ ?>

                            <li>
                                <a href="<?php echo base_url('supplier/edit/'.$this->session->userdata('id'));?>" class="dropdown-toggle user-role text-capti">
                                    <i class="ti-user"></i><p>&nbsp; <?php echo $this->session->userdata('username');?></p>
                                </a>
                            </li>

                             <?php }?>

                            <li class="visible-lg">
                                <a class="dropdown-toggle " onmouseover="this.style.color='#de2138'" onmouseout="this.style.color='#9A9A9A'" href="<?php echo base_url('dashboard/logout')?>">
                                    <i class="ti-power-off"></i><p>&nbsp; Logout</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
