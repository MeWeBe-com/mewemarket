<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
	    $company_id = $_SESSION['company_id'];;
		$title = $_POST['title'];
		$rate = $_POST['rate'];

		$sql = "INSERT INTO position (company_id,description, rate) VALUES ('$company_id','$title', '$rate')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Position added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: position.php');

?>