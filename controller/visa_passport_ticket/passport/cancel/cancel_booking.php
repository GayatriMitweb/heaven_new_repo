<?php 
include_once('../../../../model/model.php');
include_once('../../../../model/visa_password_ticket/passport/passport_cancel.php');

$passport_cancel = new passport_cancel;
$passport_cancel->passport_cancel_save();
?>