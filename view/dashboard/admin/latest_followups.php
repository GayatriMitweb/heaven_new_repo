<div class="head"><i class="fa fa-calendar-o"></i>&nbsp;&nbsp;Latest Followups</div>
<div class="body" style="height:270px;">
	
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">

	<table class="table table-bordered table-hover mg_bt_0">
		<thead>
			<th>Name</th>
			<th>Followup DateTime</th>
			<th>Mobile No</th>
			<th>Email ID</th>
		</thead>
		<tbody>
			<?php 
			$today = date('Y-m-d');
			$sq = mysql_query("select * from enquiry_master where date(followup_date)>'$today' or enquiry_id in ( select enquiry_id from enquiry_master_entries where followup_status='Followup' and date(followup_date)>'$today' ) order by date(followup_date) limit 30");
			while($row = mysql_fetch_assoc($sq)){
				?>
				<tr>
					<td><?= $row['name'] ?></td>
					<td><?= date('d-m-Y', strtotime($row['followup_date'])) ?></td>
					<td><?= $row['mobile_no'] ?></td>
					<td><?= $row['email_id'] ?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>

	</div> </div> </div>

</div>