<?php 
include_once('../../model/model.php');
include_once('../../model/tour_estimate/tour_budget_entities.php');

$tour_budget_entities = new tour_budget_entities();
$tour_budget_entities->tour_budget_entities_save();
?>