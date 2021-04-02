<?php
include '../../../model/model.php';
$created_at = date('Y-m-d');
$timestamp = date('U');
$processedArray = array();

$filePath='../../../download/ledger_opening_balances'.$created_at.''.$timestamp.'.csv';
$save = preg_replace('/(\/+)/','/',$filePath);
$downloadurl='../../../../download/ledger_opening_balances'.$created_at.''.$timestamp.'.csv';
header("Content-type: text/csv ; charset:utf-8");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");
$output = fopen($save, "w");
fputcsv($output, array('Ledger Id' , 'Ledger Name' , 'Group Name', 'Debit' , 'Credit'));   

$sq_ledger = mysql_query("select * from ledger_master where 1");
while($row_ledger = mysql_fetch_assoc($sq_ledger)){

	$sq_sl = mysql_fetch_assoc(mysql_query("select * from subgroup_master where subgroup_id='$row_ledger[group_sub_id]'"));
    $credit_balance = ($row_ledger['balance_side'] == 'Credit') ? $row_ledger['balance'] : '';
    $debit_balance = ($row_ledger['balance_side'] == 'Debit') ? $row_ledger['balance'] : '';
    array_push($processedArray,array(
    $row_ledger['ledger_id'],
    $row_ledger['ledger_name'],
    $sq_sl['subgroup_name'],
    $debit_balance,
    $credit_balance));
}

foreach($processedArray as $row){
    fputcsv($output, $row);
}

fclose($output);
echo $downloadurl;
?>