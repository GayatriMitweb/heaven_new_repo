<form id="frm_tab4">

	<div class="row">
		<div class="col-md-4 col-sm-4 col-xs-12 mg_bt_10">
			<input type="text" id="payment_date" name="payment_date" placeholder="Date" title="Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12 mg_bt_10">
			<select name="payment_mode" id="payment_mode" title="Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id');get_auto_values('booking_date','basic_fair','payment_mode','service_charge','markup','save','true','service_charge','basic',true);get_identifier_block('identifier','payment_mode','credit_card_details','credit_charges');get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges')">
			<?php get_payment_mode_dropdown(); ?>
			</select>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12 mg_bt_10">
			<input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" title="Amount" onchange="payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name','bank_id');validate_balance(this.id);get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges');">
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-sm-6 mg_bt_10 col-xs-12">
			<input class="hidden" type="text" id="credit_charges" name="credit_charges" title="Credit card charges" disabled>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
			<select class="hidden" id="identifier" onchange="get_credit_card_data('identifier','payment_mode','credit_card_details')" title="Identifier(4 digit)" required
			><option value=''>Select Identifier</option></select>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
			<input class="hidden" type="text" id="credit_card_details" name="credit_card_details" title="Credit card details" disabled>
		</div>
	</div>

	<div class="row">

		<div class="col-md-4 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="bank_name" name="bank_name" class="bank_suggest" placeholder="Bank Name" title="Bank Name" disabled>

		</div>

		<div class="col-md-4 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="transaction_id" name="transaction_id" onchange="validate_specialChar(this.id)" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>

		</div>

		<div class="col-md-4 col-sm-4 col-xs-12 mg_bt_10">

	        <select name="bank_id" id="bank_id" title="Select Bank" disabled>

	        <?php get_bank_dropdown(); ?>

	        </select>

	    </div>

	</div>
    <div class="row">
      <div class="col-md-9 col-md-offset-3 col-sm-9">
       <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= $txn_feild_note ?></span>
     </div>
    </div>

	



	<br>

	<div class="row mg_tp_20 text-center">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab3()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-sm btn-success" id="btn_ticket_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>

		</div>

	</div>



</form>

<script>

$('#payment_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

function switch_to_tab3(){ $('a[href="#tab3"]').tab('show'); }



$('#frm_tab4').validate({

	rules:{

			payment_date : { required : true },

			payment_amount : { required : true, number: true },

			payment_mode : { required : true },

			bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },

	        transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     

	        bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },  

	},

	submitHandler:function(form){

		var base_url = $('#base_url').val();
		var customer_id = $('#customer_id').val();
		var cust_first_name = $('#cust_first_name').val();
		var cust_middle_name = $('#cust_middle_name').val();
		var cust_last_name = $('#cust_last_name').val();
		var gender = $('#cust_gender').val();
		var cust_birth_date = $('#cust_birth_date').val();
		var age = $('#cust_age').val();
		var contact_no = $('#cust_contact_no').val();
		var email_id = $('#cust_email_id').val();
		var address = $('#cust_address1').val();
		var address2 = $('#cust_address2').val();
		var city = $('#city').val();
		var service_tax_no = $('#cust_service_tax_no').val();  
		var landline_no = $('#cust_landline_no').val();
		var alt_email_id = $('#cust_alt_email_id').val();
		var company_name = $('#corpo_company_name').val();
		var cust_type = $('#cust_type').val();
		var country_code = $('#country_code').val();
		var state = $('#cust_state').val();
		var active_flag = 'Active';
		var credit_amount = $('#credit_amount').val();
		var branch_admin_id = $('#branch_admin_id1').val();
		var financial_year_id = $('#financial_year_id').val();
		var credit_charges = $('#credit_charges').val();
		var credit_card_details = $('#credit_card_details').val();

		//New Customer save
		if(customer_id == '0'){
		    $.ajax({
		        type: 'post',
		        url: base_url+'controller/customer_master/customer_save.php',
		        data:{ first_name : cust_first_name, middle_name : cust_middle_name, last_name : cust_last_name, gender : gender, birth_date : cust_birth_date, age : age, contact_no : contact_no, email_id : email_id, address : address,address2 : address2,city:city,  active_flag : active_flag ,service_tax_no : service_tax_no, landline_no : landline_no, alt_email_id : alt_email_id,company_name : company_name, cust_type : cust_type,state : state, branch_admin_id : branch_admin_id, country_code : country_code},
		        success: function(result){
		        }
		    });
		}

		var emp_id = $('#emp_id').val();
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
		var booking_date = $('#booking_date').val();
		var payment_date = $('#payment_date').val();

		var payment_amount = $('#payment_amount').val();
		var payment_mode = $('#payment_mode').val();
		var bank_name = $('#bank_name').val();
		var hotel_sc = $('#hotel_sc').val();
		var hotel_markup = $('#hotel_markup').val();
		var hotel_taxes = $('#hotel_taxes').val();
		var hotel_markup_taxes = $('#hotel_markup_taxes').val();
		var hotel_tds = $('#hotel_tds').val();
        var roundoff = $('#roundoff').val();
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
		var transaction_id = $('#transaction_id').val();	
		var bank_id = $('#bank_id').val();
		var honorific_arr = new Array();
		var first_name_arr = new Array();
		var middle_name_arr = new Array();
		var last_name_arr = new Array();
		var birth_date_arr = new Array();
		var adolescence_arr = new Array();
		var coach_number_arr = new Array();
		var seat_number_arr = new Array();
		var ticket_number_arr = new Array();

		if(credit_amount != ''){ 
        	if(parseFloat(payment_amount) > parseFloat(credit_amount)) { error_msg_alert('Low Credit note balance'); return false; }
        }

        var table = document.getElementById("tbl_dynamic_train_ticket_master");
        var rowCount = table.rows.length;

        

        for(var i=0; i<rowCount; i++){

          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){

			  var honorific = row.cells[2].childNodes[0].value;
			  var first_name = row.cells[3].childNodes[0].value;
			  var middle_name = row.cells[4].childNodes[0].value;
			  var last_name = row.cells[5].childNodes[0].value;
			  var birth_date = row.cells[6].childNodes[0].value;
			  var adolescence = row.cells[7].childNodes[0].value;
			  var coach_number = row.cells[8].childNodes[0].value;
			  var seat_number = row.cells[9].childNodes[0].value;
			  var ticket_number = row.cells[10].childNodes[0].value;		  


			  honorific_arr.push(honorific);
			  first_name_arr.push(first_name);
			  middle_name_arr.push(middle_name);
			  last_name_arr.push(last_name);
			  birth_date_arr.push(birth_date);
			  adolescence_arr.push(adolescence);
			  coach_number_arr.push(coach_number);
			  seat_number_arr.push(seat_number);
			  ticket_number_arr.push(ticket_number);
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

		var payment_date = $('#payment_date').val();
		$('#btn_ticket_save').button('loading');
		$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
		if(data !== 'valid'){
			error_msg_alert("The Payment date does not match between selected Financial year.");
			$('#btn_ticket_save').button('reset');
			return false;
		}else{
			if($('#whatsapp_switch').val() == "on") whatsapp_send(emp_id, customer_id, booking_date, base_url);
        $.ajax({
        	type:'post',
        	url: base_url+'controller/visa_passport_ticket/train_ticket/ticket_master_save.php',
        	data:{ emp_id : emp_id,customer_id : customer_id, type_of_tour : type_of_tour, basic_fair : basic_fair, service_charge : service_charge, delivery_charges : delivery_charges, gst_on : gst_on, taxation_type : taxation_type, taxation_id : taxation_id, service_tax : service_tax, service_tax_subtotal : service_tax_subtotal, net_total : net_total, payment_due_date : payment_due_date, payment_date : payment_date, payment_amount : payment_amount, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, honorific_arr : honorific_arr, first_name_arr : first_name_arr, middle_name_arr : middle_name_arr, last_name_arr : last_name_arr, birth_date_arr : birth_date_arr, adolescence_arr : adolescence_arr, coach_number_arr : coach_number_arr, seat_number_arr : seat_number_arr, ticket_number_arr : ticket_number_arr, travel_datetime_arr : travel_datetime_arr, travel_from_arr : travel_from_arr, travel_to_arr : travel_to_arr, train_name_arr : train_name_arr, train_no_arr : train_no_arr, ticket_status_arr : ticket_status_arr, class_arr : class_arr, booking_from_arr : booking_from_arr, boarding_at_arr : boarding_at_arr, arriving_datetime_arr : arriving_datetime_arr,booking_date : booking_date, branch_admin_id : branch_admin_id,financial_year_id : financial_year_id,reflections:reflections,bsmValues:bsmValues,roundoff:roundoff,credit_charges:credit_charges,credit_card_details:credit_card_details },

        	success:function(result){
        		var msg = result.split('--');
        		if(msg[0]=="error"){
        			error_msg_alert(result);
        			$('#btn_ticket_save').button('reset');
					return false;
        		}
        		else{
        			msg_alert(result);
        			$('#save_modal').modal('hide');
        			train_ticket_customer_list_reflect();
        		}
        	}
		});
     }
  });





	}



});

</script>