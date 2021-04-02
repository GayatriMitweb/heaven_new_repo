<?php 
include_once('../../../../model/model.php');
define('FPDF_FONTPATH','../../../../classes/fpdf/font/');
require('../../../../classes/mc_table.php');

ob_end_clean(); //    the buffer and never prints or returns anything.
ob_start();

$pdf=new PDF_MC_Table();
$pdf->SetDrawColor(148, 148, 148);
$pdf->SetTextColor(50,50,50);
$pdf->SetLineWidth(0.1);

$pdf->SetFont('Arial','',12);

for($i=1; $i<=6; $i++){
    $pdf->AddPage();
    $pdf->SetXY(0,0);
   // $pdf->Cell( 100, 10, $pdf->Image("../../../../images/terms-conditions/terms-conditions-".$i.".jpg",5,5,200,265), 0, 0, 'C', false );
}

$pdf->Output();
ob_end_flush();
?>