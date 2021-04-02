<?php include "../../model/model.php";  
$login_id=$_POST['login_id'];

$logout_date = date('Y-m-d');
$logout_time = date('H:i:s');
$user_ip =$_SERVER['REMOTE_ADDR'];

$sq_log = mysql_query("update user_logs set logout_date='$logout_date', logout_time='$logout_time' where login_id='$login_id' and user_ip='$user_ip'");
if($sq_log){
	echo "valid";
	exit;
}
else{
	echo "Invalid Username/ Password!";
}
?>