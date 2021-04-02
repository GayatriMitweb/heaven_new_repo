<?php 
include "../../../model/model.php"; 
include "../../../model/group_tour/tour_cancelation_and_refund.php"; 

$tour_id = $_POST['tour_id'];
$tour_group_id = $_POST['tour_group_id'];

$tour_cancelation_and_refund = new tour_cancelation_and_refund();
$tour_cancelation_and_refund->cancel_tour_group($tour_id, $tour_group_id);
?>
