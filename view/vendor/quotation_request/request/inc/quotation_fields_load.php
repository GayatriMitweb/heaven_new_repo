<?php

include "../../../../../model/model.php";



$quotation_for = $_POST['quotation_for'];
$enquiry_id = $_POST['enquiry_id'];


if(isset($_POST['request_id'])){

	$request_id = $_POST['request_id'];

	$sq_req = mysql_fetch_assoc(mysql_query("select * from vendor_request_master where request_id='$request_id'"));

}

else{

	$request_id = '';
	$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));

}

?>

<hr>

<?php

if($quotation_for=="Transport"){



	if($request_id==""){

		$from_date = $to_date = "";

	}

	else{

		$dynamic_fields = $sq_req['dynamic_fields'];

		$dynamic_fields_arr = json_decode($dynamic_fields, true);

		foreach($dynamic_fields_arr as $dynamic_fields){


			if($dynamic_fields['name']=="vehicle_name"){ $vehicle_name = $dynamic_fields['value']; }

			if($dynamic_fields['name']=="vehicle_type"){ $vehicle_type = $dynamic_fields['value']; }



		}

	}

	?>

	<div class="row">


		<div class="col-sm-3 col-xs-12 mg_bt_10_sm_xs">

			<input type="text" id="vehicle_name" name="vehicle_name"  onchange="validate_specialChar(this.id); validate_spaces(this.id);" placeholder="*Vehicle Name" title="Vehicle Name" value="<?= $vehicle_name ?>">

		</div>

		<div class="col-sm-3 col-xs-12 mg_bt_10_sm_xs">

			<select name="vehicle_type" id="vehicle_type" title="Vehicle Type">

				<?php if($vehicle_type !=''){

				?>

				<option value="<?php echo $vehicle_type; ?>"><?php echo $vehicle_type; ?></option>

				<?php } ?>

				<option value="">*Vehicle Type</option>

				<option value="AC">AC</option>

				<option value="Non-AC">Non-AC</option>						

			</select>

		</div>

	</div>

	<script>

		$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

	</script>

	<?php

}



if($quotation_for=="Hotel"){



	if($request_id==""){
		
	

		$enquiry_content = $sq_enq['enquiry_content'];
		$enquiry_content_arr1 = json_decode($enquiry_content, true);	

			foreach($enquiry_content_arr1 as $enquiry_content){
		    if($enquiry_content['name']=="total_members"){ $total_members = $enquiry_content['value']; }
			if($enquiry_content['name']=="total_adult"){ $total_adults = $enquiry_content['value']; }
			// if($enquiry_content['name']=="total_children"){ $total_childrens = $enquiry_content['value']; }
			if($enquiry_content['name']=="total_infant"){ $total_infants = $enquiry_content['value']; }
			if($enquiry_content['name']=="children_with_bed"){ $with_bed = $enquiry_content['value']; }
			if($enquiry_content['name']=="children_without_bed"){ $without_bed = $enquiry_content['value']; }
		    }
		 

	}

	else{

		$dynamic_fields = $sq_req['dynamic_fields'];

		$dynamic_fields_arr = json_decode($dynamic_fields, true);

		foreach($dynamic_fields_arr as $dynamic_fields){



			if($dynamic_fields['name']=="total_adults"){ $total_adults = $dynamic_fields['value']; }

			// if($dynamic_fields['name']=="total_childrens"){ $total_childrens = $dynamic_fields['value']; }

			if($dynamic_fields['name']=="total_infants"){ $total_infants = $dynamic_fields['value']; }

			if($dynamic_fields['name']=="total_members"){ $total_members = $dynamic_fields['value']; }

			if($dynamic_fields['name']=="with_bed"){ $with_bed = $dynamic_fields['value']; }

			if($dynamic_fields['name']=="without_bed"){ $without_bed = $dynamic_fields['value']; }



		}

	}

	?>
 <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
       <legend>Passenger Information</legend>
	<div class="row">
		<div class="col-md-3 col-sm-3 col-xs-12 mg_bt_10_xs">
			<input type="text" id="total_adults" name="total_adults" placeholder="*Total Adults" title="Total Adults" onchange="validate_balance(this.id); calculate_total_members()" value="<?= $total_adults ?>">
		</div>
		<div class="col-md-3 col-sm-3 col-xs-12 mg_bt_10_xs mg_bt_10">
			<input type="text" id="with_bed" name="with_bed" placeholder="*Child With Bed" title="Child With Bed" onchange="validate_balance(this.id);calculate_total_members()" value="<?= $with_bed ?>">
		</div>
		<div class="col-md-3 col-sm-3 col-xs-12 mg_bt_10">
			<input type="text" id="without_bed" name="without_bed" placeholder="*Child Without Bed" title="Child Without Bed" onchange="validate_balance(this.id);calculate_total_members()" value="<?= $without_bed ?>">
		</div>
		<div class="col-md-3 col-sm-3 col-xs-12 mg_bt_10_xs">
			<input type="text" id="total_infants" name="total_infants" placeholder="*Total Infants" title="Total Infants" onchange="validate_balance(this.id); calculate_total_members()" value="<?= $total_infants ?>">
		</div>
	</div>	
	<div class="row">
		<div class="col-md-3 col-sm-3">
			<input type="text" id="total_members" name="total_members" placeholder="*Total Passenger" title="Total Passenger" readonly value="<?= $total_members ?>">
		</div>
	</div>	
</div>
	<script>

		function calculate_total_members()

		{

			var total_adults = $('#total_adults').val();

			var with_bed = $('#with_bed').val();
			var without_bed = $('#without_bed').val();

			var total_infants = $('#total_infants').val();



			if(total_adults==""){ total_adults = 0; }

			if(with_bed==""){ with_bed = 0; }
			if(without_bed==""){ without_bed = 0; }

			if(total_infants==""){ total_infants = 0; }



			var total_members = parseFloat(total_adults) + parseFloat(with_bed) + parseFloat(without_bed) + parseFloat(total_infants);

			$('#total_members').val(total_members);

		}

	</script>

	<?php

}



if($quotation_for=="DMC"){



	if($request_id==""){

		$enquiry_content = $sq_enq['enquiry_content'];
		$enquiry_content_arr1 = json_decode($enquiry_content, true);	

			foreach($enquiry_content_arr1 as $enquiry_content){
		    if($enquiry_content['name']=="total_members"){ $total_members = $enquiry_content['value']; }
			if($enquiry_content['name']=="total_adult"){ $total_adults = $enquiry_content['value']; }
			if($enquiry_content['name']=="total_infant"){ $total_infants = $enquiry_content['value']; }
			if($enquiry_content['name']=="children_with_bed"){ $with_bed = $enquiry_content['value']; }
			if($enquiry_content['name']=="children_without_bed"){ $without_bed = $enquiry_content['value']; }
		    }
		 

	}

	else{

		$dynamic_fields = $sq_req['dynamic_fields'];

		$dynamic_fields_arr = json_decode($dynamic_fields, true);

		foreach($dynamic_fields_arr as $dynamic_fields){



			if($dynamic_fields['name']=="total_adults"){ $total_adults = $dynamic_fields['value']; }

			if($dynamic_fields['name']=="total_infants"){ $total_infants = $dynamic_fields['value']; }

			if($dynamic_fields['name']=="total_members"){ $total_members = $dynamic_fields['value']; }

			if($dynamic_fields['name']=="with_bed"){ $with_bed = $dynamic_fields['value']; }

			if($dynamic_fields['name']=="without_bed"){ $without_bed = $dynamic_fields['value']; }

			if($dynamic_fields['name']=="visa_required"){ $visa_required = $dynamic_fields['value']; }

			if($dynamic_fields['name']=="extra_bed"){ $extra_bed = $dynamic_fields['value']; }




		}

	}

	?>
 <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
       <legend>Passenger Information</legend>
	<div class="row mg_bt_10">

		<div class="col-md-3 col-sm-3 col-xs-12 mg_bt_10">

			<input type="text" id="total_adults" name="total_adults" placeholder="Total Adults" title="Total Adults" onchange="validate_balance(this.id); calculate_total_members()" value="<?= $total_adults ?>">

		</div>

		<div class="col-md-3 col-sm-3 col-xs-12 mg_bt_10">

			<input type="text" id="with_bed" name="with_bed" placeholder="Child With Bed" title="Child With Bed" onchange="validate_balance(this.id);calculate_total_members()" value="<?= $with_bed ?>">

		</div>

		<div class="col-md-3 col-sm-3 col-xs-12 mg_bt_10">

			<input type="text" id="without_bed" name="without_bed" placeholder="Child Without Bed" title="Child Without Bed" onchange="validate_balance(this.id);calculate_total_members()" value="<?= $without_bed ?>">

		</div>

		<div class="col-md-3 col-sm-3 col-xs-12 mg_bt_10">

			<input type="text" id="total_infants" name="total_infants" placeholder="Total Infants" title="Total Infants" onchange="validate_balance(this.id); calculate_total_members()" value="<?= $total_infants ?>">

		</div>

		<div class="col-md-3 col-sm-3 col-xs-12 mg_bt_10">

			<input type="text" id="total_members" name="total_members" placeholder="Total Passenger" title="Total Passenger" readonly value="<?= $total_members ?>">

		</div>


		<div class="col-md-3 col-sm-3 col-xs-12 mg_bt_10">

			<input type="text" id="extra_bed" name="extra_bed" placeholder="Extra Bed" title="Extra Bed" onchange="validate_balance(this.id);" value="<?= $extra_bed ?>">

		</div>

		<div class="col-md-3 col-sm-3 col-xs-12">

			<select name="visa_required" id="visa_required" title="Visa Required" placeholder="Visa Required" style="width:100%">

				<?php if($visa_required != '') { ?>

					<option value="<?= $visa_required ?>"><?= $visa_required ?></option>

			 	<?php } ?>

				<option value="">Visa Required</option>

				<option value="Yes">Yes</option>

				<option value="No">No</option>

			</select>

		</div>

	</div>
</div>
	<script>

		function calculate_total_members()

		{

			var total_adults = $('#total_adults').val();

			var without_bed = $('#without_bed').val();
			var with_bed = $('#with_bed').val();

			var total_infants = $('#total_infants').val();



			if(total_adults==""){ total_adults = 0; }

			if(without_bed==""){ without_bed = 0; }
			if(with_bed==""){ with_bed = 0; }

			if(total_infants==""){ total_infants = 0; }



			var total_members = parseFloat(total_adults) + parseFloat(without_bed) + parseFloat(with_bed) + parseFloat(total_infants);

			$('#total_members').val(total_members);

		}

	</script>

	<?php

}

?>



<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>

