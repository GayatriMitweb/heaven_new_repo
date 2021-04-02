<?php 
include "../../../model/model.php";

$tour_group_id = $_POST['tour_group_id'];

$sq_tour_group = mysql_fetch_assoc( mysql_query("select from_date from tour_groups where group_id='$tour_group_id'") );
$from_date = $sq_tour_group['from_date'];
$from_date = date('d-m-Y H:i:s', strtotime($from_date));
echo $from_date;
?>