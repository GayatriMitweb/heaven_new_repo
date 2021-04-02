<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
$ticket_id = $_POST['ticket_id'];
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">

<table class="table table-bordered cust_table bg_white" id="tbl_payment_list" style="margin:20px 0 !important">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Payment_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>			
			<th class="text-right success">Amount</th>
			<th class="text-center">Receipt</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$query = "select * from ticket_payment_master where 1 and payment_amount !='0' ";		

		if($ticket_id!=""){
			$query .= " and ticket_id='$ticket_id'";
		}
	    $query .= " and ticket_id in (select ticket_id from ticket_master where customer_id='$customer_id')";

		$count = 0;
		$sq_pending_amount=0;
		$sq_cancel_amount=0;
		$sq_paid_amount=0;
		$total_payment=0;

		$sq_ticket_payment = mysql_query($query);
		while($row_ticket_payment = mysql_fetch_assoc($sq_ticket_payment)){

			$sq_pay = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum,sum(credit_charges) as sumc from ticket_payment_master where clearance_status!='Cancelled' and ticket_id='$row_ticket_payment[ticket_id]'"));

			$sq_ticket_info = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id='$row_ticket_payment[ticket_id]'"));
			$total_sale = $sq_ticket_info['ticket_total_cost'] + $sq_pay['sumc'];

			$total_pay_amt = $sq_pay['sum']+$sq_pay['sumc'];
			$outstanding =  $total_sale - $total_pay_amt;
			$date = $row_ticket_payment['payment_date'];
			$yr = explode("-", $date);
			$year1 =$yr[0];
			$count++;

			$date = $sq_ticket_info['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$bg='';
			$sq_depa_date = mysql_fetch_assoc(mysql_query("select * from ticket_trip_entries where ticket_id ='$row_ticket_payment[ticket_id]'"));

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_ticket_info[customer_id]'"));
			if($row_ticket_payment['clearance_status']=="Pending"){ 
				$bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_ticket_payment['payment_amount'] + $row_ticket_payment['credit_charges'];
			}
			else if($row_ticket_payment['clearance_status']=="Cancelled"){ 
				$bg='danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_ticket_payment['payment_amount']+ $row_ticket_payment['credit_charges'];
			}
			$sq_paid_amount = $sq_paid_amount + $row_ticket_payment['payment_amount'] + $row_ticket_payment['credit_charges'];

			$payment_id_name = "Flight Ticket Payment ID";
			$payment_id = get_ticket_booking_payment_id($row_ticket_payment['payment_id'],$year1);
			$receipt_date = date('d-m-Y');
			$booking_id = get_ticket_booking_id($row_ticket_payment['ticket_id'],$year);
			$customer_id = $sq_ticket_info['customer_id'];
			$booking_name = "Flight Ticket Booking";
			$travel_date = date('d-m-Y',strtotime($sq_depa_date['departure_datetime']));
			$payment_amount = $row_ticket_payment['payment_amount'] + $row_ticket_payment['credit_charges'];
			$payment_mode1 = $row_ticket_payment['payment_mode'];
			$transaction_id = $row_ticket_payment['transaction_id'];
			$payment_date = date('d-m-Y',strtotime($row_ticket_payment['payment_date']));
			$bank_name = $row_ticket_payment['bank_name'];
			$receipt_type = "Flight Ticket Receipt";


			$url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&table_name=ticket_payment_master&customer_field=ticket_id&in_customer_id=$row_ticket_payment[ticket_id]";

			?>
			<tr class="<?= $bg?>">				
				<td><?= $count ?></td>
				<td><?= get_ticket_booking_id($row_ticket_payment['ticket_id'],$year) ?></td>
				<td><?= date('d-m-Y', strtotime($row_ticket_payment['payment_date'])) ?></td>
				<td><?= $row_ticket_payment['payment_mode'] ?></td>
				<td><?= $row_ticket_payment['bank_name'] ?></td>
				<td><?= $row_ticket_payment['transaction_id'] ?></td>
				<td class="text-right success"><?= number_format($row_ticket_payment['payment_amount'] + $row_ticket_payment['credit_charges'],2) ?></td>
				<td class="text-center">
					<a onclick="loadOtherPage('<?= $url1 ?>')" class="btn btn-info btn-sm" title="Download Receipt"><i class="fa fa-print"></i></a>
				</td>				
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="2" class="info text-right">Paid Amount : <?= number_format($sq_paid_amount,2) ?></th>
			<th colspan="2" class="warning text-right">Pending Clearance : <?= number_format($sq_pending_amount,2) ?></th>
			<th colspan="2" class="danger text-right">Cancellation Charges : <?= number_format($sq_cancel_amount,2) ?></th>
			<th colspan="2" class="success text-right">Total Payment : <?= number_format(($sq_paid_amount-$sq_pending_amount-$sq_cancel_amount),2) ?></th>
		</tr>
	</tfoot>		

</table>

</div> </div> </div>



<script>
$('#tbl_payment_list').dataTable({
	"pagingType": "full_numbers"
});
</script>