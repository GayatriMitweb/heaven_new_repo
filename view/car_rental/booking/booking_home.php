<?php
include "../../../model/model.php";
/*======******Header******=======*/
// require_once('../../layouts/admin_header.php');
$emp_id= $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='car_rental/booking/index.php'"));
$branch_status = $sq['branch_status'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
 <input type="hidden" id="whatsapp_switch"  value="<?= $whatsapp_switch ?>" >
 <!-- begin_panel('Car Rental Booking',56) ?> -->
	<div class="app_panel_content">
		<input type="hidden" value="<?= $emp_id ?>" id="emp_id"/>
		<div class="row text-right mg_bt_10">
			<div class="col-xs-12">
			    <button class="btn btn-excel btn-sm mg_bt_10" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
				<button class="btn btn-info btn-sm ico_left mg_bt_10" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Booking</button>
			</div>
		</div>

		<div class="app_panel_content Filter-panel">
			<div class="row">
				<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
				        <select name="cust_type_filter" class="form-control" id="cust_type_filter" onchange="dynamic_customer_load(this.value,'company_filter'); company_name_reflect();" title="Customer Type">
				            <?php get_customer_type_dropdown(); ?>
				        </select>
			    </div>
			    <div id="company_div" class="hidden">
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">		
				</div>	
				<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
					<select name="booking_id_filter" id="booking_id_filter" style="width:100%" title="Booking ID">
						<?php get_car_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id) ?>
					</select>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
					<input type="text" id="traveling_date_from_filter" name="traveling_date_from_filter" placeholder="From Date" title="From Date" onchange="validate_validDate('traveling_date_from_filter','traveling_date_to_filter');">
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
					<input type="text" id="traveling_date_to_filter" name="traveling_date_to_filter" placeholder="To Date" title="To Date" onchange="validate_validDate('traveling_date_from_filter','traveling_date_to_filter');">
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
					<button class="btn btn-sm btn-info ico_right" onclick="booking_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
				</div>
			</div>
		</div>


		<div id="div_booking_list" class="main_block">
			<div class="table-responsive mg_tp_10">
			<table id="car_rental_book" class="table table-hover" style="margin: 20px 0 !important;">         
			</table>
		</div>
		</div>
		<div id="div_booking_update"></div>
		<div id="div_car_content_display"></div>
	</div>
</div>
 <?= end_panel() ?>
 <script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>

<script>
$('#customer_id_filter,#cust_type_filter,#booking_id_filter').select2();
$('#traveling_date_from_filter, #traveling_date_to_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
dynamic_customer_load('','');
var columns = [
	{ title : "S_No"},
	{ title : "Booking_ID"},
	{ title : "Customer_Name"},
	{ title : "Mobile"},
	{ title : "Email_ID"},
	{ title : "No_OF_PAX"},
	{ title : "Amount", className : "info"},
	{ title : "Created_by"},
	{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", className : "text-center","width":"20% !important"}
];
function booking_list_reflect()
{
	var customer_id = $('#customer_id_filter').val();
	var traveling_date_from = $('#traveling_date_from_filter').val();
	var traveling_date_to = $('#traveling_date_to_filter').val();
	var booking_id = $('#booking_id_filter').val();
	var cust_type = $('#cust_type_filter').val();
	var company_name = $('#company_filter').val();
	var branch_status = $('#branch_status').val();
	$.post('booking_list_reflect.php', { customer_id : customer_id, traveling_date_from : traveling_date_from, traveling_date_to : traveling_date_to, cust_type : cust_type, booking_id : booking_id,company_name : company_name , branch_status : branch_status }, function(data){
		// $('#div_booking_list').html(data);
		pagination_load(data,columns,true,false,10,'car_rental_book');
		$('.loader').remove();
	});
}
booking_list_reflect();
function save_modal(){
	var branch_status = $('#branch_status').val();
	$.post('booking_save_modal.php', { branch_status : branch_status }, function(data){
		$('#div_car_content_display').html(data);
	});

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
						$('#company_name1'+offset).removeClass('hidden');
						$('#company_name1'+offset).val(result.company_name);	
					}
					else
					{
						$('#company_name1'+offset).addClass('hidden');
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

function booking_update_modal(booking_id)
{	
	var branch_status = $('#branch_status').val();
	$.post('booking_update_modal.php', { booking_id : booking_id, branch_status : branch_status}, function(data){
		$('#div_booking_update').html(data);
	});
}
function get_car_cost (offset='') {
	var travel_type = $('#travel_type'+offset).val();
	var vehicle_name = $('#vehicle_name'+offset).val();
	var places_to_visit = $('#places_to_visit'+offset).val();
	
	var base_url = $('#base_url').val();
	$.ajax({
		type     : 'post',
		url      : base_url + 'view/car_rental/booking/get_car_cost.php',
		dataType : 'json',
		data     : { travel_type: travel_type, vehicle_name: vehicle_name,places_to_visit:places_to_visit },
		success  : function (result) {
			console.log(result);
			// var hotel_arr = JSON.parse(result);

			$('#total_hr'+offset).val(result[0].total_hrs);
			$('#total_km'+offset).val(result[0].total_km);
			$('#extra_hr_cost'+offset).val(result[0].extra_hrs_rate);
			$('#extra_km'+offset).val(result[0].extra_km_rate);
			$('#route'+offset).val(result[0].route);
			$('#days_of_traveling'+offset).val(result[0].total_days);
			$('#total_max_km'+offset).val(result[0].total_max_km);
			$('#rate'+offset).val(result[0].rate);
			$('#driver_allowance'+offset).val(result[0].driver_allowance);
			$('#permit_charges'+offset).val(result[0].permit_charges);
			$('#toll_and_parking'+offset).val(result[0].toll_parking);
			$('#state_entry_tax'+offset).val(result[0].state_entry_pass);
			$('#other_charges'+offset).val(result[0].other_charges);
		},
		error    : function (result) {
			// alert(result);
			console.log(result.responseText);
		 // calculate_total_fees('1');
		}
	});
}
function get_enquiry_details(offset)
{
	var quotation_id = $('#quotation_id'+offset).val();

	$.ajax({
		type:'post',
		dataType: "json",
		url:'get_enquiry_details.php',
		data:{ quotation_id : quotation_id },
		success:function(result){
			console.log(result);
			$('#days_of_traveling'+offset).val(result[0].days_of_traveling);
			$('#places_to_visit'+offset).val(result[0].places_to_visit);
			$('#local_places_to_visit'+offset).val(result[0].local_places_to_visit);
			$('#from_date'+offset).val(result[0].from_date);
			$('#to_date'+offset).val(result[0].to_date);
			$('#route'+offset).val(result[0].route);
			$('#extra_km'+offset).val(result[0].extra_km_cost);			
			$('#extra_hr_cost'+offset).val(result[0].extra_hr_cost);			
			$('#basic_amount'+offset).val(result[0].subtotal);
			$('#taxation_id'+offset).val(result[0].taxation_id);
			// $('#service_charge'+offset).val(result[0].service_charge);
			// $('#service_tax_subtotal'+offset).val(result[0].service_tax_subtotal);
			$('#permit_charges'+offset).val(result[0].permit);			
			$('#toll_and_parking'+offset).val(result[0].toll_parking);
			$('#vehicle_name'+offset).val(result[0].vehicle_name);
			$('#driver_allowance'+offset).val(result[0].driver_allowance);
			$('#total_tour_cost'+offset).val(result[0].total_fees);
			$('#total_days'+offset).val(result[0].total_days);
			$('#tour_type'+offset).val(result[0].tour_type);
			$('#taxation_type'+offset).val(result[0].tax_type)
			$('#total_pax'+offset).val(result[0].total_pax);
			$('#travel_type'+offset).val(result[0].travel_type);
			 $('#total_fees'+offset).val(result[0].total_fees);
			 $('#total_cost'+offset).val(result[0].total_fees);
			$('#capacity'+offset).val(result[0].capacity);
			// $('#markup_cost'+offset).val(result[0].markup_cost);
			// $('#service_tax_markup'+offset).val(result[0].service_tax_markup);
			$('#state_entry_tax'+offset).val(result[0].state_entry);
			$('#other_charges'+offset).val(result[0].other_charges);
			$('#total_hrs'+offset).val(result[0].total_hrs);
			$('#total_km'+offset).val(result[0].total_km);
			$('#traveling_date'+offset).val(result[0].traveling_date);

			$('#rate'+offset).val(result[0].rate);
			$('#total_max_km'+offset).val(result[0].total_max_km);
			
			reflect_feilds();
		}
	});
}
function vehicle_dropdown_reflect(vendor_id_dropdown, vehicle_id_dropdown)
{
	var vendor_id = $('#'+vendor_id_dropdown).val();

	$.post('vehicle_dropdown_reflect.php', { vendor_id : vendor_id }, function(data){
		$('#'+vehicle_id_dropdown).html(data);
	});
}
function total_days_reflect(offset=''){
    var from_date = $('#from_date'+offset).val(); 
    var to_date = $('#to_date'+offset).val(); 

    var edate = from_date.split("-");
    e_date = new Date(edate[2],edate[1]-1,edate[0]).getTime();
    var edate1 = to_date.split("-");
    e_date1 = new Date(edate1[2],edate1[1]-1,edate1[0]).getTime();

    var one_day=1000*60*60*24;

    var from_date_ms = new Date(e_date).getTime();
    var to_date_ms = new Date(e_date1).getTime();
    
    var difference_ms = to_date_ms - from_date_ms;
    var total_days = Math.round(Math.abs(difference_ms)/one_day); 

	total_days = parseFloat(total_days)+1;
	
    $('#days_of_traveling'+offset).val(total_days);
}

function calculate_total_fees(id,offset="")
{
	// var rate_per_km = $('#rate_per_km'+offset).val();
	
	var extra_km = $('#extra_km'+offset).val();	
	var basic_amount = $('#basic_amount'+offset).val();	
	var total_pax = $('#total_pax'+offset).val();
	var capacity = $('#capacity'+offset).val();
	var rate = $('#rate'+offset).val();
	var days_of_traveling = $('#days_of_traveling'+offset).val();
	var total_vehicle = Math.ceil(parseFloat(total_pax)/parseFloat(capacity));

	var basic_amount = parseFloat(rate)*parseFloat(days_of_traveling)*parseFloat(total_vehicle);
	
	if(isNaN(basic_amount)) basic_amount = 0.00;
	$('#basic_amount'+offset).val(basic_amount);
	if(id != "basic_amount"+offset){
		$('#basic_amount'+offset).trigger('change');	
	}
		

	var driver_allowance = $('#driver_allowance'+offset).val();
	var permit_charges = $('#permit_charges'+offset).val();
	var toll_and_parking = $('#toll_and_parking'+offset).val();
	var state_entry_tax = $('#state_entry_tax'+offset).val();
	var other_charges = $('#other_charges'+offset).val();
	var extra_km_rate = $('#extra_km'+offset).val();
	var extra_hr_cost = $('#extra_hr_cost'+offset).val();
		
	if(extra_hr_cost==""){ extra_hr_cost = 0; }
	if(extra_km_rate==""){ extra_km_rate = 0; }
	if(other_charges==""){ other_charges = 0; }

	// if(rate_per_km==""){ rate_per_km = 0; }
	if(markup_cost==""){ markup_cost = 0; }
	if(basic_amount==""){ basic_amount = 0; }
	if(service_tax==""){ service_tax = 0; }
	if(driver_allowance==""){ driver_allowance = 0; }
	if(permit_charges==""){ permit_charges = 0; }
	if(toll_and_parking==""){ toll_and_parking = 0; }
	if(state_entry_tax==""){ state_entry_tax = 0; }
	
	var service_tax_markup = $('#service_tax_markup'+offset).val();
	var service_tax_subtotal = $('#service_tax_subtotal'+offset).val();
	var service_charge = $('#service_charge'+offset).val();
	var markup_cost = $('#markup_cost'+offset).val(); 
	
	var service_tax_amount = 0;
    if(parseFloat(service_tax_subtotal) !== 0.00 && (service_tax_subtotal) !== '' && typeof(service_tax_subtotal) != 'undefined'){

      var service_tax_subtotal1 = service_tax_subtotal.split(",");
      for(var i=0;i<service_tax_subtotal1.length;i++){
        var service_tax = service_tax_subtotal1[i].split(':');
        service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
      }
	}
	var markupservice_tax_amount = 0;
    if(parseFloat(service_tax_markup) !== 0.00 && (service_tax_markup) !== "" && typeof(service_tax_markup) != 'undefined'){
      var service_tax_markup1 = service_tax_markup.split(",");
      for(var i=0;i<service_tax_markup1.length;i++){
        var service_tax = service_tax_markup1[i].split(':');
        markupservice_tax_amount = parseFloat(markupservice_tax_amount) + parseFloat(service_tax[2]);
      }
    }

		basic_amount = ($('#basic_show'+offset).html() == '&nbsp;') ? basic_amount : parseFloat($('#basic_show'+offset).text().split(' : ')[1]);
		service_charge = ($('#service_show'+offset).html() == '&nbsp;') ? service_charge : parseFloat($('#service_show'+offset).text().split(' : ')[1]);
		markup_cost = ($('#markup_show'+offset).html() == '&nbsp;') ? markup_cost : parseFloat($('#markup_show'+offset).text().split(' : ')[1]);

	var total_cost = ( parseFloat(basic_amount) + parseFloat(markupservice_tax_amount) + parseFloat(service_tax_amount) + parseFloat(markup_cost) + parseFloat(service_charge) );
	total_cost = total_cost.toFixed(2);
 console.log(basic_amount, markupservice_tax_amount , service_tax_amount, markup_cost, service_charge); 
  $('#total_cost'+offset).val(total_cost);
	
	var total_fees = parseFloat(total_cost) + parseFloat(driver_allowance) + parseFloat(permit_charges) + parseFloat(toll_and_parking) + parseFloat(state_entry_tax)+parseFloat(other_charges);
	total_fees = total_fees.toFixed(2);
	
	var roundoff = Math.round(total_fees)-total_fees;
	$('#roundoff'+offset).val(roundoff.toFixed(2));
	var total = parseFloat(total_fees) + parseFloat(roundoff);
	$('#total_fees'+offset).val(total);
}
	function excel_report()
	{
		var customer_id = $('#customer_id_filter').val();
		var from_date = $('#traveling_date_from_filter').val();
		var to_date = $('#traveling_date_to_filter').val();
		var cust_type = $('#cust_type_filter').val();
		var company_name = $('#company_filter').val();
		var branch_status = $('#branch_status').val();
		window.location = 'excel_report.php?customer_id='+customer_id+'&from_date='+from_date+'&to_date='+to_date+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
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
company_name_reflect();
function booking_cancel(booking_id){
	var base_url = $('#base_url').val();
	$('#vi_confirm_box').vi_confirm_box({
        message: 'Are you sure you want to cancel?',
        callback: function(data1){
            if(data1=="yes"){
            	$.ajax({
                  type:'post',
                  url: base_url+'controller/car_rental/cancel/cancel_booking.php',
                  data:{ booking_id : booking_id },
                  success:function(result){
                    msg_alert(result);
                    booking_list_reflect();
                  },
                  error:function(result){
                    console.log(result.responseText);
                  }
                });
            }
        }
    });                	
}
function booking_registration_pdf(booking_id){
	url = "booking_registration_pdf.php?booking_id="+booking_id;
	window.open(url, '_BLANK');
}
//*******************Get Dynamic Customer Name Dropdown**********************//
function dynamic_customer_load(cust_type, company_name)
{
  var cust_type = $('#cust_type_filter').val();
  var company_name = $('#company_filter').val();
  var branch_status = $('#branch_status').val();
    $.get("get_customer_dropdown.php", { cust_type : cust_type , company_name : company_name, branch_status : branch_status}, function(data){
    $('#customer_div').html(data);
  });   
}


function car_display_modal(booking_id)
{
	$.post('view/index.php', { booking_id : booking_id }, function(data){
		$('#div_car_content_display').html(data);
	});
}
function whatsapp_send(emp_id, customer_id, booking_date, base_url){
	$.post(base_url+'controller/car_rental/booking/whatsapp_send.php',{emp_id:emp_id,booking_date:booking_date ,customer_id:customer_id,booking_date:booking_date}, function(data){
		window.open(data);
		// console.log(data);
	});
}
</script>
<?php
/*======******Footer******=======*/
// require_once('../../layouts/admin_footer.php'); 
?>
<script src="<?php echo BASE_URL ?>/view/car_rental/booking/js/calculation.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
