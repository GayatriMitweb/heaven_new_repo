<form id="frm_tab3">



	<div class="row">



		<div class="col-md-6">

			<div class="panel panel-default panel-body app_panel_style feildset-panel">
				<legend>Basic Amount</legend>

				

				<div class="row mg_bt_10">

					<div class="col-sm-4 col-xs-12 mg_bt_10">
						<span data-original-title="" title="">Adults</span>
						<input type="text" id="adults" name="adults" placeholder="Adults" title="Adults" readonly value="<?= $sq_ticket['adults'] ?>" onchange="get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','markup','update','true','service_charge','discount');">

					</div>

					<div class="col-sm-4 col-xs-12 mg_bt_10">
						<span data-original-title="" title="">Child</span>
						<input type="text" id="childrens" name="childrens" placeholder="Childrens" title="Childrens" readonly value="<?= $sq_ticket['childrens'] ?>" onchange="get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','markup','update','true','service_charge','discount');">

					</div>

					<div class="col-sm-4 col-xs-12 mg_bt_10">
						<span data-original-title="" title="">Infants</span>
						<input type="text" id="infant" name="infant" placeholder="Infant" title="Infant" readonly value="<?= $sq_ticket['infant'] ?>">

					</div>			

					<div class="col-sm-4 col-xs-12 mg_bt_10_sm_xs mg_tp_10">

						<input type="text" id="adult_fair" name="adult_fair" placeholder="Adult Fare" title="Adult Fare" onchange="calculate_total_amount(this.id);validate_balance(this.id)" value="<?= $sq_ticket['adult_fair'] ?>">

					</div>		

					<div class="col-sm-4 col-xs-12 mg_bt_10_sm_xs mg_tp_10">

						<input type="text" id="children_fair" name="children_fair" placeholder="Children Fare" title="Children Fare" onchange="calculate_total_amount(this.id);validate_balance(this.id)" value="<?= $sq_ticket['children_fair'] ?>">

					</div>		

					<div class="col-sm-4 col-xs-12 mg_tp_10">

						<input type="text" id="infant_fair" name="infant_fair" placeholder="Infant Fare" title="Infant Fare" onchange="calculate_total_amount(this.id);validate_balance(this.id)" value="<?= $sq_ticket['infant_fair'] ?>">

					</div>

				</div>



			</div>

		</div>
		<?php
				$basic_cost1 = $sq_ticket['basic_cost'];
				$service_charge = $sq_ticket['service_charge'];
				$markup = $sq_ticket['markup'];
				$discount = $sq_ticket['basic_cost_discount'];

				$bsmValues = json_decode($sq_ticket['bsm_values']);
				$service_tax_amount = 0;
				if($sq_ticket['service_tax_subtotal'] !== 0.00 && ($sq_ticket['service_tax_subtotal']) !== ''){
					$service_tax_subtotal1 = explode(',',$sq_ticket['service_tax_subtotal']);
					for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
						$service_tax = explode(':',$service_tax_subtotal1[$i]);
						$service_tax_amount = $service_tax_amount + $service_tax[2];
					}
				}
				$markupservice_tax_amount = 0;
				if($sq_ticket['service_tax_markup'] !== 0.00 && $sq_ticket['service_tax_markup'] !== ""){
					$service_tax_markup1 = explode(',',$sq_ticket['service_tax_markup']);
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
        				case 'discount' : $discount = ($value != "") ? $discount + $sq_ticket['tds'] : $discount;$inclusive_d = $value;
					}
				}
				$readonly = ($inclusive_d != '') ? 'readonly' : '';
        	?>
		<div class="col-md-6">

			<div class="panel panel-default panel-body app_panel_style feildset-panel">
				<legend>Other Calculations</legend> 

				<div class="row">

					<div class="col-sm-4 col-xs-12 mg_bt_10">
						<small id="basic_show"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small>
						<input type="text" id="basic_cost" name="basic_cost" placeholder="Basic Amount" title="Basic Amount" readonly value="<?= $basic_cost ?>" onchange="get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','markup','update','true','basic','discount',true);">

					</div>

					<div class="col-sm-4 col-xs-12 mg_bt_10">
						<small>&nbsp;</small>
						<input type="text" id="yq_tax" name="yq_tax" placeholder="YQ Tax" title="YQ Tax" onchange="calculate_total_amount(this.id);validate_balance(this.id)" value="<?= $sq_ticket['yq_tax'] ?>">

					</div>

					<div class="col-sm-4 col-xs-12 mg_bt_10">
						<small>&nbsp;</small>
						<input type="text" id="other_taxes" name="other_taxes" placeholder="Other Taxes" title="Other Taxes" onchange="calculate_total_amount(this.id);validate_balance(this.id)" value="<?= $sq_ticket['other_taxes'] ?>" >

					</div>

					<div class="col-sm-4 col-xs-12 mg_bt_10">
						<small id="discount_show"><?= ($inclusive_d == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_d ?></span></small>
						<input type="text" id="discount" name="discount" placeholder="Discount" title="Discount" onchange="calculate_total_amount(this.id);validate_balance(this.id);get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','markup','update','true','discount','discount');" value="<?= $discount ?>" >

					</div>

					<div class="col-sm-4 col-xs-12 mg_bt_10">
						<small id="service_show"><?= ($inclusive_s == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_s ?></span></small>
						<input type="text" id="service_charge" name="service_charge" placeholder="Service Charge" title="Service Charge" onchange="validate_balance(this.id);get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','markup','update','false','service_charge','discount')" value="<?= $service_charge ?>" >

					</div>

					<div class="col-sm-4 col-xs-12 mg_bt_10">
						<small>&nbsp;</small>
						<input type="text" id="service_tax_subtotal" name="service_tax_subtotal" placeholder="Service Tax" title="Service Tax" onchange="validate_balance(this.id)" value="<?= $sq_ticket['service_tax_subtotal'] ?>" readonly>

					</div>	

					<div class="col-sm-4 col-xs-12 mg_bt_10">
						<small id="markup_show"><?= ($inclusive_m == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_m ?></span></small>
						<input type="text" id="markup" name="markup" placeholder="Markup" title="Markup" onchange="validate_balance(this.id);get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','markup','update','false','markup','discount');" value="<?= $markup ?>" >
					</div>
					<div class="col-sm-4 col-xs-12">
						<small>&nbsp;</small>
						<input type="text" id="service_tax_markup" name="service_tax_markup" placeholder="Tax on Markup" title="Tax on Markup" onchange="validate_balance(this.id)" value="<?= $sq_ticket['service_tax_markup'] ?>" readonly>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default panel-body">



		<div class="row mg_bt_10">
			<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

				<input type="text" id="tds" name="tds" placeholder="TDS" title="TDS" onchange="calculate_total_amount(this.id);validate_balance(this.id)" value="<?= $sq_ticket['tds'] ?>">

			</div>		
			<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                <input type="text" name="roundoff" id="roundoff" class="text-right" placeholder="Round Off" title="RoundOff" value="<? $sq_ticket['roundoff'] ?>" readonly>
            </div>	
			<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_sm_xs">

				<input type="text" name="ticket_total_cost" id="ticket_total_cost" class="amount_feild_highlight text-right" placeholder="Net Total" title="Net Total" readonly value="<?= $sq_ticket['ticket_total_cost'] ?>">

			</div>

			<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

				<input type="text" name="due_date" id="due_date" onchange="validate_dueDate('booking_date1','due_date');" placeholder="Due Date" title="Due Date" value="<?= get_date_user($sq_ticket['due_date']) ?>">

			</div>

			<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

				<input type="text" name="booking_date1" id="booking_date1" onchange="validate_bookingDate('booking_date1','due_date');check_valid_date(this.id);get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','markup','update','true','service_charge','discount',true);" placeholder="Booking Date" title="Booking Date" value="<?= get_date_user($sq_ticket['created_at']) ?>">

			</div>
			<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
				<select id="sup_id1" name="sup_id1" style="width:100%" title="Supplier" onchange="calculate_total_amount(this.id);get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','markup','save','true','service_charge','discount',true);">
					<?php 
	                  $supplier_id = $sq_ticket['supplier_id'];
	                  $sq_sup1 = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$sq_ticket[supplier_id]'"));

	                  if ($sq_sup1['vendor_id']!="") {
	                 ?>
	                  	  <option value="<?= $sq_sup1['vendor_id'] ?>"><?= $sq_sup1['vendor_name'] ?></option>
					<?php 
	                  }
	                  else{
	                 ?>
	                  	<option value="">Select Supplier</option>
					<?php 
	                  }
	                 ?>
	                
					<?php 
					$sq_sup = mysql_query("select * from ticket_vendor where active_flag='Active' ");
					while($row_sup = mysql_fetch_assoc($sq_sup)){
						?>
						<option value="<?= $row_sup['vendor_id'] ?>"><?= $row_sup['vendor_name'] ?></option>
						<?php
					}
					?>
				</select>
			</div>

		</div>



	</div>



	<div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-sm btn-success" id="btn_ticket_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>

		</div>

	</div>





</form>



<script>
$('#sup_id1').select2();
$(function(){

	$('#frm_tab3').validate({

		rules:{

				adults: { required : true, number : true },

				childrens: { required : true, number : true },

				infant: { required : true, number : true },

				adult_fair: { required : true, number : true },

				children_fair: { required : true, number : true },

				infant_fair: { required : true, number : true },

				basic_cost: { required : true, number : true },

				markup: { required : true },
				
				ticket_total_cost: { required : true, number : true },

				booking_date1: { required : true },

		},

		submitHandler:function(form,e){
			e.preventDefault();
				

				var ticket_id = $('#ticket_id').val();

				var customer_id = $('#customer_id').val();

				var tour_type = $('#tour_type').val();

				var type_of_tour = $('input[name="type_of_tour"]:checked').val();



				var adults = $('#adults').val();

				var childrens = $('#childrens').val();

				var infant = $('#infant').val();

				var adult_fair = $('#adult_fair').val();

				var children_fair = $('#children_fair').val();

				var infant_fair = $('#infant_fair').val();

				var basic_cost = $('#basic_cost').val();

				var discount = $('#discount').val();

				var yq_tax = $('#yq_tax').val();

				var other_taxes = $('#other_taxes').val();

				var service_charge = $('#service_charge').val();

				var service_tax_subtotal = $('#service_tax_subtotal').val();

				var markup = $('#markup').val();

				var service_tax_markup = $('#service_tax_markup').val();


				var tds = $('#tds').val();

				var due_date = $('#due_date').val();
				var booking_date1 = $('#booking_date1').val();
				var sup_id = $('#sup_id1').val();

				var ticket_total_cost = $('#ticket_total_cost').val();



				var first_name_arr = new Array(); 

				var middle_name_arr = new Array(); 

				var last_name_arr = new Array(); 

				// var birth_date_arr = new Array(); 

				var adolescence_arr = new Array(); 

				var ticket_no_arr = new Array(); 

				var gds_pnr_arr = new Array(); 

				var baggage_info_arr = new Array(); 

				var entry_id_arr = new Array(); 

				var main_ticket_arr = new Array();



		        var table = document.getElementById("tbl_dynamic_ticket_master");

		        var rowCount = table.rows.length;

		        

		        for(var i=0; i<rowCount; i++)

		        {

		          var row = table.rows[i];

		           

		          if(row.cells[0].childNodes[0].checked)

		          {



					  var first_name = row.cells[2].childNodes[0].value;

					  var middle_name = row.cells[3].childNodes[0].value;

					  var last_name = row.cells[4].childNodes[0].value;

					//   var birth_date = row.cells[5].childNodes[0].value;

					  var adolescence = row.cells[6].childNodes[0].value;

					  var ticket_no = row.cells[7].childNodes[0].value;

					  var gds_pnr = row.cells[8].childNodes[0].value;

					  var baggage_info = row.cells[9].childNodes[0].value;

					  var main_ticket = row.cells[10].childNodes[0].value;

					  if(row.cells[11]){

					  	var entry_id = row.cells[11].childNodes[0].value;

					  }

					  else{

					  	var entry_id = "";

					  }

					  

					  first_name_arr.push(first_name);

					  middle_name_arr.push(middle_name);

					  last_name_arr.push(last_name);

					//   birth_date_arr.push(birth_date);

					  adolescence_arr.push(adolescence);

					  ticket_no_arr.push(ticket_no);

					  gds_pnr_arr.push(gds_pnr);

					  baggage_info_arr.push(baggage_info);

					  entry_id_arr.push(entry_id);

					  main_ticket_arr.push(main_ticket);

		          }      

		        }	

		        var from_city_id_arr = getDynFields('from_city_id');
                var to_city_id_arr = getDynFields('to_city_id');
 
		        var departure_datetime_arr = getDynFields('departure_datetime');

				var arrival_datetime_arr = getDynFields('arrival_datetime');

				var airlines_name_arr = getDynFields('airlines_name');

				var class_arr = getDynFields('class');

				var flight_no_arr = getDynFields('flight_no');

				var airlin_pnr_arr = getDynFields('airlin_pnr');

				var departure_city_arr = getDynFields('departure_city');

				var arrival_city_arr = getDynFields('arrival_city');

				var special_note_arr = getDynFields('special_note');

				var trip_entry_id_arr = getDynFields('trip_entry_id');
				var meal_plan_arr = getDynFields('meal_plan');
				var luggage_arr = getDynFields('luggage');

				
				var flight_sc = $('#flight_sc').val();
				var flight_markup = $('#flight_markup').val();
				var flight_taxes = $('#flight_taxes').val();
				var flight_markup_taxes = $('#flight_markup_taxes').val();
				var flight_tds = $('#flight_tds').val();
				var reflections = [];
				reflections.push({
				'flight_sc':flight_sc,
				'flight_markup':flight_markup,
				'flight_taxes':flight_taxes,
				'flight_markup_taxes':flight_markup_taxes,
				'flight_tds':flight_tds
				});
				var bsmValues = [];
				bsmValues.push({
					"basic" : $('#basic_show').find('span').text(),
					"service" : $('#service_show').find('span').text(),
					"markup" : $('#markup_show').find('span').text(),
					"discount" : $('#discount_show').find('span').text(),
				});
				var roundoff = $('#roundoff').val();
		
			//Validation for booking and payment date in login financial year
			var base_url = $('#base_url').val();
			var check_date1 = $('#booking_date1').val();
			$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
				if(data !== 'valid'){
					error_msg_alert("The Booking date does not match between selected Financial year.");
					return false;
				}else{
							$('#btn_ticket_save').button('loading');
							$.ajax({

									type:'post',

									url: base_url+'controller/visa_passport_ticket/ticket/ticket_master_update.php',
									data:{ ticket_id : ticket_id, customer_id : customer_id, tour_type : tour_type, type_of_tour : type_of_tour, adults : adults, childrens : childrens, infant : infant, adult_fair : adult_fair, children_fair : children_fair, infant_fair : infant_fair, basic_cost : basic_cost, markup : markup, discount : discount, yq_tax : yq_tax, service_charge : service_charge,service_tax_markup : service_tax_markup, service_tax_subtotal : service_tax_subtotal, tds : tds, due_date : due_date, ticket_total_cost : ticket_total_cost, first_name_arr : first_name_arr, middle_name_arr : middle_name_arr, last_name_arr : last_name_arr, adolescence_arr : adolescence_arr, ticket_no_arr : ticket_no_arr, gds_pnr_arr : gds_pnr_arr, baggage_info_arr : baggage_info_arr,entry_id_arr : entry_id_arr, departure_datetime_arr : departure_datetime_arr, arrival_datetime_arr : arrival_datetime_arr, airlines_name_arr : airlines_name_arr, class_arr : class_arr, flight_no_arr : flight_no_arr, airlin_pnr_arr : airlin_pnr_arr, departure_city_arr : departure_city_arr, arrival_city_arr : arrival_city_arr, special_note_arr : special_note_arr, trip_entry_id_arr : trip_entry_id_arr,booking_date1 : booking_date1,sup_id : sup_id, meal_plan_arr : meal_plan_arr, luggage_arr : luggage_arr, from_city_id_arr : from_city_id_arr, to_city_id_arr : to_city_id_arr, other_taxes : other_taxes, reflections : reflections, roundoff : roundoff, bsmValues : bsmValues, main_ticket_arr : main_ticket_arr},

									success:function(result){

										$('#btn_ticket_save').button('reset');

										var msg = result.split('--');

										if(msg[0]=="error"){

											msg_alert(result);

										}

										else{

											msg_alert(result);

											$('#ticket_save_modal').modal('hide');

											ticket_customer_list_reflect();

										}

									}

								});
							}
			});



		}

	});

});

function switch_to_tab2(){ $('a[href="#tab2"]').tab('show'); }

</script>



