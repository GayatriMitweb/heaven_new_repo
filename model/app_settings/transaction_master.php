<?php
global $transaction_master;
$transaction_master = new transaction_master;

class transaction_master{

public function transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,$tax_type, $payment_side, $clearance_status,$row_spec, $branch_admin_id,$ledger_particular,$type){

	$created_at = date('Y-m-d H:i:s');
	$financial_year_id = $_SESSION['financial_year_id'];

	$sq_max = mysql_fetch_assoc(mysql_query("select max(finance_transaction_id) as max from finance_transaction_master"));
	$finance_transaction_id = $sq_max['max'] + 1;

	$payment_particular = addslashes($payment_particular);
	$q = "insert into finance_transaction_master (finance_transaction_id, financial_year_id, branch_admin_id, module_name, module_entry_id, transaction_id, payment_amount, payment_date, payment_particular, gl_id, payment_side, clearance_status, created_at,row_specification,ledger_particular,type,tax_type) values ('$finance_transaction_id', '$financial_year_id', '$branch_admin_id', '$module_name', '$module_entry_id', '$transaction_id', '$payment_amount', '$payment_date', '$payment_particular', '$gl_id', '$payment_side', '$clearance_status', '$created_at','$row_spec','$ledger_particular','$type','$tax_type')";
	
	$sq_transaction = mysql_query($q);
	if(!$sq_transaction){
		$GLOBALS['flag'] = false;
		echo "error--Transaction entry not added!";
	}
}

public function transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,$tax_type, $payment_side, $clearance_status,$row_spec,$ledger_particular,$type, $old_payment_side=''){

	$financial_year_id = $_SESSION['financial_year_id'];
	if($old_payment_side==""){
		$old_payment_side = $payment_side;
	}
	$payment_particular = addslashes($payment_particular);

	$q1 = "UPDATE finance_transaction_master set financial_year_id='$financial_year_id', transaction_id='$transaction_id', payment_amount='$payment_amount', payment_date='$payment_date', payment_particular='$payment_particular', gl_id='$gl_id', clearance_status='$clearance_status', payment_side='$payment_side',row_specification = '$row_spec', ledger_particular = '$ledger_particular' WHERE module_name='$module_name' and module_entry_id='$module_entry_id' and gl_id='$old_gl_id' and payment_side='$old_payment_side' and type='$type'";

	if($tax_type != '')
		$q1 .= ' and tax_type='.$tax_type;
		
	$sq_transaction = mysql_query($q1);
	if(!$sq_transaction){
		$GLOBALS['flag'] = false;
		echo "error--Transaction not updated!";
	}
}

}

?>