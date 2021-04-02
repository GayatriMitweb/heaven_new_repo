<?php
include "../../model/model.php"; 
include "../../model/attractions_offers_enquiry/upcoming_tour_offers_master.php"; 

$offer_id = $_POST["offer_id"];
$title = $_POST["title"];
$description = $_POST["description"];
$valid_date = $_POST["valid_date"];

$upcoming_tour_offers_master = new upcoming_tour_offers_master();
$upcoming_tour_offers_master->upcoming_tour_offers_master_update($offer_id, $title, $description, $valid_date);
?>