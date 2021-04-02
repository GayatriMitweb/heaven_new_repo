<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
$ticket_id = $_POST['ticket_id'];

$query = "select * from train_ticket_master where 1 ";
$query .=" and customer_id='$customer_id'";
if($ticket_id!=""){
	$query .=" and train_ticket_id='$ticket_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered cust_table" id="tbl_ticket_report" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>Sr.No</th>
			<th>Booking_ID</th>
			<th>From_Location</th>
			<th>To_Location</th>
			<th>Train_Name</th>
			<th>Train_No</th>
			<th>Class</th>
			<th>Ticket</th>
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
			$sq_tickets = mysql_fetch_assoc(mysql_query("select * from train_ticket_master_upload_entries where train_ticket_id='$ticket_id'"));

			$url = $sq_tickets['train_ticket_url'];
			$url = explode('uploads/', $url);
			$url = BASE_URL.'uploads/'.$url[1];
			
			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
			$sq_entry1 = mysql_query("select * from train_ticket_master_trip_entries where train_ticket_id='$row_ticket[train_ticket_id]'");
			while($row_entery1 = mysql_fetch_assoc($sq_entry1)){
					?>
					<tr class="<?= $bg ?>">
						<td><?= ++$count ?></td>
						<td><?= get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year) ?></td>
						<td><?= $row_entery1['travel_from'] ?></td>
						<td><?= $row_entery1['travel_to'] ?></td>
						<td><?= $row_entery1['train_name'] ?></td>
						<td><?= $row_entery1['train_no'] ?></td>
						<td><?= $row_entery1['class'] ?></td>
						<td>
						<?php if($sq_tickets['train_ticket_url']!=""){  ?>
							<a href="<?= $url ?>" download class="btn btn-info btn-sm"><i class="fa fa-download"></i></a>
						<?php } 
						echo 'NA'; 
			} ?>
						</td>
				</tr>
				<?php
			}
		?>
	</tbody>
</table>
</div> </div> </div>
<script type="text/javascript">
$('#tbl_ticket_report').dataTable({
	"pagingType": "full_numbers"
});
</script>
