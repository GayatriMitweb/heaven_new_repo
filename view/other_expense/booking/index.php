<?php 
include_once('../../../model/model.php');
$role = $_SESSION['role'];
$emp_id= $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
include_once('expense_save_modal.php');
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>">
<div class="row text-right"> <div class="col-xs-12">
	<button class="btn btn-excel btn-sm mg_bt_20" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
	<button class="btn btn-info btn-sm ico_left mg_bt_10" data-toggle="modal" data-target="#expense_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Expense</button>
</div> </div>

	
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
			<div class="col-md-3 col-sm-6 col-xs-12">
				<button class="btn btn-sm btn-info ico_right" onclick="expense_estimate_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			</div>
		</div>
	</div>

<div id="div_expense_estimate_list" class="main_block loader_parent"></div>
<div id="div_expense_estimate_update" class="main_block"></div>

<script>
$('#supplier_type1,#expense_type1').select2();

function expense_estimate_list_reflect()
{
	$('#div_expense_estimate_list').append('<div class="loader"></div>');
	var expense_type = $('#expense_type1').val();
	var supplier_type = $('#supplier_type1').val();
	var branch_status = $('#branch_status').val();

	$.post('booking/expense_list_reflect.php', { supplier_type : supplier_type, expense_type : expense_type, branch_status : branch_status}, function(data){		
		$('#div_expense_estimate_list').html(data);
	});
}
expense_estimate_list_reflect();

function excel_report()
{
	var expense_type = $('#expense_type1').val();
	var supplier_type = $('#supplier_type1').val();
	var branch_status = $('#branch_status').val();

	window.location = 'booking/excel_report.php?supplier_type='+supplier_type+'&expense_type='+expense_type+'&branch_status='+branch_status;


}

function expense_update_modal(expense_id)
{
	$.post('booking/expense_update_modal.php', { expense_id : expense_id}, function(data){		
		$('#div_expense_estimate_update').html(data);
	});
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>