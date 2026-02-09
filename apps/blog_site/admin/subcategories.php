<?php session_start(); include('../connection/config.php');
if(empty($_SESSION)){
  echo '<script type="text/javascript">
           window.location = "login.php";
      </script>';
}?>
<!DOCTYPE html>
<html>
<?php include('head.php')?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include('navbar.php')?>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <?php include('sidebar.php')?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sub Categories List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Sub Categories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                  <a href="addsubcategory.php" class="btn btn-tool btn-sm">
                    <i class="fas fa-plus"></i>
                  </a>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Category Name</th>
                    <th>Sub Category Name</th>
                    <th>Order Id</th>
                    <th>More</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php
                  $catsql = "Select * From `category` where company_id = '".$_SESSION['company_id']."'";
                  $categories = mysqlFetchRows($catsql);

                  $subsql = "Select * From `sub_category` where company_id = '".$_SESSION['company_id']."'";
                  $subcat = mysqlFetchRows($subsql);

                  foreach($subcat as $sub){ ?>
                  <tr>
                    <td>
                      <?php foreach($categories as $cat){
                        if($cat['category_id'] == $sub['category_id']){
                          echo $cat['category_name'];
                        }
                      } ?>
                    </td>
                    <td>
                      <?php
                      echo $sub['sub_category_name'];
                      ?>
                    </td>
                    <td>
                      <?php echo $cat['order_id']; ?>
                    </td>

                    <td>
                      <a href="#" class="text-muted">
                        <i class="fas fa-edit"></i>
                      </a>
                    </td>
                  </tr>

                  <?php }?>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">

    </div>
    <strong>Copyright &copy; 2021 CMS.</strong> All rights reserved.
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include('footer.php')?>
</body>
</html>
