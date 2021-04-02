<?php
include "../../../../../../model/model.php";
$exc_id = $_POST['exc_id'];
$customer_id = $_SESSION['customer_id'];
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
<table class="table table-bordered bg_white cust_table" id="exc_payment_list" style="margin:20px 0 !important">
	<thead>
	 <tr class="table-heading-row">
		<th>S_No.</th>
		<th>Booking_ID</th>
		<th>Payment_Date</th>
		<th>Mode</th>
		<th>Bank_Name</th>
		<th>Cheque_No/ID</th>
		<th class="success text-right">Amount</th>
		<th>Receipt </th>
	 </tr>
	</thead>
	<tbody>
		<?php 
		$query = "SELECT * from exc_payment_master where 1 and payment_amount!=0 ";		
		if($financial_year_id!=""){
			$query .= " and financial_year_id='$financial_year_id'";
		}
		if($exc_id!=""){
			$query .= " and exc_id='$exc_id'";
		}
		if($payment_mode!=""){
			$query .= " and payment_mode='$payment_mode'";
		}
		if($customer_id!=""){
			$query .= " and exc_id in (select exc_id from excursion_master where customer_id='$customer_id')";
		}
		if($payment_from_date!='' && $payment_to_date!=''){
			$payment_from_date = get_date_db($payment_from_date);
			$payment_to_date = get_date_db($payment_to_date);

			$query .=" and payment_date between '$payment_from_date' and '$payment_to_date'";
		}

		$count = 0;
		$total_paid_amt=0;

		$sq_pending_amount=0;
		$sq_cancel_amount=0;
		$sq_paid_amount=0;
		$total_payment=0;
	
		$sq_exc_payment = mysql_query($query);
		

		$sq_cancel_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from exc_payment_master where clearance_status='Cleared'"));
	
		$sq_pend_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from exc_payment_master where clearance_status='Pending'"));

		while($row_exc_payment = mysql_fetch_assoc($sq_exc_payment)){

			$date = $row_exc['payment_date'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$count++;
			$sq_exc_info = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$row_exc_payment[exc_id]'"));
			$total_sale = $sq_exc_info['exc_total_cost'];
			$sq_pay = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from exc_payment_master where clearance_status!='Cancelled' and exc_id='$row_exc_payment[exc_id]'"));
			$total_pay_amt = $sq_pay['sum'];
			$outstanding =  $total_sale - $total_pay_amt;
			$date = $sq_exc_info['created_at'];
			$yr = explode("-", $date);
			$year1 =$yr[0];


			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_exc_info[customer_id]'"));

			$bg='';

			if($row_exc_payment['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_exc_payment['payment_amount']+$row_exc_payment['credit_charges'];
			}
			else if($row_exc_payment['clearance_status']=="Cancelled"){ $bg='danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_exc_payment['payment_amount']+$row_exc_payment['credit_charges'];
			}		
			
			$sq_paid_amount = $sq_paid_amount + $row_exc_payment['payment_amount']+$row_exc_payment['credit_charges'];

			$payment_id_name = "Activity Payment ID";
			$payment_id = get_exc_booking_payment_id($row_exc_payment['payment_id'],$year1);
			$receipt_date = date('d-m-Y');
			$booking_id = get_exc_booking_id($row_exc_payment['exc_id'],$year);
			$customer_id = $sq_exc_info['customer_id'];
			$booking_name = "Activity Booking";
			$travel_date = 'NA';
			$payment_amount = $row_exc_payment['payment_amount']+$row_exc_payment['credit_charges'];
			$payment_mode1 = $row_exc_payment['payment_mode'];
			$transaction_id = $row_exc_payment['transaction_id'];
			$payment_date = date('d-m-Y',strtotime($row_exc_payment['payment_date']));
			$bank_name = $row_exc_payment['bank_name'];
			$receipt_type = "Activity Receipt";			

			$url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&table_name=exc_payment_master&customer_field=exc_id&in_customer_id=$row_exc_payment[exc_id]";

			?>
			<tr class="<?= $bg?>">
				<td><?= $count ?></td>
				<td><?=  get_exc_booking_id($row_exc_payment['exc_id'],$year); ?></td>
				<td><?= date('d-m-Y', strtotime($row_exc_payment['payment_date'])) ?></td>
				<td><?= $row_exc_payment['payment_mode'] ?></td>
				<td><?= $row_exc_payment['bank_name']; ?></td>
				<td><?= $row_exc_payment['transaction_id']; ?></td>
				<td class="text-right success"><?= number_format($row_exc_payment['payment_amount']+$row_exc_payment['credit_charges'],2) ?></td>
				<td>
					<a onclick="loadOtherPage('<?= $url1 ?>')" class="btn btn-info btn-sm" title="Download Receipt"><i class="fa fa-print"></i></a>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="2" class="info text-right">Total Paid : <?= number_format($sq_paid_amount,2) ?></th>
			<th colspan="2" class="warning text-right">Pending Clearance : <?= number_format($sq_pending_amount,2) ?></th>
			<th colspan="2" class="danger text-right">Cancellation Charges : <?= number_format($sq_cancel_amount,2) ?></th>
			<th colspan="1" class="success text-right">Total Payment : <?= number_format(($sq_paid_amount - $sq_pending_amount - $sq_cancel_amount),2) ?></th>
			<th class="active"></th>
		</tr>
	</tfoot>	
</table>

</div> </div> </div>
<script type="text/javascript">
$('#exc_payment_list').dataTable({
	"pagingType": "full_numbers"
});
</script>
