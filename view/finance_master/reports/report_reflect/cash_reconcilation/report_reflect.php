<?php 
include "../../../../../model/model.php";
$filter_date = $_POST['filter_date'];
$branch_admin_id = $_POST['branch_admin_id'];

$query = "select * from cash_reconcl_master where 1 ";
if($filter_date != ''){
	$filter_date = get_date_db($filter_date);
	$query .= " and reconcl_date = '$filter_date'";
}
if($branch_admin_id != '0'){
	 $query .= " and branch_admin_id = '$branch_admin_id'";
}
$sq_query = mysql_query($query);
$array_s = array();
$temp_arr = array();
		$count = 1;
		$bg = '';
		while($row_query = mysql_fetch_assoc($sq_query))
		{		
		if($row_query['approval_status'] == 'true') {  $bg = 'success'; }
		else if($row_query['approval_status'] == 'false')  {  $bg = 'danger'; }
		else{
			 $bg = '';
		}
		$class="";
		if($row_query['approval_status'] == ''){ $class = 'fa fa-check-square-o'; }
		else{  $class = 'fa fa-eye'; }
		$temp_arr = array( "data" => array(
			(int)($count++),
			get_date_user($row_query['reconcl_date']),
			$row_query['system_cash'] ,
			$row_query['till_cash'] ,
			$row_query['diff_prior'],
			$row_query['reconcl_amount'],
			$row_query['diff_reconcl'],
			'<button class="btn btn-info btn-sm" onclick="display_modal('. $row_query['id'] .')" title="Admin Approval data-toggle="tooltip"><i class="'. $class.'"></i></button>'
			), "bg" =>$bg);
			array_push($array_s, $temp_arr);
			}echo json_encode($array_s);
	?>	 