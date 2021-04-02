<?php 
class save_master{

public function master_save()
{
	$branch_admin_id = $_POST['branch_admin_id'];
	$comp_name = $_POST['comp_name'];
	$under_statue = $_POST['under_statue'];
	$payment = $_POST['payment'];
	$due_date = $_POST['due_date'];
	$resp_person  = $_POST['resp_person'];
	$description  = $_POST['description'];

	$due_date = get_date_db($due_date);
	begin_t();

	//Master table
	$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from other_complaince_master"));
	$id = $sq_max['max'] + 1;
	$sq_comp = mysql_query("insert into other_complaince_master (id,branch_admin_id, comp_name, under_statue, payment, due_date, resp_person, description,comp_date) values ('$id','$branch_admin_id','$comp_name','$under_statue','$payment','$due_date','$resp_person','$description','')");
	if($sq_comp){
		commit_t();
		echo "Other Compliances saved successfully!";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Other Compliances not saved!";
		exit;
	}
}

public function master_update()
{
	$comp_date  = $_POST['comp_date'];
	$comment = $_POST['comment'];
	$comp_id = $_POST['comp_id'];

	$comp_date = get_date_db($comp_date);
	begin_t();

	$sq_comp = mysql_query("update other_complaince_master set comp_date='$comp_date', comment='$comment' where id='$comp_id'");
	if($sq_comp){
		commit_t();
		echo "Other Compliances saved successfully!";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Other Compliances not saved!";
		exit;
	}
}



}
?>