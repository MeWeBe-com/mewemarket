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

      $query = "INSERT INTO `sub_category`(`company_id`, `meta_title`, `meta_keyword`, `meta_description`, `category_id`, `sub_category_name`) VALUES ('".$_SESSION['company_id']."','".$data['meta_title']."','".$data['meta_keyword']."','".$data['meta_description']."','".$data['category_id']."','".$data['title']."')";
      mysqlInsert($query);

      echo '<script type="text/javascript">
           window.location = "subcategories.php"
      </script>';

    }?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="ew-message-dialog d-none"></div>
        <form name="farticlesadd" class="ew-form ew-add-form ew-horizontal" action="addsubcategory.php" method="post" enctype="multipart/form-data">
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
