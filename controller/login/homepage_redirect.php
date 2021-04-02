<?php include "../model/model.php";
global $app_version;

$username = $_GET['username'];
$password = $_GET['password'];

$_SESSION['username'] = $username;
$_SESSION['password'] = $password;
$_SESSION['app_version'] = $app_version;

$sq = mysql_query("select role_id, emp_id from roles where user_name='$username' and password='$password' ");

if($row= mysql_fetch_assoc($sq)){
	$_SESSION['emp_id'] = $row['emp_id'];
	header("location:dashboard/dashboard_main.php");	
}

?>