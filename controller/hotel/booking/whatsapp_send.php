<?php 
include "../../../model/model.php";
include "../../../model/hotel/booking_master.php";


$booking_master_whatsapp = new booking_master();
$booking_master_whatsapp->whatsapp_send();
?>