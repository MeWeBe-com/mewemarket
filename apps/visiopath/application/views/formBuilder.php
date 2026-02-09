<?php include('partial/head.php') ?>

<?php echo form_open('builder/submitbuilder'); 

foreach($forms as $form){ ?>

   <div class="form-group <?php if($form['type'] !==  "textarea"){ echo "col-md-4"; }else{ echo "col-md-12"; }?> ">

	   <?php

	  	$fields = $this->builder_model->MakeFormField($form);

	  	echo $fields; ?>
	
	</div>
<?php 
  }

  	?>


 <div class="col-md-12 text-center">
 	<?php echo form_submit('submit', 'Submit','class="btn btn-theme btn-round"'); ?>
 </div>




<?php   echo form_close(); exit;?>


<?php include('partial/footerscript.php') ?>


