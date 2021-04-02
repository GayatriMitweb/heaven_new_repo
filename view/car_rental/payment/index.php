<?php
include "../../../model/model.php";
/*======******Header******=======*/
// require_once('../../layouts/admin_header.php');
$role= $_SESSION['role'];
$emp_id= $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$role_id = $_SESSION['role_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='car_rental/payment/index.php'"));
$branch_status = $sq['branch_status'];
require_once('payment_save_modal.php');
?>
 <!-- begin_panel('Car Rental Receipt',81) ?> -->
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
 <input type="hidden" id="whatsapp_switch"  value="<?= $whatsapp_switch ?>" >
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm mg_bt_10" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<button class="btn btn-info btn-sm ico_left mg_bt_10" data-toggle="modal" data-target="#payment_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Receipt</button>
	</div>
</div>


<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="booking_id_filter" id="booking_id_filter" style="width:100%" title="Booking ID">
		        <?php get_car_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id);   ?>
		    </select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="payment_mode_filter" id="payment_mode_filter" title="Mode" class="form-control" title="Mode">
				<?php get_payment_mode_dropdown(); ?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 hidden">
			<select name="financial_year_id_filter" id="financial_year_id_filter" title="Financial Year">
				<?php get_financial_year_dropdown(); ?>
			</select>
		</div>		
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="payment_from_date_filter" name="payment_from_date_filter" placeholder="From Date" class="form-control" title="From Date" onchange="validate_validDate('payment_from_date_filter','payment_to_date_filter');">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="payment_to_date_filter" class="form-control" name="payment_to_date_filter" placeholder="To Date" title="To Date" onchange="validate_validDate('payment_from_date_filter','payment_to_date_filter');">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<button class="btn btn-sm btn-info ico_right" onclick="payment_list_reflect();bank_receipt()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>


<div id="div_payment_list" class="main_block mg_tp_20">
<div class="table-responsive">
        <table id="car_r_book" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="div_payment_update"></div>
<div id="receipt_data"></div>
<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
$('#payment_from_date_filter, #payment_to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#booking_id_filter').select2();
var columns = [
	{ title : "S_No"},
	{ title : "", "bSortable": false},
	{ title : "Booking_ID"},
  	{ title : "Customer_Name"},
	{ title : "Mode"},
	{ title : "Receipt_Date"},
	{ title : "Branch_Name"},
	{ title : "Amount", className : "success"},
	{ title : "Actions", className : "text-center"}
];
function payment_list_reflect()
{
	var booking_id = $('#booking_id_filter').val();
	var payment_mode = $('#payment_mode_filter').val();
	var financial_year_id = $('#financial_year_id_filter').val();
	var payment_from_date = $('#payment_from_date_filter').val();
	var payment_to_date = $('#payment_to_date_filter').val();
	var branch_status = $('#branch_status').val();
	$.post('../payment/payment_list_reflect.php', { booking_id : booking_id, payment_mode : payment_mode, financial_year_id : financial_year_id, payment_from_date : payment_from_date, payment_to_date : payment_to_date, branch_status : branch_status }, function(data){
		// $('#div_payment_list').html(data);
		pagination_load(data,columns,true,true,10,'car_r_book');
        $('.loader').remove();
	});
}
payment_list_reflect();

function payment_update_modal(payment_id)
{
	var branch_status = $('#branch_status').val();
	$.post('../payment/payment_update_modal.php', { payment_id : payment_id, branch_status : branch_status}, function(data){
		console.log(data);
		$('#div_payment_update').html(data);
	});
}
$(function () {
	$("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
	$("[data-toggle='tooltip']").click(function(){$('.tooltip').remove()})
});
function cash_bank_receipt_generate()
{
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();

	$('input[name="chk_car_rental_payment"]:checked').each(function(){
		payment_id_arr.push($(this).val());
	});
	if(payment_id_arr.length==0){
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}

	var base_url = $('#base_url').val();
	var url = base_url+"view/bank_receipts/car_rental_payment/cash_bank_receipt.php?payment_id_arr="+payment_id_arr+'&bank_name_reciept='+bank_name_reciept;
	window.open(url, '_blank');
}

function cheque_bank_receipt_generate()
{
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();
	var branch_name_arr = new Array();

	$('input[name="chk_car_rental_payment"]:checked').each(function(){
		var id = $(this).attr('id');
		var offset = id.substring(23);
		var branch_name = $('#branch_name_'+offset).val();

		payment_id_arr.push($(this).val());
		branch_name_arr.push(branch_name);
	});

	if(payment_id_arr.length==0){
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}
	$('input[name="chk_car_rental_payment"]:checked').each(function(){

		var id = $(this).attr('id');
		var offset = id.substring(23);
		var branch_name = $('#branch_name_'+offset).val();

		if(branch_name==""){
			error_msg_alert("Please enter branch name for selected payments!");				
			exit(0);
		}
	});
	var base_url = $('#base_url').val();

	var url = base_url+"view/bank_receipts/car_rental_payment/cheque_bank_receipt.php?payment_id_arr="+payment_id_arr+'&branch_name_arr='+branch_name_arr+'&bank_name_reciept='+bank_name_reciept;
	window.open(url, '_blank');
}
function bank_receipt(){
	var payment_mode = $('#payment_mode_filter').val();
	var base_url = $('#base_url').val();
	$.post(base_url+'view/hotels/booking/payment/bank_receipt_generate.php',{payment_mode : payment_mode}, function(data){
		$('#receipt_data').html(data);
	});
}

function excel_report()
{
  	var booking_id = $('#booking_id_filter').val();
	var payment_mode = $('#payment_mode_filter').val();
	var financial_year_id = $('#financial_year_id_filter').val();
	var payment_from_date = $('#payment_from_date_filter').val();
	var payment_to_date = $('#payment_to_date_filter').val();
  	var branch_status = $('#branch_status').val();
  window.location = '../payment/excel_report.php?booking_id='+booking_id+'&payment_from_date='+payment_from_date+'&payment_to_date='+payment_to_date+'&financial_year_id='+financial_year_id+'&payment_mode='+payment_mode+'&branch_status='+branch_status;
}
function whatsapp_send_r(booking_id, payment_amount, base_url){
	$.post(base_url+'controller/car_rental/payment/receipt_whatsapp_send.php',{booking_id:booking_id, payment_amount:payment_amount}, function(data){
	window.open(data);
	});
}
</script>
<?php
/*======******Footer******=======*/
// require_once('../../layouts/admin_footer.php'); 
?>