<?php 
include "../../../../../model/model.php"; 
$asset_name = $_POST['asset_name'];
$asset_type = $_POST['asset_type'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_POST['branch_admin_id'];
$role = $_POST['role'];
$array_s = array();
$temp_arr = array();
	$count = 1;
	$total_amount = 0;
	$query = "SELECT * FROM `fixed_asset_entries` where 1 "; 
	if($asset_type != ''){
		$query .= " and asset_id in(select entry_id from fixed_asset_master where asset_type ='$asset_type')";
	}
	if($asset_name != ''){
		$query .= " and asset_id in(select entry_id from fixed_asset_master where entry_id ='$asset_name')";
	}
	if($branch_status == 'yes'){
		if($role == 'Branch Admin'){
			$query .= " and branch_admin_id='$branch_admin_id'";
		}
	}
	$query .= "group by asset_ledger order by entry_id desc ";
	$sq_query = mysql_query($query);
	while($row_query = mysql_fetch_assoc($sq_query))
	{
		$sq_asset = mysql_fetch_assoc(mysql_query("select * from fixed_asset_master where entry_id ='$row_query[asset_id]'"));
		$sq_depr = mysql_fetch_assoc(mysql_query("select sum(depr_till_date) as depr_till_date from fixed_asset_entries where asset_id ='$row_query[asset_id]' and asset_ledger ='$row_query[asset_ledger]'"));
		$closing_c_amount = $row_query['purchase_amount'] - $sq_depr['depr_till_date'];

		$sq_latest = mysql_fetch_assoc(mysql_query("select * from fixed_asset_entries where asset_id ='$row_query[asset_id]' and asset_ledger ='$row_query[asset_ledger]' order by entry_id desc"));
		$opening_c_amount = $closing_c_amount + $sq_latest['depr_till_date'];

		if($row_query['sold_amount'] != '0'){ $bg = 'danger'; }else{ $bg = ''; }
		$temp_arr = array( "data" => array(
			(int)($count++),
			$sq_asset['asset_type'] ,
			$sq_asset['asset_name'],
			$row_query['asset_ledger'],
			get_date_user($row_query['purchase_date']),
			$row_query['purchase_amount'] ,
			number_format($opening_c_amount,2),
			$sq_latest['rate_of_depr'],
			$sq_latest['depr_till_date'],
			$sq_depr['depr_till_date'],
			number_format($closing_c_amount,2),
			'<button data-toggle="tooltip" class="btn btn-info btn-sm" onclick="display_modal(\''.$sq_latest['entry_id'] .'\',\''.$sq_latest['asset_ledger'] .'\',\''. $sq_latest['asset_id'] .'\')" title="View Details"><i class="fa fa-eye"></i></button>'
			), "bg" =>$bg);
			array_push($array_s,$temp_arr);
		}
		echo json_encode($array_s);	 
		?>