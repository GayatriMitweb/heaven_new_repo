<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$array_s = array();
$temp_arr = array();

$query = "select * from sms_mobile_no where 1 ";
if($branch_status=='yes' && $role=='Branch Admin'){
	$query .=" and branch_admin_id = '$branch_admin_id'";
}

$sq_mobile_no = mysql_query($query);
$count = 0;
while($row_mobile_no = mysql_fetch_assoc($sq_mobile_no)){
	$count++;
	
	$group_name = "";
	$sq_group_entries = mysql_query("select * from sms_group_entries where mobile_no_id='$row_mobile_no[mobile_no_id]'");
	while($row_group_entry = mysql_fetch_assoc($sq_group_entries)){
		$sms_group_id = $row_group_entry['sms_group_id'];
		
		$sq_sms_group = mysql_fetch_assoc(mysql_query("select * from sms_group_master where sms_group_id='$sms_group_id'"));
		$sms_group_name = $sq_sms_group['sms_group_name'];

		$group_name .= $sms_group_name.', ';	
	}
	$temp_arr = array( "data" => array(
		'<input type="checkbox" id="chk_mobile_no_'.$count.'" name="chk_mobile_no" value="\''. $row_mobile_no['mobile_no_id'] .'\'">',
		(int)($count),
		$row_mobile_no['mobile_no'] ,
		trim($group_name, ', '),
		'<button class="btn btn-info btn-sm" onclick="mobile_no_edit_modal('. $row_mobile_no['mobile_no_id'] .')" data-toggle="tooltip" title="Edit No"><i class="fa fa-pencil-square-o"></i></button>'	
		), "bg" =>$bg);
	array_push($array_s,$temp_arr);
}
echo json_encode($array_s);
?>
