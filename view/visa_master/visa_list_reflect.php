<?php
include "../../model/model.php";

$country_name = $_POST['country_name'];
$visa_type = $_POST['visa_type'];
$query = "select * from visa_crm_master where 1";

if($country_name!=""){
	$query .=" and country_id='$country_name' ";
}
if($visa_type!=""){
	$query .=" and visa_type='$visa_type' ";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table" id="tbl_emp_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Country_Name</th>
			<th>Visa_Type</th>
			<th>Total_Amount</th>
			<th>Time Taken</th>
			<th>View</th>
			<th>Edit</th>
			<th>Send</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0; $total_amt = 0;
		$sq_emp = mysql_query($query);
		while($row_emp = mysql_fetch_assoc($sq_emp)){
			
			$sq_location = mysql_fetch_assoc(mysql_query("select * from locations where location_id='$row_emp[location_id]'"));
			$sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$row_emp[branch_id]'"));
			$total_amt = $row_emp['fees'] + $row_emp['markup'];
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= $row_emp['country_id'] ?></td>
				<td><?= $row_emp['visa_type'] ?></td>
				<td><?= number_format($total_amt,2) ?></td>
				<td><?= $row_emp['time_taken']?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="display_modal(<?= $row_emp['entry_id'] ?>)" title="View Visa"><i class="fa fa-eye"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_emp['entry_id'] ?>)" title="Edit Visa"><i class="fa fa-pencil-square-o"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="send(<?= $row_emp['entry_id'] ?>)" title="Send Visa Information"><i class="fa fa-paper-plane-o"></i></button>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
</div> </div> </div>

<script>
$('#tbl_emp_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>