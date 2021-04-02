<?php 
include "../../../../../../model/model.php"; 
$month = $_POST['month'];
$branch_status = $_POST['branch_status'];
$role = $_POST['role'];
$branch_admin_id = $_POST['branch_admin_id'];
$array_s = array();
$temp_arr = array();

$query = "select * from employee_salary_master where 1 ";
if($month != ''){
	$query .= " and month='$month'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
		$query .= " and emp_id in(select emp_id from emp_master where branch_id='$branch_admin_id')";
	}
	elseif($role!='Admin' && $role!='Branch Admin'){
      $query .= " and emp_id='$emp_id'";
    }
}
$sq_query = mysql_query($query);

	$count = 1;
	while($row_query = mysql_fetch_assoc($sq_query))
	{
		$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_query[emp_id]'")); 
		
		$temp_arr = array( "data" => array(
		(int)($count++),
		$row_query['emp_id'],
		$sq_emp['first_name'].' '.$sq_emp['last_name'] ,
		$row_query['gross_salary'],
		$row_query['pt'] 

		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
echo json_encode($array_s);			 
?>
	