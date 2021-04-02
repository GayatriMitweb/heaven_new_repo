<?php 
include "../../../model/model.php"; 
include "../../../model/package_tour/cancel_and_refund/cancel_booking.php"; 

$traveler_id_arr = $_POST['traveler_id_arr'];
$booking_id = $_POST['booking_id'];

$cancel_booking = new cancel_booking;
$cancel_booking->cancel_booking_save($traveler_id_arr, $booking_id);
?>