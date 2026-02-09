<?php
	$conn = new mysqli('localhost', 'saasthemes_payrollsystem', '1000Dollar', 'saasthemes_payrollsystem');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>
