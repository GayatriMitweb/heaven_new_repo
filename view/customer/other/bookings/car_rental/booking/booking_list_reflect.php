<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
$booking_id = $_POST['booking_id'];

$query = "select * from car_rental_booking where customer_id='$customer_id' ";
if($booking_id!=""){
	$query .= " and booking_id='$booking_id'";	
}
?>
<div class="row mg_tp_20"><div class="col-xs-12">
<div class="table-responsive">
<table class="table table-bordered table-hover cust_table" id="tbl_vendor_list" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Total_guest</th>
			<th>Traveling_Date</th>
			<th>View</th>
			<th class="text-right info">Total Amount</th>
			<th class="text-right success">Paid Amount</th>
			<th class="text-right danger">Cncl_amount</th>
			<th class="text-right warning">Balance</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$pen_bal=0;
		$paid_bal=0;
		$total_cancel=0;
		$sq_booking = mysql_query($query);
		while($row_booking = mysql_fetch_assoc($sq_booking))
		{
			$date = $row_booking['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$count++;
			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));

			$sale_total_amount=$row_booking['total_fees'];
			$cancel_amount=$row_booking['cancel_amount'];

			$sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from car_rental_payment where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
			$paid_amount = $sq_payment_info['sum'];

			if($paid_amount > $cancel_amount && $cancel_amount == '0'){
				$balance_amount = $sale_total_amount - $paid_amount;
			}
			else if($paid_amount > $cancel_amount && $cancel_amount != '0'){
				$balance_amount = 0;
			}
			else{
				$balance_amount = $cancel_amount - $paid_amount;
			}

			//Total
			$total_amount += $sale_total_amount;
			$total_paid += $paid_amount;
			$total_cancel += $cancel_amount;
			$total_balance += $balance_amount;

			$bg = ($row_booking['status']=="Cancel") ? "danger" : "";

			
			?>
			<tr class="<?= $bg ?>">
				<td><?= $count ?></td>
				<td><?= get_car_rental_booking_id($row_booking['booking_id'],$year) ?></td>
				<td><?= $row_booking['total_pax'] ?></td>
				<td><?= date('d-m-Y H:i:s', strtotime($row_booking['traveling_date'])) ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="car_display_modal(<?= $row_booking['booking_id'] ?>)" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></button>
				</td>
				<td class="text-right info"><?= number_format($sale_total_amount, 2) ?></td>
				<td class="text-right success"><?= number_format($paid_amount,2)?></td>
				<td class="text-right danger"><?= number_format($cancel_amount,2)?></td>
				<td class="text-right warning"><?= number_format($balance_amount,2);?></td>
			</tr>
			<?php
		}
		
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="5" class="text-right">Total</th>
			<th class="text-right info"><?= number_format($total_paid,2) ?></th>
			<th class="text-right success"><?= number_format($total_paid,2) ?></th>
			<th class="text-right danger"><?= number_format($total_cancel,2); ?></th>
			<th class="text-right warning"><?= number_format(($total_balance),2);?></th>
		</tr>
</tfoot>
</table>
</div>
</div>
</div>
<script type="text/javascript">
	
$('#tbl_vendor_list').dataTable({
	"pagingType": "full_numbers"
});
</script>