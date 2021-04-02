<?php
include "../../../model/model.php";
include "../../../model/group_tour/booking/booking_update.php";
include "../../../model/group_tour/booking/booking_update_transaction.php";
include_once('../../../model/app_settings/transaction_master.php');

$booking_update = new booking_update();
$booking_update->complete_booking_information_update();
?>