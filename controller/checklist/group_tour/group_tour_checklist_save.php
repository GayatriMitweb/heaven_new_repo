<?php 
include_once('../../../model/model.php');
include_once('../../../model/checklist/group_tour_checklist.php');

$group_tour_checklist = new group_tour_checklist;
$group_tour_checklist->group_tour_checklist_save();
?>