<?php 
include_once('../../../model/model.php');
include_once('../../../model/bus_booking/cancel_booking.php');

$cancel_booking = new cancel_booking;
$cancel_booking->cancel_booking_save();
?>