<?php 
$flag = true;
class roe_master{

	public function roe_save(){
		$currency_name_arr = $_POST['currency_name_arr'];
		$currency_rate_arr = $_POST['currency_rate_arr'];

		begin_t();

		for($i=0; $i<sizeof($currency_rate_arr); $i++){
			$sq_count = mysql_num_rows(mysql_query("select entry_id from roe_master where currency_id='$currency_name_arr[$i]'"));
			if($sq_count>0){
				$GLOBALS['flag'] = false;
				$sq_cur = mysql_fetch_assoc(mysql_query("select currency_code from currency_name_master where id='$currency_name_arr[$i]'"));
				echo "error--ROE already exists for ".$sq_cur['currency_code'];
				exit;
			}
			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from roe_master"));
			$entry_id = $sq_max['max'] + 1;
			$sq_currency = mysql_query("insert into roe_master (entry_id,currency_id, currency_rate) values ('$entry_id','$currency_name_arr[$i]','$currency_rate_arr[$i]')");

			if(!$sq_currency){
				$GLOBALS['flag'] = false;
				echo "error--Some entries not saved";
				exit;
			}
		}

		if($GLOBALS['flag']){
			commit_t();
			echo "ROE has been successfully saved.";
			exit;
		}
		else{
			rollback_t();
			exit;
		}
	}

	public function roe_update(){

		$entry_id = $_POST['entry_id'];
		$currency_code = $_POST['currency_code'];
		$currency_rate = $_POST['currency_rate'];

		$sq_count = mysql_num_rows(mysql_query("select entry_id from roe_master where currency_id='$currency_code' and entry_id!='$entry_id'"));
		if($sq_count>0){
			$GLOBALS['flag'] = false;
			$sq_cur = mysql_fetch_assoc(mysql_query("select currency_code from currency_name_master where id='$currency_code'"));
			echo "error--ROE already exists for ".$sq_cur['currency_code'];
			exit;
		}

		$sq_currency = mysql_query("update roe_master set currency_id='$currency_code', currency_rate='$currency_rate' where entry_id='$entry_id'");
		if($sq_currency){
			echo "ROE has been successfully updated.";
			exit;
		}
		else{
			echo "error--ROE not updated";
			exit;
		}

	}
}
?>