<?php
class cancel_estimate_master{

public function cancel_estimate()
{
	$estimate_id = $_POST['estimate_id'];

	$sq_cancel = mysql_query("update vendor_estimate set status='Cancel' where estimate_id='$estimate_id'");
	if($sq_cancel){
		echo "Purchase cancellation done!";
		exit;
	}
	else{
		echo "error--Sorry, Purchase not cancelled!";
		exit;
	}
}

}
?>