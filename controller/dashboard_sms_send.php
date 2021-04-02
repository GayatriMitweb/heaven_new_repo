<?php 
include "../model/model.php"; 
include "../model/dashboard_sms_send.php"; 

$sms = new sms(); 
$sms->send_sms();
?>