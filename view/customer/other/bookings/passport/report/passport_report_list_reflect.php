<?php
include "../../../../../../model/model.php";

$passport_id = $_POST['passport_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from passport_master where 1 ";
$query .=" and customer_id='$customer_id'";

if($passport_id!=""){
	$query .=" and passport_id='$passport_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered bg_white cust_table" id="tbl_passport_report" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>Sr. No</th>
			<th>Booking_ID</th>
			<th>Passenger_Name</th>
			<th>Birth_Date</th>
			<th>Received_Documents</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_passport = mysql_query($query);
		while($row_passport =mysql_fetch_assoc($sq_passport)){

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_passport[customer_id]'"));
			$date = $row_passport['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			
			$sq_entry = mysql_query("select * from passport_master_entries where passport_id='$row_passport[passport_id]'");
			while($row_entry = mysql_fetch_assoc($sq_entry)){

				$bg = ($row_entry['status']=="Cancel") ? "danger" : "";
				?>
				<tr class="<?= $bg ?>">
					<td><?= ++$count ?></td>
					<td><?= get_passport_booking_id($row_passport['passport_id'],$year) ?></td>
					<td><?= $row_entry['first_name']." ".$row_entry['last_name'] ?></td>
					<td><?= date('d-m-Y', strtotime($row_entry['birth_date'])) ?></td>
					<td><?= $row_entry['received_documents'] ?></td>
				</tr>
				<?php
			}

		}
		?>
	</tbody>
</table>
</div> </div> </div>
<script type="text/javascript">	
$('#tbl_passport_report').dataTable({
	"pagingType": "full_numbers"
});
</script>