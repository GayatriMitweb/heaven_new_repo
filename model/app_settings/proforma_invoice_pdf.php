<?php 

include_once('../../model/model.php');

require("../../classes/convert_amount_to_word.php");



define('FPDF_FONTPATH','../../classes/fpdf/font/');

//require('../../classes/fpdf/fpdf.php');

require('../../classes/mc_table.php');


$for = $_GET['for'];
$invoice_no = $_GET['invoice_no'];
$invoice_date = $_GET['invoice_date'];
$customer_name = $_GET['customer_id'];
$service_name = $_GET['service_name'];
$basic_cost = $_GET['basic_cost'];
$service_tax = $_GET['service_tax'];
$net_amount = $_GET['net_amount'];
$travel_cost = $_GET['travel_cost'];


$_SESSION['generated_by'] = $app_address.'        Contact : '.$app_contact_no;
$amount_in_word = $amount_to_word->convert_number_to_words($net_amount);

$service_tax1 = number_format($service_tax,2);
$basic_cost1 = number_format($basic_cost,2);
$travel_cost1 = number_format($travel_cost,2);

$sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Invoice' and 	active_flag ='Active'"));



ob_end_clean(); //    the buffer and never prints or returns anything.

ob_start(); 

$pdf=new PDF_MC_Table();

//$pdf=new FPDF();

$pdf->addPage();



$pdf->SetDrawColor(242,242,242);

$pdf->SetTextColor(40,35,35);



$y_pos = $pdf->getY();

$pdf->Rect(5, 5 , 199, 287);

$pdf->Rect(10, 10 , 189, 10);



//company name

$pdf->SetFont('Arial','B',10);

$pdf->SetXY(13, 12);

$pdf->SetFillColor(235);

$pdf->rect(10, 11, 189, 8, 'F');

$pdf->Cell(200, 7, strtoupper($app_name));



//Service name

$pdf->SetFont('Arial','B',10);

$pdf->SetXY(165, 12);

$pdf->Cell(105, 7, $service_name);



//logo

$pdf->Rect(10, 20 , 119, 24);

$pdf->Image($admin_logo_url, 13, 22, 50, 20);



$pdf->SetFont('Arial','B',8);

$pdf->SetXY(129, 20);

$pdf->MultiCell(30, 8, ' INVOICE NO.', 1);



$pdf->SetXY(159, 20);

$pdf->MultiCell(40, 8,' '. $invoice_no, 1);



$pdf->SetXY(129, 28);

$pdf->MultiCell(30, 8, ' DATE', 1);



$pdf->SetXY(159, 28);

$pdf->MultiCell(40, 8,' '. $invoice_date, 1);



$pdf->SetXY(129, 36);

$pdf->MultiCell(30, 8, ' '.get_tax_name(), 1);



$pdf->SetXY(159, 36);

$pdf->MultiCell(40, 8,' '. $service_tax_no, 1);



$pdf->SetFont('Arial','',9);

$pdf->SetXY(10, 44);

$pdf->MultiCell(119, 8, "BANK NAME : ".$bank_name_setting, 1);



$pdf->SetXY(129, 44);

$pdf->MultiCell(70, 8, "A/C NAME : ".$acc_name, 1);


$pdf->SetXY(10, 52);

$pdf->MultiCell(70, 8, "A/C NO : ".$bank_acc_no, 1);

$pdf->SetXY(80, 52);
$pdf->MultiCell(70, 8, "BRANCH : ".$bank_branch_name, 1);

$pdf->SetXY(150, 52);

$pdf->MultiCell(49, 8, "IFSC : ".$bank_ifsc_code, 1);


$pdf->SetFont('Arial','B',9);

$pdf->SetXY(10, 60);

$pdf->MultiCell(119, 8, "Customer Name : ". $customer_name, 1);




$y_pos = $pdf->getY();

$pdf->SetXY(70, $y_pos);

$pdf->SetFillColor(235);

$pdf->SetFont('Arial','B',10);

$pdf->rect(129,$y_pos, 70, 8, 'F');

$pdf->SetXY(129, $y_pos);

$pdf->MultiCell(70, 8, "Invoice Amount  " , 1);



$y_pos = $pdf->getY();



$pdf->SetFont('Arial','',10);

$pdf->SetXY(129, $y_pos);

$pdf->MultiCell(40, 8, 'Basic Amount', 1);



$pdf->SetXY(169, $y_pos);

$pdf->MultiCell(30, 8,$basic_cost1 , 1,'R');



$y_pos = $pdf->getY();
$y_pos = $pdf->getY();


$y_pos = $pdf->getY();
$pdf->SetXY(129, $y_pos);
$pdf->MultiCell(40, 8,'Tax', 1);

$pdf->SetXY(169, $y_pos);
$pdf->MultiCell(30, 8, $service_tax1, 1,'R');

if($for == 'package'){
$y_pos = $pdf->getY();
$pdf->SetXY(129, $y_pos);
$pdf->MultiCell(40, 8,'Travel + Visa + Guide', 1);

$pdf->SetXY(169, $y_pos);
$pdf->MultiCell(30, 8, $travel_cost1, 1,'R');
}

$y_pos = $pdf->getY();

$pdf->SetFillColor(235);

$pdf->rect(129,$y_pos, 70, 8, 'F');

$pdf->SetFont('Arial','B',9);

$pdf->SetXY(129, $y_pos);

$pdf->MultiCell(40, 8, 'Net Invoice Amount', 1);



$pdf->SetXY(169, $y_pos);

$pdf->MultiCell(30, 8,number_format($net_amount,2), 1,'R');



$y_pos = $pdf->getY();



$pdf->SetFillColor(235);

$pdf->rect(10, $y_pos, 189, 8, 'F');



$pdf->SetFont('Arial','B',9);



$pdf->MultiCell(189, 8, "In Rupees :  ". $amount_in_word , 1);



$y_pos = $pdf->getY();

$pdf->SetFont('Arial','',8);

//terms & condition rect

$pdf->rect(10,$y_pos, 119, 50);

// for rect

$pdf->rect(129,$y_pos, 70, 50);



$pdf->SetFont('Arial','B',8);

$pdf->SetXY(10, $y_pos+1);

$pdf->MultiCell(40, 7, 'Terms & Conditions : ');



$pdf->SetXY(135, $y_pos+1);

$pdf->MultiCell(55, 7,'For '.strtoupper($app_name),'0','C');



$pdf->SetFont('Arial','',8);

$y_pos = $pdf->getY();

$pdf->SetXY(13, $y_pos);

$pdf->MultiCell(113, 6,$sq_terms_cond['terms_and_conditions']);



$y_pos = $pdf->getY();

$pdf->SetFont('Arial','',8);

$pdf->SetXY(93, $y_pos+25);

$pdf->MultiCell(40, 5, 'RECEIVER SIGNATURE',0);



$pdf->SetXY(159, $y_pos+25);

$pdf->MultiCell(110, 5, 'AUTHORIZED SIGNATORY',0);



$pdf->SetFont('Arial','',8);

$y_pos = $pdf->getY();

$pdf->SetXY(10, $y_pos+3);

$pdf->MultiCell(180, 5, 'This is a Computer generated document and does not require any signature.',0,'C');

$filename = $sq_customer['first_name'].'_'.$sq_customer['last_name'].'_Invoice'.'.pdf';
$pdf->Output($filename,'I');

ob_end_flush()

?>