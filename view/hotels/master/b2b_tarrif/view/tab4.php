<?php
$sq_query = mysql_query("select * from hotel_weekend_tarrif where pricing_id='$pricing_id'");
?>
<div class="panel panel-default panel-body fieldset profile_background">
	<div class="tab-content">
	    <div role="tabpanel" class="tab-pane active" id="basic_information">
	     	<div class="row">
				<div class="col-md-12">
					<div class="profile_box main_block">
          <h3 class="editor_title">Hotel Weekend Rates</h3>
            <div class="table-responsive">
                <table class="table table-bordered no-marg">
                  <thead>
                      <tr class="table-heading-row">
                        <th>S_No.</th>
                        <th>Room_Category</th>
                        <th>Max_Occupancy</th>
                        <th>Weekend_Day</th>
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
                      <td><?= $row_query['day'] ?></td>
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
