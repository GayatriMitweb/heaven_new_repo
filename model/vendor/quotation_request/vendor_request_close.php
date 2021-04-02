<?php 
class vendor_request_close{

public function request_close()
{
	$request_id = $_POST['request_id'];

	begin_t();
	$sq_req = mysql_query("update vendor_request_master set bid_status='Close' where request_id='$request_id'");
	if($sq_req){
		commit_t();
		echo "Quotation is closed!";
		exit;
	}
	else{
		rollback_t();
		echo "error--Quotation not closed!";
		exit;
	}

}

}
?>