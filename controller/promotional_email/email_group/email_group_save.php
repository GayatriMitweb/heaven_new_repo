<?php 
include_once('../../../model/model.php');
include_once('../../../model/promotional_email/email_group.php');

$email_group = new email_group;
$email_group->email_group_save();
?>