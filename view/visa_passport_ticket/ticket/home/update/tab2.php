<form id="frm_tab2">

	<div class="row">
		<div class="col-md-8 col-sm-12 col-xs-12 mg_bt_20_xs">
			<strong>Type Of Trip :</strong>&nbsp;&nbsp;&nbsp;

			<?php $chk = ($sq_ticket['type_of_tour']=="One Way") ? "checked" : "" ?>
			<input type="radio" name="type_of_tour" id="type_of_tour-one_way" value="One Way" <?= $chk ?>>&nbsp;&nbsp;<label for="type_of_tour-one_way">One Way</label>
			&nbsp;&nbsp;&nbsp;
			
			<?php $chk = ($sq_ticket['type_of_tour']=="Round Trip") ? "checked" : "" ?>
			<input type="radio" name="type_of_tour" id="type_of_tour-round_trip" value="Round Trip" <?= $chk ?>>&nbsp;&nbsp;<label for="type_of_tour-round_trip">Round Trip</label>
			&nbsp;&nbsp;&nbsp;

			<?php $chk = ($sq_ticket['type_of_tour']=="Multi City") ? "checked" : "" ?>
			<input type="radio" name="type_of_tour" id="type_of_tour-multi_city" value="Multi City" <?= $chk ?>>&nbsp;&nbsp;<label for="type_of_tour-multi_city">Multi City</label>
			&nbsp;&nbsp;&nbsp;
		</div>
		<div class="col-md-4 col-sm-12 col-xs-12 text-right">
			<button type="button" class="btn btn-info btn-sm ico_left" onclick="addDyn('div_dynamic_ticket_info');event_airport_su();copy_values()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Section</button>
		</div>
	</div>

	<?php 
	$sq_trip_entries_count = mysql_num_rows(mysql_query("select * from ticket_trip_entries where ticket_id='$ticket_id'"));
	?>
	<div class="dynform-wrap" id="div_dynamic_ticket_info" data-counter="<?= $sq_trip_entries_count ?>">

		<?php
		$count = 0;
		$sq_trip_entries = mysql_query("select * from ticket_trip_entries where ticket_id='$ticket_id'");
		while($row_entry = mysql_fetch_assoc($sq_trip_entries)){

			$count++;
			?>
				<div class="dynform-item">
					<input type="hidden" id="trip_entry_id-<?= $count ?>" name="trip_entry_id" value="<?= $row_entry['entry_id'] ?>" data-dyn-valid="">
					<div class="row mg_bt_10">
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<input type="text" id="departure_datetime-<?= $count ?>" name="departure_datetime" class="app_datetimepicker" placeholder="Departure Date-Time" title="Departure Date-Time" data-dyn-valid="required" value="<?= get_datetime_user($row_entry['departure_datetime']) ?>" onchange="get_arrival_dateid(this.id);">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<input type="text" id="arrival_datetime-<?= $count ?>" name="arrival_datetime" class="app_datetimepicker" placeholder="Arrival Date-Time" title="Arrival Date-Time"  data-dyn-valid="required" value="<?= get_datetime_user($row_entry['arrival_datetime']) ?>">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<select id="airlines_name-<?= $count ?>" name="airlines_name" title="Airlines Name" style="width:100%" data-dyn-valid="required" class="app_select" onchange="get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','markup','update','true','service_charge','discount');">
								<?php if($row_entry['airlines_name']!=''){?><option value="<?= $row_entry['airlines_name'] ?>"><?= $row_entry['airlines_name'] ?></option><?php } ?>
								<option value="">Airline Name</option>
								<?php $sq_airline = mysql_query("select airline_name,airline_code from airline_master where active_flag!='Inactive' order by airline_name asc");
								while($row_airline = mysql_fetch_assoc($sq_airline)){
							    ?>
							    <option value="<?= $row_airline['airline_name'].' ('.$row_airline['airline_code'].')' ?>"><?= $row_airline['airline_name'].' ('.$row_airline['airline_code'].')' ?></option>
							    <?php } ?>
							</select>
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<select name="class" id="class-1" title="Class" data-dyn-valid="required" onchange="get_auto_values('booking_date1','basic_cost','payment_mode','service_charge','markup','update','true','service_charge','discount');">
								<?php if($row_entry['class']!=''){?><option value="<?= $row_entry['class'] ?>"><?= $row_entry['class'] ?></option><?php } ?>
								<option value="">Class</option>
								<option value="Economy">Economy</option>
								<option value="Business">Business</option>
								<option value="Business">Premium Economy</option>
								<option value="First class">First class</option>
							</select>
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<input type="text" id="flight_no-<?= $count ?>" style="text-transform: uppercase;" onchange="validate_specialChar(this.id)" name="flight_no" placeholder="Flight No" title="Flight No" data-dyn-valid="required" value="<?= $row_entry['flight_no'] ?>">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<input type="text" id="airlin_pnr-<?= $count ?>" style="text-transform: uppercase;" onchange="validate_specialChar(this.id)" name="airlin_pnr" placeholder="Airline PNR" title="Airline PNR" data-dyn-valid="required" value="<?= $row_entry['airlin_pnr'] ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-12 mg_bt_10_xs">
						<?php 
							 $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_entry[from_city]'"));
							?>
							<input id="airpf-<?= $count ?>" name="airpf" class="form-control autocomplete" placeholder="Enter Airport" data-dyn-valid="required" value="<?php echo ($sq_city['city_name']) ? $sq_city['city_name']." - ".$row_entry['departure_city'] : ''; ?>">
							<input type="hidden" name="from_city_id" id="from_city-<?= $count ?>" value="<?php echo ($row_entry['from_city'] != '')? $row_entry['from_city']: ''; ?>" data-dyn-valid="required"/>
							<input type="hidden" name="departure_city" id="departure_city-<?= $count ?>" value="<?php echo ($row_entry['departure_city'] != '')? $row_entry['departure_city']: '';?>"  data-dyn-valid="required">
						</div>
						<?php 
							 $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_entry[to_city]'"));
							?>
						<div class="col-md-4 col-sm-4 col-xs-12 mg_bt_10_xs">
							<input id="airpt-<?= $count ?>" name="airpt" class="form-control autocomplete" placeholder="Enter Airport" data-dyn-valid="required" value="<?php echo ($sq_city['city_name']) ? $sq_city['city_name']." - ".$row_entry['arrival_city'] : ''; ?>">
							<input type="hidden" name="to_city_id" id="to_city-<?= $count ?>" data-dyn-valid="required" value="<?php echo ($row_entry['to_city'] != '')? $row_entry['to_city']: ''; ?>"/>
							<input type="hidden" name="arrival_city" id="arrival_city-<?= $count ?>" data-dyn-valid="required" value="<?php echo ($row_entry['arrival_city'] != '')? $row_entry['arrival_city']: '';?>">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<input type="text" id="meal_plan-1" onchange=" validate_specialChar(this.id)" name="meal_plan" placeholder="Meal Plan" title="Meal Plan" data-dyn-valid="" value="<?php echo $row_entry['meal_plan']; ?>">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<input type="text" id="luggage-1" onchange=" validate_specialChar(this.id)" name="luggage" placeholder="Luggage" title="Luggage" data-dyn-valid="" value="<?php echo $row_entry['luggage']; ?>">
				        </div>
						<div class="col-md-4 col-sm-12 col-xs-12">
							<textarea name="special_note" onchange="validate_address(this.id) ;" id="special_note-<?= $count ?>" rows="1" placeholder="Special Note" title="Special Note" data-dyn-valid="required"><?= $row_entry['special_note'] ?></textarea>
						</div>
					</div>
				</div>
				<script>
					$('#departure_datetime-<?= $count ?>, #arrival_datetime-<?= $count ?>').datetimepicker({ format:'d-m-Y H:i:s' });
					$('#airlines_name-<?= $count ?>').select2();
				</script>
			<?php
		}
		?>

	</div>

	<div class="row text-center mg_tp_20">
		<div class="col-xs-12">
			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
			&nbsp;&nbsp;
			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>

</form>

<script>
$('#frm_tab2').validate({
	rules:{
			type_of_tour : { required : true },
	},
	submitHandler:function(form){		
		var type_of_tour = $('input[name="type_of_tour"]:checked').val();
		
		/*var status = dyn_validate('div_dynamic_ticket_info');
		if(!status){ return false; }*/

		var msg = "Type of trip is required"; 
		if(type_of_tour == undefined) { error_msg_alert(msg); return false;}

		$('a[href="#tab3"]').tab('show');

	}
});
function switch_to_tab1(){ $('a[href="#tab1"]').tab('show'); }
</script>





<script>
function getAirports() {
	var air_req_u = $.ajax({
			method:'post',
			url : 'home/airport_list.php',
			async : false,
		});
	return JSON.parse(air_req_u.responseText);
}
var a_list_u = getAirports();
for(var num_airp = 1; num_airp <= parseInt($('#div_dynamic_ticket_info').attr('data-counter')); num_airp++)
	event_airport_su(num_airp);
	
	function event_airport_su(count = 2){
		if(count == 1)	{id1 = "airpf-1"; id2 = "airpt-1"}
		else	{id1 = "airpf-"+$('#div_dynamic_ticket_info').attr('data-counter');id2 = "airpt-"+$('#div_dynamic_ticket_info').attr('data-counter');}
		ids = [{"dep" : id1}, {"arr" : id2}];
		airport_load_main_sale(ids);
	}

function copy_values(){
	var count = $('#div_dynamic_ticket_info').attr('data-counter');
	$('#meal_plan-'+count).val($('#meal_plan-1').val());
	$('#luggage-'+count).val($('#luggage-1').val());
	$('#airpf-'+count).val($('#airpt-1').val());
	$('#from_city-'+count).val($('#to_city-1').val());
	$('#departure_city-'+count).val($('#arrival_city-1').val());
	$('#airpt-'+count).val($('#airpf-1').val());
	$('#to_city-'+count).val($('#from_city-1').val());
	$('#arrival_city-'+count).val($('#departure_city-1').val());
}
</script>
<style>
#project-label {
    display: block;
    font-weight: bold;
    margin-bottom: 1em;
  }
  #project-icon {
    float: left;
    height: 32px;
    width: 32px;
  }
  #project-description {
    margin: 0;
    padding: 0;
  }
</style>