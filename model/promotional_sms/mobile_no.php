<?php 
class mobile_no{

public function mobile_no_save()
{

	$mobile_no = $_POST['mobile_no'];
	$created_at = date('Y-m-d');
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$sq_max = mysql_fetch_assoc(mysql_query("select max(mobile_no_id) as max from sms_mobile_no"));
	$mobile_no_id = $sq_max['max'] + 1;

	$sq_mobile_no_count = mysql_num_rows(mysql_query("select * from sms_mobile_no where mobile_no='$mobile_no'"));
	if($sq_mobile_no_count>0){
		echo "error--Sorry, This mobile no already exists!";
		exit;
	}

	$sq_mobile_no = mysql_query("insert into sms_mobile_no ( mobile_no_id, branch_admin_id, mobile_no, created_at ) values ( '$mobile_no_id', '$branch_admin_id', '$mobile_no', '$created_at' )");
	if($sq_mobile_no){
		echo "Mobile No. has been successfully saved.";
		exit;
	}
	else{
		echo "error--Sorry, Mobile No not saved!";
		exit;
	}

}

public function mobile_no_update()
{
	$mobile_no_id = $_POST['mobile_no_id'];
	$mobile_no = $_POST['mobile_no'];

	$sq_mobile_no_count = mysql_num_rows(mysql_query("select * from sms_mobile_no where mobile_no='$mobile_no' and mobile_no_id!='$mobile_no_id'"));
	if($sq_mobile_no_count>0){
		echo "error--Sorry, This mobile no already exists!";
		exit;
	}

	$sq_mobile_no = mysql_query("update sms_mobile_no set mobile_no='$mobile_no' where mobile_no_id='$mobile_no_id'");
	if($sq_mobile_no){
		echo "Mobile No. has been successfully updated.";
		exit;
	}
	else{
		echo "error--Sorry, Mobile No not updated!";
		exit;
	}
}

public function mobile_no_group_assign()
{
	$sms_group_id = $_POST['sms_group_id'];
	$mobile_no_id_arr = $_POST['mobile_no_id_arr'];

	$sq_mobile_count = mysql_num_rows(mysql_query("SELECT * FROM `sms_group_entries` WHERE sms_group_id='$sms_group_id'"));
	if($sq_mobile_count <='24'){

		for($i=0; $i<sizeof($mobile_no_id_arr); $i++){

			$mobile_no_id = $mobile_no_id_arr[$i];
			$sq_count = mysql_num_rows(mysql_query("select * from sms_group_entries where sms_group_id='$sms_group_id' and mobile_no_id='$mobile_no_id'"));
			if($sq_count==0){

				$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from sms_group_entries"));
				$id = $sq_max['max'] + 1;
				$sq_entry = mysql_query("insert into sms_group_entries ( id, sms_group_id, mobile_no_id ) values( '$id', '$sms_group_id', $mobile_no_id )");
				if(!$sq_entry){
					echo "error--Some entries are not assigned!";
					exit;
				}
			}
		}
		echo "SMS group is assigned successfully!";
		exit;
	}
	else{
		echo "error--Sorry Group Size exceeds!";
		exit; 
	}
}

public function fetch_mobile_no_from_system()
{
	global $encrypt_decrypt, $secret_key;
	$created_at = date('Y-m-d');
	$branch_status = $_POST['branch_status'];
	$branch_admin_id = $_POST['branch_admin_id'];
	$role = $_SESSION['role'];
	 
	$query = "select * from traveler_personal_info where 1";
	if($branch_status=='yes' && $role=='Branch Admin'){
      $query .=" and branch_admin_id = '$branch_admin_id'";
    }

    $sq_group_tour = mysql_query($query);
 
	while($row_group_tour = mysql_fetch_assoc($sq_group_tour)){
		
		if($row_group_tour['mobile_no'] != ''){

			$sq_mobile_no_count = mysql_num_rows(mysql_query("select * from sms_mobile_no where mobile_no='$row_group_tour[mobile_no]'"));
			if($sq_mobile_no_count==0){

				$sq_max = mysql_fetch_assoc(mysql_query("select max(mobile_no_id) as max from sms_mobile_no"));
				$mobile_no_id = $sq_max['max'] + 1;

				$sq_mobile_no = mysql_query("insert into sms_mobile_no ( mobile_no_id, branch_admin_id, mobile_no, created_at ) values ( '$mobile_no_id', '$branch_admin_id', '$row_group_tour[mobile_no]', '$created_at' )");
				if(!$sq_mobile_no){
					echo "Mobile no saved successfully!";
					exit;
				}
			}
		}
	}

	$query1 = "select * from package_tour_booking_master where 1";
	if($branch_status=='yes' && $role=='Branch Admin'){
      $query1 .=" and branch_admin_id = '$branch_admin_id'";
    }
	$sq_package_tour = mysql_query($query1);
	while($row_package_tour = mysql_fetch_assoc($sq_package_tour)){

		if($row_group_tour['mobile_no'] != ''){
			
			$sq_mobile_no_count = mysql_num_rows(mysql_query("select * from sms_mobile_no where mobile_no='$row_package_tour[mobile_no]'"));	
			if($sq_mobile_no_count==0){

				$sq_max = mysql_fetch_assoc(mysql_query("select max(mobile_no_id) as max from sms_mobile_no"));
				$mobile_no_id = $sq_max['max'] + 1;

				$sq_mobile_no = mysql_query("insert into sms_mobile_no ( mobile_no_id, branch_admin_id, mobile_no, created_at ) values ( '$mobile_no_id', '$branch_admin_id' ,'$row_package_tour[mobile_no]', '$created_at' )");
				if(!$sq_mobile_no){
					echo "Mobile no saved successfully!";
					exit;
				}
			}
		}
	}
	$query2 = "select * from customer_master where 1";
	if($branch_status=='yes' && $role=='Branch Admin'){
    	$query2 .=" and branch_admin_id = '$branch_admin_id'";
    }
	$sq_customer = mysql_query($query2);
	while($row_customer = mysql_fetch_assoc($sq_customer)){

		$contact_no = $encrypt_decrypt->fnDecrypt($row_customer['contact_no'], $secret_key);
		if($contact_no!=''){

			$sq_mobile_no_count = mysql_num_rows(mysql_query("select * from sms_mobile_no where mobile_no='$row_customer[contact_no]'"));
			if($sq_mobile_no_count==0){

				$sq_max = mysql_fetch_assoc(mysql_query("select max(mobile_no_id) as max from sms_mobile_no"));
				$mobile_no_id = $sq_max['max'] + 1;

				$sq_mobile_no = mysql_query("insert into sms_mobile_no ( mobile_no_id,branch_admin_id, mobile_no, created_at ) values ( '$mobile_no_id', '$branch_admin_id', '$contact_no', '$created_at' )");
				if(!$sq_mobile_no){
					echo "Mobile no saved successfully!";
					exit;
				}
			}
		}

	}

	echo "Mobile No are successfully fetched!";
	exit;

}

public function mobile_no_from_csv_save()
{
	$csv_url = $_POST['csv_url'];
	$base_url= $_POST['base_url'];

	$flag = true;
	$created_at = date('Y-m-d');
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$download_url = preg_replace('/(\/+)/','/',$csv_url);

	$File = $download_url;
	begin_t();
	$count = 1;
	$validCount=0;
	$invalidCount=0;
	$arrResult  = array();
	$unprocessArray= array();
	$handle     = fopen($File, "r");
	if(empty($handle) === false) {
	    while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
	    	if($count == 1){ $count++; continue; }
	        if($count>0){

			$mobile_no = $data[0];

			if(preg_match('/^[0-9 \s]{6,20}+$/', $mobile_no) )
		    {
		    	//echo $flag;
	        	$sq_max = mysql_fetch_assoc(mysql_query("select max(mobile_no_id) as max from sms_mobile_no"));
				$mobile_no_id = $sq_max['max'] + 1;
		        $sq_mobile_no_count = mysql_num_rows(mysql_query("select * from sms_mobile_no where mobile_no='$data[0]'"));

				if($sq_mobile_no_count==0)
				{
					$validCount++;

					$sq_mobile_no = mysql_query("insert into sms_mobile_no( mobile_no_id,branch_admin_id,mobile_no, created_at ) values ('$mobile_no_id', '$branch_admin_id', '$mobile_no', '$created_at')");
					//echo $sq_mobile_no;
					if(!$sq_mobile_no){
						$flag = false;
						echo "Error description: " . $mobile_no;
						exit;
					}
				}
				else
			    {	
			    	$invalidCount++;
			    	$arrResult['mobile_no']=$mobile_no;
			    	array_push($unprocessArray, $arrResult);
			    }
		    }
		    else
		    {	
		    	$invalidCount++;
		    	$arrResult['mobile_no']=$mobile_no;
		    	array_push($unprocessArray, $arrResult);
		    }
		}
	    }

	    $count++;
	    fclose($handle);

	    if(isset($unprocessArray) && !empty($unprocessArray))
	    	{
	    		$filePath='..//..//..//download//unprocessed_mobile_records'.$created_at.'.csv';
	    		$save = preg_replace('/(\/+)/','/',$filePath);
	    		//echo $save;
	    		$downloadurl=$base_url.'download/unprocessed_mobile_records'.$created_at.'.csv';
	    		//echo $downloadurl;
	    		header("Content-type: text/csv ; charset:utf-8");
				header("Content-Disposition: attachment; filename=file.csv");
				header("Pragma: no-cache");
				header("Expires: 0");
		      	$output = fopen($save, "w");  
		      	fputcsv($output, array('Mobile_no'));  
		      
		       foreach($unprocessArray as $row){
 					fputcsv($output, $row);  
		       }
		       	
		      fclose($output); 
		      echo "<script> window.location ='$downloadurl'; </script>";  
			}	

	}
	if($flag){
	commit_t();
	if($validCount>0)
	{
		echo  $validCount." records successfully imported<br>
			".$invalidCount." records are failed.";
	}
	else
	{
		echo "No records imported successfully!";
	}
	exit;
	}
	else{
	//echo "CSV imported successfully!";
	rollback_t();
	exit;
	}

	}


}
?>