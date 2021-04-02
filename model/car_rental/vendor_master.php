<?php 

$flag = true;
class vendor_master{
public function vendor_save()
{
	$vendor_name = $_POST['vendor_name']; 
	$mobile_no = $_POST['mobile_no']; 
	$address = $_POST['address'] ; 	
	$opening_balance = $_POST['opening_balance'];
	$active_flag = $_POST['active_flag'];
	$service_tax_no = $_POST['service_tax_no'];
	$email_id = $_POST['email_id'];
	$immergency_contact_no =$_POST['immergency_contact_no'];
	$contact_person_name =$_POST['contact_person_name'];
	$landline_no = $_POST['landline_no'];
	$country =$_POST['country'];
	$website = $_POST['website'];
	$bank_name =$_POST['bank_name'];
	$account_name = $_POST['account_name'];
	$account_no = $_POST['account_no'];
	$branch = $_POST['branch'];
	$ifsc_code = $_POST['ifsc_code'];
	$city_id = $_POST['city_id'];
	$state = $_POST['state'];
	$side = $_POST['side'];
	$supp_pan = $_POST['supp_pan'];
	$as_of_date = $_POST['as_of_date'];
	$as_of_date = get_date_db($as_of_date);


	$vehicle_name_arr = $_POST['vehicle_name_arr'];
	$vehicle_no_arr = $_POST['vehicle_no_arr']; 
	$vehicle_driver_name_arr = $_POST['vehicle_driver_name_arr']; 
	$vehicle_mobile_no_arr = $_POST['vehicle_mobile_no_arr']; 
	$vehicle_year_of_purchase_arr = $_POST['vehicle_year_of_purchase_arr']; 
	$vehicle_rate_arr = $_POST['vehicle_rate_arr']; 
	$vehicle_type_arr = $_POST['vehicle_type_arr'];

	$created_at = date('Y-m-d H:i:s');

	begin_t();
	global $encrypt_decrypt, $secret_key;
	$mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
	$email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);

	$sq_vendor_count = mysql_num_rows(mysql_query("select * from car_rental_vendor where vendor_name='$vendor_name'"));
	if($sq_vendor_count>0){
		rollback_t();
		echo "error--Company name already exists!";
		exit;
	}
	
	$vendor_name = addslashes($vendor_name);
	
	
	$sq_max = mysql_fetch_assoc(mysql_query("select max(vendor_id) as max from car_rental_vendor"));
	$vendor_id = $sq_max['max'] + 1;
	$sq_vendor = mysql_query("insert into car_rental_vendor (vendor_id, vendor_name, city_id, mobile_no, landline_no, contact_person_name,immergency_contact_no, address,country,website, opening_balance, active_flag, created_at,service_tax_no, email,bank_name,account_name,account_no,branch,ifsc_code,state_id,side,pan_no,as_of_date) values ('$vendor_id', '$vendor_name', '$city_id', '$mobile_no','$landline_no','$contact_person_name','$immergency_contact_no', '$address','$country','$website', '$opening_balance', '$active_flag', '$created_at','$service_tax_no','$email_id','$bank_name','$account_name','$account_no','$branch','$ifsc_code','$state','$side','$supp_pan','$as_of_date')");
	sundry_creditor_balance_update();

	if($sq_vendor)
	{
		$vendor_login_master = new vendor_login_master;
		$vendor_login_master->vendor_login_save($vendor_name, 	$mobile_no, 'Car Rental Vendor', $vendor_id, $active_flag, 	$email_id,$opening_balance,$side,$as_of_date);
		for($i=0; $i<sizeof($vehicle_no_arr); $i++){

			$sq_max = mysql_fetch_assoc(mysql_query("select max(vehicle_id) as max from car_rental_vendor_vehicle_entries"));
			$vehicle_id = $sq_max['max'] + 1;
			$query = "insert into car_rental_vendor_vehicle_entries(vehicle_id, vendor_id, vehicle_name, vehicle_no,  vehicle_type, vehicle_driver_name, vehicle_mobile_no, vehicle_year_of_purchase, vehicle_rate) values ('$vehicle_id', '$vendor_id', '$vehicle_name_arr[$i]', '$vehicle_no_arr[$i]', '$vehicle_type_arr[$i]', '$vehicle_driver_name_arr[$i]','$vehicle_mobile_no_arr[$i]','$vehicle_year_of_purchase_arr[$i]','$vehicle_rate_arr[$i]')";
			$sq_vendor = mysql_query($query);
			if(!$sq_vendor){

				$GLOBALS['flag'] = false;

				echo "error--Some vehicles not added!";

				//exit;

			}
		}

	    if($GLOBALS['flag']){

	      commit_t();

	      echo "Car Rental has been successfully saved.";

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
	$pan_card_no = $_POST['pan_card_no']; 
	$address = $_POST['address'];

	$vehicle_name_arr = $_POST['vehicle_name_arr'];
	$vehicle_no_arr = $_POST['vehicle_no_arr']; 
	$vehicle_driver_name_arr = $_POST['vehicle_driver_name_arr']; 
	$vehicle_mobile_no_arr = $_POST['vehicle_mobile_no_arr']; 
	$vehicle_year_of_purchase_arr = $_POST['vehicle_year_of_purchase_arr']; 
	$vehicle_rate_arr = $_POST['vehicle_rate_arr']; 
	$vehicle_type_arr = $_POST['vehicle_type_arr'];
	$vehicle_id_arr = $_POST['vehicle_id_arr'];
	$opening_balance = $_POST['opening_balance'];
	$active_flag = $_POST['active_flag'];
	$service_tax_no1 = $_POST['service_tax_no1'];
	$email_id1 = $_POST['email_id1'];
	$created_at = date('Y-m-d H:i:s');
	$immergency_contact_no =$_POST['immergency_contact_no'];
	$contact_person_name =$_POST['contact_person_name'];
	$landline_no = $_POST['landline_no'];
	$country =$_POST['country'];
	$website = $_POST['website'];
	$bank_name =$_POST['bank_name'];
	$account_name = $_POST['account_name'];
	$account_no = $_POST['account_no'];
	$branch = $_POST['branch'];
	$ifsc_code = $_POST['ifsc_code'];
	$city_id = $_POST['city_id'];
	$state = $_POST['state'];
	$side = $_POST['side'];
	$supp_pan = $_POST['supp_pan'];
	$as_of_date = $_POST['as_of_date'];
	$as_of_date = get_date_db($as_of_date);

	begin_t();
	global $encrypt_decrypt, $secret_key;
	$mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
	$email_id1 = $encrypt_decrypt->fnEncrypt($email_id1, $secret_key);
	$sq_vendor_count = mysql_num_rows(mysql_query("select * from car_rental_vendor where vendor_name='$vendor_name' and vendor_id!='$vendor_id'"));

	if($sq_vendor_count>0){
		rollback_t();
		echo "error--Supplier name already exists!";
		exit;
	}

	$vendor_name = addslashes($vendor_name);
	$sq_vendor = mysql_query("update car_rental_vendor set city_id='$city_id', vendor_name='$vendor_name', mobile_no='$mobile_no', landline_no='$landline_no', contact_person_name='$contact_person_name', immergency_contact_no='$immergency_contact_no', address='$address', country='$country', website='$website', opening_balance='$opening_balance', service_tax_no='$service_tax_no1', email='$email_id1', active_flag='$active_flag', bank_name='$bank_name',account_name='$account_name' ,account_no='$account_no', branch='$branch', ifsc_code='$ifsc_code', state_id='$state',side='$side',pan_no='$supp_pan',as_of_date='$as_of_date' where vendor_id='$vendor_id'");
	sundry_creditor_balance_update();
	
	if($sq_vendor)
	{
		for($i=0; $i<sizeof($vehicle_no_arr); $i++){
			if($vehicle_id_arr[$i]==""){
				$sq_max = mysql_fetch_assoc(mysql_query("select max(vehicle_id) as max from car_rental_vendor_vehicle_entries"));
				$vehicle_id = $sq_max['max'] + 1;
				$query = "insert into car_rental_vendor_vehicle_entries (vehicle_id, vendor_id, vehicle_name, vehicle_no,  vehicle_driver_name, vehicle_mobile_no, vehicle_year_of_purchase, vehicle_rate, vehicle_type) values ('$vehicle_id', '$vendor_id', '$vehicle_name_arr[$i]', '$vehicle_no_arr[$i]', '$vehicle_driver_name_arr[$i]', '$vehicle_mobile_no_arr[$i]', '$vehicle_year_of_purchase_arr[$i]','$vehicle_rate_arr[$i]', '$vehicle_type_arr[$i]')";
				$sq_vendor1 = mysql_query($query);
				if(!$sq_vendor1){

					$GLOBALS['flag'] = false;

					echo "error--Some vehicles not added!";

					//exit;

				}
			}

			else{
				$query = "update car_rental_vendor_vehicle_entries set vehicle_name='$vehicle_name_arr[$i]', vehicle_no='$vehicle_no_arr[$i]',  vehicle_driver_name='$vehicle_driver_name_arr[$i]', vehicle_mobile_no='$vehicle_mobile_no_arr[$i]', vehicle_year_of_purchase='$vehicle_year_of_purchase_arr[$i]', vehicle_rate='$vehicle_rate_arr[$i]', vehicle_type='$vehicle_type_arr[$i]' where vehicle_id='$vehicle_id_arr[$i]'"; 	
				$sq_vendor = mysql_query($query);
				if(!$sq_vendor){

					$GLOBALS['flag'] = false;

					echo "error--Some vehicles not updated!";

					//exit;

				}

			}
		}

		$vendor_login_master = new vendor_login_master;

	    $vendor_login_master->vendor_login_update($vendor_login_id, $vendor_name, $mobile_no, $vendor_id, $active_flag, $email_id1,'Car Rental Vendor',$opening_balance,$side,$as_of_date);

	    if($GLOBALS['flag']){

	      commit_t();

	      echo "Car Rental has been successfully updated.";

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