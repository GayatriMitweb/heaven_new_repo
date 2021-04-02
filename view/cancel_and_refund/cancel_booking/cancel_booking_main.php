<?php
include "../../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
	<div class="row"> 
		<div class="col-md-12 col-xs-12">
			<div class="row">
				<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
					<select id="booking_id" name="booking_id" title="Select Booking ID" style="width:100%" onchange="cancel_booking_reflect()"> 
						<option value="">Select Booking</option>
						<?php 
						$sq_hotel = mysql_query("select * from package_tour_booking_master order by booking_id desc");
						while($row_hotel = mysql_fetch_assoc($sq_hotel)){
							$date = $row_hotel['booking_date'];
							$yr = explode("-", $date);
							$year =$yr[0];
							$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_hotel[customer_id]'"));
							?>
							<option value="<?= $row_hotel['booking_id'] ?>"><?= get_package_booking_id($row_hotel['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
							<?php } ?>
		      		</select>
				</div>
			</div>
		</div> 
	</div>
</div>

<div id="div_cancel_booking_reflect" class="mg_tp_10"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
	$("#booking_id").select2();
	function cancel_booking_reflect(){
		var booking_id = $('#booking_id').val();
		if(booking_id!=''){
			$.post('cancel_booking_reflect.php', { booking_id : booking_id }, function(data){
				$('#div_cancel_booking_reflect').html(data);
			});
		}else{
			$('#div_cancel_booking_reflect').html('');
		}
	}
	function refund_calculate(amount_id, charge_id, tax_id, total_id){
		var amount = $('#'+amount_id).val();
		var charge = $('#'+charge_id).val();
		var tax = $('#'+tax_id).val();

		if(amount==""){ amount = 0; }
		if(charge==""){ charge = 0; }
		if(tax==""){ tax = 0; }

		if(charge_id=="tour_service_charge"){ charge = 0; }

		var total = parseFloat(amount) + parseFloat(charge) + parseFloat(tax);

		$('#'+total_id).val(total.toFixed(2));

		total_refund_calculate();
	}

function total_refund_calculate(){
	var total_train_amount = $('#total_train_amount').val();
	var total_plane_amount = $('#total_plane_amount').val();
	var total_cruise_amount = $('#total_cruise_amount').val();
	var total_visa_amount = $('#total_visa_amount').val();
	var total_insuarance_amount = $('#total_insuarance_amount').val();
	var total_tour_amount = $('#total_tour_amount').val();

	if(total_train_amount==""){ total_train_amount = 0; }
	if(total_plane_amount==""){ total_plane_amount = 0; }
	if(total_cruise_amount==""){ total_cruise_amount = 0; }
	if(total_visa_amount==""){ total_visa_amount = 0; }
	if(total_insuarance_amount==""){ total_insuarance_amount = 0; }
	if(total_tour_amount==""){ total_tour_amount = 0; }
	
	var total_refund = parseFloat(total_train_amount) + parseFloat(total_plane_amount) + parseFloat(total_cruise_amount) + parseFloat(total_visa_amount) + parseFloat(total_insuarance_amount) + parseFloat(total_tour_amount);

	$('#total_refund').val( total_refund.toFixed(2) );
}
</script>