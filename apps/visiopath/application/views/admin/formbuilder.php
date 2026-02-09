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
                          <div class="card">
                              <div class="card-header">
                                  <h4 class="card-title">Add New Form</h4>
                              </div>
                              <div class="card-content">

                                <div class="row">
                                  <div class="col-lg-2  pirate">
                                   <h4 class="mt-1">Select Type </h4>


                                    <a id="heading" href="javascript:;" value="heading" class="btn btn-theme btn-round btn-wd mb-1">Heading</a> <br/>
                                    <a class="btn btn-theme btn-round btn-wd mb-1 input" value="input"   href="javascript:;">Input</a> <br/>
                                    <a class="btn btn-theme btn-round btn-wd mb-1 check" value="checkbox" href="javascript:;">Checkbox</a> <br/> 
                                    <a class="btn btn-theme btn-round btn-wd mb-1 textarea" value="textarea" href="javascript:;">Textarea</a>  <br/>
                                    <a class="btn btn-theme btn-round btn-wd mb-1 selectbox" value="select" href="javascript:;">Selectbox</a>   <br/>
                                 </div>

                                  <div class="col-lg-10">
                                      
                                       <form method="post" id="AddtoForm" action="<?php echo base_url();?>formbuild/AddNewFormFields/<?php echo $test_type_id?>">
                                         
                                          <div class="row">
                                            <div class="update text-center">
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
</body>

</html>



<script>
  var i = 0;

  var structure = '<div class="row" id="__i__"><h4 class="mt-2 pl-4">__TYPE__OPTIONNAME__</h4><div class="col-md-4 pr-1"><input type="hidden" value="__TYPE__OPTIONNAME__" class="form-control" name="field_type[field_type][__i__]"><div class="form-group"><label>Field text <span class="text-theme">*</span></label><input type="text" class="form-control" name="field_text[field_text][__i__]" placeholder="Field text" required=""></div></div><div class="col-md-4 px-1"><div class="form-group"><label>Sorting order</label><input type="text" class="form-control" name="field_sorting[field_sorting][__i__]" placeholder="Sorting Order e.g(1,2,3)" required=""></div></div><div class="col-md-4 pl-1 __TYPE__OTHERSPECITY__"><div class="form-group"><label>Other Specify</label><select class="form-control" name="other_specify[other_specify][__i__]"><option value="1">yes</option><option value="0">no</option></select></div></div><div class="col-md-12 px-1 __TYPE__FIELFOPTIONS__"><div class="form-group"><label for="exampleInputEmail1">Field Options<span class="text-theme">*</span>(Each option in each line)</label><textarea placeholder="Enter after every option" class="form-control" name="field_option[field_option][__i__]"></textarea></div></div> <div ><i class="ti-close remove" value="__i__" ></i></div> </div> ';


  $(".remove").click(function(){
     var id = $(this).attr('value');
     alert(id);
    $("#"+id).remove();
  });



  $('.selectbox').click(function() {
      var val = $('.selectbox').attr('value');
     

    // alert(val);
     var rep_string = structure.replace("__i__",i);
     var rep_string = rep_string.replace(/__TYPE__OPTIONNAME__/gi,val);
     var rep_string = rep_string.replace(/__i__/gi,i);
     $('#AddtoForm').append(rep_string); 
     $('.RemoveField').remove(); 

     i++;
  });

   $('#heading').click(function() {
      var val = $('#heading').attr('value');
     // alert(structure);

     var rep_string = structure.replace(/__i__/gi,i);
     var rep_string = rep_string.replace(/__TYPE__OPTIONNAME__/gi,val);
     var rep_string = rep_string.replace("__TYPE__FIELFOPTIONS__","RemoveField");
     var rep_string = rep_string.replace("__TYPE__OTHERSPECITY__","RemoveField");
     
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
    
     //var rep_string = rep_string.replace("__TYPE__OTHERSPECITY__","RemoveField");
     $('#AddtoForm').append(rep_string); 
     $('.RemoveField').remove();  
     i++;
  });

  


/*$('#heading').click(function() {
 var structure = $('<div class="row" id='+ h +'><div class="col-md-4 pr-1">'+
                      '<div class="form-group">'+
                        '<label>Field name <span class="text-theme">*</span></label>'+
                        '<input type="text" class="form-control" name="field_text[]" placeholder="Field Name" required="">'+
                      '</div>'+
                    '</div>'+

                    '<div class="col-md-4 px-1">'+
                      '<div class="form-group">'+
                        '<label>Sorting order <span class="text-theme">*</span></label>'+
                        '<input type="text" class="form-control" name="field_sorting[]" placeholder="Sorting Order e.g(1,2,3)" required="">'+
                      '</div>'+
                    '</div>'+
                    
                  '<div class="asdf" id='+ h +' ><i class="ti-close"></i></div> </div>');
   $('#AddtoForm').append(structure); 
   h++;
});

var j = 41;
$('.textarea').click(function() {
    var structure = $('<div class="row" id='+ j +'><div class="col-md-4 pr-1">'+
                      '<div class="form-group">'+
                        '<label>Field name <span class="text-theme">*</span></label>'+
                        '<input type="text" class="form-control" name="field_text[]" placeholder="Field Name" required="">'+
                      '</div>'+
                    '</div>'+
                    '<div class="col-md-4 px-1">'+
                      '<div class="form-group">'+
                                              '<label>Field Type</label>'+
                                              '<select class="form-control" name="field_type[]">'+
                                                '<option value="inputbox">'+
                                                  'Input'+
                                                '</option>'+
                                                '<option value="checkbox">'+
                                                  'Checkbox'+
                                                '</option>'+
                                                '<option value="selectbox">'+
                                                  'Select'+
                                                '</option>'+
                                               ' <option value="textbox">'+
                                                 ' Textarea'+
                                                '</option>'+
                        '</select></div></div>'+

                    '<div class="col-md-4 pl-1"><div class="form-group"><label>Other Specify</label><select class="form-control" name="other_specify[]">'+
                         ' <option value="1">yes</option>'+
                          '<option value="0">no</option>'+
                        '</select></div></div>'+
                  '<div class="col-md-4 px-1">'+
                      '<div class="form-group">'+
                        '<label>Sorting order <span class="text-theme">*</span></label>'+
                        '<input type="text" class="form-control" name="field_sorting[]" placeholder="Sorting Order e.g(1,2,3)" required="">'+
                      '</div>'+
                    '</div>'+
                    '<div class="asdf" id='+ j +'><i class="ti-close"></i></div> </div>');
   $('#AddtoForm').append(structure); 

});*/







</script>