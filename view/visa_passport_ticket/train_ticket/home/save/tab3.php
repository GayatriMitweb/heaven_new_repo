<form id="frm_tab3">

	

	<div class="row mg_bt_10">

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
		<small id="basic_show" style="color:red">&nbsp;</small>
			<input type="text" id="basic_fair" name="basic_fair" placeholder="*Basic Fare" title="Basic Fare" onchange="calculate_total_amount();validate_balance(this.id);get_auto_values('booking_date','basic_fair','payment_mode','service_charge','markup','save','true','basic','basic');">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
            <small id="service_show" style="color:red">&nbsp;</small>
			<input type="text" id="service_charge" name="service_charge" placeholder="Service Charge" title="Service Charge" onchange="calculate_total_amount();validate_balance(this.id);get_auto_values('booking_date','basic_fair','payment_mode','service_charge','markup','save','false','service_charge','discount')">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
		<small>&nbsp;</small>
			<input type="text" id="delivery_charges" name="delivery_charges" placeholder="Delivery Charges" title="Delivery Charges" onchange="calculate_total_amount();validate_balance(this.id)">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
		<small>&nbsp;</small>
			<input type="text" id="service_tax_subtotal" name="service_tax_subtotal" placeholder="Tax Amount" title="Tax Amount" readonly>
		</div>
		<div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">
		<small>&nbsp;</small>
			<input type="text" name="roundoff" id="roundoff" class="text-right" placeholder="Round Off" title="RoundOff" readonly>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
		<small>&nbsp;</small>
			<input type="text" id="net_total" class="amount_feild_highlight text-right" name="net_total" placeholder="Net Total" title="Net Total" readonly>
		</div>
		</div>
		<div class="row mg_bt_10">
		<div class="col-md-2 col-sm-4 col-xs-12">
			<input type="text" id="payment_due_date"  name="payment_due_date" placeholder="Due Date" title="Due Date" value="<?= date('d-m-Y') ?>">
		</div>

		<div class="col-md-2 col-sm-4 col-xs-12">
			<input type="text" id="booking_date" name="booking_date" value="<?= date('d-m-Y') ?>" placeholder="Booking Date" title="Booking Date" onchange="check_valid_date(this.id);get_auto_values('booking_date','basic_fair','payment_mode','service_charge','markup','save','true','service_charge','basic',true);">
		</div>
	</div>



	<div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>



</form>



<script>

$('#payment_due_date,#booking_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

function switch_to_tab2(){ $('a[href="#tab2"]').tab('show'); }

$('#frm_tab3').validate({

	rules:{

			basic_fair : { required : true, number : true },
			net_total : { required : true, number : true },
			booking_date : { required : true},

	},

	submitHandler:function(form){		

		var taxation_id = $('#taxation_id').val();
		var base_url = $('#base_url').val();
		if(parseFloat(taxation_id) == "0"){ error_msg_alert("Please select Tax Percentage"); return false; }

		//Validation for booking and payment date in login financial year
		var check_date1 = $('#booking_date').val();
		$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
			if(data != 'valid'){
				error_msg_alert("The Booking date does not match between selected Financial year.");
				return false;
			}
			else{
				$('a[href="#tab4"]').tab('show');
			}
		});
	}

});

</script>