<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
include_once('payment_save_modal.php');
?>
<div class="row text-right mg_bt_20">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
		<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#v_payment_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Payment</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
        <select name="expense_type1" id="expense_type1" title="Expense Type" class="form-control">
          <option value="">Expense Type</option>
          <?php 
          $sq_expense = mysql_query("select * from ledger_master where group_sub_id in ('84','44','47','43','75','81','82','59','103','51','35','69','97','98','76','57','88','80','92','72','9','7','8')");
          while($row_expense = mysql_fetch_assoc($sq_expense)){
            ?>
            <option value="<?= $row_expense['ledger_id'] ?>"><?= $row_expense['ledger_name'] ?></option>
            <?php
          }
          ?>
        </select>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
        <select name="supplier_type1" id="supplier_type1" title="Supplier Type" class="form-control">
          <option value="">Supplier Name</option>
          <?php 
          $sq_expense = mysql_query("select * from other_vendors order by vendor_name");
          while($row_expense = mysql_fetch_assoc($sq_expense)){
            ?>
            <option value="<?= $row_expense['vendor_id'] ?>"><?= $row_expense['vendor_name'] ?></option>
            <?php
          }
          ?>
        </select>
      </div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 hidden">
			<select name="financial_year_id_filter" id="financial_year_id_filter" title="Financial Year" class="form-control">
				<?php get_financial_year_dropdown(); ?>
			</select>
		</div>
		<div class="col-md-3">
			<button class="btn btn-sm btn-info ico_right" onclick="payment_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>
</div>
<div id="div_exp_report_content" class="main_block loader_parent"></div>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#expense_type1,#supplier_type1').select2();
function payment_list_reflect()
{
  $('#div_exp_report_content').append('<div class="loader"></div>');
	var expense_type = $('#expense_type1').val();
  var supplier_type = $('#supplier_type1').val();
  var financial_year_id = $('#financial_year_id_filter').val();
  var branch_status = $('#branch_status').val();
	$.post('payment/payment_list_reflect.php', { supplier_type : supplier_type, expense_type : expense_type, financial_year_id : financial_year_id, branch_status : branch_status }, function(data){
		$('#div_exp_report_content').html(data);
	});
}
payment_list_reflect();


function excel_report()
{
	var expense_type = $('#expense_type1').val();
  var supplier_type = $('#supplier_type1').val();
  var financial_year_id = $('#financial_year_id_filter').val();
  var branch_status = $('#branch_status').val();
	window.location = 'payment/excel_report.php?financial_year_id='+financial_year_id+'&expense_type='+expense_type+'&supplier_type='+supplier_type+'&branch_status='+branch_status;
}

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>