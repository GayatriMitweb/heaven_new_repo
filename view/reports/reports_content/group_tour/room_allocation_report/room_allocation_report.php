<?php include "../../../../../model/model.php"; 

$array_s = array();
$temp_arr = array();
$tour_id= $_POST['tour_id'];
$group_id= $_POST['group_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$count=0;

$query = "select * from tourwise_traveler_details where 1";

if($tour_id!="")
{
	$query .= " and tour_id = '$tour_id'";
}
if($group_id!="")
{
	$query .= " and tour_group_id = '$group_id'";
}
if($branch_id!=""){

	$query .= " and branch_admin_id = '$branch_id'";
}
if($branch_status=='yes' && $role=='Branch Admin'){
    $query .= " and  branch_admin_id = '$branch_admin_id'";
}
 
$sq_tourwise_det = mysql_query($query);
while($row_tourwise_det = mysql_fetch_assoc($sq_tourwise_det))
{
	$bg="";
		if($row_tourwise_det['tour_group_status']=="Cancel") 	{

			$bg="danger";

		}

		else  {

			$bg="#fff";

		}

	$count++;
	$date = $row_tourwise_det['form_date'];
         $yr = explode("-", $date);
         $year =$yr[0];
	$sq_total_member_count = mysql_num_rows(mysql_query("select traveler_id from travelers_details where traveler_group_id='$row_tourwise_det[traveler_group_id]' and status!='Cancel'"));

	$tour_name1 = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id= '$row_tourwise_det[tour_id]'"));
	$tour_name = $tour_name1['tour_name'];
	$tour_group1 = mysql_fetch_assoc(mysql_query("select from_date, to_date from tour_groups where group_id= '$row_tourwise_det[tour_group_id]'"));
	$tour_group = date("d/m/Y", strtotime($tour_group1['from_date']))." to ".date("d/m/Y", strtotime($tour_group1['to_date']));

	$sq_adjust_with = mysql_fetch_assoc(mysql_query("select first_name, last_name from travelers_details where traveler_id='$row_tourwise_det[s_adjust_with]'"));
	$adjust_with = $sq_adjust_with['first_name']." ".$sq_adjust_with['last_name'];
	$temp_arr = array( "data" => array(
		(int)($count),
		$tour_name,
		$tour_group,
		get_group_booking_id($row_tourwise_det['id'],$year),
		$sq_total_member_count,
		$row_tourwise_det['s_double_bed_room'],
		$row_tourwise_det['s_extra_bed'],
		$row_tourwise_det['s_on_floor']
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
	echo json_encode($array_s);
?>