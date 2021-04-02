<?php 

include_once('../model.php');

require("../../classes/convert_amount_to_word.php");



define('FPDF_FONTPATH','../../classes/fpdf/font/');

//require('../../classes/fpdf/fpdf.php');

require('../../classes/mc_table.php');



$payment_id_name = $_GET['payment_id_name'];
$payment_id = $_GET['payment_id'];
$receipt_date = $_GET['receipt_date'];
$booking_id = $_GET['booking_id'];
$customer_id = $_GET['customer_id'];
$booking_name = $_GET['booking_name'];
$travel_date = $_GET['travel_date'];
$payment_amount = $_GET['payment_amount'];
$transaction_id = $_GET['transaction_id'];
$payment_date = $_GET['payment_date'];
$payment_mode = $_GET['payment_mode'];
$bank_name = $_GET['bank_name'];
$confirm_by = $_GET['confirm_by'];
$receipt_type = $_GET['receipt_type'];





$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));

$sq_role = mysql_fetch_assoc(mysql_query("select emp_id from roles where id='$confirm_by'"));



if($confirm_by=='' || $confirm_by==0){

	$booking_by = $app_name;

}

else{

	$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$confirm_by'"));

	$booking_by = $sq_emp['first_name'].' '.$sq_emp['last_name'];

}

$sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Receipt' and title='Declaration'"));

ob_end_clean(); //    the buffer and never prints or returns anything.

ob_start(); 

$pdf=new PDF_MC_Table();

$pdf->addPage();



$_SESSION['generated_by'] = $app_address.'        Contact : '.$app_contact_no;



$pdf->SetDrawColor(240, 240, 242);



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

$pdf->SetXY(163, 12);

$pdf->Cell(105, 7, $receipt_type);



//logo

$pdf->Rect(10, 20 , 119, 21);

$pdf->Image($admin_logo_url, 13, 22, 46, 17);



$pdf->SetFont('Arial','B',8);

$pdf->SetXY(129, 20);

$pdf->MultiCell(30, 7, ' RECEIPT NO.', 1);



$pdf->SetXY(159, 20);

$pdf->MultiCell(40, 7,' '. $payment_id, 1);



$pdf->SetXY(129, 27);

$pdf->MultiCell(30, 7, ' DATE', 1);



$pdf->SetXY(159, 27);

$pdf->MultiCell(40, 7,' '. date('d-m-Y', strtotime($payment_date)), 1);



$pdf->SetXY(129, 34);

$pdf->MultiCell(30, 7,' '.get_tax_name(), 1);



$pdf->SetXY(159, 34);

$pdf->MultiCell(40, 7,' '. $service_tax_no, 1);



$pdf->SetFont('Arial','',9);



$pdf->SetXY(10, 41);

$pdf->MultiCell(119, 7, "BANK NAME : ".$bank_name_setting, 1);



$pdf->SetXY(129, 41);

$pdf->MultiCell(70, 7, "A/C NAME : ".$acc_name, 1);

$pdf->SetXY(10, 48);

$pdf->MultiCell(70, 7, "A/C NO : ".$bank_acc_no, 1);

$pdf->SetXY(80, 48);

$pdf->MultiCell(70, 7, "BRANCH : ".$bank_branch_name, 1);

$pdf->SetXY(150, 48);

$pdf->MultiCell(49, 7, "IFSC : ".$bank_ifsc_code, 1);



$pdf->SetXY(10, 55);

$pdf->MultiCell(189, 2, " ", 1);



$y_pos = $pdf->getY();

$pdf->SetFont('Arial','',9);

$pdf->SetXY(10, $y_pos);

$pdf->MultiCell(189, 8, "Received with thank from ", 1);

$pdf->SetFont('Arial','B',9);

$pdf->SetXY(55, $y_pos);

$pdf->Cell(189, 8,$sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name'],0);





$pdf->SetFont('Arial','',9);

$pdf->SetXY(10, 71);

$pdf->MultiCell(189, 8, "Residing at ", 1);

//$pdf->SetFont('Arial','B',9);

$pdf->SetXY(55, 71);

$pdf->Cell(189, 8,$sq_customer['address'],0);



$pdf->SetFont('Arial','',9);

$pdf->SetXY(10, 79);

$pdf->MultiCell(189, 8, "The sum of Rs. ", 1);

//$pdf->SetFont('Arial','B',9);

$pdf->SetXY(55, 79);

$pdf->Cell(189, 8,$payment_amount,0);



$pdf->SetFont('Arial','',9);

$pdf->SetXY(10, 87);

$pdf->MultiCell(189, 8, "Payment Mode ", 1);

//$pdf->SetFont('Arial','B',9);

$pdf->SetXY(55, 87);

$pdf->Cell(189, 8,$payment_mode,0);





$pdf->SetFont('Arial','',9);

$pdf->SetXY(10, 95);

$pdf->MultiCell(189, 8, "For Services ", 1);

//$pdf->SetFont('Arial','B',9);

$pdf->SetXY(55, 95);

$pdf->Cell(189, 8,$booking_name,0);





$y_pos = $pdf->getY();

$pdf->rect(10, $y_pos, 189, 20);



$y_pos = $pdf->getY();

$pdf->SetFillColor(235);

$pdf->SetFont('Arial','B',9);

$pdf->rect(10, $y_pos+10, 189, 8, 'F');

$pdf->SetXY(10, $y_pos+10);

$pdf->MultiCell(160, 8, "In Rupees :  ". $amount_to_word->convert_number_to_words($payment_amount), 1);



$y_pos = $pdf->getY();

$pdf->SetFont('Arial','',8);

//terms & condition rect

$pdf->rect(10,$y_pos, 119, 50);

// for rect

$pdf->rect(129,$y_pos, 70, 50);



$y_pos = $pdf->getY();

$pdf->SetFont('Arial','B',8);

$pdf->SetXY(10, $y_pos+2);

$pdf->MultiCell(40, 7, 'Declaration : ');



$pdf->SetXY(121, $y_pos+2);

$pdf->MultiCell(55, 7,'For '.strtoupper($app_name),'0','R');



$pdf->SetFont('Arial','',8);

$y_pos = $pdf->getY();

$pdf->SetXY(13, $y_pos);

$pdf->MultiCell(113, 6,$sq_terms_cond['terms_and_conditions']);



$y_pos = $pdf->getY();

$pdf->SetFont('Arial','',8);

$pdf->SetXY(93, $y_pos+30);

$pdf->MultiCell(40, 5, 'RECEIVER SIGNATURE',0);



$pdf->SetXY(159, $y_pos+30);

$pdf->MultiCell(110, 5, 'AUTHORIZED SIGNATORY',0);



$pdf->SetFont('Arial','',8);

$y_pos = $pdf->getY();

$pdf->SetXY(10, $y_pos+2);

$pdf->MultiCell(180, 5, 'This is a Computer generated document and does not require any signature.',0,'C');


$filename = $sq_customer['first_name'].'_'.$sq_customer['last_name'].'_Reciept'.'.pdf';
$pdf->Output($filename,'I');

ob_end_flush();

?>