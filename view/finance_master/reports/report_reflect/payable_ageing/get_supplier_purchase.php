<?php
 include "../../../../../model/model.php";
 include_once('../../../../../model/app_generic_functions.php');

$array_s = array();
$temp_arr = array();
$till_date = $_POST['till_date'];
$vendor_type = $_POST['vendor_type'];
$vendor_type_id = $_POST['vendor_type_id'];
$branch_status = $_POST['branch_status'];
$role = $_POST['role'];
$branch_admin_id = $_POST['branch_admin_id'];

$till_date1 = get_date_user($till_date);

$total_outstanding_total = 0; $not_due_total = 0; $total_due_total = 0;
$group1_total = 0; $group2_total = 0; $group3_total=0; $group4_total=0; $group5_total=0; $group6_total=0; $group7_total=0;

$count=1;
$query = "select * from vendor_estimate where 1 ";
if($vendor_type != ''){
	$query .= " and vendor_type = '$vendor_type' ";
}
if($vendor_type_id != ''){
	$query .= " and vendor_type_id='$vendor_type_id'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$query .= " group by vendor_type, vendor_type_id";

$sq_supplier = mysql_query($query);
while($row_supplier = mysql_fetch_assoc($sq_supplier))
{
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
	$total_outstanding = 0; $not_due = 0; $total_due = 0;
	$group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

	$booking_id_arr = array();
	$pending_amt_arr = array();
	$total_days_arr = array();
	$not_due_arr = array();
	$due_date_arr = array();

	$sq_pacakge = mysql_query("select * from vendor_estimate where vendor_type='$row_supplier[vendor_type]' and vendor_type_id ='$row_supplier[vendor_type_id]' ");
	while($row_package = mysql_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;

		$booking_amt = $row_package['net_total'];
		$total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from vendor_payment_master where vendor_type='$row_package[vendor_type]' and vendor_type_id ='$row_package[vendor_type_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		$cancel_est = $row_package['cancel_amount'];

		//Consider sale cancel amount
		if($cancel_est != '0'){ 			
			if($cancel_est <= $total_paid){
				$pending_amt  = 0;
			}
			else{
				$pending_amt =  $cancel_est - $total_paid;
			}
		}
		else{
			$pending_amt = $booking_amt-$total_paid;
		}

		$due_date = get_date_user($row_package['due_date']);
		if(strtotime($till_date1) < strtotime($due_date)) {
			$not_due = $pending_amt;
		    $total_due = 0;		
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,'0'); 
				array_push($not_due_arr,$pending_amt);
				array_push($total_days_arr,'NA'); 
			}    
		}
		else{
			$not_due = 0;
		    //////get total days count////
		    $date1_ts = strtotime($till_date1);
				$date2_ts = strtotime($due_date);
				$diff = $date1_ts - $date2_ts;
				$total_days = round($diff / 86400);
		    //////////////////////////////
		    if($total_days>='0' && $total_days<='30') { $group1  += $pending_amt; } 
		    if($total_days>'30' && $total_days<='60') { $group2  += $pending_amt; } 
		    if($total_days>'60' && $total_days<='90') { $group3  += $pending_amt;} 
		    if($total_days>'90' && $total_days<='120') { $group4  += $pending_amt; } 
		    if($total_days>'120' && $total_days<='180') { $group5 += $pending_amt; }
		    if($total_days>'180' && $total_days<='360') { $group6 += $pending_amt; }
		    if($total_days>'360'){ $group7  += $pending_amt; } 
		    
			if($pending_amt>'0'){
				array_push($pending_amt_arr,$pending_amt); 
				array_push($total_days_arr,$total_days); 
				array_push($not_due_arr,'0');
		    }
		}
		$total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
		$total_outstanding = $total_due + $not_due;
		

		if($total_outstanding>'0'){ 
			array_push($booking_id_arr,$row_package['estimate_id']); 
			array_push($due_date_arr,$row_package['due_date']);
		}
	}
	$supplier_name = get_vendor_name_report($row_supplier['vendor_type'], $row_supplier['vendor_type_id']);
	

	if($total_outstanding>'0'){
		$total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
		$group7_total += $group7;

		$temp_arr = array( "data" => array(
			(int)($count++),
			$row_supplier['vendor_type'],
			$supplier_name,
			'<button class="btn btn-info btn-sm" onclick="view_modal(\''. implode(',', $booking_id_arr).'\',\''. implode(',', $pending_amt_arr).'\',\''.implode(',', $not_due_arr).'\',\''. implode(',',$total_days_arr).'\',\''. implode(',', $due_date_arr).'\')" data-toggle="tooltip" title="Ageing Information"><i class="fa fa-eye"></i></button>',
			
			number_format($total_outstanding,2),
			number_format($not_due,2) ,
			number_format($total_due,2),
			number_format($group1,2),
			number_format($group2,2),
			number_format($group3,2),
			number_format($group4,2),
			number_format($group5,2),
			number_format($group6,2),
			number_format($group7,2)

			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
}
$footer_data = array("footer_data" => array(
	'total_footers' => 11,
	
	'foot0' => "TOTAL : ",
	'col0' => 4,
	'class0' =>"text-center",

	'foot1' => number_format($total_outstanding_total,2),
	'col1' => 1,
	'class1' =>"text-center",

	'foot2' => number_format($not_due_total,2),
	'col2' => 1,
	'class2' =>"text-center",

	'foot3' => number_format($total_due_total,2),
	'col3' => 1,
	'class3' =>"text-center",

	'foot4' => number_format($group1_total,2),
	'col4' => 1,
	'class4' =>"text-center",

	'foot5' => number_format($group2_total,2),
	'col5' => 1,
	'class5' =>"text-center",

	'foot6' => number_format($group3_total,2),
	'col6' => 1,
	'class6' =>"text-center",

	'foot7' => number_format($group4_total,2),
	'col57' => 1,
	'class7' =>"text-center",

	'foot8' => number_format($group5_total,2),
	'col8' => 1,
	'class8' =>"text-center",
	'foot9' => number_format($group6_total,2),
	'col9' => 1,
	'class9' =>"text-center",

	'foot10' => number_format($group7_total,2),
	'col10' => 1,
	'class10' =>"text-center"
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>

