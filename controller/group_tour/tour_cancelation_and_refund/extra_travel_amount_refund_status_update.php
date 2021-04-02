<?php 
include "../../../model/model.php"; 
include "../../../model/group_tour/tour_cancelation_and_refund.php"; 

$tour_cancelation_and_refund = new tour_cancelation_and_refund();
$tour_cancelation_and_refund->extra_travel_amount_refund_status_update();
?>