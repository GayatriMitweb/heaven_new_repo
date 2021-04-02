<?php
include "../../../../../../model/model.php";
include_once('../gst_sale/sale_generic_functions.php');

$branch_status = $_POST['branch_status'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

$array_s = array();
$temp_arr = array();
$tax_total = 0;
$markup_tax_total = 0;
$count = 1;

$sq_setting = mysql_fetch_assoc(mysql_query("select * from app_settings where setting_id='1'"));
$sq_supply = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_setting[state_id]'"));

//GIT Booking
$query = "select * from tourwise_traveler_details where 1 ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and form_date between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	//Total count
	$sq_count = mysql_fetch_assoc(mysql_query("select count(traveler_id) as booking_count from travelers_details where traveler_group_id ='$row_query[id]'"));
	//Group cancel or not
	$sq_group = mysql_fetch_assoc(mysql_query("select status from tour_groups where group_id ='$row_query[tour_group_id]'"));

	//Cancelled count
	$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(traveler_id) as cancel_count from travelers_details where traveler_group_id ='$row_query[id]' and status ='Cancel'"));
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
	if($sq_cust['type'] == 'Corporate'){
		$cust_name = $sq_cust['company_name'];
	}else{
		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	}

	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'] || $sq_group['status'] != 'Cancel')
	{
		$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
		$hsn_code = get_service_info('Group Tour');

		//Service tax
		$tax_per = 0;
		$service_tax_amount = 0;
		$tax_name = 'NA';
		if($row_query['service_tax'] !== 0.00 && ($row_query['service_tax']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_query['service_tax']);
			$tax_name = '';
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				$tax_name .= $service_tax[0] . $service_tax[1].' ';
				$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
			}
		}
		//Markup Tax
		$markup_tax_amount = 0;
		$markup_tax_name = 'NA';
		$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
		//Taxable amount
		$taxable_amount = ($service_tax_amount / $tax_per) * 100;
		$tax_total += $service_tax_amount;
		$markup_tax_total += $markup_tax_amount;

		$temp_arr = array( "data" => array(
			(int)($count++),
			"Group Booking",
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_group_booking_id($row_query['id']) ,
			get_date_user($row_query['form_date']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			number_format($row_query['net_total'],2) ,
			number_format($taxable_amount,2) ,
			$tax_name,
			number_format($service_tax_amount,2),
			$markup,
			$markup_tax_name,
			number_format($markup_tax_amount,2),
			"0.00",
			"0.00",
			"",
			""
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
}
//FIT Booking
$query = "select * from package_tour_booking_master where 1 ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and booking_date between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	//Total count
	$sq_count = mysql_fetch_assoc(mysql_query("select count(traveler_id) as booking_count from package_travelers_details where booking_id ='$row_query[booking_id]'"));
	//Cancelled count
	$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(traveler_id) as cancel_count from package_travelers_details where booking_id ='$row_query[booking_id]' and status ='Cancel'"));

	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
	if($sq_cust['type'] == 'Corporate'){
		$cust_name = $sq_cust['company_name'];
	}else{
		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	}

	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
	{
    	$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
    	$hsn_code = get_service_info('Package Tour');  	
		
		//Service tax
		$tax_per = 0;
		$service_tax_amount = 0;
		$tax_name = 'NA';
		if($row_query['tour_service_tax_subtotal'] !== 0.00 && ($row_query['tour_service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_query['tour_service_tax_subtotal']);
			$tax_name = '';
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				$tax_name .= $service_tax[0] . $service_tax[1].' ';
				$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
			}
		}
		//Markup Tax
		$markup_tax_amount = 0;
		$markup_tax_name = 'NA';
		$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
		//Taxable amount
		$taxable_amount = ($service_tax_amount / $tax_per) * 100;
		$tax_total += $service_tax_amount;
		$markup_tax_total += $markup_tax_amount;

		$temp_arr = array( "data" => array(
			(int)($count++),
			"Package Booking",
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_package_booking_id($row_query['booking_id']) ,
			get_date_user($row_query['booking_date']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			number_format($row_query['net_total'],2) ,
			number_format($taxable_amount,2) ,
			$tax_name,
			number_format($service_tax_amount,2),
			$markup,
			$markup_tax_name,
			number_format($markup_tax_amount,2),
			"0.00",
			"0.00",
			"",
			""
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
}
//Visa Booking
$query = "select * from visa_master where 1 ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	//Total count
	$sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from visa_master_entries where visa_id ='$row_query[visa_id]'"));
	//Cancelled count
	$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from visa_master_entries where visa_id ='$row_query[visa_id]' and status ='Cancel'"));
	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
	{
		$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
		if($sq_cust['type'] == 'Corporate')
			$cust_name = $sq_cust['company_name'];
		else
			$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
		
		$hsn_code = get_service_info('Visa');
		$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
		
		//Service tax
		$tax_per = 0;
		$service_tax_amount = 0;
		$tax_name = 'NA';
		if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
			$tax_name = '';
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				$tax_name .= $service_tax[0] . $service_tax[1].' ';
				$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
			}
		}
		//Markup Tax
		$markup_tax_amount = 0;
		$markup_tax_name = 'NA';
		$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
		if($row_query['markup_tax'] !== 0.00 && ($row_query['markup_tax']) !== ''){
			$markup_tax_subtotal1 = explode(',',$row_query['markup_tax']);
			$markup_tax_name = '';
			for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
				$markup_tax = explode(':',$markup_tax_subtotal1[$i]);
				$markup_tax_amount +=  $markup_tax[2];
				$markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
			}
		}
		//Taxable amount
		$taxable_amount = ($service_tax_amount / $tax_per) * 100;
		$tax_total += $service_tax_amount;
		$markup_tax_total += $markup_tax_amount;

		$temp_arr = array( "data" => array(
			(int)($count++),
			"Visa Booking",
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_visa_booking_id($row_query['visa_id']) ,
			get_date_user($row_query['created_at']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			$row_query['visa_total_cost'] ,
			number_format($taxable_amount,2) ,
			$tax_name,
			number_format($service_tax_amount,2),
			$markup,
			$markup_tax_name,
			number_format($markup_tax_amount,2),
			"0.00",
			"0.00",
			"",
			""
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
}
//Passport Booking
$query = "select * from passport_master where 1 ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	//Total count
	$sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from passport_master_entries where passport_id ='$row_query[passport_id]'"));
	//Cancelled count
	$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from passport_master_entries where passport_id ='$row_query[passport_id]' and status ='Cancel'"));
	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count']){

		$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
		if($sq_cust['type'] == 'Corporate'){
			$cust_name = $sq_cust['company_name'];
		}else{
			$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
		}
		$hsn_code = get_service_info('Passport');
		$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
		
		//Service tax
		$tax_per = 0;
		$service_tax_amount = 0;
		$tax_name = 'NA';
		if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
			$tax_name = '';
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				$tax_name .= $service_tax[0] . $service_tax[1].' ';
				$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
			}
		}
		//Markup Tax
		$markup_tax_amount = 0;
		$markup_tax_name = 'NA';
		$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
		//Taxable amount
		$taxable_amount = ($service_tax_amount / $tax_per) * 100;
		$tax_total += $service_tax_amount;
		$markup_tax_total += $markup_tax_amount;

		$temp_arr = array( "data" => array(
			(int)($count++),
			"Passport Booking",
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_passport_booking_id($row_query['passport_id']) ,
			get_date_user($row_query['created_at']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			$row_query['passport_total_cost'] ,
			number_format($taxable_amount,2),
			$tax_name,
			number_format($service_tax_amount,2),
			$markup,
			$markup_tax_name,
			number_format($markup_tax_amount,2),
			"0.00",
			"0.00",
			"",
			""
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
}
//Bus Booking
$query = "select * from bus_booking_master where 1 ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	//Total count
	$sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from bus_booking_entries where booking_id ='$row_query[booking_id]'"));

	//Cancelled count
	$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from bus_booking_entries where booking_id ='$row_query[booking_id]' and status ='Cancel'"));
	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
	{
		$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
		if($sq_cust['type'] == 'Corporate'){
			$cust_name = $sq_cust['company_name'];
		}else{
			$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
		}
		$hsn_code = get_service_info('Bus');
		$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));

		//Service tax
		$tax_per = 0;
		$service_tax_amount = 0;
		$tax_name = 'NA';
		if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
			$tax_name = '';
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				$tax_name .= $service_tax[0] . $service_tax[1].' ';
				$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
			}
		}
		//Markup Tax
		$markup_tax_amount = 0;
		$markup_tax_name = 'NA';
		$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
		if($row_query['markup_tax'] !== 0.00 && ($row_query['markup_tax']) !== ''){
			$markup_tax_subtotal1 = explode(',',$row_query['markup_tax']);
			$markup_tax_name = '';
			for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
				$markup_tax = explode(':',$markup_tax_subtotal1[$i]);
				$markup_tax_amount +=  $markup_tax[2];
				$markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
			}
		}
		//Taxable amount
		$taxable_amount = ($service_tax_amount / $tax_per) * 100;
		$tax_total += $service_tax_amount;
		$markup_tax_total += $markup_tax_amount;
		
		$temp_arr = array( "data" => array(
			(int)($count++),
			"Bus Booking",
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_bus_booking_id($row_query['booking_id']) ,
			get_date_user($row_query['created_at']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			$row_query['net_total'] ,
			number_format($taxable_amount,2) ,
			$tax_name,
			number_format($service_tax_amount,2),
			$markup,
			$markup_tax_name,
			number_format($markup_tax_amount,2),
			"0.00",
			"0.00",
			"",
			""
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
}
//Forex Booking
$query = "select * from forex_booking_master where 1 ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
	if($sq_cust['type'] == 'Corporate'){
		$cust_name = $sq_cust['company_name'];
	}else{
		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	}
	$hsn_code = get_service_info('Forex');
	$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
	
	//Service tax
	$tax_per = 0;
	$service_tax_amount = 0;
	$tax_name = 'NA';
	if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
		$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
		$tax_name = '';
		for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
			$service_tax = explode(':',$service_tax_subtotal1[$i]);
			$service_tax_amount +=  $service_tax[2];
			$tax_name .= $service_tax[0] . $service_tax[1].' ';
			$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
		}
	}
	//Markup Tax
	$markup_tax_amount = 0;
	$markup_tax_name = 'NA';
	$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
	//Taxable amount
	$taxable_amount = ($service_tax_amount / $tax_per) * 100;
	$tax_total += $service_tax_amount;
	$markup_tax_total += $markup_tax_amount;

	$temp_arr = array( "data" => array(
		(int)($count++),
		"Forex Booking",
		$hsn_code ,
		$cust_name,
		($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
		($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
		get_forex_booking_id($row_query['booking_id']) ,
		get_date_user($row_query['created_at']),
		($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
		($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
		$row_query['net_total'] ,
		number_format($taxable_amount,2),
		$tax_name,
		number_format($service_tax_amount,2),
		$markup,
		$markup_tax_name,
		number_format($markup_tax_amount,2),
		"0.00",
		"0.00",
		"",
		""
	), "bg" =>$bg);
	array_push($array_s,$temp_arr);
}
//Activity Booking
$query = "select * from excursion_master where 1 ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	//Total count
 	$sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from excursion_master_entries where exc_id ='$row_query[exc_id]'"));
 	//Cancelled count
 	$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from excursion_master_entries where exc_id ='$row_query[exc_id]' and status ='Cancel'"));
 	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
	{
    	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
    	if($sq_cust['type'] == 'Corporate'){
    		$cust_name = $sq_cust['company_name'];
    	}else{
    		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
    	}
    	$hsn_code = get_service_info('Excursion');
    	$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
		
		//Service tax
		$tax_per = 0;
		$service_tax_amount = 0;
		$tax_name = 'NA';
		if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
			$tax_name = '';
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				$tax_name .= $service_tax[0] . $service_tax[1].' ';
				$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
			}
		}
		//Markup Tax
		$markup_tax_amount = 0;
		$markup_tax_name = 'NA';
		$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
		if($row_query['service_tax_markup'] !== 0.00 && ($row_query['service_tax_markup']) !== ''){
			$markup_tax_subtotal1 = explode(',',$row_query['service_tax_markup']);
			$markup_tax_name = '';
			for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
				$markup_tax = explode(':',$markup_tax_subtotal1[$i]);
				$markup_tax_amount +=  $markup_tax[2];
				$markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
			}
		}
		//Taxable amount
		$taxable_amount = ($service_tax_amount / $tax_per) * 100;
		$tax_total += $service_tax_amount;
		$markup_tax_total += $markup_tax_amount;

		$temp_arr = array( "data" => array(
			(int)($count++),
			"Activity Booking",
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_exc_booking_id($row_query['exc_id']) ,
			get_date_user($row_query['created_at']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			$row_query['exc_total_cost'] ,
			number_format($taxable_amount,2) ,
			$tax_name,
			number_format($service_tax_amount,2),
			$markup,
			$markup_tax_name,
			number_format($markup_tax_amount,2),
			"0.00",
			"0.00",
			"",
			""
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
}

//Hotel Booking
$query = "select * from hotel_booking_master where 1 ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date' ";
}	
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	//Total count
 	$sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from hotel_booking_entries where booking_id ='$row_query[booking_id]'"));

 	//Cancelled count
 	$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from hotel_booking_entries where booking_id ='$row_query[booking_id]' and status ='Cancel'"));
 	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
	{
    	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
    	if($sq_cust['type'] == 'Corporate'){
    		$cust_name = $sq_cust['company_name'];
    	}else{
    		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
    	}
    	$hsn_code = get_service_info('Hotel / Accommodation');
    	$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
		
		//Service tax
		$tax_per = 0;
		$service_tax_amount = 0;
		$tax_name = 'NA';
		if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
			$tax_name = '';
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				$tax_name .= $service_tax[0] . $service_tax[1].' ';
				$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
			}
		}
		//Markup Tax
		$markup_tax_amount = 0;
		$markup_tax_name = 'NA';
		$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
		if($row_query['markup_tax'] !== 0.00 && ($row_query['markup_tax']) !== ''){
			$markup_tax_subtotal1 = explode(',',$row_query['markup_tax']);
			$markup_tax_name = '';
			for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
				$markup_tax = explode(':',$markup_tax_subtotal1[$i]);
				$markup_tax_amount +=  $markup_tax[2];
				$markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
			}
		}
		//Taxable amount
		$taxable_amount = ($service_tax_amount / $tax_per) * 100;
		$tax_total += $service_tax_amount;
		$markup_tax_total += $markup_tax_amount;

		$temp_arr = array( "data" => array(
			(int)($count++),
			"Hotel Booking",
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_hotel_booking_id($row_query['booking_id']) ,
			get_date_user($row_query['created_at']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			$row_query['total_fee'] ,
			number_format($taxable_amount,2) ,
			$tax_name,
			number_format($service_tax_amount,2),
			$markup,
			$markup_tax_name,
			number_format($markup_tax_amount,2),
			"0.00",
			"0.00",
			"",
			""
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
}

//Car Rental Booking
$query = "select * from car_rental_booking where status != 'Cancel' ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
	if($sq_cust['type'] == 'Corporate'){
		$cust_name = $sq_cust['company_name'];
	}else{
		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	}
	$hsn_code = get_service_info('Car Rental');
	$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
	
	//Service tax
	$tax_per = 0;
	$service_tax_amount = 0;
	$tax_name = 'NA';
	if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
		$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
		$tax_name = '';
		for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
			$service_tax = explode(':',$service_tax_subtotal1[$i]);
			$service_tax_amount +=  $service_tax[2];
			$tax_name .= $service_tax[0] . $service_tax[1].' ';
			$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
		}
	}
	//Markup Tax
	$markup_tax_amount = 0;
	$markup_tax_name = 'NA';
	$markup = ($row_query['markup_cost'] == '' || $row_query['markup_cost'] == '0') ? 'NA' : number_format($row_query['markup_cost'],2);
	if($row_query['markup_cost_subtotal'] !== 0.00 && ($row_query['markup_cost_subtotal']) !== ''){
		$markup_tax_subtotal1 = explode(',',$row_query['markup_cost_subtotal']);
		$markup_tax_name = '';
		for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
			$markup_tax = explode(':',$markup_tax_subtotal1[$i]);
			$markup_tax_amount +=  $markup_tax[2];
			$markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
		}
	}
	//Taxable amount
	$taxable_amount = ($service_tax_amount / $tax_per) * 100;
	$tax_total += $service_tax_amount;
	$markup_tax_total += $markup_tax_amount;

	$temp_arr = array( "data" => array(
		(int)($count++),
		"Car Rental Booking" ,
		$hsn_code ,
		$cust_name,
		($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
		($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
		get_car_rental_booking_id($row_query['booking_id'])  ,
		get_date_user($row_query['created_at']),
		($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
		($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
		$row_query['total_fees'] ,
		number_format($taxable_amount,2) ,
		$tax_name,
		number_format($service_tax_amount,2),
		$markup,
		$markup_tax_name,
		number_format($markup_tax_amount,2),
		"0.00",
		"0.00",
		"",
		""
	), "bg" =>$bg);
	array_push($array_s,$temp_arr);
} 
//Flight Booking
$query = "select * from ticket_master where 1 ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date' ";
}

$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	//Total count
	$sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from ticket_master_entries where ticket_id ='$row_query[ticket_id]'"));

	//Cancelled count
	$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from ticket_master_entries where ticket_id ='$row_query[ticket_id]' and status ='Cancel'"));
	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
	{
		$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
		if($sq_cust['type'] == 'Corporate'){
			$cust_name = $sq_cust['company_name'];
		}else{
			$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
		}
		$hsn_code = get_service_info('Flight');
		$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
			
		//Service tax
		$tax_per = 0;
		$service_tax_amount = 0;
		$tax_name = 'NA';
		if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
			$tax_name = '';
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				$tax_name .= $service_tax[0] . $service_tax[1].' ';
				$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
			}
		}
		//Markup Tax
		$markup_tax_amount = 0;
		$markup_tax_name = 'NA';
		$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
		if($row_query['service_tax_markup'] !== 0.00 && ($row_query['service_tax_markup']) !== ''){
			$markup_tax_subtotal1 = explode(',',$row_query['service_tax_markup']);
			$markup_tax_name = '';
			for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
				$markup_tax = explode(':',$markup_tax_subtotal1[$i]);
				$markup_tax_amount +=  $markup_tax[2];
				$markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
			}
		}
		//Taxable amount
		$taxable_amount = ($service_tax_amount / $tax_per) * 100;
		$tax_total += $service_tax_amount;
		$markup_tax_total += $markup_tax_amount;

		$temp_arr = array( "data" => array(
			(int)($count++),
			"Ticket Booking" ,
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_ticket_booking_id($row_query['ticket_id'])  ,
			get_date_user($row_query['created_at']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			$row_query['ticket_total_cost'] ,
			number_format($taxable_amount,2) ,
			$tax_name,
			number_format($service_tax_amount,2),
			$markup,
			$markup_tax_name,
			number_format($markup_tax_amount,2),
			"0.00",
			"0.00",
			"",
			""
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
} 
//Train Booking
$query = "select * from train_ticket_master where 1 ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date' ";
}

$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	//Total count
	$sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from train_ticket_master_entries where train_ticket_id ='$row_query[train_ticket_id]'"));

	//Cancelled count
	$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from train_ticket_master_entries where train_ticket_id ='$row_query[train_ticket_id]' and status ='Cancel'"));
	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
	{
		$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
		if($sq_cust['type'] == 'Corporate'){
			$cust_name = $sq_cust['company_name'];
		}else{
			$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
		}
		$hsn_code = get_service_info('Train');
		$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));

		//Service tax
		$tax_per = 0;
		$service_tax_amount = 0;
		$tax_name = 'NA';
		if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
			$tax_name = '';
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				$tax_name .= $service_tax[0] . $service_tax[1].' ';
				$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
			}
		}
		//Markup Tax
		$markup_tax_amount = 0;
		$markup_tax_name = 'NA';
		$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
		//Taxable amount
		$taxable_amount = ($service_tax_amount / $tax_per) * 100;
		$tax_total += $service_tax_amount;
		$markup_tax_total += $markup_tax_amount;

		$temp_arr = array( "data" => array(
			(int)($count++),
			"Train Ticket Booking" ,
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_train_ticket_booking_id($row_query['train_ticket_id'])  ,
			get_date_user($row_query['created_at']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			$row_query['net_total'] ,
			number_format($taxable_amount,2) ,
			$tax_name,
			number_format($service_tax_amount,2),
			$markup,
			$markup_tax_name,
			number_format($markup_tax_amount,2),
			"0.00",
			"0.00",
			"",
			""
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
} 
//Miscellaneous Booking
$query = "select * from miscellaneous_master where 1 ";
if($from_date !='' && $to_date != ''){
$from_date = get_date_db($from_date);
$to_date = get_date_db($to_date);
$query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	//Total count
	$sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from miscellaneous_master_entries where misc_id ='$row_query[misc_id]'"));

	//Cancelled count
	$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from miscellaneous_master_entries where misc_id	 ='$row_query[misc_id]' and status ='Cancel'"));
	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
	{
		$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
		if($sq_cust['type'] == 'Corporate'){
			$cust_name = $sq_cust['company_name'];
		}else{
			$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
		}
		$hsn_code = get_service_info('Miscellaneous');
		$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
		
		//Service tax
		$tax_per = 0;
		$service_tax_amount = 0;
		$tax_name = 'NA';
		if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
			$tax_name = '';
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				$tax_name .= $service_tax[0] . $service_tax[1].' ';
				$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
			}
		}
		//Markup Tax
		$markup_tax_amount = 0;
		$markup_tax_name = 'NA';
		$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
		if($row_query['service_tax_markup'] !== 0.00 && ($row_query['service_tax_markup']) !== ''){
			$markup_tax_subtotal1 = explode(',',$row_query['service_tax_markup']);
			$markup_tax_name = '';
			for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
				$markup_tax = explode(':',$markup_tax_subtotal1[$i]);
				$markup_tax_amount +=  $markup_tax[2];
				$markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
			}
		}
		//Taxable amount
		$taxable_amount = ($service_tax_amount / $tax_per) * 100;
		$tax_total += $service_tax_amount;
		$markup_tax_total += $markup_tax_amount;

		$temp_arr = array( "data" => array(
			(int)($count++),
			"Miscellaneous Booking" ,
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_misc_booking_id($row_query['misc_id'])  ,
			get_date_user($row_query['created_at']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			$row_query['misc_total_cost'] ,
			number_format($taxable_amount,2) ,
			$tax_name,
			number_format($service_tax_amount,2),
			$markup,
			$markup_tax_name,
			number_format($markup_tax_amount,2),
			"0.00",
			"0.00",
			"",
			""
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	} 
}
//Income Booking
$query = "select * from other_income_master where 1 ";
if($from_date !='' && $to_date != ''){
$from_date = get_date_db($from_date);
$to_date = get_date_db($to_date);
$query .= " and receipt_date between '$from_date' and '$to_date' ";
}

$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	$taxable_amount = $row_query['amount'];
	$sq_income_type_info = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_query[income_type_id]'"));
	$hsn_code = '9985';
	
	//Service tax
	$tax_per = 0;
	$service_tax_amount = 0;
	$tax_name = 'NA';
	//Markup Tax
	$markup_tax_amount = 0;
	$markup_tax_name = 'NA';
	$markup = number_format(0,2);
	//Taxable amount
	$tax_total += $row_query['service_tax_subtotal'];
	$temp_arr = array( "data" => array(
		(int)($count++),
		$sq_income_type_info['ledger_name'] ,
		$hsn_code ,
		$row_query['receipt_from'],
		'NA' ,
		($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'],
		get_other_income_payment_id($row_query['income_id'])  ,
		get_date_user($row_query['created_at']),
		'Unregistered',
		'NA',
		$row_query['total_fee'] ,
		number_format($taxable_amount,2) ,
		'NA',
		number_format($row_query['service_tax_subtotal'],2),
		$markup,
		$markup_tax_name,
		number_format($markup_tax_amount,2),
		"0.00",
		"0.00",
		"",
		""
	), "bg" =>$bg);
	array_push($array_s,$temp_arr);
}
					
$footer_data = array("footer_data" => array(
	'total_footers' => 4,
	
	'foot0' => 'Total TAX :'.number_format($tax_total,2),
	'col0' => 14,
	'class0' =>"info text-left",

	'foot1' => '',
	'col1' => 1,
	'class1' =>"info text-left",

	'foot2' => 'Total Markup TAX :'.number_format($markup_tax_total,2),
	'col2' => 2,
	'class2' =>"info text-left",

	'foot3' => '',
	'col3' => 12,
	'class3' =>"info text-left"
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>
	