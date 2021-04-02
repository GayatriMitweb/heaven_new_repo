<?php 
include_once('../../../../../model/model.php');

$group_id = $_POST['group_id'];
$plane_info_arr = array();

$sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$group_id'"));

$query = "select * from group_tour_plane_entries where tour_id='$sq_group[tour_id]'";
$sq_train = mysql_query($query);

	while($row_train = mysql_fetch_assoc($sq_train)){		
		$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_train[from_city]'"));
		$sq_city1 = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_train[to_city]'"));

		$arrival_date = get_datetime_user($row_train['arraval_time']);
		$departure_date = get_datetime_user($row_train['dapart_time']);

		$arr = array(
			'from_location' => $row_train['from_location'],
			'to_location' => $row_train['to_location'],
			'airline_name' => $row_train['airline_name'],
			'class' => $row_train['class'],
			'arraval_time' => $arrival_date,
			'dapart_time' => $departure_date,
			'from_city' => $row_train['from_city'],
			'to_city' => $row_train['to_city'],
			'city_name' => $sq_city['city_name'],
			'city_name1' => $sq_city1['city_name']
		);
	 array_push($plane_info_arr, $arr);
	}


echo json_encode($plane_info_arr);
?>