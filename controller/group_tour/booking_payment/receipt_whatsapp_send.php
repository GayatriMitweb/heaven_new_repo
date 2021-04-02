<?php 
include "../../../model/model.php";
include "../../../model/group_tour/booking_payment.php";

$booking_whatsapp=new booking_payment();
$booking_whatsapp->whatsapp_send();
?>