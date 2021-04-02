<?php 

$flag = true;

class cruise_master{
public function cruise_save()
{
	$company_name = $_POST['company_name'];
	$mobile_no = $_POST['mobile_no'];
	$landline_no = $_POST['landline_no'];
	$email_id = $_POST['email_id'];
	$contact_person_name = $_POST['contact_person_name'];
	$cmb_city_id = $_POST['cmb_city_id'];
	$cruise_address = $_POST['cruise_address'];
	$opening_balance = $_POST['opening_balance'];
	$active_flag = $_POST['active_flag'];
	$service_tax_no = $_POST['service_tax_no'];
	$state = $_POST['state'];
	$immergency_contact_no =$_POST['immergency_contact_no'];
	$country = $_POST['country'];
	$website = $_POST['website'];
	$bank_name =$_POST['bank_name'];
	$account_name = $_POST['account_name'];
	$account_no = $_POST['account_no'];
	$branch = $_POST['branch'];
	$ifsc_code = $_POST['ifsc_code'];
	$side = $_POST['side'];
	$supp_pan = $_POST['supp_pan'];
	$as_of_date = $_POST['as_of_date'];
	$as_of_date = get_date_db($as_of_date);
	$created_at = date('Y-m-d H:i:s');

	begin_t();
	global $encrypt_decrypt, $secret_key;
	$mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
	$email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);

	$sq_cruise_count = mysql_num_rows(mysql_query("select * from cruise_master where company_name='$company_name'"));
	if($sq_cruise_count>0){
		rollback_t();
		echo "error--cruise company name already exists!";
		exit;
	}

	$company_name = addslashes($company_name);
	$sq_max = mysql_fetch_assoc(mysql_query("select max(cruise_id) as max from cruise_master"));
	$cruise_id = $sq_max['max'] + 1;
	$sq_cruise = mysql_query("insert into cruise_master (cruise_id, city_id, company_name, mobile_no, landline_no, email_id, contact_person_name,immergency_contact_no, cruise_address,state, country, website, opening_balance, bank_name,account_name,account_no,branch,ifsc_code, service_tax_no, active_flag, created_at,side,pan_no,as_of_date) values ('$cruise_id', '$cmb_city_id', '$company_name', '$mobile_no', '$landline_no', '$email_id', '$contact_person_name','$immergency_contact_no' ,'$cruise_address','$state','$country','$website', '$opening_balance','$bank_name','$account_name','$account_no','$branch','$ifsc_code','$service_tax_no', '$active_flag', '$created_at','$side','$supp_pan','$as_of_date' ) ");
	sundry_creditor_balance_update();

	if($sq_cruise){
		$vendor_login_master = new vendor_login_master;
	    $vendor_login_master->vendor_login_save($company_name, $mobile_no, 'Cruise Vendor', $cruise_id, $active_flag, $email_id,$opening_balance,$side,$as_of_date);
	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Cruise has been successfully saved.";
	      exit;
	    }
	    else{
	      rollback_t();
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "error--Cruise not saved!";
		exit;
	}
}

public function cruise_update()
{
	$cruise_id = $_POST['cruise_id'];
	$vendor_login_id = $_POST['vendor_login_id'];
	$company_name = $_POST['company_name'];
	$mobile_no = $_POST['mobile_no'];
	$landline_no = $_POST['landline_no'];
	$email_id = $_POST['email_id'];
	$contact_person_name = $_POST['contact_person_name'];
	$cmb_city_id1 = $_POST['cmb_city_id1'];	
	$cruise_address = $_POST['cruise_address'];
	$opening_balance = $_POST['opening_balance'];
	$active_flag = $_POST['active_flag'];
	$service_tax_no1 = $_POST['service_tax_no1'];
	$immergency_contact_no =$_POST['immergency_contact_no'];
	$country = $_POST['country'];
	$website = $_POST['website'];
	$bank_name =$_POST['bank_name'];
	$account_name = $_POST['account_name'];
	$account_no = $_POST['account_no'];
	$branch = $_POST['branch'];
	$ifsc_code = $_POST['ifsc_code'];
	$side = $_POST['side'];
	$state = $_POST['state'];
	$supp_pan = $_POST['supp_pan'];
	$as_of_date = $_POST['as_of_date'];
	$as_of_date = get_date_db($as_of_date);
	$created_at = date('Y-m-d H:i:s');
	begin_t();
	global $encrypt_decrypt, $secret_key;
	$mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
	$email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
	$sq_cruise_count = mysql_num_rows(mysql_query("select * from cruise_master where company_name='$company_name' and cruise_id!='$cruise_id'"));
	if($sq_cruise_count>0){
		rollback_t();
		echo "error--Cruise company name laready exists!";
		exit;
	}

	$company_name = addslashes($company_name);
	$sq_cruise = mysql_query("update cruise_master set company_name='$company_name', mobile_no='$mobile_no', landline_no='$landline_no', email_id='$email_id', contact_person_name='$contact_person_name', immergency_contact_no='$immergency_contact_no', city_id='$cmb_city_id1', cruise_address='$cruise_address', country='$country', website='$website', service_tax_no='$service_tax_no1', opening_balance='$opening_balance', bank_name='$bank_name',account_name='$account_name' ,account_no='$account_no', branch='$branch', ifsc_code='$ifsc_code', active_flag='$active_flag', side='$side', state='$state',pan_no='$supp_pan',as_of_date='$as_of_date' where cruise_id='$cruise_id' ");

	if($sq_cruise){
		$vendor_login_master = new vendor_login_master;
	    $vendor_login_master->vendor_login_update($vendor_login_id, $company_name, $mobile_no, $cruise_id, $active_flag, $email_id,'Cruise Vendor',$opening_balance,$side,$as_of_date);
	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Cruise has been successfully updated.";
	      exit;
	    }
	    else{
	      rollback_t();
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "error--Cruise not update!";
		exit;
	}
}


}

?>