<?php include "../../../../../model/model.php"; ?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
<table class="table trable-hover" id="payment">
<thead>
<tr class="table-heading12">
    <th>S.N.</th>
    <th>Tour Name</th>
    <th>Tour Group</th>
    <th>Booking ID</th>
    <th>Total Train Amount</th>
    <th>Cancelation Train Amount</th>
    <th>Total Train Sale</th>
    <th>Total Paid</th>
    <th>Total Air Amount</th>
    <th>Cancelation Air Amount</th>
    <th>Total Air Sale</th>
    <th>Total Paid</th>
    <th>Both Paid</th>
    <th>Total Balance</th>  
</tr>
</thead>
<tbody>
<?php
$count = 1;
$avalable_bal=0;
$pending_refund=0;
$sq1 = mysql_query("select * from tourwise_traveler_details where tour_group_status!='Cancel'");
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

	$sq_cancel_amt = mysql_fetch_assoc(mysql_query("select * from refund_traveler_estimate where tourwise_traveler_id='$row1[id]'"));
	$total_train_sale= $row1['total_train_expense'] - $sq_cancel_amt['total_train_amount'];
	$total_plane_sale= $row1['total_plane_expense'] - $sq_cancel_amt['total_plane_amount'];

	$sq_pay_train=mysql_fetch_assoc(mysql_query("SELECT sum(amount) as sum from payment_master where tourwise_traveler_id = '$row1[id]' and travel_type='train' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$sq_pay_air=mysql_fetch_assoc(mysql_query("SELECT sum(amount) as sum from payment_master where tourwise_traveler_id = '$row1[id]' and travel_type='air' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$sq_pay_both=mysql_fetch_assoc(mysql_query("SELECT sum(amount) as sum from payment_master where tourwise_traveler_id = '$row1[id]' and travel_type='both' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	/*$query1 = "select * from payment_master where tourwise_traveler_id = '$row1[id]' and payment_for = 'traveling' ";
	if($traveling_type!="")
	{
		$query1 = $query1." and travel_type = '$traveling_type' ";
	}	
	else
	{
		$query1 = $query1." and 1 ";
	}*/

	$sq2 = mysql_query($query1);
	$travel_type_arr = array();
	//while($row2 = mysql_fetch_assoc($sq2))
	//{
		
		$total_bal=(($total_train_sale-$sq_pay_train['sum'])+($total_plane_sale-$sq_pay_air['sum']))- $sq_pay_both['sum'];

	?>
	<tr>
		<td><?php echo $count; ?></td>
		<td><?= $tour_name;?></td>		
		<td><?php echo $tour_group_from."".$tour_group_to; ?></td>
		<td><?php echo get_group_booking_id($row1['id']) ?></td>
		<td><?php echo $row1['total_train_expense']; ?></td>
		<td><?php echo $sq_cancel_amt['total_train_amount']; ?></td>
		<td><?php echo number_format($total_train_sale, 2); ?></td>
		<td><?php echo $sq_pay_train['sum'];?></td>
		<td><?php echo $row1['total_plane_expense'] ;?></td>
		<td><?php echo $sq_cancel_amt['total_plane_amount'] ;?></td>
		<td><?php echo number_format($total_plane_sale, 2); ?></td>
		<td><?= $sq_pay_air['sum']?></td>
		<td><?= $sq_pay_both['sum']?></td>
		<td class="success"><?php //echo ($bal >=0 ? $bal : 0);
					if($total_bal>=0)
					{						 
						$avalable_bal=$avalable_bal+$total_bal;
					}else
					{
						$pending_refund =$pending_refund+($total_bal);
					}

					echo $total_bal;?></td>		
	</tr>	
	<?php	
		$count++;	
	//}
}
?>
</tbody>
<tfoot>
	<tr class="active">
		<th colspan="9" class="text-right">Pending Refund : <?= number_format($pending_refund, 2);?></th>

		<th colspan="5" class="text-right">Available Balance : <?= number_format($avalable_bal, 2)?></th>
	</tr>
</tfoot>
</table>
</div>	</div> </div>
</div>
<script>
//paginate_table();
$('#payment').dataTable({
		"pagingType": "full_numbers"
	});
</script>