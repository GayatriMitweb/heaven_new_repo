<?php include "../../../../../model/model.php";?>
<?php
global $app_cancel_pdf,$theme_color;
$quotation_id = $_GET['quotation_id'];
$sq_quotation = mysql_fetch_assoc(mysql_query("select * from car_rental_quotation_master where quotation_id='$quotation_id'"));
$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

if($sq_emp_info['first_name']==''){
	$emp_name = 'Admin';
}
else{
	$emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
}

$_SESSION['generated_by'] = $app_address.'        Contact : '.$app_contact_no;

define('FPDF_FONTPATH','../../../../../classes/fpdf/font/');
//require('../../../../../classes/fpdf/fpdf.php');
require('../../../../../classes/mc_table.php');
require('../../../../../classes/rounded_rect2.php'); 


$pdf=new PDF_MC_Table();
$pdf->AddPage();
$pdf->setTextColor(40,35,35);

$pdf->Image($transport_service_voucher2,8,0,8,297);
$pdf->SetXY(0,0);
$pdf->SetDrawColor(242,242,242);
$pdf->Image($admin_logo_url, 30, 8, 46, 17);

$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(51,203,204);
$pdf->rect(149,7,58,12,F);
$pdf->SetXY(161, 7.5);
$pdf->Cell(58, 12, 'QUOTATION',0,'L');

//$pdf->SetXY(155, 8);
$pdf->Image($quotation_icon,150,8,10,11);

$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(40,35,35);
$pdf->SetXY(151, 28);
$pdf->Cell(58, 12,"QUOTATION ID : ".get_quotation_id($quotation_id),0,'L');

$pdf->setXY(28,$y_pos);
$pdf->SetFillColor(255);
$pdf->RoundedRect(28, 38, 179, 30, 2, '1234', 'DF');

$pdf->SetFont('Arial','',20);
$pdf->SetTextColor(51,203,204);
$pdf->SetXY(30, 43);
$pdf->Cell(30, 8, strtoupper($app_name));
$pdf->Line(145,68,145,38);
$pdf->SetTextColor(40,35,35);

$pdf->SetFont('Arial','B',8);
$pdf->setXY(30, 58);
$pdf->cell(190, 5, "A :  ", 0, 0);
$pdf->setXY(148, 43);
$pdf->cell(192, 7, "E : ", 0, 0);
$pdf->setXY(148 , 51);
$pdf->cell(190, 7, "P : ", 0, 0);
$pdf->setXY(148, 59);
$pdf->cell(190, 7, "L : ", 0, 0);

$pdf->SetXY(35, 58);
$pdf->MultiCell(75, 5, $app_address);
$pdf->setXY(153, 43);
$pdf->cell(190, 7, $app_email_id, 0, 0);

$pdf->setXY(153 , 51);
$pdf->cell(190, 7, $app_contact_no, 0, 0);

$pdf->setXY(153, 59);
$pdf->cell(190, 7, $app_landline_no, 0, 0);

$pdf->SetFillColor(255);
$pdf->RoundedRect(28, 75, 179, 12, 2, '1234', 'DF');

$pdf->SetFont('Arial','B',9);
$pdf->setXY(30, 78);
$pdf->cell(190, 7, 'CUSTOMER NAME : ', 0, 0);

$pdf->setXY(62 , 78);
$pdf->cell(190, 7, $sq_quotation['customer_name'], 0, 0);

$pdf->setXY(128, 78);
$pdf->cell(190, 7, 'EMAIL ID : ', 0, 0);
$pdf->Line(120,75,120,87);

$pdf->setXY(145, 78);
$pdf->cell(190, 7, $sq_quotation['email_id'], 0, 0);

$pdf->SetFont('Arial','B',9);
$pdf->setXY(28, 93);
$pdf->Multicell(35, 8, 'No Of Pax : '.$sq_quotation['total_pax'], 1, 1);
$pdf->setXY(63, 93);
$pdf->Multicell(53, 8, 'Travelling Date : '.get_date_user($sq_quotation['traveling_date']), 1, 1);
$pdf->setXY(116, 93);
$pdf->Multicell(50, 8, 'Total Days : '.$sq_quotation['days_of_traveling'], 1, 1);
$pdf->setXY(166, 93);
$pdf->Multicell(40, 8, 'Vehicle Type : '.$sq_quotation['vehicle_type'], 1, 1);
$pdf->setXY(28, 101);
$pdf->Multicell(35, 8, 'Route: '.$sq_quotation['route'], 1, 1);
$pdf->setXY(63, 101);
$pdf->Multicell(53, 8, 'From Date : '.get_date_user($sq_quotation['from_date']), 1, 1);
$pdf->setXY(116, 101);
$pdf->Multicell(50, 8, 'To Date : '.get_date_user($sq_quotation['to_date']), 1, 1);
$pdf->setXY(166,101);
$pdf->Multicell(40, 8, 'Trip Type : '.$sq_quotation['trip_type'], 1, 1);

$y_pos = $pdf->getY()+11;
$pdf->SetTextColor(40,35,35);
$pdf->SetFont('Arial','',9);
$pdf->setXY(28,$y_pos);
$pdf->Multicell(86, 10, 'Vehicle Name' , 1, 1);
$pdf->SetFont('Arial','',9);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10,'  '.$sq_quotation['vehicle_name'], 1, 1);

$y_pos = $pdf->getY();
$pdf->setXY(28, $y_pos);
$pdf->Multicell(86, 10, 'Places To Visit', 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10, '  '.$sq_quotation['places_to_visit'], 1, 1);

$y_pos = $pdf->getY();
$pdf->setXY(28, $y_pos);
$pdf->rect(28, $y_pos, 179,10, 'F');
$pdf->Multicell(86, 10, 'Daily KM', 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10, '  '.$sq_quotation['daily_km'], 1, 1);

$y_pos = $pdf->getY();
$pdf->setXY(28, $y_pos);
$pdf->Multicell(86, 10, 'Extra KM Cost', 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10, '  '.$sq_quotation['extra_km_cost'], 1, 1);

$y_pos = $pdf->getY();
$pdf->setXY(28, $y_pos);
$pdf->rect(28, $y_pos, 179,10, 'F');
$pdf->Multicell(86, 10, 'Extra Hr Cost', 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10, '  '.$sq_quotation['extra_hr_cost'], 1, 1);

//costing informaion

$y_pos = $pdf->getY()+10;
$pdf->setXY(28, $y_pos);
$pdf->SetFillColor(51,203,204);
$pdf->rect(28,$y_pos,179,11,F);
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(86, 10, 'COSTING' , 0, 0);

$pdf->SetFont('Arial','',9);
$y_pos = $pdf->getY()+11;
$pdf->SetTextColor(40,35,35);
$pdf->setXY(28,$y_pos);
$pdf->Multicell(86, 10, 'Subtotal' , 1, 1);
$pdf->SetFont('Arial','',9);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10,'  '.number_format($sq_quotation['subtotal']+$sq_quotation['markup_cost'],2), 1, 1);

$y_pos = $pdf->getY();
$pdf->setXY(28, $y_pos);
$pdf->Multicell(86, 10, 'Tax', 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10, '  '.number_format($sq_quotation['service_tax_subtotal'],2), 1, 1);

$y_pos = $pdf->getY();
$pdf->setXY(28,$y_pos);
$pdf->Multicell(86, 10, 'Permit' , 1, 1);
$pdf->SetFont('Arial','',9);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10,'  '.$sq_quotation['permit'], 1, 1);

$y_pos = $pdf->getY();
$pdf->setXY(28, $y_pos);
$pdf->Multicell(86, 10, 'Toll Parking', 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10, '  '.number_format($sq_quotation['toll_parking'],2), 1, 1);

$y_pos = $pdf->getY();
$pdf->setXY(28, $y_pos);
$pdf->Multicell(86, 10, 'Driver Allowance', 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10, '  '.number_format($sq_quotation['driver_allowance'],2), 1, 1);

$y_pos = $pdf->getY();
$pdf->setXY(28, $y_pos);
$pdf->SetFillColor(235);
$pdf->SetFont('Arial','B',9);
$pdf->rect(28, $y_pos, 179,10, 'F');
$pdf->Multicell(86, 10, 'QUOTATION COST', 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10, '  '.number_format($sq_quotation['total_tour_cost'] ,2), 1, 1);

$pdf->AddPage($pdf->CurOrientation);
$pdf->Image($transport_service_voucher2,8,0,8,297);
///// Bank details ///////
$pdf->SetFillColor(51,203,204);
	$y_pos = $pdf->getY();
	$y_pos+=8;
	$pdf->rect(28,$y_pos-1,179,11,F);

	$y_pos = $pdf->getY()+10;
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(255,255,255);
	$y_pos = $pdf->getY();
	$y_pos+=8;
	$pdf->SetXY(28,$y_pos);
	$pdf->Cell(86, 10, 'BANK DETAILS' , 0, 0);
$pdf->SetTextColor(40,35,35);
$pdf->SetFont('Arial','',9);
//Adding new page if end of page is found
        if($pdf->GetY()+20>$pdf->PageBreakTrigger)
        {
        	$pdf->AddPage($pdf->CurOrientation);
        	$pdf->Image($transport_service_voucher2,8,0,8,297);
        }
        
$y_pos = $pdf->getY();
$y_pos+=10;
$pdf->setXY(28, $y_pos);
$pdf->Multicell(86, 10, 'BANK NAME  : '.$bank_name_setting , 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10,'A/C NAME  : '.$acc_name, 1, 1);

$y_pos = $pdf->getY();
//$y_pos+=1;
$pdf->setXY(28, $y_pos);
$pdf->Multicell(86, 10, 'A/C NO           : '.$bank_acc_no, 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10, 'BRANCH    : '.$bank_branch_name, 1, 1);

$y_pos = $pdf->getY();
//$y_pos+=1;
$pdf->setXY(28, $y_pos);
$pdf->Multicell(86, 10, 'IFSC               : '.$bank_ifsc_code, 1, 1);
  
  
$y_pos = $pdf->getY()+10;
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(40,35,35);
$pdf->SetXY(120,$y_pos);
$pdf->Cell(50, 10, 'CREATED BY : ', 0, 0,'R');

$pdf->SetFont('Arial','',9);
$pdf->SetXY(155,$y_pos);
$pdf->Cell(30, 10, $emp_name, 0, 0,'R');

$pdf->Output();

?>