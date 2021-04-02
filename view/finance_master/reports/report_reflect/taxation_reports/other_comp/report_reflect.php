<?php include "../../../../../../model/model.php"; 
$till_date = $_POST['till_date'];
$branch_status = $_POST['branch_status'];
$role = $_POST['role'];
$branch_admin_id = $_POST['branch_admin_id'];
$array_s = array();
$temp_arr = array();

$query = "select * from other_complaince_master where 1 ";
if($till_date != ''){
	$till_date = get_date_db($till_date);
	$query .= " and comp_date <= '$till_date'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
		$query .= " and branch_admin_id='$branch_admin_id'";
	}
}
$sq_query = mysql_query($query);

	$count = 1;
	while($row_query = mysql_fetch_assoc($sq_query)){ 
		
	$temp_arr = array( "data" => array(
		(int)($count++),
		$row_query['comp_name'],
		$row_query['under_statue'] ,
		get_date_user($row_query['due_date']),
		$row_query['payment'], 
		$row_query['resp_person'],
		$row_query['description'] ,
		($row_query['comp_date'] == '0000-00-00')?'<button class="btn btn-info btn-sm" onclick="update_modal('. $row_query['id'] .')" title="Complied Date"><i class="fa fa-eye"></i></button>' : get_date_user($row_query['comp_date'])
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
echo json_encode($array_s);			 
?>			