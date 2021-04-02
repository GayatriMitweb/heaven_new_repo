<?php include "../../../../../model/model.php";
$tour_id = $_POST['tour_id'];
$group_id = $_POST['group_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$branch_id= $_GET['branch_id_filter'];
$count=0;
$array_s = array();
$temp_arr = array();
$query = "select * from refund_tour_cancelation where 1";
if($branch_id!=""){

	$query .= " and tourwise_traveler_id in (select id from tourwise_traveler_details where branch_admin_id = '$branch_id')";
}
if($branch_status=='yes' && $role=='Branch Admin'){
    $query .= " and tourwise_traveler_id in (select id from tourwise_traveler_details where branch_admin_id = '$branch_admin_id')";
}

if($tour_id != '' ){
	$query .= " and tourwise_traveler_id in(select id from tourwise_traveler_details where tour_id='$tour_id') ";
}

if($group_id != ''){
	$query .= " and tourwise_traveler_id in(select id from tourwise_traveler_details where tour_group_id='$group_id') ";
}
$count = 0;
 
$sq_pending_amount=0;
$sq_cancel_amount=0;
$sq_paid_amount=0;
$sq = mysql_query($query);
$bg;

		$sql = mysql_query("SELECT SUM(amount) as total FROM payment_master where tourwise_traveler_id ='$tourwise_traveler_id' and payment_for = 'Travelling' and clearance_status!='Pending' AND clearance_status!='Cancelled'");
		$row = mysql_fetch_array($sql);
		$traveling_amount_paid = $row['total'];

		$sql1 = mysql_query("SELECT SUM(amount) as total FROM payment_master where tourwise_traveler_id ='$tourwise_traveler_id' and payment_for = 'Tour' and clearance_status!='Pending' AND clearance_status!='Cancelled' ");


		$row1= mysql_fetch_array($sql1);
		$tour_amount_paid = $row1['total'];
		$total_amount = $traveling_amount_paid + $tour_amount_paid;
		
		$tourwise_details1 = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_traveler_id' "));

		$sq_est_info = mysql_fetch_assoc(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$tourwise_traveler_id'"));

		$sale_Amount = $tourwise_details1['total_tour_fee'] - $sq_est_info['total_refund'];

		$refund_amount = $total_amount - $sale_Amount; 


while($row = mysql_fetch_assoc($sq)){
	($row['clearance_status']=="Cleared")?$bg='success':$bg="";

	$sq_traveler = mysql_fetch_assoc(mysql_query("select * from travelers_details where traveler_id='$row[traveler_id]'"));
	$sq_traveler_year = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where traveler_group_id='$sq_traveler[traveler_group_id]'"));
	$date = $sq_traveler_year['form_date'];
         $yr = explode("-", $date);
         $year =$yr[0];
	if($row['clearance_status']=="Pending"){ $bg='warning';
		$sq_pending_amount = $sq_pending_amount + $row['refund_amount'];
	}

	if($row['clearance_status']=="Cancelled"){ $bg='danger';
		$sq_cancel_amount = $sq_cancel_amount + $row['refund_amount'];
	}

	if($row['clearance_status']=="Cleared"){ $bg='success';
		$sq_paid_amount = $sq_paid_amount + $row['refund_amount'];
	}

	if($row['clearance_status']==""){ $bg='';
		$sq_paid_amount = $sq_paid_amount + $row['refund_amount'];
	}
	$refund_amount += $row['refund_amount']; 
	/*
	$sq_travel = mysql_query($travel_query);
*/
$temp_arr = array( "data" => array(
	(int)(++$count),
	date('d/m/Y', strtotime($row['refund_date'])),
	get_group_booking_id($row['tourwise_traveler_id'],$year),
	$sq_traveler['first_name'].' '.$sq_traveler['last_name'],
	$row['refund_mode'],
	$row['refund_amount']
	), "bg" =>$bg);
	array_push($array_s,$temp_arr);
}
$footer_data = array("footer_data" => array(
	'total_footers' => 4,
	
	'foot0' => "Refund Amount : ".   number_format((($refund_amount=='')?0:$refund_amount), 2),
	'col0' => 2,
	'class0' =>"text-right success",

	'foot1' => "Total Pending  : ".number_format((($sq_pending_amount=='')?0:$sq_pending_amount), 2),
	'col1' => 2,
	'class1' =>"text-right warning",
	'foot2' => "Total Cancel: ".number_format((($sq_cancel_amount=='')?0:$sq_cancel_amount), 2),
	'col2' => 1,
	'class2' =>"text-right danger",
	'foot3' => "Total Refund : ".number_format($refund_amount - $sq_pending_amount - $sq_cancel_amount,2),
	'col3' => 2,
	'class3' =>"text-right success"
	)
);
array_push($array_s, $footer_data);
	echo json_encode($array_s);
?>