<h3 class="editor_title">Tour Details</h3>
<div class="panel panel-default panel-body app_panel_style">
	<div class="row">

		<div class="col-md-12">

			<div class="profile_box main_block">

	        	 	 <?php

	        	 	  $sq_tours = mysql_fetch_assoc(mysql_query($query));

	        	 	 ?>

	        	 	<div class="row">

	        	 	<div class="col-md-6 right_border_none_sm" style="border-right: 1px solid #ddd;">

		        		<span class="main_block">

			                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

			                  <?php echo "<label>Tour Type <em>:</em></label> ".$sq_tours['tour_type']; ?>

			            </span>
						<span class="main_block">
							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
							<?php echo "<label>Status <em>:</em></label> ".$sq_tours['active_flag']; ?>
						</span>

			        </div>

	        	 	<div class="col-md-6">      
						<span class="main_block">
							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
							<?php echo "<label>Tour Name <em>:</em></label> ".$sq_tours['tour_name']; ?>
						</span>	           
			           
			            <?php

		                if($sq_tours['pdf_url']!=""){

		                	  $image = $sq_tours['pdf_url']; 
                    		  $newUrl = preg_replace('/(\/+)/','/',$image);
                    		  $newUrl = explode('uploads', $newUrl);
                    		  $newUrl1 = BASE_URL.'uploads'.$newUrl[1];

		                ?>	

		                <span class="main_block">

		                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

		                  <?php echo "<label>Itinerary <em>:</em></label> "?><a href="<?php echo $newUrl1; ?>" download title="View Itinerary"><i class="fa fa-id-card-o"></i></a> 

		                </span>

		                <?php }

		                ?>
			        </div>

			        </div>

			             

			    </div> 

		</div>

	</div>
</div>


<div class="row">

	<div class="col-md-12 mg_tp_10">

        <h3 class="editor_title">Itinerary Details</h3>

         <div class="table-responsive no-marg">

	        <table class="table no-marg table-bordered" >

	            <thead>

	                <tr class="table-heading-row">

						<th>S_No.</th>

         				<th>Special_Attraction</th>

				        <th>Day_wise_Program</th>

				        <th>Overnight_Stay</th>
				        <th>MEAL_PLAN</th>
				    </tr>

				</thead>

				<tbody>

					<?php 

						$count = 1; 

						 $query1 = "select * from group_tour_program where tour_id = '$tour_id'";

          				$sq_pckg_a = mysql_query($query1);

						while($row_pckg = mysql_fetch_assoc($sq_pckg_a)) {

						?>

					<tr>

						<td><?php echo $count++; ?></td>

						<td style="width:300px;"><?php echo $row_pckg['attraction']; ?></td>

						<td style="width:500px;"><pre class="real_text"><?php echo $row_pckg['day_wise_program']; ?></pre></td>

						<td style="width:300px;"><?php echo $row_pckg['stay']; ?></td>
						<td style="width:300px;"><?php echo $row_pckg['meal_plan']; ?></td>

					</tr>

					<?php } ?>

				</tbody>

			</table>
			
	 	</div>

	</div>

</div>

<div class="row">

	<div class="col-md-12 mg_tp_30">

	        <h3 class="editor_title">Dates & Capacity</h3>

             <div class="table-responsive no-marg">

		        <table class="table no-marg table-bordered">

		            <thead>

		                <tr class="table-heading-row">

							<th>S_No.</th>

	         				<th>From_Date</th>

					        <th>To_Date</th>

					        <th>Seat_Capacity</th>

					    </tr>

					</thead>

					<tbody>

						<?php 

							$count = 1; 

							$query = "Select * from tour_groups where tour_id = '$tour_id'";

							$sq_tourgrp1 = mysql_query($query);

							while($sq_tourgrp = mysql_fetch_assoc($sq_tourgrp1)) {

							?>

						<tr>

							<td><?php echo $count++; ?></td>

							<td><?php echo date('d/m/Y', strtotime($sq_tourgrp['from_date'])); ?></td>

							<td><?php echo date('d/m/Y', strtotime($sq_tourgrp['to_date'])); ?></td>

							<td><?php echo $sq_tourgrp['capacity']; ?></td>

						</tr>

						<?php } ?>

					</tbody>

				</table>

    	 	</div>

	</div>

</div>

<!-- -->