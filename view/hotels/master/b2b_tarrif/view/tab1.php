<div class="panel panel-default panel-body fieldset profile_background">
	<div class="tab-content">
	    <!-- *****TAb1***** start -->
	    <div role="tabpanel" class="tab-pane active" id="basic_information">
	     	<div class="row">
				<div class="col-md-12">
					<div class="profile_box main_block">
						<?php $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_query[city_id]'")); ?>
						<div class="row">
							<div class="col-md-6" style="border-right: 1px solid #ddd">
								<span class="main_block">
									<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
									<?php echo "<label>City Name <em>:</em></label> " .$sq_city['city_name']; ?>
								</span>
								<?php $sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$sq_query[hotel_id]'")); ?>
								<span class="main_block">
									<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
									<?php echo "<label>Hotel Name <em>:</em></label> " .$sq_hotel['hotel_name']; ?>
								</span>
								<?php $sq_currency = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id='$sq_query[currency_id]'")); ?>
								<span class="main_block">
									<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
									<?php echo "<label>Currency <em>:</em></label> " .$sq_currency['currency_code']; ?>
								</span>
							</div>
							<div class="col-md-6 right_border_none_sm">
								<!-- <span class="main_block">
									<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
									<?php echo "<label>Taxation <em>:</em></label> ".$row_hotel['taxation_type'].'-'.$row_hotel['service_tax'].'%'; ?>
								</span> -->
								<span class="main_block">
									<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
									<?php echo "<label>Created At <em>:</em></label> ".get_date_user($sq_query['created_at']); ?>
								</span>
							</div>
						</div>
			    </div>
			</div>
	    </div>
		</div>
	    <!-- ********Tab1 End******** --> 
		<?php
		$sq_query = mysql_query("select * from hotel_contracted_tarrif where pricing_id='$pricing_id'");
		?>
				<div role="tabpanel" class="tab-pane active" id="basic_information">
					<div class="row">
						<div class="col-md-12">
							<div class="profile_box main_block">
				<h3 class="editor_title">Hotel Seasonal Tariff Details</h3>
					<div class="table-responsive">
						<table class="table table-bordered no-marg">
						<thead>
							<tr class="table-heading-row">
								<th>S_No.</th>
								<th>Room_Category</th>
								<th>Max_Occupancy</th>
								<th>Valid_From_Date</th>
								<th>Valid_To_Date</th>
								<th>Room_Cost</th>
								<th>Child_With_Bed</th>
								<th>Child_Without_Bed</th>
								<th>Extra_Bed</th>
								<th>Markup(%)</th>
								<th>Markup_Cost</th>
								<th>MealPlan</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$count=1;
						while($row_query = mysql_fetch_assoc($sq_query)){ ?>
							<tr>
							<td><?= $count++ ?></td>
							<td><?= $row_query['room_category'] ?></td>
							<td><?= $row_query['max_occupancy'] ?></td>
							<td><?= get_date_user($row_query['from_date']) ?></td>
							<td><?= get_date_user($row_query['to_date']) ?></td>
							<td><?= $row_query['double_bed'] ?></td>
							<td><?= $row_query['child_with_bed'] ?></td>
							<td><?= $row_query['child_without_bed'] ?></td>
							<td><?= $row_query['extra_bed'] ?></td>
							<td><?= $row_query['markup_per'] ?></td>
							<td><?= $row_query['markup'] ?></td>
							<td><?= $row_query['meal_plan'] ?></td>
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