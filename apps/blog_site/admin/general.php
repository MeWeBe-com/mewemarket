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
            <h1>General</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">General</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php
    $sql = "SELECT * FROM general where company_id = '".$_SESSION['company_id']."' ";
    $general = mysqlFetchRow($sql);

    if(isset($_POST['btn-action'])){
      $data = $_POST;

      if(!empty($_FILES['logo_img']['name'])){

        $file_name   = $_FILES['logo_img']['name'];
        $file_tmp 	 = $_FILES['logo_img']['tmp_name'];

        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed = array('jpg','png','gif','jpeg','bmp','svg','JPEG');

        if(!empty($file_name)){
          move_uploaded_file($file_tmp,"../img/logo/".$file_name);
        }
      }else{
        $file_name = $general['logo'];
      }

      $query = "UPDATE `general` SET `home_summary`='".$data['home_summary']."',`logo`='".$file_name."',`meta_title`='".$data['meta_title']."',`meta_keyword`='".$data['meta_keyword']."',`meta_description`='".$data['meta_description']."',`footer_address`='".$data['footer_address']."',`footer_text`='".$data['footer_text']."',`footer_copyright`='".$data['footer_copyright']."',`color`='".$data['color']."' WHERE company_id = '".$_SESSION['company_id']."'";
      mysqlInsert($query);

      echo '<script type="text/javascript">
           window.location = "general.php"
      </script>';

    }?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="ew-message-dialog d-none"></div>
        <form name="farticlesadd" class="ew-form ew-add-form ew-horizontal" action="general.php" method="post" enctype="multipart/form-data">

          <div class="ew-add-div">
            <div id="r_meta_title" class="form-group row">
              <label id="elh_articles_meta_title" for="x_meta_title" class="col-sm-2 col-form-label ew-label">Meta Title</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_meta_title">
                <textarea name="meta_title" cols="35" rows="4" placeholder="Meta Title" class="form-control"><?php echo $general['meta_title'];?></textarea>
                </span>
                </div></div>
            </div>
            <div id="r_meta_keyword" class="form-group row">
              <label id="elh_articles_meta_keyword" for="x_meta_keyword" class="col-sm-2 col-form-label ew-label">Meta Keyword</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_meta_keyword">
                <textarea  name="meta_keyword"  cols="35" rows="4" placeholder="Meta Keyword" class="form-control"><?php echo $general['meta_keyword'];?></textarea>
                </span>
                </div></div>
            </div>
            <div id="r_meta_description" class="form-group row">
              <label id="elh_articles_meta_description" for="x_meta_description" class="col-sm-2 col-form-label ew-label">Meta Description</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_meta_description">
                <textarea  name="meta_description" cols="35" rows="4" placeholder="Meta Description" class="form-control"><?php echo $general['meta_description'];?></textarea>
                </span>
                </div></div>
            </div>

            <div id="home_summary" class="form-group row">
              <label  class="col-sm-2 col-form-label ew-label">Home Summary</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_meta_description">
                <textarea  name="home_summary" cols="35" rows="4" placeholder="Home Summary" class="form-control"><?php echo $general['home_summary'];?></textarea>
                </span>
                </div></div>
            </div>


            <div id="r_title" class="form-group row">
              <label class="col-sm-2 col-form-label ew-label">Footer Address *</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_title">
                <input type="text" name="footer_address"  size="30" maxlength="255" placeholder="Footer Address"  class="form-control" required value="<?php echo $general['footer_address'];?>">
                </span>
                </div></div>
            </div>

            <div id="r_title" class="form-group row">
              <label class="col-sm-2 col-form-label ew-label">Footer Text</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_title">
                <input type="text" name="footer_text"  size="30" maxlength="255" placeholder="Footer Text" value="<?php echo $general['footer_text'];?>" class="form-control" required>
                </span>
                </div></div>
            </div>

            <div id="r_title" class="form-group row">
              <label class="col-sm-2 col-form-label ew-label">Footer Copyright</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_title">
                <input type="text" name="footer_copyright"  size="30" maxlength="255" placeholder="Footer Copyright" value="<?php echo $general['footer_copyright'];?>" class="form-control" required>
                </span>
                </div>
              </div>
            </div>

            <div id="r_title" class="form-group row">
              <label class="col-sm-2 col-form-label ew-label">Color</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_title">
                <input type="color" name="color"  size="30" maxlength="255" placeholder="Color" value="<?php echo $general['color'];?>" class="form-control" required>
                </span>
                </div>
              </div>
            </div>

            <div id="r_feature_img" class="form-group row">
              <label id="elh_articles_feature_img" class="col-sm-2 col-form-label ew-label">Logo Image *</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_feature_img">
                <div id="fd_x_feature_img">
                <div class="input-group">
                <div class="custom-file">
                <input type="file" class="custom-file-input"  name="logo_img" lang="en">
                <label class="custom-file-label ew-file-label" for="x_feature_img">Choose file</label>
                </div>
                </div>

                </div>
                <table id="ft_x_feature_img" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
                </span>
                </div></div>
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
