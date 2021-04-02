<?php
include_once('../../model/model.php');
include_once('../../model/branches_and_locations/location_master.php');

$location_master = new location_master;
$location_master->location_master_update();
?>