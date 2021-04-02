<form id="frm_tab4">

<div class="row mg_bt_10">

	<div class="col-md-2">
		<small id="basic_show">&nbsp;</small>
  		<input type="text" id="subtotal" name="subtotal" class="text-right form-control" placeholder="Basic Cost" title="Basic Cost" onchange="quotation_cost_calculate();validate_balance(this.id);get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','save','true','basic',true);">  
  	</div>
    <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">
		<small id="service_show">&nbsp;</small>
    	<input type="text" name="service_charge" id="service_charge" placeholder="*Service Charge" title="Service Charge" onchange="validate_balance(this.id);quotation_cost_calculate();get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','save','false','service_charge')">
	</div>
	<div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10_xs">
		<small>&nbsp;</small>
		<input type="text" id="service_tax_subtotal" name="service_tax_subtotal" placeholder="*Tax Amount" title="Tax Amount" readonly>
	</div>
	<div class="col-md-2">
		<small id="markup_show">&nbsp;</small>
  		<input type="text" id="markup_cost" name="markup_cost" class="text-right form-control" placeholder="Markup Cost" title="Markup Cost" onchange="quotation_cost_calculate();validate_balance(this.id);get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','save','false','service_carge','discount');">  
  	</div> 
	  <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">
	  	<small>&nbsp;</small>
        <input type="text" id="service_tax_markup" name="service_tax_markup" placeholder="*Tax on Markup" title="Tax on Markup" readonly>
    </div> 
	<div class="col-md-2"> 
		<small>&nbsp;</small>
	 	<input type="text" id="permit" name="permit" class="text-right form-control" placeholder="Permit charges" title="Permit charges" value="0.00" onchange="quotation_cost_calculate();validate_balance(this.id)">  
	</div>
</div>
<div class="row mg_bt_10">
    <div class="col-md-2">
	  	<input type="text" id="toll_parking" name="toll_parking" class="text-right form-control" placeholder="Toll Parking charges" title="Toll Parking charges" value="0.00" onchange="quotation_cost_calculate();validate_balance(this.id)"> 
	</div>
	<div class="col-md-2">
	    <input type="text" id="driver_allowance" name="driver_allowance" class="text-right form-control" placeholder="Driver Allowance" title="Driver Allowance" value="0.00" onchange="quotation_cost_calculate();validate_balance(this.id)">
	</div>
	<div class="col-md-2">
		<input type="text"  id="state_entry" name="state_entry" class="text-right form-control" placeholder="State Entry" title="State Entry" onchange="quotation_cost_calculate();validate_balance(this.id)" value="0.00"> 
	</div>
	<div class="col-md-2">
		<input type="text"  id="other_charges"  name="other_charges" class="text-right form-control" placeholder="Other Charges" title="Other Charges" onchange="quotation_cost_calculate();validate_balance(this.id)" value="0.00"> 
	</div>
	
</div>
<div class="row mg_tp_10">	 
<div class="col-md-2">
	<input type="text" id="roundoff" name="roundoff" class="text-right form-control" placeholder="Round Off" title="Round Off" value="0.00" onchange="validate_balance(this.id)" readonly>
</div>
<div class="col-md-2">
	    <input type="text" id="total_tour_cost" name="total_tour_cost" class="text-right form-control" placeholder="Total" title="Total" value="0.00" onchange="validate_balance(this.id)" >
	</div>
</div>
<div class="row mg_tp_20 text-center">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
		&nbsp;&nbsp;
		<button class="btn btn btn-success" id="btn_quotation_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
	</div>
</div>

</form>
<script>

function switch_to_tab1(){ $('a[href="#tab1"]').tab('show'); }

$('#frm_tab4').validate({

	rules:{

		

	},

	submitHandler:function(form){

		var enquiry_id = $("#enquiry_id").val();
		var login_id = $("#login_id").val();
		var emp_id = $("#emp_id").val();
		var customer_name = $('#customer_name').val();
		var email_id = $('#email_id').val();
		var mobile_no = $('#mobile_no').val();
		var total_pax = $("#total_pax").val();
		var days_of_traveling = $('#days_of_traveling').val();
		var traveling_date = $('#traveling_date').val();
		
		var travel_type = $('#travel_type').val();
		var places_to_visit = $('#places_to_visit').val();
		var local_places_to_visit = $('#local_places_to_visit').val();
		var vehicle_name = $('#vehicle_name').val();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		// var route = $('#route').val();
		var extra_km_cost = $('#extra_km_cost').val();
		var extra_hr_cost = $('#extra_hr_cost').val();		
		var daily_km = $('#daily_km').val();
		var subtotal = $('#subtotal').val();
		var markup_cost = $('#markup_cost').val();
		var markup_cost_subtotal = $('#service_tax_markup').val();
		var taxation_id = $('#taxation_id').val();
		var service_charge = $('#service_charge').val();
		var service_tax_subtotal = $('#service_tax_subtotal').val();
		var permit = $('#permit').val();
		var toll_parking = $('#toll_parking').val();
		var driver_allowance = $('#driver_allowance').val();
		var total_tour_cost = $('#total_tour_cost').val();
		var quotation_date = $('#quotation_date').val();
		var branch_admin_id = $('#branch_admin_id1').val();
		var financial_year_id = $('#financial_year_id').val();
		var travel_type = $('#travel_type').val();
		var vehicle_name = $('#vehicle_name').val();
 		var total_hr = $('#total_hr').val();
		var total_km = $('#total_km').val();
		var rate = $('#rate').val();
		var total_max_km = $('#total_max_km').val();
		var base_url = $('#base_url').val();
		var state_entry = $('#state_entry').val();
		var other_charge = $('#other_charges').val();
		var capacity = $('#capacity').val();
		var bsmValues = [];
		bsmValues.push({
			"basic" : $('#basic_show').find('span').text(),
			"service" : $('#service_show').find('span').text(),
			"markup" : $('#markup_show').find('span').text()
		});
		var roundoff = $('#roundoff').val();

		$('#btn_quotation_save').button('loading');

		$.ajax({

			type:'post',

			url: base_url+'controller/package_tour/quotation/car_rental/quotation_save.php',

			data:{ enquiry_id : enquiry_id , login_id : login_id, emp_id : emp_id,total_pax : total_pax, days_of_traveling : days_of_traveling,traveling_date : traveling_date, travel_type : travel_type, places_to_visit : places_to_visit,vehicle_name : vehicle_name, from_date : from_date, to_date : to_date,extra_km_cost : extra_km_cost , extra_hr_cost : extra_hr_cost, daily_km : daily_km, subtotal : subtotal,markup_cost : markup_cost,markup_cost_subtotal : markup_cost_subtotal, taxation_id : taxation_id, service_charge : service_charge , service_tax_subtotal : service_tax_subtotal, permit : permit, toll_parking : toll_parking, driver_allowance : driver_allowance , total_tour_cost : total_tour_cost, customer_name : customer_name,quotation_date : quotation_date, email_id : email_id, mobile_no : mobile_no, branch_admin_id : branch_admin_id,financial_year_id :financial_year_id,travel_type:travel_type,vehicle_name:vehicle_name,total_hr:total_hr,total_km:total_km,rate:rate,total_max_km:total_max_km,other_charge:other_charge,state_entry:state_entry,capacity:capacity,local_places_to_visit:local_places_to_visit, bsmValues : bsmValues, roundoff : roundoff},
		
			success: function(message){

					$('#btn_quotation_save').button('reset');

                	var msg = message.split('--');

					if(msg[0]=="error"){

						error_msg_alert(msg[1]);

					}

					else{

						$('#vi_confirm_box').vi_confirm_box({

						            false_btn: false,

						            message: message,

						            true_btn_text:'Ok',

						    callback: function(data1){

						        if(data1=="yes"){

						        	$('#btn_quotation_save').button('reset');

						        	$('#quotation_save_modal').modal('hide');

						        	quotation_list_reflect();


						        }

						      }

						});

					}



                }  



                

		});

	}  



});



        	 

</script>