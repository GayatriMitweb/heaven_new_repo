<?php 
include_once('../../../model/model.php');
require("../../../classes/convert_amount_to_word.php");

define('FPDF_FONTPATH','../../../classes/fpdf/font/');
require('../../../classes/mc_table.php');
$_SESSION['generated_by'] = $app_name;

$booking_id = $_GET['booking_id'];
$sq_booking = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$booking_id'"));
$no_of_car = ceil($sq_booking['total_pax']/$sq_booking['capacity']);
$booking_date = $sq_booking['created_at'];
$yr = explode("-", $booking_date);
$year =$yr[0];
if($sq_booking['travel_type']=='Outstation'){
	$travel_date =  date('d-m-Y', strtotime($sq_booking['traveling_date']));
}else{
	$travel_date = date('d-m-Y ', strtotime($sq_booking['from_date'])).' To '.date('d-m-Y', strtotime($sq_booking['to_date']));
}
 if($sq_booking['travel_type']=='Local'){
	$place_to_visit =$sq_booking['local_places_to_visit'];
 }else{
	$place_to_visit =$sq_booking['places_to_visit'];
 }

 $basic_amount = $sq_booking['basic_amount']+$sq_booking['markup_cost_subtotal'];

$sq_vendor = mysql_fetch_assoc(mysql_query("select * from car_rental_vendor where vendor_id='$sq_booking[vendor_id]'"));

$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));

if($sq_customer['type']=='Corporate'){
	$customer_name = $sq_customer['company_name'];
}else{
	$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
}
$tax_show = '';
$basic_cost1 = $sq_booking['basic_amount']; 
$newBasic = $basic_cost1;
$newSC = $sq_booking['service_charge'];
$service_charge = $sq_booking['service_charge'];
//////////////////Service Charge Rules
$service_tax_amount = 0;
if($sq_booking['service_tax_subtotal'] !== 0.00 && ($sq_booking['service_tax_subtotal']) !== ''){
  $service_tax_subtotal1 = explode(',',$sq_booking['service_tax_subtotal']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $name .= $service_tax[0] . ' ';
    $percent = $service_tax[1];
  }
}
if($bsmValues[0]->service != ''){ //inclusive service charge
  $newSC = $service_tax_amount + $service_charge;
  $newBasic = $newSC+$basic_cost1;

}
else{
  $tax_show =  $name . $percent. ($service_tax_amount);
  $newSC = $service_charge;
  $newBasic = $newSC+$basic_cost1;

}
////////////////////Markup Rules
$markupservice_tax_amount = 0;
if($sq_booking['markup_cost_subtotal'] !== 0.00 && $sq_booking['markup_cost_subtotal'] !== ""){
  $service_tax_markup1 = explode(',',$sq_booking['markup_cost_subtotal']);
  for($i=0;$i<sizeof($service_tax_markup1);$i++){
    $service_tax = explode(':',$service_tax_markup1[$i]);
    $markupservice_tax_amount += $service_tax[2];
  }
}
if($bsmValues[0]->markup != ''){ //inclusive markup
  $newBasic = $basic_cost1 + $sq_booking['markup_cost'] + $markupservice_tax_amount;
  $tax_show= '';
}
else{
  $newSC = $service_charge + $sq_booking['markup_cost'];
  $newBasic = $basic_cost1 + $newSC;

  $tax_show = ' ( '.$name . ' ) '.$percent.' '. ($markupservice_tax_amount + $service_tax_amount);
}
////////////Basic Amount Rules
if($bsmValues[0]->basic != ''){ //inclusive markup
  $newBasic = $basic_cost1 + $service_tax_amount + $sq_booking['markup_cost'] + $markupservice_tax_amount;
}
$newBasic=$newBasic+ $sq_booking['roundoff'] + $service_tax_amount + $markupservice_tax_amount;
$pdf=new PDF_MC_Table();
$pdf->addPage();

$pdf->SetFont('Arial','',12);
$pdf->SetXY(0,0);
$pdf->Cell( 100, 12, $pdf->Image($admin_logo_url,10,5,60,25), 10, 0, 'C', false );

$pdf->line(10,31,200,31);

$pdf->SetFont('Arial','',9);
$pdf->SetXY(10, 30);
$pdf->MultiCell(150, 8,$app_address);

$y_pos = $pdf->getY();
$pdf->SetXY(10, $y_pos);
$pdf->MultiCell(45, 8,"Phone: ".$app_contact_no);

$pdf->SetXY(50, $y_pos);
$pdf->MultiCell(70, 8,"Email: ". $app_email_id);

$pdf->SetFont('Arial','',12);
$y_pos = $pdf->getY()+10;
$pdf->setXY(10, $y_pos);
$pdf->Cell(190, 8, 'Car Rental Booking',1, 0, 'C');

$pdf->SetFont('Arial','',10);

$y_pos = $pdf->getY()+12;
$pdf->setXY(150, $y_pos);
$pdf->Cell(100, 7, 'Booking Date : '.get_date_user($sq_booking['created_at']));
$pdf->Line(150, $y_pos+7, 200, $y_pos+7);

$y_pos = $pdf->getY()+9;
$pdf->setXY(150, $y_pos);
$pdf->Cell(100, 7, 'Booking ID : '.get_car_rental_booking_id($booking_id,$year));
$pdf->Line(150, $y_pos+7, 200, $y_pos+7);


$y_pos = $pdf->getY()+12;
$pdf->setXY(10, $y_pos);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190, 8, 'General Information',1, 0, 'C');

$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
$email_id  = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
$y_pos = $pdf->getY()+8;
$pdf->SetFont('Arial','',9);
$pdf->setXY(10, $y_pos);
$pdf->SetWidths(array(30,65,30,65));
$pdf->Row(array('Customer Name', $customer_name, 'Total Pax', $sq_booking['total_pax']));
$pdf->Row(array('Mobile No', $contact_no, 'Email ID', $email_id));
$pdf->Row(array('Travelling Date',$travel_date, 'Days Of Travel', $sq_booking['days_of_traveling']));

$pdf->SetWidths(array(30,160));
$pdf->Row(array('Total vehicle', $no_of_car));
$pdf->Row(array('Passenger', $sq_booking['pass_name']));
$pdf->Row(array('Address', $sq_customer['address']));
$pdf->Row(array('Places To Visit', $place_to_visit));
$pdf->Row(array('Vendor Name', $sq_vendor['vendor_name']));

$y_pos = $pdf->getY()+5;
$pdf->SetFont('Arial','B',9);
$pdf->setXY(10, $y_pos);
$pdf->Cell(190, 8, 'Costing Information',1, 0, 'C');

$pdf->SetFont('Arial','',9);
$y_pos = $pdf->getY()+8;
$pdf->setXY(10, $y_pos);
$pdf->SetWidths(array(30,65,30,65));

$pdf->Row(array('Starting KM',' ' , 'Ending Km', $sq_booking['rate_per_km']));
$pdf->Row(array('Extra KM',' '));
$pdf->Row(array('Total Amount', $newBasic ,'Extra Km Rate', $sq_booking['extra_km']));
$pdf->Row(array('Extra Hr Rate', $sq_booking['extra_hr_cost'],'Driver Allowance', $sq_booking['driver_allowance']));

$pdf->SetWidths(array(30,65,30,65));
$pdf->Row(array('Permit Charges', $sq_booking['permit_charges'],'Toll & Parking', $sq_booking['toll_and_parking']));
$pdf->Row(array('State Entry Tax', $sq_booking['state_entry_tax'], 'Other Charges', $sq_booking['other_charges']));

$pdf->SetFont('Arial','B',9);
$pdf->SetWidths(array(30,160));
$pdf->Row(array('Total',number_format($sq_booking['state_entry_tax'] + $newBasic + $sq_booking['driver_allowance'] + $sq_booking['other_charges'] + $sq_booking['permit_charges'] +$sq_booking['toll_and_parking'],2), ''));

$y_pos = $pdf->getY()+5;
$pdf->SetFont('Arial','B',9);
$pdf->setXY(10, $y_pos);
$pdf->Cell(190, 8, 'Vehicle Information',1, 0, 'C');

$y_pos = $pdf->getY()+8;
$pdf->SetFont('Arial','',9);
$pdf->setXY(10, $y_pos);
$pdf->SetWidths(array(20,30,30,40, 40, 30));
$pdf->Row(array('Sr. No', 'Vehicle Name', 'Vehicle No', 'Driver Name', 'Mobile No', 'Type'));

$count = 0;
// $sq_vehicle_entries = mysql_query("select * from car_rental_booking_vehicle_entries where booking_id='$booking_id'");
// while($row_vehicle = mysql_fetch_assoc($sq_vehicle_entries)){

	$count++;

	$sq_vehicle = mysql_fetch_assoc(mysql_query("select * from car_rental_vendor_vehicle_entries where vehicle_id='$row_vehicle[vehicle_id]'"));

	$pdf->Row(array($count, $sq_booking['vehicle_name'], $sq_vehicle['vehicle_no'], $sq_vehicle['vehicle_driver_name'], $sq_vehicle['vehicle_mobile_no'], $sq_vehicle['vehicle_type']));

// }


$pdf->Output();
?>
