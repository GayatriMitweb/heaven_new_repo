<?php
include "../../../../../../model/model.php";
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='reports/business_reports/index.php'"));
$branch_status = $sq['branch_status'];
 ?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="app_panel_content Filter-panel">

	<div class="row">
		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
	        <select class="form-control" style="width:100%" id="booking_id2" name="booking_id2" title="Booking Id" onchange="package_tour_expense_save_reflect()"> 
	            <?php get_package_booking_dropdown($role, $branch_admin_id, $branch_status,'',$role_id);?> 
	        </select>
	    </div>
		<div class="col-md-9 col-sm-12 text-right text_center_xs text_left_sm_xs">
			<button class="btn btn-excel btn-sm mg_bt_10_sm_xs" onclick="excel_report_package()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		</div>
	</div>

</div>

<div id="div_package_expense_reflect" class="main_block mg_tp_20"></div>

<script>
$('#booking_id2').select2();

$(function(){
	$('#booking_id').change(function(){
		$('#div_package_expense_reflect').html('');
	});
});

function package_tour_expense_save_reflect()
{
		var booking_id = $('#booking_id2').val();
		var branch_status = $('#branch_status').val();
    var base_url = $('#base_url').val();

    if(booking_id==""){
      error_msg_alert("Select Booking Id");
	  $('#div_package_expense_reflect').html('');
      return false;
    }else{
		$.post(base_url+'view/reports/business_reports/report_reflect/revenue_expenses/package_tour/package_expense_reflect.php', { booking_id : booking_id,branch_status : branch_status }, function(data){    
		$('#div_package_expense_reflect').html(data);
		});
	}
}
function excel_report_package()
{
	var booking_id = $('#booking_id2').val();
	if(booking_id==""){
		error_msg_alert("Select Booking Id.");
		return false;
	}
	window.location = 'report_reflect/revenue_expenses/package_tour/excel_report.php?booking_id='+booking_id;
}

</script>

