<?php
require_once 'dompdf/vendor/autoload.inc.php';
require_once 'dompdf/vendor/dompdf/dompdf/lib/html5lib/Parser.php';
require_once 'dompdf/vendor/dompdf/dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
//require_once 'dompdf/vendor/dompdf/dompdf/lib/php-svg-lib/src/autoload.php';
require_once 'dompdf/vendor/dompdf/dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$data = file_get_contents("https://www.reviewschef.com/lims_system/user/");

$dompdf->loadHtml($data);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

?>