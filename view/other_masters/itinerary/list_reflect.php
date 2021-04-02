<?php
include_once("../../../model/model.php");
$dest_id = $_POST['dest_id'];
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="tbl_list_iti" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>dest_Id</th>
			<th>destination</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$query = "select * from destination_master where dest_id in(select dest_id from itinerary_master where 1)";
		if($dest_id!=''){
			$query = "select * from destination_master where dest_id in(select dest_id from itinerary_master where dest_id='$dest_id')";
		}
		$sq_iti = mysql_query($query);
		while($row_iti = mysql_fetch_assoc($sq_iti)){
			?>
			<tr>
				<td><?= $row_iti['dest_id'] ?></td>
				<td><?= $row_iti['dest_name'] ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_iti['dest_id'] ?>)" title="Edit Itinerary"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

</div> </div> </div>

<script>
$('#tbl_list_iti').dataTable({
		"pagingType": "full_numbers"
	});
</script>