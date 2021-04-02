<?php 
include_once('../../../model/model.php');
include_once('../../../model/checklist/package_tour_checklist.php');

$package_tour_checklist = new package_tour_checklist;
$package_tour_checklist->package_tour_checklist_save();
?>