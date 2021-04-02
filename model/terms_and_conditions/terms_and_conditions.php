<?php 
class terms_and_conditions
{

public function terms_and_conditions_save()
{
	$type = $_POST['type'];
	$title = $_POST['title'];
	$terms_and_conditions = $_POST['terms_and_conditions'];
	$active_flag = $_POST['active_flag'];
	$branch_admin_id=$_POST['branch_admin_id'];

	$sq_count = mysql_num_rows(mysql_query("select * from terms_and_conditions where type = '$type' and active_flag='Active'"));
	if($sq_count>0){
		echo "error--Sorry, Already exits!";
		exit;
	}


	$created_at = date('Y-m-d H:i:s');
	$terms_and_conditions1 = addslashes($terms_and_conditions);
	$sq_max = mysql_fetch_assoc(mysql_query("select max(terms_and_conditions_id) as max from terms_and_conditions"));
	$terms_and_conditions_id = $sq_max['max']+1;

	$sq_entry = mysql_query("insert into terms_and_conditions (terms_and_conditions_id,branch_admin_id, type, title, terms_and_conditions, active_flag, created_at) values ( '$terms_and_conditions_id','$branch_admin_id', '$type','$title', '$terms_and_conditions1', '$active_flag', '$created_at')");
	if($sq_entry){
		echo "Terms & Conditions has been successfully saved.";
		exit;
	}
	else{
		echo "error--Sorry, Terms & Conditions not saved!";
		exit;
	}
}

public function terms_and_conditions_update()
{
	$terms_and_conditions_id = $_POST['terms_and_conditions_id'];
	$title = $_POST['title'];
	$type = $_POST['type'];
	$terms_and_conditions = $_POST['terms_and_conditions'];
	$active_flag = $_POST['active_flag'];

	if($active_flag == "Active"){
		$sq_active_count = 	mysql_num_rows(mysql_query("select * from terms_and_conditions where terms_and_conditions_id!='$terms_and_conditions_id' and type = '$type' and active_flag='Active'"));
		if($sq_active_count > 0){
			echo "error--Sorry, Terms and Conditions for ".$type." Already exits!";
			exit;
		}
		else{
			$terms_and_conditions1 = addslashes($terms_and_conditions);
			$sq_entry = mysql_query("update terms_and_conditions set type = '$type', title='$title', 	terms_and_conditions='$terms_and_conditions1', active_flag='$active_flag' where 	terms_and_conditions_id='$terms_and_conditions_id'");
			if($sq_entry){
				echo "Terms & Conditions has been successfully updated.";
				exit;
			}
			else{
				echo "error--Sorry, Terms & Conditions not updated!";
				exit;
			}
		}
	}
	if($active_flag == "Inactive"){
		$terms_and_conditions1 = addslashes($terms_and_conditions);
		$sq_entry = mysql_query("update terms_and_conditions set type = '$type', title='$title', 	terms_and_conditions='$terms_and_conditions1', active_flag='$active_flag' where 	terms_and_conditions_id='$terms_and_conditions_id'");
		if($sq_entry){
			echo "Terms & Conditions has been successfully updated.";
			exit;
		}
		else{
			echo "error--Sorry, Terms & Conditions not updated!";
			exit;
		}
	}
}

}
?>