<?php 
class booking_type_master{

public function booking_type_save()
{
	$booking_type = $_POST['booking_type'];
	$gl_id = $_POST['gl_id'];

	$created_at = date('Y-m-d H:i:s');

	$sq_count = mysql_num_rows(mysql_query("select booking_type_id from miscellaneous_booking_type where booking_type='$booking_type'"));
	if($sq_count>0){
		echo "error--Booking type already exists!";
		exit;
	}

	$sq_max = mysql_fetch_assoc(mysql_query("select max(booking_type_id) as max from miscellaneous_booking_type"));
	$booking_type_id = $sq_max['max'] + 1;

	$sq_type = mysql_query("insert into miscellaneous_booking_type (booking_type_id, gl_id, booking_type, created_at) values ('$booking_type_id', '$gl_id', '$booking_type', '$created_at')");
	if($sq_type){
		echo "Booking type saved!";
		exit;
	}
	else{
		echo "error--Booking not saved!";
		exit;
	}
}

public function booking_type_update()
{
	$booking_type_id = $_POST['booking_type_id'];
	$booking_type = $_POST['booking_type'];
	$gl_id = $_POST['gl_id'];

	$sq_count = mysql_num_rows(mysql_query("select booking_type_id from miscellaneous_booking_type where booking_type='$booking_type' and booking_type_id1!='$booking_type_id'"));
	if($sq_count>0){
		echo "error--Booking type already exists!";
		exit;
	}

	$sq_type = mysql_query("update miscellaneous_booking_type set booking_type='$booking_type', gl_id='$gl_id' where booking_type_id='$booking_type_id'");
	if($sq_type){
		echo "Booking type updated!";
		exit;
	}
	else{
		echo "error--Booking not updated!";
		exit;
	}
}

}
?>