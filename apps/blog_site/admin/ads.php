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
            <h1>ads</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">ads</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php
    $sql = "SELECT * FROM ads where company_id = '".$_SESSION['company_id']."' ";
    $general = mysqlFetchRow($sql);

    if(isset($_POST['btn-action'])){
      $data = $_POST;


      $query = "UPDATE `ads` SET `column_text`='".$data['column_text']."'WHERE company_id = '".$_SESSION['company_id']."'";
      mysqlInsert($query);

      echo '<script type="text/javascript">
           window.location = "general.php"
      </script>';

    }?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="ew-message-dialog d-none"></div>
        <form name="farticlesadd" class="ew-form ew-add-form ew-horizontal" action="ads.php" method="post" enctype="multipart/form-data">

          <div id="r_description" class="form-group row">
            <label  class="col-sm-2 col-form-label ew-label">Description *</label>
            <div class="col-sm-10"><div>
                <span id="el_articles_description">
               <textarea cols="35" rows="4" class="textarea" placeholder="" required name= "column_text"
                         style="width: 100%; height: 800px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $general['column_text']; ?></textarea>

                </span>
              </div></div>
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
