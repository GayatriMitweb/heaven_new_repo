<?php
include "../../model/model.php"; 
include "../../model/attractions_offers_enquiry/fourth_coming_attraction_master.php"; 

$id = $_POST['id'];

$fourth_coming_attraction_master = new fourth_coming_attraction_master();
$fourth_coming_attraction_master->fourth_coming_attraction_disable($id);
?>