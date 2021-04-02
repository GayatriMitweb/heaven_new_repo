<?php 
include_once('../../../../model/model.php');
require("../../../../classes/convert_amount_to_word.php");

define('FPDF_FONTPATH','../../../../classes/fpdf/font/');
require('../../../../classes/fpdf/fpdf.php');


$payment_id = $_GET['payment_id'];

$sq_payment_info = mysql_fetch_assoc(mysql_query("select * from forex_booking_payment_master where payment_id='$payment_id'"));
$booking_id = $sq_payment_info['booking_id'];

$sq_booking_info = mysql_fetch_assoc(mysql_query("select * from forex_booking_master where booking_id='$booking_id'"));

$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking_info[customer_id]'"));

$amount_in_word =  $amount_to_word->convert_number_to_words($sq_payment_info['payment_amount']);


$pdf=new FPDF();
$pdf->addPage();
$pdf->SetFont('Arial','',10);

$pdf->Image($forex_booking_receipt_url, 0, 0, 210, 280);

for($receipt_count = 0; $receipt_count<2; $receipt_count++){

$offset = ($receipt_count==0) ? 0 : 140;

$pdf->SetXY(170, 9+$offset);
$pdf->Cell(100, 7, get_forex_booking_payment_id($payment_id));

$pdf->SetXY(165, 15+$offset);
$pdf->Cell(100, 7, date('d-m-Y'));

$pdf->SetXY(80, 40+$offset);
$pdf->Cell(100, 7, $sq_customer_info['first_name'].' '.$sq_customer_info['middle_name'].' '.$sq_customer_info['last_name']);

$pdf->SetXY(56, 48+$offset);
$pdf->Cell(100, 7, $sq_customer_info['address']);

$pdf->SetXY(62, 56+$offset);
$pdf->Cell(100, 7, $amount_in_word);


$pdf->SetXY(44, 90+$offset);
$pdf->Cell(100, 7, $sq_payment_info['payment_amount']);

$pdf->SetXY(62, 95+$offset);
$pdf->Cell(100, 7, $sq_payment_info['transaction_id']);

$pdf->SetXY(50, 101+$offset);
$pdf->Cell(100, 7, date('d-m-Y', strtotime($sq_payment_info['payment_date'])));

$pdf->SetXY(50, 106+$offset);
$pdf->Cell(100, 7, $sq_payment_info['bank_name']);

//Footer Bank Details
$bank_details = "";
if($bank_acc_no!=""){
  $bank_details .= "A/C No:".$bank_acc_no;
}
if($other_bank_details!=""){
  $bank_details .= ", ".$other_bank_details;
}
$pdf->SetXY(30,136+$offset);
$pdf->Cell(175,0,$bank_details,0,'', 'R');


}

$pdf->Output();
?>