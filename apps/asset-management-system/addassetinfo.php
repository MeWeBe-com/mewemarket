<?php  session_start(); include('connection/config.php');?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Add Asset Info</title>
    <?php include('head.php');?>

    <?php if(isset($_POST['submit'])){
        $data = $_POST;

         $query = "INSERT INTO `tblitem`(`company_id`, `item_tag`, `item_name`, `description`,  `cost`, `date_purchased`, `qty`, `category_id`, `user_id`) VALUES ('".$_SESSION['company_id']."','".$data['item_tag']."','".$data['item_name']."','".$data['description']."','".$data['cost']."','".$data['date_purchased']."','".$data['qty']."','".$data['category_id ']."','".$_SESSION['user_id']."')";
        mysqlInsert($query);

        echo '<script type="text/javascript">
           window.location = "assetinfo.php"
      </script>';

    }?>

</head>

<body class="materialdesign">

<!-- Header top area start-->
<div class="wrapper-pro">
    <?php include('sidebar.php');?>
    <!-- Header top area start-->
    <div class="content-inner-all">
        <?php include('header.php');?>
        <!-- Header top area end-->
        <!-- Breadcome start-->
        <div class="breadcome-area mg-b-30 small-dn">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcome-list shadow-reset">
                            <div class="row">
                                <div class="col-lg-6">
                                 </div>
                                <div class="col-lg-6">
                                    <ul class="breadcome-menu">
                                        <li><a href="dashboard.php">Dashboard</a> <span class="bread-slash">/</span>
                                        </li>
                                        <li><a href="assetcategory.php">Asset Category</a> <span class="bread-slash">/</span>
                                        </li>
                                        <li><span class="bread-blod">Add Asset Category</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcome End-->
        <!-- Static Table Start -->
        <div class="data-table-area mg-b-15">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sparkline9-list shadow-reset">
                            <div class="sparkline9-hd">
                                <div class="main-sparkline9-hd">
                                    <h1>Add Asset Category <span class="basic-ds-n">Form</span></h1>
                                </div>
                            </div>
                            <div class="sparkline9-graph">
                                <div class="basic-login-form-ad">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <form action="" method="post">
                                                <div class="basic-login-inner">
                                                <h3>Fill In : </h3>
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <label class="login2">Item Barcode : </label>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" placeholder="Search Barcode" name="item_tag" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <label class="login2">Name & Amount : </label>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control" placeholder="Item Name" name="item_name" style="width: 140%" />
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="number" class="form-control" placeholder="Amt" name="cost" style="  ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <label class="login2">Description : </label>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <textarea name="description" cols="35" rows="3" placeholder="Write Description.."></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <label class="login2">Date Purchase : </label>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="date" name="date_purchased" class="form-control" placeholder="Date" style="width: 140%" />
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="number" name="qty" class="form-control" placeholder="Qty" style="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <label class="login2">Category : </label>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <select class="form-control" name="category_id">
                                                                    <option value="">Select Category</option>
                                                                    <?php
                                                                    $sql = "SELECT * FROM `tblcategory` where company_id = '".$_SESSION['company_id']."'";
                                                                    $branchs = mysqlFetchRows($sql);

                                                                    foreach($branchs as $branch){ ?>
                                                                        <option value="<?php echo $branch['category_id']?>"><?php echo $branch['category_name']?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-12 text-center">
                                                                <input type="submit" name="submit" value="save" class="btn btn-custon-rounded-three btn-primary"  />
                                                            </div>
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
            </div>
        </div>
        <!-- Static Table End -->
    </div>
</div>
<!-- Chat Box Start-->
<!-- Chat Box End-->
<!-- jquery
    ============================================ -->

<script src="js/vendor/jquery-1.11.3.min.js"></script>
<!-- bootstrap JS
    ============================================ -->
<script src="js/bootstrap.min.js"></script>
<!-- meanmenu JS
    ============================================ -->
<script src="js/jquery.meanmenu.js"></script>
<!-- mCustomScrollbar JS
    ============================================ -->
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- sticky JS
    ============================================ -->
<script src="js/jquery.sticky.js"></script>
<!-- scrollUp JS
    ============================================ -->
<script src="js/jquery.scrollUp.min.js"></script>
<script src="js/modal-active.js"></script>
<!-- counterup JS
    ============================================ -->
<script src="js/counterup/jquery.counterup.min.js"></script>
<script src="js/counterup/waypoints.min.js"></script>
<!-- peity JS
    ============================================ -->
<script src="js/peity/jquery.peity.min.js"></script>
<script src="js/peity/peity-active.js"></script>
<!-- sparkline JS
    ============================================ -->
<script src="js/sparkline/jquery.sparkline.min.js"></script>
<script src="js/sparkline/sparkline-active.js"></script>
<!-- data table JS
    ============================================ -->
<script src="js/data-table/bootstrap-table.js"></script>
<script src="js/data-table/data-table-active.js"></script>
<script src="js/data-table/bootstrap-table-editable.js"></script>
<script src="js/data-table/bootstrap-editable.js"></script>
<script src="js/data-table/bootstrap-table-resizable.js"></script>
<script src="js/data-table/colResizable-1.5.source.js"></script>
<script src="js/data-table/bootstrap-table-export.js"></script>
<!-- main JS
    ============================================ -->
<script src="js/main.js"></script>
</body>
</html>
