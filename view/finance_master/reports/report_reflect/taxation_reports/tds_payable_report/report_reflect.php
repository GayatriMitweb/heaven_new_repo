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
	$query = "select * from vendor_estimate where status =''";
	if($from_date != '' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date'"; 		
	}
	include "../../../../../../model/app_settings/branchwise_filteration.php";
	$sq_query = mysql_query($query);
	while($row_query = mysql_fetch_assoc($sq_query))
	{
	$tds_on_amount = $row_query['basic_cost'] + $row_query['non_recoverable_taxes'] + $row_query['service_charge']+ $row_query['other_charges'];
	$supp_name = get_vendor_name_report($row_query['vendor_type'],$row_query['vendor_type_id']);
	$supp_pan_no = get_vendor_pan_report($row_query['vendor_type'],$row_query['vendor_type_id']);
	if($row_query['tds'] != '0'){
		$temp_arr = array( "data" => array(
			(int)($count++),
			get_date_user($row_query['created_at']),
			$supp_name ,
			($supp_pan_no == '') ? 'NA' : $supp_pan_no,
			number_format($tds_on_amount,2) ,
			number_format($row_query['tds'],2) 

		), "bg" =>$bg);
		array_push($array_s,$temp_arr);			 
	} 
	}
	//Other Expense
	$query = "select * from other_expense_master where 1 ";
	if($from_date != '' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date'"; 		
	}
	include "../../../../../../model/app_settings/branchwise_filteration.php";
	$sq_query = mysql_query($query);
	while($row_query = mysql_fetch_assoc($sq_query))
	{		 
	$sq_supp = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$row_query[supplier_id]'"));
	$sq_exp = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_query[expense_type_id]'"));
	if($row_query['tds'] != '0'){
		$temp_arr = array( "data" => array(
			(int)($count++),
			get_date_user($row_query['created_at']),
			($sq_supp['vendor_name'] == '') ? $sq_exp['ledger_name'] : $sq_supp['vendor_name'] ,
			($sq_supp['pan_no'] == '') ? 'NA' : $sq_supp['pan_no'],
			number_format($row_query['amount'],2) ,
			number_format($row_query['tds'],2) 

		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
	}
echo json_encode($array_s);
?>
	