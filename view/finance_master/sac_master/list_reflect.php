<?php
include "../../../model/model.php";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Service_Name</th>
			<th>HSN/SAC Code</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_sac = mysql_query("select * from sac_master");
		while($row_sac = mysql_fetch_assoc($sq_sac)){
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= $row_sac['service_name'] ?></td>
				<td><?= $row_sac['hsn_sac_code'] ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_sac['sac_id'] ?>)" title="Update SAC"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

</div> </div> </div>

<script>
$('#tbl_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>