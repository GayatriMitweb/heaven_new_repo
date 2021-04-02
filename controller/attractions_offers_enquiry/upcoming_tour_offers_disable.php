<?php
include "../../model/model.php"; 
include "../../model/attractions_offers_enquiry/upcoming_tour_offers_master.php"; 

$offer_id = $_POST["offer_id"];

$upcoming_tour_offers_master = new upcoming_tour_offers_master();
$upcoming_tour_offers_master->upcoming_tour_offers_disable($offer_id);
?>