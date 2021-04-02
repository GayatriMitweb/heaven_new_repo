<?php include "../../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="row text-right mg_bt_10">
	<div class="col-md-4 col-md-offset-8">
            <button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
            <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()" title="Add New"><i class="fa fa-plus"></i>&nbsp;&nbsp;Reconciliation</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 mg_bt_10_xs">
			<input type="text" name="from_date_filter1" id="from_date_filter1" placeholder="Date" title="Date" class="form-control" onchange="report_reflect()">
		</div>
	</div>
</div
<hr>
<div id="div_report" class="main_block loader_parent">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="cash_re" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<div id="display_modal" class="main_block"></div>

<script type="text/javascript">
$('#from_date_filter1').datetimepicker({ timepicker:false, format:'d-m-Y' }); 
function save_modal()
{ 
	var base_url = $('#base_url').val();
  	var branch_admin_id = $('#branch_admin_id1').val();
	$('#btn_save').button('loading');

	$.post(base_url+'view/finance_master/reports/report_reflect/cash_reconcilation/save_modal.php', {branch_admin_id : branch_admin_id }, function(data){
		$('#btn_save').button('reset');
		$('#div_modal').html(data);
	});
}
var column = [	
			{ title : "SR.NO"},
			{ title : "Date"},
			{ title : "Cash as per System"},
			{ title : "Cash as per Tills"},
			{ title : "Difference"},
			{ title : "Reconciliation Amount"},
			{ title : "Reconciliation difference"},
			{ title : "Admin Approval"}
];
function report_reflect()
{
	$('#div_report').append('<div class="loader"></div>');
	var filter_date = $('#from_date_filter1').val();
  	var branch_admin_id = $('#branch_admin_id1').val();
	$.post('report_reflect/cash_reconcilation/report_reflect.php',{  filter_date : filter_date,branch_admin_id : branch_admin_id  }, function(data){
		var table = pagination_load(data, column, true, false, 20, 'cash_re');
		$('.loader').remove();
	});
}
report_reflect();

function display_modal(id)
{
    $.post('report_reflect/cash_reconcilation/view/index.php', {id : id}, function(data){
        $('#display_modal').html(data);
    });
}

function cal_denomination_amount(offset)
{
	var denom = $('#denom_'+offset).val();
	var numbers = $('#number_'+offset).val();
	var amount = $('#amount_'+offset).val();
	var txt_till_cash = $('#txt_till_cash').val();
	var system_cash = $('#txt_system_cash').val();
	var total_denom_amount = 0;

	if(txt_till_cash == ''){ txt_till_cash = 0;}
	if(system_cash == ''){ system_cash = 0;}
	if(numbers == ''){ numbers = 0;}

	var total_amount = parseFloat(numbers) * parseFloat(denom);
	var total_amount1 = parseFloat(total_amount);
	$('#amount_'+offset).val(total_amount1.toFixed(2));

	for(var i=1; i<=11; i++){
		var denom_amount = $('#amount_'+i).val();
		if(denom_amount == ''){ denom_amount = 0;}
		total_denom_amount = parseFloat(total_denom_amount) + parseFloat(denom_amount);
	}
	$('#txt_till_cash').val(total_denom_amount);

	var till_cash_temp = $('#txt_till_cash').val();
	var diff_reconc = parseFloat(system_cash) - parseFloat(till_cash_temp);
	var diff_reconc = parseFloat(diff_reconc);
	$('#txt_diff').val(diff_reconc.toFixed(2));

	if(parseFloat(diff_reconc) == '0'){
		$('#reconc_result').text('Cash Matches!');
	}
	else if(parseFloat(diff_reconc) < '0'){
		$('#reconc_result').text('Cash is excess in tills!');
	}
	else{
		$('#reconc_result').text('Cash is less in tills!');
	}

	var recon_temp = $('#txt_rec_amt').val();
	if(recon_temp == ''){ recon_temp = 0; }
	var diff_after_reconc = parseFloat(diff_reconc) + parseFloat(recon_temp);
	var diff_after_reconc = parseFloat(diff_after_reconc);
	$('#txt_rec_diff').val(diff_after_reconc.toFixed(2));

}
function cal_reconcil_amount(){
	var txt_amt_pen = $('#reason_amount1').val();
	var txt_amt_pass = $('#reason_amount2').val();
	var txt_cash_deposit = $('#reason_amount3').val();
	var txt_cash_with = $('#reason_amount4').val();
	var txt_remarks_positive = $('#reason_amount5').val();
	var txt_remarks_negative = $('#reason_amount6').val();

	var txt_diff = $('#txt_diff').val();

	if(txt_amt_pen == ''){ txt_amt_pen = 0; }
	if(txt_amt_pass == ''){ txt_amt_pass = 0; }
	if(txt_cash_deposit == ''){ txt_cash_deposit = 0; }
	if(txt_cash_with == ''){ txt_cash_with = 0; }
	if(txt_remarks_positive == ''){ txt_remarks_positive = 0; }
	if(txt_remarks_negative == ''){ txt_remarks_negative = 0; }

	var reconc_amount = parseFloat(txt_amt_pen) - parseFloat(txt_amt_pass) + parseFloat(txt_cash_deposit) - parseFloat(txt_cash_with) + parseFloat(txt_remarks_positive) - parseFloat(txt_remarks_negative);
	var reconc_amount = parseFloat(reconc_amount);
	$('#txt_rec_amt').val(reconc_amount.toFixed(2));

	var recon_temp = $('#txt_rec_amt').val();
	var diff_after_reconc = parseFloat(txt_diff) + parseFloat(recon_temp);
	var diff_after_reconc = parseFloat(diff_after_reconc);
	$('#txt_rec_diff').val(diff_after_reconc.toFixed(2));
}

function excel_report()
{
	var filter_date = $('#from_date_filter1').val();
  	var branch_admin_id = $('#branch_admin_id1').val();
	
	window.location = 'report_reflect/cash_reconcilation/excel_report.php?filter_date='+filter_date+'&branch_admin_id='+branch_admin_id;
}

</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>