<form id="frm_tab3">

<?php
        $basic_fair = $sq_booking['basic_fair'];
        $service_charge = $sq_booking['service_charge'];
        $markup = $sq_booking['markup'];
        $discount = $sq_booking['discount'];

        $bsmValues = json_decode($sq_booking['bsm_values']);
        $service_tax_amount = 0;
        if($sq_booking['service_tax_subtotal'] !== 0.00 && ($sq_booking['service_tax_subtotal']) !== ''){
        $service_tax_subtotal1 = explode(',',$sq_booking['service_tax_subtotal']);
        for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
        $service_tax = explode(':',$service_tax_subtotal1[$i]);
        $service_tax_amount = $service_tax_amount + $service_tax[2];
        }
        }
        $markupservice_tax_amount = 0;
        if($sq_booking['markup_tax'] !== 0.00 && $sq_booking['markup_tax'] !== ""){
        $service_tax_markup1 = explode(',',$sq_booking['markup_tax']);
        for($i=0;$i<sizeof($service_tax_markup1);$i++){
        $service_tax = explode(':',$service_tax_markup1[$i]);
        $markupservice_tax_amount = $markupservice_tax_amount+ $service_tax[2];
        }
		}
		
        foreach($bsmValues[0] as $key => $value){
        switch($key){
        case 'basic' : $basic_fair = ($value != "") ? $basic_fair + $service_tax_amount : $basic_fair;$inclusive_b = $value;break;
        case 'service' : $service_charge = ($value != "") ? $service_charge + $service_tax_amount : $service_charge;$inclusive_s = $value;break;
        case 'markup' : $markup = ($value != "") ? $markup + $markupservice_tax_amount : $markup;$inclusive_m = $value;break;
        case 'discount' : $discount = ($value != "") ? $discount + $sq_booking['tds'] : $discount;$inclusive_d = $value;break;
        }
        }
        $readonly = ($inclusive_d != '') ? 'readonly' : '';
        // echo "<pre>";
        // var_dump($bsmValues)
        ?>
	<div class="row">
		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
            <small id="basic_show" style="color:red"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small>
			<input type="text" id="basic_fair" name="basic_fair" placeholder="Basic Fare" title="Basic Fare" onchange="get_auto_values('booking_date1','basic_fair','payment_mode','service_charge','markup1','update','true','service_charge','discount1',true);calculate_total_amount();validate_balance(this.id)" value="<?= $basic_fair ?>">
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
            <small id="service_show" style="color:red"><?= ($inclusive_s == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_s ?></span></small>
			<input type="text" id="service_charge" name="service_charge" placeholder="Service Charge" title="Service Charge" onchange="get_auto_values('booking_date1','basic_fair','payment_mode','service_charge','markup1','update','false','service_charge','discount1');calculate_total_amount();validate_balance(this.id)" value="<?= $service_charge ?>">
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
            <small>&nbsp;</small>
			<input type="text" id="delivery_charges" name="delivery_charges" placeholder="Delivery Charges" title="Delivery Charges" onchange="calculate_total_amount();validate_balance(this.id)" value="<?= $sq_booking['delivery_charges'] ?>">
		</div>

		<!-- <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

          <select name="taxation_type" id="taxation_type" title="Taxation Type">
          	<?php if($sq_booking['taxation_type']!='0'){ ?>
                <option value="<?= $sq_booking['taxation_type'] ?>"><?= $sq_booking['taxation_type'] ?></option>
            <?php  
             }
             ?>        
          </select>

        </div>    

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
			<select name="gst_on" id="gst_on" title="Tax On" onchange="calculate_total_amount()">
				<?php if($sq_booking['gst_on']!=''){ ?>
				<option value="<?= $sq_booking['gst_on'] ?>"><?= $sq_booking['gst_on'] ?></option>
			<?php }?>
				<option value="">Tax On</option>
				<option value="Service Charge">Service Charge</option>
				<option value="Delivery Charges">Delivery Charges</option>
				<option value="Service Charge+Delivery Charges">Service Charge+Delivery Charges</option>			
			</select>

		</div> -->

		<!-- <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<select name="taxation_id" id="taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'service_tax', 'calculate_total_amount');">
				
	        </select>
	        <input type="hidden" id="service_tax" name="service_tax" value="<?= $sq_booking['service_tax'] ?>">			       
		</div> -->

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
		<small>&nbsp;</small>
			<input type="text" id="service_tax_subtotal" name="service_tax_subtotal" placeholder="Tax Amount" title="Tax Amount" readonly value="<?= $sq_booking['service_tax_subtotal'] ?>">
		</div>
		<div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">
		<small>&nbsp;</small>
			<input type="text" name="roundoff" id="roundoff" class="text-right" placeholder="Round Off" title="RoundOff" value="<?= $sq_booking['roundoff'] ?> " readonly>
		</div>	
		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
		<small>&nbsp;</small>
			<input type="text" id="net_total" name="net_total" placeholder="Net Total" title="Net Total" readonly value="<?= $sq_booking['net_total'] ?>">
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
			<input type="text" id="payment_due_date" name="payment_due_date" placeholder="Due Date" title="Due Date" value="<?= get_date_user($sq_booking['payment_due_date']) ?>">
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
			<input type="text" id="booking_date1" name="booking_date1" placeholder="Booking Date" title="Booking Date" onchange="get_auto_values('booking_date1','basic_fair','payment_mode','service_charge','markup1','update','true','service_charge','discount1',true);" value="<?= get_date_user($sq_booking['created_at']) ?>" onchange="check_valid_date(this.id)">
		</div>
	</div>



	<div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-sm btn-success" id="btn_ticket_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>

		</div>

	</div>



</form>



<script>

$('#payment_due_date,#booking_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });

function switch_to_tab2(){ $('a[href="#tab2"]').tab('show'); }

$('#frm_tab3').validate({

	rules:{

			basic_fair : { required : true, number : true },
			net_total : { required : true, number : true },
			booking_date1: { required : true },
	},

	submitHandler:function(form){		



		var train_ticket_id = $('#train_ticket_id').val();

		var customer_id = $('#customer_id').val();

		var type_of_tour = $('input[name="type_of_tour"]:checked').val();

		var basic_fair = $('#basic_fair').val();

		var service_charge = $('#service_charge').val();

		var delivery_charges = $('#delivery_charges').val();

		var gst_on = $('#gst_on').val();

		var taxation_type = $('#taxation_type').val();

		var taxation_id = $('#taxation_id').val();

		var service_tax = $('#service_tax').val();

		var service_tax_subtotal = $('#service_tax_subtotal').val();

		var net_total = $('#net_total').val();

		var payment_due_date = $('#payment_due_date').val();
		var booking_date1 = $('#booking_date1').val();
		var roundoff = $('#roundoff').val();
		var hotel_sc = $('#hotel_sc').val();
		var hotel_markup = $('#hotel_markup').val();
		var hotel_taxes = $('#hotel_taxes').val();
		var hotel_markup_taxes = $('#hotel_markup_taxes').val();
		var hotel_tds = $('#hotel_tds').val();
		var reflections = [];
		reflections.push({
			'train_sc':hotel_sc,
			'train_markup':hotel_markup,
			'train_taxes':hotel_taxes,
			'train_markup_taxes':hotel_markup_taxes,
			'train_tds':hotel_tds
		});
		var bsmValues = [];
          bsmValues.push({
          "basic" : $('#basic_show').find('span').text(),
          "service" : $('#service_show').find('span').text(),
          "markup" : $('#markup_show').find('span').text(),
          "discount" : $('#discount_show').find('span').text()
          });
		if(parseFloat(taxation_id) == "0"){ error_msg_alert("Please select Tax Percentage"); return false; }


		var honorific_arr = new Array();

		var first_name_arr = new Array();

		var middle_name_arr = new Array();

		var last_name_arr = new Array();

		var birth_date_arr = new Array();

		var adolescence_arr = new Array();

		var coach_number_arr = new Array();

		var seat_number_arr = new Array();

		var ticket_number_arr = new Array();

		var entry_id_arr = new Array();





        var table = document.getElementById("tbl_dynamic_train_ticket_master");

        var rowCount = table.rows.length;

        

        for(var i=0; i<rowCount; i++)

        {

          var row = table.rows[i];

           

          if(row.cells[0].childNodes[0].checked)

          {
          	  var honorific = row.cells[2].childNodes[0].value;

			  var first_name = row.cells[3].childNodes[0].value;

			  var middle_name = row.cells[4].childNodes[0].value;

			  var last_name = row.cells[5].childNodes[0].value;

			  var birth_date = row.cells[6].childNodes[0].value;

			  var adolescence = row.cells[7].childNodes[0].value;

			  var coach_number = row.cells[8].childNodes[0].value;

			  var seat_number = row.cells[9].childNodes[0].value; 

			  var ticket_number = row.cells[10].childNodes[0].value;

			  if(row.cells[11]){

			  	var entry_id = row.cells[11].childNodes[0].value;		  	

			  }

			  else{

			  	var entry_id = "";

			  }

			

			  

			  honorific_arr.push(honorific);

			  first_name_arr.push(first_name);

			  middle_name_arr.push(middle_name);

			  last_name_arr.push(last_name);

			  birth_date_arr.push(birth_date);

			  adolescence_arr.push(adolescence);

			  coach_number_arr.push(coach_number);

			  seat_number_arr.push(seat_number);
			  ticket_number_arr.push(ticket_number);
			  entry_id_arr.push(entry_id);



          }      

        }



		var travel_datetime_arr = getDynFields('travel_datetime');
		var travel_from_arr = getDynFields('travel_from');
		var travel_to_arr = getDynFields('travel_to');
		var train_name_arr = getDynFields('train_name');
		var train_no_arr = getDynFields('train_no');
		var ticket_status_arr = getDynFields('ticket_status');
		var class_arr = getDynFields('class');
		var booking_from_arr = getDynFields('booking_from');
		var boarding_at_arr = getDynFields('boarding_at');
		var arriving_datetime_arr = getDynFields('arriving_datetime');

		var trip_entry_id = getDynFields('trip_entry_id');


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

							url: base_url+'controller/visa_passport_ticket/train_ticket/ticket_master_update.php',

							data:{ train_ticket_id : train_ticket_id, customer_id : customer_id, type_of_tour : type_of_tour, basic_fair : basic_fair, service_charge : service_charge, delivery_charges : delivery_charges, gst_on : gst_on, taxation_type : taxation_type, taxation_id : taxation_id, service_tax : service_tax, service_tax_subtotal : service_tax_subtotal, net_total : net_total, payment_due_date : payment_due_date, honorific_arr : honorific_arr, first_name_arr : first_name_arr, middle_name_arr : middle_name_arr, last_name_arr : last_name_arr, birth_date_arr : birth_date_arr, adolescence_arr : adolescence_arr, coach_number_arr : coach_number_arr, seat_number_arr : seat_number_arr, ticket_number_arr : ticket_number_arr, entry_id_arr : entry_id_arr, travel_datetime_arr : travel_datetime_arr, travel_from_arr : travel_from_arr, travel_to_arr : travel_to_arr, train_name_arr : train_name_arr, train_no_arr : train_no_arr, ticket_status_arr : ticket_status_arr, class_arr : class_arr, booking_from_arr : booking_from_arr, boarding_at_arr : boarding_at_arr, arriving_datetime_arr : arriving_datetime_arr, trip_entry_id : trip_entry_id, booking_date1 : booking_date1,reflections:reflections,bsmValues:bsmValues,roundoff:roundoff  },

							success:function(result){

								$('#btn_ticket_save').button('reset');

								var msg = result.split('--');

								if(msg[0]=="error"){

									msg_alert(result);

								}

								else{

									msg_alert(result);

									$('#update_modal').modal('hide');

									train_ticket_customer_list_reflect();

								}

							}

						});
				}
			});





	}

});

</script>