<?php 
include "../../model/model.php"; 
include "../../model/attractions_offers_enquiry/enquiry_csv_save_v.php"; 

$enquiry_master = new enquiry_master();
$enquiry_master->enquiry_master_save();
?>