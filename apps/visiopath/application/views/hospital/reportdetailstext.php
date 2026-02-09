Visiopath Ltd<br />
Reg. number: 12096339<br />
Email: info@visiopath.com<br />
Phone: 0800 111 4606<br />
URL: lims.visiopath.com<br />
<br />

*Patient Details*<br />
Name: <?php  echo ($jobDetails[0]->last_name.", ".$jobDetails[0]->patient_name)?><br />
<?php echo ucfirst($jobDetails[0]->gender).", " ;?>Age: <?php 
$date=$jobDetails[0]->DateOfBirth;
$date = new DateTime($date);
$now = new DateTime();
$interval = $now->diff($date);
echo  $interval->y;

$date = $jobDetails[0]->DateOfBirth;
$date = date_create($date);
$date = date_format($date,"d-m-Y"); 
echo " | DOB: ".$date."";


?> <br />
NHS number: <?php echo  $jobDetails[0]->nhs_number  ?><br />
Hospital number: <?php echo  $jobDetails[0]->hospital_number  ?>
<?php if(!empty($jobDetails[0]->mobile_number)){?>
<br />Mobile number: <?php echo  $jobDetails[0]->mobile_number  ?>
<?php }?>
<br />
<br />

*Case Numbers/Dates*<br />
<?php if(!empty($jobDetails[0]->address)){?>
Address: <?php echo $jobDetails[0]->address  ?><br />
<?php }?>
Received date:: <?php $date=date_create($jobDetails[0]->test_date); echo date_format($date,"d-m-Y"); ?><br />
Created date: <?php $date=date_create($jobDetails[0]->test_date); echo date_format($date,"d-m-Y"); ?><br />
Authorised date: <?php $date=date_create($jobDetails[0]->update_time); echo date_format($date,"d-m-Y"); ?><br />


<br />

*Referred By*<br />
Referral clinic: <?php echo $HospitalDetails[0]->hospital_name  ?><br />
Address: <?php echo $HospitalDetails[0]->address ;?>

<br />
<br />
Case reference number: <br />
<?php echo  $jobDetails[0]->Client_case_number  ?><br />
Visiopath number: <br />
<?php echo  $jobDetails[0]->visiopath_number  ?>
<br />
<br />
*Specimen*<br />
<?php echo nl2br($jobDetails[0]->specimen_text) ?><br />
<br />
*Clinical Details*<br />
<?php echo nl2br($jobDetails[0]->clinical_details) ?><br />
<br />
*Macroscopic Details*<br />
<?php echo nl2br($jobDetails[0]->macroscopic_details) ?>

<br />
<br />
*Microscopic Details:*<br />
<?php echo  nl2br(strip_tags($jobDetails[0]->microscopy,"<br>"))  ?> 
	
	<?php foreach($ReportDetails as $reportDetail){
$report_id = $reportDetail->id ;?>
<br />
<br />*<?php echo strtoupper($reportDetail->report_name) ;?>*<br />
<?php if(!empty($GetReportValues[$report_id])){ ?>
<?php 
$array = json_decode(json_encode($GetReportValues[$report_id]), true);
foreach($GetReportFields[$report_id] as $field){ 

$key = array_search($field->field_id, array_column($array, 'field_id'));
if(!empty($GetReportValues[$report_id][$key]->values) || $field->is_heading == 1)
{
?> 
<br />- <?php echo $field->field_text;?>: <?php 

if($field->is_heading != 1 ){ 
$values = str_replace("$",",",$GetReportValues[$report_id][$key]->values);
}else{
$values = "";
}
?><?php echo $values  ?><?php 
}
}
}?>

<?php } ;?>
<br />
<br />
<?php if(!empty($multipleUploads)){?>
<br />
<br />
*Attached File:*<br />
<?php $i = 1; foreach($multipleUploads as $file){ ?>
<?php echo base_url();?><?php echo  $file->upload_file  ?>
<br /> 
<?php }?>
<?php }?>	
<br /><br />
*Snomed:*<br />
<?php echo str_replace("|", ", <br />", $jobDetails[0]->snomed)   ?> <br />
<br />

<br />

*Reported by*<br />
Doctor name: <?php $date=date_create($jobDetails[0]->test_date); echo date_format($date,"d-m-Y"); ?><br />
GMC number: <?php $date=date_create($jobDetails[0]->update_time); echo date_format($date,"d-m-Y"); ?><br />
<br />
*Contact details*
<br />

<?php if($jobDetails[0]->show_number == 1){?>
Phone number: <?php echo $jobDetails[0]->work_number ?><br />
<?php }?>

<?php if($jobDetails[0]->show_number == 1){?>
Email: <?php echo $jobDetails[0]->secondary_email ?><br />
<?php }?>

Electronically signed on: <?php $date=date_create($jobDetails[0]->update_time); echo date_format($date,'d-m-Y'); ?> at <?php $date=date_create($jobDetails[0]->update_time); echo date_format($date,("h:i a")); ?><br />

<br />

<?php if($getErrorReport != 'Fail'){?>
<br />
*Supplementary Report*
<br />

Doctor name: <?php echo  "Dr. ".$jobDetails[0]->doctor_name  ?><br />
Subject: <?php echo $getErrorReport[0]->title ?> <br />
Date: <?php $date=date_create($getErrorReport[0]->date); echo date_format($date,"d-m-Y H:i a"); ?><br />
Report Details: <br />


<?php $comments = str_replace('&nbsp;', ' ', $getErrorReport[0]->Comments) ;
	  echo nl2br(strip_tags($comments));  ?> 
<br/>
                           
					<?php }?>




<?php /*	<br>

<table style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse; border:1px solid #ccc" >
<tr>
<td bgcolor="#000000" colspan="3" style=" padding:5px; font-weight:bold; font-size:15px;"> <font color="#FFFFFF">Hospital Details</font></td>
</tr>
<tr>

<tr>
<td style="width: 50%;padding-top: 15px"><strong>Name of Hospital : </strong> <?php echo  $HospitalDetails[0]->hospital_name  ?></td>
<td  style="width: 50%;padding-top: 15px"><strong>Email : </strong><?php echo  $HospitalDetails[0]->email  ?></td>

</tr>
<tr>
<td style="width: 50%;"><strong>Phone number :</strong> <?php echo $HospitalDetails[0]->phone ?></td>
<td style="width: 50%;"><strong>Address : </strong><?php echo  $HospitalDetails[0]->address  ?></td>
</tr>

</tr>
</table>


<?php if($getErrorReport != 'Fail'){?>

<br />

<table class="supply"  style="width: 100%;border: solid 1px #5544DD; border-collapse: collapse; border:1px solid #ccc" >
<thead>
<tr>
<td bgcolor="#000000" colspan="4" style=" padding:5px; font-weight:bold; font-size:15px;"> <font color="#FFFFFF">Supplementary Details.</font></td>
</tr>
<tr >
<th width="25%">User</th>
<th width="25%">Title</th>
<th width="25%">Comments</th>
<th width="25%">Date</th>
</tr>
</thead>
<tbody class="tbody">

<?php foreach($getErrorReport as $error){ //print_r($error);?>
<tr>
<td width="25%"><?php echo $jobDetails[0]->doctor_name ?></td>
<td width="25%"><?php echo $error->title ?></td>
<td width="25%"><?php echo $error->Comments ?></td>
<td width="25%"><?php $date=date_create($error->date); echo date_format($date,"d-m-Y"); ?></td>
</tr>
<?php }?>
</tbody>


</table>

<?php }*/?>


