<?php 
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$count = 0;
$array_s = array();
$temp_arr = array();

$query1 = "select * from sms_email_id where 1";
if($branch_status=='yes' && $role=='Branch Admin'){
	$query1 .=" and branch_admin_id = '$branch_admin_id'";
}

$sq_email_no = mysql_query($query1);
	
while($row_email_no = mysql_fetch_assoc($sq_email_no)){
	$count++;
	
	$group_name = "";
	$sq_group_entries = mysql_query("select * from email_group_entries where email_id_id='$row_email_no[email_id_id]'");
	while($row_group_entry = mysql_fetch_assoc($sq_group_entries)){
		$email_group_id = $row_group_entry['email_group_id'];
		
		$sq_sms_group = mysql_fetch_assoc(mysql_query("select * from email_group_master where email_group_id='$email_group_id'"));
		$email_group_name = $sq_sms_group['email_group_name'];

		$group_name .= $email_group_name.', ';	
	}
	
	
	$temp_arr = array( "data" => array(
				'<input type="checkbox" id="chk_email_id_'.$count.'" name="chk_email_id" value="\''. $row_email_no['email_id_id'] .'\'">',
				(int)($count),
				$row_email_no['email_id'],
				trim($group_name, ', '),
				'<button class="btn btn-info btn-sm" onclick="email_id_edit_modal(\''. $row_email_no['email_id_id'] .'\')" data-toggle="tooltip" title="Edit Email ID"><i class="fa fa-pencil-square-o"></i></button>'	
				), "bg" =>$bg);
			array_push($array_s,$temp_arr);
	
}
echo json_encode($array_s);
?>

