<?php 

$flag = true;

class other_vendor_master{
public function save_vendor()
{
    $vendor_name = $_POST['vendor_name'];
    $profession = $_POST['profession'];
    $service_tax_no = $_POST['service_tax_no'];
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
    $city_id = $_POST['cmb_city_id'];
    $mobile_no = $_POST['mobile_no'];
    $email_id = $_POST['email_id'];
    $address = $_POST['address'];
    $opening_balance = $_POST['opening_balance'];
    $active_flag = $_POST['active_flag'];
    $state = $_POST['state'];
    $side = $_POST['side'];
    $supp_pan = $_POST['supp_pan'];
    $as_of_date = $_POST['as_of_date'];
    $as_of_date = get_date_db($as_of_date);

    global $encrypt_decrypt, $secret_key;
    $mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
    $email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
    $sq_vendor_count = mysql_num_rows(mysql_query("select * from other_vendors where vendor_name='$vendor_name'"));
    if($sq_vendor_count>0){
    	echo "error--Sorry, Vendor name already exists!";
    	exit;
    }

    $created_at = date('Y-m-d H:i:s');
    $sq_max = mysql_fetch_assoc(mysql_query("select max(vendor_id) as max from other_vendors"));
    $vendor_id = $sq_max['max'] + 1;

    $vendor_name  =addslashes($vendor_name);
    $sq_vendor = mysql_query("insert into other_vendors (vendor_id, vendor_name, city_id, profession, service_tax_no, mobile_no, landline_no, email_id, contact_person_name, immergency_contact_no, address, country, website, opening_balance, bank_name,account_name, account_no, branch, ifsc_code, active_flag, created_at, state_id, side,pan_no,as_of_date) values ('$vendor_id', '$vendor_name', '$city_id', '$profession', '$service_tax_no', '$mobile_no', '$landline_no','$email_id', '$contact_person_name','$immergency_contact_no' ,'$address', '$country','$website','$opening_balance', '$bank_name','$account_name','$account_no','$branch','$ifsc_code','$active_flag', '$created_at','$state','$side','$supp_pan','$as_of_date')");
    
    sundry_creditor_balance_update();
    if($sq_vendor){
    	$vendor_login_master = new vendor_login_master;
	    $vendor_login_master->vendor_login_save($vendor_name, $mobile_no, 'Other Vendor', $vendor_id, $active_flag, $email_id,$opening_balance,$side,$as_of_date);
	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Supplier has been successfully saved.";
	      exit;
	    }
	    else{
	      rollback_t();
	      echo "error--Error in login!";
	      exit;
	    }
    }
    else{
    	rollback_t();
    	echo "error--Sorry, Vendor not saved!";
    }
}
public function update_vendor()
{
    $vendor_id = $_POST['vendor_id'];
    $vendor_login_id = $_POST['vendor_login_id'];
    $vendor_name = $_POST['vendor_name'];
    $profession = $_POST['profession'];
    $service_tax_no = $_POST['service_tax_no'];
    $landline_no = $_POST['landline_no'];
    $email_id = $_POST['email_id'];
    $contact_person_name = $_POST['contact_person_name'];
    $immergency_contact_no =$_POST['immergency_contact_no'];
    $country = $_POST['country'];
    $website = $_POST['website'];
    $bank_name =$_POST['bank_name'];
    $account_name = $_POST['account_name'];
    $account_no = $_POST['account_no'];
    $branch = $_POST['branch'];
    $ifsc_code = $_POST['ifsc_code'];
    $cmb_city_id1 = $_POST['cmb_city_id1']; 
    $mobile_no = $_POST['mobile_no'];
    $address = $_POST['address'];
    $opening_balance = $_POST['opening_balance'];
    $active_flag = $_POST['active_flag'];
    $state_id = $_POST['state_id'];
    $side = $_POST['side'];
    $supp_pan = $_POST['supp_pan'];
    $as_of_date = $_POST['as_of_date'];
    $as_of_date = get_date_db($as_of_date);
    global $encrypt_decrypt, $secret_key;
    $mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
    $email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);

    $sq_vendor_count = mysql_num_rows(mysql_query("select * from other_vendors where vendor_name='$vendor_name' and vendor_id!='$vendor_id'"));
    if($sq_vendor_count>0){
        echo "error--Sorry, Supplier name already exists!";
        exit;
    }
    
    $vendor_name  =addslashes($vendor_name);
    $sq_vendor = mysql_query("update other_vendors set vendor_name='$vendor_name', profession='$profession', service_tax_no='$service_tax_no', mobile_no='$mobile_no', landline_no='$landline_no', email_id='$email_id', address='$address', contact_person_name='$contact_person_name', immergency_contact_no='$immergency_contact_no', city_id='$cmb_city_id1', country='$country', website='$website', opening_balance='$opening_balance',  bank_name='$bank_name', account_name='$account_name',account_no='$account_no', branch='$branch', ifsc_code='$ifsc_code', active_flag='$active_flag', state_id='$state_id', side='$side',pan_no='$supp_pan',as_of_date='$as_of_date' where vendor_id='$vendor_id'");
    
    if($sq_vendor){
        $vendor_login_master = new vendor_login_master;
        $vendor_login_master->vendor_login_update($vendor_login_id, $vendor_name, $mobile_no, $vendor_id, $active_flag, $email_id,'Other Vendor',$opening_balance,$side,$as_of_date);
        if($GLOBALS['flag']){
          commit_t();
          echo "Supplier has been successfully updated.";
          exit;
        }
        else{
          rollback_t();
          echo "error--Error in login details";
          exit;
        }
    }
    else{
        rollback_t();
        echo "error--Sorry, Supplier not updated!";
    }
}
}
?>