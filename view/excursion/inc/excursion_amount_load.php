<?php
include_once('../../../model/model.php');
//Get selected currency rate
global $currency;
$sq_to = mysql_fetch_assoc(mysql_query("select currency_rate from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$exc_date_arr = $_POST['exc_date_arr'];
$exc_arr = $_POST['exc_arr'];
$transfer_arr = $_POST['transfer_arr'];

$amount_arr = array();
for($i=0;$i<sizeof($exc_arr);$i++){

	$exc_date = date('Y-m-d',strtotime($exc_date_arr[$i]));
	$sq_excursion = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$exc_arr[$i]'"));
	
	$currency_id = $sq_excursion['currency_code'];
	$sq_from = mysql_fetch_assoc(mysql_query("select currency_rate from roe_master where currency_id='$currency_id'"));
	$from_currency_rate = $sq_from['currency_rate'];

	$sq_costing = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff_basics where exc_id='$exc_arr[$i]' and transfer_option='$transfer_arr[$i]' and (from_date <='$exc_date' and to_date>='$exc_date')"));
	$adult_cost = ($from_currency_rate / $to_currency_rate) * $sq_costing['adult_cost'];
	$child_cost = ($from_currency_rate / $to_currency_rate) * $sq_costing['child_cost'];
	$total_cost = $adult_cost + $child_cost;

	$arr = array(
				'total_cost' => $total_cost,
				'adult_cost' => $adult_cost,
				'child_cost' => $child_cost
	);
	array_push($amount_arr, $arr);
}
echo json_encode($amount_arr);
?>