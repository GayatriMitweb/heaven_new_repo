<?php 
include_once('../../../../../model/model.php');

$group_id = $_POST['group_id'];
$train_info_arr = array();

$sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$group_id'"));

$query = "select arrival_date,departure_date,from_location,to_location,class from group_train_entries where tour_id='$sq_group[tour_id]'";
$sq_train = mysql_query($query);

	while($row_train = mysql_fetch_assoc($sq_train)){
		$arrival_date = date('d-m-Y H:i:s', strtotime($row_train['arrival_date']));
		$departure_date = date('d-m-Y H:i:s', strtotime($row_train['departure_date']));
		$arr = array(
			'from_location' => $row_train['from_location'],
			'to_location' => $row_train['to_location'],
			'class' => $row_train['class'],			
			'arrival_date' => $arrival_date,
			'departure_date' => $departure_date
		);
	 array_push($train_info_arr, $arr);
	}
echo json_encode($train_info_arr);
?>