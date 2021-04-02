<?php 
include_once('../../../model/model.php');
include_once('../../../model/visa_password_ticket/passport/passport_payment_master.php');


$passport_payment_whatsapp = new passport_payment_master;
$passport_payment_whatsapp->whatsapp_send();
?>