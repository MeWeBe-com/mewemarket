<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Configurations - Lims</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

<?php $this->load->view('partial/head.php'); ?>

</head>

<body>
	<div class="wrapper">
	  <?php if(!isset($_GET['appview'])){?>  <?php $this->load->view('partial/sidebar.php') ?> <?php }?>

	    <div class="main-panel">
			<?php $this->load->view('partial/nav.php') ?>

      

	        <div class="container-fluid ">
          <div class="col-lg-2 col-md-6 col-sm-6 ">
            
           
          </div>
		  <?php /*?><div class="col-lg-2 col-md-6 col-sm-6 mt-3">
            <a href="<?php echo base_url();?>admin/exportAdminUsers" class="btn btn-outline-danger login_btn">Export CSV</a>


           
          </div><?php */?>
          <div class="col-lg-5 col-md-6 col-sm-6">

                
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 mt-4">
            

          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
             <div class="col-lg-5 col-md-6 col-sm-6 pull-left mt-4">  
             
            </div>

            <div class="col-lg-7 col-md-6 col-sm-6 pull-right mt-2">
                
            </div>
          </div>
        </div>

       
       
            <div class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <span class="text-theme  bootstrap-table pl-4">Configurations </span> 
                                    <?php if(isset($_GET['Done'])){?>
                                      <span class="text-success">Success - Configuration Updated Successfully </span> 
                                    <?php }?>
                                </div>
                                <div class="card-content">


                                    <form method="post" action="<?php echo base_url();?>admin/UpdateConfigurationForm">
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Date type</label>
                                                <div class="col-sm-3">
                                                    <select class="DateType form-control" class="form-control"  name="name[__date__type__]">
                                                      <option <?php if($ConfigOptions[1]->value == 'Y-m-d'){ echo "selected" ;} ?> value="Y-m-d">yyyy-mm-dd</option>
                                                      <option  <?php if($ConfigOptions[1]->value == 'd-m-Y'){ echo "selected" ;} ?> value="d-m-Y">dd-mm-yyyy</option>
                                                      
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>

                                         <fieldset class="mt-3">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Auto accept jobs</label>
                                                <div class="col-sm-9">
                                                    <input type="checkbox" class="switch" name="name[__auto__accept__jobs__]" value="1" <?php if($ConfigOptions[0]->value == 1){ echo "checked" ;} ?>> (Doctors will auto-accept Jobs, and cannot decline.)
                                                </div>
                                            </div>
                                        </fieldset>

                                        <input class="btn btn-wd btn-theme ml-3" type="submit"  value="Submit" />
                                    </form>
                                </div>
                            </div><!--  end card  -->
                        </div> <!-- end col-md-12 -->
                    </div> <!-- end row -->
                </div>
            </div>
           <?php $this->load->view('partial/footer.php') ?>
	    </div>
	</div>
</body>




	<?php $this->load->view('partial/footerscript.php') ?>


      <script type="text/javascript">
       /**/
   
     
       /*  $('.bootstrap-switch-on').on("click",function(){ 

              alert("asd")
                  value = '0';
            

              $.ajax({url: "<?php echo base_url();?>admin/UpdateConfiguration?name=__auto__accept__jobs__&value="+value, success: function(result){
                                   
               } 
              });
          });
      

        $(document).ready(function(){
            $('.DateType').change(function(){ 
            var postValue = $('option:selected',this).attr('value');
            $.ajax({url: "<?php echo base_url();?>admin/UpdateConfiguration?name=__date__type__&value="+postValue, success: function(result){
             
        }});
     });
});*/

        
</script>

</html>
