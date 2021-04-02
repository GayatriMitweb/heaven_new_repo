<?php 
include "../../../model/model.php"; 
include "../../../model/group_tour/bus/bus_seat_arrangement_master.php"; 

$bus_id = $_POST['bus_id'];
$tour_id = $_POST['tour_id'];
$tour_group_id = $_POST['tour_group_id'];
$traveler_id = $_POST['traveler_id'];
$seat_no = $_POST['seat_no'];

$bus_seat_arrangement_master = new bus_seat_arrangement_master();
$bus_seat_arrangement_master->bus_seat_arrangement_master_save($bus_id, $tour_id, $tour_group_id, $traveler_id, $seat_no);
?>