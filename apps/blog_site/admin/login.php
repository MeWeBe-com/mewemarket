<?php session_start(); include('../connection/config.php');?>

<?php if(isset($_POST['submit'])){

  $email = $_POST['email'];
  $password = $_POST['password'];

   $sql = "SELECT * FROM admin inner join company on company.company_id = admin.company_id  where admin.name = '".$email."' AND admin.password = '".$password."'";
  $row = mysqlFetchRow($sql);

  $_SESSION['company_id'] = $row['company_id'];
  $_SESSION['company_name'] = $row['company_name'];

  echo '<script type="text/javascript">
           window.location = "index.php"
      </script>';

};?>

<!DOCTYPE html>
<html>
<?php include('head.php')?>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index2.html"><b>Blog Site</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<?php include('footer.php')?>
</body>
</html>
