<div class="panel panel-default panel-body fieldset profile_background no-pad-sm">
		<div class="row mg_tp_20">

		<div class="col-xs-12">
			<h3 class="editor_title">Package Information</h3>
			<div class="panel panel-default panel-body app_panel_style">

					<div class="profile_box main_block">

			        		<?php
			        			$sq_dest = mysql_fetch_assoc(mysql_query("select * from destination_master where dest_id='$sq_pckg[dest_id]'"));
			        		?>

			        		<div class="row">
			        			<div class="col-md-6 right_border_none_sm">
				        			<span class="main_block">
			    						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i> 
			    				    <?php echo '<label>Destination  <em>:</em></label> '.$sq_dest['dest_name']; ?>
				    				</span>
				    			</div>
				    		</div>
				    		<div class="row">
			        			<div class="col-md-6 right_border_none_sm" style="border-right: 1px solid #ddd;">
				        	 		<span class="main_block">
				        	 			<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						                  <?php echo '<label>Tour Type  <em>:</em></label>'.$sq_pckg['tour_type'] ?>
						            </span>
				        	 		<span class="main_block">
				        	 			<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						                  <?php echo '<label>Package Name  <em>:</em></label>'.$sq_pckg['package_name'] ?>
						            </span>

				    				<span class="main_block">
				    					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
				    				    <?php echo '<label>Package Code  <em>:</em></label>'.$sq_pckg['package_code']; ?> 
				    				</span>
				        			<span class="main_block">
										<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
									    <?php echo '<label>Total Days  <em>:</em></label>'.$sq_pckg['total_days']; ?>
									</span>

									<span class="main_block">
										<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
									    <?php echo '<label>Total Nights  <em>:</em></label>'.$sq_pckg['total_nights']; ?>
									</span>
				        		</div>
			        			<div class="col-md-6 col-sm-12 col-xs-12">
				        			<span class="main_block">
												<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
													<?php echo '<label>Adult Cost  <em>:</em></label>'.$sq_pckg['adult_cost']; ?>
											</span>
											<span class="main_block">
												<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
													<?php echo '<label>Child Cost  <em>:</em></label>'.$sq_pckg['child_cost']; ?>
											</span>
				        			<span class="main_block">
												<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
													<?php echo '<label>Infant Cost  <em>:</em></label>'.$sq_pckg['infant_cost']; ?>
											</span>
											<span class="main_block">
												<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
													<?php echo '<label>Child with Bed Cost  <em>:</em></label>'.$sq_pckg['child_with']; ?>
											</span>
				        			<span class="main_block">
												<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
													<?php echo '<label>Child w/o Bed Cost  <em>:</em></label>'.$sq_pckg['child_without']; ?>
											</span>
											<span class="main_block">
												<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
													<?php echo '<label>Extra Bed Cost  <em>:</em></label>'.$sq_pckg['extra_bed']; ?>
											</span>

				        		</div>
			        		</div>

		        	</div> 
			</div>
	</div>

		<div class="col-xs-12 mg_tp_10">

       	 	<h3 class="editor_title">Itinerary Information</h3>

                <div class="table-responsive">

                	<table id="tbl_dynamic_bus_booking" name="tbl_dynamic_bus_booking" class="table no-marg table-bordered">
	                	<tr class="table-heading-row">
							<th>S_No.</th>
							<th>Attraction</th>
							<th>Day_Wise_Program</th>
							<th>Overnight_Stay</th>
							<th>Meal_Plan</th>
						</tr>

						<?php
						$count = 0;
						$query = "select * from custom_package_program where package_id = '$package_id'";
						$sq_pckg_a = mysql_query($query);
						while($sq_pckg1 = mysql_fetch_assoc($sq_pckg_a)){

							$count++;
						?>
						<tr>
							<td><?=  $count ?></td>
							<td><?php echo $sq_pckg1['attraction']; ?></td>
							<td><pre class="real_text"><?php echo $sq_pckg1['day_wise_program']; ?></pre></td>
							<td><?php echo $sq_pckg1['stay']; ?></td>
							<td><?php echo $sq_pckg1['meal_plan']; ?></td>
						</tr>
						<?php  }  ?>
					</table>
				</div>
			</div>
		
		<?php 
		$sq_hotel_count = mysql_num_rows(mysql_query("select * from custom_package_hotels where package_id = '$package_id'"));	
		if($sq_hotel_count != '0'){
		?>
	    <div class="col-md-12 mg_tp_30">

       	 	<h3 class="editor_title">Hotel Information</h3>

            <div class="table-responsive">

            	<table id="tbl_dynamic_bus_booking" name="tbl_dynamic_bus_booking" class="table no-marg table-bordered">

                	<tr class="table-heading-row">

						<th>S_No.</th>

						<th>City_Name</th>

						<th>Hotel_Name</th>

						<th>Hotel_Type</th>

						<th>Total_Night</th>

					</tr>

				<?php

				$count_hotel =0; 

				$sq_pckg_hotel = mysql_query("select * from custom_package_hotels where package_id = '$package_id'");	        

					while($row_hotel = mysql_fetch_assoc($sq_pckg_hotel)){

					$sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id = '$row_hotel[hotel_name]'"));		

					$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id = '$row_hotel[city_name]'"));		

					$count_hotel++;

					?>

						<tr>

							<td><?= $count_hotel ?></td>

							<td><?php echo ucfirst($sq_city['city_name']); ?></td>

							<td><?php echo ucfirst($sq_hotel['hotel_name']); ?></td>

							<td><?php echo $row_hotel['hotel_type']; ?></td>

							<td><?php echo $row_hotel['total_days']; ?></td>

						</tr> 

						<?php } ?>

                </table>

            </div>

	    </div>
	<?php } ?>
		<?php 
		$sq_hotel_count = mysql_num_rows(mysql_query("select * from custom_package_transport where package_id = '$package_id'"));	
		if($sq_hotel_count != '0'){
		?>
	    <div class="col-md-12 mg_tp_30">
       	 	<h3 class="editor_title">Transport Information</h3>
            <div class="table-responsive">

            	<table id="tbl_dynamic_bus_booking" name="tbl_dynamic_bus_booking" class="table no-marg table-bordered">
					<tr class="table-heading-row">
						<th>S_No.</th>
						<th>Vehicle_Name</th>
						<th>Pickup</th>
						<th>Drop</th>
					</tr>
					<?php
					$count_hotel =0;
					$sq_pckg_hotel = mysql_query("select * from custom_package_transport where package_id = '$package_id'");	        
						while($row_hotel = mysql_fetch_assoc($sq_pckg_hotel)){

						$sq_transport = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id = '$row_hotel[vehicle_name]'"));
						$count_hotel++;

						// Pickup
						if($row_hotel['pickup_type'] == 'city'){
							$row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_hotel[pickup]'"));
							$pickup = $row['city_name'];
						}
						else if($row_hotel['pickup_type'] == 'hotel'){
							$row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[pickup]'"));
							$pickup = $row['hotel_name'];
						}
						else{
							$row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[pickup]'"));
							$airport_nam = clean($row['airport_name']);
							$airport_code = clean($row['airport_code']);
							$pickup = $airport_nam." (".$airport_code.")";
							$html = '<optgroup value="airport" label="Airport Name"><option value="'.$row['airport_id'].'">'.$pickup.'</option></optgroup>';
						}
						// Drop
						if($row_hotel['drop_type'] == 'city'){
							$row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_hotel[drop]'"));
							$drop = $row['city_name'];
						}
						else if($row_hotel['pickup_type'] == 'hotel'){
							$row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[drop]'"));
							$drop = $row['hotel_name'];
						}
						else{
							$row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[drop]'"));
							$airport_nam = clean($row['airport_name']);
							$airport_code = clean($row['airport_code']);
							$drop = $airport_nam." (".$airport_code.")";
						}
						?>
						<tr>
							<td><?= $count_hotel ?></td>
							<td><?php echo $sq_transport['vehicle_name']; ?></td>
							<td><?php echo $pickup; ?></td>
							<td><?php echo $drop; ?></td>
						</tr> 
			        <?php } ?>
                </table>
            </div>
	    </div>
		<?php } ?>
        <div class="col-md-6 mg_tp_30">
       	 	<h3 class="editor_title">Inclusions</h3>
			<div class="panel panel-default panel-body">
				<?php echo $sq_pckg['inclusions']; ?>
			</div>
        </div>
        <div class="col-md-6 mg_tp_30">
       	 	<h3 class="editor_title">Exclusions</h3>
			<div class="panel panel-default panel-body">
	       	 	<?php echo $sq_pckg['exclusions']; ?>
			</div>
        </div>
	</div>
</div>