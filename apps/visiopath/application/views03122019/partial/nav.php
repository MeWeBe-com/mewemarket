<?php 
	if($this->session->userdata('roleId') == 1){
		$user = "admin";
	}elseif($this->session->userdata('roleId') == 2){
		$user = "doctor";
	}else{
		$user = "hospital";
	}
?>

<nav class="navbar navbar-default">
	            <div class="container-fluid">
					<div class="navbar-minimize">
						<button id="minimizeSidebar" class="btn btn-fill btn-icon"><i class="ti-more-alt"></i></button>
					</div>
	                <div class="navbar-header">
	                    <button type="button" class="navbar-toggle">
	                        <span class="sr-only">Toggle navigation</span>
	                        <span class="icon-bar bar1"></span>
	                        <span class="icon-bar bar2"></span>
	                        <span class="icon-bar bar3"></span>
	                    </button>
	                    <a class="navbar-brand" href="<?php echo base_url(); echo $user?>">
							<?php echo ucfirst($user)?> Panel
						</a>
	                </div>
	                <div class="collapse navbar-collapse">

						<form class="navbar-form navbar-left navbar-search-form" role="search">
	    					<div class="input-group">
	    						<span class="input-group-addon"><i class="fa fa-search"></i></span>
	    						<input type="text" value="" class="form-control" placeholder="Search...">
	    					</div>
	    				</form>

	                    <ul class="nav navbar-nav navbar-right">
	                        <li>
	                            <a href="#stats" class="dropdown-toggle btn-magnify" data-toggle="dropdown">
	                                <i class="ti-user"></i>
									<p>Welcome <?php echo $this->session->userdata('username')?></p>
	                            </a>
	                        </li>

	                        <li class="dropdown">
	                            <a href="#notifications" class="dropdown-toggle btn-rotate" data-toggle="dropdown">
	                                <i class="ti-time"></i>
	                                <span class="notification">Last log in  <?php echo ($this->session->userdata('last_login'))?></span>
									<p class="hidden-md hidden-lg">
										
									</p>
	                            </a>
	                           
	                        </li>
							<li>
	                            <a href="<?php echo base_url();?>user/logout" class="">
									<i class="ti-new-window"> </i>  Logout
									<p class="hidden-md hidden-lg">
										
									</p>
	                            </a>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </nav>