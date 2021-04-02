<?php
include "../../../../model/model.php";
/*======******Header******=======*/
 
$emp_id= $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='vendor/quotation_request/index.php'"));
$branch_status = $sq['branch_status'];
 
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-right mg_bt_20">
	<div class="col-md-12">
			<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="quot_btn"><i class="fa fa-plus"></i>&nbsp;&nbsp;Quotation Request</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<select name="quotation_for_filter" id="quotation_for_filter" title="Quotation For" style="width:100%">
				<option value="">Quotation For</option>
				<option value="DMC">DMC</option>
				<option value="Hotel">Hotel</option>			
				<option value="Transport">Transport</option>
			</select>
		</div>
		<div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">
				<input type="text" id="from_date1" name="from_date" class="form-control" placeholder="From Date" title="From Date">
			</div>
			<div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">
				<input type="text" id="to_date1" name="to_date" class="form-control" placeholder="To Date" title="To Date">
			</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<button class="btn btn-info btn-sm ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>
<div id="div_quotation_list_reflect" class="main_block loader_parent">
	<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
		<table id="quotation_request" class="table table-hover" style="margin: 20px 0 !important;">         
		</table>
	</div></div></div>
</div>
<div id="div_modal_content"></div>
<div id="div_list_reflect" class="main_block loader_parent"></div>
<div id="div_req_view"></div>

<script>
$('#quotation_for_filter').select2();
$('#from_date1, #to_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
function save_modal(){
	$('#quot_btn').button('loading');
	$.post('request/save_modal.php', {}, function(data){
		$('#quot_btn').button('reset');
		$('#div_modal_content').html(data);
	});
}
var column = [
	{ title : "S_No."},
	{ title:"Date", className:"text-center"},
	{ title : "Quotation_ID"},
	{ title : "Customer Name"},
	{ title : "Interested_Tour"},
	{ title : "Sent_by"},
	{ title : "Actions", className : "text-center"}
];
function list_reflect(){
	$('#div_list_reflect').append('<div class="loader"></div>');
	var quotation_for = $('#quotation_for_filter').val();
	var from_date = $('#from_date1').val();
	var to_date = $('#to_date1').val();
	var branch_status = $('#branch_status').val();
 
	$.post('request/list_reflect.php', { quotation_for : quotation_for, from_date : from_date, to_date : to_date , branch_status : branch_status }, function(data){
		pagination_load(data, column, true, false, 10, 'quotation_request');
		$('.loader').remove();
	});
}
list_reflect();

function vendor_request_view_modal(request_id){
	$.post('request/view/index.php', { request_id : request_id }, function(data){
		$('#div_req_view').html(data);
	});
}
 
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
 
 