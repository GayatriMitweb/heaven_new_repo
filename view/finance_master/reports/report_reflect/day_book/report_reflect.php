<?php
include "../../../../../model/model.php";
$today_date = date('Y-m-d');
$from_date = $_POST['from_date'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_POST['branch_admin_id'];
$role = $_POST['role'];
$role_id = $_POST['role_id'];

$array_s = array();
$temp_arr = array();
$count = 1; $total_debit_amount = 0; $total_credit_amount = 0;
$query = "select * from finance_transaction_master where 1 and gl_id != '165' and gl_id != '0'";
if($from_date != ''){
	$from_date = get_date_db($from_date);
	$query .= " and payment_date='$from_date'";
}
else{
	$query .= " and payment_date='$today_date'";
}

include "../../../../../model/app_settings/branchwise_filteration.php";
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query)){
	$debit_amount = 0; $credit_amount = 0;
	$sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_query[gl_id]'"));
	if($row_query['payment_side'] == 'Debit'){ $debit_amount = $row_query['payment_amount']; }
	else{ $credit_amount = $row_query['payment_amount']; }
	$debit_amount = ($debit_amount == '0') ? '' : $debit_amount;
	$credit_amount = ($credit_amount == '0') ? '' : $credit_amount;
	$total_debit_amount += $debit_amount;
	$total_credit_amount += $credit_amount;
	if($row_query['payment_amount'] != '0'){

		$temp_arr = array( "data" => array(
			(int)($count++),
			$sq_ledger['ledger_name'] ,
			($row_query['type']),
			$debit_amount,
			$credit_amount 
			), "bg" =>$bg);
			array_push($array_s,$temp_arr);
		
		}
	}
	$footer_data = array("footer_data" => array(
		'total_footers' => 3,
		
		'foot0' => "Total",
		'col0' => 3,
		'class0' =>"text-right",

		'foot1' => number_format($total_debit_amount,2),
		'col1' => 1,
		'class1' =>"text-right danger",
		'foot2' => number_format($total_credit_amount,2),
		'col2' => 1,
		'class2' =>"text-right success"
		)
	);
	array_push($array_s, $footer_data);
	echo json_encode($array_s);
?>