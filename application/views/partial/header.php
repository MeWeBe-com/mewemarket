<nav class="navbar navbar-light navbar-glass navbar-top sticky-kit pt-lg-3 pb-lg-3 pt-2 pb-2 navbar-expand">

	<button class="btn navbar-toggler-humburger-icon navbar-toggler mr-1 mr-sm-3" type="button" data-toggle="collapse" data-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
	<a class="navbar-brand mr-1 mr-sm-3" href="<?php echo base_url();?>">
		<div class="d-flex align-items-center">
			<img class="mr-2" src="<?php echo base_url();?>assets/img/illustrations/logo.png" alt="" width="140" />
		</div>
	</a>
	<ul class="navbar-nav align-items-center d-none d-lg-block w-100 pr-3">
		<li class="nav-item">
			<form class="form-inline search-box w-100" method="post" action="<?php echo base_url('search')?>">
				<input class="form-control rounded-pill search-input w-100" type="search" name="keyword" placeholder="Search..." value="<?php if(!empty($keyword)){ echo $keyword; }?>" aria-label="Search" /><span class="position-absolute fas fa-search text-400 search-box-icon"></span>
			</form>
		</li>
	</ul>
	<ul class="navbar-nav navbar-nav-icons ml-auto flex-row align-items-center">
		<li class="nav-item">
			<?php if(empty($this->session->userdata('user_id'))){ ?>
				<a class="nav-link text-300 text-white fs--2" id="navbarDropdownLogin" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<div class="avatar avatar-xl">
						<img class="rounded-circle" src="<?php echo base_url();?>assets/img/team/avatar.png" alt="" />
					</div>
				</a>
			<?php }else{ ?>
		<li class="nav-item dropdown dropdown-on-hover">
			<a class="nav-link pr-0" id="navbarDropdownUser" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<div class="avatar avatar-xl">
					<img class="rounded-circle" src="<?php echo base_url();?>assets/img/team/avatar.png" alt="" />
				</div>
			</a>
			<div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="navbarDropdownUser">
				<div class="bg-white rounded-soft py-2">
					<a class="dropdown-item font-weight-bold text-warning" href="#!">
						<span class="fas fa-crown mr-1"></span>
						<span><?php echo ucfirst($this->session->userdata('user_name')) ;?></span>
					</a>
					<div class="dropdown-divider"></div>
					<div class="dropdown-item"> Theme <div class="custom-control custom-switch d-inline float-right">
							<input class="custom-control-input" id="mode" <?php if($this->input->cookie('theme_mode') == 2){ echo "Checked"; }?> type="checkbox" data-home-url="javascript:;" data-url="javascript:;" />
							<label class="custom-control-label" for="mode"> </label>
						</div>
					</div>

					<div class="dropdown-divider"></div>
					<?php if($this->session->userdata('role') == 1){?>
					<a class="dropdown-item" href="<?php echo base_url('admin')?>">Admin Panel</a>
					<?php }?>
					<?php if($this->session->userdata('role') == 0){?>
						<a class="dropdown-item" href="<?php echo base_url('users/dashboard')?>">Dashboard</a>
					<?php }?>
					<a class="dropdown-item" href="<?php echo base_url('users/setting/'.$this->session->userdata('user_id'))?>">Edit Profile</a>

					<?php if($this->session->userdata('role') == 0){?>
						<a class="dropdown-item" href="<?php echo base_url('users/favourites')?>">Favourites</a>
						<a class="dropdown-item" href="<?php echo base_url('users/purchases')?>">Purchases</a>
					<?php }?>

					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="<?php echo base_url('users/logout')?>">Logout</a>
				</div>
			</div>
		</li>
		<?php }?>
		<div class="dropdown-menu dropdown-menu-right dropdown-menu-card" id="login_modal" aria-labelledby="navbarDropdownLogin">
			<div class="card shadow-none navbar-card-login">
				<div class="card-body fs--1 p-4 font-weight-normal">
					<div class="row text-left justify-content-between align-items-center mb-2">
						<div class="col-auto">
							<h5 class="mb-0">Log in</h5>
						</div>
						<div class="col-auto">
							<p class="fs--1 text-600 mb-0">or <a href="<?php echo base_url('users/register')?>">Create an account</a></p>
						</div>
					</div>
					<form method="POST" action="<?php echo base_url('users/Verify')?>">
						<div class="form-group">
							<input class="form-control" type="email" placeholder="Email address" name="user_email" required/>
							<?php if(isset($_GET['error'])){?>
								<small class="text-danger" >
									<strong>These credentials do not match our records.</strong>
								</small>
							<?php }?>
						</div>
						<div class="form-group">
							<input class="form-control" type="password" placeholder="Password" name="user_password" required/>
						</div>
						<div class="row justify-content-between align-items-center">
							<div class="col-auto">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input" type="checkbox" id="modal-checkbox" name="remember_me"/>
									<label class="custom-control-label" for="modal-checkbox">Remember me</label>
								</div>
							</div>
							<div class="col-auto"><a class="fs--1" href="<?php echo base_url('users/ForgetPassword');?>">Forgot Password?</a></div>
						</div>
						<div class="form-group">
							<button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Log in</button>
						</div>
					</form>
					<div class="w-100 position-relative mt-4">
						<hr class="text-300" />
						<div class="position-absolute absolute-centered t-0 px-3 bg-white text-sans-serif fs--1 text-500 text-nowrap">or log in with</div>
					</div>

					<div class="dropdown-item px-0 col-lg-12">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4 col-4 text-left pt-1" id="LightMode"><span class="far fa-sun"></span> Light Mode</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center">
								<div class="custom-control custom-switch d-inline ">
									<input class="custom-control-input" id="mode" <?php  if($this->input->cookie('theme_mode') == 2 || empty($this->input->cookie('theme_mode'))){ echo "Checked"; }?> type="checkbox" data-home-url="javascript:;" data-url="javascript:;" />
									<label class="custom-control-label" for="mode"> </label>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-4 text-right pt-1" id="darkMode"><span class="far fa-moon"></span> Dark Mode</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		</li>
	</ul>
</nav>



       <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body p-4">
              <div class="row text-left justify-content-between align-items-center mb-2">
                <div class="col-auto">
                  <h5 id="modalLabel">Register</h5>
                </div>
                <div class="col-auto">
                  <p class="fs--1 text-600 mb-0">Have an account? <a href="javascript:;">Login</a></p>
                </div>
              </div>
              <form>
                <div class="form-group">
                  <input class="form-control" type="text" placeholder="Name" />
                </div>
                <div class="form-group">
                  <input class="form-control" type="email" placeholder="Email address" />
                </div>
                <div class="form-row">
                  <div class="form-group col-6">
                    <input class="form-control" type="password" placeholder="Password" />
                  </div>
                  <div class="form-group col-6">
                    <input class="form-control" type="password" placeholder="Confirm Password" />
                  </div>
                </div>
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" id="modal-register-checkbox" />
                  <label class="custom-control-label" for="modal-register-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Register</button>
                </div>
              </form>
              <div class="w-100 position-relative mt-4">
                <hr class="text-300" />
                <div class="position-absolute absolute-centered t-0 px-3 bg-white text-sans-serif fs--1 text-500 text-nowrap">or register with</div>
              </div>
              <div class="form-group mb-0">
                <div class="row no-gutters">
                  <div class="col-sm-6 pr-sm-1"><a class="btn btn-outline-google-plus btn-sm btn-block mt-2" href="#"><span class="fab fa-google-plus-g mr-2" data-fa-transform="grow-8"></span> google</a></div>
                  <div class="col-sm-6 pl-sm-1"><a class="btn btn-outline-facebook btn-sm btn-block mt-2" href="#"><span class="fab fa-facebook-square mr-2" data-fa-transform="grow-8"></span> facebook</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
