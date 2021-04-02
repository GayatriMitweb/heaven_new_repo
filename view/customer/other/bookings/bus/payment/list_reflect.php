<?php
include "../../../../../../model/model.php";
$customer_id = $_SESSION['customer_id'];
$booking_id = $_POST['booking_id'];

?>

<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
<table class="table table-bordered cust_table" id="tbl_list" style="margin:20px 0 !important">
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
		$query = "SELECT * from bus_booking_payment_master where 1 and payment_amount!=0";		
		if($booking_id!=""){
			$query .= " and booking_id='$booking_id'";
		}
		$query .= " and booking_id in (select booking_id from bus_booking_master where customer_id='$customer_id')";

		$bg;
		$count = 0;
		$total_paid_amt=0;

		$sq_pending_amount=0;
		$sq_cancel_amount=0;
		$sq_paid_amount=0;
		$Total_payment=0;
	
		$sq_payment = mysql_query($query);		

		while($row_payment = mysql_fetch_assoc($sq_payment)){
			$count++;

			$sq_bus_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$row_payment[booking_id]'"));
			$total_sale = $sq_bus_info['net_total'];
			$sq_pay = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bus_booking_payment_master where clearance_status!='Cancelled' and booking_id='$row_payment[booking_id]'"));
			$total_pay_amt = $sq_pay['sum'];
			$outstanding =  $total_sale - $total_pay_amt;
			
			$date = $sq_bus_info['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			
			$date = $row_payment['payment_date'];
			$yr = explode("-", $date);
			$year1 =$yr[0];
			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_bus_info[customer_id]'"));
			
			$bg='';
			$sq_paid_amount = $sq_paid_amount + $row_payment['payment_amount'] + $row_payment['credit_charges'];
			if($row_payment['clearance_status']=="Pending"){ 
				$bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_payment['payment_amount'] + $row_payment['credit_charges'];
			}
			else if($row_payment['clearance_status']=="Cancelled"){ 
				$bg='danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_payment['payment_amount'] + $row_payment['credit_charges'];
			}
			$sq_travel_date = mysql_fetch_assoc(mysql_query("select * from bus_booking_entries where booking_id='$row_payment[booking_id]'"));

			$payment_id_name = "Bus Payment ID";
			$payment_id = get_bus_booking_payment_id($row_payment['payment_id'],$year1);
			$receipt_date = date('d-m-Y');
			$booking_id = get_bus_booking_id($row_payment['booking_id'],$year);
			$customer_id = $sq_bus_info['customer_id'];
			$booking_name = "Bus Booking";

			$travel_date = get_date_user($sq_travel_date['date_of_journey']);
			$payment_amount = $row_payment['payment_amount'] + $row_payment['credit_charges'];
			$payment_mode1 = $row_payment['payment_mode'];
			$transaction_id = $row_payment['transaction_id'];
			$payment_date = date('d-m-Y',strtotime($row_payment['payment_date']));
			$bank_name = $row_payment['bank_name'];
			$receipt_type = "Bus Receipt";
			
			$url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&table_name=bus_booking_payment_master&customer_field=booking_id&in_customer_id=$row_payment[booking_id]";
			?>
			<tr class="<?= $bg?>">				
				<td><?= $count ?></td>				
				<td><?= get_bus_booking_id($row_payment['booking_id'],$year); ?></td>
				<td><?= date('d-m-Y', strtotime($row_payment['payment_date'])) ?></td>
				<td><?= $row_payment['payment_mode'] ?></td>
				<td><?= $row_payment['bank_name'] ?></td>
				<td><?= $row_payment['transaction_id'] ?></td>	
				<td class="text-right success"><?= number_format($row_payment['payment_amount'] + $row_payment['credit_charges'],2) ?></td>
				<td>
					<a onclick="loadOtherPage('<?= $url1 ?>')" class="btn btn-info btn-sm" title="Download Reciept"><i class="fa fa-print"></i></a>
				</td>		
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="2"  class="text-right info">Total Paid : <?= number_format($sq_paid_amount,2) ?></th>			
			<th colspan="2" class="text-right warning">Pending Clearance : <?= number_format($sq_pending_amount,2) ?></th>		
			<th colspan="2" class="text-right danger">Cancellation Charges : <?= number_format($sq_cancel_amount,2) ?></th>			
			<th colspan="2" class="text-right success">Total Payment : <?= number_format(($sq_paid_amount - $sq_pending_amount - $sq_cancel_amount),2) ?></th>
		</tr>
	</tfoot>	
</table>

</div> </div> </div>
<script type="text/javascript">
	
$('#tbl_list').dataTable({
	"pagingType": "full_numbers"
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>