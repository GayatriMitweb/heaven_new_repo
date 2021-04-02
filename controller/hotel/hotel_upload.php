<?php 
include_once('../../../model/model.php');
include_once('../../../model/hotel/hotel_upload.php');

$hotel_upload_master = new hotel_upload_master;
$hotel_upload_master->hotel_upload_save();
?>