<?php
include "../../model/model.php"; 
include "../../model/attractions_offers_enquiry/fourth_coming_attraction_master.php"; 

$id = $_POST['id'];
$title = $_POST['title'];
$valid_date = $_POST['valid_date'];
$description = $_POST['description'];

$fourth_coming_attraction_master = new fourth_coming_attraction_master();
$fourth_coming_attraction_master->fourth_coming_attraction_master_update($id, $title, $valid_date, $description);

?>