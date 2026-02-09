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
            <h1>Articles List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Articles</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php if(isset($_POST['btn-action'])){
      $data = $_POST;


      if(!empty($_FILES['feature_img']['name'])){

        $file_name   = $_FILES['feature_img']['name'];
        $file_tmp 	 = $_FILES['feature_img']['tmp_name'];

        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed = array('jpg','png','gif','jpeg','bmp','svg','JPEG');

          if(!empty($file_name)){
            move_uploaded_file($file_tmp,"../img/articleimg/".$file_name);
          }
      }

      $query = "INSERT INTO `articles`(`company_id`, `meta_title`, `meta_keyword`, `meta_description`, `source`, `category_id`, `sub_category_id`, `title`, `slug`, `short_description`, `description`, `feature_img`, `status`) VALUES ('".$_SESSION['company_id']."','".$data['meta_title']."','".$data['meta_keyword']."','".$data['meta_description']."','".$data['source']."','".$data['category_id']."',NULL,'".$data['title']."',NULL,'".$data['short_description']."','".$data['description']."','".$file_name."','".$data['status']."')";
      mysqlInsert($query);

      echo '<script type="text/javascript">
           window.location = "articles.php"
      </script>';

    }?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="ew-message-dialog d-none"></div>
        <form name="farticlesadd" class="ew-form ew-add-form ew-horizontal" action="addarticle.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="modal" value="0">
          <div class="ew-add-div">
            <div id="r_meta_title" class="form-group row">
              <label id="elh_articles_meta_title" for="x_meta_title" class="col-sm-2 col-form-label ew-label">Meta Title</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_meta_title">
                <textarea name="meta_title" cols="35" rows="4" placeholder="Meta Title" class="form-control"></textarea>
                </span>
                </div></div>
            </div>
            <div id="r_meta_keyword" class="form-group row">
              <label id="elh_articles_meta_keyword" for="x_meta_keyword" class="col-sm-2 col-form-label ew-label">Meta Keyword</label>
              <div class="col-sm-10"><div>
<span id="el_articles_meta_keyword">
<textarea  name="meta_keyword"  cols="35" rows="4" placeholder="Meta Keyword" class="form-control"></textarea>
</span>
                </div></div>
            </div>
            <div id="r_meta_description" class="form-group row">
              <label id="elh_articles_meta_description" for="x_meta_description" class="col-sm-2 col-form-label ew-label">Meta Description</label>
              <div class="col-sm-10"><div>
<span id="el_articles_meta_description">
<textarea  name="meta_description" cols="35" rows="4" placeholder="Meta Description" class="form-control"></textarea>
</span>
                </div></div>
            </div>
            <div id="r_source" class="form-group row">
              <label id="elh_articles_source" for="x_source" class="col-sm-2 col-form-label ew-label">Source</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_source">
                <input type="text"  name="source"  maxlength="65535" placeholder="Source" value="" class="form-control">
                </span>
                </div></div>
            </div>
            <div id="r_category_id" class="form-group row">
              <label id="elh_articles_category_id" for="x_category_id" class="col-sm-2 col-form-label ew-label">Category *</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_category_id">
                <div class="input-group">
                <select class="custom-select ew-custom-select" name="category_id" ">
                  <option value="">Please select</option>
                <?php   $catsql = "Select * From `category` where company_id = '".$_SESSION['company_id']."'";
                $catrows = mysqlFetchRows($catsql);
                foreach($catrows as $cat){ ?>
                  <option value="<?php echo $cat['category_id'];?>"><?php echo $cat['category_name'];?></option>
                  <?php }?>
                </select>
                </div>
                </span>
                </div></div>
            </div>
            <div id="r_title" class="form-group row">
              <label class="col-sm-2 col-form-label ew-label">Title *</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_title">
                <input type="text" name="title"  size="30" maxlength="255" placeholder="Title" value="" class="form-control" required>
                </span>
                </div></div>
            </div>
            <div id="r_short_description" class="form-group row">
              <label id="elh_articles_short_description" for="x_short_description" class="col-sm-2 col-form-label ew-label">Short Description *</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_short_description">
                <textarea  name="short_description" cols="35" rows="4" placeholder="Short Description" class="form-control" required maxlength="200"></textarea>
                </span>
                </div></div>
            </div>
            <div id="r_description" class="form-group row">
              <label  class="col-sm-2 col-form-label ew-label">Description *</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_description">
               <textarea class="textarea" placeholder="Place some text here" required name= "description"
                         style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                </span>
                </div></div>
            </div>
            <div id="r_feature_img" class="form-group row">
              <label id="elh_articles_feature_img" class="col-sm-2 col-form-label ew-label">Feature Image *</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_feature_img">
                <div id="fd_x_feature_img">
                <div class="input-group">
                <div class="custom-file">
                <input type="file" class="custom-file-input"  name="feature_img" lang="en">
                <label class="custom-file-label ew-file-label" for="x_feature_img">Choose file</label>
                </div>
                </div>

                </div>
                <table id="ft_x_feature_img" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
                </span>
                </div></div>
            </div>
            <div id="r_created_at" class="form-group row">
              <label id="elh_articles_created_at" for="x_created_at" class="col-sm-2 col-form-label ew-label">Created At <br> (YYYY/MM/DD) *</label>
              <div class="col-sm-10"><div>
              <span id="el_articles_created_at">
              <div class="input-group date" ><input type="date"  data-format="5" name="created_at"  required maxlength="19" placeholder="Created At  (YYYY/MM/DD)" value="" class="form-control datetimepicker-input" data-target="#datetimepicker_farticlesaddx_created_at"><div class="input-group-append" data-target="#datetimepicker_farticlesaddx_created_at" data-toggle="datetimepicker"><button class="btn btn-default" type="button"><i class="far fa-calendar-alt"></i></button></div></div>
              </span>
                </div></div>
            </div>
            <div id="r_status" class="form-group row">
              <label id="elh_articles_status" for="x_status" class="col-sm-2 col-form-label ew-label">Status</label>
              <div class="col-sm-10"><div>
                <span id="el_articles_status">
                <div class="input-group">
                <select class="custom-select ew-custom-select"  name="status">
                <option value="">Please select</option>
                  <option value="1">Live</option>
                  <option value="0">Pending</option></select>
                </div>
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
