<?php
session_start();
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	echo $_GET['invoice_id'];
	$invoiceValues = $invoice->getInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);		
}
$invoiceDate = date("d M,Y", strtotime($invoiceValues['order_date']));


$path = 'images/logo/'.$_SESSION['logo'];

$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);


$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

$output ='';
$output .= '
<style>html,body{font-family:sans-serif} h1{margin-bottom:100px;color:'.$_SESSION['color'].'}.tops{vertical-align: text-bottom}h1{vertical-align:top !important} #invoice{max-width:800px;margin:0 auto}#billship,#company,#items{width:100%;border-collapse:collapse}#company td,#billship td,#items td,#items th{padding:15px}#company,#billship{margin-bottom:30px}#company img{max-width:180px;height:auto}#bigi{font-size:28px;color:'.$_SESSION['color'].'}#billship{background:'.$_SESSION['color'].';color:#fff}#billship td{width:33%}#items th{text-align:left;border-top:2px solid '.$_SESSION['color'].';border-bottom:2px solid '.$_SESSION['color'].'}#items td{border-bottom:1px solid '.$_SESSION['color'].'}.idesc{color:'.$_SESSION['color'].'}.ttl{font-weight:700}.right{text-align:right}#notes{margin-top:30px;font-size:.95em}</style>
</style>

<div id="invoice">
	<table id="company" width="85%"  cellpadding="5" >
		<tbody>
			<tr>
				<td width="47%">';
					if(empty($_SESSION['logo'])) {
						$output .= '<h1>' . ucfirst($_SESSION['company_name']) . '</h1>';
					}else{
						$output .= '<img src="'.$base64.'" width="150" height="150"/>';
					}

$output .= '
				</td>
				<td class="right " width="50%">
					<span>'.ucfirst($_SESSION['company_name']).'</span><br />
					<span>'.ucfirst($_SESSION['address']).'</span><br />
					<span>Phone: '.$_SESSION['mobile'].'</span><br />
					<span>'.$_SESSION['email'].'</span>
				</td>
			</tr>
		</tbody>
	</table>
	
	<table id="billship">
		<tbody>
			<tr>
				<td>
					<strong>BILL TO</strong>
					<br>'.$invoiceValues['order_receiver_name'].'<br>'.$invoiceValues['order_receiver_address'].'<br>
				</td>
				<td>
					<strong>SHIP TO</strong>
					<br>'.$invoiceValues['order_receiver_name'].'<br>'.$invoiceValues['order_receiver_address'].'<br>
				</td>
				<td>
					<strong>Invoice #:</strong> CB-'.$invoiceValues['order_id'].'<br>
					<strong>DOP:</strong> '.$invoiceDate.'<br>
					<strong>P.O. #:</strong> CB-'.$invoiceValues['order_id'].'<br>
					<strong>Due Date:</strong> '.$invoiceDate.'<br>
				</td>
			</tr>
		</tbody>
	</table>
	<table id="items">
		<tbody>
			<tr>
				<th>Sr No.</th>
				<th>Item Code</th>
				<th>Item Name</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Actual Amt.</th>
				</tr>';
$count = 0;
foreach($invoiceItems as $invoiceItem) {
	$count++;
	$output .= '
		
				<tr>
				<td>
					'.$count.'
				</td>
				<td>
					'.$invoiceItem["item_code"].'
				</td>
				<td>
					'.$invoiceItem["item_name"].'
				</td>
				<td>
					'.$invoiceItem["order_item_quantity"].'
				</td>
				<td>
					'.$invoiceItem["order_item_price"].'
				</td>
				<td>
					'.$invoiceItem["order_item_final_amount"].'
				</td>
			</tr>
			';
}
$output .= '
			<tr class="ttl">
				<td class="right" colspan="5">
					SUB-TOTAL
				</td>
				<td>
					'.$invoiceValues['order_total_before_tax'].'
				</td>
			</tr>
			<tr class="ttl">
				<td class="right" colspan="5">
					Tax Rate :
				</td>
				<td>
					'.$invoiceValues['order_tax_per'].'
				</td>
			</tr>
			<tr class="ttl">
				<td class="right" colspan="5">
					Tax Amount:
				</td>
				<td>
					'.$invoiceValues['order_total_tax'].'
				</td>
			</tr>
			<tr class="ttl">
				<td class="right" colspan="5">
					Total:
				</td>
				<td>
					'.$invoiceValues['order_total_after_tax'].'
				</td>
			</tr>
			
			<tr class="ttl">
				<td class="right" colspan="5">
					Amount Paid:
				</td>
				<td>
					'.$invoiceValues['order_amount_paid'].'
				</td>
			</tr>
			
			<tr class="ttl">
				<td class="right" colspan="5">
					Amount Due:
				</td>
				<td>
					'.$invoiceValues['order_total_amount_due'].'
				</td>
			</tr>
	</tbody>
</table>
<div></div>
</div>';


// create pdf of invoice	
$invoiceFileName = 'Invoice-'.$invoiceValues['order_id'].'.pdf';
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml(html_entity_decode($output));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
?>   
