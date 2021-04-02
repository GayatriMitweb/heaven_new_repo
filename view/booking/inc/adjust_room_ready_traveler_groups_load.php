<?php include "../../../model/model.php"; ?>
<?php

$tour_id = $_GET['tour_id'];
$tour_group_id = $_GET['tour_group_id'];
$adjust_room_with_other = $_GET['adjust_room_with_other'];
?>
<option value="select">Select</option>
<?php
$sq = mysql_query("select id from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id='$tour_group_id' and s_adjusted_with='' and s_adjust_room_with_other='yes' ");
while($row = mysql_fetch_assoc($sq))
{
	?>
	<option value="<?php echo $row['id'] ?>"><?php echo "File No-".$row['id'] ?></option>
	<?php
}

?>