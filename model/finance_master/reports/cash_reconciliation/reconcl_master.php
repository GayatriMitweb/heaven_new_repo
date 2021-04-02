<?php 
class reconcl_master{

public function reconcl_master_save()
{
	$branch_admin_id = $_POST['branch_admin_id'];
	$date = $_POST['date'];
	$system_cash = $_POST['system_cash'];
	$till_cash = $_POST['till_cash'];
	$diff_prior = $_POST['diff_prior'];
	$reconcl_amount = $_POST['reconcl_amount'];
	$diff_reconcl  = $_POST['diff_reconcl'];
	$denom_amount_arr = $_POST['denom_amount_arr'];
	$numbers_arr = $_POST['numbers_arr'];
	$total_amount_arr = $_POST['total_amount_arr'];
	$reason_arr = $_POST['reason_arr'];
	$reason_amount_arr = $_POST['reason_amount_arr'];

	$date1 = get_date_db($date);
	begin_t();

	//Master table
	$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from cash_reconcl_master"));
	$id = $sq_max['max'] + 1;
	$sq_cash = mysql_query("insert into cash_reconcl_master (id, reconcl_date, branch_admin_id, system_cash, till_cash, diff_prior, reconcl_amount, diff_reconcl) values ('$id','$date1','$branch_admin_id','$system_cash','$till_cash','$diff_prior','$reconcl_amount','$diff_reconcl')");

	//Denominations
	for($i = 0;$i<sizeof($denom_amount_arr);$i++){
		$sq_max = mysql_fetch_assoc(mysql_query("select max(denom_id) as max from cash_denomination_master"));
		$denom_id = $sq_max['max'] + 1;
		$sq_cash = mysql_query("insert into cash_denomination_master (denom_id, id, denomination, numbers, amount) values ('$denom_id', '$id', '$denom_amount_arr[$i]', '$numbers_arr[$i]', '$total_amount_arr[$i]')");
	}

	//Reconciliation reasons
	for($i = 0;$i<sizeof($reason_arr);$i++){
		$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from cash_reconcl_master_entries"));
		$entry_id = $sq_max['max'] + 1;
		$sq_cash = mysql_query("insert into cash_reconcl_master_entries (entry_id, id, reason, amount) values ('$entry_id', '$id', '$reason_arr[$i]', '$reason_amount_arr[$i]')");
	}
	if($sq_cash){
		commit_t();
		echo "Cash Reconciliation Done!";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Cash Reconciliation Not Done!";
		exit;
	}

}
//Approval save
public function reconcl_approval_save()
{
	$approve_status = $_POST['approve_status'];
	$cash_id = $_POST['cash_id'];

	$sq_approve = mysql_query("Update cash_reconcl_master set approval_status ='$approve_status' where id='$cash_id'");
	if($sq_approve){
		commit_t();
		echo "Approval Done!";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Approval Not Done!";
		exit;
	}
}

}
?>