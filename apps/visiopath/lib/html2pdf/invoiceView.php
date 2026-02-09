<?php
//	ob_start();
	 $Id = $_GET['id'];
	$type = $_GET['type'];
	
	
	define("REQUEST", "external"); 
	include('index.php');
    ob_end_clean();
    $CI =& get_instance();
    $CI->load->library('session'); //if it's not autoloaded in your CI setup
	if(empty($CI->session->userdata('id'))){ 
		echo "Please login to view this invoice <a href='/'>Click here</a>";
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
    ob_start();
	
	if($type == "doctor"){
	 	 $content = file_get_contents(base_url()."doctor/viewInvoicePDF/".$Id."/");
	}elseif($type == "hospital"){
		  $content = file_get_contents(base_url()."hospital/viewInvoicePDF/".$Id."/");
	}
	//$content = ob_get_clean();
	$content = preg_replace("/<script[^>]*?>.*?<\/script>/si", "", $content);
	//$content = ob_get_clean();
    $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', 3);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
	$html2pdf->pdf->SetTitle('Invoice Detail');
    $html2pdf->output('Invoice'.$Id.'.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
