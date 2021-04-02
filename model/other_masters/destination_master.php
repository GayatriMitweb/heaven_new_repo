<?php 
$flag = true;
class destination_master{

	public function destination_save()
	{
		$destination_name_arr = $_POST['destination_name_arr'];
		$status_arr = $_POST['status_arr'];
		begin_t();

		for($i=0; $i<sizeof($destination_name_arr); $i++){
			$destination_name1 = ltrim($destination_name_arr[$i]);

			$sq_count = mysql_num_rows(mysql_query("select dest_id from destination_master where dest_name='$destination_name1'"));
			if($sq_count>0){
				$GLOBALS['flag'] = false;
				echo "error--".$destination_name1." already exists!";
				exit;
			}
			$sq_max = mysql_fetch_assoc(mysql_query("select max(dest_id) as max from destination_master"));
			$dest_id = $sq_max['max'] + 1;

			$sq_airline = mysql_query("insert into destination_master (dest_id, dest_name, status) values ('$dest_id', '$destination_name_arr[$i]', '$status_arr[$i]')");
			if(!$sq_airline){
				$GLOBALS['flag'] = false;
				echo "error--Some Destination not saved";
			}

		}

		if($GLOBALS['flag']){
			commit_t();
			echo "Destination has been successfully saved.";
			exit;
		}
		else{
			rollback_t();
			exit;
		}
	}

function destination_update()
{
	$dest_id = $_POST['dest_id'];
	$dest_name = $_POST['dest_name'];
	$dest_status = $_POST['dest_status'];
	$destination_name1 = ltrim($dest_name);

	$sq_count = mysql_num_rows(mysql_query("select dest_id from destination_master where dest_name='$destination_name1' and dest_id!='$dest_id'"));
	if($sq_count>0){
		$GLOBALS['flag'] = false;
		echo "error--".$destination_name1." already exists!";
		exit;
	}

	$sq_airline = mysql_query("update destination_master set dest_name='$dest_name', status='$dest_status' where dest_id='$dest_id'");
	if($sq_airline){
		echo "Destination has been successfully updated.";
		exit;
	}
	else{
		echo "error--Destination not updated";
		exit;
	}

}
}

?>