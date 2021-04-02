<?php include "../../../model/model.php"; ?>
<?php include_once "../../../classes/tour_booked_seats.php"; ?>
<?php
	$tour_info_arr =array();
	$tour_id = $_GET['tour_id'];
	$tour_group_id = $_GET['tour_group_id'];
	$sq = mysql_query("select capacity from tour_groups where tour_id='$tour_id' and group_id='$tour_group_id' ");
	if($row = mysql_fetch_assoc($sq))
	{
		$total_seats = $row['capacity'];
	}	
	
	$seats_booked = $bk_seats->booked_seats($tour_id, $tour_group_id);
	$available_seats = $total_seats - $seats_booked;
	
	$arr = array(
		'available_seats' => $available_seats,
		'total_seats' => $total_seats,
		'seats_booked' => $seats_booked
		);
	
	array_push($tour_info_arr, $arr);

echo json_encode($tour_info_arr);
?>
