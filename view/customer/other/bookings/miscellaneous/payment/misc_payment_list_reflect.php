<?php
include "../../../../../../model/model.php";
$misc_id = $_POST['misc_id'];
$customer_id = $_SESSION['customer_id'];
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
<table class="table table-bordered bg_white cust_table" id="miscellaneous_payment_list" style="margin:20px 0 !important">
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
		$query = "SELECT * from miscellaneous_payment_master where 1 and payment_amount!=0 ";		
		if($financial_year_id!=""){
			$query .= " and financial_year_id='$financial_year_id'";
		}
		if($misc_id!=""){
			$query .= " and misc_id='$misc_id'";
		}
		if($payment_mode!=""){
			$query .= " and payment_mode='$payment_mode'";
		}
		if($customer_id!=""){
			$query .= " and misc_id in (select misc_id from miscellaneous_master where customer_id='$customer_id')";
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
	
		$sq_miscellaneous_payment = mysql_query($query);
		

		$sq_cancel_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from miscellaneous_payment_master where clearance_status='Cleared'"));
	
		$sq_pend_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from miscellaneous_payment_master where clearance_status='Pending'"));

		while($row_miscellaneous_payment = mysql_fetch_assoc($sq_miscellaneous_payment)){
			$date = $row_miscellaneous_payment['payment_date'];
			$yr = explode("-", $date);
			$year1 =$yr[0];

			$count++;
			$sq_paid_amount1 = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from miscellaneous_payment_master where misc_id='$row_miscellaneous_payment[misc_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			$credit_card_charges = $sq_paid_amount1['sumc'];

			$sq_miscellaneous_info = mysql_fetch_assoc(mysql_query("select * from miscellaneous_master where misc_id='$row_miscellaneous_payment[misc_id]'"));
			$total_sale = $sq_miscellaneous_info['misc_total_cost'] + $credit_card_charges;
			$total_pay_amt = $sq_paid_amount1['sum']+$sq_paid_amount1['sumc'];
			$outstanding =  $total_sale - $total_pay_amt;
			
			$date = $sq_miscellaneous_info['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_miscellaneous_info[customer_id]'"));
			$bg='';

			if($row_miscellaneous_payment['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_miscellaneous_payment['payment_amount'] + $row_miscellaneous_payment['credit_charges'];
			}
			else if($row_miscellaneous_payment['clearance_status']=="Cancelled"){ $bg='danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_miscellaneous_payment['payment_amount'] + $row_miscellaneous_payment['credit_charges'];
			}		
			$sq_paid_amount = $sq_paid_amount + $row_miscellaneous_payment['payment_amount'] + $row_miscellaneous_payment['credit_charges'];

			$payment_id_name = "miscellaneous Payment ID";
			$payment_id = get_misc_booking_payment_id($row_miscellaneous_payment['payment_id'],$year1);
			$receipt_date = date('d-m-Y');
			$booking_id = get_misc_booking_id($row_miscellaneous_payment['misc_id'],$year);
			$customer_id = $sq_miscellaneous_info['customer_id'];
			$booking_name = "miscellaneous Booking";
			$travel_date = 'NA';
			$payment_amount = $row_miscellaneous_payment['payment_amount'] + $row_miscellaneous_payment['credit_charges'];
			$payment_mode1 = $row_miscellaneous_payment['payment_mode'];
			$transaction_id = $row_miscellaneous_payment['transaction_id'];
			$payment_date = date('d-m-Y',strtotime($row_miscellaneous_payment['payment_date']));
			$bank_name = $row_miscellaneous_payment['bank_name'];
			$receipt_type = "miscellaneous Receipt";			

			$url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&table_name=miscellaneous_payment_master&customer_field=misc_id&in_customer_id=$row_miscellaneous_payment[misc_id]";

			?>
			<tr class="<?= $bg?>">
				<td><?= $count ?></td>
				<td><?=  get_misc_booking_id($row_miscellaneous_payment['misc_id'],$year); ?></td>
				<td><?=  date('d-m-Y', strtotime($row_miscellaneous_payment['payment_date'])) ?></td>
				<td><?= $row_miscellaneous_payment['payment_mode'] ?></td>
				<td><?= $row_miscellaneous_payment['bank_name']; ?></td>
				<td><?= $row_miscellaneous_payment['transaction_id']; ?></td>
				<td class="text-right success"><?= number_format($row_miscellaneous_payment['payment_amount'] + $row_miscellaneous_payment['credit_charges'],2) ?></td>
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
			<th colspan="2" class="text-right">Total Paid : <?= number_format($sq_paid_amount,2) ?></th>
			<th colspan="2" class="warning text-right">Pending Clearance : <?= number_format($sq_pending_amount,2) ?></th>
			<th colspan="2" class="danger text-right">Cancellation Charges : <?= number_format($sq_cancel_amount,2) ?></th>
			<th colspan="1" class="success text-right">Total Payment : <?= number_format(($sq_paid_amount - $sq_pending_amount - $sq_cancel_amount),2) ?></th>
			<th class="active"></th>
		</tr>
	</tfoot>	
</table>

</div> </div> </div>

<script>
	$('#miscellaneous_payment_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>