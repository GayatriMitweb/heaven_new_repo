<?php 
include_once('../../../model/model.php');
include_once('../../../model/visa_password_ticket/passport/passport_master.php');

$passport_whatsapp = new passport_master;
$passport_whatsapp->whatsapp_send();
?>