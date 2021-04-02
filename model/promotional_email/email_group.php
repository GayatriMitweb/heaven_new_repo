<?php 
class email_group{

public function email_group_save()
{

	$email_group_name = $_POST['email_group_name'];
	$created_at = date('Y-m-d');
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$sq_max = mysql_fetch_assoc(mysql_query("select max(email_group_id) as max from email_group_master"));
	$email_group_id = $sq_max['max'] + 1;

	$sq_email_group_count = mysql_num_rows(mysql_query("select * from email_group_master where email_group_name='$email_group_name'"));
	if($sq_email_group_count>0){
		echo "error--Sorry, This Email ID group already exists!";
		exit;
	}

	$sq_email_group = mysql_query("insert into email_group_master ( email_group_id, branch_admin_id, email_group_name, created_at ) values ( '$email_group_id', '$branch_admin_id' ,'$email_group_name', '$created_at' )");
	if($sq_email_group){
		echo "Email group has been successfully saved.";
		exit;
	}
	else{
		echo "error--Sorry, Email ID group  not saved!";
		exit;
	}

}

public function email_group_update()
{
	$email_group_id = $_POST['email_group_id'];
	$email_group_name = $_POST['email_group_name'];

	$sq_sms_group_count = mysql_num_rows(mysql_query("select * from email_group_master where email_group_name='$email_group_name' and email_group_id!='$email_group_id'"));
	if($sq_sms_group_count>0){
		echo "error--Sorry, This Email ID  group already exists!";
		exit;
	}

	$sq_sms_group = mysql_query("update email_group_master set email_group_name='$email_group_name' where email_group_id='$email_group_id'");
	if($sq_sms_group){
		echo "Group has been successfully updated.";
		exit;
	}
	else{
		echo "error--Sorry, Email ID  group not updated!";
		exit;
	}
}

}
?>