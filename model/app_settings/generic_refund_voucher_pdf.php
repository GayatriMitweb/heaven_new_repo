<?php
ob_start();
include_once('../model.php');
require("../../classes/convert_amount_to_word.php");
define('FPDF_FONTPATH','../../classes/fpdf/font/');
require('../../classes/fpdf/fpdf.php');

ob_end_clean(); //    the buffer and never prints or returns anything.
ob_start();

$voucher_no = $_GET['v_voucher_no'];
$refund_date = $_GET['v_refund_date'];
$refund_to = $_GET['v_refund_to'];
$customer_id = $_GET['customer_id'];
$refund_id = $_GET['refund_id'];

$service_name = $_GET['v_service_name'];
$refund_amount = $_GET['v_refund_amount'];
$payment_mode = $_GET['v_payment_mode'];
$refund_date = get_date_user($refund_date);

$sq_credit_note = mysql_fetch_assoc(mysql_query("select * from credit_note_master where module_name='$service_name' and customer_id='$customer_id' and refund_id='$refund_id'"));
$credit_note_id = get_credit_note_id($sq_credit_note['id']);

if($payment_mode == 'Credit Note') { $refund_mode = 'Credit Note ('.$credit_note_id.')'; }
else{ $refund_mode = $payment_mode; }

$pdf=new FPDF();
$pdf->addPage();
$pdf->SetFont('Arial','',10);

$count = 0;
while($count<2){
	$count++;
	$offset = ($count=="1") ? 0 : 135;
	$pdf->SetFillColor(235);
	$pdf->rect(0, 0+$offset, 210, 25, 'F');
	$pdf->Image($admin_logo_url, 10, 4+$offset, 45, 17);

	$pdf->SetFont('Arial','',27);

	$pdf->SetXY(150, 10+$offset);

	$pdf->MultiCell(200, 5, 'VOUCHER');

	$pdf->SetFont('Arial','',17);

	$pdf->SetXY(10, 30+$offset);

	$pdf->Cell(200, 7, $app_name);

	$pdf->SetFont('Arial','',10);

	$pdf->SetXY(10, 38+$offset);

	$pdf->MultiCell(85, 4, $app_address,0);

	$pdf->SetFont('Arial','',10);

	$pdf->SetXY(10, 57+$offset);

	$pdf->MultiCell(200, 5, 'Contact : '.$app_contact_no."    Email : ".$app_email_id);

	$pdf->SetDrawColor(200, 200, 200);

	$pdf->SetFont('Arial','',12);

	$pdf->SetXY(130, 35+$offset);

	$pdf->MultiCell(30, 8, '  Voucher No.', 1);

	$pdf->SetXY(160, 35+$offset);

	$pdf->MultiCell(40, 8, $voucher_no, 1);

	$pdf->SetXY(130, 43+$offset);

	$pdf->MultiCell(30, 8, '  Date', 1);

	$pdf->SetXY(160, 43+$offset);

	$pdf->MultiCell(40, 8, $refund_date, 1);

	$pdf->SetXY(130, 51+$offset);

	$pdf->MultiCell(30, 8,'  '.get_tax_name().' No.', 1);

	$pdf->SetXY(160, 51+$offset);

	$pdf->MultiCell(40, 8, $service_tax_no, 1);

	$pdf->line(0, 65+$offset, 210, 65+$offset);

	$pdf->SetFont('Arial','',10);

	$pdf->SetXY(30, 70+$offset);

	$pdf->MultiCell(45, 7, '  Refund Paid To', 1);

	$pdf->SetXY(75, 70+$offset);

	$pdf->MultiCell(105, 7, $refund_to, 1);

	$pdf->SetXY(30, 77+$offset);

	$pdf->MultiCell(45, 7, '  Behalf Of Services', 1);

	$pdf->SetXY(75, 77+$offset);

	$pdf->MultiCell(105, 7, $service_name, 1);

	$pdf->SetXY(30, 84+$offset);

	$pdf->MultiCell(45, 7, '  Refund Amount', 1);

	$pdf->SetXY(75, 84+$offset);

	$pdf->MultiCell(105, 7, $refund_amount, 1);

	$pdf->SetXY(30, 91+$offset);

	$pdf->MultiCell(45, 7, '  Payment Mode', 1);

	$pdf->SetXY(75, 91+$offset);

	$pdf->MultiCell(105, 7, $refund_mode, 1);

	$pdf->SetFont('Arial','B',10);

	$pdf->SetXY(30, 102+$offset);

	$pdf->MultiCell(45, 7, 'Receiver Signature');

	$pdf->rect(26, 109+$offset, 40, 20);

	$pdf->SetFont('Arial','B',10);

	$pdf->SetXY(125, 102+$offset);

	$pdf->MultiCell(70, 7, 'For '.$app_name, 0, 'C');

	$pdf->rect(140, 109+$offset, 40, 20);
}

$filename = $refund_to.'_RefundVoucher'.'.pdf';
$pdf->Output($filename,'I');
ob_end_flush();
?>