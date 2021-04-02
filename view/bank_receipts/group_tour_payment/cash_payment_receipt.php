<?php include "../../../model/model.php"; ?>
<?php

$payment_amount = $_GET['payment_amount'];
$payment_id = $_GET['payment_id'];
$payment_type = $_GET['payment_type'];

$total_amount = $payment_amount;

$bank_name_arr1 = array();
$branch_name1 = array();
$cheque_no1 = array();
$amount1 = array();
for($i=0; $i<8; $i++)
{
	$bank_name_arr1[$i] = "";
	$branch_name1[$i] = "";
	$cheque_no1[$i] = "";
	$amount1[$i] = "";
}


include_once('../layout/index.php');
?>
