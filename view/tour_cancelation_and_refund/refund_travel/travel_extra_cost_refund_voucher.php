<?php include "../../../model/model.php"; ?>
<?php

$refund_id = $_GET['refund_id'];

$sq_refund = mysql_fetch_assoc(mysql_query("select * from refund_travel_extra_amount where refund_id='$refund_id'"));
$refund_mode = $sq_refund['refund_mode'];
$refund_amount = $sq_refund['refund_amount'];
$tourwise_traveler_id = $sq_refund['tourwise_traveler_id'];


$sq = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_traveler_id'"));
$traveler_group_id = $sq['traveler_group_id'];


$cur_date = date("d-M-Y");


define('FPDF_FONTPATH','../../../classes/fpdf/font/');
require('../../../classes/fpdf/fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
//$pdf->Image('background.png', 0, 0, 500, 300);

$pdf->SetFont('Arial','',13);

$pdf->Cell( 100, 10, $pdf->Image($report_logo_small_url,15,10,80), 0, 0, 'R', false );

$pdf->Cell(70,30,'',1,'L');
$pdf->SetXY(115,15);
$pdf->Cell(19,5,'No :',0,'L');
$pdf->Cell(23,5,"GTER-".$refund_id,0,'L');
$pdf->SetXY(135,20);
$pdf->MultiCell(35,0, '',1,'L');
$pdf->SetXY(115,35);

$pdf->SetXY(115,25);
$pdf->Cell(23,5,'Date :',0,'L');
$pdf->Cell(23,5, $cur_date,0,'L');
$pdf->SetXY(135,30);
$pdf->MultiCell(35,0, '',1,'L');
$pdf->SetXY(115,35);



$pdf->SetXY(15,55);
$pdf->Cell(30,0,'Paid to',0,'L');
$pdf->Cell(300,0,'File No-'.$tourwise_traveler_id,0,'L');
$pdf->SetXY(35,58);
$pdf->Cell(160,0,'',1,'L');

$pdf->SetXY(15,65);
$pdf->Cell(30,0,'on A/C for',0,'L');
$pdf->Cell(300,0,'',0,'L');
$pdf->SetXY(40,68);
$pdf->Cell(155,0,'',1,'L');

$pdf->SetXY(15,75);
$pdf->Cell(30,0,'Rupees',0,'L');
$pdf->Cell(300,0,$refund_amount,0,'L');
$pdf->SetXY(35,78);
$pdf->Cell(160,0,'',1,'L');

$pdf->SetXY(15,85);
$pdf->Cell(85,0,'paid by Cash/ Check/ Net Transfer ',0,'L');
$pdf->Cell(300,0,$refund_mode,0,'L');
$pdf->SetXY(90,88);
$pdf->Cell(105,0,'',1,'L');

$pdf->SetXY(15,95);
$pdf->Cell(300,0,'Details of payment made ',0,'L');
$pdf->Cell(300,0,'',0,'L');
$pdf->SetXY(70,98);
$pdf->Cell(125,0,'',1,'L');


$pdf->SetXY(15,117);
$pdf->Cell( 10, 10, $pdf->Image("../../../images/ruppee_ico.jpg",15,115,10), 0, 0, 'R', false );
$pdf->Cell(30,0,$refund_amount,0,'L');
$pdf->SetXY(25,120);
$pdf->Cell(25,0,'',1,'L');

$pdf->SetXY(70,119);
$pdf->Cell(60,0,'Reciever Signature',0,'L');
$pdf->Cell(40,0,'For '.$app_name,0,'L');




  
$pdf->Output();
?>