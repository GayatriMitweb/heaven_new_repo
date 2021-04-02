<?= begin_panel('Tour Budget Calculate') ?>

<div class="row">
	<div class="col-md-4 col-md-offset-4 text-center">
		<label for="budget_type_id_sel">Select Tour Type</label>
		<select name="budget_type_id_sel" id="budget_type_id_sel">
			<option value="">Select Tour Type</option>
			<?php 
			$sq = mysql_query("select * from tour_budget_type");
			while($row=mysql_fetch_assoc($sq)){
				?>
				<option value="<?= $row['budget_type_id'] ?>"><?= $row['budget_type'] ?></option>
				<?php
			}
			?>
		</select>
	</div>
</div>

<div id="div_budget_calculate_reflect" class="main_block mg_tp_20"></div>

<?= end_panel() ?>

<script>
	$(function(){
		$('#budget_type_id_sel').change(function(){
			var budget_type_id = $(this).val();
			$.post('budget_calculate/budget_calculate_reflect.php', { budget_type_id : budget_type_id }, function(data){
				$('#div_budget_calculate_reflect').html(data);
			});
		});
	});
</script>