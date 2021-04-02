<?php 
include "../../model/model.php"; 
include "../../model/attractions_offers_enquiry/enquiry_master.php"; 

$enquiry_master = new enquiry_master();
$enquiry_master->followup_reply_save();
?>