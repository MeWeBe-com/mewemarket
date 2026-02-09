<?php
 $db = mysqli_connect('localhost', 'saasthemes_sais', '1000Dollar') or
        die ('Unable to connect. Check your connection parameters.');
        mysqli_select_db($db, 'saasthemes_sais' ) or die(mysqli_error($db));
?>
