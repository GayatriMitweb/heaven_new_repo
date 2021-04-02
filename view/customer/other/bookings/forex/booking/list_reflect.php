<?php
include "../../../../../../model/model.php";
$customer_id = $_SESSION['customer_id'];
$booking_id = $_POST['booking_id'];

$query = "select * from forex_booking_master where customer_id='$customer_id' ";
if($booking_id!=""){
	$query .= " and booking_id='$booking_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered cust_table" id="tbl_list_f" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Sale/Buy</th>
			<th>currency</th>
			<th>View</th>
			<th class="text-right success">Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$total_amount = 0;
		$sq_booking = mysql_query($query);
		while($row_booking = mysql_fetch_assoc($sq_booking)){
			$date = $row_booking['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
			$total_amount += $row_booking['net_total'];
			$bg = ($row_booking['booking_status']=="Cancel") ? "danger" : "";
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= get_forex_booking_id($row_booking['booking_id'],$year) ?></td>
				<td><?= $row_booking['booking_type'] ?></td>
				<td><?=$row_booking['currency_code']?></td>
				<td><button data-toggle="tooltip" class="btn btn-info btn-sm" onclick="display_modal('<?=$row_booking['booking_id'] ?>')" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></button></td>
				<td class="text-right success"><?= $row_booking['net_total'] ?></td>
			</tr>
			<?php
		}
		?>	
	</tbody>
	<tfoot>
		<tr>
			<th colspan="5" class="text-right"> Total</th>
			<th class="text-right success"><?= number_format($total_amount,2) ?></td>
		</tr>
	</tfoot>
</table>
<div id="div_view_modal"></div>
</div> </div> </div>
<script type="text/javascript">
$('#tbl_list_f').dataTable({
	"pagingType": "full_numbers"
});
function display_modal(booking_id)

{

	$.post('bookings/forex/booking/view/index.php', { booking_id : booking_id }, function(data){

		$('#div_view_modal').html(data);

	});

}
</script>