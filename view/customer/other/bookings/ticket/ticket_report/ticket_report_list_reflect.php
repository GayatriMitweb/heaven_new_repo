<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
$ticket_id = $_POST['ticket_id'];

$query = "select * from ticket_trip_entries where 1 ";
if($ticket_id!=""){
	$query .=" and ticket_id='$ticket_id'";	
}
if($customer_id!=""){
	$query .=" and ticket_id in ( select ticket_id from ticket_master where customer_id='$customer_id' )";	
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">

<table class="table table-bordered cust_table bg_white" id="tbl_ticket_report" style="margin:20px 0 !important">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Departure_Date&Time</th>
			<th>Arrival_Date&Time</th>
			<th>Airline</th>
			<th>Class</th>
			<th>Flight_No.</th>
			<th>Airline_PNR</th>
			<th>Sector(From_To)</th>
			<th>Ticket</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		
		$sq_trip = mysql_query($query);	
		while($row_trip = mysql_fetch_assoc($sq_trip)){
			$sq_tickets = mysql_fetch_assoc(mysql_query("select * from ticket_master_upload_entries where ticket_id='$ticket_id'"));

			$url = $sq_tickets['ticket_url'];
			$url = explode('uploads/', $url);
			$url = BASE_URL.'uploads/'.$url[1];

			$sq_ticket = mysql_fetch_assoc(mysql_query("select customer_id from ticket_master where ticket_id='$row_trip[ticket_id]'"));
			
			$date = $sq_ticket['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_ticket[customer_id]'"));
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= get_ticket_booking_id($row_trip['ticket_id'],$year) ?></td>
				<td><?=  date('d/m/Y H:i:s', strtotime($row_trip['departure_datetime'])) ?></td>
				<td><?= date('d/m/Y H:i:s', strtotime($row_trip['arrival_datetime'])) ?></td>
				<td><?= $row_trip['airlines_name'] ?></td>
				<td><?= $row_trip['class'] ?></td>
				<td><?= $row_trip['flight_no'] ?></td>
				<td><?= $row_trip['airlin_pnr'] ?></td>
				<td><?= $row_trip['departure_city'].' -- '.$row_trip['arrival_city'] ?></td>
				<td>
					<?php if($sq_tickets['ticket_url']!=""){  ?>
					<a href="<?= $url ?>" download class="btn btn-info btn-sm"><i class="fa fa-download"></i></a>
					<?php } 
						echo 'NA'; ?>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

</div> </div> </div>

<script>
	$('#tbl_ticket_report').dataTable({
	"pagingType": "full_numbers"
});
</script>