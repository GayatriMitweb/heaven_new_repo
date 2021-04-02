<?php
include "../../../../model/model.php";
$refund_id = $_GET['refund_id'];


$sq_refund = mysql_fetch_assoc(mysql_query("select * from hotel_booking_refund_master where refund_id='$refund_id'"));
$sq_visa_info = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$sq_refund[booking_id]'"));

$hotel_name = "";
$sq_refund_entries = mysql_query("select * from hotel_booking_refund_entries where refund_id='$refund_id'");
while($row_refund_entry = mysql_fetch_assoc($sq_refund_entries)){

	$sq_entry_info = mysql_fetch_assoc(mysql_query("select * from hotel_booking_entries where entry_id='$row_refund_entry[entry_id]'"));
	$sq_hotel_info = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$sq_entry_info[hotel_id]'"));
	$hotel_name .= $sq_hotel_info['hotel_name'].', ';
}
$hotel_name = trim($hotel_name, ", ");

define('FPDF_FONTPATH','../../../../classes/fpdf/font/');
require('../../../../classes/fpdf/fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();

$offset = 0;

for($loop_count=0; $loop_count<2; $loop_count++){

if($loop_count==1){ $offset = 140; }

$pdf->SetFont('Arial','',13);

$pdf->Image($report_logo_small_url,15,10+$offset,80);

$pdf->SetXY(110,13+$offset);
$pdf->Cell(70,30,'',1,'L');

$pdf->SetXY(115,21+$offset);
$pdf->Cell(19,5,'No :',0,'L');
$pdf->Cell(23,5,get_hotel_booking_refund_id($refund_id),0,'L');
$pdf->SetXY(135,26+$offset);
$pdf->MultiCell(35,0, '',1,'L');
$pdf->SetXY(115,37+$offset);

$pdf->SetXY(115,30+$offset);
$pdf->Cell(23,5,'Date :',0,'L');
$pdf->Cell(23,5, date('d-m-Y', strtotime($sq_refund['refund_date'])),0,'L');
$pdf->SetXY(135,35+$offset);
$pdf->MultiCell(35,0, '',1,'L');
$pdf->SetXY(115,35+$offset);


$pdf->SetFont('Arial','',11);
$pdf->SetXY(15,55+$offset);
$pdf->Cell(24,0,'Refund For',0,'L');
$pdf->Cell(300,0, $hotel_name,0,'L');
$pdf->SetXY(35,58+$offset);
$pdf->Cell(160,0,'',1,'L');
$pdf->SetFont('Arial','',13);

$pdf->SetXY(15,65+$offset);
$pdf->Cell(30,0,'on A/C for',0,'L');
$pdf->Cell(300,0,'',0,'L');
$pdf->SetXY(40,68+$offset);
$pdf->Cell(155,0,'',1,'L');

$pdf->SetXY(15,75+$offset);
$pdf->Cell(30,0,'Rupees',0,'L');
$pdf->Cell(300,0,$sq_refund['refund_amount'],0,'L');
$pdf->SetXY(35,78+$offset);
$pdf->Cell(160,0,'',1,'L');

$pdf->SetXY(15,85+$offset);
$pdf->Cell(85,0,'Paid by Cash/ Check/ Net Transfer ',0,'L');
$pdf->Cell(300,0,$sq_refund['refund_mode'],0,'L');
$pdf->SetXY(90,88+$offset);
$pdf->Cell(105,0,'',1,'L');

$pdf->SetXY(15,95+$offset);
$pdf->Cell(300,0,'Details of payment made ',0,'L');
$pdf->Cell(300,0,'',0,'L');
$pdf->SetXY(70,98+$offset);
$pdf->Cell(125,0,'',1,'L');


$pdf->Image("../../../../images/ruppee_ico.jpg",15,115+$offset,10);
$pdf->SetXY(24,118+$offset);
$pdf->Cell(30,0,$sq_refund['refund_amount'],0,'L');
$pdf->SetXY(25,120+$offset);
$pdf->Cell(25,0,'',1,'L');

$pdf->SetXY(70,119+$offset);
$pdf->Cell(60,0,'Reciever Signature',0,'L');
$pdf->Cell(40,0,'For '.$app_name,0,'L');


}
  
$pdf->Output();
?>