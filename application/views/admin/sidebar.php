<nav class="navbar navbar-vertical navbar-expand-xl navbar-light">
	<div class="d-flex align-items-center">
		<div class="toggle-icon-wrapper">
			<button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-toggle="tooltip" data-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
		</div>
		<a class="navbar-brand" href="<?php echo base_url();?>">
			<div class="d-flex align-items-center py-3">
				<img class="mr-2" src="<?php echo base_url();?>assets/img/illustrations/logo.png" alt="" width="140" />

			</div>
		</a>
	</div>
	<div class="collapse navbar-collapse perfect-scrollbar scrollbar" id="navbarVerticalCollapse">
		<ul class="navbar-nav flex-column">

			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url();?>admin" >
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-chart-pie"></span>
						</span>
						<span class="nav-link-text">Home</span>
					</div>
				</a>
			</li>

			<li class="nav-item"><a class="nav-link dropdown-indicator" href="#categories" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="pages">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-copy"></span>
						</span>
						<span class="nav-link-text">Categories</span>
					</div>
				</a>
				<ul class="nav collapse" id="categories" data-parent="#navbarVerticalCollapse">
					<li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/manage_category')?>">Manage Categories</a>
					</li>
					<li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/create_category')?>">Create Category</a>
					</li>
				</ul>
			</li>

			<li class="nav-item"><a class="nav-link dropdown-indicator" href="#pages" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="pages">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="far fa-list-alt"></span>
						</span>
						<span class="nav-link-text">Packages</span>
					</div>
				</a>
				<ul class="nav collapse" id="pages" data-parent="#navbarVerticalCollapse">
					<li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/manage_package')?>">Manage Package</a>
					</li>
					<li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/create_package')?>">Create Package</a>
					</li>
				</ul>
			</li>

			<li class="nav-item"><a class="nav-link dropdown-indicator" href="#products" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="pages">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-boxes"></span>
						</span>
						<span class="nav-link-text">Products</span>
					</div>
				</a>
				<ul class="nav collapse" id="products" data-parent="#navbarVerticalCollapse">
					<li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/manage_product')?>">Manage Products</a>
					</li>
					<li class="nav-item"><a class="nav-link" href="<?php echo base_url('admin/create_product')?>">Create Products</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#users" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="pages">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-users"></span>
						</span>
						<span class="nav-link-text">Users</span>
					</div>
				</a>
				<ul class="nav collapse" id="users" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('admin/manage_users')?>">
							Manage Users
						</a>
					</li>
					<!--<li class="nav-item"><a class="nav-link" href="<?php /*echo base_url('admin/create_product')*/?>">Create Products</a>
					</li>-->
				</ul>
			</li>

			<li class="nav-item">
				<a class="nav-link dropdown-indicator" href="#subscribe" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="pages">
					<div class="d-flex align-items-center">
						<span class="nav-link-icon">
							<span class="fas fa-file-invoice"></span>
						</span>
						<span class="nav-link-text">Subscription</span>
					</div>
				</a>
				<ul class="nav collapse" id="subscribe" data-parent="#navbarVerticalCollapse">
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('admin/manage_subscription')?>">
							Manage Subscription
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>
