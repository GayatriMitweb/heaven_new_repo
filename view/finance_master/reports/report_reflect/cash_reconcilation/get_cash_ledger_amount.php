<?php 
include '../../../../../model/model.php';
$total_amount = 0;
$branch_admin_id = $_POST['branch_admin_id'];

$query = "select * from finance_transaction_master where gl_id='20' ";
if($branch_admin_id != '0'){
	 $query .= " and branch_admin_id = '$branch_admin_id'";
}
$sq_cash = mysql_query($query);
while($row_cash = mysql_fetch_assoc($sq_cash)){
	if($row_cash['payment_side'] == 'Credit'){
		$total_amount -= $row_cash['payment_amount'];
	}else{
		$total_amount += $row_cash['payment_amount'];
	}
}
echo $total_amount;
?>