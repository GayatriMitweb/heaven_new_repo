<?php
$flag = true; 
class bank_master{

public function bank_master_save()
{
	$bank_name = $_POST['bank_name'];
	$branch_name = $_POST['branch_name'];
	$address = $_POST['address'];
	$account_no = $_POST['account_no'];
	$ifsc_code = $_POST['ifsc_code'];
	$swift_code = $_POST['swift_code'];
	$account_type = $_POST['account_type'];
	$mobile_no = $_POST['mobile_no'];
	$opening_balance = $_POST['opening_balance'];
	$active_flag = $_POST['active_flag'];
	$as_of_date = $_POST['as_of_date'];

	$created_at = date('Y-m-d H:i:s');
	$as_of_date = get_date_db($as_of_date);

	//**Starting transaction
	begin_t();

	$sq_count = mysql_num_rows(mysql_query("select bank_name from bank_master where bank_name='$bank_name' and branch_name='$branch_name'"));
	if($sq_count>0){
		echo "error--Bank name already exists!";
		exit;
	}

	$sq_max = mysql_fetch_assoc(mysql_query("select max(bank_id) as max from bank_master"));
	$bank_id = $sq_max['max'] + 1;

	$sq_bank = mysql_query("insert into bank_master (bank_id, bank_name, branch_name, address, account_no, ifsc_code, swift_code, account_type, mobile_no, opening_balance,active_flag, created_at,as_of_date) values ('$bank_id', '$bank_name', '$branch_name', '$address', '$account_no', '$ifsc_code', '$swift_code', '$account_type', '$mobile_no', '$opening_balance', '$active_flag', '$created_at','$as_of_date')");

	if($bank_id == 1){
		$sq_app_settings_bank = mysql_query("UPDATE app_settings SET bank_name='$bank_name', acc_name='$account_type', bank_acc_no='$account_no', bank_branch_name='$branch_name', bank_ifsc_code='$ifsc_code', bank_swift_code='$swift_code'");
	}

	get_bank_balance_update();

	//Creating ledger
	$sq_max = mysql_fetch_assoc(mysql_query("select max(ledger_id) as max from ledger_master"));
	$ledger_id = $sq_max['max'] + 1;
	$ledger_name = $bank_name.'('.$branch_name.')';

	$sq_ledger = mysql_query("insert into ledger_master (ledger_id, ledger_name, alias, group_sub_id, balance, dr_cr,customer_id,user_type) values ('$ledger_id', '$ledger_name', '', '24', '0','Dr','$bank_id','bank')");
		
	if(!$sq_bank){
		$GLOBALS['flag'] = false;
		echo "error--Sorry, Bank not saved!";
	}

	if($GLOBALS['flag']){
		commit_t();
		echo "Bank has been successfully saved.";
		exit;
	}
	else{
		rollback_t();
		exit;
	}

}

public function bank_master_update()
{
	$bank_id = $_POST['bank_id'];
	$bank_name = $_POST['bank_name'];
	$branch_name = $_POST['branch_name'];
	$address = $_POST['address'];
	$account_no = $_POST['account_no'];
	$ifsc_code = $_POST['ifsc_code'];
	$swift_code = $_POST['swift_code'];
	$account_type = $_POST['account_type'];
	$mobile_no = $_POST['mobile_no'];
	$opening_balance = $_POST['opening_balance'];
	$active_flag = $_POST['active_flag'];
	$as_of_date = $_POST['as_of_date'];
	$as_of_date = get_date_db($as_of_date);

	$sq_count = mysql_num_rows(mysql_query("select bank_name from bank_master where bank_name='$bank_name' and bank_id!='$bank_id' and branch_name='$branch_name'"));
	if($sq_count>0){
		echo "error--Bank name already exists!";
		exit;
	}

	//**Starting transaction
	begin_t();

	$sq_bank = mysql_query("update bank_master set bank_name='$bank_name', branch_name='$branch_name', address='$address', account_no='$account_no', ifsc_code='$ifsc_code', swift_code='$swift_code', account_type='$account_type', mobile_no='$mobile_no', opening_balance='$opening_balance', active_flag='$active_flag',as_of_date='$as_of_date' where bank_id='$bank_id'");

	if($bank_id == 1){
		$sq_app_settings_bank = mysql_query("UPDATE app_settings SET bank_name='$bank_name', acc_name='$account_type', bank_acc_no='$account_no', bank_branch_name='$branch_name', bank_ifsc_code='$ifsc_code', bank_swift_code='$swift_code'");
	}

	$ledger_name = $bank_name.'('.$branch_name.')';
	$sq_bank = mysql_query("update ledger_master set ledger_name='$ledger_name' where user_type='bank' and customer_id='$bank_id'");
	
	if(!$sq_bank){
		$GLOBALS['flag'] = false;
		echo "error--Sorry, Bank not updated!";
	}	

	if($GLOBALS['flag']){
		commit_t();
		echo "Bank has been successfully updated.";
		exit;
	}
	else{
		rollback_t();
		exit;
	}
}
}
?>