<?php include "../../../../../model/model.php";
$tour_id = $_POST['tour_id'];
$group_id = $_POST['group_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$id = $_POST['id'];
$count=0;
$sq_pending_amount=0;
$sq_cancel_amount=0;
$sq_paid_amount=0;
$Total_payment=0;
$total = 0;
$array_s = array();
$temp_arr = array();
$query1 = "select * from payment_master where 1";

if($tour_id != ''){
	$query1 .= " and tourwise_traveler_id in(select id from tourwise_traveler_details where tour_id='$tour_id') ";
}
if( $group_id != ''){
	$query1 .= " and tourwise_traveler_id in(select traveler_group_id from tourwise_traveler_details where tour_group_id='$group_id') ";
}

if($branch_id!=""){

	$query1 .= " and tourwise_traveler_id in (select id from tourwise_traveler_details where branch_admin_id = '$branch_id')";
}
if($branch_status=='yes' && $role=='Branch Admin'){
    $query1 .= " and branch_admin_id = '$branch_admin_id'";
}
 
$sq_payment_det = mysql_query($query1);
$bg;
while($row_payment_det = mysql_fetch_assoc($sq_payment_det))
{

	$total += $row_payment_det['amount']; 
	$sq_tourwise_details = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$row_payment_det[tourwise_traveler_id]'"));
	$date = $sq_tourwise_details['from_date'];
         $yr = explode("-", $date);
         $year =$yr[0];
	$sq_tour_det = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id='$sq_tourwise_details[tour_id]'"));
	$sq_tour_group_det = mysql_fetch_assoc(mysql_query("select from_date, to_date from tour_groups where group_id='$sq_tourwise_details[tour_group_id]'"));
	$tour_group = date("d-m-Y", strtotime($sq_tour_group_det['from_date']))." to ".date("d/m/Y", strtotime($sq_tour_group_det['to_date']));

	$count++;
	if($row_payment_det['clearance_status']=="Pending"){ $bg='warning';
		$sq_pending_amount = $sq_pending_amount + $row_payment_det['amount'];
	}

	if($row_payment_det['clearance_status']=="Cancelled"){ $bg='danger';
		$sq_cancel_amount = $sq_cancel_amount + $row_payment_det['amount'];
	}

	if($row_payment_det['clearance_status']=="Cleared"){ $bg='success';
		$sq_paid_amount = $sq_paid_amount + $row_payment_det['amount'];
	}

	if($row_payment_det['clearance_status']==""){ $bg='';
		$sq_paid_amount = $sq_paid_amount + $row_payment_det['amount'];
	}
	$temp_arr = array( "data" => array(
		(int)($count),
		$sq_tour_det['tour_name'],
		$tour_group,
		get_group_booking_id($row_payment_det['tourwise_traveler_id'],$year),
		date("d/m/Y", strtotime($row_payment_det['date'])),
		$row_payment_det['payment_mode'],
		$row_payment_det['payment_for'],
		($row_payment_det['payment_for']=='Tour') ? (($sq_tourwise_details['total_travel_expense']=="") ?  number_format(0,2) : $sq_tourwise_details['total_travel_expense'] ) : (($row_payment_det['payment_for']=='Travelling') ? $sq_tourwise_details['total_tour_fee'] : ""),
		($row_payment_det['amount']=="") ? number_format(0,2) : $row_payment_det['amount'],
		($row_payment_det['payment_for']=='Tour') ? ($sq_tourwise_details['total_travel_expense']- $row_payment_det['amount']) : (($row_payment_det['payment_for']=='Travelling' ? number_format(($sq_tourwise_details['total_tour_fee']-$row_payment_det['amount']), 2) : ""))
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
	$footer_data = array("footer_data" => array(
		'total_footers' => 4,
		
		'foot0' => "Paid Amount : ".  number_format($total, 2),
		'col0' => 3,
		'class0' =>"text-right info",

		'foot1' => "Pending Amount : ".number_format($sq_pending_amount, 2),
		'col1' => 2,
		'class1' =>"text-right warning",
		'foot2' => "Cancellation Charges : ". number_format($sq_cancel_amount, 2),
		'col2' => 3,
		'class2' =>"text-right danger",
		'foot3' => "Total Paid : ".number_format(($total-$sq_pending_amount - $sq_cancel_amount), 2),
		'col3' => 2,
		'class3' =>"text-right success"
		)
	);
	array_push($array_s, $footer_data);
	echo json_encode($array_s);
?>	