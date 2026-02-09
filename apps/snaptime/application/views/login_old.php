<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Login | Scruffy Dog</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/css/classic.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/css/classic.date.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/css/paper-dashboard.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/css/demo.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/css/main.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet"/>

</head>
<body>

    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/" style="max-width: 230px;padding: 0px;margin: 0px;">
                    <img class="img-responsive" alt="Logo" src="<?php echo base_url('assets/images/logo.png');?>">
                </a>
            </div>
        </div>
    </nav>
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" data-color="" data-image="<?php echo base_url('assets/img/background/background-2.jpg');?>">
            <div class="content">
                <div class="container">
              
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">

                              <?php 
                if($this->session->flashdata('message'))
                {
                    echo '
                    <div class="alert alert-danger">
                        '.$this->session->flashdata("message").'
                    </div>
                    ';
                }
                ?>

                    <?php if(isset($_GET['success'])){ ?>
                        <div class="alert alert-success">
                           Your password has successfully changed.
                        </div>
                    <?php }?>

                        <form action="<?php echo base_url('login/validation');?>" id="form" method="post">                               
                            <div class="card" data-background="color" data-color="blue">
                                 

                                <div class="card-header row">
                                    <div class="col-md-12  col-sm-6 col-xs-12">
                                    <h4 class="card-title tx_bold6">Login</h4></div>
                                     
                                </div>
                                <div class="w-100"><hr></div>
                                <div class="card-content pb-0">
                                    <div class="form-group">
                                        <label>Email address <span class="text-ligh">*</span></label>
                                        <input class="form-control text-box single-line"  name="email" placeholder="Enter email address" type="email" value="" required="" />
                                    </div>
                                    <div class="form-group">
                                        <label>Password <span class="text-ligh">*</span></label>
                                        <input class="form-control text-box single-line"  name="password" placeholder="Enter password" type="password" required="" />
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-fill btn-wd ">Let's go</button>
                                  <div class="forgot mt-4">
                                       <a href="<?php echo base_url();?>login/ForgetPassword">Forgot your password?</a>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>

            <footer class="footer footer-transparent">
                <div class="container">
                    <div class="copyright">
                        &copy; 2020, Quintessence All rights reserved.
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/demo.js"></script>
<script src="/assets/js/custom.js"></script>
<script src="/Scripts/picker.js"></script>
<script src="/Scripts/picker.date.js"></script>
<script src="/assets/js/paper-dashboard.js"></script>

    <script src="/Scripts/jquery.validate.js"></script>
<script src="/Scripts/jquery.validate.unobtrusive.js"></script>

    <script type="text/javascript">
        $().ready(function () {
            demo.checkFullPageBackgroundImage();

            setTimeout(function () {
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700)
        });
      
    </script>


</body>
</html>


