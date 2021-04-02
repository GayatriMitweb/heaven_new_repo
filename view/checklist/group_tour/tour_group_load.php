<?php
include "../../../model/model.php";

$tour_id = $_POST['tour_id'];

echo '<option value="">Select Tour Group</option>';

$sq_tour_group = mysql_query("select * from tour_groups where tour_id='$tour_id'");
while($row_group = mysql_fetch_assoc($sq_tour_group)){
	echo '<option value="'.$row_group['group_id'].'">'.date('d-m-Y', strtotime($row_group['from_date'])).' to '.date('d-m-Y', strtotime($row_group['to_date'])).'</option>';
}
?>