<?php 
include "../../../../../../model/model.php";

$exc_id = $_POST['exc_id'];
$customer_id = $_SESSION['customer_id'];
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">

<table class="table table-bordered bg_white cust_table" id="tbl_exc_list" style="margin:20px 0 !important">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>View</th>
			<th class="text-right info">Total Amount</th>
			<th class="text-right success">Paid Amount</th>
			<th class="text-right danger">Cancellation Charges</th> 
			<th class="text-right warning">Balance</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$query = "select * from excursion_master where 1 ";
		$query .= " and customer_id='$customer_id'";
		if($exc_id != ''){
			$query .= " and exc_id='$exc_id'";
		}
		$count = 0;
		$booking_amount = 0;
		$cancelled_amount = 0;
		$total_amount = 0;

		$sq_exc = mysql_query($query);
		while($row_exc = mysql_fetch_assoc($sq_exc)){

			$pass_count = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$row_exc[exc_id]'"));
			$cancel_count = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$row_exc[exc_id]' and status='Cancel'"));
			if($pass_count==$cancel_count){
				$bg="danger";
			}
			else {
				$bg="#fff";
			}

			$date = $row_exc['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_exc[customer_id]'"));

           //Get Total exc cost
            $sale_total_amount=$row_exc['exc_total_cost'];
			if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

			$cancel_amount=$row_exc['cancel_amount'];
			$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from exc_payment_master where exc_id='$row_exc[exc_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
			$paid_amount = $query['sum'];
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
			<tr class="<?=$bg?>">
				<td><?= ++$count ?></td>
				<td><?= get_exc_booking_id($row_exc['exc_id'],$year) ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="exc_display_modal(<?= $row_exc['exc_id'] ?>)" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></button>
				</td>
				<td class="info text-right"><?php echo $sale_total_amount; ?></td>
				<td class="success text-right"><?= $paid_amount ?></td>
				<td class="danger text-right"><?php echo $cancel_amount; ?></td>
				<td class="warning text-right"><?php echo number_format($balance_amount,2); ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr>
		    <th colspan="3" class="text-right active">Total</th>		    
			<th class="info text-right"><?php echo number_format($total_amount,2); ?></th>
			<th class="success text-right"><?php echo number_format($total_paid,2); ?></th>
			<th class="danger text-right"><?php echo number_format($total_cancel,2); ?></th>
			<th class="warning text-right"><?php echo number_format($total_balance,2); ?></th>
		</tr>
	</tfoot>
</table>
</div> </div> </div>
<script>
$('#tbl_exc_list').dataTable({
	"pagingType": "full_numbers"
});
</script>