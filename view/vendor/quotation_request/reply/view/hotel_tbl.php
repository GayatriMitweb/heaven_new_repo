<?php  if($sq_req['quotation_for']=="Hotel"): ?>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="profile_box main_block">
        <h3 class="editor_title">Hotel Details</h3>

        	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
			
				<table class="table table-bordered no-marg">
					<thead>
						<tr class="table-heading-row">
							<th>S_No.</th>
							<th>Hotel</th>
							<th>Check_In</th>
							<th>Check_Out</th>
							<th>Meal_Plan</th>
						</tr>
					</thead>
	        	<?php 
	        	$hotel_entries = $sq_req['hotel_entries'];
				$hotel_entries_arr = json_decode($hotel_entries, true);

				$count = 1;
				foreach(array_chunk($hotel_entries_arr, 4) as $hotel_entries){

					$arr = array();
					foreach($hotel_entries as $hotel_entries1){
						$arr[$hotel_entries1['name']] = $hotel_entries1['value'];
					}

					//$sq_hotel = mysql_fetch_assoc(mysql_query("select hotel_id, hotel_name from hotel_master where hotel_id='$arr[hotel_id]'"));
					if($arr['hotel_id'] != ''){
					?>
						<tr>
							<td><?= $count ?></td>
							<td><?= $arr['hotel_id'] ?></td>
							<td><?= date('d/m/Y', strtotime($arr['checkin_date'])) ?></td>
							<td><?= date('d/m/Y', strtotime($arr['checkout_date'])) ?></td>
							<td><?= $arr['meal_plan'] ?></td>
						</tr>
						<?php
						$count++;
					}

				}
	        	?>
	        	</table>

        	</div> </div> </div>

        </div>
    </div>
</div>
<?php endif; ?>