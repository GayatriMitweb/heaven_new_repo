<?php 
class tasks_master{

public function tasks_master_save()
{
	$task_name  = $_POST['task_name'];
    $due_date  = $_POST['due_date'];
    $assign_to  = $_POST['assign_to'];
    $remind  = $_POST['remind'];
    $remind_by  = $_POST['remind_by'];
    $task_type = $_POST['task_type'];
    $task_type_field_id = $_POST['task_type_field_id'];
    $task_status = 'Created';

    $created_at = date('Y-m-d');
    $due_date = date('Y-m-d H:i', strtotime($due_date));

    if($remind=="On Due Time"){
        $remind_due_date = $due_date;
    }
    if($remind=="Before 15 Mins"){
        $time = strtotime($due_date);
        $time = $time - (15 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="Before 30 Mins"){
        $time = strtotime($due_date);
        $time = $time - (30 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="Before 1 Hour"){
        $time = strtotime($due_date);
        $time = $time - (60 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="Before 1 Day"){
        $time = strtotime($due_date);
        $time = $time - (24 * 60 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="None"){
        $remind_due_date = "";
    }
            
            

    $sq_max = mysql_fetch_assoc(mysql_query("select max(task_id) as max from tasks_master"));
    $task_id = $sq_max['max'] + 1;


    $sq_task = mysql_query("insert into tasks_master ( task_id, emp_id, task_name, due_date, remind, remind_due_date, remind_by, task_type, task_type_field_id, task_status, created_at ) values ( '$task_id', '$assign_to', '$task_name', '$due_date', '$remind', '$remind_due_date', '$remind_by', '$task_type', '$task_type_field_id', '$task_status', '$created_at' )");

    if($sq_task){
    	echo "Task saved succcessfully!";
    	exit;
    }
    else{
    	echo "error--Tasks not saved!";
    	exit;
    }
}

public function tasks_master_update()
{
	$task_id = $_POST['task_id'];
	$task_name  = $_POST['task_name'];
    $due_date  = $_POST['due_date'];
    $assign_to  = $_POST['assign_to'];
    $remind  = $_POST['remind'];
    $remind_by  = $_POST['remind_by'];
    $task_type = $_POST['task_type'];
    $task_type_field_id = $_POST['task_type_field_id'];

    $due_date = date('Y-m-d H:i', strtotime($due_date));

    if($remind=="On Due Time"){
        $remind_due_date = $due_date;
    }
    if($remind=="Before 15 Mins"){
        $time = strtotime($due_date);
        $time = $time - (15 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="Before 30 Mins"){
        $time = strtotime($due_date);
        $time = $time - (30 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="Before 1 Hour"){
        $time = strtotime($due_date);
        $time = $time - (60 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="Before 1 Day"){
        $time = strtotime($due_date);
        $time = $time - (24 * 60 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="None"){
        $remind_due_date = "";
    }

    $sq_task = mysql_query("update tasks_master set emp_id='$assign_to', task_name='$task_name', due_date='$due_date', remind='$remind', remind_due_date='$remind_due_date', remind_by='$remind_by', task_type='$task_type', task_type_field_id='$task_type_field_id' where task_id='$task_id'");

    if($sq_task){
    	echo "Task updated succcessfully!";
    	exit;
    }
    else{
    	echo "error--Tasks not updated!";
    	exit;
    }

}

public function tasks_status_update()
{
	$task_id = $_POST['task_id'];
	$extra_note = $_POST['extra_note'];
	$task_status = $_POST['task_status'];

    $cur_date = date('Y-m-d H:i:s');

	$sq_task = mysql_query("update tasks_master set extra_note='$extra_note', task_status='$task_status', status_date='$cur_date' where task_id='$task_id'");

	if($sq_task){
    	echo "Task status updated succcessfully!";
    	exit;
    }
    else{
    	echo "error--Tasks status not updated!";
    	exit;
    }
}

public function tasks_master_clone()
{
	$reference_task_id  = $_POST['reference_task_id'];
    $extra_note = $_POST['extra_note'];

	$task_name  = $_POST['task_name'];
    $due_date  = $_POST['due_date'];
    $assign_to  = $_POST['assign_to'];
    $remind  = $_POST['remind'];
    $remind_by  = $_POST['remind_by'];
    $task_type = $_POST['task_type'];
    $task_type_field_id = $_POST['task_type_field_id'];
    $task_status = 'Created';

    $created_at = date('Y-m-d');
    $due_date = date('Y-m-d H:i', strtotime($due_date));

    if($remind=="On Due Time"){
        $remind_due_date = $due_date;
    }
    if($remind=="Before 15 Mins"){
        $time = strtotime($due_date);
        $time = $time - (15 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="Before 30 Mins"){
        $time = strtotime($due_date);
        $time = $time - (30 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="Before 1 Hour"){
        $time = strtotime($due_date);
        $time = $time - (60 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="Before 1 Day"){
        $time = strtotime($due_date);
        $time = $time - (24 * 60 * 60);
        $remind_due_date = date('Y-m-d H:i', $time);
    }
    if($remind=="None"){
        $remind_due_date = "";
    }

	$sq_task_update = mysql_query("update tasks_master set extra_note='$extra_note', task_status='Closed' where task_id='$reference_task_id'");
	
    $sq_max = mysql_fetch_assoc(mysql_query("select max(task_id) as max from tasks_master"));
    $task_id = $sq_max['max'] + 1;


    $sq_task = mysql_query("insert into tasks_master ( task_id, emp_id, task_name, due_date, remind, remind_due_date, remind_by, task_type, task_type_field_id, task_status, reference_task_id, created_at ) values ( '$task_id', '$assign_to', '$task_name', '$due_date', '$remind', '$remind_due_date', '$remind_by', '$task_type', '$task_type_field_id', '$task_status', '$reference_task_id', '$created_at' )");

    if($sq_task){
    	echo "Task saved succcessfully!";
    	exit;
    }
    else{
    	echo "error--Tasks not saved!";
    	exit;
    }
}
 
function task_status_disable($task_id)
{
  $sq = mysql_query("update tasks_master set task_status='Disabled' where task_id='$task_id'");
  if(!$sq){
    echo "Sorry, Status not updated.";
    exit;
  }
  else{
    echo "Task is updated successfully.";
    exit;
  }
}


}
?>