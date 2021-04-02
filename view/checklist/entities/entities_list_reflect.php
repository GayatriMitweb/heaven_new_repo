<?php
include "../../../model/model.php";
$entity_for = $_POST['entity_for'];

?>
<div class="row mg_tp_10"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	<table class="table table-bordered" id="checklist_entities_tbl">
		<thead>
			<tr class="active table-heading-row">
				<th>S_No.</th>
				<th>For &nbsp;&nbsp;&nbsp;</th>
				<th>View</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 0; 
			$query = "select * from checklist_entities where 1 ";
			if($entity_for != ''){
				$query .= " and entity_for='$entity_for'";
			}
			$sq_entity = mysql_query($query);
			while($row_entity = mysql_fetch_assoc($sq_entity)){
				
				 $sq_tour =mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$row_entity[tour_id]'"));
				 $sq_tour_group =mysql_fetch_assoc(mysql_query("select * from tour_groups where tour_id='$row_entity[tour_id]' and group_id='$row_entity[tour_group_id]'"));
				 $sq_pckg_tour=mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$row_entity[booking_id]'"));
				?>
				<tr>
					<td><?= ++$count ?></td>
					<td><?= $row_entity['entity_for'] ?></td>
					<td><button class="btn btn-info btn-sm" onclick="view_modal(<?= $row_entity['entity_id']  ?>)" title="View Checklist"><i class="fa fa-eye"></i></button></td>
					<td>					
						<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_entity['entity_id'] ?>)" title="Edit Entity"><i class="fa fa-pencil-square-o"></i></button>
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>	
</div> </div> </div>


<script>
$('#checklist_entities_tbl').dataTable({"pagingType": "full_numbers"});
</script>