<?php
include "../../../../model/model.php";

$city_id = $_POST['city_id'];
$hotel_id = $_POST['hotel_id'];
$from_date = $_POST['from_date'];
$to_date  = $_POST['to_date'];
$array_s = array();
$temp_arr = array();
$query = "select * from hotel_vendor_price_master where 1 ";
if($city_id != ''){
	$query .= " and city_id = '$city_id'";
}
if($hotel_id != ''){
	$query .= " and hotel_id = '$hotel_id'";
}
if($from_date != '' && $to_date != ''){
	$from_date1 = date('Y-m-d H:i', strtotime($from_date));
	$to_date1 = date('Y-m-d H:i', strtotime($to_date));
	$query .= "  and (created_at>='$from_date1' and created_at<='$to_date1') ";
}
$query .= ' order by pricing_id desc';
$sq_query_login = mysql_query($query);

$count = 0;
	while($row_req = mysql_fetch_assoc($sq_query_login)){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$row_req[hotel_id]'"));
		$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_req[city_id]'"));
		$sq_currency = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id='$row_req[currency_id]'"));
		$temp_arr = array( "data" => array(
			(int)(++$count), 
			get_datetime_user($row_req['created_at']),
			$sq_city['city_name'],
			$sq_hotel['hotel_name'],
			$sq_currency['currency_code'],
			'
			<form style="display:inline-block" action="b2b_tarrif/update/index.php" id="frm_booking_'.$count.'" method="POST">
				<input style="display:inline-block" type="hidden" id="pricing_id" name="pricing_id" value="'.$row_req['pricing_id'].'">
				<button style="display:inline-block" data-toggle=tooltip" class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true" data-toggle="tooltip" title="Update Details"></i></button>
			</form>
			<button style="display:inline-block" class="btn btn-info btn-sm" onclick="view_modal(\''.$row_req['pricing_id'].'\')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>
			
			'), "bg" => $bg);
		array_push($array_s,$temp_arr); 
	}
echo json_encode($array_s);	
?>	