<?php 
include_once('../../../model/model.php');
include_once('../../../model/promotional_sms/sms_group.php');

$sms_group = new sms_group;
$sms_group->sms_group_save();
?>