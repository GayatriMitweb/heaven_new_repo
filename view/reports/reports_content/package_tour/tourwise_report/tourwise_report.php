<?php include "../../../../../model/model.php";

$booking_id=$_POST['booking_id'];

$array_s = array();
$temp_arr = array();

$query = "select * from package_tour_booking_master where 1 ";

if($booking_id!="")
{
	$query .=" and booking_id = '$booking_id'";
}


$count = 0;
$bg;
$sq1 =mysql_query($query);
while($row1 = mysql_fetch_assoc($sq1))
{
	

	$sq2 = mysql_query("select * from package_travelers_details where booking_id = '$row1[booking_id]'");
	while($row2 = mysql_fetch_assoc($sq2))
	{
	 $count++;
	($row2['status']=='Cancel')?$bg='danger':$bg='';

	$temp_arr = array( "data" => array(
		(int)($count),
		$row1['tour_name'] ,
		get_date_user($row1['tour_from_date']),
		get_date_user($row1['tour_to_date']),
		$row2['first_name']." ".$row2['last_name'],
		$row2['adolescence'],
		$row1['mobile_no']
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
}
echo json_encode($array_s);
?>