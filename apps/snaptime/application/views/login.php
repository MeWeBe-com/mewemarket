<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Login | Scruffy Dog</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/classic.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/classic.date.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/paper-dashboard.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/demo.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/custom.css?a" rel="stylesheet"/>

</head>
<body>

<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/" style="max-width: 230px;padding: 0px;margin: 0px;">
                <img class="img-responsive" alt="Logo" src="<?php echo base_url('assets/images/Sd-Logo.png'); ?>">
            </a>
        </div>
    </div>
</nav>
<div class="wrapper wrapper-full-page">
    <div class="full-page login-page" data-color=""
         data-image="<?php echo base_url('assets/img/background/background-2.jpg'); ?>">
        <div class="content">
            <div class="container">

                <div class="row">


                    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">

                        <div class="row col-xs-offset-0 text-center">
                            <h3 class="my-0 mb-0 font-700 text-white rwp"><?php echo $this->uri->segment(2)?></h3>
                        </div>

                        <div class="row card bg-none p-0">
                            <?php
                            if ($this->session->flashdata('message')) {
                                echo '
                                        <div class="alert alert-danger text-white mb-0">
                                            ' . $this->session->flashdata("message") . '
                                        </div>
                                        ';
                            }
                            ?>

                            <?php if (isset($_GET['success'])) { ?>
                                <div class="alert alert-success">
                                    Your password has successfully changed.
                                </div>
                            <?php } ?>
                        </div>

                        <div class="row mb-3 card col-xs-offset-0">
                            <div class=" mb-0 pb-0">
                                <ul id="tabs" class="nav nav-tabs login-tabs" data-tabs="tabs">
                                    <li class="active col-md-6 col-xs-6 p-0">
                                        <a class="btn big-login btn-fill " href="#home" data-toggle="tab">Manager</a>
                                    </li>
                                    <li class=" col-md-6  col-xs-6  p-0">
                                        <a class="btn big-register btn-fill" href="#profile" data-toggle="tab">External Resource</a>
                                    </li>
                                </ul>
                            </div>

                            <div id="my-tab-content" class="tab-content text-left pt-0">
                                <div class="tab-pane active" id="home">
                                    <form action="<?php echo base_url('login/validation'); ?>" id="form" method="post">
                                        <div class=" " data-background="color" data-color="blue">

                                            <div class="w-100">
                                                <hr class="mt-0 mb-0">
                                            </div>
                                            <div class="card-content pb-0">
                                                <div class="form-group">
                                                    <label>Email address <span class="text-ligh">*</span></label>
                                                    <input class="form-control text-box single-line" name="email"
                                                           placeholder="Enter email address" type="email" value=""
                                                           required=""/>
                                                </div>
                                                <div class="form-group">
                                                    <label>Password <span class="text-ligh">*</span></label>
                                                    <input class="form-control text-box single-line" name="password"
                                                           placeholder="Enter password" type="password" required=""/>
                                                </div>
                                                <?php if (!empty($company)) {
                                                    ?>
                                                    <input class="form-control text-box single-line"
                                                           value="<?php echo $company->id ?>" name="company_id"
                                                           placeholder="Company ID" type="hidden"/>
                                                <?php } ?>
                                            </div>
                                            <div class="card-footer text-center">
                                                <button type="submit" class="btn btn-fill btn-wd ">Let's go</button>
                                                <div class="forgot mt-4">
                                                    <a class="text-red text-underline"
                                                       href="<?php echo base_url(); ?>login/ForgetPassword">Forgot your
                                                        password?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="profile">
                                    <form action="<?php echo base_url('supplier_login/validation'); ?>" id="form"
                                          method="post">
                                        <div class=" " data-background="color" data-color="blue">
                                            <div class="w-100">
                                                <hr class="mt-0 mb-0">
                                            </div>
                                            <div class="card-content pb-0">
                                                <div class="form-group">
                                                    <label>Email address <span class="text-ligh">*</span></label>
                                                    <input class="form-control text-box single-line" name="email"
                                                           placeholder="Enter email address" type="email" value=""
                                                           required=""/>
                                                </div>
                                                <div class="form-group">
                                                    <label>Password <span class="text-ligh">*</span></label>
                                                    <input class="form-control text-box single-line" name="password"
                                                           placeholder="Enter password" type="password" required=""/>
                                                </div>
                                                <?php if (!empty($company)) {
                                                    ?>
                                                    <input class="form-control text-box single-line"
                                                           value="<?php echo $company->id ?>" name="company_id"
                                                           placeholder="Company ID" type="hidden"/>
                                                <?php } ?>
                                            </div>
                                            <div class="card-footer text-center">
                                                <button type="submit" class="btn btn-fill btn-wd ">Let's go</button>
                                                <div class="forgot mt-4">
                                                    <a class="text-red text-underline"
                                                       href="<?php echo base_url(); ?>supplier_login/ForgetPassword">Forgot
                                                        your password?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>

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

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/demo.js"></script>
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/paper-dashboard.js"></script>


<script type="text/javascript">

</script>


</body>
</html>


