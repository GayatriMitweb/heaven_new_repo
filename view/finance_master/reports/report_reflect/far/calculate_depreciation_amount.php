<?php include "../../../../../model/model.php";
$purchase_amount = $_POST['purchase_amount'];
$depr_type = $_POST['depr_type'];
$rate_of_depr = $_POST['rate_of_depr'];
$financial_year_id = $_POST['financial_year_id'];
$purchase_date = $_POST['purchase_date'];
$asset_name = $_POST['asset_name'];
$asset_ledger = $_POST['asset_ledger'];

$depr_amount = 0;

$purchase_date = get_date_db($purchase_date);
$sq_finacial_year = mysql_fetch_assoc(mysql_query("select * from financial_year where financial_year_id='$financial_year_id'"));

if($purchase_date > $sq_finacial_year['from_date']){
	$date1 = strtotime($sq_finacial_year['to_date']);
	$date2 = strtotime($purchase_date);
	$datediff = $date1 - $date2;

	$diff = round($datediff / (60 * 60 * 24));
}
else{
	$date1 = strtotime($sq_finacial_year['to_date']);
	$date2 = strtotime($sq_finacial_year['from_date']);
	$datediff = $date1 - $date2;

	$diff = round($datediff / (60 * 60 * 24));
}

if($depr_type == 'Straight Line'){
	if($purchase_date > $sq_finacial_year['to_date']){
		echo '0';
	}
	else{
		$depr_amount = ($purchase_amount * ($rate_of_depr / 100) *($diff/365));
		echo $depr_amount;
	}
}
else{
	if($purchase_date > $sq_finacial_year['to_date']){
		echo '0';
	}
	else{
		$sq_depr = mysql_fetch_assoc(mysql_query("select sum(depr_till_date) as depr_till_date from fixed_asset_entries where asset_id ='$asset_name' and asset_ledger ='$asset_ledger'"));
		$sq_depr['depr_till_date'] = ($sq_depr['depr_till_date'] == '') ? '0' : $sq_depr['depr_till_date'];
		$depr_amount1 = (($purchase_amount - $sq_depr['depr_till_date']) * ($rate_of_depr / 100) *($diff/365));
		echo $depr_amount1;
	}
}
?>