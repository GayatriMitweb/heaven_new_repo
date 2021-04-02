<div class="head">
	<div class="tabs active" data-target="tab_1"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Latest Payments</div>
	<div class="tabs" data-target="tab_2"><i class="fa fa-plane"></i>&nbsp;&nbsp;Upcoming Tours</div>
	<div class="tabs" data-target="tab_3"><i class="fa fa-ticket"></i>&nbsp;&nbsp;Latest Bookings</div>
</div>
<div class="body" style="height:270px;">
	
<div class="row tab active" id="tab_1"> <div class="col-md-12"> <div class="table-resposive">

	<table class="table table-bordered table-hover mg_bt_0">
		<thead>
			<tr>
				<th>Tour Name</th>
				<th>Tour Group</th>
				<th>Amount</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 0; 
			$today = date('Y-m-d');
			$sq = mysql_query("select * from payment_master order by date(date) desc limit 5");
			while($row = mysql_fetch_assoc($sq)){
				$tourwise_id = $row['tourwise_traveler_id'];
				$sq_tourwise = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
				$tour_id = $sq_tourwise['tour_id'];
				$tour_group_id = $sq_tourwise['tour_group_id'];

				$sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$tour_id'"));
				$sq_tour_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where tour_id='$tour_id' and group_id='$tour_group_id'"));

				$tour_group = date('d-m-Y', strtotime($sq_tour_group['from_date'])).' to '.date('d-m-Y', strtotime($sq_tour_group['to_date']))
				?>
				<tr>
					<td><?= $sq_tour['tour_name'] ?></td>
					<td><?= $tour_group ?></td>
					<td><?= $row['amount'] ?></td>
					<td><?= date('d-m-Y', strtotime($row['date'])) ?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>		

</div> </div> </div>


<div class="row tab" id="tab_2"> <div class="col-md-12"> <div class="table-resposive">
	
	<table class="table table-bordered table-hover mg_bt_0">
		<thead>
			<tr>
				<th>Tour Name</th>
				<th>Tour Group</th>
				<th>Capacity</th>
				<th>Tour Cost</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$count = 0;
			$today = date('Y-m-d');
			$sq_tours = mysql_query("select * from tour_groups where status!='Cancel' and date(from_date)>'$today' order by date(from_date) asc limit 5");
			while($row = mysql_fetch_assoc($sq_tours)){
				$tour_id = $row['tour_id'];
				$sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$tour_id'"));

				$tour_group = date('d-m-Y', strtotime($row['from_date'])).' to '.date('d-m-Y', strtotime($row['to_date']))
				?>
				<tr>
					<td><?= $sq_tour['tour_name'] ?></td>
					<td><?= $tour_group ?></td>
					<td><?= $row['capacity'] ?></td>
					<td><?= $sq_tour['tour_cost'] ?></td>
				</tr>	
				<?php
			}
			?>
		</tbody>
	</table>

</div> </div> </div>


<div class="row tab" id="tab_3"> <div class="col-md-12"> <div class="table-resposive">

	<table class="table table-bordered table-hover mg_bt_0">
		<thead>
			<th>File No.</th>
			<th>Tour Name</th>
			<th>Mobile No</th>
			<th>Email ID</th>
			<th>Booking Date</th>
		</thead>
		<tbody>
			<?php 
			$today = date('Y-m-d');
			$sq = mysql_query("select * from tourwise_traveler_details where and tour_group_status!='Cancel' and date(form_date)>'$today' limit 5");
			while($row = mysql_fetch_assoc($sq)){
				$tourwise_id = $row['id'];
				$tour_id = $row['tour_id'];
				$sq_personal_info = mysql_fetch_assoc(mysql_query("select * from traveler_personal_info where tourwise_traveler_id='$tourwise_id'"));

				$sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$tour_id'"));
				?>
				<tr>
					<td><?= 'File No-'.$row['id'] ?></td>
					<td><?= $sq_tour['tour_name'] ?></td>
					<td><?= $sq_personal_info['mobile_no'] ?></td>
					<td><?= $sq_personal_info['email_id'] ?></td>
					<td><?= date('d-m-Y', strtotime($row['form_date'])) ?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>


</div> </div> </div>


</div>


<script>
	$('.dash_latest_events .tabs').click(function(){
		var id = $(this).attr('data-target');
		$('.dash_latest_events .tabs').removeClass('active');
		$(this).addClass('active');

		$('.dash_latest_events .tab').removeClass('active');
		$('.dash_latest_events #'+id).addClass('active');
	});
</script>