<form id="frm_tab2">
	
	<div class="row">
		<div class="col-md-8 col-sm-12 col-xs-12 mg_bt_20_xs">
			<strong>Type Of Trip :</strong>&nbsp;&nbsp;&nbsp;
			<?php $chk = ($sq_booking['type_of_tour']=="One Way") ? "checked" : ""; ?>
			<input type="radio" name="type_of_tour" id="type_of_tour-one_way" value="One Way" <?= $chk ?>>&nbsp;&nbsp;<label for="type_of_tour-one_way">One Way</label>
			&nbsp;&nbsp;&nbsp;
			<?php $chk = ($sq_booking['type_of_tour']=="Return Trip") ? "checked" : ""; ?>
			<input type="radio" name="type_of_tour" id="type_of_tour-return_trip" value="Return Trip" <?= $chk ?>>&nbsp;&nbsp;<label for="type_of_tour-return_trip">Return Trip</label>
			&nbsp;&nbsp;&nbsp;
		</div>
		<div class="col-md-4 col-sm-12 col-xs-12 text-right">
			<button type="button" class="btn btn-info btn-sm ico_left" onclick="addDyn('div_dynamic_ticket_info')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Section</button>
		</div>
	</div>

	<?php $sq_entry_count = mysql_num_rows(mysql_query("select * from train_ticket_master_trip_entries where train_ticket_id='$train_ticket_id'")); ?>
	<div class="dynform-wrap" id="div_dynamic_ticket_info" data-counter="<?= $sq_entry_count ?>">

		<?php 
		$count = 0;
		$sq_entry = mysql_query("select * from train_ticket_master_trip_entries where train_ticket_id='$train_ticket_id'");
		while($row_entry = mysql_fetch_assoc($sq_entry)){
			$count++;
			?>
				<div class="dynform-item">	

					<input type="hidden" id="trip_entry_id-<?= $count ?>" name="trip_entry_id" value="<?= $row_entry['entry_id'] ?>" data-dyn-valid="">	
				
					<div class="row ">
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<input type="text" id="travel_datetime-<?= $count ?>" name="travel_datetime" placeholder="Departure Date-Time" title="Departure Date-Time" class="app_datetimepicker" data-dyn-valid="required" value="<?= get_datetime_user($row_entry['travel_datetime']) ?>" onchange="get_arrival_dateid(this.id);">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<input type="text" id="arriving_datetime-<?= $count ?>" name="arriving_datetime" placeholder="Arrival Date-Time" title="Arrival Date-Time" class="app_datetimepicker" data-dyn-valid="required" value="<?= get_datetime_user($row_entry['arriving_datetime']) ?>">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<input type="text" id="travel_from-<?= $count ?>" name="travel_from" placeholder="Travel From" title="Travel From" onchange="validate_city(this.id)" data-dyn-valid="required" value="<?= $row_entry['travel_from'] ?>">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<input type="text" id="travel_to-<?= $count ?>" onchange="validate_city(this.id)" name="travel_to" placeholder="Travel To" title="Travel To" data-dyn-valid="required" value="<?= $row_entry['travel_to'] ?>">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<input type="text" id="train_name-<?= $count ?>" style="text-transform: uppercase;"  name="train_name" placeholder="Train Name" title="Train Name" data-dyn-valid="" value="<?= $row_entry['train_name'] ?>">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<input type="text" id="train_no-<?= $count ?>" onchange="validate_balance(this.id)" name="train_no" placeholder="Train No" title="Train No" data-dyn-valid="" value="<?= $row_entry['train_no'] ?>">
						</div>				
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
							<select name="ticket_status" id="ticket_status-<?= $count ?>" title="Ticket Status" data-dyn-valid="">
								<?php	if($row_entry['ticket_status']!="") {?>
								<option  value="<?= $row_entry['ticket_status'] ?>"><?= $row_entry['ticket_status'] ?></option>
								<?php } ?>
								<option value="">Ticket Status</option>
								<option value="Confirm">Confirm</option>
								<option value="Waiting">Waiting</option>
								<option value="RAC">RAC</option>
								<option value="Open">Open</option>
							</select>
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<select name="class" id="class-<?= $count ?>" title="Class" data-dyn-valid="">
								<?php	if($row_entry['class']!="") {?>
								<option value="<?= $row_entry['class'] ?>"><?= $row_entry['class'] ?></option>
								<?php } ?>
								<option value="">Class</option>
								<?php get_train_class_dropdown(); ?>
							</select>
						</div>
						
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<input type="text" id="boarding_at-<?= $count ?>" name="boarding_at" title="Boarding Point" placeholder="Boarding Point" onchange="validate_address(this.id)" data-dyn-valid="" value="<?= $row_entry['boarding_at'] ?>">
						</div>
					</div>

				</div>
			<?php
		}
		?>
		
	

	</div>

	<div class="row text-center mg_tp_20">
		<div class="col-md-12">
			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;previous</button>
			&nbsp;&nbsp;
			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>

</form>

<script>
$('#arriving_datetime-1, #departure_datetime-1, #travel_datetime-1').datetimepicker({ format:'d-m-Y H:i:s' });
$('#frm_tab2').validate({
	rules:{
	},
	submitHandler:function(form){		

		 var status = dyn_validate('div_dynamic_ticket_info');
		 if(!status){ return false; }

		$('a[href="#tab3"]').tab('show');

	}
});
function switch_to_tab1(){ $('a[href="#tab1"]').tab('show'); }
</script>