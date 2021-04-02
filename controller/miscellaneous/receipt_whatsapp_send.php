<?php 
include_once('../../model/model.php');
include_once('../../model/miscellaneous/miscellaneous_payment_master.php');


$visa_payment_whatsapp = new miscellaneous_payment_master;
$visa_payment_whatsapp->whatsapp_send();
?> 