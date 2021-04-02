<?php include "../../../../../model/model.php"; ?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
<table class="table trable-hover">
<?php
$booker_id = $_GET['booker_id'];
$collection_type = $_GET['collection_type'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
?>
<thead>
<tr class="active">
	<th>S.N.</th>
	<th>Booker Name</th>
	<th>Tour</th>
	<th>Group</th>
	<th>Booking ID</th>
	<th>Transfer Date</th>
	<th>Amount</th>
	<th>Status</th>
</tr>
</thead>
<tbody>	
<?php
	$query1 = "select * from tourwise_traveler_details where  ";
	if($booker_id != '')
	{
		$query1 = $query1." booker_id='$booker_id'";
	}	
	else
	{
		$query1 = $query1." 1 ";
	}	
	$count=0;
	$total_amount=0;
	$sq1 = mysql_query($query1);
	while($row1= mysql_fetch_assoc($sq1))
	{				

		$sq = mysql_fetch_assoc(mysql_query(" select first_name, last_name from emp_master where emp_id='$row1[booker_id]' "));
		$booker_name = $sq['first_name']." ".$sq['last_name'];

		$sq = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id='$row1[tour_id]'"));
		$tour_name = $sq['tour_name'];


		$sq = mysql_fetch_assoc(mysql_query("select from_date, to_date from tour_groups where tour_id='$row1[tour_id]'"));
		$tour_group = date("d-m-Y", strtotime($sq['from_date']))." ".date("d-m-Y", strtotime($sq['to_date']));

		$query2 = "select * from payment_master where tourwise_traveler_id = '$row1[id]' and (payment_status='transffered' or   payment_status='approved') AND clearance_status!='Pending' AND clearance_status!='Cancelled' ";

		if($collection_type=='other')
		{
			$query2 = $query2." and (payment_mode='cash' or payment_mode='NEFT' or payment_mode='RTGS') ";
		}
		else if($collection_type == 'cheque')
		{
			$query2 = $query2." and payment_mode='cheque' ";	
		}
		

		if($from_date!="" && $to_date!="")
		{
  			$from_date=date("Y-m-d", strtotime($from_date));  
  			$to_date=date("Y-m-d", strtotime($to_date)); 
			
			$query2 = $query2." and (amount_transfer_date BETWEEN '$from_date' and  '$to_date') ";
		}		   



		$sq2 = mysql_query($query2);
		while($row2=mysql_fetch_assoc($sq2))
		{
			$timestamp = strtotime($row2['amount_transfer_date']);
			$amount_transfer_date = date("d-m-Y", strtotime($row2['amount_transfer_date']));
			$count++;
			$total_amount=$total_amount+$row2['amount'] ;
		?>
		<tr>
			<td><?php echo $count; ?></td>
			<td><?php echo $booker_name ?></td>
			<td><?php echo $tour_name ?></td>
			<td><?php echo $tour_group ?></td>
			<td><?php echo get_group_booking_id($row1['id']) ?></td>
			<td><?php echo $amount_transfer_date ?></td>
			<td><?php echo $row2['amount'] ?></td>
			<td><?php echo $row2['payment_status'] ?></td>
		</tr>	
		<?php	
		}
	}		

?>
</tbody>
<tfoot>
	<tr>
		<th class="active text-right" colspan="9">Total Amount : <?= number_format($total_amount,2)?></th>
		</tr>
</tfoot>
</table>
</div>	</div> </div>
</div>
<script>
paginate_table();
</script>