<nav class="navbar navbar-vertical navbar-expand-xl navbar-light">
	<div class="d-flex align-items-center">
		<div class="toggle-icon-wrapper">
			<button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-toggle="tooltip" data-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
		</div>
		<a class="navbar-brand" href="<?php echo base_url('')?>">
			<div class="d-flex align-items-center py-3">
				<img class="mr-2" src="<?php echo base_url();?>assets/img/illustrations/logo.png" alt="" width="140" />
			</div>
		</a>
	</div>
	<div class="collapse navbar-collapse perfect-scrollbar scrollbar" id="navbarVerticalCollapse">
		<ul class="navbar-nav flex-column">
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url()?>" >
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-chart-pie"></span>
						</span>
						<span class="nav-link-text">Home</span>
					</div>
				</a>

			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url('about'); ?>">
					<div class="d-flex align-items-center"><span class="nav-link-icon">
							<span class="fas fa-book "></span></span><span class="nav-link-text"> About</span>
					</div>
				</a>
			</li>

			<!--<li class="nav-item">
				<a class="nav-link" href="<?php /*echo base_url('pricing')*/?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon"><span class="fas fa-dollar-sign"></span></span>
						<span class="nav-link-text"> Pricing</span>
					</div>
				</a>
			</li>-->
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url('pricing'); ?>">
					<div class="d-flex align-items-center"><span class="nav-link-icon">
							<span class="fas fa-poll"></span></span><span class="nav-link-text"> Pricing</span>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url('users/Support'); ?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fab fa-trello"></span>
						</span>
						<span class="nav-link-text"> Support</span>
					</div>
				</a>
			</li>
		</ul>
		<ul class="navbar-nav flex-column">
			<div class="navbar-vertical-divider">
				<hr class="navbar-vertical-hr my-2" />
			</div>
			<li class="nav-item">
					<div class="d-flex align-items-center">
						<span class="nav-link-text"> Categories</span>
					</div>

			</li>
			<div class="navbar-vertical-divider">
				<hr class="navbar-vertical-hr my-2" />
			</div>
			<!--<li class="nav-item">
				<a class="nav-link" href="<?php /*echo base_url('category/ViewCategory/1');*/?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-lock-open"></span>
						</span>
						<span class="nav-link-text"> Open Source</span>
					</div>
				</a>
			</li>-->
			<li class="nav-item">
				<?php $slug = url_title('Business', 'dash', true);?>
				<a class="nav-link" href="<?php echo base_url('category/ViewCategory/2/'.$slug);?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-briefcase"></span>
						</span>
						<span class="nav-link-text"> Business</span>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<?php $slug = url_title('Application', 'dash', true);?>
				<a class="nav-link" href="<?php echo base_url('category/ViewCategory/3/'.$slug);?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-mobile-alt"></span>
						</span>
						<span class="nav-link-text"> Application</span>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<?php $slug = url_title('Customer Service', 'dash', true);?>
				<a class="nav-link" href="<?php echo base_url('category/ViewCategory/4/'.$slug);?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-poll"></span>
						</span>
						<span class="nav-link-text"> Customer Service</span>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<?php $slug = url_title('Education', 'dash', true);?>
				<a class="nav-link" href="<?php echo base_url('category/ViewCategory/5/'.$slug);?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-university"></span>
						</span>
						<span class="nav-link-text"> Education</span>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<?php $slug = url_title('Finance', 'dash', true);?>
				<a class="nav-link" href="<?php echo base_url('category/ViewCategory/6/'.$slug);?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-chart-line"></span>
						</span>
						<span class="nav-link-text"> Finance</span>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<?php $slug = url_title('Legal', 'dash', true);?>
				<a class="nav-link" href="<?php echo base_url('category/ViewCategory/7/'.$slug);?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-balance-scale-left"></span>
						</span>
						<span class="nav-link-text"> Legal </span>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<?php $slug = url_title('Logistics', 'dash', true);?>
				<a class="nav-link" href="<?php echo base_url('category/ViewCategory/8/'.$slug);?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-trailer"></span>
						</span>
						<span class="nav-link-text"> Logistics </span>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<?php $slug = url_title('Marketing', 'dash', true);?>
				<a class="nav-link" href="<?php echo base_url('category/ViewCategory/9/'.$slug);?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-bullhorn"></span>
						</span>
						<span class="nav-link-text"> Marketing </span>
					</div>
				</a>
			</li>

	</div>
</nav>
