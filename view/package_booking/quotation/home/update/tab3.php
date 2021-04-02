<?php 
$sq_package = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$package_id'"));
$package_name = $sq_package['package_name'];
?>
<form id="frm_tab3">

<div class="app_panel"> 


<!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
      <div class="container">
          <h2 class="pull-left"></h2>
          <div class="pull-right header_btn">
            <button>
                <a>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </button>
          </div>
      </div>
    </div> 
<!--=======Header panel end======-->

    <div class="container">


	<div class="row">
		<div class="col-md-12 app_accordion">
  			<div class="panel-group main_block" id="accordion" role="tablist" aria-multiselectable="true">

  			<!-- Train Information -->
				<div class="accordion_content main_block mg_bt_10">
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1" id="collapsed1">      
					        	<div class="col-md-12"><span>Train Information</span></div>
					        </div>
					    </div>
					    <div id="collapse1" class="panel-collapse collapse in main_block" role="tabpanel" aria-labelledby="heading1">
					        <div class="panel-body">
					        	<?php include_once('train_tbl.php'); ?>
					        </div>
					    </div>
					</div>
				</div>

  			<!-- Flight Information -->
				<div class="accordion_content main_block mg_bt_10">
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2" id="collapsed2">      
					        	<div class="col-md-12"><span>Flight Information</span></div>
					        </div>
					    </div>
					    <div id="collapse2" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading2">
					        <div class="panel-body">
					        	<?php include_once('plane_tbl.php'); ?>	
					        </div>
					    </div>
					</div>
				</div>

  			<!-- Cruise Information -->
				<div class="accordion_content main_block mg_bt_10">
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3" id="collapsed3">
					        	<div class="col-md-12"><span>Cruise Information</span></div>
					        </div>
					    </div>
					    <div id="collapse3" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading3">
					        <div class="panel-body">
					        	<?php include_once('cruise_tbl.php'); ?>
					        </div>
					    </div>
					</div>
				</div>

  			<!-- Hotel Information -->
				<div class="accordion_content main_block mg_bt_10">
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapse4" id="collapsed4">
					        	<div class="col-md-12"><span>Hotel Information</span></div>
					        </div>
					    </div>
					    <div id="collapse4" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading4">
					        <div class="panel-body">
					        	<?php include_once('hotel_tbl.php'); ?>
					        </div>
					    </div>
					</div>
				</div>

  			<!-- Transport Information -->
				<div class="accordion_content main_block mg_bt_10">
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="true" aria-controls="collapse5" id="collapsed5">      
					        	<div class="col-md-12"><span>Transport Information</span></div>
					        </div>
					    </div>
					    <div id="collapse5" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading5">
					        <div class="panel-body">
					        <div class="row">
							    <div class="col-xs-12 text-right mg_bt_20_sm_xs">
							        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_tour_quotation_dynamic_transport_u');destinationLoading('.pickup_from', 'Pickup Location');destinationLoading('.drop_to', 'Drop-off Location');"><i class="fa fa-plus"></i></button>
							    </div>
							</div>
				      <div class="row">

							    <div class="col-xs-12">

							        <div class="table-responsive">

							        <table id="tbl_package_tour_quotation_dynamic_transport_u" name="tbl_package_tour_quotation_dynamic_transport_u" class="table mg_bt_0 table-bordered mg_bt_10 pd_bt_51">

							        <?php
									$sq_transport_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id'"));

									if($sq_transport_count==0){
							        	?>
							        <tr>
										<td><input class="css-checkbox" id="chk_transport-" type="checkbox" onchange="get_transport_cost_update(this.id);" checked readonly><label class="css-label" for="chk_transport1" > </label></td>
										<td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
										<td><select id="transport_vehicle-"  name="transport_vehicle-" title="Select Transport" onchange="get_transport_cost_update(this.id);" class="form-control app_select2" style="width:200px"> 
												<option value="">Transport Vehicle</option>
												<?php
												$sq_query = mysql_query("select * from b2b_transfer_master where status != 'Inactive' order by vehicle_name asc"); 
												while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
													<option value="<?php echo $row_dest['entry_id']; ?>"><?php echo $row_dest['vehicle_name']; ?></option>
												<?php } ?>
											</select></td>
										<td><input type="text" id="transport_start_date-" name="transport_start_date-" placeholder="Start Date" title="Start Date" class="app_datepicker" style="width:150px" onchange="get_transport_cost_update(this.id);"></td>
										<td><select name="pickup_from-" id="pickup_from-" data-toggle="tooltip" style="width:250px;" title="Pickup Location" class="form-control app_select2 pickup_from" onchange="get_transport_cost_update(this.id);">
										</select></td>
										<td><select name="drop_to-" id="drop_to-" style="width:250px;" data-toggle="tooltip" title="Drop-off Location" class="form-control app_select2 drop_to" onchange="get_transport_cost_update(this.id);">
											</select></td>
										<td><input type="text" id="no_vehicles-" name="no_vehicles-" placeholder="No.Of vehicles" title="No.Of vehicles" style="width:150px" onchange="get_transport_cost_update(this.id);"></td> 
										<td><input type="text" id="transport_cost-" name="transport_cost-" placeholder="Cost" title="Cost" style="width:150"></td> 
										<td><input type="text" id="package_name-" name="package_name-" placeholder="Package Name" title="Package Name" style="width:200px" readonly></td> 
										<td><input type="text" id="package_id-" name="package_id-" placeholder="Package ID" title="Package ID" style="display:none;"></td> 
										<td><input type="hidden" id="pickup_type-" name="pickup_type-" style="display:none;"></td> 
										<td><input type="hidden" id="drop_type" name="drop_type" style="display:none;"></td> 
									</tr>
									<script type="text/javascript">
										$('#transport_vehicle1-,#pickup_from1-,#drop_to1-').select2();
										$('#transport_start_date1-').datetimepicker({ format:'d-m-Y',timepicker:false });	
									</script>
									<?php
									}
									else{
							        		$count = 0;
							        		$sq_q_tr = mysql_query("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id'");
							        		while($row_q_tr = mysql_fetch_assoc($sq_q_tr)){

							        			$count++;
												$sq_transport_bus_agency1 = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id='$row_q_tr[vehicle_name]'"));
												
												// Pickup
												if($row_q_tr['pickup_type'] == 'city'){
													$row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_q_tr[pickup]'"));
													$pickup = $row['city_name'];
													$plabel = 'City Name';
												}
												else if($row_q_tr['pickup_type'] == 'hotel'){
													$row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_q_tr[pickup]'"));
													$pickup = $row['hotel_name'];
													$plabel = 'Hotel Name';
												}
												else{
													$row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_q_tr[pickup]'"));
													$airport_nam = clean($row['airport_name']);
													$airport_code = clean($row['airport_code']);
													$pickup = $airport_nam." (".$airport_code.")";
													$plabel = 'Airport Name';
												}
												//Drop-off
												if($row_q_tr['drop_type'] == 'city'){
													$row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_q_tr[drop]'"));
													$drop = $row['city_name'];
													$dlabel = 'City Name';
												}
												else if($row_q_tr['drop_type'] == 'hotel'){
													$row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_q_tr[drop]'"));
													$drop = $row['hotel_name'];
													$dlabel = 'Hotel Name';
												}
												else{
													$row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_q_tr[drop]'"));
													$airport_nam = clean($row['airport_name']);
													$airport_code = clean($row['airport_code']);
													$drop = $airport_nam." (".$airport_code.")";
													$dlabel = 'Airport Name';
												}
							        			?>
							        		<tr>
							                <td><input class="css-checkbox" id="chk_transport-<?= $count ?>_u" name="chk_transport-<?= $count ?>_u" type="checkbox" onchange="get_transport_cost_update(this.id);" checked><label class="css-label" for="chk_transport<?= $count ?>_u" > </label></td>
							                <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
							                <td class="col-md-3"><select name="transport_vehicle-<?= $count ?>_u" id="transport_vehicle-<?= $count ?>_u" style="width:150px" class="app_select2 form-control" onchange="get_transport_cost_update(this.id)">
											    <option value="<?= $sq_transport_bus_agency1['entry_id'] ?>"><?= $sq_transport_bus_agency1['vehicle_name'] ?></option>
								                <option value="">Transport Vehicle</option>
								            	<?php
								                $sq_transport_bus_agency = mysql_query("select * from b2b_transfer_master where status!='Inactive' order by vehicle_name asc");
								                while($row_transport_bus_agency = mysql_fetch_assoc($sq_transport_bus_agency)){
								                    ?>
								                    <option value="<?= $row_transport_bus_agency['entry_id'] ?>"><?= $row_transport_bus_agency['vehicle_name'] ?></option>
								                    <?php
								                }
								                ?>
								            </select></td>
										    <td class="col-md-3"><input type="text" id="transport_start_date-<?= $count ?>_u" name="transport_start_date-<?= $count ?>_u" style="width:150px" placeholder="Start Date" title="Start Date" class="app_datepicker" onchange="get_transport_cost_update(this.id);" value="<?= date('d-m-Y', strtotime($row_q_tr['start_date'])) ?>"></td>
											<td><select name="pickup_from-<?= $count ?>_u" id="pickup_from-<?= $count ?>_u" data-toggle="tooltip" style="width:250px;" title="Pickup Location" class="form-control app_select2 pickup_from" onchange="get_transport_cost_update(this.id);">
												<optgroup value='<?=$row_q_tr['pickup_type']?>' label="<?=$plabel?>">
												<option value="<?= $row_q_tr['pickup_type'].'-'.$row_q_tr['pickup'] ?>"><?= $pickup ?></option>
											</select></td>
											<td><select name="drop_to-<?= $count ?>_u" id="drop_to-<?= $count ?>_u" style="width:250px;" data-toggle="tooltip" title="Drop-off Location" class="form-control app_select2 drop_to" onchange="get_transport_cost_update(this.id);">
												<optgroup value='<?=$row_q_tr['drop_type']?>' label="<?=$dlabel?>">
												<option value="<?= $row_q_tr['drop_type'].'-'.$row_q_tr['drop'] ?>"><?= $drop ?></option>
												</select></td>
											<td><input type="text" id="no_vehicles-<?= $count ?>_u" name="no_vehicles-<?= $count ?>_u" placeholder="No.Of vehicles" title="No.Of vehicles" style="width:150px" value="<?=$row_q_tr['vehicle_count']?>" onchange="get_transport_cost_update(this.id);"></td> 
											<td><input type="text" id="transport_cost-<?= $count ?>_u" name="transport_cost-<?= $count ?>_u" placeholder="Cost" title="Cost" style="width:170px" value="<?=$row_q_tr['transport_cost']?>"></td> 
											<td class="hidden"><input type="hidden" id="package_name-<?= $count ?>_u" name="package_name-<?= $count ?>_u" placeholder="Package Name" title="Package Name" style="display:none;" readonly></td> 
											<td class="hidden"><input type="text" id="package_id-<?= $count ?>_u" name="package_id-<?= $count ?>_u" placeholder="Package ID" title="Package ID" style="display:none;" value="<?=$row_q_tr['package_id']?>"></td> 
											<td class="hidden"><input type="hidden" id="pickup_type-<?= $count ?>_u" name="pickup_type-<?= $count ?>_u" style="display:none;" value="<?=$row_q_tr['pickup_type']?>"></td> 
											<td class="hidden"><input type="hidden" id="drop_type-<?= $count ?>_u" name="drop_type-<?= $count ?>_u" style="display:none;" value="<?=$row_q_tr['drop_type']?>"></td>
							                <td class="hidden"><input type="hidden" value="<?= $row_q_tr['id'] ?>" style="display:none;"></td>
							            </tr>
										<script type="text/javascript">
											$('#transport_vehicle-<?= $count ?>_u,#pickup_from-<?= $count ?>_u,#drop_to-<?= $count ?>_u').select2();
											$('#transport_start_date-<?= $count ?>_u').datetimepicker({ format:'d-m-Y',timepicker:false });	
										</script>

							            <?php
				        				}
				        			}
				        			?>
							        </table>
							        </div>
							    </div>
							</div> 
					        </div>
					    </div>
					</div>
				</div>
  				<!-- Activity Information -->
				<div class="accordion_content main_block mg_bt_10">
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="true" aria-controls="collapse6" id="collapsed6">      
					        	<div class="col-md-12"><span>Activity Information</span></div>
					        </div>
					    </div>
					    <div id="collapse6" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading1">
					        <div class="panel-body">
					        	<div class="row">
								    <div class="col-xs-12 text-right mg_bt_20_sm_xs">
								        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_tour_quotation_dynamic_excursion','2')"><i class="fa fa-plus"></i></button>
								    </div>
								</div>
								<div class="row">
								    <div class="col-xs-12">
								        <div class="table-responsive">
								        <table id="tbl_package_tour_quotation_dynamic_excursion" name="tbl_package_tour_quotation_dynamic_excursion" class="table mg_bt_0 table-bordered mg_bt_10 pd_bt_51">
								        <?php 
								        	$sq_ex_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id'"));
								        	if($sq_ex_count==0){
								        		?>
								            <tr>
								                <td><input class="css-checkbox" id="chk_tour_group-1" type="checkbox" onchange="get_excursion_amount_update(this.id);"><label class="css-label" for="chk_tour_group2"> <label></td>
								                <td style="width:10%"><input maxlength="15" value="1" type="text" name="username1" placeholder="Sr. No." class="form-control" disabled /></td>
    											<td><input type="text" id="exc_date-1" name="exc_date-1" placeholder="Activity Date & Time" title="Activity Date & Time" class="app_datepicker" value="<?= date('d-m-Y') ?>" style="width:110px" onchange="get_excursion_amount_update(this.id);"></td>
								                <td><select id="city_name-1" class="app_select2 form-control" name="city_name-1" title="City Name" style="width:100%" onchange="get_excursion_list(this.id);">
													<option value="">*City</option>
													<?php 
													$sq_city = mysql_query("select * from city_master order by city_name asc");
													while($row_city = mysql_fetch_assoc($sq_city)){
													?>
													<option value="<?php echo $row_city['city_id'] ?>"><?php echo $row_city['city_name'] ?></option>
													<?php } ?>
													</select></td>
												<td><select id="excursion-1" class="app_select2 form-control" title="Activity Name" name="excursion-1" style="width:100%" onchange="get_excursion_amount_update(this.id);">
									                <option value="">*Activity Name</option>
									            </select></td>
												<td><select name="transfer_option-1" id="transfer_option-1" data-toggle="tooltip" class="form-contrl app_select2" title="Transfer Option" style="width:150px" onchange="get_excursion_amount_update(this.id);">
													<option value="Private Transfer">Private Transfer</option>
													<option value="Without Transfer">Without Transfer</option>
													<option value="Sharing Transfer">Sharing Transfer</option>
													<option value="SIC">SIC</option>
													</select></td>
									            <td><input type="text" id="excursion_amount-1" name="excursion_amount-1" placeholder="Activity Amount" title="Activity Amount" style="width:100%" onchange="validate_balance(this.id);" ></td>
								            </tr>
								            <script>
								            $('#city_name-1').select2();
											$("#exc_date-1").datetimepicker({ format:'d-m-Y H:i' });
											</script>
								            <?php
								        	}
								        	else{
								        		$count = 0;
								        		$sq_q_ex = mysql_query("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id'");
								        		while($row_q_ex = mysql_fetch_assoc($sq_q_ex)){

								        			$count++;
								        			$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_q_ex[city_name]'"));
								        			$sq_ex = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$row_q_ex[excursion_name]'"));
								        			?>
								        		<tr>								                
								                <td><input class="css-checkbox" id="chk_tour_group-<?= $count ?>" type="checkbox" checked><label class="css-label" for="chk_tour_group2" onchange="get_excursion_amount_update(this.id);"> <label></td>
								                <td><input maxlength="15" value="<?= $count ?>" type="text" name="username1" placeholder="Sr. No." class="form-control" disabled /></td>
    											<td><input type="text" id="exc_date-<?= $count ?>_u" name="exc_date-<?= $count ?>_u" placeholder="Activity Date & Time" title="Activity Date & Time" class="app_datepicker" value="<?= get_datetime_user($row_q_ex['exc_date']) ?>" style="width:110px" onchange="get_excursion_amount_update(this.id);"></td>
								                <td class="col-md-4"><select id="city_name-<?= $count ?>_u" class="app_select2 form-control" name="city_name-<?= $count ?>_u" title="City Name" style="width:100%" onchange="get_excursion_list(this.id);">
													<option value="<?php echo $sq_city['city_id'] ?>"><?php echo $sq_city['city_name'] ?></option>
													<option value="">*City</option>
													<?php 
														$sq_city1 = mysql_query("select * from city_master order by city_name asc");
														while($row_city = mysql_fetch_assoc($sq_city1))
														{
															?>
															<option value="<?php echo $row_city['city_id'] ?>"><?php echo $row_city['city_name'] ?></option>
															<?php } ?>
										            </select>
								                </td>
								                <td class="col-md-4"><select id="excursion-<?= $count ?>_u" class="app_select2 form-control" title="Activity Name" name="excursion-<?= $count ?>_u" style="width:100%" onchange="get_excursion_amount_update(this.id);">
									                <option value="<?php echo $sq_ex['entry_id'] ?>"><?php echo $sq_ex['excursion_name'] ?></option>
									                <option value="">*Activity Name</option>
									            </select></td>
												<td class="col-md-4"><select name="transfer_option-<?= $count ?>_u" id="transfer_option-<?= $count ?>_u" data-toggle="tooltip" class="form-contrl app_select2" title="Transfer Option" onchange="get_excursion_amount_update(this.id);">
													<option value="<?php echo $row_q_ex['transfer_option'] ?>"><?php echo $row_q_ex['transfer_option'] ?></option>
													<option value="Private Transfer">Private Transfer</option>
													<option value="Without Transfer">Without Transfer</option>
													<option value="Sharing Transfer">Sharing Transfer</option>
													<option value="SIC">SIC</option>
													</select></td>
											  	<td><input type="text" id="excursion_amount-<?= $count ?>_u" name="excursion_amount-<?= $count ?>_u"  onchange="validate_balance(this.id)" placeholder="Activity Amount" title="Activity Amount" style="width:150px" value="<?php echo $row_q_ex['excursion_amount'] ?>"></td>
											    <td class="hidden"><input type="hidden" value="<?= $row_q_ex['id'] ?>"></td>
								            </tr>
								            <script>
											$('#city_name-<?= $count ?>_u').select2();
											$('#exc_date-<?= $count ?>_u').datetimepicker({ format:"d-m-Y H:i:s" });
											</script>
								            <?php

					        				}

					        			  }

					        			?>	                               
								        </table>
								        </div>
								    </div>
								</div>
					        </div>
					    </div>
					</div>
				</div>

  			</div>
  		</div>
  	</div>	


	<div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>



</form>

<?= end_panel(); ?>


<script>
destinationLoading(".pickup_from", 'Pickup Location');
destinationLoading(".drop_to", 'Drop-off Location');	
city_lzloading('.city_name');
// App_accordion
jQuery(document).ready(function() {			
	jQuery(".panel-heading").click(function(){ 
		jQuery('#accordion .panel-heading').not(this).removeClass('isOpen');
		jQuery(this).toggleClass('isOpen');
		jQuery(this).next(".panel-collapse").addClass('thePanel');
		jQuery('#accordion .panel-collapse').not('.thePanel').slideUp("slow"); 
		jQuery(".thePanel").slideToggle("slow").removeClass('thePanel'); 
	});
	
});

//Get Hotel Cost
function get_hotel_cost(hotel_id1){

	var hotel_id_arr = new Array();
	var room_cat_arr = new Array();
	var check_in_arr = new Array();
	var check_out_arr = new Array();
	var total_nights_arr = new Array();
	var total_rooms_arr = new Array();
	var extra_bed_arr = new Array();
	var package_id_arr = [];
	var child_with_bed = $('#children_with_bed').val(); 
	var child_without_bed = $('#children_without_bed').val(); 
	var adult_count = $('#total_adult').val(); 

	var table = document.getElementById("tbl_package_tour_quotation_dynamic_hotel_update");
	var rowCount = table.rows.length;

	for(var i=0; i<rowCount; i++){

		var row = table.rows[i];
		if(row.cells[0].childNodes[0].checked){

			var hotel_id = row.cells[3].childNodes[0].value;
			var room_category = row.cells[4].childNodes[0].value;
			var check_in = row.cells[5].childNodes[0].value;
			var check_out = row.cells[6].childNodes[0].value;
			var total_nights = row.cells[8].childNodes[0].value;
			var total_rooms = row.cells[9].childNodes[0].value;
			var extra_bed = row.cells[10].childNodes[0].value;
			var package_id = row.cells[13].childNodes[0].value;

			hotel_id_arr.push(hotel_id);
			room_cat_arr.push(room_category);
			check_in_arr.push(check_in);
			check_out_arr.push(check_out);
			total_nights_arr.push(total_nights);
			total_rooms_arr.push(total_rooms);
			extra_bed_arr.push(extra_bed);
			package_id_arr.push(package_id);

		}
	}
	var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: base_url+'view/package_booking/quotation/home/hotel/get_hotel_cost.php',
		data:{ hotel_id_arr : hotel_id_arr,check_in_arr : check_in_arr,check_out_arr:check_out_arr,room_cat_arr:room_cat_arr,total_nights_arr:total_nights_arr,total_rooms_arr:total_rooms_arr,extra_bed_arr:extra_bed_arr,child_with_bed:child_with_bed,child_without_bed:child_without_bed,adult_count:adult_count,package_id_arr:package_id_arr },
		success:function(result){

			var hotel_arr = JSON.parse(result);
			for(var i=0; i<hotel_arr.length; i++){
				var row = table.rows[i];
				row.cells[12].childNodes[0].value = hotel_arr[i]['hotel_cost'];
			}
			//Tab-4 Per person costing
			$('#hotel_pp_costing').val(result);
		}
	});
}			

//Get Transport Cost
function get_transport_cost_update(id){

	var trans_id = id.split('-');
	var transport_id_arr = new Array();
	var travel_date_arr = new Array();
	var pickup_arr = new Array();
	var drop_arr = new Array();
	var pickup_id_arr = new Array();
	var drop_id_arr = new Array();
	var vehicle_count_arr = new Array();
	var ppackage_id_arr = new Array();
	var ppackage_name_arr = new Array();
	
	var transport_id = $('#transport_vehicle-'+trans_id[1]).val();
	var travel_date = $('#transport_start_date-'+trans_id[1]).val();
	var pickup = $('#pickup_from-'+trans_id[1]).val(); 
	var drop = $('#drop_to-'+trans_id[1]).val();
	var pickup1 = pickup.split('-')[1];
	var drop1 = drop.split('-')[1]; 
	var vehicle_count = $('#no_vehicles-'+trans_id[1]).val(); 
	var pname = $('#package_name-'+trans_id[1]).val(); 
	var pid = $('#package_id-'+trans_id[1]).val(); 
	var pickup_type = pickup.split('-')[0];
	var drop_type = drop.split('-')[0];

	transport_id_arr.push(transport_id);
	travel_date_arr.push(travel_date);
	pickup_arr.push(pickup1);
	drop_arr.push(drop1);
	pickup_id_arr.push(pickup_type);
	drop_id_arr.push(drop_type);
	vehicle_count_arr.push(vehicle_count);
	ppackage_id_arr.push(pid);
	ppackage_name_arr.push(pname);
	$.ajax({
		type:'post',
		url: '../hotel/get_transport_cost.php',
		data:{ transport_id_arr : transport_id_arr,travel_date_arr:travel_date_arr,pickup_arr:pickup_arr,drop_arr:drop_arr,vehicle_count_arr:vehicle_count_arr ,pickup_id_arr:pickup_id_arr,drop_id_arr:drop_id_arr,ppackage_id_arr:ppackage_id_arr,ppackage_name_arr:ppackage_name_arr},
		success:function(result){
			
			var transport_arr = JSON.parse(result);
			if(document.getElementById("chk_transport-"+trans_id[1]).checked == true){
				$('#transport_cost-'+trans_id[1]).val(transport_arr[0]['total_cost']);
			}
			else{
				$('#transport_cost-'+trans_id[1]).val(0);
			}
		}
	});
}
$(function(){

	$('#frm_tab3').validate({

		rules:{

				

	},

	submitHandler:function(form){


		//Train Info
		var table = document.getElementById("tbl_package_tour_quotation_dynamic_train");

		var rowCount = table.rows.length;

			

			for(var i=0; i<rowCount; i++)

			{

			var row = table.rows[i];

				

			if(row.cells[0].childNodes[0].checked)

			{

				var train_from_location1 = row.cells[2].childNodes[0].value;         

				var train_to_location1 = row.cells[3].childNodes[0].value;   

				var train_class = row.cells[4].childNodes[0].value;         

				var train_arrival_date = row.cells[5].childNodes[0].value;         

				var train_departure_date = row.cells[6].childNodes[0].value;         	



				if(row.cells[7] && row.cells[7].childNodes[0]){

				var train_id = row.cells[7].childNodes[0].value;

				}

				else{

				var train_id = "";

				}      	

				if(train_from_location1=="")

				{

					error_msg_alert('Enter train from location in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_train').parent('div').closest('.accordion_content').addClass("indicator");

					return false;

				}	



				if(train_to_location1=="")

				{

					error_msg_alert('Enter train to location in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_train').parent('div').closest('.accordion_content').addClass("indicator");

					return false;

				}

				

			}      

			}


		// Flight Info  
		var table = document.getElementById("tbl_package_tour_quotation_dynamic_plane");
		var rowCount = table.rows.length;
		
		for(var i=0; i<rowCount; i++)
		{
		var row = table.rows[i];
		if(row.cells[0].childNodes[0].checked)
		{
			var plane_from_city = row.cells[2].childNodes[0].value;         
			var plane_from_location1 = row.cells[3].childNodes[0].value;	
			var plane_to_city = row.cells[4].childNodes[0].value;         
			var plane_to_location1 = row.cells[5].childNodes[0].value;
			var airline_name = row.cells[6].childNodes[0].value;  
			var plane_class = row.cells[7].childNodes[0].value;  
			var dapart1 = row.cells[8].childNodes[0].value;       
			var arraval1 = row.cells[9].childNodes[0].value;

			if(row.cells[10] && row.cells[10].childNodes[0]){
			var plane_id = row.cells[10].childNodes[0].value;
			}
			else{
			var plane_id = "";
			}    

			if(plane_from_location1=="")
			{
				error_msg_alert('Enter flight from location in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

			if(plane_to_location1=="")
			{
				error_msg_alert('Enter flight to location in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			} 

			if(dapart1=="")
			{ 
				error_msg_alert("Departure Datetime is required in row:"+(i+1)); 
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
			}		       

			if(arraval1=="")
			{ 
				error_msg_alert('Arrival Datetime is required in row:'+(i+1)); 
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
			}
		}      

		}


	//Cruise Information
	var cruise_departure_date_arr = new Array();
	var cruise_arrival_date_arr = new Array();
	var route_arr = new Array();
	var cabin_arr = new Array();
	var sharing_arr = new Array();
	var c_entry_id_arr = new Array();

	var table = document.getElementById("tbl_dynamic_cruise_quotation");
	var rowCount = table.rows.length;

		for(var i=0; i<rowCount; i++)
		{
		var row = table.rows[i];	 
		if(row.cells[0].childNodes[0].checked)
		{
			var cruise_from_date = row.cells[2].childNodes[0].value;    
			var cruise_to_date = row.cells[3].childNodes[0].value;    
			var route = row.cells[4].childNodes[0].value;    
			var cabin = row.cells[5].childNodes[0].value;  
			var sharing = row.cells[6].childNodes[0].value;   
			
			
			if(row.cells[7] && row.cells[7].childNodes[0]){
			var c_entry_id = row.cells[7].childNodes[0].value;
			}
			else{
			var c_entry_id = "";
			} 

			if(cruise_from_date=="")
			{
				error_msg_alert('Enter Cruise Departure datetime in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
				$('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

			if(cruise_to_date=="")
			{
				error_msg_alert('Enter Cruise Arrival datetime  in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
				$('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}
			if(route=="")
			{
				error_msg_alert('Enter route in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
				$('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}
			if(cabin=="")
			{
				error_msg_alert('Enter Cabin in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
				$('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			} 	 
			cruise_departure_date_arr.push(cruise_from_date);
			cruise_arrival_date_arr.push(cruise_to_date);
			route_arr.push(route);
			cabin_arr.push(cabin);
			sharing_arr.push(sharing);
			c_entry_id_arr.push(c_entry_id);

		}      
		}
		
	//Hotel Information
	var package_id_arr = new Array();
	var table = document.getElementById("tbl_package_tour_quotation_dynamic_hotel_update");
	var rowCount = table.rows.length;

	for(var i=0; i<rowCount; i++){

		var row = table.rows[i];
		if(row.cells[0].childNodes[0].checked){
			
			var city_name = row.cells[2].childNodes[0].value;
			var hotel_id = row.cells[3].childNodes[0].value;  
			var hotel_cat = row.cells[4].childNodes[0].value;
			var check_in = row.cells[5].childNodes[0].value;  
			var checkout = row.cells[6].childNodes[0].value;        
			var hotel_stay_days1 = row.cells[8].childNodes[0].value;
			var total_rooms = row.cells[9].childNodes[0].value;
			var package_name1 = row.cells[11].childNodes[0].value;
			var hotel_cost = row.cells[12].childNodes[0].value;
			var package_id1 = row.cells[13].childNodes[0].value;

			if(city_name==""){
				error_msg_alert('Select hotel city in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_hotel_update').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

			if(hotel_id==""){
				error_msg_alert('Enter hotel in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_hotel_update').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}
			if(hotel_cat==""){
				error_msg_alert('Enter Room Category in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_hotel_update').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}
			if(check_in==""){
				error_msg_alert('Select Check-In date in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_hotel_update').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

			if(checkout==""){
				error_msg_alert('Select Check-Out date in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_hotel_update').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

			if(hotel_stay_days1==""){
				error_msg_alert('Enter hotel total days in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_hotel_update').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

			package_id_arr.push(package_id1);
		}

	}

	//Transport Information 
	var package_id_arr1 = new Array();
	var table = document.getElementById("tbl_package_tour_quotation_dynamic_transport_u");

	var rowCount = table.rows.length;
	for(var i=0; i<rowCount; i++){
		
		var row = table.rows[i];
		if(row.cells[0].childNodes[0].checked){
			
			var transport_id = row.cells[2].childNodes[0].value;
			var travel_date = row.cells[3].childNodes[0].value;
			var vehicle_count = row.cells[6].childNodes[0].value;
			var pname = row.cells[8].childNodes[0].value;
			var package_id1 = row.cells[9].childNodes[0].value;
			var pickup = row.cells[4].childNodes[0].value;
			var drop = row.cells[5].childNodes[0].value;
			
			if(transport_id==""){
				error_msg_alert('Select Transport Vehicle in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_transport').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

			if(travel_date==""){
				error_msg_alert('Enter Travel date in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_transport').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

			if(pickup==""){
				error_msg_alert('Select pickup location in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_transport').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}
			if(drop==""){
				error_msg_alert('Select drop location in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_transport').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}
			package_id_arr1.push(package_id1);

		}
	}


	var table = document.getElementById("tbl_package_tour_quotation_dynamic_excursion");
	var rowCount = table.rows.length;
	var total_amount = 0;
	for(var e=0; e<rowCount; e++)
	{
		var row = table.rows[e];
		if(row.cells[0].childNodes[0].checked)
		{		
			var exc_date = row.cells[2].childNodes[0].value; 
			var city_name = row.cells[3].childNodes[0].value;
			var excursion_name = row.cells[4].childNodes[0].value;
			var transfer_option = row.cells[5].childNodes[0].value;
			
			if(exc_date=="") {
				error_msg_alert('Select Activity date in row'+(e+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_excursion').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			} 
			if(city_name=="") {
				error_msg_alert('Select Activity city in row'+(e+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_excursion').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}
			if(excursion_name=="") {
				error_msg_alert('Select Activity name in row'+(e+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_excursion').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			} 	
			if(transfer_option=="") {
				error_msg_alert('Select Transfer option in row'+(e+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_excursion').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			} 		

			var e_amount = row.cells[4].childNodes[0].value;	
			total_amount = parseFloat(total_amount) + parseFloat(e_amount);	    			    	
		}		   
	}

quotation_cost_calculate1('abc');

	$('.accordion_content').removeClass("indicator");
			$('#tab3_head').addClass('done');
		$('#tab4_head').addClass('active');
		$('.bk_tab').removeClass('active');
		$('#tab4').addClass('active');
		$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
	}
	});
});

function switch_to_tab2(){
	$('#tab3_head').removeClass('active');
	$('#tab_daywise_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab_daywise').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200); }

</script>



