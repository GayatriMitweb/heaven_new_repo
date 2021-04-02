 
<form id="frm_tab41_c">
	<div class="row mg_bt_10">
	<?php
		$basic_cost1 = $sq_quotation['subtotal'];
		$service_charge = $sq_quotation['service_charge'];
		$markup = $sq_quotation['markup_cost'];

		$bsmValues = json_decode($sq_quotation['bsm_values']);
		$service_tax_amount = 0;
		if($sq_quotation['service_tax_subtotal'] !== 0.00 && ($sq_quotation['service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$sq_quotation['service_tax_subtotal']);
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount = $service_tax_amount + $service_tax[2];
			}
		}
		$markupservice_tax_amount = 0;
		if($sq_quotation['markup_cost_subtotal'] !== 0.00 && $sq_quotation['markup_cost_subtotal'] !== ""){
			$service_tax_markup1 = explode(',',$sq_quotation['markup_cost_subtotal']);
			for($i=0;$i<sizeof($service_tax_markup1);$i++){
				$service_tax = explode(':',$service_tax_markup1[$i]);
				$markupservice_tax_amount = $markupservice_tax_amount+ $service_tax[2];
			}
		}
		foreach($bsmValues[0] as $key => $value){
			switch($key){
				case 'basic' : $basic_cost = ($value != "") ? $basic_cost1 + $service_tax_amount : $basic_cost1;$inclusive_b = $value;break;
				case 'service' : $service_charge = ($value != "") ? $service_charge + $service_tax_amount : $service_charge;$inclusive_s = $value;break;
				case 'markup' : $markup = ($value != "") ? $markup + $markupservice_tax_amount : $markup;$inclusive_m = $value;break;
			}
		}
		$readonly = ($inclusive_d != '') ? 'readonly' : '';
    ?>
	<div class="col-md-2">
		<small id="basic_show1"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small>
  		<input type="text" id="subtotal" name="subtotal" placeholder="Basic Cost"  class="text-right form-control" title="Basic Cost" onchange="validate_balance(this.id);get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','update','true','basic',true);  " value="<?= $basic_cost ?>">  

  	</div>
	<div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">
		<small id="service_show1"><?= ($inclusive_s == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_s ?></span></small>
    	<input type="text" name="service_charge" id="service_charge" placeholder="*Service Charge" title="Service Charge" value="<?= $service_charge ?>" onchange="validate_balance(this.id);get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','update','false','service_charge');  ">
	</div>
	<div class="col-md-2">
		<small>&nbsp;</small>
		<input type="text" id="service_tax_subtotal" name="service_tax_subtotal" class="text-right form-control" readonly placeholder="Tax Amount" title="Tax Amount" value="<?php echo $sq_quotation['service_tax_subtotal']; ?>">

	</div>
	<div class="col-md-2">
		<small id="markup_show1"><?= ($inclusive_m == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_m ?></span></small>
  		<input type="text" id="markup_cost" name="markup_cost" class="text-right form-control" placeholder="Markup Cost" title="Markup Cost" onchange="validate_balance(this.id);get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','update','false','markup');  " value="<?= $markup ?>">  
  	</div>
	  <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">
	  	<small>&nbsp;</small>
        <input type="text" id="service_tax_markup" name="service_tax_markup" placeholder="*Tax on Markup" title="Tax on Markup" onchange="  " value="<?= $sq_quotation['markup_cost_subtotal'] ?>" readonly>
    </div> 
	<div class="col-md-2"> 
		<small>&nbsp;</small>
	 	<input type="text" id="permit1" name="permit1" class="text-right form-control" placeholder="Permit charges" title="Permit charges" value="<?php echo $sq_quotation['permit']; ?>" onchange="  validate_balance(this.id)">  

	</div>
</div>
<div class="row mg_bt_10">

    <div class="col-md-2">
	  	<input type="text" id="toll_parking1" name="toll_parking1" class="text-right form-control" placeholder="Toll Parking charges" title="Toll Parking charges" value="<?php echo $sq_quotation['toll_parking']; ?>" onchange="  validate_balance(this.id)"> 
	</div>
	<div class="col-md-2">
	    <input type="text" id="driver_allowance1" name="driver_allowance1" class="text-right form-control" placeholder="Driver Allowance" title="Driver Allowance" value="<?php echo $sq_quotation['driver_allowance']; ?>" onchange="  validate_balance(this.id)">
	</div>
	<div class="col-md-2">
		<input type="text" id="state_entry" class="text-right form-control" name="state_entry" placeholder="State Entry" title="State Entry" value="<?php echo $sq_quotation['state_entry']; ?>" onchange="  validate_balance(this.id)" > 
	</div>
	<div class="col-md-2">
		<input type="text"  id="other_charges" name="other_charges" class="text-right form-control" placeholder="Other Charges" title="Other Charges" onchange="  validate_balance(this.id)" value="<?php echo $sq_quotation['other_charge']; ?>" > 
	</div>
	

</div>	 
<div class="row">
	<div class="col-md-2">
		<input type="text" id="roundoff1" name="roundoff1" class="text-right form-control" placeholder="Round Off" title="Round Off" value="<?= $sq_quotation['roundoff'] ?>" onchange="validate_balance(this.id)" readonly>
	</div>
	<div class="col-md-2">
	    <input type="text" id="total_tour_cost1" name="total_tour_cost1" class="text-right form-control" onchange="validate_balance(this.id);" placeholder="Total" title="Total" value="<?php echo $sq_quotation['total_tour_cost']; ?>" >
	</div>
</div>
	<div class="row mg_tp_20 text-center">
		<div class="col-md-12">
			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
			&nbsp;&nbsp;
			<button class="btn btn-sm btn-success" id="btn_quotation_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
		</div>
	</div>
</form>

<script>

function quotation_cost_calculate1(){
	var subtotal = $('#subtotal').val();  
	var markup_cost = $('#markup_cost').val(); 
    var markup_cost_subtotal = $('#service_tax_markup').val(); 
	var permit = $('#permit1').val();
	var toll_parking = $('#toll_parking1').val();
	var driver_allowance = $('#driver_allowance1').val();
	var state_entry = $('#state_entry').val();
	var other_charges = $('#other_charges').val();

	var service_tax_markup = $('#service_tax_markup').val();
	var service_tax_subtotal = $('#service_tax_subtotal').val();
	var service_charge = $('#service_charge').val();

    if(subtotal==""||subtotal=='0'){ subtotal = 0;}
    if(markup_cost==""||markup_cost=="0"){ markup_cost = 0;}
    if(service_charge==""||service_charge=='0'){ service_charge = 0;}
    if(permit==""||permit=='0'){permit = 0;}
    if(toll_parking==""||toll_parking=='0'){ toll_parking = 0;}
	if(driver_allowance==""||driver_allowance=='0'){ driver_allowance = 0;}
	if(state_entry==""||state_entry=='0'){ state_entry = 0;}
	if(other_charges==""||other_charges=='0'){ other_charges = 0;}

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

	subtotal = ($('#basic_show1').html() == '&nbsp;') ? subtotal : parseFloat($('#basic_show1').text().split(' : ')[1]);
	service_charge = ($('#service_show1').html() == '&nbsp;') ? service_charge : parseFloat($('#service_show1').text().split(' : ')[1]);
	markup_cost = ($('#markup_show1').html() == '&nbsp;') ? markup_cost : parseFloat($('#markup_show1').text().split(' : ')[1]);

	total_tour_cost = 	parseFloat(subtotal) + 
						parseFloat(markupservice_tax_amount) + 
						parseFloat(permit) + 
						parseFloat(toll_parking) + 
						parseFloat(driver_allowance) + 
						parseFloat(service_tax_amount) + 
						parseFloat(state_entry) + 
						parseFloat(other_charges) +
						parseFloat(markup_cost) +
						parseFloat(service_charge);
	
	var roundoff = Math.round(total_tour_cost)-total_tour_cost;
	$('#roundoff1').val(roundoff.toFixed(2));

	$('#total_tour_cost1').val(parseFloat(total_tour_cost.toFixed(2)) + parseFloat(roundoff));
}
//   
function switch_to_tab1(){ $('a[href="#tab_1_c"]').tab('show'); }

$('#frm_tab41_c').validate({
	rules:{
		tour_cost : { required : true, number: true },
		taxation_id : { required : true },
	},
	submitHandler:function(form){
		var enquiry_id = $("#enquiry_id1").val();
		var quotation_id = $('#quotation_id1').val();
		var customer_name = $('#customer_name1').val();
		var email_id = $('#email_id1').val();
		var mobile_no = $('#mobile_no1').val();
		var total_pax = $("#total_pax1").val();
		var days_of_traveling = $('#days_of_traveling').val();
		var traveling_date = $('#traveling_date1').val();
		var capacity = $('#capacity').val();
		var travel_type = $('#travel_type').val();
		var route = $('#places_to_visit').val();
		var vehicle_name = $('#vehicle_name').val();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var extra_km_cost = $('#extra_km_cost').val();
		var extra_hr_cost = $('#extra_hr_cost').val();		
		var total_hrs = $('#total_hr').val();
		var local_places_to_visit = $('#local_places_to_visit').val();
		var total_km = $('#total_km').val();
		var rate = $('#rate').val();
		var total_max_km = $('#total_max_km').val();
		var subtotal = $('#subtotal').val();
		var markup_cost = $('#markup_cost').val();
		var markup_cost_subtotal = $('#service_tax_markup').val();
		var taxation_id = $('#taxation_id').val();
		var service_charge = $('#service_charge').val();
		var service_tax_subtotal = $('#service_tax_subtotal').val();
		var permit = $('#permit1').val();
		var toll_parking = $('#toll_parking1').val();
		var driver_allowance = $('#driver_allowance1').val();
		var total_tour_cost = $('#total_tour_cost1').val();
		var state_entry = $('#state_entry').val();
		var markup_show = $('#markup_show').val();
		var roundoff = $('#roundoff1').val();
		var bsmValues = [];
		bsmValues.push({
			"basic" : $('#basic_show1').find('span').text(),
			"service" : $('#service_show1').find('span').text(),
			"markup" : $('#markup_show1').find('span').text()
		});

		var other_charges = $('#other_charges').val();
		var quotation_date = $('#quotation_date').val();
 
		var base_url = $('#base_url').val();

		if(parseFloat(taxation_id) == "0"){ error_msg_alert("Please select Tax Percentage"); return false; }

		$('#btn_quotation_save').button('loading');

		$.ajax({

			type:'post',

			url: base_url+'controller/package_tour/quotation/car_rental/quotation_update.php',

			data:{quotation_id : quotation_id, enquiry_id : enquiry_id , total_pax : total_pax, days_of_traveling : days_of_traveling,traveling_date : traveling_date, travel_type : travel_type,vehicle_name : vehicle_name, from_date : from_date, to_date : to_date, route : route,extra_km_cost : extra_km_cost , extra_hr_cost : extra_hr_cost, subtotal : subtotal,markup_cost : markup_cost,markup_cost_subtotal : markup_cost_subtotal, taxation_id : taxation_id, service_charge : service_charge , service_tax_subtotal : service_tax_subtotal, permit : permit, toll_parking : toll_parking, driver_allowance : driver_allowance , total_tour_cost : total_tour_cost, customer_name : customer_name,quotation_date : quotation_date,email_id : email_id, mobile_no : mobile_no,other_charges:other_charges,state_entry:state_entry,capacity:capacity,total_hrs:total_hrs,total_km:total_km,rate:rate,total_max_km:total_max_km,local_places_to_visit:local_places_to_visit, roundoff : roundoff, bsmValues : bsmValues},
			success: function(message){			
                	$('#btn_quotation_update').button('reset');
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
					        	  $('#quotation_update_modal').modal('hide');
					        	 document.location.reload();
					        	 //quotataion_list_reflect();
						        }
						      }
						});
					}

                }  
		});

	}
});

        	 
</script>
