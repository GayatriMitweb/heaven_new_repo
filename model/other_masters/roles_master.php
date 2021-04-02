<?php 
class roles_master{

public function role_save()
{
	$role_name = $_POST['role_name'];
	$active_flag = $_POST['active_flag'];

    $role_name1 = ltrim($role_name);
	$sq_count = mysql_num_rows(mysql_query("select * from role_master where role_name='$role_name1'"));
	if($sq_count>0){
		echo "error--Role already exists!";
		exit;
	}

	$sq_max = mysql_fetch_assoc(mysql_query("select max(role_id) as max from role_master"));
	$role_id = $sq_max['max'] + 1;

	$sq_role = mysql_query("insert into role_master ( role_id, role_name, active_flag ) values ( '$role_id', '$role_name', '$active_flag' )");
	if($sq_role){
		echo "Role has been successfully saved.";
		exit;
	}
	else{
		echo "error--Role not saved!";
		exit;
	}
}

public function role_update()
{
	$role_id = $_POST['role_id'];
	$role_name = $_POST['role_name'];
	$active_flag = $_POST['active_flag'];

    $role_name1 = ltrim($role_name);
	$sq_count = mysql_num_rows(mysql_query("select * from role_master where role_name='$role_name1' and role_id!='$role_id'"));
	if($sq_count>0){
		echo "error--Role already exists!";
		exit;
	}

	$sq_role = mysql_query("update role_master set role_name='$role_name', active_flag='$active_flag' where role_id='$role_id'");
	if($sq_role){
		echo "Role has been successfully updated.";
		exit;
	}
	else{
		echo "error--Role not updated!";
		exit;
	}
}

}
?>