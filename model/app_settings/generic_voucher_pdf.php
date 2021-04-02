<?php 

include_once('../model.php');

require("../../classes/convert_amount_to_word.php");



define('FPDF_FONTPATH','../../classes/fpdf/font/');

//require('../../classes/fpdf/fpdf.php');

require('../../classes/mc_table.php');



$invoice_no = $_GET['invoice_no'];

$invoice_date = $_GET['invoice_date'];

$customer_id = $_GET['customer_id'];

$service_name = $_GET['service_name'];

$basic_cost1 = $_GET['basic_cost'];

$service_charge = $_GET['service_charge'];

$taxation_type = $_GET['taxation_type'];

$service_tax_per = $_GET['service_tax_per'];

$service_tax = $_GET['service_tax'];

$net_amount = $_GET['net_amount'];

$bank_name = $_GET['bank_name'];
$total_paid = $_GET['total_paid'];
$balance_amount = $_GET['balance_amount'];


$_SESSION['generated_by'] = $app_address.'        Contact : '.$app_contact_no;



$taxation_type = str_replace("_plus_", "+", $taxation_type);



if($taxation_type=="CGST+SGST"){

	$service_tax_per = $service_tax_per/2;

	$service_tax = $service_tax;	

}



$amount_in_word = $amount_to_word->convert_number_to_words($net_amount);

$net_amount1 = 0;
$net_amount1 =  $basic_cost1 + $service_charge  + $service_tax;

$basic_cost = number_format($basic_cost1,2);

$discount = number_format($discount,2);

$total_amount = number_format($total_amount,2);

$service_tax_per = number_format($service_tax_per,2);

//$service_tax = number_format($service_tax,2);

$net_amount = number_format($net_amount,2);

$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));

$sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Invoice' and active_flag ='Active'"));



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

$pdf->MultiCell(119, 8, "Customer Name : ". $sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name'] , 1);

$pdf->SetFont('Arial','',9);

if($sq_customer['type'] == 'Corporate'){ $company_name = '('.$sq_customer[company_name].')';}

else{ $company_name = '';}

$pdf->SetXY(129, 60);

$pdf->MultiCell(70, 8,"Type : ". $sq_customer['type'].$company_name , 1);








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

$pdf->MultiCell(30, 8,$basic_cost , 1,'R');



$y_pos = $pdf->getY();



$pdf->SetFont('Arial','',10);

$pdf->SetXY(129, $y_pos);

$pdf->MultiCell(40, 8, 'Service Charges', 1);



$pdf->SetXY(169, $y_pos);

$pdf->MultiCell(30, 8, $service_charge, 1,'R');



$y_pos = $pdf->getY();



if($taxation_type=="CGST+SGST"){



	$y_pos = $pdf->getY();



	$pdf->SetXY(129, $y_pos);

    $pdf->MultiCell(40, 8,$taxation_type.'('.$service_tax_per.'%)', 1);



	$pdf->SetXY(169, $y_pos);

	$pdf->MultiCell(30, 8, number_format($service_tax,2), 1,'R');

}

else{



	$y_pos = $pdf->getY();



	$pdf->SetXY(129, $y_pos);

	$pdf->MultiCell(40, 8,$taxation_type.'('.$service_tax_per.'%)', 1);



	$pdf->SetXY(169, $y_pos);

	$pdf->MultiCell(30, 8, number_format($service_tax,2), 1,'R');

}

$y_pos = $pdf->getY();
$pdf->SetFillColor(235);

$pdf->rect(129,$y_pos, 70, 8, 'F');

$pdf->SetFont('Arial','B',9);

$pdf->SetXY(129, $y_pos);

$pdf->MultiCell(40, 8, 'Net Invoice Amount', 1);

$pdf->SetXY(169, $y_pos);
$pdf->MultiCell(30, 8,number_format($net_amount1,2), 1,'R');


$y_pos = $pdf->getY();
$pdf->SetFillColor(235);

$pdf->rect(129,$y_pos, 70, 8, 'F');

$pdf->SetFont('Arial','B',9);

$pdf->SetXY(129, $y_pos);

$pdf->MultiCell(40, 8, 'Paid Amount', 1);

$pdf->SetXY(169, $y_pos);
$pdf->MultiCell(30, 8,number_format($total_paid,2), 1,'R');


$y_pos = $pdf->getY();
$pdf->SetFillColor(235);

$pdf->rect(129,$y_pos, 70, 8, 'F');

$pdf->SetFont('Arial','B',9);

$pdf->SetXY(129, $y_pos);

$pdf->MultiCell(40, 8, 'Balance Amount', 1);

$pdf->SetXY(169, $y_pos);
$pdf->MultiCell(30, 8,number_format($balance_amount,2), 1,'R');

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

$pdf->SetXY(93, $y_pos+31);

$pdf->MultiCell(40, 5, 'RECEIVER SIGNATURE',0);



$pdf->SetXY(159, $y_pos+31);

$pdf->MultiCell(110, 5, 'AUTHORIZED SIGNATORY',0);



$pdf->SetFont('Arial','',8);

$y_pos = $pdf->getY();

$pdf->SetXY(10, $y_pos+3);

$pdf->MultiCell(180, 5, 'This is a Computer generated document and does not require any signature.',0,'C');


$filename = $sq_customer['first_name'].'_'.$sq_customer['last_name'].'_Invoice'.'.pdf';
$pdf->Output($filename,'I');

ob_end_flush();

?>