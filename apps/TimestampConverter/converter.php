<?php
	if(ISSET($_POST['convert'])){
		$time = $_POST['time'];
		
		$datetime = "F d, Y H:i:s A";
		
		$date = new DateTime();
		$date->setTimestamp($time);
		
		$newDate = $date->format($datetime); 
		echo "<h4>The actual Datetime is:</h4>";
		echo "<center><h3 class='text-success'>".$newDate."</h3></center>";
	}

if(ISSET($_POST['make'])){
    $time = $_POST['time'];

    $newDate = strtotime($time);

    echo "<h4>The actual Timestamp of $time is:</h4>";
    echo "<center><h3 class='text-success'>".$newDate."</h3></center>";
}
?>