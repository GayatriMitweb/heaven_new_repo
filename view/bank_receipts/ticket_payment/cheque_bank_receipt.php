<?php include "../../../model/model.php"; ?>
<?php

$payment_id_arr = $_GET['payment_id_arr'];
$branch_name_arr = $_GET['branch_name_arr'];

$payment_id_arr = explode(',',$payment_id_arr);
$branch_name_arr = explode(',',$branch_name_arr);

$payment_id_arr1 = join("','",$payment_id_arr);
$sq_payment = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from ticket_payment_master where payment_id in ('$payment_id_arr1')"));
$total_amount = $sq_payment['sum'];

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
for($i=0; $i<sizeof($payment_id_arr); $i++)
{
	$sq = mysql_query("select * from ticket_payment_master where payment_id='$payment_id_arr[$i]'");
	while($row = mysql_fetch_assoc($sq))
	{
		$bank_name_arr1[$i] = $row['bank_name'];
		$branch_name1[$i] = $branch_name_arr[$i];
		$cheque_no1[$i] = $row['transaction_id'];
		$amount1[$i] = $row['payment_amount'];
	}	
}	


include_once('../layout/index.php');
?>
