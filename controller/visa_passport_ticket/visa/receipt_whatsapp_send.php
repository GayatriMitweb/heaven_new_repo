<?php 
include_once('../../../model/model.php');
include_once('../../../model/visa_password_ticket/visa/visa_payment_master.php');


$visa_whatsapp = new visa_payment_master;
$visa_whatsapp->whatsapp_send();
?> 