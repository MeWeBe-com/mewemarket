<?php
include'../includes/connection.php';
?>
            <?php
              $fname = $_POST['firstname'];
              $lname = $_POST['lastname'];
              $gen = $_POST['gender'];
              $email = $_POST['email'];
              $phone = $_POST['phonenumber'];
              $jobb = $_POST['jobs'];
              $hdate = $_POST['hireddate'];

              $company_id = $_SESSION['COMPANY_ID'];
              
              mysqli_query($db,"INSERT INTO employee
                              (EMPLOYEE_ID, COMPANY_ID,FIRST_NAME, LAST_NAME,GENDER, EMAIL, PHONE_NUMBER, JOB_ID, HIRED_DATE)
                              VALUES (Null,'{$company_id}','{$fname}','{$lname}','{$gen}','{$email}','{$phone}','{$jobb}','{$hdate}')");
              header('location:employee.php');
            ?>