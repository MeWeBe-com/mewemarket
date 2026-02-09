<?php
// first thing is to start session
session_start();
// now to check if variable is true

if(!$_SESSION['anything'])
{
    echo $_SESSION['anything'];
    header('location:login');
}


header('location: ../auth/login');
?>

<h1>Welcome You are Logged In....!!!!!</h1>
<a href="logout.php">Logout</a>
