<?php include "../model/model.php"; ?>
<?php 

$tourwise_traveler_id = $_POST['tourwise_traveler_id'];
$travelers_arr = $_POST['travelers_arr'];
$ticket_url = $_POST['ticket_url'];


$model->tickets_for_booking_upload($tourwise_traveler_id, $travelers_arr, $ticket_url);
?>