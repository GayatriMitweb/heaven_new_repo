<div class="head">Upcoming Tours</div>
<div class="body" style="height:270px;">
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
		
		<table class="table table-bordered table-hover">
			<thead>
				<th>Tour Name</th>
				<th>Tour Date</th>
				<th>File Number</th>
				<th>Mobile No</th>
			</thead>
			<tbody>
				<?php
				$today = date('Y-m-d');
				$sq_package_tours = mysql_query("select * from package_tour_booking_master where MONTH(tour_from_date)=MONTH(NOW()) and day(tour_from_date)>DAYOFMONTH('$today')");
				while($row_package_tours = mysql_fetch_assoc($sq_package_tours)){
					?>
					<tr>
						<td><?= $row_package_tours['tour_name'] ?></td>
						<td><?= date('d-m-Y', strtotime($row_package_tours['tour_from_date'])) ?></td>
						<td><?= 'File No-'.$row_package_tours['booking_id'] ?></td>
						<td><?= $row_package_tours['mobile_no'] ?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>

	</div> </div> </div>
</div>