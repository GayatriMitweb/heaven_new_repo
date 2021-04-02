<?php
include "../../../../../../model/model.php";

$exc_id = $_POST['exc_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from excursion_master where 1 ";
$query .=" and customer_id='$customer_id'";
if($exc_id!=""){
	$query .=" and exc_id='$exc_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered bg_white cust_table" id="tbl_exc_report" style="margin:20px 0 !important">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Activity_date&time</th>
			<th>City_name</th>
			<th>Activity_name</th>
			<th>total_guest</th>
			<th>amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_exc = mysql_query($query);
		while($row_exc =mysql_fetch_assoc($sq_exc)){

			$date = $row_exc['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_exc[customer_id]'"));

			$sq_entry = mysql_query("select * from excursion_master_entries where exc_id='$row_exc[exc_id]'");
			while($row_entry = mysql_fetch_assoc($sq_entry)){

				$bg = ($row_entry['status']=="Cancel") ? "danger" : "";
       			$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_entry[city_id]'"));
				$sq_exc1 = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$row_entry[exc_name]'"));    
					?>
					<tr class="<?= $bg ?>">
						<td><?php echo ++$count; ?></td>
						<td><?php echo get_exc_booking_id($row_exc['exc_id'],$year); ?> </td>
						<td><?php echo date('d-m-Y H:i', strtotime($row_entry['exc_date'])); ?> </td>
						<td><?php echo $sq_city['city_name']; ?> </td>
						<td><?php echo $sq_exc1['excursion_name']; ?> </td>
						<td><?php echo ($row_entry['total_adult'] + $row_entry['total_child']); ?></td>
						<td><?php echo $row_entry['total_cost']; ?> </td>
					</tr>
				<?php
			    } 
		}
		?>
	</tbody>
</table>
</div> </div> </div>
<script>
$('#tbl_exc_report').dataTable({
	"pagingType": "full_numbers"
});
</script>