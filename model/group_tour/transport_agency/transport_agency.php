<?php
$flag = true;
class transport_agency{

function transport_agency_master_save( $city_id, $transport_agency_name, $mobile_no,$landline_no, $email_id, $contact_person_name,$immergency_contact_no, $transport_agency_address, $country, $website, $opening_balance, $active_flag, $service_tax_no, $bank_name,$account_name ,$account_no, $branch, $ifsc_code,$state,$side,$supp_pan,$as_of_date){

  $city_id = mysql_real_escape_string($city_id);
  $mobile_no = mysql_real_escape_string($mobile_no);
  $landline_no = mysql_real_escape_string($landline_no);
  $email_id = mysql_real_escape_string($email_id);
  $contact_person_name = mysql_real_escape_string($contact_person_name);
  $immergency_contact_no = mysql_real_escape_string($immergency_contact_no);
  $country = mysql_real_escape_string($country);
  $website = mysql_real_escape_string($website);
  $transport_agency_address = mysql_real_escape_string($transport_agency_address);
  $opening_balance = mysql_real_escape_string($opening_balance);
  $active_flag = mysql_real_escape_string($active_flag);
  $service_tax_no = mysql_real_escape_string($service_tax_no);
  $bank_name = mysql_real_escape_string($bank_name);
  $account_name = mysql_real_escape_string($account_name);
  $account_no = mysql_real_escape_string($account_no);
  $branch = mysql_real_escape_string($branch);
  $ifsc_code = mysql_real_escape_string($ifsc_code);
  $state = mysql_real_escape_string($state);
  $side = mysql_real_escape_string($side);
  $supp_pan = mysql_real_escape_string($supp_pan);
  $as_of_date = mysql_real_escape_string($as_of_date);
  $as_of_date = get_date_db($as_of_date);
  begin_t();
  global $encrypt_decrypt, $secret_key;
  $mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
  $email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);

  $transport_agency_name_count = mysql_num_rows(mysql_query("select transport_agency_name from transport_agency_master where transport_agency_name='$transport_agency_name'"));
  if($transport_agency_name_count>0)

  {
    echo "error--Transport Agency name already exists!";
    exit;
  }  

	$transport_agency_name = addslashes($transport_agency_name);
  $max_transport_agency_id1 = mysql_fetch_assoc(mysql_query("select max(transport_agency_id) as max from transport_agency_master"));
  $max_transport_agency_id = $max_transport_agency_id1['max']+1;

  $sq = mysql_query("insert into transport_agency_master ( transport_agency_id, city_id, transport_agency_name, mobile_no,landline_no, email_id, contact_person_name,immergency_contact_no, transport_agency_address, country, website, opening_balance, service_tax_no, active_flag, bank_name,account_name, account_no, branch, ifsc_code , state_id,side,pan_no,as_of_date) values ( '$max_transport_agency_id', '$city_id', '$transport_agency_name', '$mobile_no','$landline_no', '$email_id', '$contact_person_name', '$immergency_contact_no', '$transport_agency_address','$country','$website', '$opening_balance', '$service_tax_no', '$active_flag','$bank_name','$account_name','$account_no','$branch','$ifsc_code','$state','$side','$supp_pan','$as_of_date')");
  sundry_creditor_balance_update();

  if(!$sq)
  {
    rollback_t();
    echo "error--Transport Agency details not saved!";
    exit;
  } 
  else
  {
     $vendor_login_master = new vendor_login_master;
     $vendor_login_master->vendor_login_save($transport_agency_name, $mobile_no, 'Transport Vendor', $max_transport_agency_id, $active_flag, $email_id,$opening_balance,$side,$as_of_date);
     if($GLOBALS['flag']){
        commit_t();
        echo "Transport has been successfully saved.";
        exit;
    }  

    else{
        rollback_t();
        exit;
    }
  } 
}
function transport_agency_master_update( $transport_agency_id, $vendor_login_id, $city_id, $transport_agency_name, $mobile_no,$landline_no, $email_id, $contact_person_name,$immergency_contact_no, $transport_agency_address, $country, $website, $opening_balance, $active_flag, $service_tax_no, $bank_name,$account_name, $account_no, $branch, $ifsc_code,$state,$side,$supp_pan,$as_of_date)

{
  $city_id = mysql_real_escape_string($city_id);
  //$transport_agency_name = mysql_real_escape_string($transport_agency_name);
  $mobile_no = mysql_real_escape_string($mobile_no);
  $landline_no = mysql_real_escape_string($landline_no);
  $email_id = mysql_real_escape_string($email_id);
  $contact_person_name = mysql_real_escape_string($contact_person_name);
  $transport_agency_address = mysql_real_escape_string($transport_agency_address);
  $opening_balance = mysql_real_escape_string($opening_balance);
  $active_flag = mysql_real_escape_string($active_flag);
  $service_tax_no = mysql_real_escape_string($service_tax_no);
  $immergency_contact_no = mysql_real_escape_string($immergency_contact_no);
  $country = mysql_real_escape_string($country);
  $website = mysql_real_escape_string($website);
  $bank_name = mysql_real_escape_string($bank_name);
  $account_name = mysql_real_escape_string($account_name);
  $account_no = mysql_real_escape_string($account_no);
  $branch = mysql_real_escape_string($branch);
  $ifsc_code = mysql_real_escape_string($ifsc_code);
  $state = mysql_real_escape_string($state);
  $side = mysql_real_escape_string($side);
  $supp_pan = mysql_real_escape_string($supp_pan);
  $as_of_date = get_date_db($as_of_date);
  global $encrypt_decrypt, $secret_key;
  $mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
  $email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
  begin_t();

  $transport_agency_name_count = mysql_num_rows(mysql_query("select transport_agency_name from transport_agency_master where transport_agency_name='$transport_agency_name' and transport_agency_id!='$transport_agency_id'"));

  if($transport_agency_name_count>0)
  {
    echo "error--Transport Agency name already exit!";
    exit;
  }  

	$transport_agency_name = addslashes($transport_agency_name);
  $sq = mysql_query("update transport_agency_master set city_id='$city_id', transport_agency_name='$transport_agency_name', mobile_no='$mobile_no',landline_no ='$landline_no', email_id='$email_id', contact_person_name='$contact_person_name', immergency_contact_no='$immergency_contact_no', transport_agency_address='$transport_agency_address', country='$country', website='$website', opening_balance='$opening_balance', active_flag='$active_flag', service_tax_no='$service_tax_no', bank_name='$bank_name',account_name='$account_name',account_no='$account_no',branch='$branch',ifsc_code='$ifsc_code', state_id='$state',side='$side',pan_no='$supp_pan' ,as_of_date = '$as_of_date' where transport_agency_id='$transport_agency_id'");
   sundry_creditor_balance_update();
  if(!$sq)
  {
    rollback_t();
    echo "error--Transport Agency details not updated!";
    exit;
  } 
  else
  { 
     $vendor_login_master = new vendor_login_master;
     $vendor_login_master->vendor_login_update($vendor_login_id, $transport_agency_name, $mobile_no, $transport_agency_id, $active_flag, $email_id,'Transport Vendor',$opening_balance,$side,$as_of_date);
     if($GLOBALS['flag']){
        commit_t();
        echo "Transport has been successfully updated.";
        exit;
     }  
     else{
        rollback_t();
        exit;
     }
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
                
                $sq_max_id = mysql_fetch_assoc(mysql_query("select max(transport_agency_id) as max from transport_agency_master"));
                $transport_agency_id = $sq_max_id['max']+1;

                $city_id = $data[0];
                $transport_name = $data[1];
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
                
                   if(preg_match('/^[0-9]*$/', $city_id) && preg_match('/^[a-zA-Z \s]*$/', $transport_name) && preg_match('/^[0-9]*$/', $state_id) && preg_match('/^[0-9]*$/', $opening_balance)  && !empty($side) && !empty($as_of_date) && ($as_of_date!='1970-01-01') && (strlen($mobile)<=20)){
                      $sq_transport_count = mysql_num_rows(mysql_query("select * from transport_agency_master where transport_agency_name='$transport_name'"));
                      if($sq_transport_count==0)
                      {
                          $validCount++;
                          global $encrypt_decrypt, $secret_key;
                          $mobile = $encrypt_decrypt->fnEncrypt($mobile, $secret_key);
                          $email = $encrypt_decrypt->fnEncrypt($email, $secret_key);
                          
	                        $transport_name = addslashes($transport_name);
                          $query = "insert into transport_agency_master ( transport_agency_id, city_id, transport_agency_name, mobile_no,landline_no, email_id, contact_person_name,immergency_contact_no, transport_agency_address, country, website, opening_balance, service_tax_no, active_flag, bank_name,account_name, account_no, branch, ifsc_code , state_id,side,pan_no,as_of_date) values ( '$transport_agency_id', '$city_id', '$transport_name', '$mobile','$landline', '$email', '$contact_person', '$emergency_contact', '$address','$country','$website', '$opening_balance', '$gst_no', 'Active','$bank_name','$account_name','$account_no','$branch','$ifsc_code','$state_id','$side','$supp_pan','$as_of_date')";
                          $sq_enquiry = mysql_query($query);

                          if($sq_enquiry)
                          {
                            $vendor_login_master = new vendor_login_master;
                            $vendor_login_master->vendor_login_save($transport_name, $mobile, 'Transport Vendor', $transport_agency_id, 'Active', $email,$opening_balance,$side,$as_of_date);
                          }
                          else {
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
           
          //print_r($unprocessedArray); die;
          $filePath='../../../download/unprocessed_transport_records'.$downloaded_at.'.csv';
          $save = preg_replace('/(\/+)/','/',$filePath);
          //echo $save;
          $downloadurl='../../../download/unprocessed_transport_records'.$downloaded_at.'.csv';
          //echo $downloadurl;
          header("Content-type: text/csv ; charset:utf-8");
        header("Content-Disposition: attachment; filename=file.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
            $output = fopen($save, "w");  
            fputcsv($output, array('city_id' , 'Transport_Name' , 'Mobile' , 'landline' ,'Email', 'Contact Person' , 'Emergency Contact No' , 'Address' , 'state_id' , 'Country' , 'Website' , 'Bank Name' , 'Account Name' , 'Account No' , 'Branch', 'IFSC/swift Code' , 'PAN/TAN No' , 'Tax No' , 'Opening Balance' ,'As Of date', 'Side'));  
          
           foreach($unprocessedArray as $row){
          fputcsv($output, $row);  
           }
            
          fclose($output); 
          //print_r($downloadurl);
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