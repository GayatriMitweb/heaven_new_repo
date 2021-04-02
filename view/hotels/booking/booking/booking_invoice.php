<?php 
include_once('../../../../model/model.php');
require("../../../../classes/convert_amount_to_word.php");

define('FPDF_FONTPATH','../../../../classes/fpdf/font/');
require('../../../../classes/fpdf/fpdf.php');

$booking_id = $_GET['booking_id'];

$sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$booking_id'"));
$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_hotel[customer_id]'"));


$amount_in_word =  $amount_to_word->convert_number_to_words($sq_hotel['total_fee']);


$pdf=new FPDF();
$pdf->addPage();
$pdf->SetFont('Arial','',10);

$pdf->Image($report_logo_url, 5, 5, 198, 30);


$pdf->SetXY(10, 43);
$pdf->Cell(50, 7, 'Customer Name', 1, '', 'L');
$pdf->SetXY(60, 43);
$pdf->Cell(140, 7, $sq_customer['first_name'].' '.$sq_customer['last_name'], 1, '', 'L');

$pdf->SetXY(10, 50);
$pdf->Cell(50, 7, 'Address', 1, '', 'L');
$pdf->SetXY(60, 50);
$pdf->Cell(140, 7, $sq_customer['address'], 1, '', 'L');

$pdf->SetXY(10, 65);
$pdf->Cell(30, 7, 'Sr No', 1, '', 'L');
$pdf->SetXY(40, 65);
$pdf->Cell(100, 7, 'Perticulars', 1, '', 'L');
$pdf->SetXY(140, 65);
$pdf->Cell(60, 7, 'Amount', 1, '', 'L');

$pdf->SetXY(10, 72);
$pdf->Cell(30, 7, '1', 1, '', 'L');
$pdf->SetXY(40, 72);
$pdf->Cell(100, 7, 'Hotel Booking Costing', 1, '', 'L');
$pdf->SetXY(140, 72);
$pdf->Cell(60, 7, $sq_hotel['booking_amount'], 1, '', 'L');

$pdf->SetXY(10, 85);
$pdf->Cell(30, 7, 'Total Amount: '.$amount_in_word, 0, '', 'L');

$pdf->SetXY(10, 95);
$pdf->Cell(30, 7, 'Tax Registration No : ', 0, '', 'L');

$pdf->SetXY(10, 110);
$pdf->Cell(30, 7, 'For '.$app_name, 0, '', 'L');

$pdf->SetXY(10, 130);
$pdf->Cell(30, 7, 'Proprietor', 0, '', 'L');



$pdf->Output();
?>