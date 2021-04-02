	<div class="row">
		<div class="col-xs-12">
    		<div class="profile_box main_block">
    		 <h3 class="editor_title">Trip Details</h3>
	        	<div class="table-responsive">
	            <?php $offset = ""; ?>
	            <table class="table table-bordered no-marg">
	            	<thead>
						<tr class="table-heading-row">
							<th>S_No.</th>
	        				<th>Travel_From</th>
	        				<th>Travel_To</th>
	        				<th>Train_Name</th>
	        				<th>Train_No.</th>
	        				<th>Ticket_Status</th>
	        				<th>Class</th>
	        				<th>Boarding_Point</th>
	        				<th>Departure_Date/Time</th>
	        				<th>Arrival_Date/Time</th>
	    				</tr>
					</thead>
	               	<tbody>
			            <?php
						$count = 0;
						$sq_ticket= mysql_query("select * from train_ticket_master_trip_entries where train_ticket_id='$train_ticket_id'"); 
						while($row_entry = mysql_fetch_assoc($sq_ticket)){
						$count++;
			    		?>
							<tr>
							    <td><?php echo $count; ?></td>
							    <td><?= $row_entry['travel_from'] ?></td>
							    <td><?= $row_entry['travel_to'] ?></td>
							    <td>
							    	<?php echo $row_entry['train_name']; ?>
							    </td>
							    <td>
							    	<?php echo $row_entry['train_no']; ?>
							    </td>
							    <td><?= $row_entry['ticket_status']; ?></td>
								<td><?php echo $row_entry['class']; ?></td>
							  
							    <td>
							    	<?php echo $row_entry['boarding_at']; ?>
							    </td>
							    <td><?php echo get_datetime_user($row_entry['travel_datetime']); ?></td>
							    <td>
							    	<?php echo get_datetime_user($row_entry['arriving_datetime']); ?>
							    </td>
							</tr>  
	               		<?php
	               		}
	               		?>
	             	</tbody>
	            </table>
	    		</div>
	        </div>
	 	</div>
    </div>  
	    
               