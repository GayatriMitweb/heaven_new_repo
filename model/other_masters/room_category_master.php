<?php 
class room_category_master{

public function category_save()
{
	$room_category = $_POST['room_category'];
	$status = $_POST['status'];

	$room_category1 = ltrim($room_category);
	$sq_count = mysql_num_rows(mysql_query("select entry_id from room_category_master where room_category='$room_category1'"));
	if($sq_count>0){
		echo "error--".$room_category1." already exists!";
		exit;
	}

	$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from room_category_master"));
	$entry_id = $sq_max['max'] + 1;
	$sq_insert = mysql_query("insert into room_category_master ( entry_id, room_category, active_status ) values ( '$entry_id', '$room_category', '$status' )");
	if($sq_insert){
		echo "Room Category has been successfully saved.";
		exit;
	}
	else{
		echo "error--Room Category not saved!";
		exit;
	}
}

public function category_update()
{
	$entry_id = $_POST['entry_id'];
	$room_category = $_POST['room_category'];
	$active_flag = $_POST['status'];

	$room_category1 = ltrim($room_category);
	$q = "select * from room_category_master where room_category='$room_category1' and entry_id!='$entry_id'";
	$sq_count = mysql_num_rows(mysql_query($q));

	if($sq_count>0){
		echo "error--".$room_category1." already exists!";
		exit;
	}

	$sq_insert = mysql_query("update room_category_master set room_category='$room_category' , active_status='$active_flag'  where entry_id='$entry_id'");
	if($sq_insert){
		echo "Room Category has been successfully updated.";
		exit;
	}
	else{
		echo "error--Room Category not updated!";
		exit;
	}
}

}
?>