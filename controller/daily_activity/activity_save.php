<?php 
include "../../model/model.php"; 
include "../../model/daily_activity/daily_activity.php"; 

$daily_activity = new daily_activity();
$daily_activity->activity_save();
?>