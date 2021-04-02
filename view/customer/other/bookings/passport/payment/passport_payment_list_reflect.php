<?php
include "../../../../../../model/model.php";

$passport_id = $_POST['passport_id'];
$customer_id = $_SESSION['customer_id'];
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered bg_white cust_table" id="tbl_passport_payment" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>Sr. No</th>
			<th>Booking_ID</th>
			<th>Payment_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th  class="text-right success">Amount</th>
			<th>Receipt</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$query = "select * from passport_payment_master where 1";		
		if($passport_id!=""){
			$query .= " and passport_id='$passport_id'";
		}		
		$query .= " and passport_id in (select passport_id from passport_master where customer_id='$customer_id')";
		$count = 0;
		$bg;
		$sq_pending_amount = 0;
		$sq_cancel_amount = 0;
		$sq_paid_amount = 0;

		$sq_passport_payment = mysql_query($query);
		while($row_passport_payment = mysql_fetch_assoc($sq_passport_payment)){
			if($row_passport_payment['payment_amount'] != '0'){
			$count++;

			$date = $row_passport_payment['payment_date'];
			$yr = explode("-", $date);
			$year1 =$yr[0];
			$sq_passport_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$row_passport_payment[passport_id]'"));
			$sq_pay = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum,sum(credit_charges) as sumc from passport_payment_master where clearance_status!='Cancelled' and clearance_status!='Pending' and passport_id='$row_passport_payment[passport_id]'"));
		
			$total_sale = $sq_passport_info['passport_total_cost']+$sq_pay['sumc'];
			$total_pay_amt = $sq_pay['sum']+$sq_pay['sumc'];
			$outstanding =  $total_sale - $total_pay_amt;

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_passport_info[customer_id]'"));

			($row_passport_payment['clearance_status']=="Cleared")?$bg='success':$bg="";

			if($row_passport_payment['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_passport_payment['payment_amount']+$row_passport_payment['credit_charges'];
			}

			if($row_passport_payment['clearance_status']=="Cancelled"){ $bg='danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_passport_payment['payment_amount']+$row_passport_payment['credit_charges'];
			}

			$total = $total + $row_passport_payment['payment_amount']+$row_passport_payment['credit_charges'];
			$date = $sq_passport_info['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$payment_id_name = "Passport Payment ID";
			$payment_id = get_passport_booking_payment_id($row_passport_payment['payment_id'],$year);
			$receipt_date = date('d-m-Y');
			$booking_id = get_passport_booking_id($row_passport_payment['passport_id'],$year1);
			$customer_id = $sq_passport_info['customer_id'];
			$booking_name = "Passport Booking";
			$travel_date = 'NA';
			$payment_amount = $row_passport_payment['payment_amount']+$row_passport_payment['credit_charges'];
			$payment_mode1 = $row_passport_payment['payment_mode'];
			$transaction_id = $row_passport_payment['transaction_id'];
			$payment_date = date('d-m-Y',strtotime($row_passport_payment['payment_date']));
			$bank_name = $row_passport_payment['bank_name'];
			$receipt_type = "Passport Receipt";

			$url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&table_name=passport_payment_master&customer_field=passport_id&in_customer_id=$row_passport_payment[passport_id]";
			?>
			<tr class="<?= $bg?>">				
				<td><?= $count ?></td>
				<td><?= get_passport_booking_id($row_passport_payment['passport_id'],$year1) ?></td>
				<td><?= date('d-m-Y', strtotime($row_passport_payment['payment_date'])) ?></td>
				<td><?= $row_passport_payment['payment_mode'] ?></td>
				<td><?= $row_passport_payment['bank_name'] ?></td>
				<td><?= $row_passport_payment['transaction_id'] ?></td>	
				<td  class="text-right success"><?= $row_passport_payment['payment_amount'] ?></td>
				<td>
					<a onclick="loadOtherPage('<?= $url1 ?>')" class="btn btn-info btn-sm" title="Download Receipt"><i class="fa fa-print"></i></a>
				</td>			
			</tr>
			<?php
				}
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="2" class="text-right info">Paid Amount: <?= number_format($total,2); ?></th>
			<th colspan="2" class="text-right warning">Pending Clearance : <?= number_format($sq_pending_amount,2)?></th>
			<th colspan="2" class="text-right danger">Cancellation Charges : <?= number_format($sq_cancel_amount,2)?></th>
			<th colspan="2" class="text-right success">Payment Amount: <?= number_format(($total-$sq_pending_amount-$sq_cancel_amount),2);?></th>
		</tr>
	</tfoot>		
</table>

</div> </div> </div>
<script type="text/javascript">
	
$('#tbl_passport_payment').dataTable({
	"pagingType": "full_numbers"
});
</script>
