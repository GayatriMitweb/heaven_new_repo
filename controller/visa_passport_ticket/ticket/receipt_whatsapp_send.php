<?php 
include_once('../../../model/model.php');
include_once('../../../model/visa_password_ticket/ticket/ticket_payment_master.php');

$payment_whatsapp = new ticket_payment_master;
$payment_whatsapp->whatsapp_send();
?> 