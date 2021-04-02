<?php include "../../../../../model/model.php"; 
$to_date = $_POST['to_date'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_POST['branch_admin_id'];
$role = $_POST['role'];
$array_s = array();
$temp_arr = array();
	$count = 1;
	$total_amount = 0;
	$query = "SELECT * FROM `debit_note_master` where 1 "; 
	if($to_date != ''){
		$to_date = get_date_db($to_date);
		$query .= " and created_at <= '$to_date'";
	}
	if($branch_status == 'yes'){
		if($role == 'Branch Admin'){
			$query .= " and branch_admin_id='$branch_admin_id'";
		}
	}
	$sq_query = mysql_query($query);
	while($row_query = mysql_fetch_assoc($sq_query))
	{
		$supplier_name = get_vendor_name_report($row_query['vendor_type'],$row_query['vendor_type_id']);
		$temp_arr = array( "data" => array(
			(int)($count++),
			get_date_user($row_query['created_at']),
			$supplier_name,
			$row_query['vendor_type'],
			$row_query['payment_amount']
			), "bg" =>$bg);
			array_push($array_s,$temp_arr);
		}
		echo json_encode($array_s);	 
		?>