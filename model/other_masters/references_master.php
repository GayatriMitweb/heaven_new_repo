<?php 
class references_master{

public function reference_save()
{
	$reference_name = $_POST['reference'];
	$status = $_POST['status'];
	$created_at = date("Y-m-d H:i:S");

	$reference_name1 = ltrim($reference_name);
	$sq_count = mysql_num_rows(mysql_query("select reference_id from references_master where reference_name='$reference_name1'"));
	if($sq_count>0){
		echo "error--".$reference_name1." already exists!";
		exit;
	}

	$sq_max = mysql_fetch_assoc(mysql_query("select max(reference_id) as max from references_master"));
	$reference_id = $sq_max['max'] + 1;

	$sq_insert = mysql_query("insert into references_master ( reference_id, reference_name, created_at, active_flag ) values ( '$reference_id', '$reference_name', '$created_at', '$status' )");
	if($sq_insert){
		echo "References has been successfully saved.";
		exit;
	}
	else{
		echo "error--Reference not saved!";
		exit;
	}
}

public function reference_update()
{
	$reference_id = $_POST['reference_id'];
	$reference_name = $_POST['reference'];
	$active_flag = $_POST['status'];

	$reference_name1 = ltrim($reference_name);
	$created_at = date("Y-m-d H:i:S");
	$q = "select * from references_master where reference_name='$reference_name1' and reference_id!='$reference_id'";
	$sq_count = mysql_num_rows(mysql_query($q));

	if($sq_count>0){
		echo "error--".$reference_name1." already exists!";
		exit;
	}

	$sq_insert = mysql_query("update references_master set reference_name='$reference_name' , active_flag='$active_flag'  where reference_id='$reference_id'");
	if($sq_insert){
		echo "References has been successfully updated.";
		exit;
	}
	else{
		echo "error--Reference not updated!";
		exit;
	}
}

}
?>