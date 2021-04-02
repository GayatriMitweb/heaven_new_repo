<?php 
class subgroup_master{

public function subgroup_master_save()
{
	$subgroup_name = $_POST['subgroup_name'];
	$group_id = $_POST['group_id'];

	$sq_count = mysql_num_rows(mysql_query("select subgroup_name from subgroup_master where subgroup_name='$subgroup_name'"));
	if($sq_count>0){
		echo "error--".$subgroup_name." already exists!";
		exit;
	}

	$sq_max = mysql_fetch_assoc(mysql_query("select max(subgroup_id) as max from subgroup_master"));
	$subgroup_id = $sq_max['max'] + 1;

	$sq_side = mysql_fetch_assoc(mysql_query("select * from subgroup_master where subgroup_id='$group_id'"));
	$side = $sq_side['dr_cr'];

	$subgroup_name = addslashes($subgroup_name);
	begin_t();
	$query  = "insert into subgroup_master(subgroup_id,subgroup_name,group_id,dr_cr)values('$subgroup_id','$subgroup_name','$group_id','$side')";
	$sq_bank = mysql_query($query);
	if($sq_bank){
		commit_t();
		echo "Group has been successfully saved.";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Group not saved!".$query;
		exit;
	}

}

public function subgroup_master_update()
{
	$subgroup_id = $_POST['subgroup_id'];
	$subgroup_name = $_POST['subgroup_name'];
	$group_id = $_POST['group_id'];

	$sq_count = mysql_num_rows(mysql_query("select subgroup_name from subgroup_master where subgroup_name='$subgroup_name' and subgroup_id!='$subgroup_id'"));
	if($sq_count>0){
		echo "error--".$subgroup_name." already exists!";
		exit;
	}

	begin_t();
	$subgroup_name = addslashes($subgroup_name);
	$sq_bank = mysql_query("update subgroup_master set subgroup_name='$subgroup_name', group_id='$group_id' where subgroup_id='$subgroup_id'");
	if($sq_bank){
		commit_t();
		echo "Group has been successfully updated.";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Group not updated!";
		exit;
	}

}

}
?>