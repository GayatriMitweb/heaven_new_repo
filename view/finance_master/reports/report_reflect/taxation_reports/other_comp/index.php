<?php include "../../../../../../model/model.php"; 
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='finance_master/reports/index.php'"));
$branch_status = $sq['branch_status'];
?>

<input type="hidden" name="branch_status" value="<?= $branch_status ?>" id="branch_status">
<input type="hidden" name="role" value="<?= $role ?>" id="role">
<input type="hidden" name="branch_admin_id" value="<?= $branch_admin_id ?>" id="branch_admin_id">
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
			<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;
            <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()" title="Add New"><i class="fa fa-plus"></i>&nbsp;&nbsp;Compliance</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3">
			<input type="text" name="till_date" id="till_date" title="Till Date" placeholder="Till Date" onchange="report_reflect()">
		</div>
	</div>
</div>
<hr>
<!-- <div id="div_report_other" class="main_block loader_parent"></div> -->
<div id="display_modal1"></div>
<div class="row mg_tp_10 main_block">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="other_comp" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div></div>
<script type="text/javascript">
$('#month_filter').select2(); 
$('#till_date').datetimepicker({timepicker:false, format:'d-m-Y'});
function save_modal()
{ 
	var base_url = $('#base_url').val();
	$('#btn_save').button('loading');
	$.post('report_reflect/taxation_reports/other_comp/save_modal.php', { }, function(data){
		$('#btn_save').button('reset');
		$('#div_modal').html(data);
	});
}

var column = [
{ title : "S_No."},
{ title:"Compliance_Name"},
{ title : "Statute_Name"},
{ title : "Due_Date"},
{ title : "Payment"},
{ title : "Responsible_Person"},
{ title : "Description"},
{ title : "Date_Complied_on"}
]; 
function report_reflect()
{
	$('#div_report_other').append('<div class="loader"></div>');
	var till_date = $('#till_date').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();
 
	$.post('report_reflect/taxation_reports/other_comp/report_reflect.php',{  till_date : till_date ,branch_status : branch_status, role : role,branch_admin_id : branch_admin_id }, function(data){
		// console.log(data);
		pagination_load(data, column, true, false, 20, 'other_comp');
	});
}
report_reflect();

function update_modal(comp_id)
{
    $.post('report_reflect/taxation_reports/other_comp/update_modal.php', {comp_id : comp_id}, function(data){
        $('#display_modal1').html(data);
    });
}

function excel_report()
{
	var till_date = $('#till_date').val();

	window.location = 'report_reflect/taxation_reports/other_comp/excel_report.php?till_date='+till_date;
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>