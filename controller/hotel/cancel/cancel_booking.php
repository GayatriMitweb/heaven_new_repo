<?php 
include_once('../../../model/model.php');
include_once('../../../model/hotel/hotel_booking_cancel.php');

$hotel_booking_cancel = new hotel_booking_cancel;
$hotel_booking_cancel->hotel_cancel_save();
?>