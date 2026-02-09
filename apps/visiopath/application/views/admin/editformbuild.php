<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
  Add New Form - LIMS
  </title>
 
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
 <?php $this->load->view('partial/head.php') ?>
</head>

<body class="">
  <div class="wrapper ">
    <?php $this->load->view('partial/sidebar.php') ?>
    <div class="main-panel">
      <!-- Navbar -->
      <?php $this->load->view('partial/nav.php') ?>
      <!-- End Navbar -->
      <!-- <div class="panel-header panel-header-sm">

</div> -->

   <div class="content">
              <div class="container-fluid">
                  <div class="row">
                      
                      <div class="col-lg-12 col-md-7">
                        <?php //print_r($formfields);?>

                          <div class="card">
                              <div class="card-header">
                                  <h4 class="card-title"><?php  echo "Add/Edit form fields in ".$TestTypeName->TestTypeName ;  ?> </h4>
                              </div>
                              <div class="card-content">

                                <div class="row">
                                  <div class="col-lg-2  pirate">
                                   <h4 class="mt-1">Select Type </h4>


                                    <a id="heading" href="javascript:;" value="heading" class="btn btn-theme btn-round btn-wd mb-1">Heading</a> <br/>
                                    <a class="btn btn-theme btn-round btn-wd mb-1 input" value="inputbox"   href="javascript:;">Input</a> <br/>
                                    <a class="btn btn-theme btn-round btn-wd mb-1 check" value="checkbox" href="javascript:;">Checkbox</a> <br/> 
                                    <a class="btn btn-theme btn-round btn-wd mb-1 textarea" value="textbox" href="javascript:;">Textarea</a>  <br/>
                                    <a class="btn btn-theme btn-round btn-wd mb-1 selectbox" value="selectbox" href="javascript:;">Selectbox</a>   <br/>
                                 </div>

                                  <div class="col-lg-10">
                                      
                                       <form method="post" action="<?php echo base_url();?>formbuild/AddNewFormFields/<?php echo $test_type_id?>">
                                         
                                        <?php //print_r($formfields)?>
										<div class="row">
                                            <div class="update text-center mb-3">
                                              <button type="submit" class="btn btn-theme btn-round">Submit</button>
                                            </div>
                                          </div>
										 <div class="row">
											<div id="AddtoForm" >
											
											
											</div>
										</div>
                                          <div class="row">
                                            <div class="update text-center mt-3">
                                              <button type="submit" class="btn btn-theme btn-round">Submit</button>
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
  
 
 
 

    
      <?php $this->load->view('partial/footer.php') ?>
    </div>
  </div>
  <!--   Core JS Files   -->
 <?php $this->load->view('partial/footerscript.php') ?>
 
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
  $( function() {
    $( "#AddtoForm" ).sortable({
      revert: true
    });
    /*$( "#draggable" ).draggable({
      connectToSortable: "#sortable",
      helper: "clone",
      revert: "invalid"
    });*/
    $( ".row" ).disableSelection();
  } );
  </script>
</body>

</html>



<script>
var i=0;

  var structure = '<div class="row ui-state-default" id="row__i__"><h4 class="mt-2 pl-4">__TYPE__OPTIONNAME__</h4><div class="col-md-6 pr-1"><input type="hidden" value="__TYPE__FieldTextID__" class="form-control hiddenID" name="field_type[__i__][field_id]"><input type="hidden" value="__TYPE__FieldType__" class="form-control" name="field_type[__i__][field_type]"><div class="form-group"><label>Field text <span class="text-theme">*</span></label><input type="text" class="form-control" name="field_type[__i__][field_text]" value="__TYPE__FieldTextValue__" placeholder="Field text" required=""></div></div><div class="col-md-4 px-1 dontshow"><div class="form-group"><label>Sorting order</label><input type="text" class="form-control" value="__TYPE__FieldSortValue__" name="field_type[__i__][sorting_order]" placeholder="Sorting Order e.g(1,2,3)" required=""></div></div><div class="col-md-6 pl-1 __TYPE__OTHERSPECITY__"><div class="form-group"><label>Add Free Text Area</label><select class="form-control" name="field_type[__i__][other_specify]"><option value="1" __TYPE__FieldOtherSpecifyValueYes__>yes</option><option value="0" __TYPE__FieldOtherSpecifyValueNo__>no</option></select></div></div><div class="col-md-12 px-1 __TYPE__FIELFOPTIONS__"><div class="form-group"><label for="exampleInputEmail1">Field Options<span class="text-theme">*</span>(Each option in each line)</label><textarea placeholder="Enter after every option" class="form-control" name="field_type[__i__][field_options]">__TYPE__FIELDOPTIONSVALUE__</textarea></div></div><div><i class="ti-close remove removeRow" value="row__i__"></i></div></div>';
  <?php 
  $i = 0;
  foreach($formfields as $field){ ?>

   <?php if(($field->is_heading) == 1){ ?>

    var rep_string = structure.replace(/__s__/gi,i); 
     
     var rep_string = rep_string.replace("__TYPE__FIELFOPTIONS__","RemoveField");
	  
	    var rep_string = rep_string.replace("__TYPE__OPTIONNAME__","Heading");
	  var rep_string = rep_string.replace(/__i__/gi,"<?php echo $i?>");
	  var rep_string = rep_string.replace("__TYPE__FieldTextID__","<?php echo  $field->field_id ;?>");
	   var rep_string = rep_string.replace("__TYPE__FieldType__","heading");
     
	 
	 
	 
	 var rep_string = rep_string.replace("__TYPE__OTHERSPECITY__","RemoveField");
     var rep_string = rep_string.replace("__TYPE__FieldTextValue__","<?php echo  $field->field_text ;?>");
     var rep_string = rep_string.replace("__TYPE__FieldSortValue__","<?php echo  $field->sorting_order ;?>");
     var rep_string = rep_string.replace("__TYPE__OPTIONNAME__","");
     
    
     $('#AddtoForm').append(rep_string);
     $('.RemoveField').remove(); 

     rep_string = '';


   <?php } ?>

   <?php if($field->field_type == 'inputbox' || $field->field_type == 'textbox'){ ?>

     var rep_string = structure.replace(/__s__/gi,i);
     
     var rep_string = rep_string.replace("__TYPE__FIELFOPTIONS__","RemoveField");
     var rep_string = rep_string.replace("__TYPE__FieldTextValue__","<?php echo  $field->field_text ;?>");
     var rep_string = rep_string.replace("__TYPE__FieldSortValue__","<?php echo  $field->sorting_order ;?>");
     var rep_string = rep_string.replace("__TYPE__OPTIONNAME__","<?php echo  $field->field_type ;?>");
	 
	 var rep_string = rep_string.replace(/__i__/gi,"<?php echo $i?>");
	  var rep_string = rep_string.replace("__TYPE__FieldTextID__","<?php echo  $field->field_id ;?>");
	   var rep_string = rep_string.replace("__TYPE__FieldType__","<?php echo  $field->field_type ;?>");
     
	<?php if($field->field_type == 1){ ?>
        var rep_string = rep_string.replace("__TYPE__FieldOtherSpecifyValueYes__","selected");
		 var rep_string = rep_string.replace("__TYPE__FieldOtherSpecifyValueNo__","");
    <?php }else{?>
        var rep_string = rep_string.replace("__TYPE__FieldOtherSpecifyValueNo__","selected");
		 var rep_string = rep_string.replace("__TYPE__FieldOtherSpecifyValueYes__","");
    <?php }?>
          
     $('#AddtoForm').append(rep_string);
     $('.RemoveField').remove(); 

     rep_string = '';


   <?php } ?>

    
      <?php  if($field->field_type == 'checkbox' || $field->field_type == 'selectbox'){ ?>

      var rep_string = structure.replace(/__s__/gi,i);

     var rep_string = rep_string.replace("__TYPE__FieldTextValue__","<?php echo  $field->field_text ;?>");
     var rep_string = rep_string.replace("__TYPE__FieldSortValue__","<?php echo  $field->sorting_order ;?>");
     var rep_string = rep_string.replace("__TYPE__OPTIONNAME__","<?php echo  $field->field_type ;?>");
     var rep_string = rep_string.replace("__TYPE__FIELDOPTIONSVALUE__","<?php echo  str_replace("$","__DOLLAR__",preg_replace('/\s+/', ' ', ($field->field_options)))  ;?>");
	 
	 var rep_string = rep_string.replace(/__i__/gi,"<?php echo $i?>");
	  var rep_string = rep_string.replace("__TYPE__FieldTextID__","<?php echo  $field->field_id ;?>");
	   var rep_string = rep_string.replace("__TYPE__FieldType__","<?php echo  $field->field_type ;?>");
     

     

     
     <?php if($field->field_type == 1){ ?>
        var rep_string = rep_string.replace("__TYPE__FieldOtherSpecifyValueYes__","selected");
		 var rep_string = rep_string.replace("__TYPE__FieldOtherSpecifyValueNo__","");
    <?php }else{?>
        var rep_string = rep_string.replace("__TYPE__FieldOtherSpecifyValueNo__","selected");
		 var rep_string = rep_string.replace("__TYPE__FieldOtherSpecifyValueYes__","");
    <?php }?>
     
      $('#AddtoForm').append(rep_string); 


      $( "#AddtoForm textarea" ).last().val();
      $('.RemoveField').remove(); 

     rep_string = '';
     

   <?php } ?>


  <?php $i++;}?>



$('textarea').each(function(){
   var original = $(this).val();
   var valueNew = original.replace(/__DOLLAR__/gi, "\n");
   //.val($('#myTextArea').val().replace(@<br />@, "\N"));
  $(this).val(valueNew);
})



  

  



structure = "";

var structure = '<div class="row ui-state-default" id="row__i__"><h4 class="mt-2 pl-4">__TYPE__OPTIONNAME__</h4><div class="col-md-6 pr-1"><input type="hidden" value="__TYPE__OPTIONNAME__" class="form-control" name="field_type[__i__][field_type]"><div class="form-group"><label>Field text <span class="text-theme">*</span></label><input type="text" class="form-control" name="field_type[__i__][field_text]" placeholder="Field text" required=""></div></div><div class="col-md-4 px-1 dontshow"><div class="form-group" ><label>Sorting order</label><input type="text" class="form-control" value="__NewSortValue__" name="field_type[__i__][sorting_order]" placeholder="Sorting Order e.g(1,2,3)" required=""></div></div><div class="col-md-6 pl-1 __TYPE__OTHERSPECITY__"><div class="form-group"><label>Add Free Text Area</label><select class="form-control" name="field_type[__i__][other_specify]"><option value="1">yes</option><option value="0">no</option></select></div></div><div class="col-md-12 px-1 __TYPE__FIELFOPTIONS__"><div class="form-group"><label for="exampleInputEmail1">Field Options<span class="text-theme">*</span>(Each option in each line)</label><textarea placeholder="Enter after every option" class="form-control" name="field_type[__i__][field_options]"></textarea></div></div><div><i class="ti-close remove removeRow"  value="row__i__"></i></div></div> ';

var i = <?php echo $i?>;

  $('.selectbox').click(function() {
      var val = $('.selectbox').attr('value');
     

    // alert(val);
     var rep_string = structure.replace(/__i__/gi,i);
     var rep_string = rep_string.replace(/__TYPE__OPTIONNAME__/gi,val);
	 var rep_string = rep_string.replace(/__NewSortValue__/gi,(i+1));
    // var rep_string = rep_string.replace(/__i__/gi,i);
     $('#AddtoForm').append(rep_string); 
     $('.RemoveField').remove(); 

     i++;
  });

   $('#heading').click(function() {
      var val = $('#heading').attr('value');
     // alert(structure);

     var rep_string = structure.replace(/__i__/gi,i);
     var rep_string = rep_string.replace(/__TYPE__OPTIONNAME__/gi,"Heading");
     var rep_string = rep_string.replace("__TYPE__FIELFOPTIONS__","RemoveField");
     var rep_string = rep_string.replace("__TYPE__OTHERSPECITY__","RemoveField");
     var rep_string = rep_string.replace("__TYPE__FieldSortValue__","");
     var rep_string = rep_string.replace("__TYPE__FieldTextValue__","");
	  var rep_string = rep_string.replace(/__NewSortValue__/gi,(i+1));
     $('#AddtoForm').append(rep_string); 
     $('.RemoveField').remove();  
     i++;
  });

   $('.input').click(function() {
      var val = $('.input').attr('value');
     // alert(structure);

      var rep_string = structure.replace(/__i__/gi,i);
     var rep_string = rep_string.replace(/__TYPE__OPTIONNAME__/gi,val);
     var rep_string = rep_string.replace("__TYPE__FIELFOPTIONS__","RemoveField");
     var rep_string = rep_string.replace(/__NewSortValue__/gi,(i+1));
     //var rep_string = rep_string.replace("__TYPE__OTHERSPECITY__","RemoveField");
     $('#AddtoForm').append(rep_string); 
     $('.RemoveField').remove();  
     i++;
  });

   $('.check').click(function() {
      var val = $('.check').attr('value');
     // alert(structure);

      var rep_string = structure.replace(/__i__/gi,i);
     //var rep_string = rep_string.replace("__TYPE__FIELFOPTIONS__","RemoveField");
     var rep_string = rep_string.replace(/__TYPE__OPTIONNAME__/gi,val);
      var rep_string = rep_string.replace(/__NewSortValue__/gi,(i+1));
     //var rep_string = rep_string.replace("__TYPE__OTHERSPECITY__","RemoveField");
     $('#AddtoForm').append(rep_string); 
     $('.RemoveField').remove();  
     i++;
  });

   $('.textarea').click(function() {
      var val = $('.textarea').attr('value');
     // alert(structure);

      var rep_string = structure.replace(/__i__/gi,i);
     var rep_string = rep_string.replace("__TYPE__FIELFOPTIONS__","RemoveField");
    var rep_string = rep_string.replace(/__TYPE__OPTIONNAME__/gi,val);
     var rep_string = rep_string.replace(/__NewSortValue__/gi,(i+1));
     //var rep_string = rep_string.replace("__TYPE__OTHERSPECITY__","RemoveField");
     $('#AddtoForm').append(rep_string); 
     $('.RemoveField').remove();  
     i++;
  });

  






$(document).on("click",".removeRow",function(){


	var r = confirm("Are you sure you want to remove this field, it will remove any report data associated with this field");
	if (r == true) {
	  var id = $(this).attr('value');
	  var hiddenID = $("#"+id).find(".hiddenID").val();
	  if(hiddenID == "undefined"){
	  	$("#"+id).remove();
	  }else{
	  	//alert(hiddenID)
		//Run Ajax here
        $.ajax({url: "<?php echo base_url();?>formbuild/DeleteFormFieldById/"+hiddenID, success: function(result){
                $("#"+id).remove();
              }
                  
        });
	  }
   	// $("#row"+id).remove();
	} else {
	  return false;
	} 
     
  });


</script>