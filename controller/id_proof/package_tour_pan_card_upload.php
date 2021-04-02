<?php 
include_once('../../model/model.php');
include_once('../../model/id_proof/package_tour_id_proof.php');

$package_tour_id_proof = new package_tour_id_proof();
$package_tour_id_proof->package_tour_pan_card_upload();
?>