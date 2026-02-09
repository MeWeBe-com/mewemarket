<?php

	$Id = $_GET['id'];
	define("REQUEST", "external"); 
	include('index.php');
    ob_end_clean();
    $CI =& get_instance();
    $CI->load->library('session'); //if it's not autoloaded in your CI setup
	if(empty($CI->session->userdata('id'))){ 
		echo "Please login to view this report <a href='/'>Click here</a>";
		exit; 
	}
	 
	
/**
 * Html2Pdf Library - example
 *
 * HTML => PDF converter
 * distributed under the OSL-3.0 License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2017 Laurent MINGUET
 */
require_once dirname(__FILE__).'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
   
    //include dirname(__FILE__).'/res/example03.php';
    //$content = ob_get_clean();
	
	
	$content = file_get_contents(base_url()."/hospital/ViewReportPDF/".$Id."/");
	
    $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', 3);
	$title_arr = explode("pagetitle=",$content);
	$title_arr = explode("pagetitleClosed",$title_arr[1]);
	$title = $title_arr[0];
	$html2pdf->pdf->SetTitle($title);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);

    $html2pdf->output('ViewReportPDF'.$title.'.pdf');

    
} catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
