<?php include "../../../../../../model/model.php"; 
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$branch_status = $_POST['branch_status'];
$role = $_POST['role'];
$branch_admin_id = $_POST['branch_admin_id'];
$array_s = array();
$temp_arr = array();

	
	$count = 1;
	//Hotel
	$query = "select * from hotel_booking_master where 1 ";
	if($from_date != '' && $to_date != ''){
		$from_date = get_date_db($from_date);
		$to_date = get_date_db($to_date);
		$query .= " and created_at between '$from_date' and '$to_date'"; 		
	}
	include "../../../../../../model/app_settings/branchwise_filteration.php";
	$sq_query = mysql_query($query);

	while($row_query = mysql_fetch_assoc($sq_query))
	{
		//Total hotels count
		$sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from hotel_booking_entries where booking_id ='$row_query[booking_id]'"));

		//Cancelled hotels count
		$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from hotel_booking_entries where booking_id ='$row_query[booking_id]' and status ='Cancel'"));

		if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
		{
			$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
			if($sq_cust['type'] == 'Corporate'){
				$cust_name = $sq_cust['company_name'];
			}else{
				$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
			}
			$tds_on_amount = $row_query['sub_total'] + $row_query['service_charge'];
			if($row_query['tds'] != '0'){
				
					$temp_arr = array( "data" => array(
						(int)($count++),
						get_date_user($row_query['created_at']),
						$cust_name ,
						($sq_cust['pan_no'] == '') ? 'NA' : $sq_cust['pan_no'],
						number_format($tds_on_amount,2) ,
						number_format($row_query['tds'],2) 

					), "bg" =>$bg);
				array_push($array_s,$temp_arr);
			}
		} 
	}
	//Flight
	$tds_on_amount = 0;
	$query = "select * from ticket_master where 1 ";
	if($from_date != '' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date'"; 		
	}
	include "../../../../../../model/app_settings/branchwise_filteration.php";
	$sq_query = mysql_query($query);
	while($row_query = mysql_fetch_assoc($sq_query))
	{
		//Total passenger count
		$sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from ticket_master_entries where ticket_id ='$row_query[ticket_id]'"));

		//Cancelled passenger count
		$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from ticket_master_entries where ticket_id ='$row_query[ticket_id]' and status ='Cancel'"));
		if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
		{
			$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
			if($sq_cust['type'] == 'Corporate'){
				$cust_name = $sq_cust['company_name'];
			}else{
				$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
			}
			$tds_on_amount = $row_query['basic_cost'] + $row_query['basic_cost_markup'] - $row_query['basic_cost_discount'] + $row_query['yq_tax']+ $row_query['yq_tax_markup'] - $row_query['yq_tax_discount'] + $row_query['g1_plus_f2_tax'] + $row_query['service_charge'];	
			if($row_query['tds'] != '0'){
				
				$temp_arr = array( "data" => array(
					(int)($count++),
					get_date_user($row_query['created_at']),
					$cust_name ,
					($sq_cust['pan_no'] == '') ? 'NA' : $sq_cust['pan_no'],
					number_format($tds_on_amount,2) ,
					number_format($row_query['tds'],2) 

				), "bg" =>$bg);
			array_push($array_s,$temp_arr);
			} 
		}
	} 
	//Other Income
	$query = "select * from other_income_master where 1 ";
	if($from_date != '' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date'"; 		
	}
	$sq_query = mysql_query($query);
	while($row_query = mysql_fetch_assoc($sq_query))
	{		 
		if($row_query['tds'] != '0'){
				$temp_arr = array( "data" => array(
					(int)($count++),
					get_date_user($row_query['created_at']),
					$row_query['receipt_from'] ,
					($row_query['pan_no'] == '') ? 'NA' : $row_query['pan_no'],
					number_format($row_query['amount'],2) ,
					number_format($row_query['tds'],2) 

				), "bg" =>$bg);
			array_push($array_s,$temp_arr);
			}
	}
	echo json_encode($array_s);
	?>	
