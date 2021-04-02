<?php include "../../../model/model.php";  
$emp_id=$_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$type = $_POST['type'];
$count_l = 0;

if($role=='Admin'){
	if($type == 'task'){
		$sq_task = mysql_fetch_assoc(mysql_query("select * from generic_count_master"));
		echo $sq_task['a_task_count'];
		$sq_log = mysql_query("update generic_count_master set a_task_count='0' where id='1'");
	}
	else if($type == 'leave'){
		$sq_task = mysql_fetch_assoc(mysql_query("select * from generic_count_master"));
		echo $sq_task['a_leave_count'];
		$sq_log = mysql_query("update generic_count_master set a_leave_count='0' where id='1'");
	}
	else{
		echo '0';
		$sq_log = mysql_query("update generic_count_master set a_enquiry_count='0' where id='1'");
	}
}
else if($role=='Branch Admin'){
	if($type == 'task'){
		$sq_leavee = mysql_query("select * from tasks_master where task_status='Completed' and branch_admin_id='$branch_admin_id'");
		while($row_leavee = mysql_fetch_assoc($sq_leavee)){
			$count_l++;
			$sq_log = mysql_query("update emp_master set task_count='0' and temp_task_count='$count_l' where emp_id='$emp_id'");
		}
		echo '0';
	}
	else if($type == 'leave'){
		$sq_leavee = mysql_query("select * from leave_request where status='' and emp_id in(select emp_id from emp_master where branch_id='$branch_admin_id')");
		while($row_leavee = mysql_fetch_assoc($sq_leavee)){
			$count_l++;
			$sq_log = mysql_query("update emp_master set leave_count='0' and temp_leave_count='$count_l' where emp_id='$emp_id'");
		}
		echo '0';
	}
	else{
		echo '0';
		$sq_log1 = mysql_query("update emp_master set enquiry_count='0' where emp_id='$emp_id'");
	}
}
else{
	if($type == 'task'){
		if($role_id==2 || $role_id==3 || $role_id==4 || $role_id==7){
			$sq_leavee = mysql_query("select * from tasks_master where task_status='Created' and emp_id='$emp_id'");
		}
		else{
				$sq_leavee = mysql_query("select * from tasks_master where (task_status='Created' and emp_id='$emp_id') or task_status='Completed'");
		}
		while($row_leavee = mysql_fetch_assoc($sq_leavee)){
				$count_l++;
				$sq_log = mysql_query("update emp_master set task_count='0' and temp_task_count='$count_l' where emp_id='$emp_id'");
		}
		echo '0';
	}
	else if($type == 'leave'){
		$sq_leavee = mysql_query("select * from leave_request where status='Approved' and emp_id='$emp_id'");
		while($row_leavee = mysql_fetch_assoc($sq_leavee)){
				$count_l++;
				$sq_log = mysql_query("update emp_master set leave_count='0' and temp_leave_count='$count_l' where emp_id='$emp_id'");
		}
		echo '0';
	}
	else{
		echo '0';
		$sq_log1 = mysql_query("update emp_master set enquiry_count='0' where emp_id='$emp_id'");
	}
}
?>