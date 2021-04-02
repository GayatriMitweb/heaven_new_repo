<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
$ticket_id = $_POST['ticket_id'];

$query = "select * from ticket_master where 1 ";
$query .=" and customer_id='$customer_id'";
if($ticket_id!=""){
	$query .=" and ticket_id='$ticket_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">

<table class="table table-bordered cust_table bg_white" id="tbl_ticket_report" style="margin:20px 0 !important">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Passenger_Name</th>
			<th>Adolescence</th>
			<th>Ticket_No</th>
			<th>Gds_Pnr</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_ticket = mysql_query($query);
		while($row_ticket =mysql_fetch_assoc($sq_ticket)){
			$date = $row_ticket['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));

			$sq_entry = mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]' ");
			while($row_entry = mysql_fetch_assoc($sq_entry)){

				$bg = ($row_entry['status']=='Cancel') ? 'danger' : '';
				?>
				<tr class="<?= $bg ?>">
					<td><?= ++$count ?></td>
					<td><?= get_ticket_booking_id($row_ticket['ticket_id'],$year) ?></td>
					<td><?= $row_entry['first_name']." ".$row_entry['last_name'] ?></td>
					<td><?= $row_entry['adolescence'] ?></td>
					<td><?= $row_entry['ticket_no'] ?></td>
					<td><?= $row_entry['gds_pnr'] ?></td>
				</tr>
				<?php
			}

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