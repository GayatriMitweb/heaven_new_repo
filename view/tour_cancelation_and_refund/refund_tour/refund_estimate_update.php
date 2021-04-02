<?php 
$sq_est_info = mysql_fetch_assoc(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$tourwise_id'"));
?>

<legend>Amount To Refund</legend>

<form id="frm_refund_estimate">

<fieldset class="cancel_fieldset">
<legend>Train Refund</legend>

<div class="row">
	<div class="col-md-3">
		<input type="text" name="train_amount" id="train_amount" placeholder="Amount" title="Amount" value="<?php echo ($sq_est_info['train_amount']=="") ? 0 : $sq_est_info['train_amount'] ?>" onchange="refund_calculate('train_amount', 'train_service_charge', 'train_service_tax', 'total_train_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="train_service_charge" id="train_service_charge" placeholder="Service Charge" title="Service Charge" value="<?php echo ($sq_est_info['train_service_charge']=="") ? 0 : $sq_est_info['train_service_charge'] ?>" onchange="refund_calculate('train_amount', 'train_service_charge', 'train_service_tax', 'total_train_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="train_service_tax" id="train_service_tax" placeholder="Tax" title="Tax" value="<?php echo ($sq_est_info['train_service_tax']=="") ? 0 : $sq_est_info['train_service_tax'] ?>" onchange="refund_calculate('train_amount', 'train_service_charge', 'train_service_tax', 'total_train_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="total_train_amount" id="total_train_amount" title="Total Amount" value="<?php echo $sq_est_info['total_train_amount'] ?>" disabled>
	</div>
</div>

</fieldset>

<fieldset class="cancel_fieldset">
<legend>Air Refund</legend>

<div class="row">
	<div class="col-md-3">
		<input type="text" name="plane_amount" id="plane_amount" placeholder="Amount" title="Amount" value="<?php echo ($sq_est_info['plane_amount']=="") ? 0 : $sq_est_info['plane_amount'] ?>" onchange="refund_calculate('plane_amount', 'plane_service_charge', 'plane_service_tax', 'total_plane_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="plane_service_charge" id="plane_service_charge" placeholder="Service Charge" title="Service Charge" value="<?php echo ($sq_est_info['plane_service_charge']=="") ? 0 : $sq_est_info['plane_service_charge'] ?>" onchange="refund_calculate('plane_amount', 'plane_service_charge', 'plane_service_tax', 'total_plane_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="plane_service_tax" id="plane_service_tax" placeholder="Tax" title="Tax" value="<?php echo ($sq_est_info['plane_service_tax']=="") ? 0 : $sq_est_info['plane_service_tax'] ?>" onchange="refund_calculate('plane_amount', 'plane_service_charge', 'plane_service_tax', 'total_plane_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="total_plane_amount" id="total_plane_amount" placeholder="Total Amount" title="Total Amount" value="<?php echo $sq_est_info['total_plane_amount'] ?>" disabled>
	</div>
</div>

</fieldset>

<fieldset class="cancel_fieldset">
<legend>Visa Refund</legend>

<div class="row">
	<div class="col-md-3">
		<input type="text" name="visa_amount" id="visa_amount" placeholder="Amount" title="Amount" value="<?php echo ($sq_est_info['visa_amount']=="") ? 0 : $sq_est_info['visa_amount'] ?>" onchange="refund_calculate('visa_amount', 'visa_service_charge', 'visa_service_tax', 'total_visa_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="visa_service_charge" id="visa_service_charge" placeholder="Service Charge" title="Service Charge" value="<?php echo ($sq_est_info['visa_service_charge']=="") ? 0 : $sq_est_info['visa_service_charge'] ?>" onchange="refund_calculate('visa_amount', 'visa_service_charge', 'visa_service_tax', 'total_visa_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="visa_service_tax" id="visa_service_tax" placeholder="Tax" title="Tax" value="<?php echo ($sq_est_info['visa_service_tax']=="") ? 0 : $sq_est_info['visa_service_tax'] ?>" onchange="refund_calculate('visa_amount', 'visa_service_charge', 'visa_service_tax', 'total_visa_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="total_visa_amount" id="total_visa_amount" placeholder="Total Amount" title="Total Amount" value="<?php echo $sq_est_info['total_visa_amount'] ?>" disabled>
	</div>
</div>

</fieldset>

<fieldset class="cancel_fieldset">
<legend>Insuarance Refund</legend>

<div class="row">
	<div class="col-md-3">
		<input type="text" name="insuarance_amount" id="insuarance_amount" placeholder="Amount" title="Amount" value="<?php echo ($sq_est_info['insuarance_amount']=="") ? 0 : $sq_est_info['insuarance_amount'] ?>" onchange="refund_calculate('insuarance_amount', 'insuarance_service_charge', 'insuarance_service_tax', 'total_insuarance_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="insuarance_service_charge" id="insuarance_service_charge" placeholder="Service Charge" title="Service Charge" value="<?php echo ($sq_est_info['insuarance_service_charge']=="") ? 0 : $sq_est_info['insuarance_service_charge'] ?>" onchange="refund_calculate('insuarance_amount', 'insuarance_service_charge', 'insuarance_service_tax', 'total_insuarance_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="insuarance_service_tax" id="insuarance_service_tax" placeholder="Tax" title="Tax" value="<?php echo ($sq_est_info['insuarance_service_tax']=="") ? 0 : $sq_est_info['insuarance_service_tax'] ?>" onchange="refund_calculate('insuarance_amount', 'insuarance_service_charge', 'insuarance_service_tax', 'total_insuarance_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="total_insuarance_amount" id="total_insuarance_amount" placeholder="Total Amount" title="Total Amount" value="<?php echo $sq_est_info['total_insuarance_amount'] ?>" disabled>
	</div>
</div>

</fieldset>

<fieldset class="cancel_fieldset">
<legend>Tour Refund</legend>

<div class="row">
	<div class="col-md-3">
		<input type="text" name="tour_amount" id="tour_amount" placeholder="Amount" title="Amount" value="<?php echo ($sq_est_info['tour_amount']=="") ? 0 : $sq_est_info['tour_amount'] ?>" onchange="refund_calculate('tour_amount', 'tour_service_charge', 'tour_service_tax', 'total_tour_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="tour_service_tax" id="tour_service_tax" placeholder="Tax" title="Tax" value="<?php echo ($sq_est_info['tour_service_tax']=="") ? 0 : $sq_est_info['tour_service_tax'] ?>" onchange="refund_calculate('tour_amount', 'tour_service_charge', 'tour_service_tax', 'total_tour_amount')">
	</div>
	<div class="col-md-3">
		<input type="text" name="total_tour_amount" id="total_tour_amount" placeholder="Total Amount" title="Total Amount" value="<?php echo $sq_est_info['total_tour_amount'] ?>" disabled>
	</div>
</div>

</fieldset>

<fieldset class="cancel_fieldset">
<legend>Tour Refund</legend>

<div class="row">
	<div class="col-md-3">
		<input type="text" name="total_refund" id="total_refund" placeholder="Total Refund" title="Total Refund" value="<?php echo $sq_est_info['total_refund'] ?>" disabled>
	</div>
</div>

</fieldset>


<div class="row text-center mg_bt_20">
	<div class="col-md-12">
		<button class="btn btn-success ico_left"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
	</div>
</div>

</form>

<hr>

<script>
function refund_calculate(amount_id, charge_id, tax_id, total_id)
{
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

function total_refund_calculate()
{
	var total_train_amount = $('#total_train_amount').val();
	var total_plane_amount = $('#total_plane_amount').val();
	var total_visa_amount = $('#total_visa_amount').val();
	var total_insuarance_amount = $('#total_insuarance_amount').val();
	var total_tour_amount = $('#total_tour_amount').val();

	var total_refund = parseFloat(total_train_amount) + parseFloat(total_plane_amount) + parseFloat(total_visa_amount) + parseFloat(total_insuarance_amount) + parseFloat(total_tour_amount);

	$('#total_refund').val(total_refund.toFixed(2));
}

$('#frm_refund_estimate').validate({
	rules:{
			train_amount :{ required : true, number : true },
			train_service_charge :{ required : true, number : true },
			train_service_tax :{ required : true, number : true },
			total_train_amount :{ required : true, number : true },
			plane_amount :{ required : true, number : true },
			plane_service_charge :{ required : true, number : true },
			plane_service_tax :{ required : true, number : true },
			total_plane_amount :{ required : true, number : true },
			visa_amount :{ required : true, number : true },
			visa_service_charge :{ required : true, number : true },
			visa_service_tax :{ required : true, number : true },
			total_visa_amount :{ required : true, number : true },
			insuarance_amount :{ required : true, number : true },
			insuarance_service_charge :{ required : true, number : true },
			insuarance_service_tax :{ required : true, number : true },
			total_insuarance_amount :{ required : true, number : true },
			tour_amount :{ required : true, number : true },
			tour_service_tax :{ required : true, number : true },
			total_tour_amount	 :{ required : true, number : true },	
			total_refund	 :{ required : true, number : true },	
	},
	submitHandler:function(form){

			var tourwise_id = $('#txt_tourwise_traveler_id').val();
			var train_amount = $('#train_amount').val();
			var train_service_charge = $('#train_service_charge').val();
			var train_service_tax = $('#train_service_tax').val();
			var total_train_amount = $('#total_train_amount').val();
			var plane_amount = $('#plane_amount').val();
			var plane_service_charge = $('#plane_service_charge').val();
			var plane_service_tax = $('#plane_service_tax').val();
			var total_plane_amount = $('#total_plane_amount').val();
			var visa_amount = $('#visa_amount').val();
			var visa_service_charge = $('#visa_service_charge').val();
			var visa_service_tax = $('#visa_service_tax').val();
			var total_visa_amount = $('#total_visa_amount').val();
			var insuarance_amount = $('#insuarance_amount').val();
			var insuarance_service_charge = $('#insuarance_service_charge').val();
			var insuarance_service_tax = $('#insuarance_service_tax').val();
			var total_insuarance_amount = $('#total_insuarance_amount').val();
			var tour_amount = $('#tour_amount').val();
			var tour_service_tax = $('#tour_service_tax').val();
			var total_tour_amount = $('#total_tour_amount').val();
			var total_refund = $('#total_refund').val();


			$.ajax({
				type:'post',
				url: base_url()+'controller/group_tour/tour_cancelation_and_refund/booking_tour_refund_estimate.php',
				data: { tourwise_id : tourwise_id, train_amount : train_amount, train_service_charge : train_service_charge, train_service_tax : train_service_tax, total_train_amount : total_train_amount, plane_amount : plane_amount, plane_service_charge : plane_service_charge, plane_service_tax : plane_service_tax, total_plane_amount : total_plane_amount, visa_amount : visa_amount, visa_service_charge : visa_service_charge, visa_service_tax : visa_service_tax, total_visa_amount : total_visa_amount, insuarance_amount : insuarance_amount, insuarance_service_charge : insuarance_service_charge, insuarance_service_tax : insuarance_service_tax, total_insuarance_amount : total_insuarance_amount, tour_amount : tour_amount, tour_service_tax : tour_service_tax, total_tour_amount : total_tour_amount, total_refund : total_refund },
				success:function(result){
					msg_popup_reload(result);
				}
				
			});



	}

});
</script>