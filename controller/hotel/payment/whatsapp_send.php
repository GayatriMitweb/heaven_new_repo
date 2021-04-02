<?php 
include_once('../../../model/model.php');
include_once('../../../model/hotel/payment_master.php');


$payment_whatsapp = new payment_master;
$payment_whatsapp->whatsapp_send();
?>