<?php 
include "../../../../model/model.php";
require_once('../../../../classes/tour_booked_seats.php');

$tour_id = $_POST['tour_id'];
$sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$tour_id'"));
?>
<div class="head">
	<div class="tabs active" data-target="tab_1"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Weekly</div>
	<div class="tabs" data-target="tab_2"><i class="fa fa-plane"></i>&nbsp;&nbsp;Monthly</div>
</div>
<div class="body" style="height:270px;">

	<div class="row tab active" id="tab_1"> <div class="col-md-12"> <div class="table-resposive">

	<table class="table table-bordered table-hover mg_bt_0">
		<thead>
			<tr>
				<th>Group</th>
				<th>File No</th>
				<th>Name</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$sq = mysql_query("select * from tourwise_traveler_details where tour_id='$tour_id' and tour_group_status!='Cancel' and WEEKOFYEAR(form_date)=WEEKOFYEAR(NOW())");
			while($row = mysql_fetch_assoc($sq)){
				$tour_group_id = $row['tour_group_id'];
				$sq_tour_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where tour_id='$tour_id' and group_id='$tour_group_id'"));
				$tour_group = date('d-m-Y', strtotime($sq_tour_group['from_date'])).' to '.date('d-m-Y', strtotime($sq_tour_group['to_date']));

				$traveler_group_id = $row['traveler_group_id'];
				$sq_traveler = mysql_fetch_assoc(mysql_query("select * from travelers_details where traveler_group_id='$traveler_group_id'"));
				?>
				<tr>
					<td><?= $tour_group ?></td>	
					<td><?= 'File No-'.$row['id'] ?></td>
					<td><?= $sq_traveler['first_name'].' '.$sq_traveler['last_name'] ?></td>
					<td><?= date('d-m-Y', strtotime($row['form_date'])) ?></td>
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
				<th>Group</th>
				<th>File No</th>
				<th>Name</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$sq = mysql_query("select * from tourwise_traveler_details where tour_id='$tour_id' and tour_group_status!='Cancel' and YEAR(form_date) = YEAR(NOW()) AND MONTH(form_date)=MONTH(NOW())");
			while($row = mysql_fetch_assoc($sq)){
				$tour_group_id = $row['tour_group_id'];
				$sq_tour_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where tour_id='$tour_id' and group_id='$tour_group_id'"));
				$tour_group = date('d-m-Y', strtotime($sq_tour_group['from_date'])).' to '.date('d-m-Y', strtotime($sq_tour_group['to_date']));

				$traveler_group_id = $row['traveler_group_id'];
				$sq_traveler = mysql_fetch_assoc(mysql_query("select * from travelers_details where traveler_group_id='$traveler_group_id'"));
				?>
				<tr>
					<td><?= $tour_group ?></td>	
					<td><?= 'File No-'.$row['id'] ?></td>
					<td><?= $sq_traveler['first_name'].' '.$sq_traveler['last_name'] ?></td>
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
	$('.booking_weekly_monthly_report .tabs').click(function(){
		var id = $(this).attr('data-target');
		$('.booking_weekly_monthly_report .tabs').removeClass('active');
		$(this).addClass('active');

		$('.booking_weekly_monthly_report .tab').removeClass('active');
		$('.booking_weekly_monthly_report #'+id).addClass('active');
	});
</script>