<?php 
include_once('../../../model/model.php');

$group_id = $_POST['group_id'];
$cruise_info_arr = array();

$sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$group_id'"));

$query = "select * from group_cruise_entries where tour_id='$sq_group[tour_id]'";
$sq_cruise = mysql_query($query);

	while($row_cruise = mysql_fetch_assoc($sq_cruise)){

		$departure_date = date('d-m-Y H:i:s', strtotime($row_cruise['dept_datetime']));
		$arrival_datetime = date('d-m-Y H:i:s', strtotime($row_cruise['arrival_datetime']));

		$arr = array(
			'dept_datetime' => $departure_date,
			'arrival_datetime' => $arrival_datetime,
			'route' => $row_cruise['route'],
			'cabin' => $row_cruise['cabin']
		);
	 array_push($cruise_info_arr, $arr);
	}


echo json_encode($cruise_info_arr);
?>