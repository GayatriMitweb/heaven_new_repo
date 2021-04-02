<div class="app_panel_content Filter-panel">

	<div class="row text-center">
		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
	        <select class="form-control" style="width:100%" id="cmb_tour_name" name="cmb_tour_name" onchange="tour_group_reflect(this.id)" title="Tour Name"> 
	            <option value="">Tour Name </option>
	            <?php
	                $sq=mysql_query("select tour_id,tour_name from tour_master where active_flag='Active' order by tour_name asc");
	                while($row=mysql_fetch_assoc($sq))
	                {
	                  echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
	                }    
	            ?>
	        </select>
	    </div>
	    
	    <div class="col-md-3 col-sm-6 mg_bt_10_xs">
	        <select class="form-control" id="cmb_tour_group" name="cmb_tour_group" title="Tour Group"> 
	            <option value="">Tour Group</option>        
	        </select>
	    </div>
		<div class="col-md-3 col-sm-6 text-left">
			<button class="btn btn-info ico_right" onclick="group_tour_expense_save_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
		<div class="col-md-3 col-sm-12 text-right text_center_xs text_left_sm_xs">
			<button class="btn btn-excel btn-sm mg_bt_10_sm_xs" onclick="excel_report1()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		</div>
	</div>

</div>

<div id="div_tour_expense_reflect" class="main_block"></div>



<script>
$('#cmb_tour_name').select2();

	function excel_report1()
	{
		var tour_id = $('#cmb_tour_name').val();
		var tour_group_id = $('#cmb_tour_group').val();
		if(tour_id==""){
			error_msg_alert("Select tour name.");
			return false;
		}
		if(tour_group_id==""){
			error_msg_alert("Select tour group.");
			return false;
		}

		window.location = 'group_tour/excel_report.php?tour_id='+tour_id+'&tour_group_id='+tour_group_id;
	}

	function group_tour_expense_save_reflect(){
		var tour_id = $('#cmb_tour_name').val();
		var tour_group_id = $('#cmb_tour_group').val();

		if(tour_id==""){
			error_msg_alert("Select tour name.");
			return false;
		}
		if(tour_group_id==""){
			error_msg_alert("Select tour group.");
			return false;
		}

		$.post('group_tour/tour_expense_save_reflect.php', { tour_id : tour_id, tour_group_id : tour_group_id }, function(data){
			$('#div_tour_expense_reflect').html(data);
		});
	}
	$(function(){
		$('#cmb_tour_name, #cmb_tour_group').change(function(){
			$('#div_tour_expense_reflect').html('');
		});
	});
</script>

