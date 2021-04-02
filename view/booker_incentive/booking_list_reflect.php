<?php
include "../../model/model.php";

$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id_agent = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$financial_year_id = $_SESSION['financial_year_id'];
$array_s = array();
$temp_arr = array();
function dateSort($a,$b){
    $dateA = strtotime($a['booking_date']);
    $dateB = strtotime($b['booking_date']);
    return ($dateA-$dateB);
}

$group_booking_arr = array();

$query1 = "select * from tourwise_traveler_details where 1 and emp_id != '0' and tour_group_status != 'Cancel' ";
if($emp_id_filter!=""){
	$query1 .= " and emp_id='$emp_id_filter' ";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query1 .= " and date(form_date) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query1 .= " and emp_id='$emp_id_agent' ";	
}
if($branch_status=='yes' && $role!='Admin'){
	$query1 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query1 .= " and emp_id='$emp_id'";
}
 
$query1 .= " order by date(form_date) asc";
$sq_group_bookings = mysql_query($query1);
while($row_group_bookings = mysql_fetch_assoc($sq_group_bookings)){

	$date = $row_group_bookings['form_date'];
	$yr = explode("-", $date);
	$year =$yr[0];

	$sq_pass_count = mysql_num_rows(mysql_query("select * from travelers_details where traveler_group_id = '$row_group_bookings[traveler_group_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from travelers_details where traveler_group_id = '$row_group_bookings[traveler_group_id]' and status='Cancel'"));

	if($sq_pass_count != $sq_pass_cancel)
	{
		$tourwise_traveler_id = $row_group_bookings['id'];			
		$emp_id = $row_group_bookings['emp_id'];			
		$tour_id = $row_group_bookings['tour_id'];
		$tour_group_id = $row_group_bookings['tour_group_id'];
		$booking_date = $row_group_bookings['form_date'];
		$tour_type = "Group Tour";
		$file_no = get_group_booking_id($row_group_bookings['id'],$year);

		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}

		$sq_tour = mysql_fetch_assoc( mysql_query("select tour_name from tour_master where tour_id='$tour_id'") );
		$tour_name = $sq_tour['tour_name'];

		$sq_tour_group = mysql_fetch_assoc( mysql_query("select from_date, to_date from tour_groups where tour_id='$tour_id' and group_id='$tour_group_id'") );
		$tour_group = date('d-m-Y', strtotime($sq_tour_group['from_date']));
		$booking_amount = $row_group_bookings['net_total'] ;

		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id='$row_group_bookings[tour_group_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){		
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$array1 = array(	
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $tourwise_traveler_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,
										'tour_name' => $tour_name,
										'tour_date' => $tour_group,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,						
								  )
					   );
		array_push($group_booking_arr, $array1);
	}			
}


$package_booking_arr = array();

$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];

$query2 = "select * from package_tour_booking_master where 1  and emp_id != '0' and tour_status != 'Cancel'";
if($emp_id_filter!=""){
	$query2 .= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query2 .= " and date(booking_date) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query2 .= " and emp_id='$emp_id_agent' ";	
}

if($branch_status=='yes' && $role!='Admin'){
	$query1 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query1 .= " and emp_id='$emp_id'";
}
 
$query2 .= " order by date(booking_date) asc ";
$sq_package_booking = mysql_query($query2);
while($row_package_booking = mysql_fetch_assoc($sq_package_booking)){
	$date = $row_package_booking['booking_date'];
         $yr = explode("-", $date);
         $year =$yr[0];
	$sq_pass_count = mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id = '$row_package_booking[booking_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id = '$row_package_booking[booking_id]' and status='Cancel'"));
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_package_booking['booking_id'];
		$emp_id = $row_package_booking['emp_id'];
		$tour_name = $row_package_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_package_booking['tour_from_date']));
		$booking_date = $row_package_booking['booking_date'];
		$tour_type = "Package Tour";
		$file_no = get_package_booking_id($row_package_booking['booking_id'],$year);
		$booking_amount = $row_package_booking['net_total'] ;

		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id='$row_package_booking[booking_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}

		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );

		array_push($package_booking_arr, $array1);	
	}
}
// Hotel booking
$hotel_booking_arr = array();
$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];

$query3 = "select * from hotel_booking_master where 1  and emp_id != '0'";
if($emp_id_filter!=""){
	$query3 .= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query3 .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query3 .= " and emp_id='$emp_id_agent' ";	
}

if($branch_status=='yes' && $role!='Admin'){
	$query3 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query3 .= " and emp_id='$emp_id'";
}
$query3 .= " order by date(created_at) asc ";
$sq_hotel_booking = mysql_query($query3);
while($row_hotel_booking = mysql_fetch_assoc($sq_hotel_booking)){
	$date = $row_hotel_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id = '$row_hotel_booking[booking_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id = '$row_hotel_booking[booking_id]' and status='Cancel'"));
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_hotel_booking['booking_id'];
		$emp_id = $row_hotel_booking['emp_id'];
		$tour_name = $row_hotel_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_hotel_booking['tour_from_date']));
		$booking_date = $row_hotel_booking['created_at'];
		$tour_type = "Hotel Booking";
		$file_no = get_hotel_booking_id($row_hotel_booking['booking_id'],$year);
		$booking_amount = $row_hotel_booking['total_fee'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Hotel Booking' and estimate_type_id='$row_hotel_booking[booking_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($hotel_booking_arr, $array1);	
	}
}
// Bus Booking
$bus_booking_arr = array();
$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];

$query4 = "select * from bus_booking_master where 1  and emp_id != '0'";
if($emp_id_filter!=""){
	$query4 .= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query4 .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query4 .= " and emp_id='$emp_id_agent' ";	
}

if($branch_status=='yes' && $role!='Admin'){
	$query4 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query4 .= " and emp_id='$emp_id'";
}
$query4 .= " order by date(created_at) asc ";
$sq_bus_booking = mysql_query($query4);
while($row_bus_booking = mysql_fetch_assoc($sq_bus_booking)){
	$date = $row_bus_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id = '$row_bus_booking[booking_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id = '$row_bus_booking[booking_id]' and status='Cancel'"));
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_bus_booking['booking_id'];
		$emp_id = $row_bus_booking['emp_id'];
		$tour_name = $row_bus_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_bus_booking['tour_from_date']));
		$booking_date = $row_bus_booking['created_at'];
		$tour_type = "Bus Booking";
		$file_no = get_bus_booking_id($row_bus_booking['booking_id'],$year);
		$booking_amount = $row_bus_booking['net_total'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Bus Booking' and estimate_type_id='$row_bus_booking[booking_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($bus_booking_arr, $array1);	
	}
}
// Car Rental Booking
$car_booking_arr = array();
$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];

$query5 = "select * from car_rental_booking where 1  and emp_id != '0' and status!='Cancel'";
if($emp_id_filter!=""){
	$query4 .= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query5 .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query5 .= " and emp_id='$emp_id_agent' ";	
}

if($branch_status=='yes' && $role!='Admin'){
	$query5 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query5 .= " and emp_id='$emp_id'";
}
$query5 .= " order by date(created_at) asc ";
$sq_car_booking = mysql_query($query5);
while($row_car_booking = mysql_fetch_assoc($sq_car_booking)){
	$date = $row_car_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysql_num_rows(mysql_query("select * from car_rental_booking where booking_id = '$row_car_booking[booking_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from car_rental_booking where booking_id = '$row_car_booking[booking_id]' and status='Cancel'"));
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_car_booking['booking_id'];
		$emp_id = $row_car_booking['emp_id'];
		$tour_name = $row_car_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_car_booking['tour_from_date']));
		$booking_date = $row_car_booking['created_at'];
		$tour_type = "Car Rental";
		$file_no = get_car_rental_booking_id($row_car_booking['booking_id'],$year);
		$booking_amount = $row_car_booking['total_fees'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Car Rental' and estimate_type_id='$row_car_booking[booking_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($car_booking_arr, $array1);	
	}
}
//Excursion Rental Booking
$exc_booking_arr = array();
$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];

$query6 = "select * from excursion_master where 1  and emp_id != '0' ";
if($emp_id_filter!=""){
	$query6.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query6 .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query6 .= " and emp_id='$emp_id_agent' ";	
}

if($branch_status=='yes' && $role!='Admin'){
	$query6 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query6 .= " and emp_id='$emp_id'";
}
$query6 .= " order by date(created_at) asc ";
$sq_exc_booking = mysql_query($query6);
while($row_exc_booking = mysql_fetch_assoc($sq_exc_booking)){
	$date = $row_exc_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysql_num_rows(mysql_query("select * from excursion_master_entries	where exc_id = '$row_exc_booking[exc_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id = '$row_exc_booking[exc_id]' and status='Cancel'"));
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_exc_booking['exc_id'];
		$emp_id = $row_exc_booking['emp_id'];
		$tour_name = $row_exc_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_exc_booking['tour_from_date']));
		$booking_date = $row_exc_booking['created_at'];
		$tour_type = "Excursion Booking";
		$file_no = get_exc_booking_id($row_exc_booking['exc_id'],$year);
		$booking_amount = $row_exc_booking['exc_total_cost'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Excursion Booking' and estimate_type_id='$row_exc_booking[exc_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($exc_booking_arr, $array1);	
	}
}
//Forex Rental Booking
$forex_booking_arr = array();
$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];

$query7 = "select * from forex_booking_master where 1  and emp_id != '0' ";
if($emp_id_filter!=""){
	$query7.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query7 .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query7 .= " and emp_id='$emp_id_agent' ";	
}

if($branch_status=='yes' && $role!='Admin'){
	$query7 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query7 .= " and emp_id='$emp_id'";
}
$query7 .= " order by date(created_at) asc ";
$sq_forex_booking = mysql_query($query7);
while($row_forex_booking = mysql_fetch_assoc($sq_forex_booking)){
	$date = $row_forex_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysql_num_rows(mysql_query("select * from excursion_master_entries	where exc_id = '$row_forex_booking[booking_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id = '$row_forex_booking[booking_id]' and status='Cancel'"));
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_forex_booking['booking_id'];
		$emp_id = $row_forex_booking['emp_id'];
		$tour_name = $row_forex_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_forex_booking['tour_from_date']));
		$booking_date = $row_forex_booking['created_at'];
		$tour_type = "Forex Booking";
		$file_no = get_forex_booking_id($row_forex_booking['booking_id'],$year);
		$booking_amount = $row_forex_booking['net_total'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Forex Booking' and estimate_type_id='$row_forex_booking[booking_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($exc_booking_arr, $array1);	
	}
}
//Misc Rental Booking
$misc_booking_arr = array();
$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];

$query8 = "select * from miscellaneous_master where 1  and emp_id != '0' ";
if($emp_id_filter!=""){
	$query8.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query8 .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query8 .= " and emp_id='$emp_id_agent' ";	
}

if($branch_status=='yes' && $role!='Admin'){
	$query8 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query8 .= " and emp_id='$emp_id'";
}
$query8 .= " order by date(created_at) asc ";

$sq_misc_booking = mysql_query($query8);
while($row_misc_booking = mysql_fetch_assoc($sq_misc_booking)){
	$date = $row_misc_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysql_num_rows(mysql_query("select * from miscellaneous_master_entries	where misc_id = '$row_misc_booking[misc_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from miscellaneous_master_entries
	where misc_id = '$row_misc_booking[misc_id]' and status='Cancel'"));
	
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_misc_booking['misc_id'];
		$emp_id = $row_misc_booking['emp_id'];
		$tour_name = $row_misc_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_misc_booking['tour_from_date']));
		$booking_date = $row_misc_booking['created_at'];
		$tour_type = "Miscellaneous Booking";
		$file_no = get_misc_booking_id($row_misc_booking['misc_id'],$year);
		$booking_amount = $row_misc_booking['misc_total_cost'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Miscellaneous Booking' and estimate_type_id='$row_misc_booking[misc_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($misc_booking_arr, $array1);	
	}
}
//Passport Booking
$passport_booking_arr = array();
$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];

$query9 = "select * from passport_master where 1  and emp_id != '0' ";
if($emp_id_filter!=""){
	$query9.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query9 .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query9 .= " and emp_id='$emp_id_agent' ";	
}

if($branch_status=='yes' && $role!='Admin'){
	$query9 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query9 .= " and emp_id='$emp_id'";
}
$query9 .= " order by date(created_at) asc ";

$sq_passport_booking = mysql_query($query9);
while($row_pass_booking = mysql_fetch_assoc($sq_passport_booking)){
	$date = $row_pass_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysql_num_rows(mysql_query("select * from passport_master_entries	where passport_id = '$row_pass_booking[passport_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from passport_master_entries
	where passport_id = '$row_pass_booking[passport_id]' and status='Cancel'"));
	
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_pass_booking['passport_id'];
		$emp_id = $row_pass_booking['emp_id'];
		$tour_name = $row_pass_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_pass_booking['tour_from_date']));
		$booking_date = $row_pass_booking['created_at'];
		$tour_type = "Passport Booking";
		$file_no = get_passport_booking_id($row_pass_booking['passport_id'],$year);
		$booking_amount = $row_pass_booking['passport_total_cost'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Passport Booking' and estimate_type_id='$row_pass_booking[passport_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($passport_booking_arr, $array1);	
	}
}
//Ticket  Booking
$ticket_booking_arr = array();
$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];

$query9 = "select * from ticket_master where 1  and emp_id != '0' ";
if($emp_id_filter!=""){
	$query9.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query9 .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query9 .= " and emp_id='$emp_id_agent' ";	
}

if($branch_status=='yes' && $role!='Admin'){
	$query9 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query9 .= " and emp_id='$emp_id'";
}
$query9 .= " order by date(created_at) asc ";

$sq_ticket_booking = mysql_query($query9);
while($row_ticket_booking = mysql_fetch_assoc($sq_ticket_booking)){
	$date = $row_ticket_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id = '$row_ticket_booking[ticket_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id = '$row_ticket_booking[ticket_id]' and status='Cancel'"));
	
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_ticket_booking['ticket_id'];
		$emp_id = $row_ticket_booking['emp_id'];
		$tour_name = $row_ticket_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_ticket_booking['tour_from_date']));
		$booking_date = $row_ticket_booking['created_at'];
		$tour_type = "Ticket Booking";
		$file_no = get_ticket_booking_id($row_ticket_booking['ticket_id'],$year);
		$booking_amount = $row_ticket_booking['ticket_total_cost'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Ticket Booking' and estimate_type_id='$row_ticket_booking[ticket_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($ticket_booking_arr, $array1);	
	}
}
//Train Ticket Booking
$train_booking_arr = array();
$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];

$query9 = "select * from train_ticket_master where 1  and emp_id != '0' ";
if($emp_id_filter!=""){
	$query9.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query9 .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query9 .= " and emp_id='$emp_id_agent' ";	
}

if($branch_status=='yes' && $role!='Admin'){
	$query9 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query9 .= " and emp_id='$emp_id'";
}
$query9 .= " order by date(created_at) asc ";

$sq_misc_booking1 = mysql_query($query9);
while($row_train_booking = mysql_fetch_assoc($sq_misc_booking1)){
	$date = $row_train_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysql_num_rows(mysql_query("select * from train_ticket_master where train_ticket_id = '$row_train_booking[train_ticket_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from train_ticket_master	where train_ticket_id = '$row_train_booking[train_ticket_id]' and status='Cancel'"));
	
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_train_booking['train_ticket_id'];
		$emp_id = $row_train_booking['emp_id'];
		$tour_name = $row_train_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_train_booking['tour_from_date']));
		$booking_date = $row_train_booking['created_at'];
		$tour_type = "Train Ticket Booking";
		$file_no = get_train_ticket_booking_id($row_train_booking['train_ticket_id'],$year);
		$booking_amount = $row_train_booking['net_total'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Train Ticket Booking' and estimate_type_id='$row_train_booking[train_ticket_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($train_booking_arr, $array1);	
	}
}
//Visa Booking
$visa_booking_arr = array();
$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];

$query10 = "select * from visa_master where 1  and emp_id != '0' ";
if($emp_id_filter!=""){
	$query10.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query10 .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
if($role =='B2b'){
	$query10 .= " and emp_id='$emp_id_agent' ";	
}

if($branch_status=='yes' && $role!='Admin'){
	$query10 .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query10 .= " and emp_id='$emp_id'";
}
$query10 .= " order by date(created_at) asc ";

$sq_visa_booking = mysql_query($query10);
while($row_visa_booking = mysql_fetch_assoc($sq_visa_booking)){
	$date = $row_misc_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysql_num_rows(mysql_query("select * from visa_master_entries	where visa_id = '$row_visa_booking[visa_id]'"));
	$sq_pass_cancel = mysql_num_rows(mysql_query("select * from visa_master_entries
	where misc_id = '$row_visa_booking[visa_id]' and status='Cancel'"));
	
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_visa_booking['visa_id'];
		$emp_id = $row_visa_booking['emp_id'];
		$tour_name = $row_visa_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_visa_booking['tour_from_date']));
		$booking_date = $row_visa_booking['created_at'];
		$tour_type = "Visa Booking";
		$file_no = get_misc_booking_id($row_visa_booking['visa_id'],$year);
		$booking_amount = $row_visa_booking['visa_total_cost'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Visa Booking' and estimate_type_id='$row_visa_booking[visa_id]'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysql_fetch_assoc( mysql_query("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($misc_booking_arr, $array1);	
	}
}

if($tour_type_filter=="Group Tour"){
	$booking_array = $group_booking_arr;
}
if($tour_type_filter=="Package Tour"){
	$booking_array = $package_booking_arr;
}
if($tour_type_filter=="Hotel Booking"){
	$booking_array = $hotel_booking_arr;
}
if($tour_type_filter=="Bus Booking"){
	$booking_array = $bus_booking_arr;
}
if($tour_type_filter=="Car Rental"){
	$booking_array = $car_booking_arr;
}
if($tour_type_filter=="Excursion Booking"){
	$booking_array = $exc_booking_arr;
}
if($tour_type_filter=="Forex Booking"){
	$booking_array = $forex_booking_arr;
}
if($tour_type_filter=="Miscellaneous Booking"){
	$booking_array = $misc_booking_arr;
}
if($tour_type_filter=="Passport Booking"){
	$booking_array = $passport_booking_arr;
}
if($tour_type_filter=="Ticket Booking"){
	$booking_array = $ticket_booking_arr;
}
if($tour_type_filter=="Train Ticket Booking"){
	$booking_array = $train_booking_arr;
}
if($tour_type_filter=="Visa Booking"){
	$booking_array = $visa_booking_arr;
}
if($tour_type_filter==""){
	$booking_array = array_merge($group_booking_arr,$hotel_booking_arr,$package_booking_arr,$bus_booking_arr,$car_booking_arr,$exc_booking_arr,$forex_booking_arr,$misc_booking_arr,$passport_booking_arr,$ticket_booking_arr,$train_booking_arr,$visa_booking_arr);
	usort($booking_array, 'dateSort');
}
// print_r($misc_booking_arr);
$incentive_total = 0; $paid_amount = 0; $balance_amount = 0;
?>

	
		<?php 
		foreach($booking_array as $booking_array_item){

			$other_data_arr = $booking_array_item['other'];

			$emp_id = $other_data_arr['emp_id'];

			if($other_data_arr['tour_type']=="Group Tour"){ $row_bg = "warning"; }
			if($other_data_arr['tour_type']=="Package Tour"){ $row_bg = "info"; }

			
			$booking_id = $other_data_arr['booking_id'];
			$incentive_count = mysql_num_rows(mysql_query("select * from booker_sales_incentive where booking_id='$booking_id' and emp_id='$emp_id' and service_type='$other_data_arr[tour_type]'"));
			if($incentive_count!=0){
				$sq_incentive = mysql_fetch_assoc(mysql_query("select * from booker_sales_incentive where booking_id='$booking_id' and emp_id='$emp_id' and service_type='$other_data_arr[tour_type]'"));	
				$incentive_total = $incentive_total + $sq_incentive['incentive_amount'];
			}
			if($role== 'Admin' || $role=='Branch Admin'){ 
				$booking_id = $other_data_arr['booking_id'];
				$incentive_count = mysql_num_rows(mysql_query("select * from booker_sales_incentive where booking_id='$booking_id' and emp_id='$emp_id'  and service_type='$other_data_arr[tour_type]'"));
				if($incentive_count==0){
					$edit='<a href="javascript:void(0)" onclick="incentive_edit_modal(\''.$other_data_arr['booking_id'] .'\',\''. $other_data_arr['emp_id'] .'\',\''.$other_data_arr['tour_type'].'\')" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit this Incentive"><i class="fa fa-pencil-square-o"></i></a>';
					
				}else{
					$edit = 'NA';
				}
		}
			$temp_arr = array( "data" => array(
				(int)(++$count),
				$other_data_arr['booker_name'],
				$other_data_arr['tour_type'],
				$other_data_arr['file_no'],
				$other_data_arr['tour_name'] ,
				date('d/m/Y', strtotime($other_data_arr['tour_date'])),
				date('d/m/Y', strtotime($booking_array_item['booking_date'])),
				number_format($other_data_arr['booking_amount'],2),
				number_format($other_data_arr['total_purchase'],2),
				number_format($other_data_arr['booking_amount'] - $other_data_arr['total_purchase'],2),
				$incentive_total,
				$edit
				
				), "bg" =>$bg);
			array_push($array_s,$temp_arr); 
					
		}
		$footer_data = array("footer_data" => array(
			'total_footers' => 1,
					
			'foot0' => "Total Incentive :".number_format($incentive_total, 2),
			'col0' => 11,
			'class0' => "text-right"		
			)
		);
		array_push($array_s, $footer_data);
		echo json_encode($array_s);
		
		?>