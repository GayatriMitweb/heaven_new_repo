<div class="row">    
  	<div class="col-xs-12">
           	<h3 class="editor_title">Trip Details</h3>
           	<?php  	$query = "select * from ticket_master where 1 ";
           	$query .=" and ticket_id='$ticket_id'";
           	$tickect_query="select * from ticket_trip_entries where 1 and ticket_id='$ticket_id' ";
           	?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered no-marg" id="tbl_ticket_report">
					<thead>
						<tr class="table-heading-row">
							<th>S_No</th>
							<th>Departure_Date&Time&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th>Arrival_Date&Time&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th>Airline</th>
							<th>Class</th>
							<th>Flight_No.</th>
							<th>Airline_PNR</th>
							<th>From_City</th>
							<th>Sector_From</th>
							<th>To_City</th>
							<th>Sector_To</th>
							<th>Meal_Plan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th>Luggage&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th>Special_Note</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$count = 0;
						$sq_ticket = mysql_query($query);
						$sq_ticket1 = mysql_query($tickect_query);
						while($row_ticket =mysql_fetch_assoc($sq_ticket)){

							$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));

							$sq_entry = mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'");
							
							while($row_entry = mysql_fetch_assoc($sq_entry)){
				               while($row_entry1 = mysql_fetch_assoc($sq_ticket1)) {
				                 $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_entry1[from_city]'"));
		                        $sq_city1 = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_entry1[to_city]'"));  
								$bg = ($row_entry['status']=='Cancel') ? 'danger' : '';
								?>
								<tr class="<?= $bg ?>">
									<td><?= ++$count ?></td>
									<td><?php echo get_datetime_user($row_entry1['departure_datetime']); ?> </td>
									<td><?php echo get_datetime_user($row_entry1['arrival_datetime']); ?></td>
									<td><?php echo $row_entry1['airlines_name']; ?></td>
									<td><?php echo $row_entry1['class']; ?></td>
									<td><?php echo $row_entry1['flight_no']; ?></td>
									<td style="text-transform: uppercase;"><?php echo $row_entry1['airlin_pnr']; ?></td>
									<td><?php echo $sq_city['city_name']; ?></td>
									<td><?php echo $row_entry1['departure_city']; ?></td>
									<td><?php echo $sq_city1['city_name']; ?></td>
									<td><?php echo $row_entry1['arrival_city']; ?></td>
									<td><?php echo $row_entry1['meal_plan']; ?></td>
									<td><?php echo $row_entry1['luggage']; ?></td>
									<td><?php echo $row_entry1['special_note']; ?></td>
								</tr>
								<?php
							}

						}
					}
						?>
					</tbody>
				</table>
            </div>
    </div>
</div> 