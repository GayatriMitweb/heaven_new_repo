<?php 
include "../../../../../../model/model.php";
$customer_id = $_SESSION['customer_id'];
$passport_id = $_POST['passport_id'];
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered cust_table bg_white" id="tbl_passport_list" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Total_guest</th>
			<th>view</th>
			<th class="text-right info">Total_Amount</th>
			<th class="text-right success">Paid_Amount</th>
			<th class="text-right danger">Cncl_amount</th>
			<th class="text-right warning">Balance</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$query = "select * from passport_master where 1 ";
		$query .= " and customer_id='$customer_id'";
		if($passport_id!=""){
			$query .= " and passport_id='$passport_id'";
		}
		
		$count = 0;
		$sq_passport = mysql_query($query);
		while($row_passport = mysql_fetch_assoc($sq_passport)){

			$pass_count = mysql_num_rows(mysql_query("select * from  passport_master_entries where passport_id='$row_passport[passport_id]'"));
			$cancel_count = mysql_num_rows(mysql_query("select * from  passport_master_entries where passport_id='$row_passport[passport_id]' and status='Cancel'"));
			if($pass_count==$cancel_count){
				$bg="danger";
			}
			else {
				$bg="#fff";
			}
			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_passport[customer_id]'"));			
			$date = $row_passport['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from passport_payment_master where passport_id='$row_passport[passport_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			//Get Total no of passport members
            $sq_total_member=mysql_num_rows(mysql_query("select passport_id from passport_master_entries where passport_id='$row_passport[passport_id]' and status!='Cancel'")); 

			//Get Total passport cost
            $sale_total_amount=$row_passport['passport_total_cost'];

			$cancel_amount=$row_passport['cancel_amount'];
			$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from passport_payment_master where passport_id='$row_passport[passport_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
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
				<td><?= get_passport_booking_id($row_passport['passport_id'],$year) ?></td>
				<td><?= $sq_total_member ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="passport_view_modal(<?= $row_passport['passport_id'] ?>)" title="View Details"><i class="fa fa-eye"></i></button>
				</td>
				<td class="text-right info"><?= $row_passport['passport_total_cost'] ?></td>
				<td class="text-right success"><?= number_format($paid_amount,2) ?></td>
				<td class="text-right danger"><?= number_format($cancel_amount,2)?></td>
				<td class="text-right warning"><?= number_format($balance_amount,2)?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr>
		    <th colspan="4" class="text-right active">Total</th>		    
			<th class="info text-right"><?php echo number_format($total_amount,2); ?></th>
			<th class="success text-right"><?php echo number_format($total_paid,2); ?></th>
			<th class="danger text-right"><?php echo number_format($total_cancel,2); ?></th>
			<th class="warning text-right"><?php echo number_format($total_balance,2); ?></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>
<script type="text/javascript">
$('#tbl_passport_list').dataTable({
	"pagingType": "full_numbers"
});
</script>