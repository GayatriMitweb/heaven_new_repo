<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Visa Supplier',86) ?>

<div class="row text-right mg_bt_20">
	<div class="col-xs-12">
		<button class="btn btn-info ico_left btn-sm" id="btn_new_income" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Payment</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select id="sup_id_filter" name="sup_id_filter" style="width:100%" title="Supplier">
				<option value="">Select Supplier</option>
				<?php 
				$sq_sup = mysql_query("select * from visa_vendor where active_flag='Active' ");
				while($row_sup = mysql_fetch_assoc($sq_sup)){
					?>
					<option value="<?= $row_sup['vendor_id'] ?>"><?= $row_sup['vendor_name'] ?></option>
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
			<button class="btn btn-sm btn-info ico_right"  onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>


<div id="div_list" class="main_block"></div>

<div id="div_crud_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script type="text/javascript">
$('#sup_id_filter').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });

function save_modal()
{
	$('#btn_new_income').button('loading');
	$.post('save_modal.php',{}, function(data){
		$('#div_crud_content').html(data);
		$('#btn_new_income').button('reset');
	});
}
function list_reflect()
{
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var supp_id = $('#sup_id_filter').val();
	var financial_year_id = $('#financial_year_id_filter').val();
	$.post('list_reflect.php',{ from_date : from_date, to_date : to_date, supp_id : supp_id, financial_year_id : financial_year_id }, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();

function update_income_modal(id)
{
	$.post('update_modal.php',{ id : id }, function(data){
		$('#div_crud_content').html(data);
	});
}


</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>