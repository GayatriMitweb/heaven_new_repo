<?php 

$flag = true;

class vendor_master{
public function vendor_save()
{
	$vendor_name = $_POST['vendor_name'];
	$mobile_no = $_POST['mobile_no'];
	$email_id = $_POST['email_id'];
	$address = $_POST['address'];
	$landline_no = $_POST['landline_no'];
	$contact_person_name = $_POST['contact_person_name'];
	$immergency_contact_no =$_POST['immergency_contact_no'];
	$country = $_POST['country'];
	$website = $_POST['website'];
	$bank_name =$_POST['bank_name'];
	$account_name = $_POST['account_name'];
	$account_no = $_POST['account_no'];
	$branch = $_POST['branch'];
	$ifsc_code = $_POST['ifsc_code'];
	$opening_balance = $_POST['opening_balance'];
	$active_flag = $_POST['active_flag'];
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
	$vendor_count = mysql_num_rows(mysql_query("select vendor_name from train_ticket_vendor where vendor_name='$vendor_name'"));
	if($vendor_count>0){
		rollback_t();
		echo "error--Supplier already exists!";
		exit;
	}
	$vendor_name = addslashes($vendor_name);
	$sq_max = mysql_fetch_assoc(mysql_query("select max(vendor_id) as max from train_ticket_vendor"));
	$vendor_id = $sq_max['max'] + 1;
	$sq_vendor = mysql_query("insert into train_ticket_vendor (vendor_id, vendor_name, mobile_no, landline_no, email_id, contact_person_name, immergency_contact_no, address,country, website, bank_name,account_name ,account_no, branch, ifsc_code, opening_balance, active_flag, created_at, service_tax_no, state_id, side,pan_no,as_of_date) values ('$vendor_id', '$vendor_name', '$mobile_no', '$landline_no','$email_id', '$contact_person_name','$immergency_contact_no', '$address', '$country','$website',  '$bank_name','$account_name','$account_no','$branch','$ifsc_code', '$opening_balance', '$active_flag', '$created_at', '$service_tax_no', '$state','$side','$supp_pan','$as_of_date')");

	if($sq_vendor){
		$vendor_login_master = new vendor_login_master;
	    $vendor_login_master->vendor_login_save($vendor_name, $mobile_no, 'Train Ticket Vendor', $vendor_id, $active_flag, $email_id,$opening_balance,$side,$as_of_date);
	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Train Ticket has been successfully saved.";
	      exit;
	    }
	    else{
	      rollback_t();     
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "error--Sorry, Supplier not saved!";
		exit;
	}
}
public function vendor_update()
{
	$vendor_id = $_POST['vendor_id'];
	$vendor_login_id = $_POST['vendor_login_id'];
	$vendor_name = $_POST['vendor_name'];
	$mobile_no = $_POST['mobile_no'];
	$landline_no = $_POST['landline_no'];
	$email_id = $_POST['email_id'];
	$address = $_POST['address'];
	$contact_person_name = $_POST['contact_person_name'];
	$immergency_contact_no =$_POST['immergency_contact_no'];
	$country = $_POST['country'];
	$website = $_POST['website'];
	$bank_name =$_POST['bank_name'];
	$account_name = $_POST['account_name'];
	$account_no = $_POST['account_no'];
	$branch = $_POST['branch'];
	$ifsc_code = $_POST['ifsc_code'];
	$opening_balance = $_POST['opening_balance'];
	$active_flag = $_POST['active_flag'];
	$service_tax_no1 = $_POST['service_tax_no1'];
	$state_id = $_POST['state_id'];
	$side = $_POST['side'];
	$supp_pan = $_POST['supp_pan'];
	$as_of_date = $_POST['as_of_date'];
	$as_of_date = get_date_db($as_of_date);

	begin_t();
	global $encrypt_decrypt, $secret_key;
	$mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
	$email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
	$vendor_count = mysql_num_rows(mysql_query("select vendor_name from train_ticket_vendor where vendor_name='$vendor_name' and vendor_id!='$vendor_id'"));
	if($vendor_count>0){
		rollback_t();
		echo "error--Supplier already exists!";
		exit;
	}
	$vendor_name = addslashes($vendor_name);
	$sq_vendor = mysql_query("update train_ticket_vendor set vendor_name='$vendor_name', mobile_no='$mobile_no', landline_no='$landline_no', email_id='$email_id', contact_person_name='$contact_person_name', immergency_contact_no='$immergency_contact_no', address='$address', country='$country', website='$website', bank_name='$bank_name',account_name='$account_name' ,account_no='$account_no', branch='$branch', ifsc_code='$ifsc_code', opening_balance='$opening_balance', active_flag='$active_flag', service_tax_no='$service_tax_no1', state_id='$state_id',side='$side',pan_no='$supp_pan',as_of_date='$as_of_date' where vendor_id='$vendor_id'");
	sundry_creditor_balance_update();
	
	if($sq_vendor){
		$vendor_login_master = new vendor_login_master;
	    $vendor_login_master->vendor_login_update($vendor_login_id, $vendor_name, $mobile_no, $vendor_id, $active_flag, $email_id,'Train Ticket Vendor',$opening_balance,$side,$as_of_date);
	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Train Ticket has been successfully updated.";
	      exit;
	    }
	    else{
	      rollback_t();
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "error--Sorry, Supplier not updated!";
		exit;
	}
}
}

?>