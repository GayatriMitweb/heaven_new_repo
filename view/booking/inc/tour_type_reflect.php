<?php 
include "../../../model/model.php"; 

$tour_id = $_POST['tour_id'];

$sq_tour = mysql_fetch_assoc(mysql_query("select tour_type from tour_master where tour_id='$tour_id'"));
echo $sq_tour['tour_type'];
?>