<?php

include "../../../../model/model.php";

$active_flag = $_POST['active_flag'];
$vehicle_name = $_POST['vehicle_name'];

$query = "select * from  car_rental_tariff_entries where 1 ";
if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
if($vehicle_name!=""){
	$query .=" and vehicle_name='$vehicle_name' ";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> 
<div class="table-responsive">
<table class="table table-bordered table-hover" id="tbl_vendor_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Vehicle_Name</th>
			<th>Tour_Type</th>
			<th>View</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_vendor = mysql_query($query);
		while($row_venndor = mysql_fetch_assoc($sq_vendor))
		{
			$count++;

			$sq_gl = mysql_fetch_assoc(mysql_query("select * from gl_master where gl_id='$row_venndor[gl_id]'"));
			$sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_venndor[city_id]'"));
			$bg = ($row_venndor['active_flag']=="Inactive") ? "danger" : "";
			?>
			<tr class="<?= $bg ?>">
				<td><?= $count ?></td>
				<td><?= $row_venndor['vehicle_name'] ?></td>
				<td><?= $row_venndor['tour_type'] ?></td>
				
				<td>
					<button class="btn btn-info btn-sm" onclick="vendor_view_modal(<?= $row_venndor['entry_id'] ?>)" title="View vendor"><i class="fa fa-eye"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="vendor_update_modal(<?= $row_venndor['entry_id'] ?>)" title="Edit vendor"><i class="fa fa-pencil-square-o"></i> </button>
				</td>
			</tr>
			<?php
		}
		?>

	</tbody>

</table>

</div>

</div></div>

<script>

$('#tbl_vendor_list').dataTable({
		"pagingType": "full_numbers"
	});

</script>