<?php
include "../../../../../../model/model.php";

$visa_id = $_POST['visa_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from visa_master where 1 ";
$query .=" and customer_id='$customer_id'";
if($visa_id!=""){
	$query .=" and visa_id='$visa_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered bg_white cust_table" id="tbl_visa_report" style="margin:20px 0 !important">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Passenger_Name</th>
			<th>Birthdate</th>
			<th>Visa_Country</th>
			<th>Visa_Type</th>
			<th>Recieved_Documents</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_visa = mysql_query($query);
		while($row_visa =mysql_fetch_assoc($sq_visa)){
			$date = $row_visa['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_visa[customer_id]'"));

			$sq_entry = mysql_query("select * from visa_master_entries where visa_id='$row_visa[visa_id]'");
			while($row_entry = mysql_fetch_assoc($sq_entry)){

				$bg = ($row_entry['status']=="Cancel") ? "danger" : "";
				?>
				<tr class="<?= $bg ?>">
					<td><?= ++$count ?></td>
					<td><?= get_visa_booking_id($row_visa['visa_id'],$year) ?></td>
					<td><?= $row_entry['first_name'].' '.$row_entry['last_name'] ?></td></td>
					<td><?= date('d-m-Y', strtotime($row_entry['birth_date'])); ?></td>
					<td><?= $row_entry['visa_country_name'] ?></td>
					<td><?= $row_entry['visa_type'] ?></td>
					<td><?= $row_entry['received_documents'] ?></td>
				</tr>
				<?php
			}

		}
		?>
	</tbody>
</table>
</div> </div> </div>
<script>
	
$('#tbl_visa_report').dataTable({
	"pagingType": "full_numbers"
});
</script>