<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
$train_ticket_id = $_POST['ticket_id'];

?>

<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
<table class="table table-bordered cust_table" id="table_train" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Payment_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>			
			<th class="text-right success">Amount</th>
			<th>Receipt</th>			
		</tr>
	</thead>
	<tbody>
		<?php 
		$query = "select * from train_ticket_payment_master where payment_amount!=0 ";	
		if($train_ticket_id!=""){

			$query .= " and train_ticket_id='$train_ticket_id'";

		}		
		if($customer_id!=""){

			$query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where customer_id='$customer_id')";

		}
		

		$count = 0;
		$bg;

		$sq_pending_amount=0;
		$sq_cancel_amount=0;
		$sq_paid_amount=0;
		$Total_payment=0;

		$sq_train_ticket_payment = mysql_query($query);

		while($row_train_ticket_payment = mysql_fetch_assoc($sq_train_ticket_payment)){
			$date = $row_train_ticket_payment['payment_date'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$count++;
			$sq_train_ticket_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$row_train_ticket_payment[train_ticket_id]'"));
			$total_sale = $sq_train_ticket_info['net_total'];
			$sq_pay = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from train_ticket_payment_master where clearance_status!='Cancelled' and train_ticket_id='$row_train_ticket_payment[train_ticket_id]'"));
			$total_pay_amt = $sq_pay['sum'];
			$outstanding =  $total_sale - $total_pay_amt;

			$sq_depa_date = mysql_fetch_assoc(mysql_query("select * from train_ticket_master_trip_entries where train_ticket_id='$row_train_ticket_payment[train_ticket_id]'"));
			$date = $sq_train_ticket_info['created_at'];
			$yr = explode("-", $date);
			$year1 =$yr[0];

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_train_ticket_info[customer_id]'"));

			($row_train_ticket_payment['clearance_status']=="Cleared")?$bg='success':$bg="";

			if($row_train_ticket_payment['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_train_ticket_payment['payment_amount'] + $row_train_ticket_payment['credit_charges'];
			}

			else if($row_train_ticket_payment['clearance_status']=="Cancelled"){ $bg='danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_train_ticket_payment['payment_amount'] + $row_train_ticket_payment['credit_charges'];
			}
			 
			$sq_paid_amount = $sq_paid_amount + $row_train_ticket_payment['payment_amount'] + $row_train_ticket_payment['credit_charges'];
		 
			$payment_id_name = "Train Ticket Payment ID";
			$payment_id = get_train_ticket_booking_payment_id($row_train_ticket_payment['payment_id'],$year);
			$receipt_date = date('d-m-Y');
			$booking_id = get_train_ticket_booking_id($row_train_ticket_payment['train_ticket_id'],$year1);
			$customer_id = $sq_train_ticket_info['customer_id'];
			$booking_name = "Train Ticket Booking";
			$travel_date = date('d-m-Y',strtotime($sq_depa_date['travel_datetime']));;
			$payment_amount = $row_train_ticket_payment['payment_amount'] + $row_train_ticket_payment['credit_charges'];
			$payment_mode1 = $row_train_ticket_payment['payment_mode'];
			$transaction_id = $row_train_ticket_payment['transaction_id'];
			$payment_date = date('d-m-Y',strtotime($row_train_ticket_payment['payment_date']));
			$bank_name = $row_train_ticket_payment['bank_name'];
			$receipt_type ="Train Ticket Receipt";
			
			$url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&table_name=train_ticket_payment_master&customer_field=train_ticket_id&in_customer_id=$row_train_ticket_payment[train_ticket_id]";

			?>

			<tr class="<?= $bg?>">			

				<td><?= $count ?></td>

				<td><?= get_train_ticket_booking_id($row_train_ticket_payment['train_ticket_id'],$year1) ?></td>
				<td><?= date('d-m-Y', strtotime($row_train_ticket_payment['payment_date'])) ?></td>
				<td><?= $row_train_ticket_payment['payment_mode'] ?></td>
				<td><?= $row_train_ticket_payment['bank_name'] ?></td>
				<td><?= $row_train_ticket_payment['transaction_id'] ?></td>
				<td class="text-right success"><?= number_format($row_train_ticket_payment['payment_amount'] + $row_train_ticket_payment['credit_charges'],2) ?></td>
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
			<th colspan="2" class="active text-right success">Paid Amount : <?= number_format($sq_paid_amount,2); ?></th>
			<th colspan="2" class="active text-right info">Pending Clearance: <?= number_format($sq_pending_amount,2)?></th>
			<th colspan="2" class="active text-right danger">Cancellation Charges : <?= number_format($sq_cancel_amount,2)?></th>
			<th colspan="2" class="active text-right warning">Total Payment : <?=  number_format(($sq_paid_amount - $sq_pending_amount-$sq_cancel_amount),2); ?></th>
		</tr>
	</tfoot>	

</table>



</div> </div> </div>
<script type="text/javascript">
$('#table_train').dataTable({
	"pagingType": "full_numbers"
});
</script>

