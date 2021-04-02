<?php 
class far_master{

public function far_master_save()
{
	$branch_admin_id = $_POST['branch_admin_id'];
	$asset_id = $_POST['asset_id'];
	$asset_ledger = $_POST['asset_ledger'];
	$purchase_date = $_POST['purchase_date'];
	$purchase_amount = $_POST['purchase_amount'];
	$depr_type = $_POST['depr_type'];
	$rate_of_depr = $_POST['rate_of_depr'];
	$depr_interval = $_POST['depr_interval'];
	$depr_till_date = $_POST['depr_till_date'];
	$carrying_amount = $_POST['carrying_amount'];
	$sold_amount = $_POST['sold_amount'];
	$profit_loss = $_POST['profit_loss'];
	$remark = $_POST['remark'];
	$evidence_url = $_POST['evidence_url'];
	$old_sold_amount = $_POST['old_sold_amount'];

	$purchase_date = get_date_db($purchase_date);
	$created_at = date('Y-m-d');
	begin_t();
	
		if($old_sold_amount == $sold_amount)
		{
			$sq_entry_c = mysql_num_rows(mysql_query("select * from fixed_asset_entries where asset_id = '$asset_id' and asset_ledger ='$asset_ledger' and depr_interval ='$depr_interval'"));

			if($sq_entry_c == '0'){

				//Entries table
				$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from fixed_asset_entries"));
				$id = $sq_max['max'] + 1;
				$sq_cash = mysql_query("insert into fixed_asset_entries (entry_id, asset_id, branch_admin_id, asset_ledger, purchase_date, purchase_amount, depr_type, rate_of_depr,depr_interval,depr_till_date,carrying_amount,sold_amount,profit_loss,remark,evidence_url,created_at) values ('$id','$asset_id','$branch_admin_id','$asset_ledger','$purchase_date','$purchase_amount','$depr_type','$rate_of_depr','$depr_interval','$depr_till_date','$carrying_amount','$sold_amount','$profit_loss','$remark','$evidence_url','$created_at')");

				if($sq_cash){
					commit_t();
					echo "Asset Added to register!";
					exit;
				}
				else{
					rollback_t();
					echo "error--Sorry, Asset Not Added to register!";
					exit;
				}
			}
			else{
					rollback_t();
					echo "error--Sorry, Asset already added to register!";
					exit;
			}
	}else{
		$sq_entry_c = mysql_num_rows(mysql_query("select * from fixed_asset_entries where asset_id = '$asset_id' and asset_ledger ='$asset_ledger' and depr_interval ='$depr_interval'"));

			if($sq_entry_c != '0'){
				$sq_update = mysql_query("update fixed_asset_entries set sold_amount ='$sold_amount' , profit_loss ='$profit_loss' where asset_id = '$asset_id' and asset_ledger ='$asset_ledger' and depr_interval ='$depr_interval'");
				if($sq_update){
					commit_t();
					echo "Asset Updated to register!";
					exit;
				}
			}
			else{
					rollback_t();
					echo "error--Sorry, Asset already added to register!";
					exit;
			}

	}

}

}
?>