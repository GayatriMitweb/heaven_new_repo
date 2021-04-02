<?php include "../../../../../model/model.php"; ?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
<table class="table trable-hover">
<thead>
<tr class="active">
		<th>Sr. No.</th>
		<th>Tour Name</td>
		<th>Tour Group</th>
		<th>Booking ID</td>
		<th>Total Tour Amount</th>
		<th>Tour amount Paid</td>
		<th>Pending Tour amount</th>
		<th>Total Travel Amount</th>
		<th>Travel Amount Paid</th>
		<th>Pending Travel Amount</th>
</tr>	
</thead>
<tbody>
<?php



$booker_id = $_GET['booker_id'];
$tour_id = $_GET['tour_id'];
$tour_group_id = $_GET['tour_group_id'];


$total_tour_amount = 0;
$total_travel_amount = 0;
$count=1;



$query = "select * from tourwise_traveler_details where ";

if($booker_id!="")
{
	$query = $query." booker_id='$booker_id'";
}
else
{
	$query = $query." 1 ";
}	

if($tour_id!="")
{
	$query = $query." and tour_id='$tour_id'";
}
else
{
	$query = $query." and 1 ";
}	

if($tour_group_id!="")
{
	$query = $query." and tour_group_id='$tour_group_id'";
}
else
{
	$query = $query." and 1 ";
}	


$query = $query." and tour_group_status!='Cancel' ";


$sq1 = mysql_query($query);
while($row1 = mysql_fetch_assoc($sq1))
{
	$total_tour_amount = $row1['total_tour_fee'];
	$total_travel_amount = $row1['total_travel_expense'];
	$paid_tour_amount = 0;
	$paid_travel_amount = 0;


	$sq2 = mysql_query("select * from payment_master where tourwise_traveler_id='$row1[id]' AND clearance_status!='Pending' AND clearance_status!='Cancelled'");
	while($row2 = mysql_fetch_assoc($sq2))
	{
		$payment_for = $row2['payment_for'];
		if($payment_for == "tour")
		{	
			$paid_tour_amount = $paid_tour_amount + $row2['amount'];
		}

		if($payment_for == "traveling")
		{	
			$paid_travel_amount = $paid_travel_amount + $row2['amount'];
		}		
	}


	$sq3 = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id='$row1[tour_id]'"));
	$tour_name = $sq3['tour_name'];

	$sq3 = mysql_fetch_assoc(mysql_query("select from_date, to_date from tour_groups where group_id='$row1[tour_group_id]'"));

	$tour_from = date("d-m-Y", strtotime($sq3['from_date']));
	$tour_to= date("d-m-Y", strtotime($sq3['to_date']));

	$pending_tour_fee = $total_tour_amount-$paid_tour_amount;
	$pending_travel_fee = $total_travel_amount-$paid_travel_amount;

	?>
	<tr>
		<td><?php echo $count ?></td>
		<td><?php echo $tour_name ?></td>		
		<td><?php echo $tour_from." to ".$tour_to ?></td>
		<td><?php echo get_group_booking_id($row1['id']) ?></td>
		<td><?php echo $total_tour_amount ?></td>
		<td><?php echo $paid_tour_amount ?></td>
		<td><?php echo $pending_tour_fee ?></td>
		<td><?php echo $total_travel_amount ?></td>
		<td><?php echo $paid_travel_amount ?></td>
		<td><?php echo $pending_travel_fee ?></td>
	</tr>	
	<?php
	$count++;
}

?>
</thead>
</table>
</div>	</div> </div>
</div>
<script>
paginate_table();
</script>