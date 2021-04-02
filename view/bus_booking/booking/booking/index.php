<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<input type="hidden" id="whatsapp_switch" value="<?= $whatsapp_switch ?>" >
<div class="row text-right mg_bt_10">
	<div class="col-xs-12">
		<button class="btn btn-excel btn-sm mg_bt_10" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		<button class="btn btn-info btn-sm ico_left mg_bt_10" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Booking</button>
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

		   	<?php   get_bus_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id) ?>

		    </select>

		</div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'to_date_filter');">

		</div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date_filter','to_date_filter')">

		</div>

		<div class="col-md-3 col-sm-6 col-xs-12">

			<button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>

</div>





<div id="div_modal"></div>

<div id="div_content" class="main_block">
<div class="table-responsive mg_tp_10">
        <table id="bus_book" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>

<div id="div_view_modal"></div>

<script src="booking/js/calculation.js"></script>

<script>

$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#customer_id_filter, #booking_id_filter,#cust_type_filter').select2();

dynamic_customer_load('','');

function save_modal()

{
	var branch_status = $('#branch_status').val();
	$('#btn_save_modal').button('loading');

	$.post('booking/save_modal.php', { branch_status : branch_status}, function(data){

		$('#btn_save_modal').button('reset');

		$('#div_modal').html(data);

	});

}
function business_rule_load(){
	get_auto_values('balance_date','basic_cost','payment_mode','service_charge','markup','save','true','basic','basic');
}
var columns = [
	{ title : "S_No"},
	{ title : "Booking_ID"},
	{ title : "Customer_Name"},
	{ title : "Booking_date"},
	{ title : "Total_Bus"},
	{ title : "Bus_operator"},
	{ title : "Amount", className : "info"},
	{ title : "Cncl_Amount", className : "danger"},
	{ title : "Total", className : "success"},
	{ title : "Created_by"},
	{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", className : "text-center"}
];
function list_reflect()

{

	var customer_id = $('#customer_id_filter').val();

	var booking_id = $('#booking_id_filter').val();

	var from_date = $('#from_date_filter').val();

	var to_date = $('#to_date_filter').val();

	var cust_type = $('#cust_type_filter').val();

	var company_name = $('#company_filter').val();
	 var branch_status = $('#branch_status').val();


	$.post('booking/list_reflect.php', { customer_id : customer_id, booking_id : booking_id, from_date : from_date, to_date : to_date, cust_type : cust_type, company_name : company_name, branch_status : branch_status }, function(data){

		// $('#div_content').html(data);
		pagination_load(data,columns,true,true,10,'bus_book');
		$('.loader').remove();

	});

}

list_reflect();



function update_modal(booking_id)

{
	 var branch_status = $('#branch_status').val();
	$.post('booking/update_modal.php', { booking_id : booking_id , branch_status : branch_status}, function(data){

		$('#div_modal').html(data);

	});

}



function view_modal(booking_id)

{

	$.post('booking/view/index.php', { booking_id : booking_id }, function(data){

		$('#div_view_modal').html(data);

	});

}



function excel_report()

{

	var customer_id = $('#customer_id_filter').val();

	var booking_id = $('#booking_id_filter').val();

	var from_date = $('#from_date_filter').val();

	var to_date = $('#to_date_filter').val();

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

function customer_info_load(offset='')

{

	var customer_id = $('#customer_id'+offset).val();
	 
	 var base_url = $('#base_url').val();
	if(customer_id==0 && customer_id!=''){
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
						$('#credit_amount'+offset).addClass('mg_tp_10');}
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

function calculate_total_amount(offset=''){



	var basic_cost = $('#basic_cost'+offset).val();
	var service_tax = $('#service_tax'+offset).val();
	var service_charge = $('#service_charge'+offset).val();
    var service_tax_subtotal = $('#service_tax_subtotal'+offset).val();
    var service_tax_markup = $('#service_tax_markup'+offset).val();
    var service_charge = $('#service_charge'+offset).val();
    var markup = $('#markup'+offset).val();
	if(basic_cost==""){ basic_cost = 0; }
	if(service_tax==""){ service_tax = 0; }
	if(service_charge==""){ service_charge = 0; }
	if(service_tax_subtotal==""){ service_tax_subtotal = 0; }
	if(service_tax_markup==""){ service_tax_markup = 0; }
	if(service_charge==""){ service_charge = 0; }
	if(markup==""){ markup = 0; }
	

	basic_cost = ($('#basic_show').html() == '&nbsp;') ? basic_cost : parseFloat($('#basic_show').text().split(' : ')[1]);
    service_charge = ($('#service_show').html() == '&nbsp;') ? service_charge : parseFloat($('#service_show').text().split(' : ')[1]);
    markup = ($('#markup_show').html() == '&nbsp;') ? markup : parseFloat($('#markup_show').text().split(' : ')[1]);
    discount =($('#discount_show').html() == '&nbsp;') ? discount : parseFloat($('#discount_show').text().split(' : ')[1]); 
	
	var service_tax_amount = 0;
    if(parseFloat(service_tax_subtotal) !== 0.00 && (service_tax_subtotal) !== ''){

      var service_tax_subtotal1 = service_tax_subtotal.split(",");
      for(var i=0;i<service_tax_subtotal1.length;i++){
        var service_tax = service_tax_subtotal1[i].split(':');
        service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
      }
    }
    
    var markupservice_tax_amount = 0;
    if(parseFloat(service_tax_markup) !== 0.00 && (service_tax_markup) !== ""){
      var service_tax_markup1 = service_tax_markup.split(",");
      for(var i=0;i<service_tax_markup1.length;i++){
        var service_tax = service_tax_markup1[i].split(':');
        markupservice_tax_amount = parseFloat(markupservice_tax_amount) + parseFloat(service_tax[2]);
      }
    }
	
	var total_amount = parseFloat(basic_cost) + parseFloat(service_charge) + parseFloat(service_tax_amount)+parseFloat(markupservice_tax_amount)+ parseFloat(markup);
	
	var total=total_amount.toFixed(2);
	var roundoff = Math.round(total)-total;
	console.log(roundoff + ' roundoff');
	
    $('#roundoff').val(roundoff.toFixed(2));
    $('#net_total'+offset).val(parseFloat(total)+parseFloat(roundoff));
}

	//*******************Get Dynamic Customer Name Dropdown**********************//

	function dynamic_customer_load(cust_type, company_name)

	{

	  var cust_type = $('#cust_type_filter').val();
	   var branch_status = $('#branch_status').val();
	  var company_name = $('#company_filter').val();

	    $.get("booking/get_customer_dropdown.php", { cust_type : cust_type , company_name : company_name, branch_status : branch_status}, function(data){

	    $('#customer_div').html(data);

	  });   

	}
	function whatsapp_send(emp_id, customer_id, booking_date, base_url){
	$.post(base_url+'controller/bus_booking/booking/whatsapp_send.php',{emp_id:emp_id,booking_date:booking_date ,customer_id:customer_id,booking_date:booking_date}, function(data){
		window.open(data);
	});
}

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>