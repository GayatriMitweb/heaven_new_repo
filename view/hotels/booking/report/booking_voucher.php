<?php include "../../../../model/model.php"; ?>
<?php
$report_generater_name = "";
$role = $_SESSION['role'];
if($role=="Admin")
{
  $report_generater_name = "Admin";
}
if($role=="Booker")
{
  $booker_id = $_SESSION['booker_id'];
  $booker_name = mysql_fetch_assoc(mysql_query("select first_name, last_name from emp_master where emp_id='$booker_id'"));
  $report_generater_name = $booker_name['first_name']." ".$booker_name['last_name'];
}  

$_SESSION['generated_by'] = $report_generater_name;

$voucher_id = $_GET['entry_id'];


$sq_service_voucher = mysql_fetch_assoc( mysql_query("select * from hotel_booking_entries where entry_id='$voucher_id'") );
$hotel_id=$sq_service_voucher['hotel_id'];

$sq_hotel = mysql_fetch_assoc( mysql_query("select * from hotel_master where hotel_id='$hotel_id'") );

	
$booking_id = $sq_service_voucher['booking_id'];
$sq_booking = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$booking_id'"));
$customer_name = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id	='$sq_booking[customer_id]'"));
$name = $customer_name['first_name'].' '.$customer_name['last_name'].'  Contact No. ('. $customer_name['contact_no'] .')';
if($customer_name['type'] == 'Corporate'){ $company_name = '('.$customer_name[company_name].')';}
else{ $company_name = '';}

 $adult= $sq_booking['adults'];
$child = $sq_booking['childrens'];
$infant = $sq_booking['infant'];

$total =  $adult+$child+$infant;

define('FPDF_FONTPATH','../../../../classes/fpdf/font/');
//require('../../../../../classes/fpdf/fpdf.php');
require('../../../../classes/mc_table.php');


$pdf=new PDF_MC_Table();
$pdf->AddPage();

$pdf->SetFont('Arial','',16);
$pdf->SetXY(0,0);
$pdf->Image($admin_logo_url,10,5,190,25);

$y_pos = $pdf->getY()+35;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 8, 'HOTEL RESERVATION VOUCHER', 1, 0, 'C');

$pdf->rect(10, $y_pos+8, 190, 30);

$pdf->SetFont('Arial','',15);
$y_pos = $pdf->getY()+10;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 8, $sq_hotel['hotel_name'], 0, 0, 'C');

$pdf->SetFont('Arial','',12);
$y_pos = $pdf->getY()+8;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 7, $sq_hotel['hotel_address'], 0, 0, 'C');

$pdf->SetFont('Arial','',11);
$y_pos = $pdf->getY()+20;
$pdf->setXY(10, $y_pos);
$pdf->SetWidths(array(45,145));

$pdf->Row(array('Booking ID', $sq_service_voucher['booking_id']));	
$pdf->Row(array('Booked By', $app_name));	
$pdf->Row(array('Guest Name', $name));	
$pdf->Row(array('Guest Type', $customer_name['type'].$company_name));
$pdf->Row(array('Room Type', $sq_service_voucher['room_type']));	
$pdf->Row(array('Check-In', date('d-m-Y', strtotime($sq_service_voucher['check_in']))));	
$pdf->Row(array('Check-Out', date('d-m-Y', strtotime($sq_service_voucher['check_out']))));	
$pdf->Row(array('Extra Bed',$sq_service_voucher['extra_beds']));	
$pdf->Row(array('No. Of Pax', $total));	
$pdf->Row(array('No. Of Rooms', $sq_service_voucher['rooms']));
$pdf->Row(array('Hotel Contact', $sq_hotel['mobile_no']));
$pdf->Row(array('Meal Plan', $sq_service_voucher['meal_plan']));	
$pdf->Row(array('Confirmation No', $sq_service_voucher['conf_no']));	


$y_pos = $pdf->getY();
$pdf->setXY(10, $y_pos);
$pdf->rect(10, $y_pos, 190, 33);

$pdf->SetFont('Arial','',13);
$y_pos = $pdf->getY()+1;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 7, 'Meal Plan :', 0, 0);

$pdf->SetFont('Arial','',11);
$y_pos = $pdf->getY()+6;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 6, '1. EP - European Plan - Only Room.', 0, 0);

$y_pos = $pdf->getY()+6;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 6, '2. CP - Continental Plan - Room with Breakfast.', 0, 0);

$y_pos = $pdf->getY()+6;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 6, '3. MAP - Modified American Plan - Room with Breakfast and Lunch or Dinner.', 0, 0);

$y_pos = $pdf->getY()+6;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 6, '4. AP - American Plan - Room with All Meals (Breakfast - Lunch - Dinner)', 0, 0);

$y_pos = $pdf->getY()+8;
$pdf->setXY(10, $y_pos);
$pdf->rect(10, $y_pos, 190, 26);

$pdf->SetFont('Arial','',13);
$y_pos = $pdf->getY()+1;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 7, 'TERMS & CONDITIONS :', 0, 0);

$pdf->SetFont('Arial','',11);
$y_pos = $pdf->getY()+6;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 6, '1. Check in and Checkout time as per Hotel Rules.', 0, 0);

$y_pos = $pdf->getY()+6;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 6, '2. All Bookings are guaranteed against full Payment.', 0, 0);

$y_pos = $pdf->getY()+6;
$pdf->setXY(10, $y_pos);
$pdf->cell(190, 6, '3. In the event of No-Show the Hotel Reserves the right to charge retention as per Hotel Policy.', 0, 0);



$pdf->Output();
?>