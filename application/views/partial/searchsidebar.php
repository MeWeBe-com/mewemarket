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
				<a class="nav-link" href="<?php echo base_url('about')?>">
					<div class="d-flex align-items-center"><span class="nav-link-icon">
							<span class="fas fa-book "></span></span><span class="nav-link-text"> About</span>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url('pricing')?>">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon"><span class="fas fa-dollar-sign"></span></span>
						<span class="nav-link-text"> pricing</span>
					</div>
				</a>
			</li>


			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url('category')?>">
					<div class="d-flex align-items-center"><span class="nav-link-icon">
							<span class="fas fa-poll"></span></span><span class="nav-link-text"> Categories</span>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="javascript:;">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fab fa-trello"></span>
						</span>
						<span class="nav-link-text"> Support</span>
					</div>
				</a>
			</li>
		</ul>
		<form method="POST" action="<?php echo base_url('search/SearchFilter');?>">
			<input type="hidden" value="<?php if(!empty($keyword)){ echo $keyword; }?>" name="keyword">
			<ul class="navbar-nav flex-column">
				<div class="navbar-vertical-divider">
					<hr class="navbar-vertical-hr my-2" />
				</div>
				<li class="nav-item"><a class="nav-link" href="javascript:;">
						<div class="d-flex align-items-center">
							<span class="nav-link-text"> Categories</span>
						</div>
					</a>
				</li>
				<div class="navbar-vertical-divider">
					<hr class="navbar-vertical-hr my-2" />
				</div>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('category/ViewCategory/1');?>">
						<div class="d-flex align-items-center">
							<span class="nav-link-icon">
								<span class="fas fa-lock-open"></span>
							</span>
							<span class="nav-link-text"> Open Source</span>
						</div>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('category/ViewCategory/2');?>">
						<div class="d-flex align-items-center">
							<span class="nav-link-icon">
								<span class="fas fa-briefcase"></span>
							</span>
							<span class="nav-link-text"> Business</span>
						</div>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('category/ViewCategory/3');?>">
						<div class="d-flex align-items-center">
							<span class="nav-link-icon">
								<span class="fas fa-mobile-alt"></span>
							</span>
							<span class="nav-link-text"> Application</span>
						</div>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('category/ViewCategory/4');?>">
						<div class="d-flex align-items-center">
							<span class="nav-link-icon">
								<span class="fas fa-poll"></span>
							</span>
							<span class="nav-link-text"> Customer Service</span>
						</div>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('category/ViewCategory/5');?>">
						<div class="d-flex align-items-center">
							<span class="nav-link-icon">
								<span class="fas fa-university"></span>
							</span>
							<span class="nav-link-text"> Education</span>
						</div>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('category/ViewCategory/6');?>">
						<div class="d-flex align-items-center">
							<span class="nav-link-icon">
								<span class="fas fa-chart-line"></span>
							</span>
							<span class="nav-link-text"> Finance</span>
						</div>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('category/ViewCategory/7');?>">
						<div class="d-flex align-items-center">
							<span class="nav-link-icon">
								<span class="fas fa-balance-scale-left"></span>
							</span>
							<span class="nav-link-text"> Legal </span>
						</div>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('category/ViewCategory/8');?>">
						<div class="d-flex align-items-center">
							<span class="nav-link-icon">
								<span class="fas fa-trailer"></span>
							</span>
							<span class="nav-link-text"> Logistics </span>
						</div>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('category/ViewCategory/9');?>">
						<div class="d-flex align-items-center">
							<span class="nav-link-icon">
								<span class="fas fa-bullhorn"></span>
							</span>
							<span class="nav-link-text"> Marketing </span>
						</div>
					</a>
				</li>
			</ul>

			<div class="navbar-vertical-divider">
					<hr class="navbar-vertical-hr my-2" />
				</div>
				<a class="nav-link text-secondary font-weight-semi-bold pl-0" href="javascript:;">
					<div class="d-flex align-items-center">
						<span class="nav-link-text "> Price</span>
					</div>
				</a>
				
				<div class="navbar-vertical-divider">
					<hr class="navbar-vertical-hr my-2" />
				</div>

				<div class="input-group mb-3">
	  				<div class="input-group-prepend">
	  					<span class="input-group-text">$</span>
	  				</div>
	  				<input class="form-control" type="text" name="price_min" >
				</div>

				<div class="input-group mb-3">
	  				<div class="input-group-prepend">
																  																	 
	  					<span class="input-group-text">$</span>
	  				</div>
	  				<input class="form-control" type="text" name="price_max">
				</div>

				<button type="submit" class="btn btn-sm btn-primary d-lg-block mt-2 w-100 mb-4" href="javascript:;">
					Update
				</button>
		</form>

	</div>
</nav>
