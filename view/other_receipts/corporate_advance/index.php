<?php
include "../../../model/model.php";
$role= $_SESSION['role'];
$emp_id= $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='other_receipts/index.php'"));
$branch_status1 = $sq['branch_status'];
?>
 <input type="hidden" id="branch_status1" name="branch_status1" value="<?= $branch_status1 ?>" >
<div class="row text-right mg_bt_20">
	<div class="col-xs-12">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<button class="btn btn-info ico_left btn-sm" id="btn_new_income" onclick="income_save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Advance</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select id="cust_id_filter" name="cust_id_filter" style="width:100%" title="Customer" class="form-control">
				  <?php get_corpo_customer_dropdown($role,$branch_admin_id,$branch_status1); ?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" name="from_date_filter" id="from_date_filter" placeholder="From Date" title="From Date" class="form-control" onchange="validate_validDate('from_date_filter','to_date_filter');">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" name="to_date_filter" id="to_date_filter" placeholder="To Date" title="To Date" class="form-control" onchange="validate_validDate('from_date_filter','to_date_filter');">
		</div>
		<div class="col-xs-3">
			<button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>


<div id="div_list" class="main_block loader_parent mg_tp_20">
<div class="table-responsive">
        <table id="corp_r_book" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>

<div id="div_crud_content"></div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script type="text/javascript">
$('#cust_id_filter').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
var columns = [
	{ title : "S_No"},
    { title : "Customer"},
	{ title : "Date"},
	{ title : "Mode"},
	{ title : "particular"},
	{ title : "Amount", className : "success"},
	<?php if($role == 'Branch Admin' || $role == 'Admin'){ ?>
		{ title : "Actions", className : "text-center"}
	<?php } ?>
	
];
function income_save_modal()
{
	var branch_status1 = $('#branch_status1').val();
	$('#btn_new_income').button('loading');
	$.post('corporate_advance/save_modal.php',{branch_status : branch_status1}, function(data){
		$('#div_crud_content').html(data);
		$('#btn_new_income').button('reset');
	});
}
function list_reflect()
{
	$('#div_list').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var cust_id = $('#cust_id_filter').val();
	var branch_status1 = $('#branch_status1').val();
	$.post('corporate_advance/list_reflect.php',{ from_date : from_date, to_date : to_date, cust_id : cust_id , branch_status : branch_status1}, function(data){
		//$('#div_list').html(data);
		pagination_load(data,columns,true,true,10,'corp_r_book');
        $('.loader').remove();
	});
}
$(function () {
	$("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
	$("[data-toggle='tooltip']").click(function(){$('.tooltip').remove()})
});
list_reflect();

function update_income_modal(advance_id)
{
	var branch_status1 = $('#branch_status1').val();
	$.post('corporate_advance/update_modal.php',{ advance_id : advance_id , branch_status : branch_status1}, function(data){
		$('#div_crud_content').html(data);
	});
}

function excel_report()
  {
    var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var cust_id = $('#cust_id_filter').val();
	var financial_year_id = $('#financial_year_id_filter').val();
    var branch_status1 = $('#branch_status1').val();
    window.location = 'corporate_advance/excel_report.php?cust_id='+cust_id+'&from_date='+from_date+'&to_date='+to_date+'&financial_year_id='+financial_year_id+'&branch_status='+branch_status1;
  }

</script>