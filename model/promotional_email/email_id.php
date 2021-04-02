<?php
class email_id{
public function email_id_save()
{
	$email_id = $_POST['email_id'];
	$created_at = date('Y-m-d');
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$sq_max = mysql_fetch_assoc(mysql_query("select max(email_id_id) as max from sms_email_id"));
	$email_id_id = $sq_max['max'] + 1;

	$sq_email_id_count = mysql_num_rows(mysql_query("select * from sms_email_id where email_id='$email_id'"));
	if($sq_email_id_count>0){
		echo "error--Sorry, This Email ID already exists!";
		exit;
	}
	else
	{
		$sq_email_id = mysql_query("insert into sms_email_id ( email_id_id, branch_admin_id, email_id, created_at ) values ( '$email_id_id', '$branch_admin_id', '$email_id', '$created_at' )");
		if($sq_email_id){
			echo "Email id has been successfully saved.";
			exit;
		}
		else{
			echo "error--Sorry, Email ID not saved!";
			exit;
		}
	}
}
public function email_id_update()
{
	$email_id_id = $_POST['email_id_id'];
	$email_id = $_POST['email_id'];

	$sq_email_id_count = mysql_num_rows(mysql_query("select * from sms_email_id where email_id='$email_id' and email_id_id!='$email_id_id'"));
	if($sq_email_id_count>0){
		echo "error--Sorry, This Email ID already exists!";
		exit;
	}

	$sq_email_id = mysql_query("update sms_email_id set email_id='$email_id' where email_id_id='$email_id_id'");
	if($sq_email_id){
		echo "Email id has been successfully updated.";
		exit;
	}
	else{
		echo "error--Sorry, Email ID not updated!";
		exit;
	}
}

public function email_id_group_assign()
{
	$email_group_id = $_POST['email_group_id'];
	$email_id_id_arr = $_POST['email_id_id_arr'];
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$sq_email_count = mysql_num_rows(mysql_query("SELECT * FROM `email_group_entries` WHERE email_group_id='$email_group_id'"));

	if($sq_email_count <= '24'){

		for($i=0; $i<sizeof($email_id_id_arr); $i++){

			$email_id_id = $email_id_id_arr[$i];
			$sq_count = mysql_num_rows(mysql_query("select * from email_group_entries where email_group_id='$email_group_id' and email_id_id='$email_id_id'"));
			$email_id_id = str_replace("'","",$email_id_id);

			if($sq_count == 0){
				$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from email_group_entries"));
				$id = $sq_max['max'] + 1;
				$sq_entry = mysql_query("insert into email_group_entries ( id, email_group_id, branch_admin_id, email_id_id ) values( '$id', '$email_group_id', '$branch_admin_id', '$email_id_id' )");
				
				if(!$sq_entry){
					echo "error--Some entries are not assigned!";
					exit;
				}
			}
		}
		echo "Email ID group is assigned successfully!";
		exit;
	}
	else{
		echo "error--Sorry Group Size exceeds!";
		exit; 
	}
}
public function fetch_email_id_from_system()
{
	global $encrypt_decrypt, $secret_key;
	$created_at = date('Y-m-d');
	$branch_status = $_POST['branch_status'];
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$role = $_SESSION['role'];

	//Group Tour
	$query = "select * from traveler_personal_info where 1";
	if($branch_status=='yes' && $role=='Branch Admin'){
      $query .=" and branch_admin_id = '$branch_admin_id'";
    }
    $query .=" and email_id!=''";
    $sq_group_tour = mysql_query($query);
	 
	while($row_group_tour = mysql_fetch_assoc($sq_group_tour)){

		$email_id = $row_group_tour['email_id'];
		if($email_id!=''){
			
			$sq_email_count = mysql_num_rows(mysql_query("select * from sms_email_id where email_id='$email_id'"));
			if($sq_email_count==0){

				$sq_max = mysql_fetch_assoc(mysql_query("select max(email_id_id) as max from sms_email_id"));
				$email_id_id = $sq_max['max'] + 1;

				$sq_email_id = mysql_query("insert into sms_email_id ( email_id_id,branch_admin_id, email_id, created_at ) values ( '$email_id_id', '$branch_admin_id', '$email_id', '$created_at' )");
				if(!$sq_email_id){
					echo "Email ID saved successfully!";
					exit;
				}
			}
		}
	}
	//Package Tour
	$query1 = "select * from package_tour_booking_master where 1";
	if($branch_status=='yes' && $role=='Branch Admin'){
    	$query1 .=" and branch_admin_id = '$branch_admin_id'";
    }
    $query1 .=" and email_id!=''";
	$sq_package_tour = mysql_query($query1);	 
	while($row_package_tour = mysql_fetch_assoc($sq_package_tour)){

		$email_id = $row_group_tour['email_id'];
		if($email_id!=''){

			$sq_email_count = mysql_num_rows(mysql_query("select * from sms_email_id where email_id='$email_id'"));
			if($sq_email_count==0){

				$sq_max = mysql_fetch_assoc(mysql_query("select max(email_id_id) as max from sms_email_id"));
				$email_id_id = $sq_max['max'] + 1;

				$sq_mobile_no = mysql_query("insert into sms_email_id (  email_id_id, branch_admin_id, email_id, created_at ) values ('$email_id_id', '$branch_admin_id', '$email_id', '$created_at' )");
				if(!$sq_mobile_no){
					echo "Email ID  saved successfully!";
					exit;
				}
			}
		}
	}
	//Customer
	$query2 = "select * from customer_master where 1";
	if($branch_status=='yes' && $role=='Branch Admin'){
    	$query2 .=" and branch_admin_id = '$branch_admin_id'";
    }
    $query2 .=" and email_id!=''";
	$sq_customer = mysql_query($query2);
	while($row_customer = mysql_fetch_assoc($sq_customer)){

		$email_id = $encrypt_decrypt->fnDecrypt($row_customer['email_id'], $secret_key);
		if($email_id!=''){

			$sq_email_count = mysql_num_rows(mysql_query("select * from sms_email_id where email_id='$email_id'"));
			if($sq_email_count==0){

				$sq_max = mysql_fetch_assoc(mysql_query("select max(email_id_id) as max from sms_email_id"));
				$email_id_id = $sq_max['max'] + 1;

				$sq_email_id = mysql_query("insert into sms_email_id (email_id_id, branch_admin_id, email_id, created_at ) values ('$email_id_id', '$branch_admin_id', '$email_id', '$created_at' )");
				if(!$sq_email_id){
					echo "Email ID saved successfully!";
					exit;
				}
			}
		}
	}

	echo "Email ID are successfully fetched!";
	exit;

}

public function email_id_from_csv_save()
{
	$csv_url = $_POST['csv_url'];
	$base_url = $_POST['base_url'];
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

	        $sq_max = mysql_fetch_assoc(mysql_query("select max(email_id_id) as max from sms_email_id"));
			$email_id_id = $sq_max['max'] + 1;
			$email_id = $data[0];
			if(!empty($email_id))
			{
				$sq_mobile_no_count = mysql_num_rows(mysql_query("select * from sms_email_id where email_id='$data[0]'"));

			if($sq_mobile_no_count==0){
				$validCount++;
				$sq_mobile_no = mysql_query("insert into sms_email_id ( email_id_id, branch_admin_id, email_id, created_at ) values ( '$email_id_id', '$branch_admin_id' ,'$email_id', '$created_at' )");
				if(!$sq_mobile_no){
					$flag = false;
					echo "error--Email Id not saved!";
					exit;
				}
			   }
			   else{
					$invalidCount++;
			    	$arrResult['email_id']=$email_id;
			    	array_push($unprocessArray, $arrResult);
			    	//print_r($unprocessArray);
				}

			}
			else{
					$invalidCount++;
			    	$arrResult['email_id']=$email_id;
			    	array_push($unprocessArray, $arrResult);
			    	//print_r($unprocessArray);
			}
	    	
			}

	    }
	    $count++;
	    fclose($handle);

	     if(isset($unprocessArray) && !empty($unprocessArray))
	    	{
				

	    		$filePath='..//..//..//download//unprocessed_email_records_.'.$created_at.'.csv';
	    		$save = preg_replace('/(\/+)/','/',$filePath);
	    		//echo $save;
	    		$downloadurl=$base_url.'download/unprocessed_email_records_.'.$created_at.'.csv';
	    		//echo $downloadurl;
	    		header("Content-type: text/csv ; charset:utf-8");
				header("Content-Disposition: attachment; filename=file.csv");
				header("Pragma: no-cache");
				header("Expires: 0");
		      	$output = fopen($save, "w");  
		      	fputcsv($output, array('Email ID'));  
		      
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
	rollback_t();
	exit;
	}
}

}
?>