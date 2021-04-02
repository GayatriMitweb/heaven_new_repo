<?php 
include_once('../../../model/model.php');
include_once('../../../model/visa_password_ticket/ticket/ticket_master/ticket_save.php');


$ticket_whatsapp = new ticket_save;
$ticket_whatsapp->whatsapp_send();
?>