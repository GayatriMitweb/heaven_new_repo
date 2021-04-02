<?php 
include "../../../model/model.php"; 
include "../../../model/group_tour/tours_master.php"; 

$tour_id = $_POST['tour_id'];
$adnary_url = $_POST['adnary_url'];

$tours_master = new tours_master();
$tours_master->upload_tour_adnary_save($tour_id, $adnary_url);
?>