<?php
include_once('../../../../model/model.php');
$total_adult = $_POST['total_adult'];
$children_without_bed = $_POST['children_without_bed'];
$children_with_bed = $_POST['children_with_bed'];
$total_infant = $_POST['total_infant'];
$exc_date_arr = $_POST['exc_date_arr'];
$exc_arr = $_POST['exc_arr'];
$transfer_arr = $_POST['transfer_arr'];
$amount_arr = array();

//Get selected currency rate
global $currency;
$sq_to = mysql_fetch_assoc(mysql_query("select currency_rate from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

for($i=0;$i<sizeof($exc_arr);$i++){

	$exc_date = date('Y-m-d',strtotime($exc_date_arr[$i]));
	$sq_excursion = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$exc_arr[$i]'"));
	
	$currency_id = $sq_excursion['currency_code'];
	$sq_from = mysql_fetch_assoc(mysql_query("select currency_rate from roe_master where currency_id='$currency_id'"));
	$from_currency_rate = $sq_from['currency_rate'];

	$sq_costing = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff_basics where exc_id='$exc_arr[$i]' and transfer_option='$transfer_arr[$i]' and (from_date <='$exc_date' and to_date>='$exc_date')"));
	$child_cost = ($from_currency_rate / $to_currency_rate) * $sq_costing['child_cost'];

	//If adults are there
	if($total_adult != 0)
		$adult_cost = ($from_currency_rate / $to_currency_rate) * $sq_costing['adult_cost'];
	else
		$adult_cost = 0;
	//If infants are there
	if($total_infant != 0)
		$infant_cost = ($from_currency_rate / $to_currency_rate) * $sq_costing['infant_cost'];
	else
		$infant_cost = 0;
	//If child without bed are there
	if($children_without_bed != 0)
		$child_cost1 = ($child_cost * $children_without_bed);
	else
		$child_cost1 = 0;
	//If child with bed are there
	if($children_with_bed != 0)
		$child_cost2 = ($child_cost * $children_with_bed);
	else
		$child_cost2 = 0;

	$total_cost = ($adult_cost * $total_adult) + $child_cost1 + $child_cost2 + ($infant_cost * $total_infant);

	$arr = array('total_cost' => $total_cost,
				'adult_cost' => $adult_cost,
				'child_cost' => $child_cost,
				'infant_cost' => $infant_cost);
    
	array_push($amount_arr, $arr);
}
echo json_encode($amount_arr);
?>