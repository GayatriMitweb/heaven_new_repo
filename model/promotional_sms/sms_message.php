<?php 

class sms_message{



public function sms_message_save()

{

	$message = $_POST['message'];

	$created_at = date('Y-m-d');
    $branch_admin_id = $_SESSION['branch_admin_id'];



	$sq_max = mysql_fetch_assoc(mysql_query("select max(sms_message_id) as max from sms_message_master"));

	$sms_message_id = $sq_max['max'] + 1;

	$sq_sms_message_count = mysql_num_rows(mysql_query("select * from sms_message_master where message='$message'"));

	if($sq_sms_message_count>0){

		echo "error--Sorry, This Message already exists!";

		exit;

	}

	$message = addslashes($message);

	$sq_sms_message = mysql_query("insert into sms_message_master ( sms_message_id, branch_admin_id, message, created_at ) values ( '$sms_message_id', '$branch_admin_id', '$message', '$created_at' )");

	if($sq_sms_message){

		echo "SMS has been successfully saved.";

		exit;

	}

	else{

		echo "error--Sorry, Message not saved!";

		exit;

	}



}



public function sms_message_update()

{

	$sms_message_id = $_POST['sms_message_id'];

	$message = $_POST['message'];



	$sq_sms_message_count = mysql_num_rows(mysql_query("select * from sms_message_master where message='$message' and sms_message_id!='$sms_message_id'"));

	if($sq_sms_message_count>0){

		echo "error--Sorry, This Message already exists!";

		exit;

	}


	$message = addslashes($message);
	$sq_sms_message = mysql_query("update sms_message_master set message='$message' where sms_message_id='$sms_message_id'");

	if($sq_sms_message){

		echo "Message has been successfully updated.";

		exit;

	}

	else{

		echo "error--Sorry, Message not updated!";

		exit;

	}

}



public function sms_message_send()

{

	$sms_message_id = $_POST['sms_message_id'];

	$sms_group_id = $_POST['sms_group_id'];



	$sq_message = mysql_fetch_assoc(mysql_query("select message from sms_message_master where sms_message_id='$sms_message_id'"));

	$message = $sq_message['message'];



	$query = "select mobile_no from sms_mobile_no where 1 ";

	if($sms_group_id!=""){

		$query .=" and mobile_no_id in ( select mobile_no_id from sms_group_entries where sms_group_id='$sms_group_id' )";	

	}



	$mobile_no_arr = array();



	$sq_mobile = mysql_query($query);

	while($row_mobile = mysql_fetch_assoc($sq_mobile)){



		array_push($mobile_no_arr, $row_mobile['mobile_no']);



	}

	$mobile_no = implode($mobile_no_arr, ',');



	global $model;

	$model->send_message($mobile_no, $message);

	$created_at = date('Y-m-d H:i:s');



	$sq_max = mysql_fetch_assoc(mysql_query("select max(log_id) as max from sms_sending_log"));

	$log_id = $sq_max['max'] + 1;



	$sq_log = mysql_query("insert into sms_sending_log (log_id, sms_message_id, sms_group_id, created_at) values ('$log_id', '$sms_message_id', '$sms_group_id', '$created_at')");

	echo "Message has been successfully sent";

	exit;



}

}

?>