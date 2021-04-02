<?php
include "../../../../../../model/model.php"; ?>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
	        <select class="form-control" style="width:100%" id="cmb_tour_name" name="cmb_tour_name" onchange="tour_group_reflect(this.id)" title="Tour Name"> 
	            <option value="">Tour Name</option>
	            <?php
				$sq=mysql_query("select tour_id,tour_name from tour_master where active_flag='Active' order by tour_name asc");
				while($row=mysql_fetch_assoc($sq)){
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
			<button class="btn btn-sm btn-info ico_right" onclick="group_tour_expense_save_reflect();group_tour_widget()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
		<div class="col-md-3 col-sm-12 text-right text_center_xs text_left_sm_xs">
			<button class="btn btn-excel btn-sm mg_bt_10_sm_xs" onclick="excel_report1()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		</div>
	</div>
</div>
<div id="div_tour_expense_reflect" class="main_block mg_tp_20"></div>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="group_tour_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>

<div id="other_expnse_display"></div>
<script>
$('#cmb_tour_name').select2();

function excel_report1(){
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
	window.location = 'report_reflect/revenue_expenses/group_tour/excel_report.php?tour_id='+tour_id+'&tour_group_id='+tour_group_id;
}
var column = [
	{ title : "S_No."},
	{ title:"Booking_ID", className:"text-center"},
	{ title : "Booking_date"},
	{ title : "Amount"},
	{ title : "User_Name"},
	{ title : "Purchase/Expenses"},
	{ title : "Other_Expense"}	
];
function group_tour_expense_save_reflect(){
	var tour_id = $('#cmb_tour_name').val();
	var tour_group_id = $('#cmb_tour_group').val();
	var base_url = $('#base_url').val();

	if(tour_id==""){
		error_msg_alert("Select tour name.");
		$('#div_tour_expense_reflect').html('');
		return false;
	}
	if(tour_group_id==""){
		error_msg_alert("Select tour group.");
		$('#div_tour_expense_reflect').html('');
		return false;
	}
	$.post(base_url+'view/reports/business_reports/report_reflect/revenue_expenses/group_tour/tour_expense_save_reflect.php', { tour_id : tour_id, tour_group_id : tour_group_id }, function(data){	
		pagination_load(data, column, true, false, 20, 'group_tour_report');
	});
}
function group_tour_widget(){
	var tour_id = $('#cmb_tour_name').val();
	var tour_group_id = $('#cmb_tour_group').val();
	var base_url = $('#base_url').val();

	if(tour_id==""){
		error_msg_alert("Select tour name.");
		$('#div_tour_expense_reflect').html('');
		return false;
	}
	if(tour_group_id==""){
		error_msg_alert("Select tour group.");
		$('#div_tour_expense_reflect').html('');
		return false;
	}
	$.post(base_url+'view/reports/business_reports/report_reflect/revenue_expenses/group_tour/widget_badge.php', { tour_id : tour_id, tour_group_id : tour_group_id }, function(data){	
		$('#div_tour_expense_reflect').html(data);
	});
}
function view_purchase_modal(tour_id,tour_group_id)
{
	var base_url = $('#base_url').val();
	$.post(base_url+'view/reports/business_reports/report_reflect/revenue_expenses/group_tour/view_purchase_modal.php', { tour_id : tour_id, tour_group_id : tour_group_id}, function(data){
		$('#other_expnse_display').html(data);
	});
}
function other_expnse_modal(tour_id,tour_group_id)
{
	var base_url = $('#base_url').val();
	$.post(base_url+'view/reports/business_reports/report_reflect/revenue_expenses/group_tour/other_expnse_modal.php', { tour_id : tour_id, tour_group_id : tour_group_id }, function(data){
		$('#other_expnse_display').html(data);
		
	});
	
}
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
$(function(){
	$('#cmb_tour_name, #cmb_tour_group').change(function(){
		$('#div_tour_expense_reflect').html('');
	});
});
</script>

