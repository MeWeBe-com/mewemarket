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

      if($function == '0'){
        $function = "";
      }

     
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
					<img class="dashboard-logo" src="<?php echo base_url();?>assets/uploads/<?php echo $this->session->userdata('company_logo');?>">
				</a>
			</div>
	    	<div class="sidebar-wrapper">
				<div class="user">
	                <div class="info">
						<div class="photo">
		                    <img src="<?php echo base_url();?>assets/img/faces/face-2.jpg" />
		                </div>

	                    <a data-toggle="collapse" href="#collapseExample" class="collapsed">
	                        <span class="ellipsis">

                                <?php  
                                $words = strlen($this->session->userdata('username'));

                                if($words > 25){
                                    echo substr_replace($this->session->userdata('username'), "...", 20);
                                }else{
                                    echo $this->session->userdata('username');
                                }?>

								<?php ?>


		                        <b class="caret"></b>
							</span>
	                    </a>
						<div class="clearfix"></div>

	                    <div class="collapse" id="collapseExample">
	                        <ul class="nav">
	                            <li>
									<a href="<?php echo base_url();?>setting/EditProfile/<?php echo $this->session->userdata('id')?>">
										<span class="sidebar-mini"><i class="ti-pencil-alt"></i></span>
										<span class="sidebar-normal">EDIT PROFILE</span>
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

                     



                    <li  <?php if($controller == $user && $function == ''){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                        <a href="<?php echo base_url();?><?php if($this->session->userdata('roleId') == 1){ echo "admin" ;}elseif($this->session->userdata('roleId') == 2){ echo "doctor"; }else{ echo "hospital"; }?>">
                            <i class="ti-dashboard"></i>
							
                            <p>DASHBOARD</p>
                        </a>
                    </li>

                    <?php if($this->session->userdata('roleId') == 1){?>

	                <li id="navReport"  <?php if($controller == 'admin'  && $function == 'ViewAll' || $function == 'addJob' || $function == 'ChooseExistingPatient' || $function == 'AddExistingjob' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
					
                            <a id="navRparent" data-toggle="collapse" href="#navRchilds" class="collapsed" aria-expanded="false">
                                <i class="ti-layout-list-post"></i>
                                <p>
                                    JOBS LIST
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div <?php if($controller == 'admin'  && $function == 'ViewAll' || $function == 'addJob' || $function == 'ChooseExistingPatient' || $function == 'AddExistingjob' ){ ?>  class="collapse in" style="" aria-expanded="true" <?php }else{ ?>  class="collapse" style="height: 0px;" aria-expanded="false" <?php } ?> id="navRchilds"  >
                                <ul class="nav">

                                    <li id="navReportSupplier" <?php if($controller == $user && $function == 'ViewAll'){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();echo $user ;?>/ViewAll">
                                            <span class="sidebar-mini"><i class="ti-layers-alt"></i></span>
                                            <span class="sidebar-normal">VIEW ALL</span>
                                        </a>
                                    </li>  

          
                                <?php if($this->session->userdata('roleId') == 1){?>
                                    <li id="navReportPurchase" <?php if($controller == $user && $function == 'addJob'){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>admin/addJob">
                                            <span class="sidebar-mini"><i class="ti-pencil"></i></span>
                                            <span class="sidebar-normal">ADD NEW JOB</span>
                                        </a>
                                    </li>

                                    <li id="navReportPurchase" <?php if($controller == $user && $function == 'ChooseExistingPatient' || $function == 'AddExistingjob'){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>admin/ChooseExistingPatient">
                                            <span class="sidebar-mini"><i class="ti-pencil-alt"></i></span>
                                            <span class="sidebar-normal">ADD FROM EXISTING</span>
                                        </a>
                                    </li>
                                <?php }?>
                                </ul>
                            </div>
                        </li>

                         <?php }?>

                          <?php if($this->session->userdata('roleId') == 2 || $this->session->userdata('roleId') == 3){?>
                             <li id="navReportPurchase" <?php if($controller == $user && $function == 'ViewAll'){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                            <a href="<?php echo base_url();echo $user ;?>/ViewAll">
                                <span class="sidebar-mini"><i class="ti-layout-list-post"></i></span>
                                <p>JOBS LIST</p>
                            </a>
                        </li>
                          <?php }?>

                         <?php if($this->session->userdata('roleId') == 1){?>

                        <li id="navReportPurchase" <?php if($controller == 'admin' && $function == 'ViewAllReports' || $controller == 'hospital' && $function == 'ViewReport' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                            <a href="<?php echo base_url();?>admin/ViewAllReports">
                                <span class="sidebar-mini"><i class="ti-layers-alt"></i></span>
                                <p>VIEW ALL REPORTS</p>
                            </a>
                        </li>

                    <?php }?>

                    <?php if($this->session->userdata('roleId') == 3 ){ ?>

                        <li id="navReportPurchase" <?php if($controller == 'hospital' && $function == 'HospitalInvoice'){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                            <a href="<?php echo base_url();?>hospital/HospitalInvoice">
                                <span class="sidebar-mini"><i class="ti-file"></i></span>
                                <p>Invoice</p>
                            </a>
                        </li>

                     <?php }?>

                     <?php if($this->session->userdata('roleId') == 2 ){ ?>

                        <li id="navReportPurchase" <?php if($controller == 'doctor' && $function == 'DoctorInvoice'){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                            <a href="<?php echo base_url();?>doctor/DoctorInvoice">
                                <span class="sidebar-mini"><i class="ti-file"></i></span>
                                <p>Invoice</p>
                            </a>
                        </li>

                     <?php }?>

	                <?php if($this->session->userdata('roleId') == 1 ){
						if($this->session->userdata('user_type') != 1){
					?>
					 <li id="navReport" <?php if($controller == 'admin'  && $function == 'hospitalInvoice' || $function == 'doctorInvoice' ){ ?>  class="active" <?php }else{ ?>  class="" <?php } ?>>
                            <a id="navRparent" data-toggle="collapse" href="#invoice" class="collapsed" aria-expanded="false">
                                <i class="ti-credit-card"></i>
                                <p>
                                    Invoice
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div id="invoice" <?php if($controller == 'admin'  && $function == 'hospitalInvoice' || $function == 'doctorInvoice' ){ ?>  class="collapse in" style="" aria-expanded="true" <?php }else{ ?>  class="collapse" style="height: 0px;" aria-expanded="false" <?php } ?> >
                                <ul class="nav">
                                    <?php /*?><li id="navReportSupplier" class="">
                                        <a <?php if($user == 'admin'){?> href="<?php echo base_url()?>invoice" <?php }else{ ?> href="<?php echo base_url()?>doctor/DoctorInvoice" <?php }?>>
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">View Invoice</span>
                                        </a>
                                    </li><?php */?>

                                    <?php if($user == 'admin'){?>

                                   <!--  <li id="navReportSupplier" class="">
                                        <a href="<?php echo base_url()?>admin">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">Sent Invoice</span>
                                        </a>
                                    </li>-->

                                      <li id="navReportSupplier" <?php if($controller == 'admin' && $function == 'hospitalInvoice' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url()?>admin/hospitalInvoice">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">INSTITUTE INVOICES</span>
                                        </a>
                                    </li>

                                      <li id="navReportSupplier" <?php if($controller == 'admin' && $function == 'doctorInvoice' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url()?>admin/doctorInvoice">
                                            <span class="sidebar-mini"><i class="ti-receipt"></i></span>
                                            <span class="sidebar-normal">DOCTOR INVOICES</span>
                                        </a>
                                    </li>
                                <?php }?>
                                </ul>
                            </div>
                        </li>




					<?php }
					 }elseif($this->session->userdata('roleId') == 3){?>

					<li <?php if($controller == 'hospital' && $function == 'ViewMyReport' || $controller == 'hospital' && $function == 'ViewReport'){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
						<a href="<?php echo base_url();?>hospital/ViewMyReport">
							<i class="ti-layers-alt"></i>
							<p>VIEW ALL REPORTS</p>
						</a>
					</li>

					<?php 	}
					
					if($this->session->userdata('roleId') == 2){?>

					<li <?php if($controller == 'doctor' && $function == 'ViewMyReport' || $controller == 'hospital' && $function == 'ViewReport' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
						<a href="<?php echo base_url();?>doctor/ViewMyReport">
							<i class="ti-layers-alt"></i>
							<p>VIEW ALL REPORTS</p>
						</a>
					</li>
					
					<?php }?>

					<?php if($this->session->userdata('roleId') == 20){?>

						<li id="navReport" <?php if($controller == 'uploadreport'  && $function == '' || $function == 'AlreadySysponis' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                            <a id="navRparent" data-toggle="collapse" href="#upload" class="collapsed" aria-expanded="false">
                                <i class="ti-upload"></i>
                                <p>
                                    Upload Report
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="upload" aria-expanded="false" style="height: 0px;">
                                <ul class="nav">
                                    <li id="navReportSupplier" <?php if($controller == 'uploadreport'  && $function == '' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>uploadreport">
                                            <span class="sidebar-mini"><i class="ti-file"></i></span>
                                            <span class="sidebar-normal">Write Synopsis</span>
                                        </a>
                                    </li>

                                     <li id="navReportSupplier" <?php if($controller == 'uploadreport'  &&  $function == 'AlreadySysponis' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>uploadreport/AlreadySysponis">
                                            <span class="sidebar-mini"><i class="ti-file"></i></span>
                                            <span class="sidebar-normal">Synopsis already included</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

					<?php }?>

					<li id="navReport" <?php if($controller == 'messages' && $function == '' || $function == 'AddMessage' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
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
                            <div  <?php if($controller == 'messages' && $function == '' || $function == 'AddMessage' ){ ?>  class="collapse in" style="" aria-expanded="true" <?php }else{ ?>  class="collapse" style="height: 0px;" aria-expanded="false" <?php } ?> id="message" >
                                <ul class="nav">
                                    <li id="navReportSupplier" <?php if($controller == 'messages' && $function == '' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>messages">
                                            <span class="sidebar-mini"><i class="ti-comment-alt"></i></span>
                                            <span class="sidebar-normal">VIEW ALL MESSAGES</span>
                                        </a>
                                    </li>
                                    <li id="navReportPurchase" <?php if($controller == 'messages' && $function == 'AddMessage' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>messages/AddMessage">
                                            <span class="sidebar-mini"><i class="ti-comment"></i></span>
                                            <span class="sidebar-normal">ADD NEW MESSAGES</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <?php if($this->session->userdata('roleId') == 1){
							if($this->session->userdata('user_type') != 1){
						?>

                        <li>
                            <a href="<?php echo base_url();?>admin/companysetting">
                                <i class="ti-settings"></i>
                                <p>Company Settings</p>
                            </a>
                        </li>

                         
                        <li id="navReport" <?php if($controller == $user  &&  $function == 'ShowAllForms' || $function == 'ShowAllAdminUser' || $function == 'ShowAllDoctor' || $function == 'ShowAllHospitals' || $function == 'Logs' || $function == 'SearchUser' || $function == 'showTestType'  || $function == 'EditForm' || $function == 'EditHospital'  ||  $function == 'EditDoctor' || $function == 'AddTestType' || $function == 'editTestType' || $function == "AddDoctor" || $function == 'Addadmin' || $function == 'AddHospital' || $function == 'configuration'){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                            <a id="navRparent" data-toggle="collapse" href="#setting" class="collapsed" aria-expanded="false">
                                <i class="ti-settings"></i>
                                <p>
                                    SETTINGS
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div <?php if($controller == $user  &&  $function == 'ShowAllForms' || $function == 'ShowAllAdminUser' || $function == 'ShowAllDoctor' || $function == 'ShowAllHospitals' || $function == 'Logs' || $function == 'SearchUser' || $function == 'showTestType'  || $function == 'EditForm' || $function == 'EditHospital'  ||  $function == 'EditDoctor' || $function == 'AddTestType' || $function == 'editTestType' || $function == "AddDoctor" || $function == 'Addadmin' || $function == 'AddHospital' || $function == 'configuration'){ ?>  class="collapse in" style="" aria-expanded="true" <?php }else{ ?> class="collapse" style="height:0px" aria-expanded="false" <?php } ?> id="setting" >
                                <ul class="nav"> 
								 	
                                     <li id="navReportSupplier" <?php if($controller == 'admin' && $function == 'ShowAllAdminUser' || $function == "Addadmin"){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>admin/ShowAllAdminUser">
                                            <span class="sidebar-mini"><i class="ti-view-list-alt"></i></span>
                                            <span class="sidebar-normal">MANAGE ADMIN / DE</span>
                                        </a>
                                    </li>

                                     <li id="navReportSupplier" <?php if($controller == 'admin' && $function == 'ShowAllDoctor' || $function == 'EditDoctor' || $function == "AddDoctor" ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>admin/ShowAllDoctor">
                                            <span class="sidebar-mini"><i class="ti-view-list-alt"></i></span>
                                            <span class="sidebar-normal">MANAGE DOCTORS</span>
                                        </a>
                                    </li>

                                     <li id="navReportSupplier" <?php if($controller == 'admin' && $function == 'ShowAllHospitals' || $function == 'EditHospital' || $function == 'AddHospital'  ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>admin/ShowAllHospitals">
                                            <span class="sidebar-mini"><i class="ti-view-list-alt"></i></span>
                                            <span class="sidebar-normal">MANAGE INSTITUTE</span>
                                        </a>
                                    </li>

                                     <li id="navReportSupplier" <?php if($controller == 'admin' && $function == 'ShowAllForms' || $controller == 'formbuild' && $function == 'EditForm' ||  $controller == 'admin' && $function == 'editTestType' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>admin/ShowAllForms">
                                            <span class="sidebar-mini"><i class="ti-view-list-alt"></i></span>
                                            <span class="sidebar-normal">FORM BUILDER</span>
                                        </a>
                                    </li>

                                     <li id="navReportSupplier" <?php if($controller == 'admin' && $function == 'configuration' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>admin/configuration">
                                            <span class="sidebar-mini"><i class="ti-view-list-alt"></i></span>
                                            <span class="sidebar-normal">CONFIGURATION</span>
                                        </a>
                                    </li>
							
                                    <li id="navReportSupplier" <?php if($controller == 'admin' && $function == 'Logs' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>admin/Logs">
                                            <span class="sidebar-mini"><i class="ti-view-list-alt"></i></span>
                                            <span class="sidebar-normal">LOGS</span>
                                        </a>
                                    </li>

                                    <?php /*?><li id="navReportSupplier" <?php if($controller == 'admin' && $function == 'SearchUser' ){ ?> class="active" <?php }else{ ?> class="" <?php } ?>>
                                        <a href="<?php echo base_url();?>admin/SearchUser">
                                            <span class="sidebar-mini"><i class="ti-view-list-alt"></i></span>
                                            <span class="sidebar-normal">MANAGE USERS</span>
                                        </a>
                                    </li><?php */?>

                                    
                               
                                </ul>
                            </div>
                        </li>

                    <?php }}?>
					
	               
					
					
					
	            </ul>
	    	</div>
	    </div>