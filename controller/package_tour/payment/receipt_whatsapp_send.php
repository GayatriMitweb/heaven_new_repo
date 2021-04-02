<?php 
include "../../../model/model.php"; 
include "../../../model/package_tour/payment.php";


$payment_whatsapp = new payment();
$payment_whatsapp->whatsapp_send();
?>
