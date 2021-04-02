<?php 
include_once('../../../model/model.php');
include_once('../../../model/other_masters/itinerary_master.php');

$itinerary_master = new itinerary_master;
$itinerary_master->itinerary_save();
?>