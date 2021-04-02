<?php 
include "../../../../../../model/model.php";
$ticket_id = $_POST['ticket_id'];
$customer_id = $_SESSION['customer_id'];
?>

<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">

	

<table class="table table-bordered cust_table" id="train_ticket_list" style="margin:20px 0 !important;">

	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Train_No</th>
			<th>Travel_Date/Time</th>
			<th>Status</th>
			<th>View</th>	
			<th class="text-right info">Total_Amount</th>
			<th class="text-right success">Paid_Amount</th>
			<th class="text-right danger">Cncl_amount</th>
			<th class="text-right warning">Balance</th>	
		</tr>
	</thead>

	<tbody>

		<?php 

		$query = "select * from train_ticket_master where 1";
		$query .= " and customer_id='$customer_id'";
		if($ticket_id!=""){
			$query .= " and train_ticket_id='$ticket_id'";
		}



		$count = 0;

		$available_bal=0;
		$pending_bal=0;

		$sq_ticket = mysql_query($query);

		while($row_ticket = mysql_fetch_assoc($sq_ticket)){

			$date = $row_ticket['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$pass_count = mysql_num_rows(mysql_query("select * from  train_ticket_master_entries where train_ticket_id='$row_ticket[train_ticket_id]'"));
			$cancel_count = mysql_num_rows(mysql_query("select * from  train_ticket_master_entries where train_ticket_id='$row_ticket[train_ticket_id]' and status='Cancel'"));
			if($pass_count==$cancel_count) 	{
				$bg="danger";
			}
			else  {
				$bg="#fff";
			}
			
			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
			$sq_train_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master_trip_entries where train_ticket_id='$row_ticket[train_ticket_id]'"));

			$total_paid_amount += $sq_payment['sum_pay'];
			$sale_total_amount = $row_ticket['net_total'];
			$cancel_amount = $row_ticket['cancel_amount'];

			$sq_payment = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum_pay from train_ticket_payment_master where train_ticket_id='$row_ticket[train_ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

			$paid_amount = $sq_payment['sum_pay'];
			$paid_amount = ($paid_amount == '')?'0':$paid_amount;

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
			?>	
			
			<tr class="<?= $bg ?>">

				<td><?= ++$count ?></td>

				<td><?= get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year) ?></td>

				<td><?=  $sq_train_info['train_no']; ?></td>

				<td><?= get_datetime_user($sq_train_info['travel_datetime']); ?></td>

				<td><?= $sq_train_info['ticket_status']; ?></td>		
				<td>
					<button class="btn btn-info btn-sm" onclick="train_ticket_view_modal(<?= $row_ticket['train_ticket_id'] ?>)" title="View Details"><i class="fa fa-eye"></i></button>
				</td>
				<td class="text-right info"><?= $sale_total_amount ?></td>
				<td  class="text-right success"><?= number_format($paid_amount,2) ?></td>
				<td class="text-right danger"><?= $cancel_amount ?></td>
				<td class="text-right warning"><?= number_format($balance_amount,2)?></td>		
			</tr>

			<?php

		}

		?>

	</tbody>
	<tfoot>
		<tr>
			<th colspan="6" class="text-right">Total</th>
			<th class="active text-right info"><?= number_format($total_amount,2);?></th>
			<th class="active text-right success"><?= number_format($total_paid,2);?></th>
			<th class="active text-right danger"><?= number_format($total_cancel,2);?></th>
			<th class="active text-right warning"><?= number_format(($total_balance),2);?></th>
		</tr>
	</tfoot>

</table>
</div> </div> </div>
<script>
$('#train_ticket_list').dataTable({
	"pagingType": "full_numbers"
});
</script>