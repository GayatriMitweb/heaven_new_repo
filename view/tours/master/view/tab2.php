<!-- Train  -->
<?php 
$sq_t_count = mysql_num_rows(mysql_query("Select * from group_train_entries where tour_id = '$tour_id'"));
if($sq_t_count != '0'){
?>
<div class="row">
	<div class="col-md-12">
	        <h3 class="editor_title">Train Details</h3>
             <div class="table-responsive">
		        <table class="table no-marg table-bordered">
		            <thead>
		                <tr class="table-heading-row">
							<th>S_No.</th>
	         				<th>From_Location</th>
					        <th>To_Location</th>
					        <th>Class</th>
					    </tr>
					</thead>
					<tbody>
						<?php 
							$count = 1; 
							$query1 = "Select * from group_train_entries where tour_id = '$tour_id'";
							$sq_tourgrp1 = mysql_query($query1);
							while($sq_tourgrp2 = mysql_fetch_assoc($sq_tourgrp1)) 
							{						  
							?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $sq_tourgrp2['from_location']; ?></td>
							<td><?php echo $sq_tourgrp2['to_location']; ?></td>
							<td><?php echo $sq_tourgrp2['class']; ?></td>						
						</tr>
						<?php } ?>
					</tbody>
				</table>
				
    	 	</div>
	</div>
</div>
<?php } ?>

<!-- Flight -->
<?php 
$sq_f_count = mysql_num_rows(mysql_query("Select * from group_tour_plane_entries where tour_id = '$tour_id'"));
if($sq_f_count != '0'){
?>
<div class="row">
	<div class="col-md-12 mg_tp_30">
	        <h3 class="editor_title">Flight Details</h3>
             <div class="table-responsive">
		        <table class="table no-marg table-bordered">
		            <thead>
		                <tr class="table-heading-row">
							<th>S_No.</th>
							<th>From_City</th>
	         				<th>Sector_From</th>
	         				<th>To_City</th>
					        <th>Sector_To</th>
					        <th>Airline_Name</th>
					        <th>Class</th>
					    </tr>
					</thead>
					<tbody>
						<?php 
							$count = 1; 
							$query = "Select * from group_tour_plane_entries where tour_id = '$tour_id'";
							$sq_tourgrp1 = mysql_query($query);
							while($sq_tourgrp = mysql_fetch_assoc($sq_tourgrp1)) {
								$sq_airline = mysql_fetch_assoc(mysql_query("select * from airline_master where airline_id='$sq_tourgrp[airline_name]'"));
								$sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_tourgrp[from_city]'"));
					            $sq_city1 = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_tourgrp[to_city]'"));
							?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $sq_city['city_name']; ?></td>
							<td><?php echo $sq_tourgrp['from_location']; ?></td>
							<td><?php echo $sq_city1['city_name']; ?></td>
							<td><?php echo $sq_tourgrp['to_location']; ?></td>
							<td><?php echo $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')'; ?></td>
							<td><?php echo $sq_tourgrp['class']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				
    	 	</div>
	</div>
</div>
<?php } ?>

<!-- Cruise -->
<?php 
$sq_c_count = mysql_num_rows(mysql_query("Select * from group_cruise_entries where tour_id = '$tour_id'"));
if($sq_c_count != '0'){
?>
<div class="row">
	<div class="col-md-12 mg_tp_30">
	        <h3 class="editor_title">Cruise Details</h3>
             <div class="table-responsive">
		        <table class="table no-marg table-bordered">
		            <thead>
		                <tr class="table-heading-row">
							<th>S_No.</th>
					        <th>Route</th>
					        <th>Cabin</th>
					    </tr>
					</thead>
					<tbody>
						<?php 
							$count = 1; 
							$query = "select * from group_cruise_entries where tour_id = '$tour_id'";
							$sq_tourgrp_c1 = mysql_query($query);
							while($sq_tourgrp_c = mysql_fetch_assoc($sq_tourgrp_c1)) {
						  
							?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $sq_tourgrp_c['route']; ?></td>
							<td><?php echo $sq_tourgrp_c['cabin']; ?></td>
						</tr>
						<?php 
						} ?>
					</tbody>
				</table>
				
    	 	</div>
	</div>
</div>
<?php } ?>