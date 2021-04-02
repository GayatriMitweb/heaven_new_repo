<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
$booking_id = $_POST['booking_id'];
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">

<table class="table table-bordered cust_table" id="tbl_refund_list" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Refund_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th class="text-right success">Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = $pending_total = $cancelled_total = 0;
		$query = "select * from bus_booking_refund_master where 1";
		if($booking_id!=""){
			$query .=" and booking_id='$booking_id'";
		}
		$query .= " and booking_id in ( select booking_id from bus_booking_master where customer_id='$customer_id' )";

		$count = 0;

		$sq_refund = mysql_query($query);
		
		while($row_refund = mysql_fetch_assoc($sq_refund)){
			$date = $row_refund['refund_date'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$count++;

			$total_refund = $total_refund+$row_refund['refund_amount'];

			$sq_car_rental_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$row_refund[booking_id]'"));
			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_car_rental_info[customer_id]'"));

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

			$sq_entries = mysql_fetch_assoc(mysql_query("select * from bus_booking_entries where booking_id='$row_refund[booking_id]'"));
			
			$v_voucher_no = get_bus_booking_refund_id($row_refund['refund_id']);
			$v_refund_date = $row_refund['refund_date'];
			$v_refund_to = $sq_entries['company_name'];
			$v_service_name = "Bus Booking";
			$v_refund_amount = $row_refund['refund_amount'];
			$v_payment_mode = $row_refund['refund_mode'];
			$url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode";
			?>
			<tr class="<?= $bg;?>">
				<td><?= $count ?></td>
				<td><?= get_bus_booking_id($row_refund['booking_id'],$year); ?></td>
				<td><?= date('d-m-Y', strtotime($row_refund['refund_date'])) ?></td>
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
			<th colspan="1" class="text-right info">Refund : <?= number_format($total_refund,2) ?></th>
			<th colspan="2" class="text-right warning">Pending : <?= number_format($pending_total,2) ?></th>
			<th colspan="2" class="text-right danger">Cancel : <?= number_format($cancelled_total,2) ?></th>
			<th colspan="2" class="text-right success">Total Refund: <?= number_format(($total_refund - $pending_total - $cancelled_total),2) ?></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>

<script>
$('#tbl_refund_list').dataTable({
	"pagingType": "full_numbers"
});
</script>