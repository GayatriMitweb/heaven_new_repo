<?php
include "../../../../../model/model.php";

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$emp_id = $_POST['emp_id'];
$array_s = array();
$temp_arr = array();
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from daily_activity where 1 ";
if($from_date!="" && $to_date !=''){
  $from_date = date('Y-m-d',strtotime($from_date));
  $to_date = date('Y-m-d',strtotime($to_date));
  $query .=" and activity_date between '$from_date' and '$to_date'  ";
}
if($emp_id!=""){
  $query .=" and emp_id ='$emp_id'";
}
if($branch_status=='yes' && $role!='Admin'){
   
    $query .=" and emp_id in(select emp_id from emp_master where branch_id='$branch_admin_id')";
}   
 

	 	$count = 0;
	 	$sq = mysql_query($query);
        while($row=mysql_fetch_assoc($sq))
        {
       $count++;  
               
       $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row[emp_id]'"));  
       
      
       $temp_arr = array( "data" => array(
        (int)($count),
        date('d-m-Y',strtotime($row['activity_date'])),
        $sq_emp['first_name'].' '.$sq_emp['last_name'],
        $row['activity_type'],
        $row['time_taken'],
        $row['description']
        
        ), "bg" =>$bg);
    array_push($array_s,$temp_arr);

}
echo json_encode($array_s);
         