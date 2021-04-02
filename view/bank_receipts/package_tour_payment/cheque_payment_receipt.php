<?php include "../../../model/model.php"; ?>
<?php

$payment_id = $_GET['payment_id'];
$branch_name = $_GET['branch_name'];
$total_amount = $_GET['total_amount'];

$payment_id_arr = explode(',',$payment_id);
$branch_name_arr = explode(',',$branch_name);

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
	$sq = mysql_query("select * from package_payment_master where payment_id='$payment_id_arr[$i]'");
	while($row = mysql_fetch_assoc($sq))
	{
		$bank_name_arr1[$i] = $row['bank_name'];
		$branch_name1[$i] = $branch_name_arr[$i];
		$cheque_no1[$i] = $row['transaction_id'];
		$amount1[$i] = $row['amount'];
	}	
}	


include_once('../layout/index.php');
?>
