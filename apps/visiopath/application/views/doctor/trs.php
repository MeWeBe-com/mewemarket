<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Add Report Details - LIMS</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

<style>
	.form-group {
    position: unset !important;
}
</style>

     <!-- Bootstrap core CSS     -->
  <?php $this->load->view('partial/head')?>

</head>

<body>
	<div class="wrapper">
		<?php $this->load->view('partial/sidebar')?>

	    <div class="main-panel">
			<?php $this->load->view('partial/nav')?>



	        <div class="content">

	        	 

	            <div class="container-fluid">
	                <div class="row">

<div class="MainForm row">


	<?php //print_r($FieldDetails);?>

	<form class="col-lg-11 ml-5 card pb-5" id="Forms" action="<?php echo base_url()?>uploadreport/GetFormValues/<?php echo $ReportDetails[0]->id?>" method="post">
		<div class="form-group"></div>
		<div class="form-group">
		      		<div class="col-lg-3"> Report Name: </div>

		      		<div class="col-lg-3">
		      			 <input class="form-control" type="text" name="report_name" value="<?php echo $ReportDetails[0]->report_name?>">
		      		</div>
	      		</div>
	
<?php foreach($FieldDetails as $field){ ?>
	<div class="form-group" style="clear:both;">


	<?php 
  //print_r($field);

	if($field->is_heading == 1){ ?>
		<div class="col-lg-12 pt-4 pb-4">
	 <?php 	echo "<strong>".ucfirst($field->field_text)."</strong> <br/>"; ?>
		</div>

		<?php if($field->is_heading == 1 && $field->field_text == "PATHOLOGIC STAGING"){ ?>
			<?php  echo "<pre class='yellowbox'>".$field->terms."</pre>";?>
	  <?php	}?>
	<?php }

	if($field->field_type == "checkbox"){


		echo "<span class='col-lg-3'>".ucfirst($field->field_text)."</span>";

		$options = explode("$",$field->field_options) ;
		
		
		if(!empty($field->values)){
			$values = explode("$",$field->values) ;
		}else{
			$values = array();
		}
		
		if(empty($field->other_text)){
			$field->other_text = "";
		}		
		 ?>
		<div class="col-lg-5 mt-3 mb-3">


		<?php foreach($options as $option){?> 
			
				<input type="checkbox" value="<?php echo $option?>" <?php if(in_array($option,$values)){?> checked="checked" <?php }?> name="<?php echo $field->field_name?>[]"><?php echo $option?><?php echo "<br/>"?>
			

	<?php	}?>
	</div>

	<?php if($field->other_specify == "1"){ ?>
		<div class="col-lg-4 mt-3 mb-3 pull-right"> 
		<textarea rows="2" name="<?php echo $field->field_name?>_other" placeholder="Comments"><?php echo $field->other_text?></textarea>
		<?php /*?><input type="text" name="<?php echo $field->field_name?>_other" value="<?php echo $field->other_text?>" > <?php */?></div>
	<?php }
	?> <?php 
	}elseif($field->field_type == "selectbox"){


		echo "<span class='col-lg-3'>".ucfirst($field->field_text)."</span>";

		$options = explode("$",$field->field_options) ; 
		
		 
		if(!empty($field->values)){
			 $values = $field->values;
		}else{
			$values ="";
		}
		
		if(empty($field->other_text)){
			$field->other_text = "";
		}	
		
		
		?>
		<div class="col-lg-5 mt-3 mb-3">
				<select class="col-lg-6" name="<?php echo $field->field_name?>">
				
			

		<?php foreach($options as $option){?> 
			
			<option value="<?php echo $option?>" <?php if($option==$values){?> selected="selected" <?php }?>><?php echo $option?></option>

	<?php	}

	
	?></select></div> <?php if($field->other_specify == "1"){?>
		<div class="col-lg-4 mt-3 mb-3 pull-right"> <input type="text" name="<?php echo $field->field_name?>_other" value="<?php echo $field->other_text?>" placeholder="Comments"> </div>
	<?php }?> <?php 
	}

	elseif($field->field_type == "inputbox"){
		echo "<span class='col-lg-3'>".ucfirst($field->field_text)."</span>";?>
		
		<div class="col-lg-5 mt-3 mb-3">
			<input class="col-lg-6" type="text" name="<?php echo $field->field_name?>" value="<?php echo $field->values?>" >
		</div> <?php 

		if($field->other_specify == "1"){?>
		<div class="col-lg-4 mt-3 mb-3 pull-right"> <input type="text" name="<?php echo $field->field_name?>_other" value="<?php echo $field->other_text?>" placeholder="Comments"> </div>
	<?php }
	}

	elseif($field->field_type == "textbox"){
		echo "<span class='col-lg-3'>".ucfirst($field->field_text)."</span>";?>
		
		<div class="col-lg-9 mt-3 mb-3">
			<textarea name="<?php echo $field->field_name?>" class="form-control"><?php echo $field->values?></textarea>
		</div> <?php 

	}



?>

</div>

<?php 
}?>
<div class="form-group">
<div class="col-lg-12 mt-3 mb-3">
	<input type="hidden" name="type" value="json" >
	<input class="btn btn-outline-danger btn-theme" value="submit" name="submit" type="submit">

	<span class="autosavetext d-inline-block pt-3 pb-3"></span>
	</div>
</div>
	</form>
</div>

   <?php $this->load->view('partial/footer')?>
	    </div>
	</div>
</body>

	<?php $this->load->view('partial/footerscript')?>

</html>

<script type="text/javascript">
	
	/*setInterval(function(){ 
		var post_url = '<?php echo base_url();?>uploadreport/GetFormValues/<?php echo end($this->uri->segment_array())?>'; 
        var request_method = $('#Forms').attr("method"); 
        var form_data = $('#Forms').serialize();
            
            $.ajax({
            	url : post_url,
            	type: request_method,
            	data : form_data
       		 }).done(function(response){ //
            		$('.autosavetext').show();
				   	$('.autosavetext').text('Autosaved');

				  	$('.autosavetext').delay(2500).fadeOut('slow');


        	 });

	}, 60000);*/
</script>