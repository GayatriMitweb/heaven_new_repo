<?php
include "../../../../model/model.php";

$customer_id = $_POST['customer_id'];
$booking_id = $_POST['booking_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from hotel_booking_master where financial_year_id='$financial_year_id' ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
if($booking_id!=""){
	$query .=" and booking_id='$booking_id'";
}
if($from_date!="" && $to_date!=""){
	$from_date = date('Y-m-d', strtotime($from_date));
	$to_date = date('Y-m-d', strtotime($to_date));
	$query .= " and created_at between '$from_date' and '$to_date'";
}
if($cust_type != ""){
	$query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
}
if($company_name != ""){
	$query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by booking_id desc";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="tbl_report" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Customer_Name</th>
			<th>City</th>
			<th>Hotel_Name</th>
			<th>Check_In&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
			<th>Check_Out&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
			<th>Rooms</th>
			<th>Room_Type</th>
			<th>Extra_Beds</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$counter = 0;
		$sq_booking = mysql_query($query);
		while($row_booking = mysql_fetch_assoc($sq_booking)){
			
			$counter++;

			$date = $row_booking['created_at'];
	        $yr = explode("-", $date);
	        $year =$yr[0];
			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));

			$sq_entry = mysql_query("select * from hotel_booking_entries where booking_id = $row_booking[booking_id]");
			while($row_entry = mysql_fetch_assoc($sq_entry)){

				$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_entry[city_id]'"));
				$sq_hotel = mysql_fetch_assoc(mysql_query("select hotel_id, hotel_name from hotel_master where hotel_id='$row_entry[hotel_id]'"));

				$bg2 = ($row_entry['status']=="Cancel") ? "danger" : "";
				?>
				<tr class="<?= $bg2 ?>">
					<td><?= ++$count ?></td>
					<td><?= get_hotel_booking_id($row_booking['booking_id'],$year)?></td>
					<td><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></td>
					<td><?= $sq_city['city_name'] ?></td>
					<td><?= $sq_hotel['hotel_name'] ?></td>
					<td><?= date('d/m/Y H:i:s', strtotime($row_entry['check_in'])) ?></td>
					<td><?= date('d/m/Y H:i:s', strtotime($row_entry['check_out'])) ?></td>
					<td><?= $row_entry['rooms'] ?></td>
					<td><?= $row_entry['room_type'] ?></td>
					<td><?= $row_entry['extra_beds'] ?></td>
				</tr>
				<?php
			}
		}
		?>
	</tbody>
</table>

</div> </div> </div>
<script>
$('#tbl_report').dataTable({
		"pagingType": "full_numbers"
	});
function hotel_service_voucher(entry_id)
{
	var url = "report/booking_voucher.php?entry_id="+entry_id;
	window.open(url, '_blank');
}
</script>