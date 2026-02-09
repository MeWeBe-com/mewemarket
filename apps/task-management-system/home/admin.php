<?php
session_start();

if(!$_SESSION['admin'] || $_SESSION['admin'] != $_SESSION['user'])
{
    //echo $_SESSION['anything'];
    header('location:../auth/login');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>I&C Dashboard</title>

  <!-- Bootstrap -->
  <!-- <link rel="stylesheet" type="text/css" href="libs/css/jquery.dataTables.min.css"> -->
  <link href="libs/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="libs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="libs/css/added_styles.css">
  <link rel="shortcut icon" href="libs/img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="libs/img/favicon.ico" type="image/x-icon">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="libs/css/custom.css"> -->


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body>

<div class="navbar-wrapper">
    <div class="container-fluid">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">I&C<sup>β</sup></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#" id="home" class="replacediv">Home</a></li>
                        <li class=" dropdown">
                            <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Departments <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class=" dropdown">
                                    <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">View Departments</a>
                                </li>
                                <li><a href="#">Add New</a></li>
                            </ul>
                        </li>
                        <!-- <li><a href="#">Add New</a></li> -->

                        <li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tasks <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="replacediv" href="#">Add A New Task Category</a></li>
                                <li><a class="replacediv" href="#">Add A New Task</a></li>
                                <li><a class="replacediv" href="#">Assign Task</a></li>
                                <li><a class="replacediv" href="#">Un-assigned Tasks</a></li>
                                <li><a class="replacediv" href="#">Manage Tasks</a></li>
                            </ul>
                        </li>

                        <li class=" dropdown"><a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Managers <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="replacediv" href="#">Add New Manager</a></li>
                                <li><a href="#">Add New</a></li>
                            </ul>
                        </li>

                        <li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Artisans <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="replacediv" href="#">Add New Artisan</a></li>
                                <li><a class="replacediv" href="#">Artisan Stats</a></li>
                                <li><a href="#">Bulk Upload</a></li>
                            </ul>
                        </li>
                        <!-- <li class=" down"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">HR <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Change Time Entry</a></li>
                                <li><a href="#">Report</a></li>
                            </ul>
                        </li> -->
                    </ul>
                    <ul class="nav navbar-nav pull-right">
                        <li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['user']?>  <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="replacediv" href="#">Change Password</a></li>
                                <li><a href="#">My Profile</a></li>
                            </ul>
                        </li>
                        <li class=""><a href="../auth/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<div style="height:50px; width:100%; clear:both;"></div>

<div class="container col-md-4 col-md-offset-4" id="insert-heading"></div>

<div class="container" id="insert-element">


</div>
<!-- <div class="container-fluid form_result"></div> -->
<script src="libs/js/jquery-3.1.1.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="libs/js/bootstrap.min.js"></script>
<!-- <script type="text/javascript" src="libs/js/jquery.validate.min.js"></script> -->
<script src="libs/js/jquery.dataTables.min.js"></script>
<script src="libs/js/dataTables.bootstrap.min.js"></script>
<script src="libs/js/jquery.tabletoCSV.js"></script>
<!-- <script src="libs/js/bootstrap-select.min.js"></script> -->
<script src="libs/js/admin_homepage.js"></script>




</body>
</html>
