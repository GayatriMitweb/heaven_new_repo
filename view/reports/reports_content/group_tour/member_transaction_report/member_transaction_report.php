<?php include "../../../../../model/model.php"; ?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
<table class="table trable-hover">
<thead>
<tr class="table-heading12">
    <th>S.N.</th>
    <th>Booking ID</th>
    <th>Tour Name</th>
    <th>Tour Group</th>
    <th>Date</th>
    <th>Paid For</th>
    <th>Mode</th>
    <th>Amt</th>
    <th>Bank</th>
    <th>Tran. Id</th>     
</tr>
</thead>
<tbody>
<?php

$query=" select * from tourwise_traveler_details where 1 ";

$count = 1;

$sq1 = mysql_query($query);
$bg;
$sq_pending_amount=0;
$sq_cancel_amount=0;
$sq_paid_amount=0;
$Total_payment=0;

while($row1 = mysql_fetch_assoc($sq1))
{
	$sq_tour_name = mysql_query("select tour_name from tour_master where tour_id='$row1[tour_id]'");
	$row_tour_name = mysql_fetch_assoc($sq_tour_name);
	$tour_name = $row_tour_name['tour_name'];

	$sq_tour_group_name = mysql_query("select from_date,to_date from tour_groups where group_id='$row1[tour_group_id]'");
	$row_tour_group_name = mysql_fetch_assoc($sq_tour_group_name);
	$tour_group_from = date("d-m-Y", strtotime($row_tour_group_name['from_date']));
	$tour_group_to = date("d-m-Y", strtotime($row_tour_group_name['to_date']));	


	$train_amount = 0;
	$plane_amount = 0;

	$query1 = "select * from payment_master where tourwise_traveler_id = '$row1[id]'";


	$sq2 = mysql_query($query1);
	$travel_type_arr = array();
	while($row2 = mysql_fetch_assoc($sq2))
	{

		if($row2['clearance_status']=="Pending"){ $bg='warning';
			$sq_pending_amount = $sq_pending_amount + $row2['amount'];
		}

		if($row2['clearance_status']=="Cancelled"){ $bg='danger';
			$sq_cancel_amount = $sq_cancel_amount + $row2['amount'];
		}

		if($row2['clearance_status']=="Cleared"){ $bg='success';
			$sq_paid_amount = $sq_paid_amount + $row2['amount'];
		}

		if($row2['clearance_status']==""){ $bg='';
			$sq_paid_amount = $sq_paid_amount + $row2['amount'];
		}

	?>
	<tr class="<?= $bg;?>">
		<td><?php echo $count ?></td>
		<td><?php echo get_group_booking_id($row1['id']) ?></td>
		<td><?php echo $tour_name ?></td>
		<td><?php echo $tour_group_from." to ".$tour_group_to ?></td>
		<td><?php echo $row2['date'] ?></td>
		<td><?php echo $row2['payment_for'] ?></td>		
		<td><?php echo $row2['payment_mode'] ?></td>
		<td><?php echo $row2['amount'] ?></td>
		<td><?php echo $row2['bank_name'] ?></td>
		<td><?php echo $row2['transaction_id'] ?></td>		
	</tr>	
	<?php	
		$count++;	
	}
}

?>
</tbody>
<tfoot>
	<tr class="active">
		<th colspan="3"  class="text-right"></th>
		<?php $total =  $sq_paid_amount+$sq_pending_amount+$sq_cancel_amount; ?>
		<th>Total Paid : <?= number_format($total, 2); ?></th>
		<th>-</th>

		<th>Total Pending : <?= number_format($sq_pending_amount, 2)?></th>
		<th>-</th>

		<th>Total Cancel : <?= number_format($sq_cancel_amount, 2)?></th>
		<th >=</th>
		<?php $Total_payment = $total-$sq_pending_amount-$sq_cancel_amount; ?>
		<th> Total Payment : <?= number_format($Total_payment, 2); ?></th>
	</tr>
</tfoot>	
</table>
</div>	</div> </div>
</div>
<script>
paginate_table();
</script>