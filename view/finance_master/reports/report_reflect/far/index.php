<?php include "../../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='finance_master/reports/index.php'"));
$branch_status = $sq['branch_status'];
?>
<input type="hidden" name="branch_status" value="<?= $branch_status ?>" id="branch_status">
<input type="hidden" name="role" value="<?= $role ?>" id="role">
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>" >

<div class="row text-right mg_bt_10">
	<div class="col-md-4 col-md-offset-8">
            <button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
            <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()" title="Add New"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Asset</button>			
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
        <div class="col-md-3">
          <select id="asset_type1" name="asset_type1" onchange="get_assets(this.id,'1');report_reflect();" style="width: 100%">
            <option value="">Type of Asset</option>
            <?php 
            $sq_query = mysql_query("select distinct(asset_type) from fixed_asset_master");
            while($row_query = mysql_fetch_assoc($sq_query)){ ?>
              <option value="<?= $row_query['asset_type'] ?>"><?= $row_query['asset_type'] ?></option>
            <?php } ?>

          </select>
        </div>
		<div class="col-md-3">
			<select id="asset_name1" name="asset_name1" onchange="report_reflect();" style="width: 100%">
                <option value="">Asset Name</option>
              </select>
		</div>
	</div>
</div>
<hr>
<div id="div_report" class="main_block loader_parent">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="rep_ref" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<div id="display_modal" class="main_block"></div>

<script type="text/javascript">
$('#asset_type1, #asset_name1').select2();
$('#from_date_filter1').datetimepicker({ timepicker:false, format:'d-m-Y' }); 

function save_modal()
{ 
	var base_url = $('#base_url').val();
  	var branch_admin_id = $('#branch_admin_id').val();
	$('#btn_save').button('loading');

	$.post(base_url+'view/finance_master/reports/report_reflect/far/save_modal.php', {branch_admin_id : branch_admin_id }, function(data){
		$('#btn_save').button('reset');
		$('#div_modal').html(data);
	});
}

function get_assets(asset_type,offset=''){
	var asset_type = $('#'+asset_type).val();
	$.post('report_reflect/far/get_assets.php', {asset_type : asset_type}, function(data){
        $('#asset_name'+offset).html(data);
    });
}
var column = [
	{ title : "S_No."},
	{ title : "asset_type"},
	{ title : "Asset_name"},
	{ title : "ASset_Ledger_name"},
	{ title : "Purchase_Date"},
	{ title : "Purchase_Amount"},
	{ title : "Opening_Carrying_amount"},
	{ title : "Rate_Of_Depreciation"},
	{ title : "Depreciation"},
	{ title : "Accumulated_Depreciation"},
	{ title : "Closing_Carrying_amount"},
	{ title : "View"},
];
function report_reflect()
{
	$('#div_report').append('<div class="loader"></div>');
	var asset_name = $('#asset_name1').val();
	var asset_type1 = $('#asset_type1').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();
	$.post('report_reflect/far/report_reflect.php',{  asset_type : asset_type1,asset_name : asset_name,branch_admin_id : branch_admin_id,branch_status : branch_status, role : role  }, function(data){
		pagination_load(data, column, true, false, 20, 'rep_ref');
		$('.loader').remove();
	});
}
report_reflect();
function calculate_depreciation_amount(purchase_amount,depr_type,rate_of_depr,financial_year_id,purchase_date,asset_name,asset_ledger,offset='')
{
	var purchase_amount = $('#'+purchase_amount).val();
	var depr_type = $('#'+depr_type).val();
	var rate_of_depr = $('#'+rate_of_depr).val();
	var financial_year_id = $('#'+financial_year_id).val();
	var purchase_date = $('#'+purchase_date).val();
	var asset_name = $('#'+asset_name).val();
	var asset_ledger = $('#'+asset_ledger).val();

	if(purchase_amount == '') { purchase_amount = 0; }
	if(rate_of_depr == '') { rate_of_depr = 0; }
	if(financial_year_id == '') { financial_year_id = 0; }

	$.post('report_reflect/far/calculate_depreciation_amount.php',{  purchase_amount : purchase_amount,depr_type : depr_type,rate_of_depr : rate_of_depr,financial_year_id : financial_year_id ,purchase_date : purchase_date,asset_name : asset_name,asset_ledger : asset_ledger }, function(data){

		var data1 = parseFloat(data);
		$('#depr_amount'+offset).val(data1.toFixed(2));

		var diff_after = parseFloat(purchase_amount) - parseFloat(data1);
		diff_after = parseFloat(diff_after);
		$('#carrying_amount'+offset).val(diff_after.toFixed(2));

	});
}
function display_modal(id,asset_ledger,asset_id)
{
    $.post('report_reflect/far/update_modal.php', {id : id,asset_ledger : asset_ledger,asset_id : asset_id}, function(data){
        $('#display_modal').html(data);
    });
}

function calculate_profit_loss(offset){
	var sold_amount = $('#sold_amount'+offset).val();
	var carrying_amount = $('#carrying_amount'+offset).val();

	if(sold_amount == ''){ sold_amount = 0; }
	if(carrying_amount == ''){ carrying_amount = 0; }

	diff_after = parseFloat(sold_amount) - parseFloat(carrying_amount);
	diff_after = parseFloat(diff_after);
	$('#profit_loss'+offset).val(diff_after.toFixed(2));
}

function excel_report()
{
	var asset_name = $('#asset_name1').val();
	var asset_type = $('#asset_type1').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();
	
	window.location = 'report_reflect/far/excel_report.php?asset_name='+asset_name+'&asset_type='+asset_type+'&branch_admin_id='+branch_admin_id+'&branch_status='+branch_status+'&branch_admin_id='+branch_admin_id+'&role='+role;
}

</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>