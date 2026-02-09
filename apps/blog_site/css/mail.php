<?php
   
    $from = "haseeb.idevation@gmail.com";
    $to = "haseeb.idevation@outlook.comm";
    $subject = "Checking PHP mail";
    $message = "PHP mail works just fine";
    $headers = "From:" . $from;
    $send_mail = mail($to,$subject,$message, $headers);
    
?>