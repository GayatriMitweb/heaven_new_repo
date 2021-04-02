<?php 

$flag = true;

class dmc_master{
public function dmc_save()
{
	$company_name = $_POST['company_name'];
	$mobile_no = $_POST['mobile_no'];
	$landline_no = $_POST['landline_no'];
	$email_id = $_POST['email_id'];
	$contact_person_name = $_POST['contact_person_name'];
	$cmb_city_id = $_POST['cmb_city_id'];
	$dmc_address = $_POST['dmc_address'];
	$opening_balance = $_POST['opening_balance'];
	$active_flag = $_POST['active_flag'];
	$service_tax_no = $_POST['service_tax_no'];
	$immergency_contact_no =$_POST['immergency_contact_no'];
	$country = $_POST['country'];
	$website = $_POST['website'];
	$bank_name =$_POST['bank_name'];
	$account_name = $_POST['account_name'];
	$account_no = $_POST['account_no'];
	$branch = $_POST['branch'];
	$ifsc_code = $_POST['ifsc_code'];
	$state = $_POST['state'];
	$side = $_POST['side'];
	$supp_pan = $_POST['supp_pan'];
	$as_of_date = $_POST['as_of_date'];
  $as_of_date = get_date_db($as_of_date);
	$created_at = date('Y-m-d H:i:s');
  global $encrypt_decrypt, $secret_key;
  $mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
  $email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);

	begin_t();

	$sq_dmc_count = mysql_num_rows(mysql_query("select * from dmc_master where company_name='$company_name'"));
	if($sq_dmc_count>0){
		rollback_t();
		echo "error--DMC company name already exists!";
		exit;
	}

	$sq_max = mysql_fetch_assoc(mysql_query("select max(dmc_id) as max from dmc_master"));
	$dmc_id = $sq_max['max'] + 1;
	$company_name = addslashes($company_name);
	$sq_dmc = mysql_query("insert into dmc_master (dmc_id, company_name, mobile_no, landline_no, email_id, contact_person_name,immergency_contact_no, dmc_address, country, website, opening_balance, service_tax_no, bank_name,account_name,account_no,branch,ifsc_code, active_flag, created_at, city_id,state_id,side,pan_no,as_of_date) values ('$dmc_id', '$company_name', '$mobile_no', '$landline_no', '$email_id', '$contact_person_name','$immergency_contact_no' ,'$dmc_address','$country','$website', '$opening_balance','$service_tax_no','$bank_name','$account_name','$account_no','$branch','$ifsc_code', '$active_flag', '$created_at', '$cmb_city_id', '$state','$side','$supp_pan','$as_of_date') ");
	sundry_creditor_balance_update();

	if($sq_dmc){
		  $vendor_login_master = new vendor_login_master;
	    $vendor_login_master->vendor_login_save($company_name, $mobile_no, 'DMC Vendor', $dmc_id, $active_flag, $email_id,$opening_balance,$side,$as_of_date);
	    if($GLOBALS['flag']){
	      commit_t();
	      echo "DMC has been successfully saved.";
	      exit;
	    }
	    else{
	      rollback_t();
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "error--DMC not saved!";
		exit;
	}
}

public function dmc_update()
{
	$dmc_id = $_POST['dmc_id'];
	$vendor_login_id = $_POST['vendor_login_id'];
	$company_name = $_POST['company_name'];
	$mobile_no = $_POST['mobile_no'];
	$landline_no = $_POST['landline_no'];
	$email_id = $_POST['email_id'];
	$contact_person_name = $_POST['contact_person_name'];
	$cmb_city_id1 = $_POST['cmb_city_id1'];	
	$dmc_address = $_POST['dmc_address'];
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
	$state = $_POST['state'];
	$side = $_POST['side'];
	$supp_pan = $_POST['supp_pan'];
	$as_of_date = $_POST['as_of_date'];
  $as_of_date = get_date_db($as_of_date);
	$created_at = date('Y-m-d H:i:s');
  global $encrypt_decrypt, $secret_key;
  $mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
  $email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
	begin_t();
	$sq_dmc_count = mysql_num_rows(mysql_query("select * from dmc_master where company_name='$company_name' and dmc_id!='$dmc_id'"));
	if($sq_dmc_count>0){
		rollback_t();
		echo "error--DMC company name laready exists!";
		exit;
	}
  
  $company_name = addslashes($company_name);
	$sq_dmc = mysql_query("update dmc_master set company_name='$company_name', mobile_no='$mobile_no', landline_no='$landline_no', email_id='$email_id', contact_person_name='$contact_person_name', immergency_contact_no='$immergency_contact_no', city_id='$cmb_city_id1', dmc_address='$dmc_address', country='$country', website='$website', service_tax_no='$service_tax_no1', opening_balance='$opening_balance', bank_name='$bank_name',account_name='$account_name' ,account_no='$account_no', branch='$branch', ifsc_code='$ifsc_code', active_flag='$active_flag', state_id='$state', side='$side',pan_no='$supp_pan',as_of_date='$as_of_date' where dmc_id='$dmc_id' ");
	sundry_creditor_balance_update();
	if($sq_dmc){
		$vendor_login_master = new vendor_login_master;
	    $vendor_login_master->vendor_login_update($vendor_login_id, $company_name, $mobile_no, $dmc_id, $active_flag, $email_id,'DMC Vendor',$opening_balance,$side,$as_of_date);
	    if($GLOBALS['flag']){
	      commit_t();
	      echo "DMC has been successfully updated.";
	      exit;
	    }
	    else{
	      rollback_t();
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "error--DMC not update!";
		exit;
	}
}


public function vendor_csv_save()
{
    $vendor_csv_dir = $_POST['vendor_csv_dir'];
    $base_url=$_POST['base_url'];
    $flag = true;

    $vendor_csv_dir = explode('uploads', $vendor_csv_dir);
    $vendor_csv_dir = BASE_URL.'uploads'.$vendor_csv_dir[1];

    begin_t();
    $count = 1;
    $validCount=0;
    $invalidCount=0;
    $unprocessedArray=array();
    $arrResult  = array();
    $handle = fopen($vendor_csv_dir, "r");
    if(empty($handle) === false) {

        while(($data = fgetcsv($handle, ",")) !== FALSE){
            if($count == 1) { $count++; continue; }

            if($count>0){
                
                $sq_max_id = mysql_fetch_assoc(mysql_query("select max(dmc_id) as max from dmc_master"));

                $dmc_id = $sq_max_id['max']+1;

                $city_id = $data[0];
                $dmc_name = $data[1];
                $mobile = $data[2];
                $landline = $data[3];
                $email = $data[4];
                $contact_person = $data[5];
                $emergency_contact = $data[6];
                $address = $data[7];
                $state_id = $data[8];
                $country = $data[9];
                $website = $data[10];
                $bank_name = $data[11];
                $account_name = $data[12];
                $account_no = $data[13];
                $branch = $data[14];
                $ifsc_code = $data[15];
                $supp_pan = $data[16];
                $gst_no = $data[17];
                $opening_balance = '';
                $as_of_date = '';
                $side = '';
                $as_of_date = get_date_db($as_of_date);

                $created_at = date('Y-m-d H:i:s');
                $downloaded_at = date('Y-m-d');
                if(preg_match('/^[0-9]*$/', $city_id) && preg_match('/^[a-zA-Z \s]*$/', $dmc_name) && preg_match('/^[0-9]*$/', $state_id) && preg_match('/^[0-9]*$/', $opening_balance) && !empty($side) && !empty($as_of_date) && ($as_of_date!='1970-01-01') && (strlen($mobile)<=20)){

                      $sq_dmc_count = mysql_num_rows(mysql_query("select * from dmc_master where company_name='$dmc_name'"));
                      if($sq_dmc_count==0)
                      {
                          $validCount++;
                          global $encrypt_decrypt, $secret_key;
                          $mobile = $encrypt_decrypt->fnEncrypt($mobile, $secret_key);
                          $email = $encrypt_decrypt->fnEncrypt($email, $secret_key);
                          $dmc_name = addslashes($dmc_name);
                          $sq_enquiry = mysql_query("insert into dmc_master (dmc_id, company_name, mobile_no, landline_no, email_id, contact_person_name,immergency_contact_no, dmc_address, country, website, opening_balance, service_tax_no, bank_name,account_name,account_no,branch,ifsc_code, active_flag, created_at, city_id,state_id,side,pan_no,as_of_date) values ('$dmc_id', '$dmc_name', '$mobile', '$landline', '$email', '$contact_person', '$emergency_contact', '$address', '$country', '$website', '$opening_balance', '$gst_no','$bank_name','$account_name','$account_no','$branch','$ifsc_code','Active','$created_at', '$city_id','$state_id','$side','$supp_pan','$as_of_date')");

                          if($sq_enquiry){
                            $vendor_login_master = new vendor_login_master;
                            $vendor_login_master->vendor_login_save($dmc_name, $mobile, 'DMC Vendor', $dmc_id, 'Active', $email,$opening_balance,$side,$as_of_date);
                          }
                          else{
                            $flag = false;
                            echo "error--Supplier Information Not Saved.";
                          } 
                        }
                        else
                        {
                          $invalidCount++;
                          array_push($unprocessedArray, $data);
                        }
                    }
                    else
                    {
                      $invalidCount++;
                      array_push($unprocessedArray, $data);
                    }
              
            }  
            
            $count++;

        }

        fclose($handle);

         if(isset($unprocessedArray) && !empty($unprocessedArray))
        {
          $filePath='../../download/unprocessed_dmc_records'.$downloaded_at.'.csv';
          $save = preg_replace('/(\/+)/','/',$filePath);
          $downloadurl='../../download/unprocessed_dmc_records'.$downloaded_at.'.csv';
          header("Content-type: text/csv ; charset:utf-8");
          header("Content-Disposition: attachment; filename=file.csv");
          header("Pragma: no-cache");
          header("Expires: 0");
          $output = fopen($save, "w");  
          fputcsv($output, array('city_id' , 'DMC_Name' , 'Mobile' , 'landline' ,'Email', 'Contact Person' , 'Emergency Contact No' , 'Address' , 'state_id' , 'Country' , 'Website' , 'Bank Name' , 'Account Name' , 'Account No' , 'Branch', 'IFSC/swift Code' , 'PAN/TAN No' , 'Tax No' , 'Opening Balance','As Of date','Side'));
          
          foreach($unprocessedArray as $row){
            fputcsv($output, $row);  
          }
          fclose($output); 
          echo "<script> window.location ='$downloadurl'; </script>";  
        }
    }

    if($flag){
      commit_t();
      if($validCount > 0)
      {
          echo  $validCount." records successfully imported<br>
          ".$invalidCount." records are failed.";
      }
      else
      {
        echo " No Supplier information imported";
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