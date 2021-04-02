<?php 

include "../../../model/model.php";

include "../../../model/group_tour/traveler_cancelation_and_refund.php";



$tourwise_id = $_POST['tourwise_id'];

$traveler_id_arr = $_POST['traveler_id_arr'];

$first_names_arr = $_POST['first_names_arr'];


$traveler_cancelation_and_refund = new traveler_cancelation_and_refund();

$traveler_cancelation_and_refund->cancel_traveler_booking($tourwise_id, $traveler_id_arr, $first_names_arr);

?>