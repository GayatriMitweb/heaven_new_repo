<?php
include "../../../../model/model.php";
$branch_status = $_POST['branch_status'];
$role_id = $_SESSION['role_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
?>
<input type="hidden" id="whatsapp_switch" value="<?= $whatsapp_switch?>">
<div class="row text-right mg_bt_20">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#passport_payment_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Receipt</button>
	</div>
</div>
<?php include_once('save_payment_modal.php'); ?>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		        <select name="cust_type_filter" id="cust_type_filter" class="form-control" onchange="dynamic_customer_load(this.value,'company_filter');company_name_reflect();" title="Customer Type" style="width:100%">
		            <?php get_customer_type_dropdown(); ?>
		            
		            
					
                    
		        </select>
	    </div>
	    <div id="company_div" class="hidden">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">
	    </div> 
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="passport_id_filter" id="passport_id_filter" style="width:100%" title="Booking ID">
		        <?php get_passport_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id) ?>
		    </select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="payment_mode_filter" id="payment_mode_filter" class="form-control" title="Mode">
				<?php get_payment_mode_dropdown(); ?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 hidden">
			<select name="financial_year_id_filter" id="financial_year_id_filter" title="Financial Year">
				<?php get_financial_year_dropdown(); ?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="payment_from_date_filter" name="payment_from_date_filter" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'payment_to_date_filter');">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="payment_to_date_filter" name="payment_to_date_filter" placeholder="To Date" title="To Date" onchange="validate_validDate('payment_from_date_filter','payment_to_date_filter')">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 text-center">
			<button class="btn btn-sm btn-info ico_right" onclick="passport_payment_list_reflect();bank_receipt()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

<div id="div_passport_payment_list" class="main_block mg_tp_10">
<div class="table-responsive">
        <table id="pass_r_book" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="div_passport_payment_update"></div>
<div id="receipt_data"></div>

<script>
	$('#payment_from_date_filter, #payment_to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
	$('#customer_id_filter, #passport_id_filter,#cust_type_filter').select2();
	dynamic_customer_load('','');
	var columns = [
		{ title : "S_No"},
		{ title : " "},
		{ title : "Booking_ID"},
		{ title : "Customer_Name"},
		{ title : "Receipt_Date"},
		{ title : "Mode"},
		{ title : "Branch_Name"},
		{ title : "Amount", className : "success"},
		{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;", className : "text-center"},
	];
	$(document).ready(function () {
	$("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
	$("[data-toggle='tooltip']").click(function(){$('.tooltip').remove()})
});
	function passport_payment_list_reflect()
	{
		var customer_id = $('#customer_id_filter').val();
		var passport_id = $('#passport_id_filter').val();
		var payment_mode = $('#payment_mode_filter').val();
		var financial_year_id = $('#financial_year_id_filter').val();
		var payment_from_date = $('#payment_from_date_filter').val();
		var payment_to_date = $('#payment_to_date_filter').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();

		$.post('payment/passport_payment_list_reflect.php', { customer_id : customer_id, passport_id : passport_id, payment_mode : payment_mode, financial_year_id : financial_year_id, payment_from_date : payment_from_date, payment_to_date : payment_to_date, cust_type : cust_type, company_name : company_name, branch_status : branch_status }, function(data){
			//$('#div_passport_payment_list').html(data);
			pagination_load(data,columns,true,true,10,'pass_r_book');
		});
	}
	passport_payment_list_reflect();

	function passport_payment_update_modal(payment_id)
	{
		var branch_status = $('#branch_status').val();
		$.post('payment/passport_payment_update_modal.php', { payment_id : payment_id , branch_status : branch_status}, function(data){
			 $('#div_passport_payment_update').html(data);
		});
	}
	company_name_reflect();
	function excel_report()
	{
		var customer_id = $('#customer_id_filter').val()
		var passport_id = $('#passport_id_filter').val()
		var payment_mode = $('#payment_mode_filter').val();
		var from_date = $('#payment_from_date_filter').val();
		var to_date = $('#payment_to_date_filter').val();
		var financial_year_id = $('#financial_year_id_filter').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();
		
		window.location = 'payment/excel_report.php?customer_id='+customer_id+'&passport_id='+passport_id+'&from_date='+from_date+'&to_date='+to_date+'&payment_mode='+payment_mode+'&financial_year_id='+financial_year_id+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
	}
	function bank_receipt(){
			var payment_mode = $('#payment_mode_filter').val();
			var base_url = $('#base_url').val();
			$.post(base_url+'view/hotels/booking/payment/bank_receipt_generate.php',{payment_mode : payment_mode}, function(data){
				$('#receipt_data').html(data);
			});
		}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>