<?php 

$flag = true;

class vendor_master{
public function vendor_save()
{
	$vendor_name = $_POST['vendor_name'];
	$city_id = $_POST['city_id'];
	$mobile_no = $_POST['mobile_no'];
	$landline_no = $_POST['landline_no'];
	$email_id = $_POST['email_id'];
	$email_id_1 = $_POST["email_id_1"];
	$email_id_2 = $_POST["email_id_2"];
	$concern_person_name = $_POST['concern_person_name'];
	$opening_balance = $_POST['opening_balance'];
	$address = $_POST['address'];
	$immergency_contact_no =$_POST['immergency_contact_no'];
	$country = $_POST['country'];
	$website = $_POST['website'];
	$bank_name =$_POST['bank_name'];
	$account_name = $_POST['account_name'];
	$account_no = $_POST['account_no'];
	$branch = $_POST['branch'];
	$ifsc_code = $_POST['ifsc_code'];
	$active_flag = $_POST['active_flag'];
	$service_tax_no = $_POST['service_tax_no'];
	$state = $_POST['state'];
	$side = $_POST['side'];
	$supp_pan = $_POST['supp_pan'];
	$as_of_date = $_POST['as_of_date'];
	$as_of_date = get_date_db($as_of_date);
	$created_at = date('Y-m-d H:i:S');

	begin_t();
	global $encrypt_decrypt, $secret_key;
	$mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
	$email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
	$email_id_1 = $encrypt_decrypt->fnEncrypt($email_id_1, $secret_key);
    $email_id_2 = $encrypt_decrypt->fnEncrypt($email_id_2, $secret_key);
	$sq_count = mysql_num_rows(mysql_query("select * from site_seeing_vendor where vendor_name='$vendor_name'"));
	if($sq_count>0){
		rollback_t();
		echo "error--Vendor name already exists!";
		exit;
	}
	$sq_max = mysql_fetch_assoc(mysql_query("select max(vendor_id) as max from site_seeing_vendor"));
	$vendor_id = $sq_max['max'] + 1;
	$vendor_name = addslashes($vendor_name);
	$sq_vendor = mysql_query("insert into site_seeing_vendor (vendor_id, vendor_name, city_id, mobile_no, landline_no, email_id,alternative_email_1,alternative_email_2,concern_person_name, immergency_contact_no, opening_balance, address, country, website, active_flag, created_at,bank_name,account_name,account_no,branch,ifsc_code, service_tax_no,state_id,side,pan_no,as_of_date) values ('$vendor_id', '$vendor_name', '$city_id', '$mobile_no', '$landline_no', '$email_id','$email_id_1','$email_id_2', '$concern_person_name', '$immergency_contact_no','$opening_balance', '$address', '$country','$website', '$active_flag', '$created_at', '$bank_name','$account_name','$account_no','$branch','$ifsc_code', '$service_tax_no','$state','$side','$supp_pan','$as_of_date')");
	
	sundry_creditor_balance_update();

	if($sq_vendor){
		$vendor_login_master = new vendor_login_master;
	    $vendor_login_master->vendor_login_save($vendor_name, $mobile_no, 'Excursion Vendor', $vendor_id, $active_flag, $email_id,$opening_balance,$side,$as_of_date);
	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Excursion has been successfully saved.";
	      exit;
	    }
	    else{
	      rollback_t();     
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "Excursion vendor not saved!";
		exit;
	}
}
public function vendor_update()
{
	$vendor_id = $_POST['vendor_id'];
	$vendor_login_id = $_POST['vendor_login_id'];
	$vendor_name = $_POST['vendor_name'];
	$city_id = $_POST['city_id'];
	$mobile_no = $_POST['mobile_no'];
	$landline_no = $_POST['landline_no'];
	$email_id = $_POST['email_id'];
	$email_id_1 = $_POST["email_id_1"];
	$email_id_2 = $_POST["email_id_2"];
	$concern_person_name = $_POST['concern_person_name'];
	$opening_balance = $_POST['opening_balance'];
	$address = $_POST['address'];
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
	$created_at = date('Y-m-d H:i:S');
	$state_id = $_POST['state_id'];
	$side = $_POST['side'];
	$supp_pan = $_POST['supp_pan'];
	$as_of_date = $_POST['as_of_date'];
	$as_of_date = get_date_db($as_of_date);
	begin_t();
	global $encrypt_decrypt, $secret_key;
	$mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
	$email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
	$email_id_1 = $encrypt_decrypt->fnEncrypt($email_id_1, $secret_key);
    $email_id_2 = $encrypt_decrypt->fnEncrypt($email_id_2, $secret_key);
	$sq_count = mysql_num_rows(mysql_query("select * from site_seeing_vendor where vendor_name='$vendor_name' and vendor_id!='$vendor_id'"));
	if($sq_count>0){
		rollback_t();
		echo "error--Vendor name already exists!";
		exit;
	}

	$vendor_name = addslashes($vendor_name);
	$sq_vendor = mysql_query("update site_seeing_vendor set vendor_name='$vendor_name', city_id='$city_id', mobile_no='$mobile_no', landline_no='$landline_no', email_id='$email_id',alternative_email_1 = '$email_id_1',alternative_email_2='$email_id_2', concern_person_name='$concern_person_name',  immergency_contact_no='$immergency_contact_no', opening_balance='$opening_balance', address='$address', country='$country', website='$website', active_flag='$active_flag', bank_name='$bank_name',account_name='$account_name' ,account_no='$account_no', branch='$branch', ifsc_code='$ifsc_code', service_tax_no='$service_tax_no1', state_id='$state_id',side='$side',pan_no='$supp_pan',as_of_date ='$as_of_date' where vendor_id='$vendor_id'");
	
	sundry_creditor_balance_update();

	if($sq_vendor){
		$vendor_login_master = new vendor_login_master;
	    $vendor_login_master->vendor_login_update($vendor_login_id, $vendor_name, $mobile_no, $vendor_id, $active_flag, $email_id,'Excursion Vendor',$opening_balance,$side,$as_of_date);
	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Excursion has been successfully updated.";
	      exit;
	    }
	    else{
	      rollback_t();
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "Excursion vendor not updated!";
		exit;
	}

}
}
?>