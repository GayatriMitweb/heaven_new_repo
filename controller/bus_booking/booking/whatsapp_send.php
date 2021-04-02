<?php 
include_once('../../../model/model.php');
include_once('../../../model/bus_booking/booking_master.php');


$booking_whatsapp = new booking_master;
$booking_whatsapp->whatsapp_send();
?>