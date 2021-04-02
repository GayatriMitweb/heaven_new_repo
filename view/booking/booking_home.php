<?php
include "../../model/model.php";
/*======******Header******=======*/
// require_once('../layouts/admin_header.php');
// include('../../layouts/app_functions.php');
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='booking/index.php'"));
$branch_status = $sq['branch_status'];
?>

<input type="hidden" id="whatsapp_switch" value="<?= $whatsapp_switch ?>" >
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
    <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
    <button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<form action="booking_save/booking_save.php" method="POST">
      <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
			<button class="btn btn-info btn-sm ico_left"><i class="fa fa-plus"></i>&nbsp;&nbsp;Booking</button>&nbsp;&nbsp;
		</form>
	</div>
</div>

<div class="app_panel_content Filter-panel">
  <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
        <select id="tour_id_filter" name="tour_id_filter" onchange="tour_group_dynamic_reflect(this.id,'group_id_filter');" style="width:100%" title="Tour Name"> 
            <option value="">Tour Name</option>
            <?php
                $sq=mysql_query("select tour_id,tour_name from tour_master where active_flag='Active' order by tour_name");
                while($row=mysql_fetch_assoc($sq))
                {
                  echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                }    
            ?>
        </select>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
        <select class="form-control" id="group_id_filter" name="group_id_filter" onchange="traveler_member_reflect();" title="Tour Group"> 
            <option value="">Tour Group</option>        
        </select>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
            <select name="cust_type_filter" id="cust_type_filter" class="form-control" onchange="dynamic_customer_load(this.value,'company_filter'); company_name_reflect();" title="Customer Type" style="width:100%">
                <?php get_customer_type_dropdown(); ?>
                
                
                
                
            </select>
      </div>
      <div id="company_div" class="hidden mg_bt_10_xs">
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">    
      </div>  
      <div class="col-md-3 col-sm-6 mg_bt_10_xs">
        <select id="booking_id_filter" name="booking_id_filter" style="width:100%" title="Booking ID"> 
            <?php get_group_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id); ?>
        </select>
      </div>    
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
          <input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date">
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
          <input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date">
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12 text-left">
          <button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
      </div>
  </div>
</div>

<div id="div_list" class="main_block loader_parent mg_tp_10">
<div class="table-responsive">
        <table id="gtour_table" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="view_modal"></div>

<script>
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#booking_id_filter, #tour_id_filter, #customer_id_filter, #cust_type_filter').select2();
dynamic_customer_load('','');
var columns = [
  { title : "S_No. " },
			{ title : "Booking_ID " },
			{ title : "Customer_Name " },
			{ title : "Tour " },
      { title : "Created_by " },
      { title: "Actions", className:"text-center" }
			
]
function business_rule_load(){
	get_auto_values('txt_date','basic_amount','cmb_payment_mode1','service_charge','markup','save','true','txt_total_discount','discount');
}
function list_reflect()
{
  $('#div_list').append('<div class="loader"></div>');
	var tour_id = $('#tour_id_filter').val();
  var group_id = $('#group_id_filter').val();
  var customer_id = $('#customer_id_filter').val();
  var booking_id = $('#booking_id_filter').val();
  var from_date = $('#from_date_filter').val();
  var to_date = $('#to_date_filter').val();
  var cust_type = $('#cust_type_filter').val();
  var company_name = $('#company_filter').val();
  var branch_status = $('#branch_status').val();

	$.post('list_reflect.php', { tour_id : tour_id, group_id : group_id, customer_id : customer_id, booking_id : booking_id, from_date : from_date, to_date : to_date , cust_type : cust_type, company_name : company_name, branch_status : branch_status}, function(data){
		//$('#div_list').html(data);
    pagination_load(data,columns, true,false, 20, 'gtour_table');
    $('.loader').remove();
	});
}

$(document).ready(function () {
	$("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
	$("[data-toggle='tooltip']").click(function(){$('.tooltip').remove()})
});


list_reflect();
function customer_booking_dropdown_load()
{
    var customer_id = $('#customer_id_filter').val();
     var branch_status = $('#branch_status').val();
    $.post('inc/customer_booking_dropdown_load.php', { customer_id : customer_id, branch_status : branch_status }, function(data){
        $('#booking_id_filter').html(data);
    });
}
function company_name_reflect()
{  
  var cust_type = $('#cust_type_filter').val();
  var branch_status = $('#branch_status').val();

    $.post('company_name_load.php', { cust_type : cust_type, branch_status : branch_status }, function(data){
 
      if(cust_type=='Corporate'){
          $('#company_div').addClass('company_class');  
        }
        else
        {
          $('#company_div').removeClass('company_class');   
        }
      $('#company_div').html(data);
    });
}

function excel_report()
{
  var tour_id = $('#tour_id_filter').val();
  var group_id = $('#group_id_filter').val();
  var customer_id = $('#customer_id_filter').val();
  var booking_id = $('#booking_id_filter').val();
  var from_date = $('#from_date_filter').val();
  var to_date = $('#to_date_filter').val();
  var cust_type = $('#cust_type_filter').val();
  var company_name = $('#company_filter').val();
  var branch_status = $('#branch_status').val();
 
    window.location = 'excel_report.php?tour_id='+tour_id+'&group_id='+group_id+'&customer_id='+customer_id+'&booking_id='+booking_id+'&from_date='+from_date+'&to_date='+to_date+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
}
function display_modal(id)
{
    $.post('view/index.php', { id : id }, function(data){
      $('#view_modal').html(data);
    });
}
//*******************Get Dynamic Customer Name Dropdown**********************//
function dynamic_customer_load(cust_type, company_name)
{
  var cust_type = $('#cust_type_filter').val();
  var company_name = $('#company_filter').val();
  var branch_status = $('#branch_status').val();
    $.get("inc/get_customer_dropdown.php", { cust_type : cust_type , company_name : company_name, branch_status : branch_status}, function(data){
    $('#customer_div').html(data);
  });   
}
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>