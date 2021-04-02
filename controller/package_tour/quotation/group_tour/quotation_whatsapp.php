<?php 
include "../../../../model/model.php"; 
include "../../../../model/package_tour/quotation/group_tour/quotation_email_send.php"; 

$quotation_whatsapp_send = new quotation_email_send;
$quotation_whatsapp_send->quotation_whatsapp();
?>