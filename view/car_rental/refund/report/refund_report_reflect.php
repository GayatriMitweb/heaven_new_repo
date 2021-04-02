<?php
include "../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$from_date = $_POST['payment_from_date'];
$to_date = $_POST['payment_to_date'];
?>
<div class="row mg_tp_20"> <div class="col-xs-12 no-pad"> <div class="table-responsive">

<table class="table table-hover" id="tbl_refund_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Refund_To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
			<th>Refund_ID</th>
			<th>Refund_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th class="text-right">Amount</th>
			<th class="text-center">Voucher</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = $pending_refund = $canceled_refund = 0;
		$query = "select * from car_rental_refund_master where 1 ";
		if($booking_id!=""){
			$query .=" and booking_id='$booking_id'";
		}
		if($from_date!='' && $to_date!=''){
			$from_date = get_date_db($from_date);
			$to_date = get_date_db($to_date);
			$query .=" and refund_date between '$from_date' and '$to_date'";
		}
		$count = 0;
		$sq_car_rental_refund = mysql_query($query);
		$sq_cancel_pay=mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from car_rental_refund_master where clearance_status='Cleared'"));
		$sq_pend_pay=mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from car_rental_refund_master where clearance_status='Pending'"));
		while($row_car_rental_refund = mysql_fetch_assoc($sq_car_rental_refund)){

			$count++;
			$total_refund = $total_refund+$row_car_rental_refund['refund_amount'];

			$sq_car_rental_info = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$row_car_rental_refund[booking_id]'"));
			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_car_rental_info[customer_id]'"));
			$date = $sq_car_rental_info['created_at'];
			$yr = explode("-", $date);
			$year1 =$yr[0];

			if($row_car_rental_refund['clearance_status']=="Pending"){ 
				$bg = "warning"; 
				$pending_refund = $pending_refund + $row_car_rental_refund['refund_amount'];
			}
			else if($row_car_rental_refund['clearance_status']=="Cancelled"){ 
				$bg = "danger"; 
				$canceled_refund = $canceled_refund + $row_car_rental_refund['refund_amount'];
			}
			else{ $bg = ""; }
			
			$date = $row_car_rental_refund['refund_date'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$v_voucher_no = get_car_rental_booking_refund_id($row_car_rental_refund['refund_id'],$year);
			$v_refund_date = $row_car_rental_refund['refund_date'];
			$v_refund_to = $sq_customer['first_name'].' '.$sq_customer['last_name'];
			$v_service_name = "Car Rental Booking";
			$v_refund_amount = $row_car_rental_refund['refund_amount'];
			$v_payment_mode = $row_car_rental_refund['refund_mode'];

			$url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode";
			?>
			<tr class="<?= $bg ?>">			
				<td><?= $count ?></td>
				<td><?= get_car_rental_booking_id($row_car_rental_refund['booking_id'],$year1); ?></td>
				<td><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></td>
				<td><?= get_car_rental_booking_refund_id($row_car_rental_refund['refund_id'],$year); ?></td>
				<td><?= date('d/m/Y', strtotime($row_car_rental_refund['refund_date'])) ?></td>
				<td><?= $row_car_rental_refund['refund_mode'] ?></td>
				<td><?= $row_car_rental_refund['bank_name'] ?></td>
				<td><?= $row_car_rental_refund['transaction_id'] ?></td>
				<td class="text-right success"><?= $row_car_rental_refund['refund_amount'] ?></td>
				<td><a href="<?= $url ?>" class="btn btn-danger btn-sm" target="_blank" title="Voucher"><i class="fa fa-file-pdf-o"></i></a></td>
			</tr>
			<?php } ?>
	</tbody>	
	<tfoot>
		<tr class="active">
			<th colspan="2"></th>
			<th colspan="2" class="text-right info">Refund : <?= ($total_refund=="") ? 0 : $total_refund ?></th>
			<th colspan="2" class="text-right warning">Pending : <?= ($pending_refund=="") ? 0 : $pending_refund ?></th>
			<th colspan="2" class="text-right danger">Cancelled : <?= ($canceled_refund=="") ? 0 : $canceled_refund ?></th>
			<th colspan="2" class="text-right success">Total : <?= $total_refund - $pending_refund - $canceled_refund ?></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>
<script>
$('#tbl_refund_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>