<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
include_once('booking_save_modal.php');
?>
<input type="hidden" id="whatsapp_switch" value="<?= $whatsapp_switch?>">
<div class="row text-right mg_bt_10">
	<div class="col-xs-12">
		<button class="btn btn-excel btn-sm mg_bt_10" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
		<button class="btn btn-info btn-sm ico_left mg_bt_10" data-toggle="modal" data-target="#booking_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Hotel Booking</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<input type="hidden" value="<?= $emp_id ?>" id="emp_id"/>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="cust_type_filter" id="cust_type_filter" style="width:100%" onchange="dynamic_customer_load(this.value,'company_filter');company_name_reflect();" title="Customer Type">
				<?php get_customer_type_dropdown(); ?>		        
			</select>
	    </div>
	    <div  id="company_div" class="hidden">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">    
	    </div> 
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="booking_id_filter" id="booking_id_filter" style="width:100%" title="Booking ID">
		    <?php   get_hotel_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id)  ?>
		    </select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'to_date');">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date','to_date')">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<button class="btn btn-sm btn-info ico_right" onclick="booking_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

<hr>
<div id="div_booking_list" class="main_block mg_tp_20">
<div class="table-responsive">
        <table id="hotel_book" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="div_booking_update_content"></div>
<div id="div_booking"></div>
<script src="../booking/js/calculation.js"></script>
<script>
$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#customer_id_filter, #booking_id_filter,#cust_type_filter').select2();
dynamic_customer_load('','');

var columns = [
	{ title : "S_no"},
	{ title : "Booking_ID"},
	{ title : "Customer_Name"},
	{ title : "Booking_Date"},
	{ title : "Amount", className : "info text-right"},
	{ title : "Cncl_Amount" ,className : "danger text-right"},
	{ title : "Total",className : "success text-right"},
	{ title : "Created_by"},
	{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", className : "text-center"}
			
];


function business_rule_load(){
	get_auto_values('booking_date','sub_total','payment_mode','service_charge','markup','save','true','service_charge','discount');
}
function booking_list_reflect()
{
	var customer_id = $('#customer_id_filter').val();
	var booking_id = $('#booking_id_filter').val();
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	var cust_type = $('#cust_type_filter').val();
	var company_name = $('#company_filter').val();
	var branch_status = $('#branch_status').val();
		

	$.post('booking/booking_list_reflect.php', { customer_id : customer_id, booking_id : booking_id, from_date : from_date, to_date : to_date , cust_type : cust_type, company_name : company_name, branch_status : branch_status}, function(data){
		//$('#div_booking_list').html(data);
		pagination_load(data,columns,true,true,10,'hotel_book');
	});
}
booking_list_reflect();

function calculate_total_amount(offset=''){

	var booking_amount = $('#booking_amount'+offset).val();
	var service_tax = $('#service_tax'+offset).val();
	var service_charge = $('#service_charge'+offset).val();

	if(service_charge==""){ service_charge = 0; }
	if(booking_amount==""){ booking_amount = 0; }

	var service_tax_subtotal = (parseFloat(service_charge)/100)*parseFloat(service_tax);
	service_tax_subtotal = Math.round(service_tax_subtotal);
	$('#service_tax_subtotal'+offset).val(service_tax_subtotal);

	var total_amount = parseFloat(booking_amount) + parseFloat(service_charge) + parseFloat(service_tax_subtotal);
	$('#total_cost'+offset).val(total_amount);

}

function customer_info_load(offset='')
{
	var customer_id = $('#customer_id'+offset).val();
	 var base_url = $('#base_url').val();
	if(customer_id==0&&customer_id!=''){
		$('#cust_details').addClass('hidden');
	    $('#new_cust_div').removeClass('hidden');

		$.ajax({
		type:'post',
		url:base_url+'view/load_data/new_customer_info.php',
		data:{},
		success:function(result){
			 
			$('#new_cust_div').html(result);
		}
	});
	}
	else{
		if(customer_id!=''){
			$('#new_cust_div').addClass('hidden');
			$('#cust_details').removeClass('hidden');
			$.ajax({
			type:'post',
			url:base_url+'view/load_data/customer_info_load.php',
			data:{ customer_id : customer_id },
			success:function(result){
				result = JSON.parse(result);
				$('#mobile_no'+offset).val(result.contact_no);
				$('#email_id'+offset).val(result.email_id);
				if(result.company_name != ''){
					$('#company_name'+offset).removeClass('hidden');
					$('#company_name'+offset).val(result.company_name);	
				}
				else
				{
					$('#company_name'+offset).addClass('hidden');
				}
				if(result.payment_amount != '' || result.payment_amount != '0'){
					$('#credit_amount'+offset).removeClass('hidden');
					$('#credit_amount'+offset).val(result.payment_amount);	
					if(result.company_name != ''){
						$('#credit_amount'+offset).addClass('mg_tp_10'); 
						$('#credit_amount'+offset).addClass('mg_bt_10'); }
					else{
						$('#credit_amount'+offset).removeClass('mg_tp_10');
						$('#credit_amount'+offset).addClass('mg_bt_10');
					}
				}
				else{
					$('#credit_amount'+offset).addClass('hidden');
				}
			}
			});
		}
    }
}
function booking_update_modal(booking_id)
{	
	var branch_status = $('#branch_status').val();
	$.post('booking/booking_update_modal.php', { booking_id : booking_id, branch_status : branch_status }, function(data){
		$('#div_booking_update_content').html(data);
	});
}
function booking_display_modal(booking_id)
{
		$.post('booking/view/index.php', { booking_id : booking_id }, function(data){
			$('#div_booking').html(data);
		});
}

function excel_report()
{
		var customer_id = $('#customer_id_filter').val()
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var booking_id = $('#booking_id_filter').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();

		window.location = 'booking/excel_report.php?customer_id='+customer_id+'&booking_id='+booking_id+'&from_date='+from_date+'&to_date='+to_date+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
}
function company_name_reflect()
{  
	var cust_type = $('#cust_type_filter').val();
	var branch_status = $('#branch_status').val();

	$.post('booking/company_name_load.php', { cust_type : cust_type , branch_status : branch_status}, function(data){
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
company_name_reflect();
//*******************Get Dynamic Customer Name Dropdown**********************//
function dynamic_customer_load(cust_type, company_name)
{
	var cust_type = $('#cust_type_filter').val();
	var company_name = $('#company_filter').val();
	var branch_status = $('#branch_status').val();

	$.get("booking/get_customer_dropdown.php", { cust_type : cust_type , company_name : company_name, branch_status : branch_status}, function(data){
	$('#customer_div').html(data);
	});   
}
function voucher_display(booking_id){

	var base_url = $('#base_url').val();
	var url1 = base_url+'model/app_settings/print_html/voucher_html/hotel_voucher.php?hotel_accomodation_id='+booking_id;
	loadOtherPage(url1);
}
</script>