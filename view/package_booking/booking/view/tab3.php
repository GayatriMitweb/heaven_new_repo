<?php
$sq_c_hotel = mysql_num_rows(mysql_query("select * from package_hotel_accomodation_master where booking_id='$booking_id'"));
if($sq_c_hotel != '0'){
?>
<div class="row mg_bt_20">
	<div class="col-xs-12">
		<div class="profile_box main_block">
			<h3 class="editor_title">Accommodation Details</h3>
			<div class="table-responsive">
				<table class="table table-bordered no-marg">
					<thead>
						<tr class="table-heading-row">
							<th>City</th>
							<th>Hotel_Name</th>
							<th>Check_In_DateTime</th>
							<th>Check_Out_DateTime</th>
							<th>Room</th>
							<th>Category</th>
							<th>Meal_Plan</th>
							<th>Room_Type</th>
							<th>Confirmation_No</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$count = 0;
						$sq_entry = mysql_query("select * from package_hotel_accomodation_master where booking_id='$booking_id'");
						while($row_entry = mysql_fetch_assoc($sq_entry)){
							
							$city_id = $row_entry['city_id'];
							$hotel_id = $row_entry['hotel_id'];

							$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$city_id'"));
							$sq_hotel_name = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$hotel_id'"));
							$count++;
						?>
						<tr class="<?php echo $bg; ?>">
							<td><?php echo $sq_city['city_name'] ?></td>
							<td><?php echo $sq_hotel_name['hotel_name'].$similar_text; ?></td>
							<td><?php echo get_datetime_user($row_entry['from_date']); ?></td>
							<td><?php echo get_datetime_user($row_entry['to_date']) ?></td>
							<td><?php echo $row_entry['rooms']; ?> </td>
							<td><?php echo $row_entry['catagory']; ?> </td>
							<td><?php echo $row_entry['meal_plan']; ?></td>
							<td><?php echo $row_entry['room_type']; ?></td>
							<td><?php echo $row_entry['confirmation_no']; ?></td>
						</tr>  
						<script>
							$("#birth_date<?= $offset.$count ?>_d, #expiry_date<?= $offset ?>1").datetimepicker({ timepicker:false, format:'d-m-Y' });
						</script>      
						<?php } ?>
				</tbody>
			</table>
			</div>
		</div> 
	</div>
</div>
<?php } ?>

<?php 
$sq_c_package = mysql_fetch_assoc(mysql_query("select * from package_tour_transport_master where booking_id='$booking_id'"));
if($sq_c_package['transport_bus_id'] !=''){
?>
<div class="row mg_bt_20">
	<div class="col-md-12">
		<div class="profile_box main_block">
			<h3 class="editor_title">Transport Details</h3>
			<div class="table-responsive">
				<table class="table table-bordered no-marg">
					<thead>
						<tr class="table-heading-row">
							<th>Vehicle_name</th>
							<th>From_Date</th>
							<th>Pickup_Location</th>
							<th>Drop_Location</th>
							<th>Total_Vehciles</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$sq_entry = mysql_query("select * from package_tour_transport_master where booking_id='$booking_id'");
						while($row_entry = mysql_fetch_assoc($sq_entry)){

							$q_transport = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id='$row_entry[transport_bus_id]'"));
                            // Pickup
                            if($row_entry['pickup_type'] == 'city'){
                                $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_entry[pickup]'"));
                                $pickup = $row['city_name'];
                            }
                            else if($row_entry['pickup_type'] == 'hotel'){
                                $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_entry[pickup]'"));
                                $pickup = $row['hotel_name'];
                            }
                            else{
                                $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_entry[pickup]'"));
                                $airport_nam = clean($row['airport_name']);
                                $airport_code = clean($row['airport_code']);
                                $pickup = $airport_nam." (".$airport_code.")";
                            }
                            //Drop-off
                            if($row_entry['drop_type'] == 'city'){
                                $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_entry[drop]'"));
                                $drop = $row['city_name'];
                            }
                            else if($row_entry['drop_type'] == 'hotel'){
                                $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_entry[drop]'"));
                                $drop = $row['hotel_name'];
                            }
                            else{
                                $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_entry[drop]'"));
                                $airport_nam = clean($row['airport_name']);
                                $airport_code = clean($row['airport_code']);
                                $drop = $airport_nam." (".$airport_code.")";
                            }
							?>
							<tr>
								<td><?= $q_transport['vehicle_name'].$similar_text ?></td>
								<td><?= get_date_user($row_entry['transport_from_date']) ?></td>
								<td><?= $pickup ?></td>
								<td><?= $drop ?></td>
								<td><?= $row_entry['vehicle_count'] ?></td>
							</tr>
					<?php } ?>
					</tbody>
				</table>
            </div>
	    </div> 
	</div>
</div>
<?php } ?>

<?php
$sq_c_package = mysql_fetch_assoc(mysql_query("select * from package_tour_excursion_master where booking_id='$booking_id'"));
if($sq_c_package['city_id'] !=''){
?>
<div class="row mg_bt_20">
	<div class="col-md-12">
		<div class="profile_box main_block">
			<h3 class="editor_title">Activity Details</h3>
			<div class="table-responsive">
				<table class="table table-bordered no-marg">
					<thead>
						<tr class="table-heading-row">
							<th>Activity_date</th>
							<th>City_Name</th>
							<th>Activity_name</th>
							<th>Transfer_option</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$sq_entry = mysql_query("select * from package_tour_excursion_master where booking_id='$booking_id'");
					while($row_entry = mysql_fetch_assoc($sq_entry)){
						$q_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_entry[city_id]'"));
						$sq_ex = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$row_entry[exc_id]'"));
						?>
						<tr>
							<td><?php echo get_datetime_user($row_entry['exc_date']) ?></td>
							<td><?= $q_city['city_name'] ?></td>
							<td><?= $sq_ex['excursion_name'] ?></td>
							<td><?= $row_entry['transfer_option'] ?> </td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
	    </div> 
	</div>
</div>
<?php } ?>