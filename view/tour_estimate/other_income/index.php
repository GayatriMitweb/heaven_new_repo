<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Other Income') ?>

<div class="row text-right mg_bt_10">
	<div class="col-xs-12">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<button class="btn btn-info ico_left btn-sm mg_bt_10_sm_xs" id="btn_new_income_type" onclick="income_type_save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Income Type</button>&nbsp;&nbsp;
		<button class="btn btn-info ico_left btn-sm" id="btn_new_income" onclick="income_save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Income</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select id="income_type_id_filter" name="income_type_id_filter" title="Income Type">
				<option value="">Income Type</option>
				<?php 
				$sq_income_type = mysql_query("select * from other_income_type_master order by income_type");
				while($row_income_type = mysql_fetch_assoc($sq_income_type)){
					?>
					<option value="<?= $row_income_type['income_type_id'] ?>"><?= $row_income_type['income_type'] ?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" name="from_date_filter" id="from_date_filter" placeholder="From Date" title="From Date">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" name="to_date_filter" id="to_date_filter" placeholder="To Date" title="To Date">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="financial_year_id_filter" id="financial_year_id_filter" title="Financial Year">
				<?php get_financial_year_dropdown(); ?>
			</select>
		</div>
		<div class="col-xs-12 text-center">
			<button class="btn btn-info ico_right" onclick="income_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>


<div id="div_list" class="main_block"></div>

<div id="div_crud_content"></div>

<script type="text/javascript">
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
function income_type_save_modal()
{
	$('#btn_new_income_type').button('loading');
	$.post('income_type/save_modal.php',{}, function(data){
		$('#div_crud_content').html(data);
		$('#btn_new_income_type').button('reset');
	});
}
function income_save_modal()
{
	$('#btn_new_income').button('loading');
	$.post('income/save_modal.php',{}, function(data){
		$('#div_crud_content').html(data);
		$('#btn_new_income').button('reset');
	});
}
function income_list_reflect()
{
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var income_type_id = $('#income_type_id_filter').val();
	var financial_year_id = $('#financial_year_id_filter').val();

	$.post('income/list_reflect.php',{ from_date : from_date, to_date : to_date, income_type_id : income_type_id, financial_year_id : financial_year_id }, function(data){
		$('#div_list').html(data);
	});
}
income_list_reflect();

function update_income_modal(income_id)
{
	$.post('income/update_modal.php',{ income_id : income_id }, function(data){
		$('#div_crud_content').html(data);
	});
}

function excel_report()
  {
    var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var income_type_id = $('#income_type_id_filter').val();
	var financial_year_id = $('#financial_year_id_filter').val();
    
    window.location = 'excel_report.php?income_type_id='+income_type_id+'&from_date='+from_date+'&to_date='+to_date+'&financial_year_id='+financial_year_id;
  }

</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>