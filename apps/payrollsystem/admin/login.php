<?php
	session_start();
	include 'includes/conn.php';

	if(isset($_POST['login'])){

        $username = $_POST['username'];
		$password = $_POST['password'];

		 $sql = "SELECT * FROM admin WHERE username = '$username'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find account with the username';
		}
		else{
			$row = $query->fetch_assoc();

			if(password_verify($password, $row['password'])){
				$_SESSION['admin'] = $row['id'];

                 $sql = "SELECT * FROM company WHERE company_id =  '".$row['company_id']."'";
                $query = $conn->query($sql);
                $company_details = $query->fetch_assoc();

                $_SESSION['company_id'] = $company_details['company_id'];
                $_SESSION['company_name'] = $company_details['company_name'];

			}
			else{
				$_SESSION['error'] = 'Incorrect password';
			}
		}
		
	}
	else{
		$_SESSION['error'] = 'Input admin credentials first';
	}

	header('location: index.php');

?>