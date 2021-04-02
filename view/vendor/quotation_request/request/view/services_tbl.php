<br>
<div class="row">
	<div class="col-md-12">
		<div class="profile_box main_block">
        <h3>Excursions</h3>

        	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
			
				<table class="table table-bordered">
					<thead>
						<tr class="table-heading-row">
							<th>S_No.</th>
							<th>Excursion_Name</th>
						</tr>
					</thead>
					<tbody>
			        	<?php 
			        	$services_arr = json_decode($sq_req['service_entries'], true);

			        	$count = 0;
			        	foreach($services_arr as $service){
			        		$count++;
			        		$service_id = $service['value'];
									$sq_service = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$service_id'"));
									$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$sq_service[city_id]'"));
			        		?>
							<tr>
								<td><?= $count ?></td>
								<td><?= $sq_city['city_name'].' : '.$sq_service['excursion_name'] ?></td>
							</tr>
			        		<?php
			        	}
			        	?>
	        		</tbody>
	        	</table>

        	</div> </div> </div>

        </div>
    </div>
</div>
