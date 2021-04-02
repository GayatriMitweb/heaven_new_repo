<?php 
class ledger_master{

public function ledger_master_save()
{
	$ledger_name = $_POST['ledger_name'];
	$alias_name = $_POST['alias_name'];
	$group_id = $_POST['group_id'];
	$ledger_balance = $_POST['ledger_balance'];
	$side = $_POST['side'];

	$sq_count = mysql_num_rows(mysql_query("select ledger_name from ledger_master where ledger_name='$ledger_name'"));
	if($sq_count>0){
		echo "error--Ledger name already exists!";
		exit;
	}

	$sq_max = mysql_fetch_assoc(mysql_query("select max(ledger_id) as max from ledger_master"));
	$ledger_id = $sq_max['max'] + 1;

	begin_t();

	$sq_bank = mysql_query("insert into ledger_master (ledger_id, ledger_name, alias, group_sub_id, balance, dr_cr,status) values ('$ledger_id', '$ledger_name', '$alias_name', '$group_id', '$ledger_balance','$side','Active')");
	if($sq_bank){
		commit_t();
		echo "Ledger has been successfully saved.";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Ledger not saved!";
		exit;
	}

}

public function ledger_master_update()
{
	$ledger_id = $_POST['ledger_id'];
	$ledger_name = $_POST['ledger_name'];
	$alias_name = $_POST['alias_name'];
	$group_id = $_POST['group_id'];
	$ledger_balance = $_POST['ledger_balance'];
	$side = $_POST['side'];
	$status = $_POST['status'];

	$sq_count = mysql_num_rows(mysql_query("select ledger_name from ledger_master where ledger_name='$ledger_name' and ledger_id!='$ledger_id'"));
	if($sq_count>0){
		echo "error--Ledger name already exists!";
		exit;
	}

	begin_t();

	$sq_bank = mysql_query("update ledger_master set ledger_name='$ledger_name', alias='$alias_name', group_sub_id='$group_id',balance='$ledger_balance',dr_cr='$side',status='$status' where ledger_id='$ledger_id'");
	
	$sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$ledger_id'"));
	//bank update 
	if($sq_ledger['user_type']=='bank'){
		$sq_bank = mysql_query("update bank_master set opening_balance='$ledger_balance' where bank_id='$sq_ledger[customer_id]'");
	}

	//supplier update
	if($sq_ledger['user_type']=='DMC Vendor'){
		$sq_bank = mysql_query("update dmc_master set opening_balance='$ledger_balance' where dmc_id='$sq_ledger[customer_id]'");
	}
	else if($sq_ledger['user_type']=='Hotel Vendor'){
		$sq_bank = mysql_query("update hotel_master set opening_balance='$ledger_balance' where hotel_id='$sq_ledger[customer_id]'");
	}
	else if($sq_ledger['user_type']=='Transport Vendor'){
		$sq_bank = mysql_query("update transport_agency_master set opening_balance='$ledger_balance' where transport_agency_id='$sq_ledger[customer_id]'");
	}
	else if($sq_ledger['user_type']=='Visa Vendor'){
		$sq_bank = mysql_query("update visa_vendor set opening_balance='$ledger_balance' where vendor_id='$sq_ledger[customer_id]'");
	}
	else if($sq_ledger['user_type']=='Passport Vendor'){
		$sq_bank = mysql_query("update passport_vendor set opening_balance='$ledger_balance' where vendor_id='$sq_ledger[customer_id]'");
	}
	else if($sq_ledger['user_type']=='Train Ticket Vendor'){
		$sq_bank = mysql_query("update train_ticket_vendor set opening_balance='$ledger_balance' where vendor_id='$sq_ledger[customer_id]'");
	}
	else if($sq_ledger['user_type']=='Car Rental Vendor'){
		$sq_bank = mysql_query("update car_rental_vendor set opening_balance='$ledger_balance' where vendor_id='$sq_ledger[customer_id]'");
	}
	else if($sq_ledger['user_type']=='Ticket Vendor'){
		$sq_bank = mysql_query("update ticket_vendor set opening_balance='$ledger_balance' where vendor_id='$sq_ledger[customer_id]'");
	}
	else if($sq_ledger['user_type']=='Excursion Vendor'){
		$sq_bank = mysql_query("update site_seeing_vendor set opening_balance='$ledger_balance' where vendor_id='$sq_ledger[customer_id]'");
	}
	else if($sq_ledger['user_type']=='Insuarance Vendor'){
		$sq_bank = mysql_query("update insuarance_vendor set opening_balance='$ledger_balance' where vendor_id='$sq_ledger[customer_id]'");
	}
	else if($sq_ledger['user_type']=='Cruise Vendor'){
		$sq_bank = mysql_query("update cruise_master set opening_balance='$ledger_balance' where cruise_id='$sq_ledger[customer_id]'");
	}
	else if($sq_ledger['user_type']=='Other Vendor'){
		$sq_bank = mysql_query("update other_vendors set opening_balance='$ledger_balance' where vendor_id='$sq_ledger[customer_id]'");
	}
	else{

	}
	if($sq_bank){
		commit_t();
		echo "Ledger has been successfully updated.";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Ledger not updated!";
		exit;
	}

}
function opening_balances_save(){
	$csv_upload_dir = $_POST['csv_upload_dir'];
    $created_at = date('Y-m-d');
    $flag = true;
    $checkFlag = true;

    $csv_upload_dir = explode('uploads', $csv_upload_dir);
    $csv_upload_dir = BASE_URL.'uploads'.$csv_upload_dir[1];
    $timestamp = date('U');
    
    begin_t();
    $validCount=0;
	$invalidCount=0;
    $unprocessedArray=array();
	
	$count = 1;
	$debit = 0;
	$credit = 0;
	$handle = fopen($csv_upload_dir, "r");
	if(empty($handle) === false){
		while(($data = fgetcsv($handle, ",")) !== FALSE){
			if($count == 1){ $count++; continue; }
			if($count>0)
			$debit = $debit + $data[3];
			$credit = $credit + $data[4];
		}
	}
	fclose($handle);
	if($debit != $credit){
		$checkFlag = false;
		$flag = false;
	}
	else{
		$count = 1;
		$handle = fopen($csv_upload_dir, "r");
		if(empty($handle) === false){

			while(($data = fgetcsv($handle, ",")) !== FALSE){

				if($count == 1){ $count++; continue; }
				if($count>0){

					$ledger_id = $data[0];
					$debit = $data[3];
					$credit = $data[4];
					
					if($debit != '' && $credit != ''){

						$invalidCount++;
						$flag = false;
						$checkFlag = false;
						break;
					}
					else{
						
						if($debit != ''){
							$balance = $debit;
							$balance_side = 'Debit';
						}
						else if($credit != ''){
							$balance = $credit;
							$balance_side = 'Credit';
						}
						else{
							$balance = '';
							$balance_side = '';
						}
						$sq = mysql_query("update ledger_master set balance='$balance',balance_side='$balance_side' where ledger_id='$ledger_id'");
						$validCount++;
						if(!$sq){
							$flag = false;
							echo "error--Information Not Saved.";
							exit;
						} 
					}
				}
				$count++;
			}
		}
		fclose($handle);
	}
	if($checkFlag == false){
		$count = 1;
		$handle = fopen($csv_upload_dir, "r");
		if(empty($handle) === false){
			while(($data = fgetcsv($handle, ",")) !== FALSE){
				if($count == 1){ $count++; continue; }
            	if($count>0)
					array_push($unprocessedArray, $data);
			}
		}
		fclose($handle);
	}
	if(isset($unprocessedArray) && !empty($unprocessedArray)){

		$filePath='../../../download/unprocessed_ledger_records'.$created_at.''.$timestamp.'.csv';
		$save = preg_replace('/(\/+)/','/',$filePath);
		$downloadurl='../../../../download/unprocessed_ledger_records'.$created_at.''.$timestamp.'.csv';
		header("Content-type: text/csv ; charset:utf-8");
		header("Content-Disposition: attachment; filename=file.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		$output = fopen($save, "w");  
		fputcsv($output, array('Ledger Id' , 'Ledger Name', 'Group Name', 'Debit' , 'Credit'));   
		
		foreach($unprocessedArray as $row){
		fputcsv($output, $row);
		}
		
		fclose($output); 
		echo "unprocess--".$downloadurl;  
	}

    if($flag){
      commit_t();
      if($validCount>0){
        echo  $validCount." Records successfully imported<br>
        ".$invalidCount." Records failed.";
      }
      else{
        echo "error--No information imported";
      }
      exit;
    }
    else{
      rollback_t();
      exit;
    }
}
}
?>