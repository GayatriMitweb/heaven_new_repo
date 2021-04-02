<?php include "../../../../../model/model.php"; 
$array_s = array();
$temp_arr = array();
$tour_id= $_POST['tour_id'];
$group_id = $_POST['group_id'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$branch_id= $_GET['branch_id_filter'];

$query = "select * from tourwise_traveler_details where 1";
if($tour_id!="")
{
	$query = $query." and tour_id='$tour_id' ";
}
 if($group_id!="")
 {
 	$query = $query." and tour_group_id ='$group_id' ";
 }

 if($role=='Sales')
{
 
	$query = $query." and emp_id='$emp_id' ";	
}	
if($branch_id!=""){

	$query .= " and  branch_admin_id = '$branch_id'";
}
if($branch_status=='yes' && $role=='Branch Admin'){
    $query .= " and  branch_admin_id = '$branch_admin_id'";
}
 $query = $query." and tour_group_status!='Cancel' ";

$count = 0;
$sq1 =mysql_query($query);
while($row1 = mysql_fetch_assoc($sq1))
{
	$sq_tour_name = mysql_query("select tour_name from tour_master where tour_id='$row1[tour_id]'");
	$row_tour_name = mysql_fetch_assoc($sq_tour_name);
	$tour_name = $row_tour_name['tour_name'];

	$sq_tour_group_name = mysql_query("select from_date,to_date from tour_groups where group_id='$row1[tour_group_id]'");
	$row_tour_group_name = mysql_fetch_assoc($sq_tour_group_name);
	$tour_group_from = date("d/m/Y", strtotime($row_tour_group_name['from_date']));
	$tour_group_to = date("d/m/Y", strtotime($row_tour_group_name['to_date']));	
	

	$query1 = "select * from travelers_details where traveler_group_id = '$row1[traveler_group_id]' and status = 'Active' ";
	$sq2 = mysql_query($query1);
	while($row2 = mysql_fetch_assoc($sq2))
	{
		if($row2['handover_adnary']=="yes")
		{
			$adnary_status = "disabled";
			$class1 = "btn btn-danger";
		}
		else
		{
			$adnary_status = "";
			$class1 = "btn btn-success";
		}	
		if($row2['handover_gift']=="yes")
		{
			$gift_status = "disabled";
			$class2 = "btn btn-danger";
		}
		else
		{
			$gift_status = "";
			$class2 = "btn btn-success";
		}	
		$temp_arr = array( "data" => array(
			(int)(++$count),
			$tour_name ,
			$tour_group_from." to ".$tour_group_to,
			$row2['first_name']." ".$row2['last_name'],
			'<button class="'.$class1.' btn-sm ico_left" id="handover_adnary'.$count .'" value="'.$row2['traveler_id'] .'" onclick="hanover_adnary(this.id)" '. $adnary_status .'><i class="fa fa-thumbs-up"></i>Handover</button>',
			'<button class="'.$class2.' btn-sm ico_left" id="handover_gift'.$count .'" value="'.$row2['traveler_id'] .'" onclick="hanover_gift(this.id)" '.$gift_status .' ><i class="fa fa-thumbs-up"></i>Handover</button>'
			), "bg" =>$bg);
			array_push($array_s,$temp_arr);
		}
	}
	echo json_encode($array_s);
?>