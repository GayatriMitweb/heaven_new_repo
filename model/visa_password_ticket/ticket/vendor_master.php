<?php 
$flag = true;
class vendor_master{
public function vendor_save()
{
	$vendor_name = $_POST['vendor_name'];
	$mobile_no = $_POST['mobile_no'];
	$landline_no = $_POST['landline_no'];
	$contact_person_name = $_POST['contact_person_name'];
	$immergency_contact_no = $_POST['immergency_contact_no'];
	$country = $_POST['country'];
	$website = $_POST['website'];
	$email_id = $_POST['email_id'];
	$address = $_POST['address'];
	$opening_balance = $_POST['opening_balance'];
	$active_flag = $_POST['active_flag'];
	$bank_name = $_POST['bank_name'];
	$account_name = $_POST['account_name'];
	$account_no = $_POST['account_no'];
	$branch = $_POST['branch'];
	$ifsc_code = $_POST['ifsc_code'];
	$service_tax_no = $_POST['service_tax_no'];
	$state = $_POST['state'];
	$side = $_POST['side'];
	$supp_pan = $_POST['supp_pan'];
	$as_of_date = $_POST['as_of_date'];
	$as_of_date = get_date_db($as_of_date);

	$created_at = date('Y-m-d H:i:s');
	begin_t();
	global $encrypt_decrypt, $secret_key;
	$mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
	$email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);

	$vendor_count = mysql_num_rows(mysql_query("select vendor_name from ticket_vendor where vendor_name='$vendor_name'"));
	if($vendor_count>0){
		rollback_t();
		echo "error--Vendor already exists!";
		exit;
	}
	$sq_max = mysql_fetch_assoc(mysql_query("select max(vendor_id) as max from ticket_vendor"));
	$vendor_id = $sq_max['max'] + 1;
	$vendor_name = addslashes($vendor_name);
	$sq_vendor = mysql_query("insert into ticket_vendor (vendor_id, vendor_name, mobile_no, landline_no, contact_person_name, immergency_contact_no, email_id, address, country, website, opening_balance, bank_name,account_name, account_no, branch, ifsc_code, active_flag, created_at, service_tax_no, state_id, side,pan_no,as_of_date) values ('$vendor_id', '$vendor_name', '$mobile_no','$landline_no','$contact_person_name','$immergency_contact_no', '$email_id','$address','$country','$website','$opening_balance','$bank_name','$account_name' ,'$account_no','$branch','$ifsc_code', '$active_flag', '$created_at','$service_tax_no','$state','$side','$supp_pan','$as_of_date')");
	sundry_creditor_balance_update();
	
	if($sq_vendor){
		$vendor_login_master = new vendor_login_master;
	    $vendor_login_master->vendor_login_save($vendor_name, $mobile_no, 'Ticket Vendor', $vendor_id, $active_flag, $email_id,$opening_balance,$side,$as_of_date);
	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Flight Ticket has been successfully saved.";
	      exit;
	    }
	    else{
	      rollback_t();     
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "error--Sorry, Vendor not saved!";
		exit;
	}
}
public function vendor_update()
{
	$vendor_name = $_POST['vendor_name'];
	$mobile_no = $_POST['mobile_no'];
	$vendor_login_id = $_POST['vendor_login_id'];
	$landline_no = $_POST['landline_no'];
	$contact_person_name = $_POST['contact_person_name'];
	$immergency_contact_no = $_POST['immergency_contact_no'];
	$country = $_POST['country'];
	$website = $_POST['website'];
	$email_id = $_POST['email_id'];
	$address = $_POST['address'];
	$opening_balance = $_POST['opening_balance'];
	$active_flag = $_POST['active_flag'];
	$bank_name = $_POST['bank_name'];
	$account_name = $_POST['account_name'];
	$account_no = $_POST['account_no'];
	$branch = $_POST['branch'];
	$ifsc_code = $_POST['ifsc_code'];
	$service_tax_no = $_POST['service_tax_no1'];
	$vendor_id = $_POST['vendor_id'];
	$state = $_POST['state'];
	$side = $_POST['side'];
	$supp_pan = $_POST['supp_pan'];
	$as_of_date = $_POST['as_of_date'];
	$as_of_date = get_date_db($as_of_date);
	begin_t();
	global $encrypt_decrypt, $secret_key;
	$mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
	$email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
	$vendor_count = mysql_num_rows(mysql_query("select vendor_name from ticket_vendor where vendor_name='$vendor_name' and vendor_id!='$vendor_id'"));
	if($vendor_count>0){
		rollback_t();
		echo "error--Vendor already exists!";
		exit;
	}
	$vendor_name = addslashes($vendor_name);
	$sq_vendor = mysql_query("update ticket_vendor set vendor_name='$vendor_name',landline_no = '$landline_no', mobile_no='$mobile_no',contact_person_name = '$contact_person_name',immergency_contact_no = '$immergency_contact_no', country = '$country', website ='$website', email_id='$email_id', address='$address',account_name='$account_name', account_no= '$account_no',branch = '$branch',ifsc_code= '$ifsc_code', opening_balance='$opening_balance', active_flag='$active_flag', bank_name='$bank_name', service_tax_no='$service_tax_no', state_id='$state', side='$side',pan_no='$supp_pan',as_of_date='$as_of_date' where vendor_id='$vendor_id'");
	sundry_creditor_balance_update();
	
	if($sq_vendor){
		$vendor_login_master = new vendor_login_master;
	    $vendor_login_master->vendor_login_update($vendor_login_id, $vendor_name, $mobile_no, $vendor_id, $active_flag, $email_id,'Ticket Vendor',$opening_balance,$side,$as_of_date);
	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Flight Ticket has been successfully updated.";
	      exit;
	    }
	    else{
	      rollback_t();
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "error--Sorry, Vendor not updated!";
		exit;
	}

}

}

?>