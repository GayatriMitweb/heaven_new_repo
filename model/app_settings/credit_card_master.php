<?php
class credit_card{

	public function save(){
		
		$company_name = $_POST['company_name'];
		$charges_in = $_POST['charges_in'];
		$credit_card_charges = $_POST['credit_card_charges'];
		$tax_charges_in =$_POST['tax_charges_in'];
		$tax_on_credit_card_charges = $_POST['tax_on_credit_card_charges'];
		$bank_id = $_POST['bank_id'];
		$membership_details_arr  = json_encode($_POST['membership_details_arr']);

		$created_at = date('Y-m-d');
		$company_name = addslashes($company_name);
		
		$sq_credit = mysql_num_rows(mysql_query("SELECT `company_name` FROM `credit_card_company` WHERE company_name='$company_name'"));
		if($sq_credit > 0){
			echo "error--Credit card company name already exist!";
			exit;
		}

		$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from credit_card_company"));
		$entry_id = $sq_max['max'] + 1;

		$sq_transaction = mysql_query("INSERT INTO `credit_card_company`(`entry_id`, `company_name`, `charges_in`, `credit_card_charges`, `tax_charges_in`, `tax_on_credit_card_charges`,`bank_id`, `membership_details_arr`, `created_at`,`status`) VALUES ('$entry_id','$company_name','$charges_in','$credit_card_charges','$tax_charges_in','$tax_on_credit_card_charges','$bank_id','$membership_details_arr','$created_at','Active')");

		$sq_max = mysql_fetch_assoc(mysql_query("select max(ledger_id) as max from ledger_master"));
		$ledger_id = $sq_max['max'] + 1;
		$sq_ledger = mysql_query("insert into ledger_master (ledger_id, ledger_name, alias, group_sub_id, balance, dr_cr,customer_id,user_type,status) values ('$ledger_id', '$company_name', '', '20', '0','Dr','$entry_id','credit company','Active')");

		if(!$sq_transaction || !$sq_ledger){

			$GLOBALS['flag'] = false;
			echo "error--Credit card company not added!";
		}
		else{
			$GLOBALS['flag'] = true;
			echo "Credit card company successfully added!";
		}
	}

	public function update(){

		$entry_id = $_POST['entry_id'];
		$company_name = $_POST['company_name'];
		$charges_in = $_POST['charges_in'];
		$credit_card_charges = $_POST['credit_card_charges'];
		$tax_charges_in =$_POST['tax_charges_in'];
		$tax_on_credit_card_charges = $_POST['tax_on_credit_card_charges'];
		$bank_id = $_POST['bank_id'];
		$membership_details_arr  = json_encode($_POST['membership_details_arr']);
		$cstatus = $_POST['cstatus'];

		$company_name = addslashes($company_name);
		
		$sq_credit = mysql_num_rows(mysql_query("SELECT `company_name` FROM `credit_card_company` WHERE company_name='$company_name' and entry_id!='$entry_id'"));
		if($sq_credit > 0){
			echo "error--Credit card company name already exist!";
			exit;
		}

		$sq_transaction = mysql_query("update `credit_card_company` set `charges_in`='$charges_in', `credit_card_charges`='$credit_card_charges', `tax_charges_in`='$tax_charges_in',`tax_on_credit_card_charges`='$tax_on_credit_card_charges',`bank_id`='$bank_id', `membership_details_arr`='$membership_details_arr',status='$cstatus' where entry_id='$entry_id'");
		
		if(!$sq_transaction){
			$GLOBALS['flag'] = false;
			echo "error--Credit card company not updated!";
		}
		else{
			$GLOBALS['flag'] = true;
			echo "Credit card company successfully updated!";
		}
	}
}
?>