<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Editor
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
 <?php include('partial/head.php') ?>

<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
 
<script src="<?php echo base_url();?>assets/js/plugin.js"></script>

</head>

<body class="">
  <div class="wrapper ">
    <?php include('partial/sidebar.php') ?>
    <div class="main-panel">
      <!-- Navbar -->
      <?php include('partial/nav.php') ?>
      <!-- End Navbar -->
      <!-- <div class="panel-header panel-header-sm">


</div> -->

   <div class="content">
              <div class="container-fluid">
                  <div class="row">
                      
                      <div class="col-lg-12 col-md-7">
                          <div class="card">
                              <div class="card-header">
                                  <h4 class="card-title">Editor </h4>
                              </div>
                              <div class="card-content">
                                <form method="post" action="<?php echo base_url();?>ckedit/Data" accept-charset="utf-8" enctype="multipart/form-data">
                                  <div class="row">
                                     <textarea name="microscopy" id="MicroscopicField" rows="15" class="resize-open form-control">This is my textarea to be replaced with CKEditor.</textarea>

                                      <script>
                                          CKEDITOR.replace( 'MicroscopicField', {
                                                language: 'en',
                                                removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,About',
                                                extraPlugins: 'autogrow'
                                                



                                                
                                            });

                                         
                                      </script>


                                    <div class="update text-center">
                                      <button type="submit" class="btn btn-wd btn-theme">Submit</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
  
 

    
      <?php include('partial/footer.php') ?>
    </div>
  </div>
  <!--   Core JS Files   -->
 <?php include('partial/footerscript.php') ?>

 <script>
  
</script>
</body>

</html>

