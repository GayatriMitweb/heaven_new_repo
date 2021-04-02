<?php 
include_once('../../../model/model.php');
?>

<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
	<table class="table table-hover" id="city_table_id" style="margin: 20px 0 !important;">
		<thead>
			<tr class="table-heading-row">
				<th>S_No.</th>
				<th>Location</th>
				<th>Status</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$sq_location = mysql_query("select * from locations");
			while($row_location = mysql_fetch_assoc($sq_location))
			{
				$bg = ($row_location['active_flag']=="Inactive") ? "danger" : "";
				?>
				<tr class="<?= $bg ?>">
					<td><?= ++$count ?></td>
					<td><?= $row_location['location_name'] ?></td>
					<td><?= $row_location['active_flag'] ?></td>
					<td>
						<button onclick="location_edit_modal(<?= $row_location['location_id'] ?>)" class="btn btn-info btn-sm" title="Edit Location"><i class="fa fa-pencil-square-o"></i></button>
					</td>
				</tr>
				<?php
			}	
			?>
		</tbody>
	</table>

</div> </div> </div>

<div id="div_location_edit_modal"></div>
<script type="text/javascript">
	$('#city_table_id').dataTable({
		"pagingType": "full_numbers",
	});
</script>