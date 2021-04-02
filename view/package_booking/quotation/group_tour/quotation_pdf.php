<?php include "../../../../model/model.php";?>
<?php
global $app_cancel_pdf,$theme_color;
$quotation_id = $_GET['quotation_id'];
$sq_quotation = mysql_fetch_assoc(mysql_query("select * from group_tour_quotation_master where quotation_id='$quotation_id'"));
$sq_package_program = mysql_query("select * from group_tour_program where tour_id ='$sq_quotation[tour_group_id]'");
$sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$sq_quotation[tour_group_id]'"));
$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

if($sq_emp_info['first_name']==''){
	$emp_name = 'Admin';
}
else{
	$emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
}

$_SESSION['generated_by'] = $app_address.'        Contact : '.$app_contact_no;

define('FPDF_FONTPATH','../../../../classes/fpdf/font/');
//require('../../../../../classes/fpdf/fpdf.php');
require('../../../../classes/mc_table.php');
require('../../../../classes/rounded_rect2.php'); 


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

$pdf->setXY(128, 78);
$pdf->cell(190, 7, 'EMAIL ID : ', 0, 0);
$pdf->Line(120,75,120,87);

$pdf->setXY(62 , 78);
$pdf->cell(190, 7, $sq_quotation['customer_name'], 0, 0);
$pdf->setXY(145, 78);
$pdf->cell(190, 7, $sq_quotation['email_id'], 0, 0);

$pdf->SetFont('Arial','B',9);
$pdf->setXY(28, 93);
$pdf->Multicell(25, 8, 'ADULT : '.$sq_quotation['total_adult'], 1, 1);
$pdf->setXY(53, 93);
$pdf->Multicell(26, 8, 'CHILDREN : '.$sq_quotation['total_children'], 1, 1);
$pdf->setXY(79, 93);
$pdf->Multicell(25, 8, 'INFANT : '.$sq_quotation['total_infant'], 1, 1);
$pdf->setXY(104, 93);
$pdf->Multicell(25, 8, 'TOTAL : '.$sq_quotation['total_passangers'], 1, 1);
$pdf->setXY(129, 93);
$pdf->Multicell(38, 8, 'WITH BED : '.$sq_quotation['children_with_bed'], 1, 1);
$pdf->setXY(167, 93);
$pdf->Multicell(40, 8, 'WITHOUT BED : '.$sq_quotation['children_without_bed'], 1, 1);


//costing informaion

$y_pos = $pdf->getY()+10;
$pdf->setXY(28, $y_pos);
$pdf->SetFillColor(51,203,204);
$pdf->rect(28,$y_pos,179,11,F);
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(86, 10, 'COSTING' , 0, 0);

$y_pos = $pdf->getY()+11;
$pdf->SetTextColor(40,35,35);
$pdf->SetFont('Arial','',9);
$pdf->setXY(28,$y_pos);
$pdf->Multicell(86, 10, 'TOUR COST' , 1, 1);
$pdf->SetFont('Arial','',9);
$pdf->setXY(114, $y_pos);
$tour_cost = $sq_quotation['tour_cost'] + $sq_quotation['markup_cost'];
$pdf->Multicell(93, 10,'  '.number_format($tour_cost,2), 1, 1);

$y_pos = $pdf->getY();
$pdf->setXY(28, $y_pos);
$pdf->Multicell(86, 10, 'TAX', 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10, '  '.number_format($sq_quotation['service_tax_subtotal'],2), 1, 1);

$y_pos = $pdf->getY();
$pdf->setXY(28, $y_pos);
$pdf->SetFillColor(235);
$pdf->SetFont('Arial','B',9);
$pdf->rect(28, $y_pos, 179,10, 'F');
$pdf->Multicell(86, 10, 'QUOTATION COST', 1, 1);
$pdf->setXY(114, $y_pos);
$pdf->Multicell(93, 10, '  '.number_format($sq_quotation['quotation_cost'] ,2), 1, 1);

// Itinerary
$y_pos = $pdf->getY()+11;
$pdf->SetFillColor(51,203,204);	
$pdf->setXY(28, $y_pos);
$pdf->rect(28,$y_pos,179,11,F);
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(225,255,255);
$pdf->Cell(86, 10, 'TOUR ITINERARY' , 0, 0);

$pdf->SetTextColor(40,35,35);
$count = 1;

while($row_itinarary = mysql_fetch_assoc($sq_package_program)){

	//Adding new page if end of page is found
    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    {
    	$pdf->AddPage($pdf->CurOrientation);
    	$pdf->Image($transport_service_voucher2,8,0,8,297);
    }

$pdf->SetFont('Arial','B',8);
$y_pos = $pdf->getY()+13;
$pdf->setXY(28, $y_pos);
$pdf->cell(190, 7, 'DAY : ', 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(36, $y_pos);
$pdf->cell(190, 7, $count, 0, 0);
$count++;

	
	//Adding new page if end of page is found
    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    {
    	$pdf->AddPage($pdf->CurOrientation);
    	$pdf->Image($transport_service_voucher2,8,0,8,297);
    }

$pdf->SetFont('Arial','B',8);
$y_pos = $pdf->getY()+6;
$pdf->setXY(28, $y_pos);
$pdf->cell(190, 7, 'ATTRACTION : ', 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(49, $y_pos);
$pdf->cell(190, 7, $row_itinarary['attraction'], 0, 0);

	
	//Adding new page if end of page is found
    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    {
    	$pdf->AddPage($pdf->CurOrientation);
    	$pdf->Image($transport_service_voucher2,8,0,8,297);
    }

$pdf->SetFont('Arial','B',8);
$y_pos = $pdf->getY()+6;
$pdf->setXY(28, $y_pos);
$pdf->cell(190, 7, 'DAY-WISE PROGRAM : ', 0, 0);

	
	//Adding new page if end of page is found
    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    {
    	$pdf->AddPage($pdf->CurOrientation);
    	$pdf->Image($transport_service_voucher2,8,0,8,297);
    }

$pdf->SetFont('Arial','',9);
$y_pos = $pdf->getY()+6;
$pdf->setXY(28, $y_pos);
$pdf->MultiCell(175, 5,$row_itinarary['day_wise_program'], 0, 1);

	
	//Adding new page if end of page is found
    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    {
    	$pdf->AddPage($pdf->CurOrientation);
    	$pdf->Image($transport_service_voucher2,8,0,8,297);
    }

$pdf->SetFont('Arial','B',8);
$y_pos = $pdf->getY()+2;
$pdf->setXY(28, $y_pos);
$pdf->cell(190, 7, 'STAY : ', 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(38, $y_pos);
$pdf->cell(190, 7, $row_itinarary['stay'], 0, 0);

	
	//Adding new page if end of page is found
    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    {
    	$pdf->AddPage($pdf->CurOrientation);
    	$pdf->Image($transport_service_voucher2,8,0,8,297);
    }

$pdf->SetFont('Arial','B',8);
$y_pos = $pdf->getY()+6;
$pdf->setXY(28, $y_pos);
$pdf->cell(190, 7, 'MEAL PLAN : ', 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(47, $y_pos);
$pdf->cell(190, 7, $row_itinarary['meal_plan'], 0, 0);

	
	//Adding new page if end of page is found
    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    {
    	$pdf->AddPage($pdf->CurOrientation);
    	$pdf->Image($transport_service_voucher2,8,0,8,297);
    }

$pdf->SetDrawColor(154,154,154);
$y_pos = $pdf->getY()+10;
$pdf->line(28, $y_pos, 205,$y_pos);

}

$pdf->AddPage($pdf->CurOrientation);
$pdf->Image($transport_service_voucher2,8,0,8,297); 
//TRAIN
$sq_train_count = mysql_num_rows(mysql_query("select * from group_tour_quotation_train_entries where quotation_id='$quotation_id'"));

if($sq_train_count>0){

	$pdf->SetFillColor(51,203,204);
	$y_pos = $pdf->getY();
	$y_pos+=8;
	$pdf->rect(28,$y_pos,179,11,F);

	$y_pos = $pdf->getY()+10;
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(255,255,255);
	$y_pos = $pdf->getY();
	$y_pos+=8;
	$pdf->SetXY(28,$y_pos);
	$pdf->Cell(86, 10, 'TRAIN' , 0, 0);

	$y_pos = $pdf->getY()+10;
	$pdf->setXY(28, $y_pos);
    $pdf->SetTextColor(40,35,35);
    $pdf->SetFont('Arial','',9);
	$pdf->SetWidths(array(37, 37, 35, 35 , 35));
	$pdf->SetFillColor(235);
    $pdf->rect(28, $y_pos, 179,7, 'F');
	$pdf->Row(array('FROM','To','CLASS','DEPARTURE DATE','ARRIVAL DATE'));
	$sq_train = mysql_query("select * from group_tour_quotation_train_entries where quotation_id='$quotation_id'");
	while($row_train = mysql_fetch_assoc($sq_train)){
		$pdf->setX(28);	
		$pdf->Row(array($row_train['from_location'], $row_train['to_location'], $row_train['class'],date('d-m-Y H:i:s', strtotime($row_train['departure_date']))  , date('d-m-Y H:i:s', strtotime($row_train['arrival_date']))));
		//Adding new page if end of page is found
        if($pdf->GetY()+20>$pdf->PageBreakTrigger)
        {
        	$pdf->AddPage($pdf->CurOrientation);
        	$pdf->Image($transport_service_voucher2,8,0,8,297);
        }
	    $y_pos = $pdf->getY();
		$pdf->setXY(28, $y_pos);
	}

}

//PLANE
$sq_plane_count = mysql_num_rows(mysql_query("select * from group_tour_quotation_plane_entries where quotation_id='$quotation_id'"));

if($sq_plane_count>0){

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
	$pdf->Cell(86, 10, 'FLIGHT' , 0, 0);

	$y_pos = $pdf->getY()+10;
	$pdf->setXY(28, $y_pos);
	$pdf->SetTextColor(40,35,35);
	$pdf->SetFont('Arial','',9);
 	$pdf->SetFillColor(235);
    $pdf->rect(28, $y_pos, 179,7, 'F');
	$pdf->SetWidths(array(30,30,30,29,30,30));
	//Adding new page if end of page is found
        if($pdf->GetY()+10>$pdf->PageBreakTrigger)
        {
        	$pdf->AddPage($pdf->CurOrientation);
        	$pdf->Image($transport_service_voucher2,8,0,8,297);
        }
	    $y_pos = $pdf->getY();
		$pdf->setXY(28, $y_pos);
	$pdf->Row(array('FROM', 'TO' ,'AIRLINE', 'CLASS', 'DEPARTURE', 'ARRIVAL'));
	$sq_plane = mysql_query("select * from group_tour_quotation_plane_entries where quotation_id='$quotation_id'");
	while($row_plane = mysql_fetch_assoc($sq_plane)){
		$sq_airline = mysql_fetch_assoc(mysql_query("select * from airline_master where airline_id='$row_plane[airline_name]'"));
		$pdf->setX(28);	
		//Adding new page if end of page is found
        if($pdf->GetY()+20>$pdf->PageBreakTrigger)
        {
        	$pdf->AddPage($pdf->CurOrientation);
        	$pdf->Image($transport_service_voucher2,8,0,8,297);
        }
	    $y_pos = $pdf->getY();
		$pdf->setXY(28, $y_pos);
		$pdf->Row(array($row_plane['from_location'], $row_plane['to_location'],$sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')', $row_plane['class'], date('d-m-Y H:i:s', strtotime($row_plane['dapart_time'])), date('d-m-Y H:i:s', strtotime($row_plane['arraval_time']))));
		

	}

}

$pdf->AddPage($pdf->CurOrientation);
$pdf->Image($transport_service_voucher2,8,0,8,297);

//Terms and conditions 
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
$pdf->Cell(86, 10, 'TERMS AND CONDITIONS' , 0, 0);

$y_pos = $pdf->getY()+15;
$pdf->SetTextColor(40,35,35);
$pdf->SetFont('Arial','',9);
$pdf->setXY(32, $y_pos);
$pdf->MultiCell(156, 4,$sq_quotation['terms'], 0, 1);

//Adding new page if end of page is found
        if($pdf->GetY()+20>$pdf->PageBreakTrigger)
        {
        	$pdf->AddPage($pdf->CurOrientation);
        	$pdf->Image($transport_service_voucher2,8,0,8,297);
        }
//INCLUSION 
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
$pdf->Cell(86, 10, 'INCLUSIONS' , 0, 0);

$y_pos = $pdf->getY()+15;
$pdf->SetTextColor(40,35,35);
$pdf->SetFont('Arial','',9);
$pdf->setXY(32, $y_pos);
$pdf->MultiCell(156, 4,$sq_quotation['incl'], 0, 1);

//exclusion
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
$pdf->Cell(86, 10, 'EXCLUSIONS' , 0, 0);

$y_pos = $pdf->getY()+15;
$pdf->SetTextColor(40,35,35);
$pdf->SetFont('Arial','',9);
$pdf->setXY(32, $y_pos);
//Adding new page if end of page is found
        if($pdf->GetY()+20>$pdf->PageBreakTrigger)
        {
        	$pdf->AddPage($pdf->CurOrientation);
        	$pdf->Image($transport_service_voucher2,8,0,8,297);
        }
$pdf->MultiCell(156, 4,$sq_quotation['excl'], 0, 1);

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