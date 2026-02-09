<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery Form Builder Basic Demo</title>
  <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="js/formBuilder.js"></script>
<link rel="stylesheet" href="css/formBuilder.css">
  <script>
  jQuery(document).ready(function($) {
    'use strict';
    $('textarea').formBuilder();
   
  });
  </script>
</head>

<body>
<div id="jquery-script-menu">
<div class="jquery-script-center">


</div>
  <h1 style="margin-top:150px;">jQuery Form Builder Basic Demo</h1>
  <form action="">
    <textarea name="formBuilder" id="formBuilder" cols="30" rows="10"><idea-template>
	<fields>
		<field name="radio-group-1574855427276" label="Radio Group" description="" required="false" type="10 form-field" />
		<field name="checkbox-group-1574855494349" label="Checkbox Group" style="multiple" description="" required="false" type="10 form-field" />
		<field name="select-1574855647307" label="Select" description="" required="false" type="6 form-field" />
		<field name="text-input-1574855450626" label="asffasd" description="" required="false" type="11 form-field" />
	</fields>
</idea-template></textarea>
  </form>
</body>

</html>
