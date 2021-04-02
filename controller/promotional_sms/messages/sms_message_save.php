<?php 
include_once('../../../model/model.php');
include_once('../../../model/promotional_sms/sms_message.php');

$sms_message = new sms_message;
$sms_message->sms_message_save();
?>