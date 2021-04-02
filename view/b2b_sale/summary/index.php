<?php 
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='reports/reports_homepage.php'"));
$branch_status = $sq['branch_status'];
?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row mg_bt_10">
	<div class="col-md-12 text-right">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>
 
 <div class="app_panel_content Filter-panel">
 <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="cust_filter" id="cust_filter" onchange="booking_reflect();list_reflect();" style="width:100%" data-toggle="tooltip" title="Select Company Name">
            <?php
            $sq_rc = mysql_query("select * from customer_master where type='B2B' and active_flag='Active'"); ?>
            <option value="">Select Company Name</option>
            <?php
            while($row_rc = mysql_fetch_assoc($sq_rc)){
              ?>
              <option value="<?= $row_rc['customer_id'] ?>"><?=  $row_rc['company_name'] ?></option>
              <?php } ?>     
            </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="b2b_booking_master" id="b2b_booking_master" style="width:100%" onchange="list_reflect();" title="Select Booking ID" data-toggle="tooltip">
              <option value="">Select Booking</option></select>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
          <input type="text" id="from_date_filter" name="from_date_filter" onchange="list_reflect();" placeholder="From Date"  data-toggle="tooltip" title="From Date">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
          <input type="text" id="to_date_filter" name="to_date_filter" onchange="list_reflect();" placeholder="To Date" data-toggle="tooltip" title="To Date">
        </div>
    </div>
 </div>	
	

</div>	
<div id="div_list" class="main_block">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="package_tour_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<div id="div_package_content_display"></div>

<script>

$('#from_date_filter,#to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
// dynamic_customer_load('','');
$('#cust_filter,#b2b_booking_master').select2();
var column = [
	{ title : "S_No."},
	{ title:"Booking_ID", className:"text-center"},
	{ title : "Customer_Name"},
	{ title : "Contact"},
	{ title : "EMAIL_ID"},
	{ title : "Booking_Date"},
	{ title : "Sale", className:"info text-right"},
	{ title : "Cancel", className:"danger text-right"},
	{ title : "Total", className:"info text-right"},
	{ title : "Paid", className:"success text-right"},
	{ title : "View"},
	{ title : "Outstanding_Balance", className:"warning text-right"},
	{ title : "Purchase"},
	{ title : "Purchased_From"},
	{ title : "Purchased_History"},
	{ title : "Booked_By"},
	{ title : "Incentive" },
	{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions", className:"text-center action_width"}
	
];
function list_reflect()
{
	var base_url = $('#base_url').val();
	var customer_id = $('#cust_filter').val();
	var b2b_booking_master = $('#b2b_booking_master').val();
	var from_date = $('#from_date_filter').val();
    var to_date = $('#to_date_filter').val();

	$.post(base_url+'view/b2b_sale/summary/list_reflect.php', { customer_id : customer_id, b2b_booking_master : b2b_booking_master, from_date : from_date, to_date : to_date}, function(data){
		// alert(data);
		pagination_load(data, column, true, true, 20, 'package_tour_report');
	});
}
list_reflect();

function excel_report()
{
	var customer_id = $('#cust_filter').val();
	var b2b_booking_master = $('#b2b_booking_master').val();
	var from_date = $('#from_date_filter').val();
    var to_date = $('#to_date_filter').val();
	var base_url = $('#base_url').val();
	var branch_status = $('#branch_status').val();
	window.location = base_url+'view/b2b_sale/summary/excel_report.php?customer_id='+customer_id+'&b2b_booking_master='+b2b_booking_master+'&from_date='+from_date+'&to_date='+to_date+'&branch_status='+branch_status;
}
function booking_reflect()
{  
	var base_url = $('#base_url').val();
	var customer_id = $('#cust_filter').val();
  $.post( base_url+'view/b2b_sale/booking_reflect.php', { customer_id : customer_id}, function(data){
    $('#b2b_booking_master').html(data);
  });
}
booking_reflect();
//*******************Get Dynamic Customer Name Dropdown**********************//
// function dynamic_customer_load(cust_type, company_name)
// {
//   var cust_type = $('#cust_type_filter').val();
//   var company_name = $('#company_filter').val();
//   var branch_status = $('#branch_status').val();
//   var base_url = $('#base_url').val();
//     $.get(base_url+"view/package_booking/booking/inc/get_customer_dropdown.php", { cust_type : cust_type , company_name : company_name, branch_status : branch_status}, function(data){
//     $('#customer_div').html(data);
//   });   
// }
// function company_name_reflect()
// {  
// 	var cust_type = $('#cust_type_filter').val();
//     var base_url = $('#base_url').val();
//      var branch_status = $('#branch_status').val();
//   	$.post(base_url+'view/package_booking/booking/company_name_load.php', { cust_type : cust_type, branch_status : branch_status }, function(data){
//   		if(cust_type=='Corporate'){
// 	  		$('#company_div').addClass('company_class');	
// 	    }
// 	    else
// 	    {
// 	    	$('#company_div').removeClass('company_class');		
// 	    }
// 	    $('#company_div').html(data);
//     });
// }

// function customer_booking_dropdown_load()
// {
//   var customer_id = $('#customer_id_filter').val();
//   var base_url = $('#base_url').val();
//   $.post(base_url+'view/b2b_sale/booking/inc/customer_booking_dropdown_load.php', { customer_id : customer_id }, function(data){
//         $('#booking_id_filter').html(data);
//     });
// }
function package_view_modal(booking_id)
  {
    var base_url = $('#base_url').val();
    $.post(base_url+'view/b2b_sale/summary/view/index.php', { booking_id : booking_id }, function(data){
      $('#div_package_content_display').html(data);
    });
  }
  function supplier_view_modal(booking_id)
  {
    var base_url = $('#base_url').val();
    $.post(base_url+'view/b2b_sale/summary/view/supplier_view_modal.php', { booking_id : booking_id }, function(data){
      $('#div_package_content_display').html(data);
    });
  }
function payment_view_modal(booking_id)
{
	var base_url = $('#base_url').val();
	$.post(base_url+'view/b2b_sale/summary/view/payment_view_modal.php', { booking_id : booking_id }, function(data){	
	  $('#div_package_content_display').html(data);
	});
}
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>