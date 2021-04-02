<?php
include "../../../../../model/model.php";

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$today_date1 = date('Y-m-d 00:00');
$today_date2 = date('Y-m-d 23:00');
$array_s = array();
$temp_arr = array();
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from enquiry_master_entries where 1 ";
if($from_date!="" && $to_date !=''){
  $from_date = date('Y-m-d H:i',strtotime($from_date));
  $to_date = date('Y-m-d H:i',strtotime($to_date));
  $query .=" and followup_date between '$from_date' and '$to_date'  ";
}else{
  $query .=" and followup_date between '$today_date1' and '$today_date2'  ";
}
if($branch_status=='yes' && $role!='Admin'){
    $query .=" and enquiry_id in(select enquiry_id from enquiry_master where branch_admin_id='$branch_admin_id')";
}

$count = 0;
$sq = mysql_query($query);
while($row=mysql_fetch_assoc($sq))
{
  if($row['followup_type']!=''){
    $count++;
    $sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$row[enquiry_id]'"));
    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_enq[assigned_emp_id]'"));

    $temp_arr = array( "data" => array(
      (int)($count),
      $sq_enq['name'],
      $sq_emp['first_name'].' '.$sq_emp['last_name'],
      get_datetime_user($row['followup_date']),
      $row['followup_type'],
      $row['followup_reply']
      
      ), "bg" =>$bg);
  array_push($array_s,$temp_arr);
      
  }
} 
echo json_encode($array_s);
?>