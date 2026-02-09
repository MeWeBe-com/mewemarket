<nav class="navbar navbar-light navbar-glass navbar-top sticky-kit navbar-expand">
	<button class="btn navbar-toggler-humburger-icon navbar-toggler mr-1 mr-sm-3" type="button" data-toggle="collapse" data-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
	<a class="navbar-brand mr-1 mr-sm-3" href="<?php echo base_url();?>">
		<div class="d-flex align-items-center">
			<img class="mr-2" src="<?php echo base_url();?>assets/img/illustrations/logo.png" alt="" width="120" />
		</div>
	</a>
	<ul class="navbar-nav align-items-center d-none d-lg-block">
		<li class="nav-item">
			<form class="form-inline search-box">
				<input class="form-control rounded-pill search-input" type="search" placeholder="Search..." aria-label="Search" /><span class="position-absolute fas fa-search text-400 search-box-icon"></span>
			</form>
		</li>
	</ul>
	<ul class="navbar-nav navbar-nav-icons ml-auto flex-row align-items-center">
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
					<a class="dropdown-item" href="<?php echo base_url('admin')?>">Admin Panel</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="<?php echo base_url('users/setting/'.$this->session->userdata('user_id'))?>">Settings</a>
					<a class="dropdown-item" href="<?php echo base_url('users/logout')?>">Logout</a>
				</div>
			</div>
		</li>
	</ul>
</nav>
