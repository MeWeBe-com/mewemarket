<?php 
	if($this->session->userdata('roleId') == 1){
		$user = "admin";
	}elseif($this->session->userdata('roleId') == 2){
		$user = "doctor";
	}elseif($this->session->userdata('roleId') == 3){
		$user = "hospital";
	}else{
		$user = "";
	}
?>

<?php $controller = $this->uri->segment(1,0);
      $function = $this->uri->segment(2,0);

            ?>

 <div class="sidebar" data-background-color="white" data-active-color="danger">
	    <!--
			Tip 1: you can change the color of the sidebar's background using: data-background-color="white | brown"
			Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
		-->
			<div class="logo">
				<a href="<?php echo base_url(); echo $user?>" class="simple-text logo-mini">
					VP
				</a>

				<a href="<?php echo base_url(); echo $user?>" class="simple-text logo-normal">
					<img class="dashboard-logo" src="<?php echo base_url();?>assets/img/logo.png">
				</a>
			</div>
	    	<div class="sidebar-wrapper">
				<div class="user">
	                <div class="info">
						<div class="photo">
		                    <img src="<?php echo base_url();?>assets/img/faces/face-2.jpg" />
		                </div>

	                    <a data-toggle="collapse" href="#collapseExample" class="collapsed">
	                        <span>
								<?php echo $this->session->userdata('username')?>
		                        <b class="caret"></b>
							</span>
	                    </a>
						<div class="clearfix"></div>

	                    <div class="collapse" id="collapseExample">
	                        <ul class="nav">
	                            <li>
									<a href="<?php echo base_url();?>setting/EditProfile/<?php echo $this->session->userdata('id')?>">
										<span class="sidebar-mini">Ep</span>
										<span class="sidebar-normal">Edit Profile</span>
									</a>
								</li>

								
	                        </ul>
	                    </div>
	                </div>
	            </div>
	            <ul class="nav">
	                <!--<li class="active">
	                    <a href="<?php echo base_url();?><?php if($this->session->userdata('roleId') == 1){ echo "admin" ;}elseif($this->session->userdata('roleId') == 2){ echo "doctor"; }else{ echo "hospital"; }?>">
	                        <i class="ti-panel"></i>
	                        <p>Dashboard</p>
	                    </a>
	                </li>-->

                    <li >
                        <a href="<?php echo base_url();?><?php if($this->session->userdata('roleId') == 1){ echo "admin" ;}elseif($this->session->userdata('roleId') == 2){ echo "doctor"; }else{ echo "hospital"; }?>">
                            <i class="ti-files"></i>
                            <p>DASHBOARD</p>
                        </a>
                    </li>

	                <li id="navReport"  class="">
                            <a id="navRparent" data-toggle="collapse" href="#navRchilds" class="collapsed" aria-expanded="false">
                                <i class="ti-files"></i>
                                <p>
                                    JOBS LIST
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="navRchilds" aria-expanded="false" style="height: 0px;">
                                <ul class="nav">

                                    <?php if($this->session->userdata('roleId') == 1){ ?>

                                    <li id="navReportSupplier" <?php if($controller == $user && $function == 'ViewAll'){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();echo $user ;?>/ViewAll">
                                            <span class="sidebar-mini"><i class="ti-file"></i></span>
                                            <span class="sidebar-normal">VIEW ALL</span>
                                        </a>
                                    </li>  

                                      <?php }else{?>

                                         <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url();echo $user ;?>">
                                            <span class="sidebar-mini"><i class="ti-file"></i></span>
                                            <span class="sidebar-normal">VIEW ALL</span>
                                        </a>
                                    </li>  

                                      <?php }?>

                                <?php if($this->session->userdata('roleId') == 1){?>
                                    <li id="navReportPurchase" class="">
                                        <a href="<?php echo base_url();?>admin/addJob">
                                            <span class="sidebar-mini"><i class="ti-file"></i></span>
                                            <span class="sidebar-normal">ADD NEW JOB</span>
                                        </a>
                                    </li>

                                    <li id="navReportPurchase" class="">
                                        <a href="<?php echo base_url();?>admin/ChooseExistingPatient">
                                            <span class="sidebar-mini"><i class="ti-file"></i></span>
                                            <span class="sidebar-normal">EDIT EXISTING JOB</span>
                                        </a>
                                    </li>
                                <?php }?>
                                </ul>
                            </div>
                        </li>

                         <?php if($this->session->userdata('roleId') == 1){?>

                        <li id="navReportPurchase" class="">
                            <a href="<?php echo base_url();?>admin/ViewAllReports">
                                <span class="sidebar-mini"><i class="ti-file"></i></span>
                                <p>VIEW ALL REPORTS</p>
                            </a>
                        </li>

                    <?php }?>

	                <?php if($this->session->userdata('roleId') != 3){?>
					 <li id="navReport" class="">
                            <a id="navRparent" data-toggle="collapse" href="#invoice" class="collapsed" aria-expanded="false">
                                <i class="ti-receipt"></i>
                                <p>
                                    Invoice
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="invoice" aria-expanded="false" style="height: 0px;">
                                <ul class="nav">
                                    <li id="navReportSupplier" class="">
                                        <a <?php if($user == 'admin'){?> href="<?php echo base_url()?>invoice" <?php }else{ ?> href="<?php echo base_url()?>doctor/DoctorInvoice" <?php }?>>
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">View Invoice</span>
                                        </a>
                                    </li>

                                    <?php if($user == 'admin'){?>

                                   <!--  <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url()?>admin">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">Sent Invoice</span>
                                        </a>
                                    </li>-->

                                      <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url()?>admin">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">INSTITUTE INVOICES</span>
                                        </a>
                                    </li>

                                      <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url()?>admin">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">DOCTOR INVOICES</span>
                                        </a>
                                    </li>
                                <?php }?>
                                </ul>
                            </div>
                        </li>




					<?php }else{?>

					<li>
						<a href="<?php echo base_url();?>hospital/ViewMyReport">
							<i class="ti-package"></i>
							<p>View Reports</p>
						</a>
					</li>

					<?php 	}?>

					<?php if($this->session->userdata('roleId') == 2){?>

						<li id="navReport" class="">
                            <a id="navRparent" data-toggle="collapse" href="#upload" class="collapsed" aria-expanded="false">
                                <i class="ti-pencil"></i>
                                <p>
                                    Upload Report
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="upload" aria-expanded="false" style="height: 0px;">
                                <ul class="nav">
                                    <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url();?>uploadreport">
                                            <span class="sidebar-mini"><i class="ti-file"></i></span>
                                            <span class="sidebar-normal">Write Synopsis</span>
                                        </a>
                                    </li>

                                     <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url();?>uploadreport/AlreadySysponis">
                                            <span class="sidebar-mini"><i class="ti-file"></i></span>
                                            <span class="sidebar-normal">Synopsis already included</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

					<?php }?>

					<li id="navReport" class="">
                            <a id="navRparent" data-toggle="collapse" href="#message" class="collapsed" aria-expanded="false">
                                <i class="ti-comments"></i>
                                <p>
                                    Messages

                                    <?php //$this->load->model('messages_model');
                                        $unread =  $this->message_model->GetUnreadMessages($this->session->userdata('id'));

                                        echo "(".$unread[0]->unread.")";

                                        ?>
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="message" aria-expanded="false" style="height: 0px;">
                                <ul class="nav">
                                    <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url();?>messages">
                                            <span class="sidebar-mini"><i class="ti-comment-alt"></i></span>
                                            <span class="sidebar-normal">View All Message</span>
                                        </a>
                                    </li>
                                    <li id="navReportPurchase" class="">
                                        <a href="<?php echo base_url();?>messages/AddMessage">
                                            <span class="sidebar-mini"><i class="ti-comment"></i></span>
                                            <span class="sidebar-normal">Add New Message</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <?php if($this->session->userdata('roleId') == 1){?>

                       

                        <li id="navReport" class="">
                            <a id="navRparent" data-toggle="collapse" href="#setting" class="collapsed" aria-expanded="false">
                                <i class="ti-receipt"></i>
                                <p>
                                    SETTINGS
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="setting" aria-expanded="false" style="height: 0px;">
                                <ul class="nav"> 

                                    <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url();?>admin/ShowAllAdminUser">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">MANAGE ADMIN USERS</span>
                                        </a>
                                    </li>

                                    <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url();?>admin/ShowAllDoctor">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">MANAGE DOCTORS</span>
                                        </a>
                                    </li>

                                   

                                     <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url();?>admin/ShowAllHospitals">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">MANAGE INSTITUTE</span>
                                        </a>
                                    </li>

                                    <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url();?>admin/Logs">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">LOGS</span>
                                        </a>
                                    </li>

                                    <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url();?>admin/SearchUser">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">USER PASSWORDS</span>
                                        </a>
                                    </li>

                                     <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url();?>admin">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">FORM BUILDER</span>
                                        </a>
                                    </li>
                               
                                </ul>
                            </div>
                        </li>

                    <?php }?>
					
	               
					
					
					
	            </ul>
	    	</div>
	    </div>