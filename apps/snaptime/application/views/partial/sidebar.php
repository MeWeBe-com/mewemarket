<div class="sidebar" data-background-color="black">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a class="simple-text" href="<?php echo base_url(); ?>home">
                <img alt="Logo" src="<?php echo base_url(); ?>assets/images/Sd-Logo.png">
            </a>
        </div>
        <ul class="nav">
            <li id="navD" class="">
                <a href="<?php echo base_url(); ?>home">
                    <i class="ti-panel"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <?php if ($this->session->userdata('role') != 'Supplier') { ?>
                <li id="navD" class="">
                    <a href="<?php echo base_url(); ?>supplier">
                        <i class="ti-book"></i>
                        <p>External resource</p>
                    </a>
                </li> <?php } ?>


            <li id="navD" class="">
                <a href="<?php echo base_url(); ?>projects">
                    <i class="ti-harddrives"></i>
                    <p>PROJECTS</p>
                </a>
            </li>


            <li id="navPD" class="">
                <a href="<?php if ($this->session->userdata('role') != 'Supplier') {
                    echo base_url('activity/');
                } else {
                    echo base_url('activity/activities/' . $this->session->userdata('id'));
                } ?>">
                    <i class="ti-time"></i>
                    <p>Activities</p>
                </a>
            </li>

            <!--                   <li id="navPO" class="">-->
            <!--                        <a href="-->
            <?php //if($this->session->userdata('role')=='Supplier'){echo base_url('timesheet/show/'.$this->session->userdata('id').'/'.date('Y-m-d')); }else{ echo base_url('timesheet');}?><!--">-->
            <!--                            <i class="ti-folder"></i>-->
            <!--                            <p>Timesheet</p>-->
            <!--                        </a>-->
            <!--                    </li>-->

            <?php if ($this->session->userdata('role') == 1) { ?>

                <li id="" class="">
                    <a href="<?php echo base_url('invoice/'); ?>">
                        <i class="ti-receipt"></i>
                        <p><?php echo "Invoice Reports"; ?></p>
                    </a>
                </li>

            <?php } ?>

            <!--<li id="navBK" class="">
                        <a href="<?php /*echo base_url('messages');*/ ?>">
                            <i class="ti-pencil"></i>
                            <p>Messages
                            </p>
                        </a>
                    </li>-->

            <?php if ($this->session->userdata('role') == 'Supplier') { ?>

                <li id="navPD" class="">
                    <a href="<?php if ($this->session->userdata('role') == 'Supplier') {
                        echo base_url('activity/show/' . $this->session->userdata('id'));
                    } else {
                        echo base_url('activity');
                    } ?>">
                        <i class="ti-harddrives"></i>
                        <p>ACCESS LOGS</p>
                    </a>
                </li>

            <?php } ?>

            <?php if ($this->session->userdata('role') == '1') { ?>

                <li id="navD" class="">
                    <a href="<?php echo base_url('user'); ?>">
                        <i class="ti-user"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li id="navD" class="">
                    <a href="<?php echo base_url('settings'); ?>">
                        <i class="ti-settings"></i>
                        <p>Settings</p>
                    </a>
                </li>
            <?php } ?>


            <li id="" class="visible-xs visible-sm">
                <a href="<?php echo base_url('dashboard/logout'); ?>">
                    <i class="ti-power-off"></i>
                    <p>Logout</p>
                </a>
            </li>


        </ul>


    </div>
</div>

