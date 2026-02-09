<?php

echo $html = preg_replace('/<!--\[if gte mso 9\]>.*<!\[endif\]-->/s', '',  $_POST['textarea']);
?>