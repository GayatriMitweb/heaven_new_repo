<?php 
include "../../../model/model.php"; 
include "../../../model/package_tour/quotation/quotation_email_send.php"; 

$quotation_whatsapp = new quotation_email_send;
$quotation_whatsapp->quotation_whatsapp();
?>