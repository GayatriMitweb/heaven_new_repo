<div class="app_panel_content Filter-panel">
	
	<div class="row text-center">

		<div class="col-md-4 col-sm-6 mg_bt_10_xs">
			<select style="width:100%" id="cmb_booking_id" name="cmb_booking_id" title="Booking ID"> 
		         
		          <?php 
		              get_package_booking_dropdown();
		           ?>
		      </select>
		</div>
		<div class="col-md-4 col-sm-12 text-left text_center_xs text_left_sm_xs">
			<button class="btn btn-info ico_right" onclick="package_tour_expense_save_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
		<div class="col-md-4 col-sm-12 text-right text_center_xs text_left_sm_xs">
			<button class="btn btn-excel btn-sm mg_bt_10_sm_xs" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		</div>
	</div>

</div>
	<div id="div_package_tour_expense_reflect" class="main_block"></div>

<script>

	function excel_report()
	{
		var booking_id = $('#cmb_booking_id').val();

		if(booking_id==""){
			error_msg_alert("Select Booking ID.");
			return false;
		}
		window.location = 'package_tour/excel_report.php?booking_id='+booking_id;
	}

	function package_tour_expense_save_reflect(){
		var booking_id = $('#cmb_booking_id').val();

		if(booking_id==""){
			error_msg_alert("Select Booking ID.");
			return false;
		}

		$.post('package_tour/tour_expense_save_reflect.php', { booking_id : booking_id }, function(data){
			$('#div_package_tour_expense_reflect').html(data);
		});
	}
	$(function(){
		$('#cmb_booking_id').change(function(){
			$('#div_package_tour_expense_reflect').html('');
		});
	});
	$(document).ready(function() {
            $("#cmb_booking_id").select2();   
        });
</script>

