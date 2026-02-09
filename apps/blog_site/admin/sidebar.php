<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <span class="brand-text font-weight-light"><?php echo $_SESSION['company_name']?></span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item ">
          <a href="index.php" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="<?php echo $base_url;?><?php echo $_SESSION['company_name'];?>/p1" class="nav-link">
            <i class="nav-icon fas fa-eye"></i>
            <p>
              Main Site
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="ads.php" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Ads
              <span class="badge badge-info right"></span>
            </p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="articles.php" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Articles
            </p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="categories.php" class="nav-link">
            <i class="nav-icon fas fa-tree"></i>
            <p>
              Category
            </p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="general.php" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              General
            </p>
          </a>

        </li>
        <li class="nav-item ">
          <a href="subcategories.php" class="nav-link ">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Sub Category
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="users.php" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Users
            </p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="logout.php" class="nav-link">
            <i class="nav-icon far fa-plus-square"></i>
            <p>
              Logout
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
