<div class="panel panel-default panel-body fieldset profile_background">
	<div class="tab-content">
	    <div role="tabpanel" class="tab-pane active" id="basic_information">
	     	<div class="row">
				<div class="col-md-12">
					<div class="profile_box main_block">
						<div class="table-responsive">
							<table class="table table-bordered no-marg">
							<thead>
								<tr class="table-heading-row">
									<th>S_No.</th>
									<th>Pickup_Location</th>
									<th>Drop-off_location</th>
									<th>Service_duration</th>
									<th>Valid_From_date</th>
									<th>Valid_To_date</th>
									<th>Luggage_capacity</th>
									<th>Total_cost</th>
									<th>Markup_In</th>
									<th>Markup_Cost</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$count=1;
							while($row_query = mysql_fetch_assoc($sq_query)){
								$tariff_data = json_decode($row_query['tariff_data']);
								// Pickup
								if($row_query['pickup_type'] == 'city'){
									$row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_query[pickup_location]'"));
									$pickup = $row['city_name'];
								}
								else if($row_query['pickup_type'] == 'hotel'){
									$row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_query[pickup_location]'"));
									$pickup = $row['hotel_name'];
								}
								else{
									$row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_query[pickup_location]'"));
									$airport_nam = clean($row['airport_name']);
									$airport_code = clean($row['airport_code']);
									$pickup = $airport_nam." (".$airport_code.")";
								}
								//Drop-off
								if($row_query['drop_type'] == 'city'){
									$row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_query[drop_location]'"));
									$drop = $row['city_name'];
								}
								else if($row_query['drop_type'] == 'hotel'){
									$row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_query[drop_location]'"));
									$drop = $row['hotel_name'];
								}
								else{
									$row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_query[drop_location]'"));
									$airport_nam = clean($row['airport_name']);
									$airport_code = clean($row['airport_code']);
									$drop = $airport_nam." (".$airport_code.")";
								}
							?>
								<tr>
								<td><?= $count++ ?></td>
								<td><?= $pickup ?></td>
								<td><?= $drop ?></td>
								<td><?= $row_query['service_duration'] ?></td>
								<td><?= get_date_user($row_query['from_date']) ?></td>
								<td><?= get_date_user($row_query['to_date']) ?></td>
								<td><?= ($tariff_data[0]->seating_capacity) ?></td>
								<td><?= number_format($tariff_data[0]->total_cost,2) ?></td>
								<td><?= $tariff_data[0]->markup_in ?></td>
								<td><?= number_format($tariff_data[0]->markup_amount,2) ?></td>
								</tr>
							<?php } ?>
							</tbody>
							</table>
						</div>
					</div>
        		</div>
        	</div>
        </div>
	</div>
</div>
