<?php 

include "../../model/model.php";

include "../../model/hotel/hotel_images.php";
$hotel_images= new hotel_images;
$hotel_images->save();
?>