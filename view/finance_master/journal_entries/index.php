<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Journal Entries',38) ?>
	<div class="row text-right mg_tp_20 mg_bt_20">
		<div class="col-md-12">
	    	<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
			<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Journal Entry</button>
		</div>
	</div>
	<div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<input type="text" id="payment_from_date_filter" name="payment_from_date_filter" placeholder="From Date" title="From Date">
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<input type="text" id="payment_to_date_filter" name="payment_to_date_filter" placeholder="To Date" title="To Date">
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			</div>
	    </div>
	</div>

<div id="div_modal" class="main_block"></div>

<div id="div_list_content" class="main_block loader_parent mg_tp_20">
 <div class="table-responsive">
    <table id="tbl_list" class="table table-hover" style="margin: 20px 0 !important;">
    </table>
</div>
</div>

<div id="journal_modal_display"></div>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
$('#payment_from_date_filter, #payment_to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
var columns = [
	{ title : "S_No." },
	{ title : "JV_ID" },
	{ title : "Date" },
	{ title : "Particulars" },
	{ title : "dr_cr" },
	{ title : "Narration" },
	{ title : "Debit_Amount" ,className: 'success text-right'},
	{ title : "Actions", className:"text-center" }
]
function list_reflect()
{
    $('#div_list_content').append('<div class="loader"></div>');
	var from_date = $('#payment_from_date_filter').val();
    var to_date = $('#payment_to_date_filter').val();
	$.post('list_reflect.php', {from_date : from_date, to_date : to_date}, function(data){
		pagination_load(data,columns,false,true,20,'tbl_list');
		$('.loader').remove();
	});
}list_reflect();

function save_modal()
{
	$('#btn_save_modal').button('loading');
	$.post('save_modal.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal').html(data);
	});
}
function update_modal(entry_id)
{
	$.post('update_modal.php', { entry_id : entry_id }, function(data){
		$('#div_modal').html(data);
	});
}

function excel_report()
{
    var from_date = $('#payment_from_date_filter').val();
    var to_date = $('#payment_to_date_filter').val();

    window.location = 'excel_report.php?from_date='+from_date+'&to_date='+to_date;
}
function entry_display_modal(entry_id)
{	
	var base_url = $('#base_url').val();
	$.post(base_url+'view/finance_master/journal_entries/view/index.php', {entry_id : entry_id}, function(data){
		$('#journal_modal_display').html(data);
	});
}
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>