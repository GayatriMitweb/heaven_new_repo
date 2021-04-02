<?php
include "../../../model/model.php";

/*======******Header******=======*/
// require_once('../../layouts/admin_header.php');
// require_once('../../../classes/tour_booked_seats.php');
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='package_booking/booking/index.php'"));
$branch_status = $sq['branch_status'];
?>
 <!-- begin_panel('Package Booking',50) ?> -->
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<input type="hidden" id="whatsapp_switch" value="<?= $whatsapp_switch ?>" >

<div class="row text-right mg_bt_10">
	<div class="col-xs-12">
    <button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<form action="booking_save/package_booking_master_save.php" method="POST">
            <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
			      <button class="btn btn-info btn-sm ico_left"><i class="fa fa-plus"></i>&nbsp;&nbsp;Booking</button>&nbsp;&nbsp;
		</form>
	</div>
</div>
<div class="app_panel_content Filter-panel">
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
          <select name="cust_type_filter" class="form-control" id="cust_type_filter" onchange="dynamic_customer_load(this.value,'company_filter'); company_name_reflect();" title="Customer Type" style="width: 100%;">
              <?php get_customer_type_dropdown(); ?>              
          </select>
    </div>
    <div id="company_div" class="hidden">
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">    
    </div>  
    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
      <select id="booking_id_filter" name="booking_id_filter" style="width:100%" title="Booking ID"> 
          <?php get_package_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id); ?>
      </select>
    </div>  
    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
        <input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date">
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
        <input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date">
    </div>
    <div class="col-md-3 col-sm-12 col-xs-12 mg_bt_10">
        <button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
    </div> 
  </div>
</div>

<div id="div_list" class="main_block loader_parent mg_tp_10">
<div class="table-responsive mg_tp_10">
  <table id="packageb_table" class="table table-hover" style="margin: 20px 0 !important;">         
  </table>
</div>
</div>

<div id="div_package_content_display"></div>
<div id="voucher_modal"></div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#booking_id_filter,#customer_id_filter,#cust_type_filter').select2();
dynamic_customer_load('','');

var columns = [
  { title : "S_No. "},
	{ title : "Booking_ID "},
	{ title : "Customer_Name "},
	{ title : "Tour "},
  { title : "Created_by "},
  { title : "Actions" , className:"text-center"}
	
];
function list_reflect(){
  $('#div_list').append('<div class="loader"></div>');
  var customer_id = $('#customer_id_filter').val();
  var booking_id = $('#booking_id_filter').val();
  var from_date = $('#from_date_filter').val();
  var to_date = $('#to_date_filter').val();
  var cust_type = $('#cust_type_filter').val();
  var company_name = $('#company_filter').val();
  var branch_status = $('#branch_status').val();
  
	$.post('list_reflect.php', {customer_id : customer_id, booking_id : booking_id, from_date : from_date, to_date : to_date, cust_type : cust_type, company_name : company_name , branch_status : branch_status}, function(data){
		//$('#div_list').html(data);
    pagination_load(data, columns, true, false, 20, 'packageb_table');
		$('.loader').remove();
	});
}
list_reflect();
$(document).ready(function () {
	$("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
	$("[data-toggle='tooltip']").click(function(){$('.tooltip').remove()})
});
function generate_booking_pdfs(offset, booking_id){

  var pdf_type = $('#booking_pdf'+offset).val();

  if(pdf_type=="Booking Form"){
    var url = 'pdf/registration_form_pdf.php?booking_id='+booking_id;
  }
  window.open(url);

}
function customer_booking_dropdown_load()
{
  var customer_id = $('#customer_id_filter').val();
  var branch_status = $('#branch_status').val();
   $.post('inc/customer_booking_dropdown_load.php', { customer_id : customer_id , branch_status : branch_status}, function(data){
        $('#booking_id_filter').html(data);

    });
}
function excel_report(){
  var customer_id = $('#customer_id_filter').val();
  var booking_id = $('#booking_id_filter').val();
  var from_date = $('#from_date_filter').val();
  var to_date = $('#to_date_filter').val();
  var cust_type = $('#cust_type_filter').val();
  var company_name = $('#company_filter').val();
  var branch_status = $('#branch_status').val();
  window.location = 'excel_report.php?booking_id='+booking_id+'&from_date='+from_date+'&to_date='+to_date+'&customer_id='+customer_id+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
}
function company_name_reflect()
{  
  var cust_type = $('#cust_type_filter').val();
  var branch_status = $('#branch_status').val();
    $.post('company_name_load.php', { cust_type : cust_type, branch_status : branch_status }, function(data){
      if(cust_type=='Corporate'){
          $('#company_div').addClass('company_class');
        }
        else{
          $('#company_div').removeClass('company_class');
        }
      $('#company_div').html(data);

    });
}
// company_name_reflect();
function package_view_modal(booking_id){
    $.post('view/index.php', { booking_id : booking_id }, function(data){
      $('#div_package_content_display').html(data);
    });
}
//*******************Get Dynamic Customer Name Dropdown**********************//

function dynamic_customer_load(cust_type, company_name){
  var cust_type = $('#cust_type_filter').val();
  var company_name = $('#company_filter').val();
  var branch_status = $('#branch_status').val();
    $.get("inc/get_customer_dropdown.php", { cust_type : cust_type , company_name : company_name, branch_status : branch_status}, function(data){
    $('#customer_div').html(data);
  });
}
function voucher_modal(booking_id){
  $.get("voucher_modal.php", {booking_id : booking_id}, function(data){
      $('#voucher_modal').html(data);
  });
}
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
// require_once('../../layouts/admin_footer.php'); 
?>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>