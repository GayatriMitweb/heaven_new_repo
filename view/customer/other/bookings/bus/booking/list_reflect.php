<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
$booking_id = $_POST['booking_id'];

$query = "select * from bus_booking_master where 1 ";
if($booking_id!=""){
	$query .= " and booking_id='$booking_id'";
}
$query .= " and customer_id='$customer_id'";
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered cust_table" id="tbl_list" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Booking_Date</th>
			<th>Company_Name</th>
			<th>Seats</th>
			<th>View</th>
			<th class="text-right info">Total_Amount</th>
			<th class="text-right success">Paid_Amount</th>
			<th class="text-right danger">Cncl_amount</th>
			<th class="text-right warning">Balance</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_booking = mysql_query($query);
		while($row_booking = mysql_fetch_assoc($sq_booking)){

			$pass_count = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id='$row_booking[booking_id]'"));
			$cancel_count = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id='$row_booking[booking_id]' and status='Cancel'"));
		 	if($pass_count==$cancel_count){
   				$bg="danger";
   			}
   			else{
   				$bg="#fff";
   			}

			$date = $row_booking['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$sq_total_seates = mysql_num_rows(mysql_query("select booking_id from bus_booking_entries where booking_id='$row_booking[booking_id]'")); 

			$sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from bus_booking_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
			$sale_total_amount = $row_booking['net_total'];
			$cancel_amount = $row_booking['cancel_amount'];
			
			$paid_amount =$sq_payment_info['sum'];
			$paid_amount = ($paid_amount == '')?'0':$paid_amount;
			
			if($paid_amount > 0){
				if($pass_count==$cancel_count){
					$balance_amount = 0;
				}else{
					$balance_amount = $sale_total_amount - $paid_amount;
				}
			}else{
				if($pass_count!=$cancel_count){
					$balance_amount = $sale_total_amount - $paid_amount;
				}
				else{
					$balance_amount = $cancel_amount;
				}
			}

			$sq_entry = mysql_fetch_assoc(mysql_query("select * from bus_booking_entries where booking_id='$row_booking[booking_id]'"));
		
			$sq_customer = mysql_fetch_assoc(mysql_query("select first_name, last_name from customer_master where customer_id='$row_booking[customer_id]'"));

			//Total
			$total_amount += $sale_total_amount;
			$total_paid += $paid_amount;
			$total_cancel += $cancel_amount;
			$total_balance += $balance_amount;
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= get_bus_booking_id($row_booking['booking_id'],$year) ?></td>
				<td><?= get_date_user($row_booking['created_at']) ?></td>
				<td><?= $sq_entry['company_name'] ?></td>
				<td><?= $sq_total_seates ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="view_modal(<?= $row_booking['booking_id'] ?>)" title="View Details"><i class="fa fa-eye"></i></button>
				</td>
				<td class="text-right info"><?= $sale_total_amount ?></td>
				<td class="text-right success"><?= $paid_amount ?></td>
				<td class="text-right danger"><?= $row_booking['cancel_amount'] ?></td>
				<td class="text-right warning"><?= number_format($balance_amount,2) ?></td>
			</tr>
			<?php
		}
		?>	
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="5"></th>
			<th class="text-right">Total</th>
			<th class="text-right info"><?= number_format($total_amount,2) ?></th>
			<th class="text-right success"><?= number_format($total_paid,2) ?></th>
			<th class="text-right danger"><?=  number_format($total_cancel,2) ?></th>
			<th class="text-right warning"><?= number_format($total_balance,2) ?></th>
		</tr>
</tfoot>
</table>

</div> </div> </div>
<script type="text/javascript">
$('#tbl_list').dataTable({
	"pagingType": "full_numbers"
});
</script>
