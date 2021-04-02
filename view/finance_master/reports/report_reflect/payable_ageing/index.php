<?php include "../../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='finance_master/reports/index.php'"));
$branch_status = $sq['branch_status'];
?>

<input type="hidden" name="branch_status" value="<?= $branch_status ?>" id="branch_status">
<input type="hidden" name="role" value="<?= $role ?>" id="role">
<input type="hidden" name="branch_admin_id" value="<?= $branch_admin_id ?>" id="branch_admin_id">

<div class="row text-right mg_bt_10">
  <div class="col-md-12">
    <button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
  </div>
</div>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
			 <input type="text" id="till_date" name="till_date" placeholder="Select Date" onchange="report_reflect()" title="Select Date" value="<?= date('d-m-Y') ?>" >
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<select name="vendor_type2" id="vendor_type2" title="Supplier Type" onchange="vendor_type_data_load(this.value, 'div_vendor_type_content2', '2');report_reflect();">
				<option value="">Supplier Type</option>
				<?php 
				$sq_vendor = mysql_query("select * from vendor_type_master order by vendor_type");
				while($row_vendor = mysql_fetch_assoc($sq_vendor)){
					?>
					<option value="<?= $row_vendor['vendor_type'] ?>"><?= $row_vendor['vendor_type'] ?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div id="div_vendor_type_content2"></div>
	</div>
</div>

<hr>
<!-- <div id="div_report_pay" class="main_block loader_parent"></div> -->
<div id="div_modal"></div>
<div class="row mg_tp_10 main_block">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="pay_age" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div></div>
<script type="text/javascript">
$('#month_filter').select2(); 
$('#till_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

function vendor_type_data_load(vendor_type, for_id, offset='', vendor_type_id='')
{
  var base_url = $('#base_url').val();
  $.post(base_url+'view/finance_master/reports/report_reflect/payable_ageing/vendor_type_data_load.php', { vendor_type : vendor_type, offset : offset, vendor_type_id : vendor_type_id }, function(data){
    $('#'+for_id).html(data);   
  });
}

function vendor_type_data_load_p(vendor_type, for_id, vendor_type_id='')
{
  var base_url = $('#base_url').val();
  $.post(base_url+'view/vendor/inc/payment_for_purchases_supplier.php', { vendor_type : vendor_type, vendor_type_id : vendor_type_id }, function(data){
    $('#'+for_id).html(data);  
  });
}
var column = [
{ title : "S_No."},
{ title:"Supplier_Type", className:"text-center"},
{ title : "Supplier_name", className:"text-center"},
{ title : "View", className:"text-center"},
{ title : "Total_Outstanding", className:"text-center"},
{ title : "Not_Due", className:"text-center"},
{ title : "Total_Due", className:"text-center"},
{ title : "0_To_30", className:"text-center"},
{ title : "31_To_60", className:"text-center"},
{ title : "61_To_90", className:"text-center"},
{ title : "91_To_120", className:"text-center"},
{ title : "121_To_180", className:"text-center"},
{ title : "181_To_360", className:"text-center"},
{ title : "361_&_above", className:"text-center"}
];
function report_reflect()
{
  $('#div_report_pay').append('<div class="loader"></div>');
	var till_date = $('#till_date').val();
	var vendor_type = $('#vendor_type2').val();
 	var vendor_type_id = get_vendor_type_id('vendor_type2', '2');
  var branch_status = $('#branch_status').val();
  var branch_admin_id = $('#branch_admin_id').val();
  var role = $('#role').val();

	$.post('report_reflect/payable_ageing/get_supplier_purchase.php',{ till_date : till_date, vendor_type : vendor_type,vendor_type_id : vendor_type_id , branch_status : branch_status , role : role,branch_admin_id : branch_admin_id }, function(data){
		// console.log(data);
    pagination_load(data, column, true, true, 20, 'pay_age');
	});
}
function view_modal(booking_id_arr,pending_amt_arr,not_due_arr,total_days_arr,due_date_arr)
{
	$.post('report_reflect/payable_ageing/view_modal.php', {booking_id_arr : booking_id_arr,pending_amt_arr : pending_amt_arr,total_days_arr : total_days_arr,not_due_arr : not_due_arr,due_date_arr : due_date_arr}, function(data){
 
		$('#div_modal').html(data);

	});

}
function get_vendor_type_id(vendor_id, offset='')
{
  var vendor_type = $('#'+vendor_id).val();

  if(vendor_type=="Hotel Vendor"){
    var hotel_id = $('#hotel_id'+offset).val();
    return hotel_id;
  }
  else if(vendor_type=="Transport Vendor"){
    var transport_agency_id = $('#transport_agency_id'+offset).val();
    return transport_agency_id;
  }
  else if(vendor_type=="Car Rental Vendor"){
    var vendor_id = $('#vendor_id'+offset).val();
    return vendor_id;
  }
  else if(vendor_type=="DMC Vendor"){
    var dmc_id = $('#dmc_id'+offset).val();
    return dmc_id;
  }
  else if(vendor_type=="Cruise Vendor"){
    var cruise_id = $('#cruise_id'+offset).val();
    return cruise_id;
  }
  else if(vendor_type=="Visa Vendor" || vendor_type=="Passport Vendor" || vendor_type=="Ticket Vendor" || vendor_type=="Train Ticket Vendor" || vendor_type=="Excursion Vendor" || vendor_type=="Insurance Vendor" || vendor_type=="Other Vendor"){
    var vendor_id = $('#vendor_id'+offset).val();
    return vendor_id;
  }  
  else{
    return '';
  }
}

function excel_report()
{
  var till_date = $('#till_date').val();
  var vendor_type = $('#vendor_type2').val();
  var vendor_type_id = get_vendor_type_id('vendor_type2', '2');
  var branch_status = $('#branch_status').val();
  var branch_admin_id = $('#branch_admin_id').val();
  var role = $('#role').val();

  if(till_date == '' && vendor_type_id == ''){
    error_msg_alert("Select atleast one filter");
    return false;
  }
  window.location = 'report_reflect/payable_ageing/excel_report.php?till_date='+till_date+'&vendor_type='+vendor_type+'&vendor_type_id='+vendor_type_id+'&branch_status='+branch_status+'&branch_admin_id='+branch_admin_id+'&role='+role;
}
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>