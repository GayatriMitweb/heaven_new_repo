<?php 
include_once('../../../../model/model.php');
include_once('../../../../model/visa_password_ticket/visa/visa_cancel.php');

$visa_cancel = new visa_cancel;
$visa_cancel->visa_cancel_save();
?>