<?php
include "../../../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$customer_id = $_SESSION['customer_id'];

$sq_car_rental_info = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$booking_id'"));

$sq_payment_info = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from car_rental_payment where booking_id='$booking_id' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));

$sq_refund_info = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from car_rental_refund_master where booking_id='$booking_id' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));

$sq_refund_pen_info = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from car_rental_refund_master where booking_id='$booking_id' and clearance_status='Pending'"));


$sale_amount = $sq_car_rental_info['total_fees'] - $sq_car_rental_info['total_refund_amount'];

$paid_amount = $sq_payment_info['sum'];

$bal_amount = $paid_amount - $sale_amount;

$total_refund1 = $bal_amount - $sq_refund_info['sum'];


?>

<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered cust_table" id="tbl_refund_list" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Refund_Date</th>
			<th>Bank_Name</th>
			<th>Mode</th>
			<th>Cheque_No/ID</th>
			<th class="text-right success">Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = 0;
		$query = "select * from car_rental_refund_master where 1";
		if($booking_id!=""){
			$query .=" and booking_id='$booking_id'";
		}
		$query .=" and booking_id in (select booking_id from car_rental_booking where customer_id='$customer_id')";
		$count = 0;
		$bg;
		$sq_pending_amount=0;
		$sq_paid_amount=0;
		$canceled_refund = 0;
		$sq_car_rental_refund = mysql_query($query);
		while($row_car_rental_refund = mysql_fetch_assoc($sq_car_rental_refund)){

			$count++;
			$date = $row_car_rental_refund['refund_date'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$total_refund = $total_refund+$row_car_rental_refund['refund_amount'];

			$sq_car_rental_info = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$row_car_rental_refund[booking_id]'"));
			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_car_rental_info[customer_id]'"));

			if($row_car_rental_refund['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_car_rental_refund['refund_amount'];
			}

			if($row_car_rental_refund['clearance_status']=="Cleared"){ $bg='success';
				$sq_paid_amount = $sq_paid_amount + $row_car_rental_refund['refund_amount'];
			}
			if($row_car_rental_refund['clearance_status']=="Cancelled"){ 
				$bg = "danger"; 
				$canceled_refund = $canceled_refund + $row_car_rental_refund['refund_amount'];
			}
			if($row_car_rental_refund['clearance_status']==""){ $bg='';
				$sq_paid_amount = $sq_paid_amount + $row_car_rental_refund['refund_amount'];
			}

			$sq_car_rental_info = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$row_car_rental_refund[booking_id]'"));
			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_car_rental_info[customer_id]'"));

			?>
			<tr class="<?= $bg;?>">			
				<td><?= $count ?></td>
				<td><?= get_car_rental_booking_id($row_car_rental_refund['booking_id'],$year); ?></td>
				<td><?= date('d-m-Y', strtotime($row_car_rental_refund['refund_date'])) ?></td>
				<td><?= $row_car_rental_refund['bank_name'] ?></td>
				<td><?= $row_car_rental_refund['refund_mode'] ?></td>
				<td><?= $row_car_rental_refund['transaction_id'] ?></td>
				<td class="text-right success"><?= $row_car_rental_refund['refund_amount'] ?></td>			
			</tr>
			<?php
		}
		?>
	</tbody>	
	<tfoot>
		<tr class="active">
			<th colspan="1" class="text-right info">Refund: <?= ($total_refund=='')?number_format(0,2): number_format($total_refund,2); ?></th>
			<th colspan="2" class="text-right warning">Pending : <?= ($sq_pending_amount=='')?number_format(0,2): number_format($sq_pending_amount,2);?></th>
			<th colspan="2" class="text-right danger">Cencelled: <?= ($canceled_refund=='')?number_format(0,2): number_format($canceled_refund,2); ?></th>
			<th colspan="2" class="text-right success">Total: <?= number_format(($total_refund-$sq_pending_amount- $canceled_refund),2);?></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>
<script>
$('#tbl_refund_list').dataTable({
	"pagingType": "full_numbers"
});
</script>