<?php
if($_POST)
{
    include '../database/DatabaseConnect.php';
    session_unset();
    session_destroy();
    $username=$_POST['username'];
    $password=$_POST['password'];
    $sUser=mysqli_real_escape_string($conn,$username);
    $sPass=mysqli_real_escape_string($conn,$password);
    // For Security
    $query="SELECT EMPLOYEE_PRIVILEGE, EMPLOYEE_NAME From EMPLOYEE where EMPLOYEE_NAME='$username' and EMPLOYEE_PASSWORD='$password'";
    $result=mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result)==1)
    {

        if($row['EMPLOYEE_PRIVILEGE'] == 1){
            session_start();
            $_SESSION['user']=$username;
            $_SESSION['admin']=$username;
            $_SESSION['password']=$password;
            $_SESSION['privilege']=$row['EMPLOYEE_PRIVILEGE'];
            header('location:../home/admin');
        }
        else if($row['EMPLOYEE_PRIVILEGE'] == 2){
            session_start();
            $_SESSION['user']=$username;
            $_SESSION['manager']=$username;
            $_SESSION['password']=$password;
            $_SESSION['privilege']=$row['EMPLOYEE_PRIVILEGE'];
            header('location:../home/manager');
        }
        else if ($row['EMPLOYEE_PRIVILEGE'] == 3){
            session_start();
            $_SESSION['user']=$username;
            $_SESSION['artisan']=$username;
            $_SESSION['password']=$password;
            $_SESSION['privilege']=$row['EMPLOYEE_PRIVILEGE'];
            header('location:../home/artisan');
        }
        else{
          header('location:login');
        }
        //echo $_SESSION['privilege'];
        //header('location:adminhome');
        // require_once __DIR__ . '/adminhome.php';
    }
    else{
      header('location:login');
    }
}

?>
