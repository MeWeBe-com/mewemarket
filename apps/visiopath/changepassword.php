<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Forget Password | Finance</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">


 <?php $this->load->view('partial/head')?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="javascript:;"><b>Recover your password</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card"> <div class="col-lg-12 text-center"><img src='<?php echo base_url();?>assets/dist/img/forgot-password.png'></div>
    <div class="card-body login-card-body">
    
      <form action="<?php echo base_url('login/ForgetValidation');?>" method="post">

                <div class="input-group mb-3"> 
                  <input type="text" class="form-control" name='email' required="" placeholder='Enter Email Address'>
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                </div>

              <div class="row">
                <div class="col-6">
                  <a href="<?php echo base_url();?>login" class="btn btn-outline-primary btn-block">Back to Login</a>
                </div>
                <!-- /.col -->
                <div class="col-6 ">
                  <button type="submit" class="btn btn-primary btn-block">Recover Password</button> 
                </div>
                <!-- /.col -->
              </div>

          </form>

            <!-- /.social-auth-links -->

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<?php $this->load->view('partial/footerscript')?>
</body>
</html>
