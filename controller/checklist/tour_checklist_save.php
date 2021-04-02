<?php 
include_once('../../model/model.php');
include_once('../../model/checklist/checklist.php');

$checklist = new checklist;
$checklist->checklist_save();
?>