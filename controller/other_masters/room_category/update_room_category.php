<?php 
include_once('../../../model/model.php');
include_once('../../../model/other_masters/room_category_master.php');

$room_category_master = new room_category_master;
$room_category_master->category_update();
?>