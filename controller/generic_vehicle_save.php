<?php
include_once('../model/model.php');
include_once('../model/generic_vehicle_save.php');

$vehicle = new vehicle_master;
$vehicle->vehicle_save();
?>