<?php include "../../../../../model/model.php"; 
$count=1;
$traveler_id = $_POST['traveler_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$array_s = array();
$temp_arr = array();


$query = "select * from customer_master where 1";
if($traveler_id!=""){
	$query .=" and customer_id ='$traveler_id' and active_flag='Active'";
}
if($branch_status=='yes' && $role=='Branch Admin'){
	$query .=" and branch_admin_id = '$branch_admin_id'";
}
$group_count = 0;
$package_count = 0;
// echo $query;
$sq = mysql_query($query);
while($row = mysql_fetch_assoc($sq))
{
	
	$traveler_id_arr = array();
	$group_collection = array();
	$package_collection = array();
	$group_count = (int)mysql_num_rows(mysql_query("select * from tourwise_traveler_details where customer_id = ".$row['customer_id']));
	$package_count = (int)mysql_num_rows(mysql_query("select * from package_tour_booking_master where customer_id = ".$row['customer_id']));
	$group_tours = mysql_query('select * from tourwise_traveler_details where customer_id = "'.$row[customer_id].'"');
	while($row1 = mysql_fetch_assoc($group_tours)){
		array_push($group_collection,$row1['traveler_group_id']);
	}
	$group_collection = implode(',',$group_collection);
	$traveler_id_arr['group'] = $group_collection;
	$package_tours = mysql_query('select * from package_tour_booking_master where customer_id = "'.$row[customer_id].'"');
	while($row2 = mysql_fetch_assoc($package_tours)){
		array_push($package_collection,$row2['booking_id']);
	}
	$package_collection = implode(',',$package_collection);
	$traveler_id_arr['package'] = $package_collection;
	// echo "<pre>";
	// print_r($traveler_id_arr);
	
	// =implode(",",$traveler_id_arr);	
	$temp_arr = array( "data" => array(
		(int)($count++),
		$row['first_name']." ".$row['last_name'] ,
		date("d-m-Y", strtotime($row['birth_date'])),
		$row['gender'],
		$group_count,
		$package_count,
		'<button id="btn_group_id'.$count.'" value=\''. json_encode($traveler_id_arr).'\' class="btn btn-info btn-sm" onclick="travelers_details(this.id)"><i class="fa fa-eye"></i></button>'
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
}
echo json_encode($array_s);
?>