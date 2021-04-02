<?php include "../../../../../model/model.php"; ?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
<table class="table trable-hover">
<thead>
<tr>
    <th>Sr No.</th>
    <th>Booking ID</th>
    <th>Booker Name</th>    
    <th>Location</th>
    <th>Traveler Name</th>
    <th>M/F</th>
    <th>DOB</th>
    <th>Seats</th>
    <th>Travel Fees</th>
    <th>Tour Fees</th>
    <th>Travel Paid</th>
    <th>Tour Paid</th>
    <th>Travel Bal</th>
    <th>Tour Bal</th>
    <th>Total Balance</th>
</tr>
</thead>
<tbody>
<?php 

$tourwise_traveler_id = $_GET['tourwise_traveler_id'];

$count=0;
$sq_tourwise_details = mysql_query("select * from tourwise_traveler_details where id='$tourwise_traveler_id'");
while($row_tourwise_details=mysql_fetch_assoc($sq_tourwise_details))
{
	$first_time = true;
	$sq_booker_info=mysql_fetch_assoc(mysql_query("SELECT * from emp_master where emp_id='$row_tourwise_details[booker_id]'"));

	$sq_total_member_count = mysql_num_rows(mysql_query("select traveler_id from travelers_details where traveler_group_id='$row_tourwise_details[traveler_group_id]'"));

	$sq_total_tour_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as total_tour_paid from payment_master where tourwise_traveler_id='$row_tourwise_details[id]' and payment_for='tour' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));

	$sq_total_travel_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as total_travel_paid from payment_master where tourwise_traveler_id='$row_tourwise_details[id]' and payment_for='traveling' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));

	$sq_traveler_det = mysql_query("select * from travelers_details where traveler_group_id='$row_tourwise_details[traveler_group_id]'");

	$sq_branch=mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_booker_info[branch_id]'"));
	while($row_traveler_det=mysql_fetch_assoc($sq_traveler_det))
	{
		$count++;
		if($row_traveler_det['gender']=="male") { $gender="M"; }
		if($row_traveler_det['gender']=="female") { $gender="F"; }
		if($row_traveler_det['status']=="Cancel") {	$text_color = "red"; }	
		else { $text_color="#000";	}	
		if($row_traveler_det['birth_date']=="") { $birth_date=""; }
		else { $birth_date=date("d-m-Y",strtotime($row_traveler_det['birth_date'])); }
	?>
		<tr style="color:<?php echo $text_color; ?>">
			<td><?php echo $count; ?></td>
			<td><?php echo get_group_booking_id($row_tourwise_details['id']); ?></td>
			<td><?= $sq_booker_info['first_name']."".$sq_booker_info['last_name']?></td>
			<td><?php echo $sq_branch['branch_name']; ?></td>
			<td><?php echo $row_traveler_det['first_name']." ".$row_traveler_det['last_name']; ?></td>
			<td><?php echo $gender ?></td>
			<td><?php echo $birth_date ?></td>
			<?php 
			if($first_time==true)
			{	
				$first_time = false;
			?>
			<td><?php echo $sq_total_member_count; ?></td>
			<td><?php echo $row_tourwise_details['total_travel_expense'] ?></td>
			<td><?php echo $row_tourwise_details['total_tour_fee'] ?></td>
			<td><?php echo $sq_total_travel_paid_amount['total_travel_paid']; ?></td>
			<td><?php echo $sq_total_tour_paid_amount['total_tour_paid']; ?></td>
			<td><?php echo number_format(($row_tourwise_details['total_travel_expense']-$sq_total_travel_paid_amount['total_travel_paid']), 2); ?></td>
			<td><?php echo number_format(($row_tourwise_details['total_tour_fee']-$sq_total_tour_paid_amount['total_tour_paid']), 2); ?></td>
			<td><?php echo number_format(($row_tourwise_details['total_travel_expense']-$sq_total_travel_paid_amount['total_travel_paid'])+($row_tourwise_details['total_tour_fee']-$sq_total_tour_paid_amount['total_tour_paid']), 2); ?></td>
			<?php 
			}
			?>
		</tr>	
	<?php	
	}	
}	

?>	
</tbody>
</table>
</div>	</div> </div>
</div>
<script>
 paginate_table();
</script>