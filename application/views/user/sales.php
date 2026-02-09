<?php echo shortNumber(12560);

function shortNumber($num)
{
	$units = ['', 'K', 'M', 'B', 'T'];
	for ($i = 0; $num >= 1000; $i++) {
		$num /= 1000;
	}
	return round($num, 1) . $units[$i];
}
?>
