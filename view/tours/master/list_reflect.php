<?php
include "../../../model/model.php";
?>
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table" id="tbl_tour_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Tour_Type</th>
			<th>Tour_Name</th>
			<th>Adult_Cost</th>
			<th>CWB Cost</th>
			<th>CWOB Cost</th>
            <th>Infant_Cost </th>
			<th>View</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_tours = mysql_query("select * from tour_master");
		while($row_tour = mysql_fetch_assoc($sq_tours)){
			$bg = ($row_tour['active_flag']=="Inactive") ? "danger" : "";
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $row_tour['tour_type'] ?></td>
				<td><?= $row_tour['tour_name'] ?></td>
				<td><?= $row_tour['adult_cost']; ?></td>
				<td><?= $row_tour['child_with_cost']; ?></td>
				<td><?= $row_tour['child_without_cost']; ?></td>
				<td><?= $row_tour['infant_cost']; ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="display_modal(<?= $row_tour['tour_id'] ?>)" title="View Tour"><i class="fa fa-eye"></i></button>
				</td>				
				<td>
				<?php echo '
					<form style="display:inline-block" action="update/update_group_tour.php" class="no-marg" method="POST">
						<input type="hidden" id="tour_id" style="display:inline-block" name="tour_id" value="'.$row_tour['tour_id'].'">
						<button class="btn btn-info btn-sm form-control" id="update_btn'.$row_tour['tour_id'].'" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>
					</form>';?>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
</div> </div> </div>
<script>
$('#tbl_tour_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>