<?php include "../../model/model.php"; ?>
<?php

$refund_id = $_GET['refund_id'];

$sq = mysql_fetch_assoc( mysql_query("select * from refund_traveler_cancelation where refund_id='$refund_id'") );
$refund_amount = $sq['total_refund'];
$refund_mode = $sq['refund_mode'];
$traveler_id = $sq['traveler_id'];
$date = $sq['refund_date'];
$yr = explode("-", $date);
$year =$yr[0];

$sq_traveler = mysql_fetch_assoc( mysql_query( "select m_honorific, first_name, last_name from travelers_details where traveler_id='$traveler_id'" ) );

$traveler_name = $sq_traveler['m_honorific'].' '.$sq_traveler['first_name'].' '.$sq_traveler_query['last_name'];
$first_time = true;

$sq = mysql_query("select traveler_id from refund_traveler_cancalation_entries where refund_id='$refund_id'");
while($row = mysql_fetch_assoc($sq))
{
	$traveler_name_sq = mysql_fetch_assoc(mysql_query("select m_honorific, first_name, last_name from travelers_details where traveler_id='$row[traveler_id]'"));
	if($first_time == true)
	{	
	 $first_time = false;
	 $traveler_name = $traveler_name." ".$traveler_name_sq['m_honorific']." ".$traveler_name_sq['first_name']." ".$traveler_name_sq['last_name'];
	} 
	else
	{
		$traveler_name = $traveler_name.", ".$traveler_name_sq['m_honorific']." ".$traveler_name_sq['first_name']." ".$traveler_name_sq['last_name'];	
	}	
}
	


$cur_date = date("d-M-Y");


define('FPDF_FONTPATH','../../classes/fpdf/font/');
require('../../classes/fpdf/fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
//$pdf->Image('background.png', 0, 0, 500, 300);

$offset = 0;

for($loop_count=0; $loop_count<2; $loop_count++){

if($loop_count==1){ $offset = 140; }

$pdf->SetFont('Arial','',13);

$pdf->Image($report_logo_small_url,15,10+$offset,80);

$pdf->SetXY(110,13+$offset);
$pdf->Cell(70,30,'',1,'L');

$pdf->SetXY(115,21+$offset);
$pdf->Cell(19,5,'No :',0,'L');
$pdf->Cell(23,5,get_group_booking_traveler_refund_id($refund_id,$year),0,'L');
$pdf->SetXY(135,26+$offset);
$pdf->MultiCell(35,0, '',1,'L');
$pdf->SetXY(115,37+$offset);

$pdf->SetXY(115,30+$offset);
$pdf->Cell(23,5,'Date :',0,'L');
$pdf->Cell(23,5, $cur_date,0,'L');
$pdf->SetXY(135,35+$offset);
$pdf->MultiCell(35,0, '',1,'L');
$pdf->SetXY(115,35+$offset);


$pdf->SetFont('Arial','',11);
$pdf->SetXY(15,55+$offset);
$pdf->Cell(17,0,'Paid to',0,'L');
$pdf->Cell(300,0, $traveler_name,0,'L');
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
$pdf->Cell(300,0,$refund_amount,0,'L');
$pdf->SetXY(35,78+$offset);
$pdf->Cell(160,0,'',1,'L');

$pdf->SetXY(15,85+$offset);
$pdf->Cell(85,0,'paid by Cash/ Check/ Net Transfer ',0,'L');
$pdf->Cell(300,0,$refund_mode,0,'L');
$pdf->SetXY(90,88+$offset);
$pdf->Cell(105,0,'',1,'L');

$pdf->SetXY(15,95+$offset);
$pdf->Cell(300,0,'Details of payment made ',0,'L');
$pdf->Cell(300,0,'',0,'L');
$pdf->SetXY(70,98+$offset);
$pdf->Cell(125,0,'',1,'L');


$pdf->Image("../../images/ruppee_ico.jpg",15,115+$offset,10);
$pdf->SetXY(24,118+$offset);
$pdf->Cell(30,0,$refund_amount,0,'L');
$pdf->SetXY(25,120+$offset);
$pdf->Cell(25,0,'',1,'L');

$pdf->SetXY(70,119+$offset);
$pdf->Cell(60,0,'Reciever Signature',0,'L');
$pdf->Cell(40,0,'For '.$app_name,0,'L');




}
  
$pdf->Output();
?>