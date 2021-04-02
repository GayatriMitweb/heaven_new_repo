<?php
include "../../../model/model.php";
$role= $_SESSION['role'];
$emp_id= $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='bank_vouchers/index.php'"));
$branch_status = $sq['branch_status'];
?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-right mg_bt_20">
	<div class="col-xs-12">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<button class="btn btn-info ico_left btn-sm" id="btn_new_cash" onclick="cash_withdrawal_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Withdrawal</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select id="bank_id_filter" name="bank_id_filter" style="width:100%" title="Bank" class="form-control">
				  <?php get_bank_dropdown(); ?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" name="from_date_filter" id="from_date_filter" placeholder="From Date" title="From Date" class="form-control" onchange="get_to_date(this.id,'to_date_filter');">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" name="to_date_filter" id="to_date_filter" placeholder="To Date" title="To Date" class="form-control" onchange="validate_validDate('from_date_filter','to_date_filter')">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 hidden">
			<select name="financial_year_id_filter" id="financial_year_id_filter" title="Financial Year" class="form-control">
				<?php get_financial_year_dropdown(); ?>
			</select>
		</div>
		<div class="col-xs-3">
			<button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>


<div id="div_list" class="main_block"></div>

<div id="div_crud_content"></div>

<script type="text/javascript">
$('#bank_id_filter').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });

function cash_withdrawal_modal()
{
	var branch_status = $('#branch_status').val();
	$('#btn_new_cash').button('loading');
	$.post('cash_withdrawal/save_modal.php',{branch_status : branch_status}, function(data){
		$('#div_crud_content').html(data);
		$('#btn_new_cash').button('reset');
	});
}
function list_reflect()
{
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var bank_id = $('#bank_id_filter').val();
	var financial_year_id = $('#financial_year_id_filter').val();
	var branch_status = $('#branch_status').val();
	$.post('cash_withdrawal/list_reflect.php',{ from_date : from_date, to_date : to_date, bank_id : bank_id, financial_year_id : financial_year_id , branch_status : branch_status}, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();

function update_withdrawal_modal(withdraw_id)
{
	var branch_status = $('#branch_status').val();
	$.post('cash_withdrawal/update_modal.php',{ withdraw_id : withdraw_id , branch_status : branch_status}, function(data){
		$('#div_crud_content').html(data);
	});
}

function excel_report()
  {
    var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var bank_id = $('#bank_id_filter').val();
	var financial_year_id = $('#financial_year_id_filter').val();
    var branch_status = $('#branch_status').val();
    window.location = 'cash_withdrawal/excel_report.php?bank_id='+bank_id+'&from_date='+from_date+'&to_date='+to_date+'&financial_year_id='+financial_year_id+'&branch_status='+branch_status;
  }

</script>