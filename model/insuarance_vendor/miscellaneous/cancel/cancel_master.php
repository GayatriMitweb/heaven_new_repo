<?php 
class cancel_master{

public function cancel_booking(){

	$booking_id = $_POST['booking_id'];

	$sq_cancel = mysql_query("update miscellaneous_booking_master set booking_status='Cancel' where booking_id='$booking_id'");
	if($sq_cancel){
		echo "Cancalation done!";
		exit;
	}
	else{
		echo "error--Error in cancalation!";
		exit;
	}

}

}
?>