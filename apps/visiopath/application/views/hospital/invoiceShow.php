    
    <style>
    .page-box {
        width: 100%;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        color: #555;
    }
    
    .page-box table {
        width: 100%;
    }
    
    .page-box table td {
        padding: 5px;
    }
    
    .page-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .page-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .page-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .details {
        margin-top:10px;
    }
    
    .page-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .page-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .page-box table tr.details td {
        padding-bottom: 5px;
    }
    
    .page-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .page-box table tr.item.last td {
        border-bottom: none;
    }
    
    .page-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    
    
   
    </style>
    <div class="page-box">

        <table style="width: 100%;">
                
             <tr>
                <td style="width:32.3%;vertical-align: middle">
                    
                    <img pagetitle=<?php echo  $jobDetails[0]->Client_case_number  ?>_<?php  echo ($jobDetails[0]->last_name)?> pagetitleClosed  class="dashboard-logo" src="<?php echo base_url()?>assets/img/logo.png" style="width:180px" />
                    
                </td>

        <td style="width: 35.1%">
        </td>

                <td style="width: 31.6%;text-align: right">
                    <span style="font-weight:bold;font-size: 10px;">Visiopath Ltd</span><br/>
          <span style="font-weight:bold;font-size: 10px;">Reg. number: 12096339</span><br/>
                    <span style="font-weight:bold;font-size: 10px;">Email: info@visiopath.com</span><br/>
                    <span style="font-weight:bold;font-size: 10px;">Phone: 0800 111 4606</span><br/>
          <span style="font-weight:bold;font-size: 10px;">URL: lims.visiopath.com</span><br/>
                    
                </td>
            </tr>

        </table>

        <table  style="width:100%" >

           <!-- <tr class="heading" >
                <td colspan="2">
                      Billed To  <?php echo $hospitalDetails[0]->hospital_name; ?>
                </td>
               
            </tr>-->

           
        
             <tr class="heading" style="padding-top:10px;">
                <td colspan="2">
                   Billed To  <?php echo $hospitalDetails[0]->hospital_name; ?> 
                </td>
               
            </tr>

          <!--  <tr >
                <td style="width:50%;">
                    Name : <?php $name =  explode(" ", $patientDetails[0]->patient_name); echo ($name[0]) ;?> 
                </td>

                 <td style="width:50%;">
                    Surname : <?php echo ($name[1]) ;?>
                </td>
               
            </tr>-->

             <tr class="details">
                 <td style="padding-top:0%;width:50%;">Case reference number: <br>
                 <barcode value="<?php echo  $test_details[0]->Client_case_number  ?>" style="width: 50mm;"></barcode><br>
                 </td>
                <td style="padding-top:0%;width:50%;">Visiopath number: <br>
                <barcode value="<?php echo  $test_details[0]->visiopath_number  ?>" style="width: 50mm;"></barcode><br>
                </td>
            </tr>
           
            <tr class="heading">
                <td  colspan="2" >
                    Doctor Details
                </td>
            </tr>
            
            <tr class="details">
                <td colspan="2" >
                    Name  of doctor: <?php echo  $DoctorDetails[0]->doctor_name  ?><br>
                
                    <?php if($DoctorDetails[0]->show_email == 1 ){ ?> Email: <?php echo $DoctorDetails[0]->email; } ?><br>
                    <?php if($DoctorDetails[0]->show_number == 1 ){ ?> Phone number: <?php echo $DoctorDetails[0]->work_number ; } ?> 
                </td>
                <br />
            </tr>

            <tr class="heading" >
                <td colspan="2">
                    Hospital Details 
                </td>
               
            </tr>

            <tr class="details">
                <td >
                    Name: <?php echo $hospitalDetails[0]->hospital_name ;?> 
                </td>

                 <td >
                    Phone number: <?php echo $hospitalDetails[0]->phone ;?>
                </td>
               
            </tr>

            <tr class="heading" >
                <td colspan="2">
                    Invoice amount
                </td>
               
            </tr>

            <tr class="details">
                <td colspan="2">
                    Amount: <?php if(!empty($test_details[0]->specimen_fee)){ echo "£".$test_details[0]->specimen_fee ;}else{ echo 'N/A' ;}?>
                </td>

                
               
            </tr>


            <?php //print_r($test_details);?>
            
            
           
        </table>
    </div>
