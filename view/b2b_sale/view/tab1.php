<div class="container-fluid">
<div class="row">
	<div class="col-md-12">
		<div class="profile_box main_block">
			<?php
			$timing_slots = explode(',',$query['timing_slots']);
			$price_total = 0;
			$tax_total = 0;
			$hotel_total = 0;
			if(sizeof($hotel_list_arr)>0){
			?>
			<div class="row no-gutters">
				<legend>Hotel Details</legend>
					<?php
					for($i=0;$i<sizeof($hotel_list_arr);$i++){
					?>
					<div class="col-md-6">
						<?php
						//Applied Tax
						$tax_arr = explode(',',$hotel_list_arr[$i]->service->hotel_arr->tax);
						?>
						<h5 class="serviceTitle"><u><?= stripslashes($hotel_list_arr[$i]->service->hotel_arr->hotel_name) ?></u></h5>
						<div class="row">
							<div class='col-md-6'>Check-In :  <strong><?= date('m-d-Y', strtotime($hotel_list_arr[$i]->service->check_in)); ?></strong></div>
							<div class='col-md-6'>Check-Out : <strong><?= date('m-d-Y', strtotime($hotel_list_arr[$i]->service->check_out)); ?></strong></div>
						</div>
						<?php
						//Room Section
						$tax_amount = 0;
						for($j=0;$j<sizeof($hotel_list_arr[$i]->service->item_arr);$j++){
							$room_types = explode('-',$hotel_list_arr[$i]->service->item_arr[$j]);
							$room_no = $room_types[0];
							$room_cat = $room_types[1];
							$room_cost = $room_types[2];
							$h_currency_id = $room_types[3];
							
							$tax_arr1 = explode('+',$tax_arr[0]);
							for($t=0;$t<sizeof($tax_arr1);$t++){
							  if($tax_arr1[$t]!=''){
								$tax_arr2 = explode(':',$tax_arr1[$t]);
								if($tax_arr2[2] == "Percentage"){
								  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
								}else{
								  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
								}
							  }
							}
							$total_amount = $room_cost + $tax_amount;
							//Convert into default currency
							$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
							$from_currency_rate = $sq_from['currency_rate'];
							$room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
							$tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
							$total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

							$price_total += $room_cost1;
							$tax_total += $tax_amount1;
							$hotel_total += $total_amount1;
							?>
							<div class="row">
								<div class='col-md-6'><u><?= $room_no ?></u></div>
								<div class='col-md-6'><b class="boldText">Total: <?= number_format($total_amount1,2) ?></b></div>
							</div>
							<div class="clearfix"><span><?= $room_cat ?></span></div>
							Amount:  <strong><?= number_format($room_cost1,2) ?></strong>
							&nbsp;&nbsp;Tax: <strong><?= number_format($tax_amount1,2) ?></strong>
						<?php }?>
						<hr/>
					</div>
				<?php
					} ?>
				</div>
			<?php } ?>
			</div>
			<?php
			$trprice_total = 0;
			$trtax_total = 0;
			$transfer_total = 0;
			if(sizeof($transfer_list_arr)>0){
			?>
			<div class="row no-gutters">
				<legend>Transfer Details</legend>
					<?php
					for($i=0;$i<sizeof($transfer_list_arr);$i++){
                        $tax_amount = 0;
						//Applied Tax
						for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
						$tax_arr = explode(',',$transfer_list_arr[$i]->service->service_arr[$j]->taxation);
						$transfer_cost = explode('-',$transfer_list_arr[$i]->service->service_arr[$j]->transfer_cost);
						$room_cost = $transfer_cost[0];
						$h_currency_id = $transfer_cost[1];
						
                        $tax_arr1 = explode('+',$tax_arr[0]);
                        for($t=0;$t<sizeof($tax_arr1);$t++){
							if($tax_arr1[$t]!=''){
								$tax_arr2 = explode(':',$tax_arr1[$t]);
								if($tax_arr2[2] == "Percentage"){
									$tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
								}else{
									$tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
								}
							}
                        }
						$total_amount = $room_cost + $tax_amount;
						//Convert into default currency
						$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
						$from_currency_rate = $sq_from['currency_rate'];
						$room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
						$tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
						$total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

						$trprice_total += $room_cost1;
						$trtax_total += $tax_amount1;
						$transfer_total += $total_amount1;
						
                        //Pickup n drop location
                        $pickup_id = $transfer_list_arr[$i]->service->service_arr[$j]->pickup_from;
                        if($transfer_list_arr[$i]->service->service_arr[$j]->pickup_type == 'city'){
                          $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$pickup_id'"));
                          $pickup = $row['city_name'];
                        }
                        else if($transfer_list_arr[$i]->service->service_arr[$j]->pickup_type == 'hotel'){
                          $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$pickup_id'"));
                          $pickup = $row['hotel_name'];
                        }
                        else{
                          $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$pickup_id'"));
                          $airport_nam = clean($row['airport_name']);
                          $airport_code = clean($row['airport_code']);
                          $pickup = $airport_nam." (".$airport_code.")";
                        }
                        //Drop-off
                        $drop_id = $transfer_list_arr[$i]->service->service_arr[$j]->drop_to;
                        if($transfer_list_arr[$i]->service->service_arr[$j]->drop_type == 'city'){
                          $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$drop_id'"));
                          $drop = $row['city_name'];
                        }
                        else if($transfer_list_arr[$i]->service->service_arr[$j]->drop_type == 'hotel'){
                          $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$drop_id'"));
                          $drop = $row['hotel_name'];
                        }
                        else{
                          $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$drop_id'"));
                          $airport_nam = clean($row['airport_name']);
                          $airport_code = clean($row['airport_code']);
                          $drop = $airport_nam." (".$airport_code.")";
                        }
						?>
						<div class="col-md-6 mg_bt_10">
							<h5 class="serviceTitle"><u><?= $transfer_list_arr[$i]->service->service_arr[$j]->vehicle_name.'('.$transfer_list_arr[$i]->service->service_arr[$j]->vehicle_type.')' ?></u></h5>
							<div class="row">
								<div class='col-md-12 mg_bt_10'>Trip Type :  <strong><?= ucfirst($transfer_list_arr[$i]->service->service_arr[$j]->trip_type) ?></strong></div>
								<div class='col-md-12 mg_bt_10'>No.Of Vehicles :  <strong><?= $transfer_list_arr[$i]->service->service_arr[$j]->no_of_vehicles ?></strong></div>
								<div class='col-md-12 mg_bt_10'>Pickup Location :  <strong><?= $pickup ?></strong></div>
								<div class='col-md-12 mg_bt_10'>Dropoff Location : <strong><?= $drop ?></strong></div>
								<div class='col-md-12 mg_bt_10'>Pickup Date&Time :  <strong><?= date('m-d-Y H:i:s', strtotime($transfer_list_arr[$i]->service->service_arr[$j]->pickup_date));  ?></strong></div>
								<?php 
								if($transfer_list_arr[$i]->service->service_arr[$j]->trip_type == 'roundtrip'){ ?>
									<div class='col-md-12'>Return Date&Time : <strong><?= date('m-d-Y H:i:s', strtotime($transfer_list_arr[$i]->service->service_arr[$j]->return_date)); ?></strong></div>
								<?php } ?>
							</div>
							<div class="row mg_tp_10">
								<div class='col-md-12 mg_bt_10'>
									Amount:  <strong><?= number_format($room_cost1,2) ?></strong>
									&nbsp;&nbsp;Tax: <strong><?= number_format($tax_amount1,2) ?></strong>
									<b class="boldText">Total: <?= number_format($total_amount1,2) ?></b>
								</div>
							</div>
						<hr/>
			 			</div>
					<?php
						}
					} ?>
			</div>
			<?php } ?>
			<?php
			$actprice_total = 0;
			$acttax_total = 0;
			$activity_total = 0;
			if(sizeof($activity_list_arr)>0){
			?>
			<div class="row no-gutters">
				<legend>Activity Details</legend>
				<?php
				for($i=0;$i<sizeof($activity_list_arr);$i++){
					$tax_amount = 0;
					$tax_arr = explode(',',$activity_list_arr[$i]->service->service_arr[0]->taxation);
				?>
				<div class="col-md-6">
					<h5 class="serviceTitle"><u><?= $activity_list_arr[$i]->service->service_arr[0]->act_name ?></u></h5>
					<div class="row">
						<div class='col-md-6'>Check-Date :  <strong><?= date('m-d-Y', strtotime($activity_list_arr[$i]->service->service_arr[0]->checkDate)); ?></strong></div>
						<div class='col-md-6'>Total Guest : <strong><?= $activity_list_arr[$i]->service->service_arr[0]->total_pax ?></strong></div>
					</div>
					<div class="row">
						<div class='col-md-6'>Reporting Time :  <strong><?= $activity_list_arr[$i]->service->service_arr[0]->rep_time ?></strong></div>
						<div class='col-md-6'>Pickup Point : <strong><?= $activity_list_arr[$i]->service->service_arr[0]->pick_point ?></strong></div>
					</div>
					<?php
					$transfer_types = explode('-',$activity_list_arr[$i]->service->service_arr[0]->transfer_type);
					$transfer = $transfer_types[0];
					$room_cost = $transfer_types[1];
					$h_currency_id = $transfer_types[2];
					
					$tax_arr1 = explode('+',$tax_arr[0]);
					for($t=0;$t<sizeof($tax_arr1);$t++){
					  if($tax_arr1[$t]!=''){
						$tax_arr2 = explode(':',$tax_arr1[$t]);
						if($tax_arr2[2] === "Percentage"){
						  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
						}else{
						  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
						}
					  }
					}
					$total_amount = $room_cost + $tax_amount;
					//Convert into default currency
					$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
					$from_currency_rate = $sq_from['currency_rate'];
					$room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
					$tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
					$total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

					$actprice_total += $room_cost1;
					$acttax_total += $tax_amount1;
					$activity_total += $total_amount1;
					?>
					<div class="clearfix">
					Transfer Type:  <strong><u><?= $transfer ?></u></strong></div>
					<div class="clearfix">Timing Slot:  <strong><u><?= ($timing_slots[$i] != '')?$timing_slots[$i] : 'NA' ?></u></strong></div>
					Amount:  <strong><?= number_format($room_cost1,2) ?></strong>
					&nbsp;&nbsp;Tax: <strong><?= number_format($tax_amount1,2) ?></strong>
					&nbsp;&nbsp;<b class="boldText">Total: <?= number_format($total_amount1,2) ?></b>
					<hr/>
				</div>
			   <?php } ?>
			</div>
			<?php } ?>
			<?php
			$toursprice_total = 0;
			$tourstax_total = 0;
			$tours_total = 0;
			if(sizeof($tours_list_arr)>0){
				?>
				<div class="row no-gutters">
					<legend>Combo Tours Details</legend>
					<?php
					for($i=0;$i<sizeof($tours_list_arr);$i++){
					?>
					<div class="col-md-6">
						<h5 class="serviceTitle"><u><?= $tours_list_arr[$i]->service->service_arr[0]->act_name ?></u></h5>
						<div class="row">
							<div class='col-md-12'>Package :  <strong><?= $tours_list_arr[$i]->service->service_arr[0]->package.'('.$tours_list_arr[$i]->service->service_arr[0]->package_code.')' ?></strong></div>
						</div>
						<div class="row">
							<div class='col-md-8'>Travel Date :  <strong><?= date('m-d-Y', strtotime($tours_list_arr[$i]->service->service_arr[0]->travel_date)); ?></strong></div>
							<div class='col-md-4'>Total Stay :  <strong><?= $tours_list_arr[$i]->service->service_arr[0]->nights.'N/'.$tours_list_arr[$i]->service->service_arr[0]->days.'D' ?></strong></div>
						</div>
						<div class="row">
							<div class='col-md-4'>Adult: <strong><?= $tours_list_arr[$i]->service->service_arr[0]->adult?></strong></div>
							<div class='col-md-4'>Child W/O Bed: <strong><?= $tours_list_arr[$i]->service->service_arr[0]->childwo?></strong></div>
							<div class='col-md-4'>Child With Bed: <strong><?= $tours_list_arr[$i]->service->service_arr[0]->childwi?></strong></div>
						</div>
						<div class="row">
							<div class='col-md-4'>Infant: <strong><?= $tours_list_arr[$i]->service->service_arr[0]->infant ?></strong></div>
							<div class='col-md-4'>Extra Bed : <strong><?= $tours_list_arr[$i]->service->service_arr[0]->extra_bed ?></strong></div>
						</div>
						<?php
                        $tax_amount = 0;
						$tax_arr = explode(',',$tours_list_arr[$i]->service->service_arr[0]->taxation);
						$room_cost = $tours_list_arr[$i]->service->service_arr[0]->total_cost;
						$h_currency_id = $tours_list_arr[$i]->service->service_arr[0]->currency_id;
						
                        $tax_arr1 = explode('+',$tax_arr[0]);
                        for($t=0;$t<sizeof($tax_arr1);$t++){
                          if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                              $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                              $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                          }
                        }
						$total_amount = $room_cost + $tax_amount;
						//Convert into default currency
						$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
						$from_currency_rate = $sq_from['currency_rate'];
						$room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
						$tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
						$total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);
	
						$toursprice_total += $room_cost1;
						$tourstax_total += $tax_amount1;
						$tours_total += $total_amount1;
						?>
						Amount:  <strong><?= number_format($room_cost1,2) ?></strong>
						&nbsp;&nbsp;Tax: <strong><?= number_format($tax_amount1,2) ?></strong>
						&nbsp;&nbsp;<b class="boldText">Total: <?= number_format($total_amount1,2) ?></b>
						<hr/>
					</div>
			
			<?php } ?>			
			</div>
			<?php } ?>
		</div>
	</div>
</div>