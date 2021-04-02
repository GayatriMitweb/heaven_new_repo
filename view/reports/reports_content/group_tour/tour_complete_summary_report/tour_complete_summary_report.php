<?php include "../../../../../model/model.php"; ?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"><div class="col-md-12 no-pad"><div class="table-responsive">
<table class="table trable-hover" id="tour_completesummary" style=" width:100% ;margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
		    <th>Sr_No</th>
		    <th>Booking_ID</th>
		    <th>Booked_By</th>    
		    <th>Branch</th>
		    <th>Passenger_Name</th>
		    <th>M/F</th>
		    <th>DOB</th>
		    <th>Seats</th>
		    <th>Travel_amount</th>
		    <th>Tour_amount</th>
		    <th>Travel_Paid</th>
		    <th>Tour_Paid</th>
		    <th>Travel_Bal</th>
		    <th>Tour_Bal</th>
		    <th>Total_Balance</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$tour_id = $_GET['tour_id'];
	$tour_group_id = $_GET['tour_group_id'];

	$count=0;
	$bg;
	$total_travel_paid=0;
	$total_tour_paid=0;
	$totl_bal=0;

	$query1 = "select * from tourwise_traveler_details where 1 ";
	if(isset($_GET['tour_id']))
	{
		$tour_id = $_GET['tour_id'];
		$tour_group_id = $_GET['tour_group_id'];
		if($tour_id!="")
		{
			$query1 = $query1." and tour_id='$tour_id' ";
			if($tour_group_id!="")
			{
				$query1 = $query1." and tour_group_id='$tour_group_id' ";
			}	
			else
			{
				$query1 = $query1." )";
			}	
		}	
	}
    $sq_tourwise_details = mysql_query($query1);
	while($row_tourwise_details=mysql_fetch_assoc($sq_tourwise_details))
	{
		$first_time = true;
		$sq_booker_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_tourwise_details[emp_id]'"));
		if($sq_booker_info['first_name'] != ''){ $booker_name = $sq_booker_info['first_name']." ".$sq_booker_info['last_name'];
		}
		else{  $booker_name = 'Admin';}
		$sq_total_member_count = mysql_num_rows(mysql_query("select traveler_id from travelers_details where traveler_group_id='$row_tourwise_details[traveler_group_id]'"));

		$sq_total_tour_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as total_tour_paid from payment_master where tourwise_traveler_id='$row_tourwise_details[id]' and payment_for='Tour' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

		$sq_total_travel_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as total_travel_paid from payment_master where tourwise_traveler_id='$row_tourwise_details[id]' and payment_for='Travelling' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

		$sq_branch_name = mysql_fetch_assoc(mysql_query("SELECT * from branches where branch_id='$sq_booker_info[branch_id]'"));

		$sq_traveler_det = mysql_query("select * from travelers_details where traveler_group_id='$row_tourwise_details[traveler_group_id]'");
		while($row_traveler_det=mysql_fetch_assoc($sq_traveler_det))
		{
			$count++;
			if($row_traveler_det['status']=="Cancel") {	$text_color = "red"; }	
			else { $text_color="#000";	}	
			if($row_traveler_det['birth_date']=="") { $birth_date=""; }
			else { $birth_date=date("d-m-Y",strtotime($row_traveler_det['birth_date'])); }

			($row_traveler_det['status']=='Cancel')?$bg='danger':$bg='';
		?>
			<tr>
				<td style="color:<?php echo $text_color; ?>" class="<?= $bg?>"><?php echo $count; ?></td>
				<td style="color:<?php echo $text_color; ?>" class="<?= $bg?>"><?php echo get_group_booking_id($row_tourwise_details['id']); ?></td>
				<td style="color:<?php echo $text_color; ?>" class="<?= $bg?>"><?php echo $booker_name; ?></td>
				<td style="color:<?php echo $text_color; ?>" class="<?= $bg?>"><?php echo ($sq_branch_name['branch_name'] =='')?'NA':$sq_branch_name['branch_name']; ?></td>
				<td style="color:<?php echo $text_color; ?>" class="<?= $bg?>"><?php echo $row_traveler_det['first_name']." ".$row_traveler_det['last_name']; ?></td>
				<td style="color:<?php echo $text_color; ?>" class="<?= $bg?>"><?php echo $row_traveler_det['gender']; ?></td>
				<td style="color:<?php echo $text_color; ?>" class="<?= $bg?>"><?php echo $birth_date ?></td>
				<?php 
				if($first_time==true)
				{	
					$first_time = false;
					$total_travel_paid = $total_travel_paid + $sq_total_travel_paid_amount['total_travel_paid'];
					$total_tour_paid = $total_tour_paid + $sq_total_tour_paid_amount['total_tour_paid'];
					$totl_bal= $totl_bal+(($row_tourwise_details['total_travel_expense']-$sq_total_travel_paid_amount['total_travel_paid'])+($row_tourwise_details['total_tour_fee']-$sq_total_tour_paid_amount['total_tour_paid']));
				?>
				<td><?php echo $sq_total_member_count; ?></td>
				<td><?php echo $row_tourwise_details['total_travel_expense'] ?></td>
				<td><?php echo $row_tourwise_details['total_tour_fee'] ?></td>
				<td><?php echo ($sq_total_travel_paid_amount['total_travel_paid'] =='')?'0.00':$sq_total_travel_paid_amount['total_travel_paid']; ?></td>
				<td><?php echo ($sq_total_tour_paid_amount['total_tour_paid'] =='')?'0.00':$sq_total_tour_paid_amount['total_tour_paid']; ?></td>
				<td><?php echo number_format(($row_tourwise_details['total_travel_expense']-$sq_total_travel_paid_amount['total_travel_paid']), 2); ?></td>
				<td><?php echo number_format(($row_tourwise_details['total_tour_fee']-$sq_total_tour_paid_amount['total_tour_paid']), 2); ?></td>
				<td><?php echo number_format(($row_tourwise_details['total_travel_expense']-$sq_total_travel_paid_amount['total_travel_paid'])+($row_tourwise_details['total_tour_fee']-$sq_total_tour_paid_amount['total_tour_paid']), 2)?></td>
				<?php 
				}
				?>
			</tr>	
		<?php	
		}	
	}	

	?>	
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="4" class="info text-right">Total Travel Paid : <?= number_format($total_travel_paid, 2) ?> </th>
			<th colspan="4" class="warning text-right">Total Tour Paid : <?= number_format($total_tour_paid, 2) ?> </th>
			<th colspan="3" class="success text-right">Total Balance : <?= number_format($totl_bal, 2)?></th>
			<th colspan="4"></th>
		</tr>
	</tfoot>
</table>
</div> </div> </div>
</div>
<script>
	paginate_table();
</script>
 
