<?php include "../../../../model/model.php"; ?>
<?php
$booking_id=$_GET['booking_id'];

$package_booking_info = mysql_fetch_assoc(mysql_query("select *  from package_tour_booking_master where booking_id='$booking_id' "));

$tour_name = $package_booking_info['tour_name'];
$from_date = date("d-m-Y", strtotime($package_booking_info['tour_from_date']));
$to_date = date("d-m-Y", strtotime($package_booking_info['tour_to_date']));

$_SESSION['generated_by'] = $app_name;
$booking_date =  date("d-m-Y", strtotime($package_booking_info['booking_date']));

define('FPDF_FONTPATH','../../../../classes/fpdf/font/');
//require('../../classes/fpdf/fpdf.php');
require('../../../../classes/mc_table.php');


$pdf=new PDF_MC_Table();

for($i=1; $i<=6; $i++){
    $pdf->AddPage();
    $pdf->SetXY(0,0);
    $pdf->Cell( 100, 10, $pdf->Image("../../../../images/terms-conditions/terms-conditions-".$i.".jpg",5,5,200,265), 0, 0, 'C', false );
}

$pdf->AddPage();

$pdf->SetFillColor(235);
$pdf->rect(0, 0, 210, 35, 'F');

$pdf->SetFont('Arial','',30);
$pdf->SetXY(70, 16);
$pdf->MultiCell(180, 5, 'BOOKING FORM');

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos = $pdf->getY();
$y_pos+=24;
$pdf->SetXY(10, $y_pos);
$pdf->MultiCell(30, 8, 'Booking ID', 1);

$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(40, $y_pos1);
$pdf->MultiCell(50, 8, get_package_booking_id($booking_id), 1);
 
$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(100,$y_pos1);
$pdf->MultiCell(30, 8, 'Tour Name', 1);

$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(130, $y_pos1);
$pdf->MultiCell(65, 8, $tour_name, 1);

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=0;
$pdf->SetXY(10, $y_pos1);
$pdf->MultiCell(30, 8, 'Booking Date', 1);

$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(40, $y_pos1);
$pdf->MultiCell(50, 8, $booking_date, 1);
 
$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(100, $y_pos1);
$pdf->MultiCell(30, 8, 'Tour Date', 1);

$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(130, $y_pos1);
$pdf->MultiCell(65, 8, $from_date.' To '.$to_date, 1);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=0;
$pdf->SetXY(10, $y_pos1);
$pdf->MultiCell(30, 8, 'Tour Type', 1);

$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(40, $y_pos1);
$pdf->MultiCell(50, 8, $package_booking_info['tour_type'], 1);
 
$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(100, $y_pos1);
$pdf->MultiCell(30, 8, 'Tour Days', 1);

$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(130, $y_pos1);
$pdf->MultiCell(65, 8, $package_booking_info['total_tour_days'], 1);


$sq_package_members = mysql_num_rows(mysql_query("select traveler_id from package_travelers_details where booking_id='$booking_id'"));

if($sq_package_members > 0)
{

    $pdf->SetDrawColor(200, 200, 200);

    $pdf->SetFont('Arial','',12);
    $y_pos1 = $pdf->getY();
    $y_pos1+=5;
    $pdf->SetXY(10, $y_pos1);
    $pdf->MultiCell(185, 10, 'PASSENGER DETAILS', 1,'C');

    $pdf->SetY($pdf->GetY()+0); 

    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    $pdf->AddPage($pdf->CurOrientation);
    $pdf->SetX(10);

    $pdf->SetWidths(array(80,30,30,45));
    $pdf->Row(array('Full Name', 'Gender', 'Age', 'DOB'));

    $sq_members = mysql_query("select * from package_travelers_details where booking_id = '$booking_id'");
    while($row_members = mysql_fetch_assoc($sq_members))
    {
        $pdf->SetX(10);
        $pdf->Row(array($row_members['first_name'].' '.$row_members['middle_name'].' '.$row_members['last_name'], $row_members['gender'], $row_members['age'],  date("d-m-Y", strtotime($row_members['birth_date']))));
    }
}

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=5;
$pdf->SetXY(10, $y_pos1);
$pdf->MultiCell(185, 10, 'CONTACT DETAILS', 1,'C');

$pdf->SetY($pdf->GetY()+0); 

    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    $pdf->AddPage($pdf->CurOrientation);
    $pdf->SetX(10);

    $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$package_booking_info[customer_id]'"));
    if($sq_customer['type'] == 'Corporate') { $company_name = $sq_customer['company_name']; }
    else { $company_name = 'NA'; }
    $pdf->SetWidths(array(45,50,45,45));
    $pdf->Row(array('Contact Person', 'Email', 'Mobile','Company'));

    $pdf->SetX(10);
    $pdf->Row(array($package_booking_info['contact_person_name'],$package_booking_info['email_id'], $package_booking_info['mobile_no'],$company_name));

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=5;
$pdf->SetXY(10, $y_pos1);
$pdf->MultiCell(185, 10, 'BOOKING DETAILS', 1,'C');

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=0;
$pdf->SetXY(10, $y_pos1);
$pdf->MultiCell(90, 8, 'Visa Country : '.$package_booking_info['visa_country_name'], 1);

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(100, $y_pos1);
$pdf->MultiCell(95, 8, 'Insuarance Company : '.$package_booking_info['insuarance_company_name'], 1);

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=0;
$pdf->SetXY(10, $y_pos1);
$pdf->MultiCell(185, 8, 'Special Request : '.$package_booking_info['special_request'], 1);

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=5;
$pdf->SetXY(10, $y_pos1);
$pdf->MultiCell(90, 8, 'Required Rooms : '.$package_booking_info['required_rooms'], 1);

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(100, $y_pos1);
$pdf->MultiCell(95, 8, 'Child With Bed: '.$package_booking_info['child_with_bed'], 1);

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=0;
$pdf->SetXY(10, $y_pos1);
$pdf->MultiCell(185, 8, 'Child Without Bed : '.$package_booking_info['child_without_bed'], 1);

$sq_count = mysql_num_rows(mysql_query("select id from package_hotel_accomodation_master where booking_id='$booking_id'"));

if($sq_count > 0)
{
    $pdf->SetDrawColor(200, 200, 200);

    $pdf->SetFont('Arial','',12);
    $y_pos1 = $pdf->getY();
    $y_pos1+=5;
    $pdf->SetXY(10, $y_pos1);
    $pdf->MultiCell(185, 10, 'ACCOMODATION DETAILS', 1,'C');

    $pdf->SetY($pdf->GetY()+0); 

    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    $pdf->AddPage($pdf->CurOrientation);
    $pdf->SetX(10);

    $pdf->SetWidths(array(10,20,30,30,20,20,20,35));
    $pdf->Row(array('Sr.No', 'City','Hotel','Check-In','Category','Meal Plan','Room Type','Confirmation No'));

    $count = 0;
    $pdf->SetX(10);
    $sq_entry = mysql_query("select * from package_hotel_accomodation_master where booking_id='$booking_id'");
        
        while($row_entry = mysql_fetch_assoc($sq_entry)){
            $city_id = $row_entry['city_id'];
            $hotel_id = $row_entry['hotel_id'];

            $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$city_id'"));
            $sq_hotel_name = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$hotel_id'"));
            $count++;
            $pdf->SetX(10);

            $pdf->Row(array($count, $sq_city['city_name'], $sq_hotel_name['hotel_name'],get_datetime_user($row_entry['from_date']),$row_entry['catagory'],$row_entry['meal_plan'],$row_entry['room_type'],$row_entry['confirmation_no']));

    }
}

$sq_entry = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));

    $transport_agency_id = $sq_entry['transport_agency_id'];
    $transport_bus_id = $sq_entry['transport_bus_id'];

    $sq_agency = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$transport_agency_id'"));
    $sq_bus_name = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id='$transport_bus_id'"));

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos = $pdf->getY();
$y_pos+=5;
$pdf->SetXY(10, $y_pos);
$pdf->MultiCell(40, 8, 'Transport Agency', 1);

$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(50, $y_pos1);
$pdf->MultiCell(50, 8, $sq_agency['transport_agency_name'], 1);
 
$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(110,$y_pos1);
$pdf->MultiCell(40, 8, 'Transport Vehicle', 1);

$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(150, $y_pos1);
$pdf->MultiCell(45, 8,$sq_bus_name['vehicle_name'] , 1);

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=0;
$pdf->SetXY(10, $y_pos1);
$pdf->MultiCell(40, 8, 'Driver Name', 1);

$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(50, $y_pos1);
$pdf->MultiCell(50, 8, $sq_entry['driver_name'], 1);

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(110, $y_pos1);
$pdf->MultiCell(40, 8, 'From Date', 1);

$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(150, $y_pos1);
$pdf->MultiCell(45, 8, get_date_user($sq_entry['transport_from_date']), 1);

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=0;
$pdf->SetXY(10, $y_pos1);
$pdf->MultiCell(40, 8, 'To Date', 1);

$y_pos1 = $pdf->getY();
$y_pos1+=-8;
$pdf->SetXY(50, $y_pos1);
$pdf->MultiCell(50, 8, get_date_user($sq_entry['transport_to_date']), 1);
 

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$y_pos1 = $pdf->getY();
$y_pos1+=5;
$pdf->SetXY(10, $y_pos1);
$pdf->MultiCell(185, 10, 'TOUR ITINERARY', 1,'C');

$pdf->SetY($pdf->GetY()+0); 

    if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    $pdf->AddPage($pdf->CurOrientation);
    $pdf->SetX(10);

    $pdf->SetWidths(array(20,30,110,25));
    $pdf->Row(array('Date','Special Attraction', 'Datewise Program', 'Overnight Stay' ));

    $pdf->SetX(10);
    $sq_itinerary_entry = mysql_query("select * from package_tour_schedule_master where booking_id='$booking_id'");
    while($row_itinerary_entry = mysql_fetch_assoc($sq_itinerary_entry)){

        $pdf->Row(array(get_date_user($row_itinerary_entry['date']), $row_itinerary_entry['attraction'], $row_itinerary_entry['program'], $row_itinerary_entry['stay'] ));

    }

$pdf->AddPage();

$pdf->SetFillColor(235);
$pdf->rect(0, 0, 210, 35, 'F');

$pdf->SetFont('Arial','',28);
$pdf->SetXY(40, 16);
$pdf->MultiCell(200, 5, 'PAYMENT INFORMATION');

$pdf->SetXY(55,40);
$pdf->SetFont('Arial','',14);
$pdf->SetFillColor(183, 189, 189, 0.99);
$pdf->Cell( 100, 7, 'TOURS - PAYMENT INFORMATION', 0, 0, 'C', true );


$total_hotel_expense = ($package_booking_info['total_hotel_expense']!="") ? $package_booking_info['total_hotel_expense']: 0;
$total_tour_expense = ($package_booking_info['total_tour_expense']!="") ? $package_booking_info['total_tour_expense']: 0;
$total_travel_expense = ($package_booking_info['total_travel_expense']!="") ? $package_booking_info['total_travel_expense']: 0;

$subtotal = ($package_booking_info['subtotal']!="") ? $package_booking_info['subtotal']: 0;
$tour_fee = ($package_booking_info['tour_fee']!="") ? $package_booking_info['tour_fee']: 0;
$gst = '';
$gst_amt = ($subtotal * $gst)/100;
$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(10, 55);
$pdf->MultiCell(40, 8, 'Tour Amount', 1);

$pdf->SetXY(50, 55);
$pdf->MultiCell(50, 8, $subtotal, 1,R);
 
$pdf->SetDrawColor(200, 200, 200);

$visa_total_amount= ($package_booking_info['visa_total_amount']!="") ? $package_booking_info['visa_total_amount']: 0;

$pdf->SetFont('Arial','',12);
$pdf->SetXY(110, 55);
$pdf->MultiCell(40, 8, 'Visa Amount', 1);

$pdf->SetXY(150, 55);
$pdf->MultiCell(50, 8, $visa_total_amount, 1,R);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(10, 63);
$pdf->MultiCell(40, 8, get_tax_name().' Amount', 1);

$pdf->SetXY(50, 63);
$pdf->MultiCell(50, 8, number_format($gst_amt, 2), 1,R);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(10, 71);
$pdf->MultiCell(40, 8, 'Subtotal', 1);

$pdf->SetXY(50, 71);
$pdf->MultiCell(50, 8, $package_booking_info['tour_cost_total'], 1,R);

$pdf->SetDrawColor(200, 200, 200);

$insuarance_total_amount= ($package_booking_info['insuarance_total_amount']!="") ? $package_booking_info['insuarance_total_amount']: 0;

// ***************** Tour Information ******************
$tour_amount= ($package_booking_info['actual_tour_expense']!="") ? $package_booking_info['actual_tour_expense']: 0;

$sq_tour_refund = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$booking_id'"));
$can_amount = $sq_tour_refund['total_refund'] - ($sq_tour_refund['total_train_amount'] + $sq_tour_refund['total_plane_amount']);

$total_tour_amount = $tour_amount - $can_amount ;

$pdf->SetFont('Arial','',12);
$pdf->SetXY(110, 63);
$pdf->MultiCell(40, 8, 'Insuarance Amount', 1);

$pdf->SetXY(150, 63);
$pdf->MultiCell(50, 8, $insuarance_total_amount, 1,R);

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(110, 71);
$pdf->MultiCell(40, 8, 'Total Amount', 1);

$pdf->SetXY(150, 71);
$pdf->MultiCell(50, 8, number_format($total_tour_amount,2), 1,R);

//Advance Payment
$payment_count= mysql_num_rows(mysql_query("select * from package_payment_master where booking_id='$booking_id' and payment_for='tour'and advance_status='true' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
if($payment_count > 0)
{
    $payment_details = mysql_fetch_assoc(mysql_query("select * from package_payment_master where booking_id='$booking_id' and payment_for='tour'and advance_status='true' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
    $receipt_no = get_package_booking_payment_id($payment_details['payment_id']);
    $receipt_date = date("d-m-Y",strtotime($payment_details['date']));
    $advance_paid = $payment_details['amount'];
}
else
{
    $receipt_no = "N/A";
    $receipt_date = "N/A";
    $advance_paid ="N/A";
}

//**Tour Payment Sum
$sq_tour_payment = mysql_fetch_assoc(mysql_query("select sum(amount) as sum_payment from package_payment_master where booking_id='$booking_id' and payment_for='tour' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
$balance_amt = $total_tour_amount - $sq_tour_payment['sum_payment'];

$balance_amt = number_format($balance_amt,2);

// ***************** Travel Information ******************
$travel_amount= ($package_booking_info['total_travel_expense']!="") ? $package_booking_info['total_travel_expense']: 0;

$sq_tour_refund = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$booking_id'"));
$can_amount = $sq_tour_refund['total_refund'] - ($sq_tour_refund['total_visa_amount'] + $sq_tour_refund['total_insuarance_amount'] + $sq_tour_refund['total_tour_amount']);

$total_travel_amount = $travel_amount - $can_amount ;

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(10, 85);
$pdf->MultiCell(40, 8, 'Receipt No', 1);

$pdf->SetXY(50, 85);
$pdf->MultiCell(50, 8,$receipt_no , 1);
 
$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(110, 85);
$pdf->MultiCell(40, 8, 'Advance Paid', 1);

$pdf->SetXY(150, 85);
$pdf->MultiCell(50, 8, $advance_paid, 1,R);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(10, 93);
$pdf->MultiCell(40, 8, 'Receipt Date', 1);

$pdf->SetXY(50, 93);
$pdf->MultiCell(50, 8, $receipt_date, 1);

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(110, 93);
$pdf->MultiCell(40, 8, 'Balance Amount', 1);

$pdf->SetXY(150, 93);
$pdf->MultiCell(50, 8,$balance_amt , 1,R);

$pdf->SetXY(55,108);
$pdf->SetFont('Arial','',14);
$pdf->SetFillColor(183, 189, 189, 0.99);
$pdf->Cell( 100, 7, 'TRAVEL - PAYMENT INFORMATION', 0, 0, 'C', true );

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(10, 123);
$pdf->MultiCell(30, 8, 'Train Amount', 1);

$pdf->SetXY(40, 123);
$pdf->MultiCell(30, 8,$package_booking_info['total_train_expense'], 1,R);
 
$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(75, 123);
$pdf->MultiCell(30, 8, 'Air Amount', 1);

$pdf->SetXY(105, 123);
$pdf->MultiCell(30, 8, $package_booking_info['total_plane_expense'], 1,R);

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(140, 123);
$pdf->MultiCell(30, 8, 'Total Amount', 1);

$pdf->SetXY(170, 123);
$pdf->MultiCell(30, 8, number_format($total_travel_amount, 2), 1,R);


$travel_payment_details = mysql_fetch_assoc(mysql_query("select * from package_payment_master where booking_id='$booking_id' and payment_for='traveling' and advance_status='true' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$travel_payment_count= mysql_num_rows(mysql_query("select  * from package_payment_master where booking_id='$booking_id' and payment_for='traveling' and advance_status='true' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$total_payment1 = mysql_fetch_assoc(mysql_query("select sum(amount) as sum_payment from package_payment_master where booking_id='$booking_id' and payment_for='traveling' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
$balance_amt1 = $total_travel_amount - $total_payment1['sum_payment'];
$balance_amt1 = number_format($balance_amt1,2);
if($travel_payment_count > 0)
{
    $receipt_no1 = get_package_booking_payment_id($travel_payment_details['payment_id']);
    $receipt_date1 = date("d-m-Y",strtotime($travel_payment_details['date']));
    $advance_paid1 = $travel_payment_details['amount'];
}
else
{
    $receipt_no1 = "N/A";
    $receipt_date1 = "N/A";
    $advance_paid1 = "N/A";
}

$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(10, 138);
$pdf->MultiCell(40, 8, 'Receipt No', 1);

$pdf->SetXY(50, 138);
$pdf->MultiCell(50, 8,$receipt_no1 , 1);
 
$pdf->SetDrawColor(200, 200, 200);

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(110, 138);
$pdf->MultiCell(40, 8, 'Advance Paid', 1);

$pdf->SetXY(150, 138);
$pdf->MultiCell(50, 8, $advance_paid1, 1,R);

$pdf->SetFont('Arial','',12);
$pdf->SetXY(10, 146);
$pdf->MultiCell(40, 8, 'Receipt Date', 1);

$pdf->SetXY(50, 146);
$pdf->MultiCell(50, 8, $receipt_date1, 1);

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(110, 146);
$pdf->MultiCell(40, 8, 'Balance Amount', 1);

$pdf->SetXY(150, 146);
$pdf->MultiCell(50, 8,$balance_amt1, 1,R);

$sq_train = mysql_num_rows(mysql_query("select booking_id from package_train_master where booking_id='$booking_id'"));
$sq_air = mysql_num_rows(mysql_query("select booking_id from package_plane_master where booking_id='$booking_id'"));

if($sq_train > 0 || $sq_air > 0)
{
    $pdf->SetXY(55,160);
    $pdf->SetFont('Arial','',14);
    $pdf->SetFillColor(183, 189, 189, 0.99);
    $pdf->Cell( 100, 7, 'TRAVEL INFORMATION', 0, 0, 'C', true );

    $sq_train = mysql_num_rows(mysql_query("select booking_id from package_train_master where booking_id='$booking_id'"));
    $train_count = 0;

    if($sq_train>0)
    {
        $pdf->SetFont('Arial','',12);
        $pdf->SetXY(10, 165);
        $pdf->Cell(200, 7, 'Train Details');

        $pdf->SetDrawColor(200, 200, 200);

        $pdf->SetY($pdf->GetY()+10); 

        if($pdf->GetY()+20>$pdf->PageBreakTrigger)
        $pdf->AddPage($pdf->CurOrientation);
        $pdf->SetX(10);

        $pdf->SetWidths(array(10,30,30,20,15,20,15,20,25));
        $pdf->Row(array('Sr.No', 'From Location', 'To Location', 'Train No','Seats','Amount','Class','Priority','Date/Time'));

        $sq_train_details = mysql_query("select * from package_train_master where booking_id='$booking_id'");
        while($row_train_details = mysql_fetch_assoc($sq_train_details))
        {
            $pdf->SetX(10);
            $train_count++;
            $pdf->Row(array($train_count, $row_train_details['from_location'], $row_train_details['to_location'], $row_train_details['train_no'], $row_train_details['seats'], $row_train_details['amount'], $row_train_details['train_class'], $row_train_details['train_priority'],date("d-m-Y H:i", strtotime($row_train_details['date']))));
        }
    }

    $sq_air = mysql_num_rows(mysql_query("select booking_id from package_plane_master where booking_id='$booking_id'"));
    $air_count = 0;

    if($sq_air>0)
    {
        $pdf->SetFont('Arial','',12);
        $y_pos1 = $pdf->getY();
        $y_pos1+=5;
        $pdf->SetXY(10, $y_pos1);
        $pdf->Cell(200, 7, 'Air Details');

        $pdf->SetDrawColor(200, 200, 200);

        $pdf->SetY($pdf->GetY()+10); 

        if($pdf->GetY()+20>$pdf->PageBreakTrigger)
        $pdf->AddPage($pdf->CurOrientation);
        $pdf->SetX(10);

        $pdf->SetWidths(array(10,30,30,25,20,20,20,35));
        $pdf->Row(array('Sr.No', 'From Sector', 'To Sector', 'Company','Seats','Amount','Arrival Time','Departure Time'));

        $sq_air_details = mysql_query("select * from package_plane_master where booking_id='$booking_id'");
        while($row_air_details = mysql_fetch_assoc($sq_air_details))
        {
            $pdf->SetX(10);
            $air_count++;
            $pdf->Row(array($air_count, $row_air_details['from_location'], $row_air_details['to_location'], $row_air_details['company'], $row_air_details['seats'], $row_air_details['amount'], date("d-m-Y H:i", strtotime($row_air_details['arraval_time'])), date("d-m-Y H:i", strtotime($row_air_details['date']))));
        }
    }
}

 






$pdf->Output();

?>