<?php include "../../../../../model/model.php"; 
$booking_id=$_POST['booking_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$branch_id= $_GET['branch_id_filter'];
$bg;

$sq_pending_amount=0;
$sq_cancel_amount=0;
$sq_paid_amount=0;
$Total_payment=0;
$refund_amount = 0;
$array_s = array();
$temp_arr = array();


	$query = "select * from package_refund_traveler_cancelation where 1"; 
	// $booking_id = $_GET['booking_id'];
	if($booking_id!=""){
		$query .= " and booking_id='$booking_id'";
	}
	if($branch_id!=""){

		$query .=" and booking_id in(select booking_id from package_tour_booking_master where branch_admin_id = '$branch_id')";
	}
	if($branch_status=='yes' && $role!='Admin'){
	    $query .=" and booking_id in(select booking_id from package_tour_booking_master where branch_admin_id = '$branch_admin_id')";
	}	
	$date;
	$query .=" and clearance_status!='Cancelled'";
 
	$sq_refund = mysql_query($query);
	
			$status=1;
	while($row_refund = mysql_fetch_assoc($sq_refund)){
		if($row_refund['clearance_status']=="Pending"){ $bg='warning';
		$sq_pending_amount = $sq_pending_amount + $row_refund['total_refund'];
		}

		if($row_refund['clearance_status']==""){ $bg='';
			$sq_paid_amount = $sq_paid_amount + $row_refund['total_refund'];
		}
		$refund_amount += $row_refund['total_refund']; 

		$sq_tour=mysql_fetch_assoc(mysql_query("SELECT * from package_tour_booking_master where booking_id='$row_refund[booking_id]'"));
		$sq_ref = mysql_query("SELECT * from package_refund_traveler_estimate where booking_id='$row_refund[booking_id]'");
		

		($row_refund['refund_date']=='0000-00-00')?$date='':$date=date("d/m/Y",strtotime($row_refund['refund_date']));
		
		$temp_arr = array( "data" => array(
			(int)(++$count),
			$date ,
			$sq_tour['tour_name'],
			get_package_booking_id($row_refund['booking_id']),
			$row_refund['refund_mode'],
			$row_refund['total_refund']
			), "bg" =>$bg);
			array_push($array_s,$temp_arr);
		
	}
	$footer_data = array("footer_data" => array(
		'total_footers' => 4,
		
		'foot0' => "Refund Amount : ".number_format((($refund_amount=='')?0:$refund_amount), 2),
		'col0' => 2,
		'class0' =>"text-right success",

		'foot1' => "Pending Amount : ".number_format((($sq_pending_amount=='')?0:$sq_pending_amount), 2),
		'col1' => 1,
		'class1' =>"text-right warning",
		'foot2' => "Total Cancel : ".number_format((($sq_cancel_amount=='')?0:$sq_pending_amount), 2),
		'col2' => 1,
		'class2' =>"text-right danger",
		'foot3' => "Total Amount : ".number_format(($refund_amount - $sq_pending_amount), 2),
		'col3' => 2,
		'class3' =>"text-right success"
		)
	);
	array_push($array_s, $footer_data);
	echo json_encode($array_s);
		?>
