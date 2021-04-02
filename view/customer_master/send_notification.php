<?php 
include "../../model/model.php";
global $app_email_id;
$emp_id = $_POST['emp_id'];
$current_date= date('Y-m-d');
$sq_count=mysql_num_rows(mysql_query("select * from admin_notification where emp_id=$emp_id and date='$current_date'"));
if($sq_count==0){
    $sq_max=mysql_fetch_assoc(mysql_query("select max(id) as max from admin_notification"));
    $max_id=$sq_max['max'];
    $id=$max_id+1;
    $sql=mysql_query("insert into admin_notification(id , emp_id , click_count , date) values($id , $emp_id , 1 , '$current_date')");
}

$sql_count=mysql_fetch_assoc(mysql_query("select click_count from admin_notification where emp_id=$emp_id and date='$current_date'"));
if($sql_count['click_count'] > 24){
    $sq_emp=mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id=$emp_id"));
    $emp_name=$sq_emp['first_name'].' '.$sq_emp['last_name']; 
    
    $sq_role=mysql_fetch_assoc(mysql_query("select * from role_master where role_id=$sq_emp[role_id]"));
    $role=$sq_role['role_name'];
    
    $content = '
    Dear Admin,
    
    The maximum limit is crossed to view customer contact details with following details.
    <br><br>
    User Name :'.$emp_name.'<br>
    User Type : '.$role.'<br>
    Date : '.date("d-m-Y") .'
    ';    
    $subject = "The maximum limit is crossed to view customer contact details";    
    global $model;    
    $model->app_email_master($app_email_id, $content,$subject,'1');
}
else{
    $sq_click_count=mysql_fetch_assoc(mysql_query("select click_count from admin_notification where emp_id='$emp_id' and date='$current_date'"));
    $click_cnt=$sq_click_count['click_count'];
    $click_count=$click_cnt+1;
    $sql=mysql_query("update admin_notification set click_count='$click_count' where emp_id='$emp_id' and date='$current_date'");
}

?>