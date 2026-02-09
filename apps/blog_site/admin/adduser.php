<?php session_start(); include('../connection/config.php');
if(empty($_SESSION)){
  echo '<script type="text/javascript">
           window.location = "login.php";
      </script>';
} ?>
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
            <h1>Articles List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">User</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php if(isset($_POST['btn-action'])){
      $data = $_POST;

      $query = "INSERT INTO `admin`(`company_id`, `name`, `email`, `password`) VALUES ('".$_SESSION['company_id']."','".$data['name']."','".$data['email']."','".$data['password']."')";
      mysqlInsert($query);

      echo '<script type="text/javascript">
           window.location = "categories.php"
      </script>';
    }?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="ew-message-dialog d-none"></div>
        <form name="farticlesadd" class="ew-form ew-add-form ew-horizontal" action="addcategory.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="modal" value="0">
          <div class="ew-add-div">
          <div id="r_title" class="form-group row">
              <label class="col-sm-2 col-form-label ew-label">Username *</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_title">
                <input type="text" name="name"  size="30" maxlength="255" placeholder="Title" value="" class="form-control" required>
                </span>
                </div>
              </div>
          </div>

            <div id="r_title" class="form-group row">
              <label class="col-sm-2 col-form-label ew-label">Email *</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_title">
                <input type="email" name="email"  size="30" maxlength="255" placeholder="Title" value="" class="form-control" required>
                </span>
                </div>
              </div>
            </div>

            <div id="r_title" class="form-group row">
              <label class="col-sm-2 col-form-label ew-label">Password *</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_title">
                <input type="text" name="password"  size="30" maxlength="255" placeholder="Title" value="" class="form-control" required>
                </span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
              <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit">Add</button>
            </div>
          </div>
        </form>
      </div>
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
