<?php include '../../../model/model.php';
$customer = $_POST['customer'];
$emp_id = $_SESSION['emp_id'];

$sq = mysql_fetch_assoc(mysql_query("select state_id from customer_master where customer_id ='$customer'"));
if($emp_id!=0 && $emp_id!=''){
    $sq_emp = mysql_fetch_assoc(mysql_query("select branch_id from emp_master where emp_id ='$emp_id'"));
    $sq_state = mysql_fetch_assoc(mysql_query("select * from branches where branch_id ='$sq_emp[branch_id]'"));
    $state_id = $sq_state['state'];
}else{
    $sq_state = mysql_fetch_assoc(mysql_query("select * from app_settings where setting_id ='1'"));
    $state_id = $sq_state['state_id'];
}
echo $sq['state_id'].'-'.$state_id;
?>