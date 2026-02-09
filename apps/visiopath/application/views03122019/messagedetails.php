<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Messages - LIMS
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
 <?php include('partial/head.php') ?>
</head>

<body class="">
  <div class="wrapper ">
    <?php include('partial/sidebar.php') ?>
    <div class="main-panel">
      <!-- Navbar -->
      <?php include('partial/nav.php') ?>
      <!-- End Navbar -->
      <!-- <div class="panel-header panel-header-lg">

  <canvas id="bigDashboardChart"></canvas>


</div> -->
      <div class="content">
        <div class="row pb-4">
          <div class="col-lg-2 col-md-6 col-sm-6">
            
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
           
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
           
          </div>
          <div class="col-lg-12 col-md-6 col-sm-6">

            <div class="col-lg-6 col-md-6 col-sm-6 pull-left mt-2">  
              <a href="<?php echo base_url()?>messages" class="btn btn-outline-danger btn-theme login_btn">Back to Inbox</a>

             
            </div>

          <div class="col-lg-6 col-md-6 col-sm-6 pull-right text-right">
              
          </div>

        </div>
      </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title pb-5"> <strong> <?php echo $messageDetail[0]->title?> </strong></h4>
              </div>
              <div class="card-body pl-4 pb-4">
                  <span class="d-block ">From : <strong class="text-theme"> 
                  
                  <?php 

                   foreach($Users as $user){ //print_r($user);
                      if($user->id == $messageDetail[0]->sender_id){
                          echo $user->username;
                      }
                  }

                  ?>

                  </strong></span>
                  

                  <p class="pt-3 ">
                   <?php echo $messageDetail[0]->message?> 
                  </p>

                  <?php //print_r($messageReply);?>

                  <?php foreach($messageReply as $message){?>
                  	 <div class="ml-5">
                  		From : <strong class="text-theme"> <?php 

		                   foreach($Users as $user){ //print_r($user);
		                      if($user->id == $message->sender_id){
		                          echo $user->username;
		                      }
		                  }

                  ?> </strong>


                  <p class="pt-3 ">
                   <?php echo $message->message?> 
                  </p>
              	 <?php }?>


                  </div>
                 
                   <div class="details-2 collapse">

                 <form method="post" action="<?php echo base_url();?>messages/SendMessage">

                   <input type="hidden" name="sender" value="<?php echo $this->session->userdata('id')?>" />
                   <input type="hidden" name="receiver" value="<?php echo $messageDetail[0]->sender_id?>" />
                   <input type="hidden" name="title" value="<?php echo $messageDetail[0]->title?>" />
                   <input type="hidden" name="message_parent_id" value="<?php echo $messageDetail[0]->message_id?>" />

                    <div class="col-md-12 pt-4">
                      <div class="form-group">
                        <textarea class="form-control textarea" name="message"></textarea>
                      </div>
                    </div> 

                    <input class="btn btn-outline-danger btn-theme login_btn  mt-4 ml-4 mb-4" type="submit" name="submit" value="submit">  

                    </form> 
                  </div>

                <?php if(empty($messageReply)){ ?>  
                	<a href="#" class="btn btn-outline-danger btn-theme login_btn  mt-4 ml-4 mb-4"  data-toggle="collapse" data-target=".details-2" data-text-alt="Cancel">Reply</a>
                <?php }else{ ?> 
                	<a href="<?php echo base_url()?>messages/AddMessage" class="btn btn-outline-danger btn-theme login_btn  mt-4">Write New Message</a> 
                <?php } ?>




<script>
  jQuery(function($){
  $('.btn[data-toggle="collapse"]').on('click', function(){
    $(this)
    .data('text-original', $(this).text())
    .text($(this).data('text-alt') )
    .data('text-alt', $(this).data('text-original'));
  });
});
</script>
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
    $(document).ready(function() {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartsPages();
    });
  </script>
</body>

</html>
