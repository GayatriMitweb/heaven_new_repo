<?php 
class branch_master{

public function branch_master_save()
{
	$branch_name = trim($_POST['branch_name']);
	$location_id = $_POST['locations_id'];   //changed due to select2 error for same id
	$branch_address = trim($_POST['branch_address']);
	$contact_no = $_POST['contact_no'];
	$email_id = $_POST['email_id'];
	$landline_no = $_POST['landline_no'];
	$address1 = trim($_POST['address1']);
	$address2 =trim($_POST['address2']);
	$city = trim($_POST['city']);
	$pincode = $_POST['pincode'];
	$state = $_POST['state'];
	$bank_name = $_POST['bank_name'];
	$acc_name = trim($_POST['acc_name']);
	$bank_acc_no = $_POST['bank_acc_no'];
	$bank_branch_name = trim($_POST['bank_branch_name']);
	$bank_ifsc_code = $_POST['bank_ifsc_code'];
	$branch_tax = $_POST['branch_tax'];
	$active_flag = $_POST['active_flag'];
	$created_at = date('Y-m-d');

	$branch_count = mysql_num_rows( mysql_query("select * from branches where branch_name='$branch_name' and location_id='$location_id'") );
	if($branch_count>0){
		echo "error--Sorry, Branch name already exists.";
		exit;
	}

	$branch_id = mysql_fetch_assoc(mysql_query("select max(branch_id) as max from branches"));
	$branch_id = $branch_id['max']+1;

	$address1 = addslashes($address1);	
	$address2 = addslashes($address2);	
	$sq_branch = mysql_query("insert into branches ( branch_id, branch_name, location_id, branch_address,contact_no, email_id, landline_no, address1, address2, city, pincode, bank_name, acc_name, bank_acc_no, bank_branch_name, ifsc_code, active_flag, created_at, branch_tax, state ) values ( '$branch_id', '$branch_name', '$location_id', '$branch_address', '$contact_no', '$email_id', '$landline_no' , '$address1', '$address2', '$city', '$pincode', '$bank_name', '$acc_name', '$bank_acc_no', '$bank_branch_name', '$bank_ifsc_code', '$active_flag', '$created_at', '$branch_tax','$state' )");
	if($sq_branch){
		echo "Your branch has been successfully saved.";
		exit;
	}
	else{
		echo "error--Sorry, Branch not saved";
		exit;
	}
}

public function branch_master_update()
{
	$branch_id = $_POST['branch_id'];
	$branch_name = trim($_POST['branch_name1']);
	$location_id = $_POST['location_id'];   //changed due to select2 error for same id
	$branch_address = trim($_POST['branch_address']);
	$contact_no = $_POST['contact_no'];
	$email_id = $_POST['email_id'];
	$landline_no = $_POST['landline_no'];
	$address1 = trim($_POST['address1']);
	$address2 =trim($_POST['address2']);
	$city = trim($_POST['city']);
	$pincode = $_POST['pincode'];
	$state = $_POST['state'];
	$bank_name = $_POST['bank_name'];
	$acc_name = trim($_POST['acc_name']);
	$bank_acc_no = $_POST['bank_acc_no'];
	$bank_branch_name = trim($_POST['bank_branch_name']);
	$bank_ifsc_code = $_POST['bank_ifsc_code'];
	$branch_tax = $_POST['branch_tax'];
	$active_flag = $_POST['active_flag'];
	
	$branch_count = mysql_num_rows( mysql_query("select * from branches where branch_name='$branch_name' and location_id='$location_id' and branch_id!='$branch_id'") );
	if($branch_count>0){
		echo "error--Sorry, Branch name already exists.";
		exit;
	}
	
	$address1 = addslashes($address1);	
	$address2 = addslashes($address2);	
	$sq_branch = mysql_query("update branches set branch_name='$branch_name', location_id='$location_id', branch_address='$branch_address', contact_no='$contact_no', email_id='$email_id', landline_no='$landline_no', address1='$address1', address2='$address2', city='$city', pincode='$pincode', bank_name='$bank_name', bank_acc_no='$bank_acc_no', acc_name='$acc_name', bank_branch_name='$bank_branch_name', ifsc_code='$bank_ifsc_code', active_flag='$active_flag', branch_tax='$branch_tax',state='$state' where branch_id='$branch_id'");
	if($sq_branch){
		echo "Your branch has been successfully updated.";
		exit;
	}
	else{
		echo "error--Sorry, Branch not updated";
		exit;
	}
}

}
?>