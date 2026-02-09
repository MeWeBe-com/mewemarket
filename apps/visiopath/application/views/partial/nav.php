<?php 
	if($this->session->userdata('roleId') == 1 && $this->session->userdata('user_type') == 1){
		$user = "DE";
		$link = "admin";
	}elseif($this->session->userdata('roleId') == 1){
		$user = "Admin";
		$link = "admin";
	}elseif($this->session->userdata('roleId') == 2){
		$user = "Doctor";
		$link = "doctor";
	}else{
		$user = "Institute";
		$link = "hospital";
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
	                    <a class="navbar-brand" href="<?php echo base_url(); echo $link?>">
							<?php echo ucfirst($user)?> Panel 
						</a>
	                </div>
	                <div class="collapse navbar-collapse">
				
						<form action="<?php echo base_url();?>doctor/SearchUser" class="navbar-form navbar-left navbar-search-form" role="search" method="get">
	    					<div class="input-group">
	    						<span class="input-group-addon"><i class="fa fa-search"></i></span>
	    						<input type="text" class="form-control" name="query" placeholder="Search..." value="<?php echo $_GET['query']?>">
	    					</div>
	    				</form>
				
	                    <ul class="nav navbar-nav navbar-right">
	                        <li>
	                            <a href="#stats" class="dropdown-toggle btn-magnify" data-toggle="dropdown">
	                                <i class="ti-user"></i>
									<p>Welcome  <?php  
                                $words = strlen($this->session->userdata('username'));

                                if($words > 25){
                                    echo substr_replace($this->session->userdata('username'), "...", 20);
                                }else{
                                    echo $this->session->userdata('username');
                                }?>

								</p>
	                            </a>
	                        </li>

	                       


	                        <li >
	                            <a href="#notifications" class="dropdown-toggle btn-rotate" data-toggle="dropdown">
	                                <i class="ti-time"></i>
	                                <p >
										Last log in 
	                                	

	                                	<?php 

	                                	if ($this->agent->is_mobile()){ 
											       $date = date_create($this->session->userdata('last_login'));
													echo date_format($date,"d-m-Y");
										}else{ 
											$date = date_create($this->session->userdata('last_login'));  
											echo  date_format($date,"d-m-Y H:i:s");
										}

	                                	?>
									</p>
	                            </a>
	                           
	                        </li>
							<li>
	                            <a href="<?php echo base_url();?>logout/<?php echo $this->session->userdata('company_slug');?>" class="">
									<i class="ti-new-window"> </i>  
									<p >
										Logout
									</p>
	                            </a>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </nav>