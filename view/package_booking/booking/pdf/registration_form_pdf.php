<?php
include "../../../../model/model.php";
require("../../../../classes/convert_amount_to_word.php");

$booking_id=$_GET['booking_id'];

$package_booking_info = mysql_fetch_assoc(mysql_query("select *  from package_tour_booking_master where booking_id='$booking_id' "));

$tour_name = $package_booking_info['tour_name'];
$from_date = date("d-m-Y", strtotime($package_booking_info['tour_from_date']));
$to_date = date("d-m-Y", strtotime($package_booking_info['tour_to_date']));

$_SESSION['generated_by'] = $app_name;
$booking_date =  date("d-m-Y", strtotime($package_booking_info['booking_date']));

$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$package_booking_info[customer_id]'"));

$sq_total_members = mysql_num_rows(mysql_query("select traveler_id from package_travelers_details where booking_id='$booking_id'"));

$_SESSION['generated_by'] = $app_address.'        Contact : '.$app_contact_no;

define('FPDF_FONTPATH','../../../../classes/fpdf/font/');
//require('../../classes/fpdf/fpdf.php');
require('../../../../classes/mc_table.php');


$pdf=new PDF_MC_Table();
$pdf->AddPage();
$pdf->setTextColor(40,35,35);

$pdf->Image($booking_form,0,0,210,297);
 
$pdf->SetXY(0,0);

$pdf->Image($admin_logo_url, 30, 8, 46, 17);

$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(255,255,255);
$pdf->SetXY(158, 12);
$pdf->Cell(100, 5, 'BOOKING FORM');

$pdf->SetFont('Arial','',13);
$pdf->SetXY(28,83);
$pdf->Cell(100, 5, 'BOOKING DETAILS');

$pdf->SetFont('Arial','',20);
$pdf->SetTextColor(51,203,204);
$pdf->SetXY(35, 32);
$pdf->Cell(30, 8, strtoupper($app_name));

$pdf->SetFont('Arial','',8);
$pdf->setTextColor(40,35,35);
$pdf->SetXY(33, 46.7);
$pdf->Cell(30, 8, $app_address);

$pdf->SetFont('Arial','B',8);
$pdf->setXY(28, 47);
$pdf->cell(190, 7, "A ", 0, 0);
$pdf->setXY(155.5, 30.8);
$pdf->cell(192, 7, "E", 0, 0);
$pdf->setXY(155.5 , 38.5);
$pdf->cell(190, 7, "P ", 0, 0);
$pdf->setXY(155.5, 45.8);
$pdf->cell(190, 7, "L ", 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(160, 30.8);
$pdf->cell(190, 7, $app_email_id, 0, 0);

$pdf->setXY(160 , 38.5);
$pdf->cell(190, 7, $app_contact_no, 0, 0);

$pdf->setXY(160, 45.8);
$pdf->cell(190, 7, $app_landline_no, 0, 0);

$pdf->SetFont('Arial','B',9);
$pdf->setXY(30, 64);
$pdf->cell(190, 7, 'CONTACT PERSON', 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(70 , 64);
$pdf->cell(190, 7, $package_booking_info['contact_person_name'], 0, 0);

$pdf->SetFont('Arial','B',9);
$pdf->setXY(138, 64);
$pdf->cell(190, 7, 'CONTACT NO', 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(174, 64);
$pdf->cell(190, 7, $package_booking_info['mobile_no'], 0, 0);

$pdf->SetFont('Arial','B',9);
$pdf->setXY(28, 93);
$pdf->cell(190, 7, 'BOOKING ID', 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(63, 93);
$pdf->cell(190, 7, get_package_booking_id($booking_id), 0, 0);

$pdf->SetFont('Arial','B',9);
$pdf->setXY(117.5, 93);
$pdf->cell(190, 7, 'DATE', 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(150, 93);
$pdf->cell(190, 7, $booking_date, 0, 0);

$pdf->SetFont('Arial','B',9); 
$pdf->setXY(28, 103);
$pdf->cell(190, 7, 'TOUR NAME', 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(63, 103);
$pdf->cell(190, 7, $tour_name, 0, 0);

$pdf->SetFont('Arial','B',9);
$pdf->setXY(117, 103);
$pdf->cell(190, 7, 'TOUR DATE', 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(150, 103);
$pdf->cell(190, 7, $from_date.' To '.$to_date, 0, 0);

$pdf->SetFont('Arial','B',9);
$pdf->setXY(28, 113);
$pdf->cell(190, 7, 'VISA', 0, 0);

$visa_name= ($package_booking_info['visa_country_name']!="") ? $package_booking_info['visa_country_name']: NA;

$pdf->SetFont('Arial','',9);
$pdf->setXY(63, 113);
$pdf->cell(190, 7, $visa_name, 0, 0);
 
$pdf->SetFont('Arial','B',9);
$pdf->setXY(117, 113);
$pdf->cell(190, 7, 'INSURANCE', 0, 0);

$insuarance_name= ($package_booking_info['insuarance_company_name']!="") ? $package_booking_info['insuarance_company_name']: NA;

$pdf->SetFont('Arial','',9); 
$pdf->setXY(150, 113);
$pdf->cell(190, 7, $insuarance_name, 0, 0);

$pdf->SetFont('Arial','B',9);
$pdf->setXY(28, 124);
$pdf->cell(190, 7, 'TOTAL GUEST', 0, 0);

$pdf->SetFont('Arial','',9);
$pdf->setXY(63, 124);
$pdf->cell(190, 7, $sq_total_members, 0, 0);

$pdf->SetFillColor(51,203,204);
$pdf->rect(27,138,181,11,F);

$pdf->SetFont('Arial','',13);
$pdf->SetTextColor(255,255,255);
$pdf->SetXY(28,141.5);
$pdf->Cell(100, 5, 'PASSENGER DETAILS');

$pdf->SetDrawColor(211,211,211);
$pdf->SetFont('Arial','',9);
$pdf->setTextColor(40,35,35);
$pdf->SetY($pdf->GetY()+7.5); 

if($pdf->GetY()+25>$pdf->PageBreakTrigger)
$pdf->AddPage($pdf->CurOrientation);
$pdf->Image($sidebar_strip,7,0,10,297);
$pdf->SetX(27);

$pdf->SetFillColor(235);
$pdf->rect(27,149, 181, 7, 'F');

$pdf->SetFont('Arial','B',9);
$pdf->SetWidths(array(80,30,30,41));
$pdf->Row(array('Full Name', 'Gender', 'Age', 'DOB'));

$sq_members = mysql_query("select * from package_travelers_details where booking_id = '$booking_id'");
while($row_members = mysql_fetch_assoc($sq_members))
{
    $pdf->SetX(27);
    $pdf->SetFont('Arial','',9);
    $pdf->Row(array($row_members['first_name'].' '.$row_members['middle_name'].' '.$row_members['last_name'], $row_members['gender'], $row_members['age'],  date("d-m-Y", strtotime($row_members['birth_date']))));
}

$pdf->SetFillColor(51,203,204);
$y_pos1 = $pdf->getY();
$y_pos1+=5;
$pdf->rect(27,$y_pos1,181,11,F);

$pdf->SetFillColor(51,203,204);
$y_pos1 = $pdf->getY();
$y_pos1+=5;
$pdf->rect(27,$y_pos1,181,11,F);

$pdf->SetFont('Arial','',13);
$pdf->SetTextColor(255,255,255);
$y_pos1 = $pdf->getY();
$y_pos1+=7.5;
$pdf->SetXY(28,$y_pos1);
$pdf->Cell(100, 5, 'ACCOMMODATION');

$pdf->SetDrawColor(211,211,211);
$pdf->SetFont('Arial','',9);
$pdf->setTextColor(40,35,35);
$pdf->SetY($pdf->GetY()+8.6); 

if($pdf->GetY()+27>$pdf->PageBreakTrigger)
$pdf->AddPage($pdf->CurOrientation);
$pdf->Image($sidebar_strip,7,0,10,297);
$pdf->SetX(27);

$pdf->SetFillColor(235);
$pdf->rect(27,$y_pos1+8.6, 181, 7, 'F');

$pdf->SetFont('Arial','B',9);
$pdf->SetWidths(array(20,25,30,25,25,20,35));
$pdf->Row(array('City','Hotel','Check-In','Check-Out','Category','Room Type','Confirmation No'));

$sq_entry = mysql_query("select * from package_hotel_accomodation_master where booking_id='$booking_id'");
    while($row_entry = mysql_fetch_assoc($sq_entry))
{
    $city_id = $row_entry['city_id'];
    $hotel_id = $row_entry['hotel_id'];
    $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$city_id'"));
    $sq_hotel_name = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$hotel_id'"));
            
    $pdf->SetX(27);
    $pdf->SetFont('Arial','',9);
    $pdf->Row(array($sq_city['city_name'], $sq_hotel_name['hotel_name'],get_datetime_user($row_entry['from_date']),get_datetime_user($row_entry['to_date']),$row_entry['catagory'], $row_entry['room_type'],$row_entry['confirmation_no']));
}

$pdf->AddPage($pdf->CurOrientation);
$pdf->Image($sidebar_strip,7,0,10,297);
$pdf->SetFillColor(51,203,204);
$y_pos1 = $pdf->getY();
$y_pos1+=5;
$pdf->rect(27,$y_pos1,181,11,F);

$pdf->SetFillColor(51,203,204);
$y_pos1 = $pdf->getY();
$y_pos1+=5;
$pdf->rect(27,$y_pos1,181,11,F);



$pdf->SetFont('Arial','',13);
$pdf->SetTextColor(255,255,255);
$y_pos1 = $pdf->getY();
$y_pos1+=7.5;
$pdf->SetXY(28,$y_pos1);
$pdf->Cell(100, 5, 'TRANSPORT');

$pdf->SetDrawColor(211,211,211);
$pdf->SetFont('Arial','',9);
$pdf->setTextColor(40,35,35);
$pdf->SetY($pdf->GetY()+8.6); 

if($pdf->GetY()+27>$pdf->PageBreakTrigger)
$pdf->AddPage($pdf->CurOrientation);
$pdf->Image($sidebar_strip,7,0,10,297);
$pdf->SetX(27);

$pdf->SetFillColor(235);
$pdf->rect(27,$pdf->GetY(), 181, 7, 'F');

$pdf->SetFont('Arial','B',9);
$pdf->SetWidths(array(61,60,60));
$pdf->Row(array('Vehicle Name','From-Date'));

$q_transport = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id='$package_booking_info[transport_bus_id]'"));
$pdf->SetX(27);
$pdf->SetFont('Arial','',9);
$pdf->Row(array($q_transport['vehicle_name'],get_date_user($package_booking_info['transport_from_date'])));


$sq_train = mysql_num_rows(mysql_query("select booking_id from package_train_master where booking_id='$booking_id'"));
$sq_air = mysql_num_rows(mysql_query("select booking_id from package_plane_master where booking_id='$booking_id'"));
if($sq_train > 0 || $sq_air > 0)
{
    $sq_train = mysql_num_rows(mysql_query("select booking_id from package_train_master where booking_id='$booking_id'"));
    $train_count = 0;

    if($sq_train>0)
    {

        $y_pos1 = $pdf->getY();
        $y_pos1+=5;

        $pdf->SetFillColor(51,203,204);
        $pdf->rect(27,$y_pos1,181,11,F);

        $pdf->SetFont('Arial','',13);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY(28,$y_pos1+3);
        $pdf->Cell(100, 5, 'TRAVEL-TRAIN');

        $pdf->SetFont('Arial','',9);
        $pdf->setTextColor(40,35,35);
        $pdf->SetY($pdf->GetY()+8); 

        if($pdf->GetY()+25>$pdf->PageBreakTrigger)
        {
            $pdf->AddPage($pdf->CurOrientation);
            $pdf->Image($sidebar_strip,7,0,10,297);
            $pdf->SetX(27);
        }

        $y_pos1 = $pdf->getY();
         $pdf->SetX(27);
        $pdf->SetFillColor(235);
        $pdf->rect(27,$y_pos1, 181, 7, 'F');

        $pdf->SetFont('Arial','B',9);
        $pdf->SetWidths(array(35,35,30,15,15,20,31));
        $pdf->Row(array('FROM', 'TO', 'TRAIN','SEATS','CLASS','PRIORITY','DEPARTURE D/T'));

        $sq_train_details = mysql_query("select * from package_train_master where booking_id='$booking_id'");
        while($row_train_details = mysql_fetch_assoc($sq_train_details))
        {
            $pdf->SetX(27);
            $train_count++;
            $pdf->SetFont('Arial','',9);
            $pdf->Row(array($row_train_details['from_location'], $row_train_details['to_location'], $row_train_details['train_no'], $row_train_details['seats'], $row_train_details['train_class'], $row_train_details['train_priority'],date("d-m-Y H:i", strtotime($row_train_details['date']))));
        }
    }
  
    $sq_air = mysql_num_rows(mysql_query("select booking_id from package_plane_master where booking_id='$booking_id'"));
    $air_count = 0;

    if($sq_air>0)
    {
        $y_pos1 = $pdf->getY();
        $y_pos1+=5;

        $pdf->SetFillColor(51,203,204);
        $pdf->rect(27,$y_pos1,181,11,F);

        $pdf->SetFont('Arial','',13);
        $pdf->SetTextColor(255,255,255);
        
        $pdf->SetXY(28, $y_pos1+2);
        $pdf->Cell(200, 7, 'TRAVEL-FLIGHT');

        $pdf->SetFont('Arial','',9);
        $pdf->setTextColor(40,35,35);
        $pdf->SetY($pdf->GetY()+9); 

        if($pdf->GetY()+20>$pdf->PageBreakTrigger)
        {
            $pdf->AddPage($pdf->CurOrientation);
            $pdf->Image($sidebar_strip,7,0,10,297);
            $pdf->SetX(27);
        }
        $y_pos1 = $pdf->getY();
         $pdf->SetX(27);
        $pdf->SetFillColor(235);
        $pdf->rect(27,$y_pos1, 181, 7, 'F');
        $pdf->SetFont('Arial','B',9);

        $pdf->SetWidths(array(35,30,35,18,32,31));
        $pdf->Row(array('FROM', 'TO', 'AIRLINE NAME','SEATS','DEPARTURE D/T','ARRIVAL D/T'));

        $sq_air_details = mysql_query("select * from package_plane_master where booking_id='$booking_id'");
        while($row_air_details = mysql_fetch_assoc($sq_air_details))
        {
            $sq_airline = mysql_fetch_assoc(mysql_query("select * from airline_master where airline_id='$row_air_details[company]'"));
            $pdf->SetX(27);
            $air_count++;
            $pdf->SetFont('Arial','',9);
            $pdf->Row(array($row_air_details['from_location'], $row_air_details['to_location'], $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')', $row_air_details['seats'], date("d-m-Y H:i:s", strtotime($row_air_details['date'])), date("d-m-Y H:i:s", strtotime($row_air_details['arraval_time']))));
        }
    }

}

if($pdf->GetY()+5>$pdf->PageBreakTrigger)
{
    $pdf->AddPage();
    $pdf->setTextColor(40,35,35);
    $pdf->Image($sidebar_strip,7,0,10,297);
    $pdf->SetX(27);
}    

// Cruise
$sq_cruise = mysql_num_rows(mysql_query("select booking_id from package_cruise_master where booking_id='$booking_id'"));
if($sq_cruise>0)
{
    $y_pos1 = $pdf->getY();
    $y_pos1+=5;

    $pdf->SetFillColor(51,203,204);
    $pdf->rect(27,$y_pos1,181,11,F);

    $pdf->SetFont('Arial','',13);
    $pdf->SetTextColor(255,255,255);
    
    $pdf->SetXY(28, $y_pos1+2);
    $pdf->Cell(200, 7, 'TRAVEL-CRUISE');

    $pdf->setTextColor(40,35,35);
    $pdf->SetY($pdf->GetY()+9); 

    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    $pdf->AddPage($pdf->CurOrientation);
    $pdf->Image($sidebar_strip,7,0,10,297);
    $pdf->SetX(27);

    $y_pos1 = $pdf->getY();

    $pdf->SetFillColor(235);
    $pdf->rect(27,$y_pos1, 181, 7, 'F');
    $pdf->SetFont('Arial','B',9);

    $pdf->SetWidths(array(35,30,35,18,32,31));
    $pdf->Row(array('DEPARTURE D/T','ARRIVAL D/T','ROUTE','CABIN','SHARING','SEATS'));


    $sq_cruise_details = mysql_query("select * from package_cruise_master where booking_id='$booking_id'");
    while($row_cruise_details = mysql_fetch_assoc($sq_cruise_details))
    {
        $pdf->SetX(27);
        $pdf->SetFont('Arial','',10);
        $pdf->Row(array(date("d-m-Y H:i:s", strtotime($row_cruise_details['dept_datetime'])), date("d-m-Y H:i:s", strtotime($row_cruise_details['arrival_datetime'])),$row_cruise_details['route'],$row_cruise_details['cabin'],$row_cruise_details['sharing'],$row_cruise_details['seats']));

        if($pdf->GetY()+20>$pdf->PageBreakTrigger)
        {
            $pdf->AddPage($pdf->CurOrientation);
            $pdf->Image($transport_service_voucher2,8,0,8,297);
        }

    }
}
 $pdf->AddPage();
    $pdf->setTextColor(40,35,35);
    $pdf->Image($sidebar_strip,7,0,10,297);
$pdf->SetFillColor(51,203,204);
$y_pos1 = $pdf->getY();
$y_pos1+=5;
$pdf->rect(27,$y_pos1,181,11,F);

$pdf->SetFont('Arial','',13);
$pdf->SetTextColor(255,255,255);
$y_pos1 = $pdf->getY();
$y_pos1+=8;
$pdf->SetXY(28,$y_pos1);
$pdf->Cell(100, 5, 'PAYMENT DETAILS');

$total_hotel_expense = ($package_booking_info['total_hotel_expense']!="") ? $package_booking_info['total_hotel_expense']: 0;
$total_tour_expense = ($package_booking_info['total_tour_expense']!="") ? $package_booking_info['total_tour_expense']: 0;
$total_travel_expense = ($package_booking_info['total_travel_expense']!="") ? $package_booking_info['total_travel_expense']: 0;

$subtotal = ($package_booking_info['subtotal']!="") ? $package_booking_info['subtotal']: 0;
$tour_fee = ($package_booking_info['tour_fee']!="") ? $package_booking_info['tour_fee']: 0;
$gst = '';
$gst_amt = ($subtotal * $gst)/100;

//Adding new page if end of page is found
if($pdf->GetY()+20>$pdf->PageBreakTrigger)
$pdf->AddPage($pdf->CurOrientation);

$pdf->setTextColor(40,35,35);
$pdf->SetFont('Arial','B',9);

$y_pos1 = $pdf->getY();
$y_pos1+=8;
$pdf->SetXY(27,$y_pos1);
$pdf->SetFillColor(235);
$pdf->rect(27,$y_pos1, 40, 8, 'F');
$pdf->MultiCell(40, 8, 'TOUR AMOUNT', 1);

$pdf->SetFont('Arial','',9);
$pdf->SetXY(67, $y_pos1);
$pdf->MultiCell(50, 8, $subtotal, 1,'R');

$pdf->SetFont('Arial','B',9);
$pdf->SetXY(117, $y_pos1);
$pdf->SetFillColor(235);
$pdf->rect(117,$y_pos1, 40, 8, 'F');
$pdf->MultiCell(40, 8, 'TAX AMOUNT', 1);

$pdf->SetFont('Arial','',9);
$pdf->SetXY(157, $y_pos1);
$pdf->MultiCell(50, 8, $package_booking_info['tour_service_tax_subtotal'] , 1,'R');

$pdf->SetFont('Arial','B',9);
$pdf->SetXY(27,$y_pos1+8);
$pdf->SetFillColor(235);
$pdf->rect(27,$y_pos1+8, 40, 8, 'F');
$pdf->MultiCell(40, 8, 'TRAIN AMOUNT', 1);

$pdf->SetFont('Arial','',9);
$pdf->SetXY(67, $y_pos1+8);
$pdf->MultiCell(50, 8,$package_booking_info['total_train_expense'] , 1,'R');

$pdf->SetFont('Arial','B',9); 
$pdf->SetXY(117, $y_pos1+8);
$pdf->SetFillColor(235);
$pdf->rect(117,$y_pos1+8, 40, 8, 'F');
$pdf->MultiCell(40, 8, 'FLIGHT AMOUNT', 1);

$pdf->SetFont('Arial','',9);
$pdf->SetXY(157, $y_pos1+8);
$pdf->MultiCell(50, 8, $package_booking_info['total_plane_expense'] , 1,'R');

$y_pos1 = $pdf->getY();
$pdf->SetFont('Arial','B',9);
$pdf->SetXY(27,$y_pos1);
$pdf->SetFillColor(235);
$pdf->rect(27,$y_pos1, 40, 8, 'F');
$pdf->MultiCell(40, 8, 'CRUISE AMOUNT', 1);

$pdf->SetFont('Arial','',9);
$pdf->SetXY(67, $y_pos1);
$pdf->MultiCell(50, 8,$package_booking_info['total_cruise_expense'] , 1,'R');

$pdf->SetFont('Arial','B',9);
$pdf->SetXY(117,$y_pos1);
$pdf->SetFillColor(235);
$pdf->rect(117,$y_pos1, 40, 8, 'F');
$pdf->MultiCell(40, 8, 'VISA AMOUNT', 1);

$visa_total_amount= ($package_booking_info['visa_total_amount']!="") ? $package_booking_info['visa_total_amount']: 0.00;

$pdf->SetFont('Arial','',9);
$pdf->SetXY(157, $y_pos1);
$pdf->MultiCell(50, 8, $visa_total_amount , 1,'R');

$y_pos1 = $pdf->getY();
$pdf->SetFont('Arial','B',9);
$pdf->SetXY(27, $y_pos1);
$pdf->SetFillColor(235);
$pdf->rect(27,$y_pos1, 40, 8, 'F');
$pdf->MultiCell(40, 8, 'INSURANCE AMOUNT', 1);

$insuarance_total_amount= ($package_booking_info['insuarance_total_amount']!="") ? $package_booking_info['insuarance_total_amount']: 0.00;

$pdf->SetFont('Arial','',9);
$pdf->SetXY(67, $y_pos1);
$pdf->MultiCell(50, 8, $insuarance_total_amount , 1,'R');

$y_pos1 = $pdf->getY();
$y_pos1+=5;
if($pdf->GetY()+20>$pdf->PageBreakTrigger)
        {
            $pdf->AddPage($pdf->CurOrientation);
            $pdf->Image($sidebar_strip,7,0,10,297);
            //$pdf->SetX(27);
            $y_pos1 = $pdf->getY();
            $y_pos1+=5;
        }
$pdf->SetFillColor(51,203,204);
$pdf->rect(117,$y_pos1,45,11,F);

//Tour TOtal
$tour_amount= ($package_booking_info['actual_tour_expense']!="") ? $package_booking_info['actual_tour_expense']: 0;

$sq_tour_refund = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$booking_id'"));
$can_amount = $sq_tour_refund['total_refund'] - ($sq_tour_refund['total_train_amount'] + $sq_tour_refund['total_plane_amount']);

$total_tour_amount = $tour_amount - $can_amount ;
//Travel Total 
$travel_amount= ($package_booking_info['total_travel_expense']!="") ? $package_booking_info['total_travel_expense']: 0;

$sq_tour_refund = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$booking_id'"));
$can_amount = $sq_tour_refund['total_refund'] - ($sq_tour_refund['total_visa_amount'] + $sq_tour_refund['total_insuarance_amount'] + $sq_tour_refund['total_tour_amount']);

$total_travel_amount = $travel_amount - $can_amount ;


$pdf->SetFont('Arial','',13);
$pdf->SetTextColor(255,255,255);
$pdf->SetXY(120, $y_pos1+1);
$pdf->Cell(35, 8, 'TOTAL AMOUNT');

$pdf->SetFont('Arial','B',13);
$pdf->setTextColor(40,35,35);
$pdf->SetXY(162, $y_pos1);
$pdf->MultiCell(45,11, number_format($total_tour_amount + $total_travel_amount, 2) , 1,'R');

$filename = $sq_customer['first_name'].'_'.$sq_customer['last_name'].'_bookingform'.'.pdf';
$pdf->SetFont('Arial','',9);

$pdf->Output($filename,'I');
?>