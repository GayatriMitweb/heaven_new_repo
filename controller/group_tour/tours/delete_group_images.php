<?php 
include "../../../model/model.php"; 
include "../../../model/group_tour/tours_master.php"; 

$tours_master_image = new tours_master;
$tours_master_image->images_delete_update();
?>
