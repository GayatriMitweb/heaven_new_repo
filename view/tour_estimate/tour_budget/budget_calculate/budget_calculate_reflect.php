<?php 
include "../../../../model/model.php";
$budget_type_id = $_POST['budget_type_id'];
?>
	
<div class="row mg_tp_20"> <div class="col-md-6 col-md-offset-3"> <div class="table-responsive">
	
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<td>Sr. No</td>
				<td>Entity Name</td>
				<td>Entity Cost</td>
			</tr>
		</thead>
		<tbody>
			<?php 
			$count = 0;
			$sq = mysql_query("select * from tour_budget_entities where budget_type_id='$budget_type_id'");
			while($row = mysql_fetch_assoc($sq)){
				?>
				<tr>
					<td><?= ++$count ?></td>
					<td><?= $row['entity_name'] ?></td>
					<td>
						<input type="text" class="form-control" id="entity_cost_<?= $count ?>" name="entity_cost" value="0">
					</td>
				</tr>
				<?php
			}
			?>
			<tr class="">
				<td colspan="2" class="text-right">Total Tour Cost</td>
				<td><input class="form-control" type="text" id="total_tour_cost" name="total_tour_cost" value="0" disabled></td>
			</tr>
		</tbody>
	</table>

</div> </div> </div>


<script>
	$(function(){
		$('input[name="entity_cost"]').change(function(){
			var total_tour_cost = 0;
			$('input[name="entity_cost"]').each(function(){
				total_tour_cost = parseFloat(total_tour_cost)+parseFloat($(this).val());
			});	
			$('#total_tour_cost').val(total_tour_cost);
		});
	});
</script>