<?php
include "../../../model/model.php";
?>
	
	<div class="row app_panel_content Filter-panel">
		<div class="col-md-3">
			<select name="tour_id" id="tour_id" style="width:100%">
				<option value="">Tour Name</option>
				<?php 
				$sq_tour = mysql_query("select tour_id, tour_name from tour_master where active_flag!='Inactive' order by tour_name");
				while($row_tour = mysql_fetch_assoc($sq_tour)){
					?>
					<option value="<?= $row_tour['tour_id'] ?>"><?= $row_tour['tour_name'] ?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="col-md-3">
      		<input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date" style="width:100%" class="form-control">
      	</div>
        <div class="col-md-3">
          <input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date" style="width:100%" class="form-control">
        </div>
        <div class="col-md-3">
          <button class="btn btn-info ico_right"  onclick="tour_groups_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
      </div>
		
	</div>

	<div id="div_tour_groups_reflect" class="main_block"></div>


<script>
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
	$('#tour_id').select2();
	function tour_groups_reflect()
	{
		var tour_id = $('#tour_id').val();
		var from_date = $('#from_date_filter').val();
		var to_date = $('#to_date_filter').val();
		
		$.post('group_tour/tour_groups_reflect.php', { tour_id : tour_id, from_date : from_date, to_date : to_date  }, function(data){
			$('#div_tour_groups_reflect').html(data);
		});
	}
	tour_groups_reflect();
</script>