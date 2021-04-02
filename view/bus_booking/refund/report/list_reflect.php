<?php
include "../../../../model/model.php";
$booking_id = $_POST['booking_id'];
$from_date = $_POST['payment_from_date'];
$to_date = $_POST['payment_to_date'];
?>
<div class="row mg_tp_20"> <div class="col-xs-12 no-pad"> <div class="table-responsive">

<table class="table table-hover" id="bus_tbl_refund" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Refund_To</th>
			<th>Refund_ID</th>
			<th>Refund_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th class="text-right">Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = 0;
		$query = "select * from bus_booking_refund_master where 1";
		if($booking_id!=""){
			$query .=" and booking_id='$booking_id'";
		}
		if($from_date!='' && $to_date!=''){
			$from_date = get_date_db($from_date);
			$to_date = get_date_db($to_date);
			$query .=" and refund_date between '$from_date' and '$to_date'";
		}
		$count = 0;

		$sq_refund = mysql_query($query);
		
		while($row_refund = mysql_fetch_assoc($sq_refund)){

			$count++;

			$total_refund = $total_refund+$row_refund['refund_amount'];

			$sq_car_rental_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$row_refund[booking_id]'"));
			$date = $sq_car_rental_info['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_car_rental_info[customer_id]'"));
			$date1 = $row_refund['refund_date'];
			$yr1 = explode("-", $date);
			$year1 =$yr1[0];

			if($row_refund['clearance_status']=="Pending"){ 
				$bg = "warning";
				$pending_total = $pending_total + $row_refund['refund_amount'];
			}
			else if($row_refund['clearance_status']=="Cancelled"){ 
				$bg = "danger"; 
				$cancelled_total = $cancelled_total + $row_refund['refund_amount'];
			}
			else{ 
				$bg = ""; 
			}

			?>
			<tr class="<?= $bg;?>">
				<td><?= $count ?></td>
				<td><?= get_bus_booking_id($row_refund['booking_id'],$year); ?></td>
				<td><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></td>
				<td><?= get_bus_booking_refund_id($row_refund['refund_id'],$year1); ?></td>
				<td><?= date('d/m/Y', strtotime($row_refund['refund_date'])) ?></td>
				<td><?= $row_refund['refund_mode'] ?></td>
				<td><?= $row_refund['bank_name'] ?></td>
				<td><?= $row_refund['transaction_id'] ?></td>
				<td class="text-right success"><?= $row_refund['refund_amount'] ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>	
	<tfoot>
		<tr class="active">
			<th class="text-right info" colspan="2">Total Paid : <?= number_format((($total_refund=="") ? 0 : $total_refund), 2);?></th>
			<th class="text-right warning" colspan="2">Total Pending : <?= number_format((($pending_total=="") ? 0 : $pending_total), 2); ?></th>
			<th class="text-right danger" colspan="2">Total Cancel : <?= number_format((($cancelled_total=="") ? 0 : $cancelled_total),2); ?></th>
			<th class="text-right success" colspan="3">Total Refund : <?= number_format(($total_refund - $pending_total - $cancelled_total), 2); ?></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>

<script>
$('#bus_tbl_refund').dataTable({
	"pagingType": "full_numbers"
});
</script>